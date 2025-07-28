@extends('admin.layout.master')

@section('title', 'Tính năng đang phát triển')

@section('content')
    <div class="container text-center py-5">
        <h1 class="display-4 text-primary">🚧 Coming Soon</h1>
        <p class="lead px-4">
            Tính năng này hiện đang được phát triển và sẽ sớm ra mắt trong thời gian tới.<br>
            Cảm ơn bạn đã quan tâm và sử dụng hệ thống.
        </p>
        <img src="https://cdn-icons-png.flaticon.com/512/6482/6482700.png" alt="Coming Soon" style="width: 150px; margin: 30px 0;">
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
@endsection
