@extends('admin.layout.master');

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Danh sách sản phẩm</h2>
                        <a class="btn btn-primary" href="{{route('product.create')}}"><i class="fas fa-plus me-1"></i> Tạo mới sản phẩm</a>
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

                <div class="card-body pt-1">
                    <x-search-value 
                        :keyword="$keyword"
                        :columns="$columns"
                        :searchColumn="$searchColumn"
                        routeName="product.list"
                        :dataSeached="$products"
                    />

                    <table class="table table-bordered table-sm fs-3">
                        <thead>
                            <tr>
                                <x-table-header 
                                    :columns="$columns" 
                                    :isSorted="$isSorted"
                                    :sortBy="$sortBy" 
                                    :sortOrder="$sortOrder" 
                                    routeName="product.list"
                                />
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{(($products->currentPage()-1)*$products->perPage()+$loop->iteration)}}</td>
                                <td>{{$product->name}}</td>
                                <td>
                                    <img src="{{asset('product_images/'.$product->image)}}" width="100" alt="{{$product->name}}">                            
                                </td>
                                <td>{{$product->sku}}</td>
                                <td>{{$product->unit}}</td>
                                <td>{{$product->product_type}}</td>
                                <td>{{$product->shelf_life}}</td>
                                <td>
                                    <span class="badge text-nowrap {{ $product->status ? 'bg-success' : 'bg-warning' }}">
                                            {{ $product->status ? 'Hoạt động' : 'Khóa' }}
                                    </span>
                                </td>
                                </td>
                                <td>{{$product->created_at}}</td>
                                <td>{{$product->updated_at}}</td>
                                <td >
                                    <div class="d-flex gap-1">      
                                        <a href="{{route('product.detail',['product' => $product])}}" class="btn btn-sm btn-info text-nowrap">Chi tiết</a>
                                        <form action="{{route('product.delete', ['product' => $product])}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn có muôn xóa?')">Xóa</button>
                                        </form>
                                  </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection