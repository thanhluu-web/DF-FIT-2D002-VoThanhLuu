@extends('admin.layout.master');

@section('content')

    <!-- Modal cập nhật trạng thái -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="updateStatusForm" method="POST" action="{{route('inventory.updateStatus')}}">
                @csrf
                @method('put')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Cập nhật trạng thái</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="inventory_id" name="inventory_id">

                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm:</label>
                            <p id="product_name" class="fw-bold"></p>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select " name="status" id="status">
                                <option value="Hàng tốt">Hàng tốt</option>
                                <option value="Hàng hư hỏng">Hàng hư hỏng</option>
                                <option value="Hàng chờ QA">Hàng chờ QA</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    {{-- Danh sách --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Danh sách tồn kho</h2>
                        {{-- <a class="btn btn-primary" href="{{route('inventoryItem.create')}}"><i
                                class="fas fa-plus me-1"></i>
                            Tạo mới sản phẩm</a> --}}
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
                        routeName="inventory.list"
                        :dataSeached="$inventories"
                    />
                    
                    <table class="table table-bordered table-sm fs-3">
                        <thead>
                            <tr>
                                 <x-table-header 
                                    :columns="$columns" 
                                    :isSorted="$isSorted"
                                    :sortBy="$sortBy" 
                                    :sortOrder="$sortOrder" 
                                    routeName="inventory.list"
                                />
                                {{-- <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Đơn vị tính</th>
                                <th>Ngày sản xuất</th>
                                <th>Trạng thái</th>
                                <th>Ngày nhập</th>
                                <th>Ngày cập nhật</th>
                                <th>Chức năng</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventories as $inventoryItem)
                                <tr>
                                    <td>{{(($inventories->currentPage()-1)*$inventories->perPage()+$loop->iteration)}}</td>
                                    <td>{{$inventoryItem->sku}}</td>
                                    <td>{{$inventoryItem->name}}</td>
                                    <td>{{$inventoryItem->quantity}}</td>
                                    <td>{{$inventoryItem->unit}}</td>
                                    <td>{{$inventoryItem->manufacture_date}}</td>
                                    <td>{{$inventoryItem->status}}</td>
                                    <td>{{$inventoryItem->created_at->format('d-m-y')}}</td>
                                    <td>{{$inventoryItem->updated_at}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="" class="btn btn-sm btn-warning text-nowrap" data-bs-toggle="modal"
                                                data-bs-target="#updateStatusModal" data-id="{{ $inventoryItem->id }}"
                                                data-status="{{$inventoryItem->status }}"
                                                data-name ="{{$inventoryItem->name}}">Cập nhật</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$inventories->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('my-js')
    <script>
        const updateModal = document.getElementById('updateStatusModal');

        updateModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // nút bấm đã kích hoạt modal
            const id = button.getAttribute('data-id');
            const status = button.getAttribute('data-status');
            const name = button.getAttribute('data-name')
            // Gán ID vào input ẩn
            document.getElementById('inventory_id').value = id;

            // Gán action form (nếu cần thiết)
            const form = document.getElementById('updateStatusForm');

            // Set giá trị trạng thái vào select
            document.getElementById('status').value = status;
            document.getElementById('product_name').textContent = name;

        });
    </script>
@endsection