<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\CreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {    
        $perPage = config('app.item_per_page');
        $sortBy = $request->get('sort_by');
        $sortOrder = $request->get('sort_order');

        $keyword = $request->get('keyword','');
        $searchColumn = $request->get('search_column','name');

        $allowedSort = ['name','phone','email','created_at','status',''];
        $isSorted = false;
        
        $columns = [
            'stt'=>'STT',
            'name' => 'Họ tên',
            'image' => 'Ảnh đại diện',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'created_at'=>' Thời gian tạo',
            'status' => 'Trạng thái',
            'action' => 'Action'
        ];

        if (in_array($sortBy, $allowedSort) && in_array($sortOrder, ['asc', 'desc'])) {
            $isSorted = true;
        } else {
            $sortBy = null;
            $sortOrder = null;
        }
        
        $users = User::where($searchColumn ,'LIKE', "%$keyword%")->orderBy($sortBy ?? 'created_at',$sortOrder ?? 'desc')->paginate($perPage)->appends([
        'sort_by'=>$sortBy,
        'sort_order'=>$sortOrder
        ]);
  
        return view('admin.pages.user_management.user_list',compact('users','sortBy','sortOrder','isSorted','keyword','searchColumn','columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.user_management.user_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $createRequest)
    {

        $user = $createRequest->safe()->merge([
            'password' => Hash::make($createRequest->password),
        ])->all();
        
        if($createRequest->hasFile('profile_image')){
            $file = $createRequest->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'img_'.uniqid().".$extension";
            $file->move(public_path("profile_images"),$filename);
            $user['profile_image'] = $filename;
        }

       User::create($user);
       return redirect()->route('user.list')->with('success','Đã tạo thành công tài khoản mới');

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
    public function edit(User $user)
    {
        return view('admin.pages.user_management.user_detail',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role' => 'required|in:admin,user,staff',
            'status' => 'required|in:0,1',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id
        ]);

        $user ->update($validated);
    
        return redirect()->route('user.list')->with('success','Cập nhật thành công')

      ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.list')->with('success','Đã xóa thành công');
    }
}
