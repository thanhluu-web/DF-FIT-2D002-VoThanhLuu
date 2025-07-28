<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $perPage = config('app.item_per_page');
        $sortBy = $request->get('sort_by');
        $sortOrder = $request->get('sort_order');

        $keyword = $request->get('keyword','');
        $columns = [
            'stt' =>'STT',
            'sku' => 'Mã sản phẩm',
            'name' =>  'Tên sản phẩm',
            'quantity'=> 'Số lượng',
            'unit' => 'Đơn vị tính',
            'manufacture_date' => 'Ngày sản xuất',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày nhập',
            'updated_at' => 'Ngày cập nhật',
            'action' => 'Chức năng',
        ];

        $searchColumn = $request->get('search_column','name');

        $allowedSort = ['name','sku','unit','manufacture_date','status','created_at','updated_at',''];
        $isSorted = false;
        
        if (in_array($sortBy, $allowedSort) && in_array($sortOrder, ['asc', 'desc'])) {
            $isSorted = true;
        } else {
            $sortBy = null;
            $sortOrder = null;
        }

        $inventories = Inventory::where($searchColumn ,'LIKE', "%$keyword%")->orderBy($sortBy ?? 'created_at',$sortOrder ?? 'desc')->paginate($perPage)->appends([
        'sort_by'=>$sortBy,
        'sort_order'=>$sortOrder
        ]);
    
        return view('admin.pages.inventory-management.inventory-list',compact('inventories','sortBy','sortOrder','isSorted','keyword','columns','searchColumn'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'inventory_id' => 'required|exists:inventory,id',
            'status' => 'required|string|max:255',
        ]);

        Inventory::where('id', $request->inventory_id)
            ->update(['status' => $request->status]);

        return redirect()->route('inventory.list')->with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
