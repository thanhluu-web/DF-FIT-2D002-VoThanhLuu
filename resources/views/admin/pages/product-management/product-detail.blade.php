@extends('admin.layout.master');

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Chi tiết sản phẩm</h2>
        </div>
        <div class="card-body pt-0">
            <form action="{{route('product.update',['product'=>$product])}}" enctype="multipart/form-data" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input name="name" type="text" class="form-control" value="{{$product->name}}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="unit">Đơn vị tính</label>
                            <select class="form-control" name="unit" id="unit">
                                <option value="">--- Chọn ---</option>
                                <option value="Cái" {{$product->unit == 'Cái' ? 'selected' : ''}}>Cái</option>
                                <option value="Thùng" {{$product->unit == 'Thùng' ? 'selected' : ''}}>Thùng</option>
                                <option value="Hộp" {{$product->unit == 'Hộp' ? 'selected' : ''}}>Hộp</option>
                            </select>
                        </div>
                        @error('unit')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="product_type">Loại hàng</label>
                            <select class="form-control" name="product_type" id="product_type">
                                <option value="">--- Chọn ---</option>
                                <option value="Ký gửi" {{$product->product_type == 'Ký gửi' ? 'selected' : ''}}>Ký gửi
                                </option>
                                <option value="Sở hữu" {{$product->product_type == 'Sở hữu' ? 'selected' : ''}}>Sở hữu</option>
                            </select>
                        </div>
                        @error('product_type')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">--- Chọn ---</option>
                                <option {{  $product->status == '1' ? 'selected' : '' }} value="1">Hoạt động</option>
                                <option {{  $product->status == '0' ? 'selected' : '' }} value="0">Bị khóa</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ảnh sản phẩm</label> <br />
                            <input for="image" id="image" name="image" type="file" class="form-control d-none"
                                onchange="previewImage(event)">
                            <label for="image">Thay đổi hình ảnh</label>
                            <img id="preview" src="{{asset('product_images/' . $product->image)}}" alt="Ảnh sản phẩm"
                                style="max-width: 200px; display: block ; margin-top: 10px;">
                        </div>
                        @error('image')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary"> <i class="fa fa-check" aria-hidden="true"></i> Cập nhật</button>
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

            // Đổi nhãn hiển thị tên file
            const fileName = input.files[0].name;
            input.nextElementSibling.innerText = fileName;
        }

    </script>
@endsection