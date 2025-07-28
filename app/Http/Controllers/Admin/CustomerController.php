<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
            'name' => 'Tên Khách hàng',
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

        $customers = Customer::where($searchColumn ,'LIKE', "%$keyword%")->orderBy($sortBy ?? 'created_at',$sortOrder ?? 'desc')->paginate($perPage)->appends([
        'sort_by'=>$sortBy,
        'sort_order'=>$sortOrder
        ]);
        
        return view('admin.pages.customer-management.customer-list', compact('customers','sortBy','sortOrder','isSorted','keyword','columns','searchColumn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.customer-management.customer-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $customer = $request->all();
        Customer::create($customer);
        return redirect()->route('customer.list')->with('success',"Bạn đã tạo thành công Khách hàng: <b> $customer[name] </b>");
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
    public function detail(Customer $customer)
    {
        return view('admin.pages.customer-management.customer-detail',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $updateCustomer = $request -> all();
        $customer ->update($updateCustomer);
        return redirect() -> route('customer.list') -> with('success','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer ->delete();
        return redirect() -> route('customer.list') -> with('success',"Bạn đã xóa Khách hàng <b> $customer[name] </b>");
    }
}
