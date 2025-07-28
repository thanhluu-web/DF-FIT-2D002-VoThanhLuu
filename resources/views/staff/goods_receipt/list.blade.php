@extends('admin.layout.master')

@section('content')
    {{-- Modal tạo phiếu nhập --}}

    <div class="modal fade" id="createGRModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="createGRForm" method="POST">
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
                        <h2 class="card-title">Danh sách phiếu nhập</h2>
                        <div>

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
                        routeName="goods_receipt.list" :dataSeached="$groupedReceipts" />

                    <table class="table table-bordered table-sm fs-3">
                        <thead>
                            <tr>
                                <x-table-header :columns="$columns" :isSorted="$isSorted" :sortBy="$sortBy"
                                    :sortOrder="$sortOrder" routeName="goods_receipt.list" />
                                {{-- <th>STT</th>
                                <th>Số phiếu nhập</th>
                                <th>Đơn đặt hàng</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Ngày cập nhật</th>
                                <th>Chức năng</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupedReceipts as $goodsReceipt)

                                @php
                                    $statusClasses = [
                                        'Mới' => 'badge bg-secondary ',
                                        'Đang nhập' => 'badge bg-warning text-dark',
                                        'Hủy' => 'badge bg-danger',
                                        'Hoàn thành' => 'badge bg-success'
                                    ];

                                    $status = $goodsReceipt->status;
                                    $class = $statusClasses[$status] ?? 'badge bg-secondary'; // fallback
                                @endphp

                                <form action="{{route('goods_receipt.cancel')}}" method="post">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="goods_receipt_no" value="{{ $goodsReceipt->goods_receipt_no }}">
                                    <input type="hidden" name="status" value="{{ $goodsReceipt->status }}">

                                    <tr>
                                        <td>{{($groupedReceipts->currentPage() - 1) * $groupedReceipts->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{$goodsReceipt->goods_receipt_no}}</td>
                                        <td>{{$goodsReceipt->purchase_order_id}}</td>

                                        <td>{{$goodsReceipt->total_quantity}}</td>
                                        <td>
                                            <span class="{{ $class }}">{{ $status }}</span>
                                        </td>
                                        <td>{{$goodsReceipt->updated_at}}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{route('goods_receipt.detail', ['goods_receipt_no' => $goodsReceipt->goods_receipt_no])}}"
                                                    class="btn btn-sm btn-info text-nowrap">Chi tiết</a>
                                                <button {{checkDisabled($goodsReceipt->status)}} class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Hủy</button>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            @endforeach

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </tbody>
                    </table>
                    </form>
                    {{$groupedReceipts->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('my-js')
    <script>
        // $('#createGRModal').on('show.bs.modal', function(event){
        //     const button = $(event.relatedTarget);
        // })
        $('#createGRForm').on('submit', function (e) {
            e.preventDefault();
            let url = "{{ route('goods_receipt.check_PO')}}";
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
                    }
                    else {
                        $('#modal-message').text(data.message)
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