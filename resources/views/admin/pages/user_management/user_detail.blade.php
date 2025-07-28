@extends('admin.layout.master')

@section('content')

    <div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Chi tiết nhân viên {{$user->name}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form role="form" action="{{route('user.update', ['user' => $user])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="card-body col-md-6 pb-1">

                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" class="form-control" id="name" placeholder="Nhập họ tên" name="name"
                                value="{{ $user->name }}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại" name="phone"
                                value="{{ $user->phone }}">
                        </div>
                        @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ" name="address"
                                value="{{ $user->address }}">
                        </div>
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="role">Phân quyền</label>
                            <select id="role" name="role" class="form-control">
                                <option value="">---Please select---</option>
                                <option {{ $user->role == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                                <option {{ $user->role == 'staff' ? 'selected' : '' }} value="staff">Staff</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">---Please select---</option>
                                <option {{ $user->status == '1' ? 'selected' : '' }} value="1">Hoạt động</option>
                                <option {{ $user->status == '0' ? 'selected' : '' }} value="0">Bị khóa</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Nhập Email" name="email"
                                value="{{ $user->email }}">
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="created_at">Ngày tạo</label>
                            <input disabled type="text" class="form-control" id="created_at " placeholder="Nhập Email"
                                name="created_at " value="{{ $user->created_at  }}">
                        </div>
                        @error('created_at ')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="card-body col-md-6">
                        <div class="form-group">
                            <label for="created_at">Ảnh đại diện</label>
                            <img class="w-100" src="{{asset('profile_images/' . $user->profile_image)}}" alt="">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

@endsection

@section('my-js')
    {{--
    <script type="text/javascript">
        $(document).ready(function () {
            $('#name').on('keyup', function () {
                var slug = $(this).val();

                $.ajax({
                    method: "GET", //method of form
                    url: "", //action of form
                    user: { slug: slug }, //input name of form,
                    success: function (response) {
                        $('#slug').val(response.slug);
                    }
                });
            });
        });
    </script> --}}
@endsection

{{-- {{ route('admin.product_category.make_slug') }} --}}
{{-- {{ route('admin.product_category.update', ['productCategory' => $user->id]) }} --}}