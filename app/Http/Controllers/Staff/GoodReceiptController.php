<?php

namespace App\Http\Controllers\Staff;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\GoodsReceiptRequest;
use App\Models\Inbound\GoodsReceipt;
use App\Models\Inbound\InboundDetail;
use App\Models\Inbound\PurchaseOrder;
use App\Models\Inbound\PurchaseOrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodReceiptController extends Controller
{
    
    public function index(Request $request){

        $perPage = config('app.item_per_page');
        $sortBy = $request->get('sort_by');
        $sortOrder = $request->get('sort_order');
        $allowedSort = ['goods_receipt_no', 'purchase_order_id', 'status', 'created_at', 'updated_at']; // tùy chỉnh theo cột bạn muốn cho sort
        $isSorted = false;

        $keyword = $request->get('keyword', '');
        $searchColumn = $request->get('search_column', 'goods_receipt_no');

        $columns = [
            'stt'=>'STT',
            'goods_receipt_no'=>'Số phiếu nhập',
            'purchase_order_id'=>'Đơn đặt hàng',
            'total_quantity'=>'Số lượng',
            'status'=>'Trạng thái',
            'updated_at'=>'Ngày cập nhật',
            'action'=>'Chức năng',
        ];
          
        if (in_array($sortBy, $allowedSort) && in_array($sortOrder, ['asc', 'desc'])) {
            $isSorted = true;
        } else {
            $sortBy = null;
            $sortOrder = null;
        }

        // Lấy dữ liệu
        $goodsReceiptQuery = GoodsReceipt::with('product', 'purchaseOrder.purchaseOrderDetail')
            ->when($keyword && $searchColumn, function ($query) use ($keyword, $searchColumn) {
                // Nếu cần tìm theo cột quan hệ thì xử lý đặc biệt, ví dụ như purchaseOrder số đơn hàng
                if ($searchColumn === 'purchase_order_id') {
                    $query->whereHas('purchaseOrder', function ($q) use ($keyword) {
                        $q->where('purchase_order_id', 'like', "%$keyword%");
                    });
                } else {
                    // Tìm trên cột thường
                    $query->where($searchColumn, 'like', "%$keyword%");
                }
            });

        // Nếu sortBy có, sắp xếp theo đó, nếu không thì mặc định theo created_at desc
        if ($sortBy) {
            $goodsReceiptQuery->orderBy($sortBy, $sortOrder);
        } else {
            $goodsReceiptQuery->orderByDesc('created_at');
        }

        // Lấy tất cả dữ liệu trước để group và tính tổng số lượng
        $allGoodsReceipts = $goodsReceiptQuery->get();

        $grouped = $allGoodsReceipts
            ->groupBy(function ($item) {
                return $item->goods_receipt_no . '_' . $item->purchase_order_id . '_' . $item->status;
            })
            ->map(function ($group) {
                $first = $group->first();
                $first->total_quantity = $group->sum('quantity');
                return $first;
            })
            ->values();

        // Phân trang thủ công cho collection đã group
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $pagedData = $grouped->slice($offset, $perPage)->values();

        $groupedReceipts = new LengthAwarePaginator(
            $pagedData,
            $grouped->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('staff.goods_receipt.list',compact('groupedReceipts','sortBy','sortOrder','isSorted','keyword','columns','searchColumn'));
    }

    public function checkPO(Request $request){

        $POID = $request->all()['purchase_order'];
        $PO = PurchaseOrder::where('purchase_order_id',$POID)->first();

        if (!$PO) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng này.'
            ]);
        }

        else if ($PO->status == 'Hủy' || $PO->status == 'Hoàn thành' ) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng này đã đóng, vui lòng chọn đơn hàng khác.']);
        }

        else{
            return response()->json(['success' => true,
            'message' => $POID
        ]);
        }
    }

    public function create (Request $request){
        $purchaseOrderID = $request -> PO;
        $purchaseOrder = PurchaseOrder::where('purchase_order_id',$purchaseOrderID)->first();
        $goodReceipts = GoodsReceipt::with('product')->where('purchase_order_id',$purchaseOrderID)->where('status','!=','Hủy')->get();
        $poDetail = PurchaseOrderDetail::where('purchase_order_id',$purchaseOrderID)->get();


        // Xử lý data
        $createdQuantity = $goodReceipts->groupBy('product_id')->map(function ($receipts){
            return $receipts->sum('quantity');
        });

        $poWithBalance = $poDetail -> map(function($item) use ($createdQuantity){
            $createdQty = $createdQuantity[$item->product_id] ?? 0;
            $remainingQty = $item -> qty_ordered - $createdQty;

            return[
                            
                'product_id' => $item-> product_id,
                'sku' => $item->product-> sku,
                'product_name'=> $item->product-> name,
                'quantity_ordered' => $item-> qty_ordered,
                'quantity_created' => $createdQty,
                'quantity_remaining' => max($remainingQty, 0 ),
                'unit' =>  $item->product->unit,
            ];
        });
        return view('staff.goods_receipt.create',compact('purchaseOrder','poWithBalance'));
    }

    public function store (GoodsReceiptRequest $request){

        $data = $request->validated();
        $purchaseOrderID = $data['PO'];
        $products = collect($data['products'])->where('quantity','>',0);

        //Tạo mã phiếu nhập theo PO
        $existingReceipts = GoodsReceipt::where('goods_receipt_no', 'like', $purchaseOrderID . '_%')->get();
        $times = $existingReceipts->map(function($item) use($purchaseOrderID){
            $suffix = str_replace($purchaseOrderID . '_', '', $item->goods_receipt_no);
            return is_numeric($suffix) ? (int)$suffix : 0;
        });

        $maxTimes = $times->max() ?? 0;
        $goodReceiptNo = $purchaseOrderID . '_' . ($maxTimes + 1);

        $goodsReceipt = [];

        foreach ($products as $index => $product) {
            $goodsReceipt[] =[
                'goods_receipt_no' => $goodReceiptNo,
                'purchase_order_id' => $purchaseOrderID,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'], 
                'status' =>'Mới',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        GoodsReceipt::insert($goodsReceipt);
        PurchaseOrder::where('purchase_order_id',$purchaseOrderID)->update(['status'=>'Đang nhập']);
        return redirect()->route('purchase_order.list')->with('success','Bạn đã tạo thành công phiếu nhập cho PO:'.$purchaseOrderID);
    }

    public function detail(Request $request){
        $goods_receipt_no = $request->goods_receipt_no;
        $goods_receipt_item = GoodsReceipt::with('product')->where('goods_receipt_no', $goods_receipt_no)->get();
        return view('staff.goods_receipt.detail',compact('goods_receipt_item'));
    }

    public function cancel(Request $request){
     
        $goodReceiptNo = $request->goods_receipt_no;
        $status = $request->status;
       

        if( in_array($status,['Mới'])){
            GoodsReceipt::where('goods_receipt_no',$goodReceiptNo)->update([
                    'status'=>'Hủy' 
                ]);
            return redirect()->route('goods_receipt.list')->with('success', 'Bạn đã hủy phiếu nhập hàng.');
        }
        return redirect()->route('goods_receipt.list')->with('error', 'Không thể huỷ phiếu nhập này này.');
    }

    public function handleReceive(Request $request){
        $goods_receipt_no = $request->goods_receipt_no;
        $PO = substr($goods_receipt_no,0,strpos($goods_receipt_no, '_'));
       
        $ActualReceived = GoodsReceipt::where('goods_receipt_no', $goods_receipt_no)->get();
        $productIds = $ActualReceived->pluck('product_id')->unique()->toArray();
        $productsInfo = Product::whereIn('id', $productIds)->get()->keyBy('id');
        GoodsReceipt::where('goods_receipt_no',$goods_receipt_no)->update(['status'=>'Hoàn thành']);

        //Cập nhật số lượng trong PO_Detail (quét toàn bộ các phiếu nhập để cập nhật)
        $received = GoodsReceipt::select('goods_receipt.purchase_order_id','qty_ordered','goods_receipt.product_id',DB::raw('SUM(quantity) as total_received'))
        ->join('purchase_order_detail',function($join){
            $join->on('goods_receipt.purchase_order_id', '=', 'purchase_order_detail.purchase_order_id')
                    ->on('goods_receipt.product_id', '=', 'purchase_order_detail.product_id');
         }) 
        ->where('goods_receipt.purchase_order_id',$PO)
        ->where('status','Hoàn thành')
        ->groupBy('purchase_order_id','product_id','qty_ordered')
        ->get();

        $updatesPODetail = $received -> map(function($item) use ($PO) {
            return [
                'purchase_order_id' => "$PO",
                'product_id' => $item->product_id,
                'qty_received' => $item->total_received,
                'qty_pending' =>  $item->qty_ordered - $item->total_received,
                'qty_ordered' =>  $item->qty_ordered
            ];
        })->toArray();

        // dd($PO, $updatesPODetail);
        PurchaseOrderDetail::upsert(
            $updatesPODetail,
            ['purchase_order_id','product_id'],
            ['qty_received','qty_pending']
        );

        //Cập nhật trạng thái cho PO
        $poPending = PurchaseOrderDetail::where('purchase_order_id',$PO)
        -> where('qty_pending','>',0)
        -> exists();
        PurchaseOrder::where('purchase_order_id',$PO)
            ->update([
                'status' => $poPending ? 'Đang nhập': 'Hoàn thành'
            ]);
        //Cập nhật lịch sử nhập hàng
        $supplierID = PurchaseOrder::where('purchase_order_id',$PO)->value('supplier_id');
        $historyInsert =  $ActualReceived->map(function ($item) use ($supplierID){
            return [
                'purchase_order_id' => $item['purchase_order_id'],
                'goods_receipt_no' => $item['goods_receipt_no'],
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'supplier_id' => $supplierID,
                'status' => $item['status'],
                'qty_received' => $item['quantity'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        })->toArray();
        DB::table('inbound_detail')->insert($historyInsert);

        //Cập nhật tôn kho

        $existingInventory = DB::table('inventory')
        ->whereIn('product_id', $productIds)
        ->get()
        ->keyBy('product_id'); // Để dễ tra nhanh

        $insertList = [];
        $updateList = [];
  
        foreach ($ActualReceived as $item) {
            $productId = $item['product_id'];
            $receivedQty = $item['quantity'];
            $product = $productsInfo[$productId];
            if ($existingInventory->has($productId)) {
                // Nếu đã có tồn kho → cộng dồn
                $updateList[] = [
                    'product_id' => $productId,
                    'quantity' => $existingInventory[$productId]->quantity + $receivedQty,
                    'updated_at' => now()
                ];
            } else {
                // Nếu chưa có tồn kho → tạo mới
                $insertList[] = [
                    'product_id' => $productId,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'unit' => $product->unit,
                    'quantity' => $receivedQty,
                    'status' => 'Hàng tốt',
                    'product_type' => $product->product_type,
                    'received_at' => now(),
                    'manufacture_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
         }}
        // Thực hiện insert và update chỉ 2 truy vấn
        if (!empty($insertList)) {
            DB::table('inventory')->insert($insertList);
        }

        if (!empty($updateList)) {
            foreach ($updateList as $row) {
                DB::table('inventory')
                    ->where('product_id', $row['product_id'])
                    ->update([
                        'quantity' => $row['quantity'],
                        'updated_at' => $row['updated_at']
                    ]);
        }}
        return redirect()->back()->with('success','Đã nhập hàng thành công');
    }

    public function showInboundDetail(Request $request){

        //ĐAng viết tiếp......
        // $sortBy = $request->get('sort_by');
        // $sortOrder = $request->get('sort_order');
        // $allowedSort = ['goods_receipt_no', 'purchase_order_id', 'status', 'created_at', 'updated_at']; 
        // $isSorted = false;

        // $keyword = $request->get('keyword', '');
        // $searchColumn = $request->get('search_column', 'purchase_order_id');

        // $columns = [
        //    'name'=>'STT',
        //    'purchase_order_id'=>'Đơn đặt hàng',
        //    'goods_receipt_no'=>'Mã phiếu nhập',
        //    'supplier.name'=>'Nhà cung cấp',
        //    'product.sku'=>'Mã sản phẩm',
        //    'product.name'=>'Tên sản phẩm',
        //    'quantity'=>'Số lượng',
        //    'product.unit'=>'Đơn vị tính',
        //    'created_at'=>'Ngày nhập',
        // ];
          
        // if (in_array($sortBy, $allowedSort) && in_array($sortOrder, ['asc', 'desc'])) {
        //     $isSorted = true;
        // } else {
        //     $sortBy = null;
        //     $sortOrder = null;
        // }

        // // Lấy dữ liệu
        // $goodsInbounDetailQuery = InboundDetail::with('product', 'supplier')
        //     ->when($keyword && $searchColumn, function ($query) use ($keyword, $searchColumn) {
        //         // Nếu cần tìm theo cột quan hệ thì xử lý đặc biệt, ví dụ như purchaseOrder số đơn hàng

        //         switch ($searchColumn) {
        //             case 'supplier.name':
                        

        //                 break;
        //             case 'supplier.name':
                       
        //                 break;    
        //             case 'supplier.name':
                       
        //                 break;        
        //             default:
        //                 # code...
        //                 break;
        //         }
        //         if ($searchColumn === 'purchase_order_id') {
        //             $query->whereHas('purchaseOrder', function ($q) use ($keyword) {
        //                 $q->where('purchase_order_id', 'like', "%$keyword%");
        //             });
        //         } else {
        //             // Tìm trên cột thường
        //             $query->where($searchColumn, 'like', "%$keyword%");
        //         }
        //     });

        // // Nếu sortBy có, sắp xếp theo đó, nếu không thì mặc định theo created_at desc
        // if ($sortBy) {
        //     $goodsReceiptQuery->orderBy($sortBy, $sortOrder);
        // } else {
        //     $goodsReceiptQuery->orderByDesc('created_at');
        // }

        // // Lấy tất cả dữ liệu trước để group và tính tổng số lượng
        // $allGoodsReceipts = $goodsReceiptQuery->get();

        // $grouped = $allGoodsReceipts
        //     ->groupBy(function ($item) {
        //         return $item->goods_receipt_no . '_' . $item->purchase_order_id . '_' . $item->status;
        //     })
        //     ->map(function ($group) {
        //         $first = $group->first();
        //         $first->total_quantity = $group->sum('quantity');
        //         return $first;
        //     })
        //     ->values();

        // // Phân trang thủ công cho collection đã group
        // $page = $request->get('page', 1);
        // $perPage = 10;
        // $offset = ($page - 1) * $perPage;
        // $pagedData = $grouped->slice($offset, $perPage)->values();

        // $groupedReceipts = new LengthAwarePaginator(
        //     $pagedData,
        //     $grouped->count(),
        //     $perPage,
        //     $page,
        //     ['path' => $request->url(), 'query' => $request->query()]
        // );

        // return view('staff.goods_receipt.list',compact('groupedReceipts','sortBy','sortOrder','isSorted','keyword','columns','searchColumn'));

        $perPage = config('app.item_per_page');
        $inboudDetails = InboundDetail::with('supplier')->paginate($perPage);
        return view('staff.goods_receipt.inbound_detail',compact('inboudDetails'));
    }

}