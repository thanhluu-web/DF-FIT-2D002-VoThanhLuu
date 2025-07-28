@extends('admin.layout.master')

@section('title', 'Không có quyền truy cập')

@section('content')
    <div class="container text-center py-5">
        <h1 class="display-4 text-danger">403 - Không có quyền truy cập</h1>
        <p class="lead ps-5 pe-5">Bạn không được phân quyền truy cập vào trang này hoặc không có quyền sử dụng chức năng này, chúng tôi sẽ ẩn các nút bấm này trong bản cập nhật tiếp theo</p>
        <a href="{{url()->previous()}}" class="btn btn-primary">Trở về trang trước</a>
    </div>
@endsection
