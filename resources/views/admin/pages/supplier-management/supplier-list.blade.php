@extends('admin.layout.master');

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Danh sách sản phẩm</h2>
                        <a class="btn btn-primary" href="{{route('supplier.create')}}"><i class="fas fa-plus me-1"></i> Tạo
                            mới Nhà cung cấp</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-inline-block" role="alert">
                            {!! session('success') !!}
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

                <div class="card-body pt-1">

                    <x-search-value :keyword="$keyword" :columns="$columns" :searchColumn="$searchColumn"
                        routeName="supplier.list" :dataSeached="$suppliers" />

                    <table class="table table-bordered table-sm fs-3">
                        <thead>
                            <tr>
                                <x-table-header :columns="$columns" :isSorted="$isSorted" :sortBy="$sortBy"
                                    :sortOrder="$sortOrder" routeName="supplier.list" />

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{(($suppliers->currentPage() - 1) * $suppliers->perPage()) + $loop->iteration }}</td>
                                    <td>{{$supplier->name}}</td>
                                    <td>{{$supplier->phone}}</td>
                                    <td>{{$supplier->address}}</td>
                                    <td>
                                        <span class="badge text-nowrap {{ $supplier->status ? 'bg-success' : 'bg-warning' }}">
                                            {{ $supplier->status ? 'Hoạt động' : 'Khóa' }}
                                        </span>
                                    </td>
                                    <td>{{$supplier->created_at}}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{route('supplier.detail', ['supplier' => $supplier])}}"
                                                class="btn btn-sm btn-info text-nowrap">Chi tiết</a>
                                            <form action="{{route('supplier.delete', ['supplier' => $supplier])}}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$suppliers->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection