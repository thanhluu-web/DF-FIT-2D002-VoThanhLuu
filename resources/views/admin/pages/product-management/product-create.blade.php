@extends('admin.layout.master');

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Tạo mới sản phẩm</h2>
        </div>
        <div class="card-body pt-0">
            <form action="{{route('product.store')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input name="name" type="text" class="form-control" value="{{old('name')}}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="unit">Đơn vị tính</label>
                            <select class="form-control" name="unit" id="unit">
                                <option value="">--- Chọn ---</option>
                                <option value="Cái" {{old('unit') == 'Cái' ? 'selected' : ''}}>Cái</option>
                                <option value="Thùng" {{old('unit') == 'Thùng' ? 'selected' : ''}}>Thùng</option>
                                <option value="Hộp" {{old('unit') == 'Hộp' ? 'selected' : ''}}>Hộp</option>
                            </select>
                        </div>
                        @error('unit')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="product_type">Loại hàng</label>
                            <select class="form-control" name="product_type" id="product_type">
                                <option value="">--- Chọn ---</option>
                                <option value="Ký gửi" {{old('product_type') == 'Ký gửi' ? 'selected' : ''}}>Ký gửi</option>
                                <option value="Sở hữu" {{old('product_type') == 'Sở hữu' ? 'selected' : ''}}>Sở hữu</option>
                            </select>
                        </div>
                        @error('product_type')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">--- Chọn ---</option>
                                <option {{  old('status') == '1' ? 'selected' : '' }} value="1">Hoạt động</option>
                                <option {{  old('status') == '0' ? 'selected' : '' }} value="0">Bị khóa</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="shelf_life">Hạn sử dụng (ngày) </label>
                            <input name="shelf_life" type="number" class="form-control" value="{{old('shelf_life')}}">
                        </div>
                        @error('shelf_life')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Hình ảnh</label>
                            <input name="image" type="file" class="form-control" onchange="previewImage(event)">
                            <img id="preview" src="" alt="Ảnh sản phẩm"
                                style="max-width: 200px; display: none ; margin-top: 10px;">
                        </div>
                        @error('image')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary"> <i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
            </form>
        </div>
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
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

    </script>
@endsection