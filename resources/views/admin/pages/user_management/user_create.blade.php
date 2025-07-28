@extends('admin.layout.master')

@section('content')

    <div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tạo mới nhân viên</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form role="form" action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="card-body col-md-6 pb-1">
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" class="form-control" id="name" placeholder="Nhập họ tên" name="name"
                                value="{{old('name')}}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại" name="phone"
                                value="{{old('phone')}}">
                        </div>
                        @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ" name="address"
                                value="{{old('address')}}">
                        </div>
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="role">Phân quyền</label>
                            <select id="role" name="role" class="form-control">
                                <option value="">---Please select---</option>
                                <option {{ old('role') == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                                <option {{ old('role') == 'staff' ? 'selected' : '' }} value="staff">Staff</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">---Please select---</option>
                                <option {{  old('status') == '1' ? 'selected' : '' }} value="1">Hoạt động</option>
                                <option {{  old('status') == '0' ? 'selected' : '' }} value="0">Bị khóa</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Nhập Email" name="email"
                                value="{{old('email')}}">
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" placeholder="Nhập Mật khẩu" name="password"
                                value="{{old('password')}}">
                        </div>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="card-body col-md-6">
                        <div class="form-group">
                            <label for="created_at">Ảnh đại diện</label>
                            <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event)">
                            <img id="preview" src="" alt="Ảnh đại diện"
                                style="max-width: 200px; display: none; margin-top: 10px;">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Tạo</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

@endsection

@section('my-js')
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
            else {
                preview.src = '';
                preview.style.display = 'none';
            }}
    </script>
@endsection

{{-- {{ route('admin.product_category.make_slug') }} --}}
{{-- {{ route('admin.product_category.update', ['productCategory' => $user->id]) }} --}}