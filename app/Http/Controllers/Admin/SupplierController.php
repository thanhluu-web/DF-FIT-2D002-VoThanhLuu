<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $perPage = config('app.item_per_page');
        $sortBy = $request->get('sort_by');
        $sortOrder = $request->get('sort_order');
        $allowedSort = ['name','phone','address','status','created_at',''];
        $isSorted = false;

        $keyword = $request->get('keyword','');
        $searchColumn = $request->get('search_column','name');

        $columns = [
            'stt' => 'STT',
            'name' => 'Tên Nhà cung cấp',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'action' => 'chức năng',
        ];
        
        if (in_array($sortBy, $allowedSort) && in_array($sortOrder, ['asc', 'desc'])) {
            $isSorted = true;
        } else {
            $sortBy = null;
            $sortOrder = null;
        }

        $suppliers = Supplier::where($searchColumn ,'LIKE', "%$keyword%")
        ->orderBy($sortBy ?? 'created_at',$sortOrder ?? 'desc')->paginate($perPage)->appends([
        'sort_by'=>$sortBy,
        'sort_order'=>$sortOrder
        ]);

        return view('admin.pages.supplier-management.supplier-list', compact('suppliers','sortBy','sortOrder','isSorted','keyword','columns','searchColumn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.supplier-management.supplier-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $supplier = $request->all();
        Supplier::create($supplier);
        return redirect()->route('supplier.list')->with('success',"Bạn đã tạo thành công Nhà Cung cấp: <b> $supplier[name] </b>");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(Supplier $supplier)
    {
        
        return view('admin.pages.supplier-management.supplier-detail',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $updateSupplier = $request -> all();
        $supplier ->update($updateSupplier);
        return redirect() -> route('supplier.list') -> with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try{
            $supplier ->delete();
            return redirect() -> route('supplier.list') -> with('success',"Bạn đã xóa Khách hàng <b> $supplier[name] </b>");
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa Nhà cung cấp này: '.$e->getMessage());
        }
    }
}
