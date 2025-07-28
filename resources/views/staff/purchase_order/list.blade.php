@extends('admin.layout.master');

@section('content')
    {{-- Modal tạo phiếu nhập --}}

    <div class="modal fade" id="createGRModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="createGRForm" method="POST" data-url="{{ route('goods_receipt.check_PO')}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Tạo phiếu nhập</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="purchase_order" class="form-label">Nhập mã Đơn đặt hàng:</label>
                            <input id="purchase_order" name="purchase_order" class=" fw-bold form-control"></input>
                        </div>
                        <div id="modal-message" class="text-danger mt-2"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tạo</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Danh sách Đon đặt hàng --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Danh sách đơn đặt hàng</h2>
                        <div>
                            <a class="btn btn-sm btn-primary" href="{{route('purchase_order.create')}}"><i
                                    class="fas fa-plus me-1"></i> Tạo Đơn đặt hàng</a>

                            <a data-bs-target="#createGRModal" class="btn btn-sm btn-info" href="" data-bs-toggle="modal"><i
                                    class="fas fa-plus me-1"></i> Tạo Phiếu
                                nhập</a>
                        </div>
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
                    <x-search-value :keyword="$keyword" :columns="$columns" :searchColumn="$searchColumn"
                        routeName="purchase_order.list" :dataSeached="$purchase_orders" />

                    <table class="table table-bordered table-sm fs-3">
                        <thead>
                            <tr>
                                <x-table-header :columns="$columns" :isSorted="$isSorted" :sortBy="$sortBy"
                                    :sortOrder="$sortOrder" routeName="purchase_order.list" />
                                {{-- <th>STT</th>
                                <th>Đơn đặt hàng</th>
                                <th>Nhà cung cấp</th>
                                <th>Ngày đặt hàng</th>
                                <th>Trạng thái</th>
                                <th>Ngày cập nhật</th>
                                <th>Chức năng</th> --}}
                            </tr>
                        </thead>



                        <tbody>
                            @foreach ($purchase_orders as $purchase_order)
                                @php
                                    $statusClasses = [
                                        'Mới' => 'badge bg-secondary ',
                                        'Đang nhập' => 'badge bg-warning text-dark',
                                        'Hủy' => 'badge bg-danger',
                                        'Hoàn thành' => 'badge bg-success'
                                    ];

                                    $status = $purchase_order->status;
                                    $class = $statusClasses[$status] ?? 'badge bg-secondary'; // fallback
                                @endphp

                                <tr>
                                    <td>{{($purchase_orders->currentPage() - 1) * $purchase_orders->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{$purchase_order->purchase_order_id}}</td>
                                    <td>{{$purchase_order->supplier->name}}</td>
                                    <td>{{$purchase_order->created_at->format('d-m-y')}}</td>
                                    <td>
                                        <span class="{{ $class }}">{{ $status }}</span>
                                    </td>

                                    <td>{{$purchase_order->updated_at}}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{route('purchase_order.detail', ['purchase_order' => $purchase_order])}}"
                                                class="btn btn-sm btn-info text-nowrap">Chi tiết</a>
                                            <form
                                                action="{{route('purchase_order.cancel', ['purchase_order' => $purchase_order])}}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button {{checkDisabled($purchase_order->status)}} class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có thực sự muốn hủy đơn hàng này?')">Hủy</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$purchase_orders->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('my-js')
    <script>
        // $('#createGRModal').on('show.bs.modal', function (event) {
        //     const button = $(event.relatedTarget);
        // });
        $('#createGRForm').on('submit', function (e) {
            e.preventDefault();
            let url = $('#createGRForm').data('url');
            const form = $(this);

            $('#modal-message').text('');

            $.ajax({
                url: url,
                method: form.attr('method'),
                data: new FormData(this),
                processData: false,
                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $(form).find('input[name="_token"]').val(),
                    'Accept': 'application/json'
                },

                success: function (data) {
                    if (data.success) {
                        window.location.href = "{{ route('goods_receipt.create', ['PO' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER', data.message);
                    } else {
                        $('#modal-message').text(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    $('#modal-message').text('Lỗi khi gửi dữ liệu.');
                }
            })
        })
    </script>
@endsection