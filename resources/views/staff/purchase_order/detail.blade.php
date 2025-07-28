@extends('admin.layout.master');

@section('content')
    {{-- Danh sách Đon đặt hàng --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Chi tiết đơn hàng: <b>{{$purchaseOrderDetails[0]->purchase_order_id}}</b>
                        </h2>
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
                <div class="card-body">
                   <h4>Trạng thái: {{$status}}</h4>
                    <div class="pt-2">
                        <table class="table table-bordered table-sm fs-3">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Đơn đặt hàng</th>
                                    <th>Mã hàng</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Ngày đặt hàng</th>
                                    <th>Số lượng đặt hàng</th>
                                    <th>Số lượng đã nhập</th>
                                    <th>Ngày cập nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrderDetails as $purchaseOrderDetail)
                                    <tr>
                                        <td>{{($purchaseOrderDetails->currentPage() - 1) * $purchaseOrderDetails->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{$purchaseOrderDetail->purchase_order_id}}</td>
                                        <td>{{$purchaseOrderDetail->product->sku}}</td>
                                        <td>{{$purchaseOrderDetail->product->name}}</td>
                                        <td>{{$purchaseOrderDetail->created_at->format('d-m-y')}}</td>
                                        <td>{{$purchaseOrderDetail->qty_ordered}}</td>
                                        <td>{{$purchaseOrderDetail->qty_received}}</td>
                                        <td>{{$purchaseOrderDetail->updated_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$purchaseOrderDetails->links()}}
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <a href="{{ route('goods_receipt.create', ['PO' => $purchaseOrderDetails[0]->purchase_order_id]) }}"
                        class="btn btn-success mt-3 {{checkDisabled($status)}}">Tạo phiếu nhập</a>

                    {{-- {{$purchase_orders->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

