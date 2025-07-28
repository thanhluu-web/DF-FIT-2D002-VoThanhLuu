<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

use App\Http\Requests\PurchaseOrderRequest;
use App\Models\Inbound\PurchaseOrder;
use App\Models\Inbound\PurchaseOrderDetail;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index(Request $request){   
        $perPage = config('app.item_per_page');
        $sortBy = $request->get('sort_by');
        $sortOrder = $request->get('sort_order');
        $allowedSort = ['purchase_order_id','supplier','created_at','status','created_at'];
        $isSorted = false;

        $keyword = $request->get('keyword','');
        $searchColumn = $request->get('search_column','purchase_order_id');

        $columns = [
            'stt'=> 'STT',
            'purchase_order_id'=> 'Đơn đặt hàng',
            'supplier.name' => 'Nhà cung cấp',
            'created_at'=> 'Ngày đặt hàng',
            'status'=> 'Trạng thái',
            'updated_at'=> 'Ngày cập nhật',
            'action'=> 'Chức năng',
        ];
        
        if (in_array($sortBy, $allowedSort) && in_array($sortOrder, ['asc', 'desc'])) {
            $isSorted = true;
        } else {
            $sortBy = null;
            $sortOrder = null;
        }

        $purchase_orders = PurchaseOrder::with('supplier')
        ->when($keyword && $searchColumn, function ($query) use ($keyword, $searchColumn) {
            if ($searchColumn === 'supplier.name') {
                $query->whereHas('supplier', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            } else {
                $query->where($searchColumn, 'like', "%$keyword%");
            }
        })
        ->orderBy($sortBy ?? 'created_at', $sortOrder ?? 'desc')
        ->paginate($perPage)
        ->appends([
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'keyword' => $keyword,
            'searchColumn' => $searchColumn,
        ]);

        return view('staff.purchase_order.list',compact('purchase_orders','sortBy','sortOrder','isSorted','keyword','columns','searchColumn'));
    }

    public function create(){
        return view ('staff.purchase_order.create');
    }

    public function store(PurchaseOrderRequest $request){
        try{
            $data = $request->validated();
                // Chuyển ngày về định dạng chuẩn Y-m-d để lưu
            $orderDate = Carbon::createFromFormat('d/m/Y', $data['order_date'])->format('Y-m-d');
            $deliveryDate = Carbon::createFromFormat('d/m/Y', $data['delivery_date'])->format('Y-m-d');
            $purchaseOrderId = 'PO' . fake()->unique()->numerify('#####');
            $supplierID = $data['supplier_id'] ?? Supplier::where('name',$data['supplier_name'])->first()->id;

            PurchaseOrder::create([
                    'purchase_order_id' => $purchaseOrderId,
                    'supplier_id' => $supplierID,
                    'order_date' => $orderDate,
                    'delivery_date' => $deliveryDate,
                    'status' => 'Mới',
            ]);
            foreach ($data['products'] as $product) {
                $qtyOrdered = (int) $product['quantity'];
                $qtyReceived = 0;
                $qtyOrdered = (int) $product['quantity'];
                $qtyReceived = 0;
                $productID = Product::where('sku',$product['product_id'])->first()->id;

                PurchaseOrderDetail::create([
                    'purchase_order_id' => $purchaseOrderId,
                    'product_id' => $productID,
                    'qty_ordered' => $qtyOrdered,
                    'qty_received' => $qtyReceived,
                    'qty_pending' => $qtyOrdered - $qtyReceived,
                 ]);
            }
          
            return redirect()->route('purchase_order.list')->with('success', "Tạo đơn đặt hàng thành công: $purchaseOrderId");
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Lỗi khi tạo đơn đặt hàng: ' . $e->getMessage());
            }
   
    }

    public function detail(PurchaseOrder $purchaseOrder){
        $status = $purchaseOrder->status;
        $purchaseOrderDetails = PurchaseOrderDetail::with('product')->where('purchase_order_id',$purchaseOrder->purchase_order_id)->paginate(10);
        return view('staff.purchase_order.detail',compact('purchaseOrderDetails','status'));
    }

    public function cancel(PurchaseOrder $purchaseOrder){
     
        $purchaseOrderID = $purchaseOrder->purchase_order_id;

        if( in_array($purchaseOrder->status,['Mới'])){
            $purchaseOrder->status = 'Hủy';
            $purchaseOrder->save();

            PurchaseOrderDetail::where('purchase_order_id',$purchaseOrderID)->update([
                'qty_ordered'=> 0,
                'qty_received'=> 0,
                'qty_pending'=> 0,
            ]);

            return redirect()->route('purchase_order.list')->with('success', 'Bạn đã hủy đơn hàng.');
        }
        return redirect()->route('purchase_order.list')->with('error', 'Không thể huỷ đơn hàng này.');
    }

    public function checkProductName (Request $request) {
        $code = $request->input('code');
        $product = Product::where('sku', $code)->first();
        if ($product) {
            return response()->json(['name' => $product->name,'unit' => $product->unit]);
        } else {
            return response()->json(['name' => null]);
        }
    }   

    public function searchSupplier(Request $request){
        $q = $request->input('q');
        $suppliers = Supplier::where('name', 'like', "%$q%")
                        ->limit(10)
                        ->get(['id', 'name']);
        return response()->json($suppliers);
    }   



}
