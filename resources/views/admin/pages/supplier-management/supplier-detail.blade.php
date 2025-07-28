@extends('admin.layout.master');

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Chi tiết Nhà cung cấp</h2>
        </div>
        <div class="card-body pt-0">
            <form action="{{route('supplier.update',['supplier'=>$supplier])}}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Tên Nhà cung cấp</label>
                            <input name="name" type="text" class="form-control" value="{{$supplier->name}}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input name="phone" type="text" class="form-control" value="{{$supplier->phone}}">
                        </div>
                        @error('phone')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input name="address" type="text" class="form-control" value="{{$supplier->address}}">
                        </div>
                        @error('address')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">--- Chọn ---</option>
                                <option {{  $supplier->status == '1' ? 'selected' : '' }} value="1">Hoạt động</option>
                                <option {{  $supplier->status == '0' ? 'selected' : '' }} value="0">Bị khóa</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày tạo</label> <br />
                           <input disabled name="created_at" type="text" class="form-control" value="{{$supplier->created_at}}">
                        </div>
                        @error('created_at')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                          <div class="form-group">
                            <label>Ngày cập nhật</label> <br />
                           <input disabled name="updated_at" type="text" class="form-control" value="{{$supplier->updated_at}}">
                        </div>
                        @error('updated_at')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary"> <i class="fa fa-check" aria-hidden="true"></i> Cập nhật</button>
            </form>
        </div>
    </div>
@endsection

