@extends('admin.layout.master');

@section('content')
    {{-- Danh sách Đon đặt hàng --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Chi tiết nhập hàng</h2>
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
       
                        @csrf
                        <div class="row mb-3">
                        </div>
                      
                        <table id="productTable" class="table table-bordered table-sm fs-3 align-middle">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Đơn đặt hàng</th>
                                    <th>Mã phiếu nhập</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn vị tính</th>
                                    <th>Ngày nhập</th>
                           
                                </tr>
                            </thead>
                            <tbody id="product-rows">
                                @foreach($inboudDetails as $i => $item)
                                    <tr>
                                    <td class="index">{{ $i + 1 }}</td>
                                    <td>{{$item->purchase_order_id}}</td>
                                    <td>{{$item->goods_receipt_no}}</td>
                                    <td>{{$item->supplier->name}}</td>
                                    <td>{{$item->product->sku}}</td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->product->unit}}</td>
                                    <td>{{$item->created_at}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$inboudDetails->links()}}
                        {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif --}}
                        {{-- <button type="submit" class="btn btn-success mt-3" onclick="return confirm('Bạn có chắc chắn muốn nhập hàng không?')">Nhập hàng</button> --}}
         
                    {{-- {{$purchase_orders->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('my-js')

@endsection