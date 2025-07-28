@extends('admin.layout.master')

@section('content')
    {{-- Danh sách Đon đặt hàng --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Tạo Phiếu nhập hàng cho đơn <b>{{$purchaseOrder->purchase_order_id}}</b></h2>
                        {{-- <div>
                            <a class="btn btn-sm btn-primary" href="{{route('purchase_order.create')}}"><i
                                    class="fas fa-plus me-1"></i> Tạo Đơn đặt hàng</a>

                            <a data-bs-target="#createGRModal" class="btn btn-sm btn-info" href="" data-bs-toggle="modal"><i
                                    class="fas fa-plus me-1"></i> Tạo Phiếu
                                nhập</a>
                        </div> --}}
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
                    <form action="{{route('goods_receipt.store')}}" method="POST">
                        @csrf

                        <input type="hidden" name="PO" value="{{$purchaseOrder->purchase_order_id}}">
                        {{-- <div class="row mb-3">

                            <div class="col-md-4">
                                <label for="order_date" class="form-label">Nhà cung cấp</label>
                                <input type="text" id="supplier_name" name="supplier_name" class="form-control"
                                    value="{{old('supplier_name')}}">
                                <input type="hidden" id="supplier-id" name="supplier_id" value="{{old('supplier_id')}}">
                                <div id="supplier-list" class="list-group position-absolute w-100" style="z-index:1000;">

                                </div>
                                @error("supplier_name")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="order_date" class="form-label">Ngày đặt hàng</label>
                                <input type="text" id="order_date" name="order_date" class="form-control"
                                    value="{{old('order_date')}}">

                                @error("order_date")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="delivery_date" class="form-label">Ngày giao hàng</label>
                                <input type="text" id="delivery_date" name="delivery_date" class="form-control"
                                    placeholder="Chọn ngày nhận hàng" value="{{old('delivery_date')}}" required>
                                @error("delivery_date")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>


                        </div> --}}

                        <table id="productTable" class="table table-bordered table-sm fs-3 align-middle">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng đặt</th>
                                    <th>Đã tạo phiếu</th>
                                    <th>Có thể đặt</th>
                                    <th>Số lượng</th>
                                    <th>Đơn vi</th>
                                </tr>
                            </thead>
                            <tbody id="product-rows">
                                @foreach($poWithBalance as $i => $product)
                                    <tr>
                                        <td class="index">{{ $i + 1 }}</td>
                                        <td>{{$product['sku']}}</td>
                                        <td>{{$product['product_name']}}</td>
                                        <td>{{$product['quantity_ordered']}}</td>
                                        <td>{{$product['quantity_created']}}</td>
                                        <td>{{$product['quantity_remaining']}}</td>
                                        <td>
                                            <input name="products[{{ $i }}][product_id]" type="hidden" value="{{ $product['product_id'] }}">
                                            <input name="products[{{ $i }}][quantity]" type="number"
                                                value="{{ $product['quantity_remaining'] ?? '' }}" class="form-control">
                                            @error("products.$i.quantity")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td class="unit">{{$product['unit']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif --}}
                        <button type="submit" class="btn btn-success mt-3">Tạo phiếu nhập</button>
                    </form>
                    {{-- {{$purchase_orders->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection