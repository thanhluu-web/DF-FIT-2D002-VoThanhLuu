@extends('admin.layout.master');

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Chi tiết Khách hàng</h2>
        </div>
        <div class="card-body pt-0">
            <form action="{{route('customer.update',['customer'=>$customer])}}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Tên Khách hàng</label>
                            <input name="name" type="text" class="form-control" value="{{$customer->name}}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input name="phone" type="text" class="form-control" value="{{$customer->phone}}">
                        </div>
                        @error('phone')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input name="address" type="text" class="form-control" value="{{$customer->address}}">
                        </div>
                        @error('address')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">--- Chọn ---</option>
                                <option {{  $customer->status == '1' ? 'selected' : '' }} value="1">Hoạt động</option>
                                <option {{  $customer->status == '0' ? 'selected' : '' }} value="0">Bị khóa</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày tạo</label> <br />
                           <input disabled name="created_at" type="text" class="form-control" value="{{$customer->created_at}}">
                        </div>
                        @error('created_at')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror

                          <div class="form-group">
                            <label>Ngày cập nhật</label> <br />
                           <input disabled name="updated_at" type="text" class="form-control" value="{{$customer->updated_at}}">
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

