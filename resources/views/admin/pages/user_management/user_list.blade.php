@extends('admin.layout.master')

@section('content')
  <div class="row">
    <div class="col-md-12">
    <div class="card">
      <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="card-title">Danh sách nhân viên</h2>
        <a href="{{route('user.create')}}" class="btn btn-primary me-2">
          <span class="d-none d-md-block"> <i class="fas fa-plus me-1"></i>Tạo mới nhân viên</span>
        </a>
      </div>
      @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show d-inline-block" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
      @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show d-inline-block" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
      </div>
      {{-- Danh sách cột --}}


      <div class="card-body pt-1">

      {{-- Tìm kiếm --}}
      <x-search-value :keyword="$keyword" :columns="$columns" :searchColumn="$searchColumn" routeName="user.list"
        :dataSeached="$users" />

      <table class="table table-bordered table-sm fs-3">
        <thead>
        <tr>
          <x-table-header :columns="$columns" :isSorted="$isSorted" :sortBy="$sortBy" :sortOrder="$sortOrder"
          routeName="user.list" />
        </tr>
        </thead>

        <tbody>
        @foreach ($users as $data)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td class="text-nowrap">{{ $data->name }}</td>
        <td>
        <img src="{{ asset('profile_images/' . $data->profile_image)}}" width="100" alt="{{ $data->name }}">
        </td>
        <td>{{ $data->phone }}</td>
        <td>{{ $data->email }}</td>
        <td>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('m/d/Y H:i:s') : '-' }}</td>
        <td>
            <span class="badge text-nowrap {{ $data->status ? 'bg-success' : 'bg-warning' }}">
            {{ $data->status ? 'Hoạt động' : 'Khóa' }}
            </span>
        </td>
        <td class="text-nowrap">

        <div class="d-flex gap-1">
          <a href="{{route('user.detail', ['user' => $data])}}" class="btn btn-sm btn-info">Chi tiết</a>
        <form action="{{route('user.delete', ['user' => $data])}}" method="post">
        @csrf
        @method('delete')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Xóa</button>
        </form>
        </div>
        </td>
      </tr>
      @endforeach
        </tbody>
      </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
      {{ $users->links() }}
      </div>
    </div>
    <!-- /.card -->
    </div>
  </div>

@endsection

{{-- {{ route('admin.product_category.detail', ['productCategory' => $data->id]) }} --}}
{{-- {{ route('admin.product.destroy', ['product' => $data->id]) }}--}}