@extends('admin.layout.master');

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Danh sách Khách hàng</h2>
                        <a class="btn btn-primary" href="{{route('customer.create')}}"><i class="fas fa-plus me-1"></i> Tạo
                            mới Khách hàng</a>
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
                        routeName="customer.list" :dataSeached="$customers" />

                    <table class="table table-bordered table-sm fs-3">
                        <thead>
                            <tr>
                                <x-table-header :columns="$columns" :isSorted="$isSorted" :sortBy="$sortBy"
                                    :sortOrder="$sortOrder" routeName="customer.list" />
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{(($customers->currentPage() - 1) * $customers->perPage()) + $loop->iteration }}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->address}}</td>
                                    <td>
                                        <span class="badge text-nowrap {{ $customer->status ? 'bg-success' : 'bg-warning' }}">
                                            {{ $customer->status ? 'Hoạt động' : 'Khóa' }}
                                        </span>
                                    </td>
                                    <td>{{$customer->created_at}}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{route('customer.detail', ['customer' => $customer])}}"
                                                class="btn btn-sm btn-info text-nowrap">Chi tiết</a>
                                            <form action="{{route('customer.delete', ['customer' => $customer])}}"
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
                    {{$customers->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection