@extends('admin.layout.master');

@section('content')
    {{-- Danh sách Đon đặt hàng --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Tạo yêu cầu mua hàng</h2>
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
                    <form action="{{route('purchase_order.store')}}" method="POST">
                        @csrf
                        <div class="row mb-3">

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


                        </div>

                        <table id="productTable" class="table table-bordered table-sm fs-3 align-middle">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn vị tính</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="product-rows">
                                @php
                                    $oldProducts = old('products', []);
                                @endphp
                                @if(count($oldProducts) > 0)
                                    @foreach($oldProducts as $i => $product)
                                        <tr>
                                            <td class="index">{{ $i + 1 }}</td>
                                            <td>
                                                <input name="products[{{ $i }}][product_id]" type="text"
                                                    value="{{ $product['product_id'] ?? '' }}" class="form-control product-code">
                                                @error("products.$i.product_id")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td class="name"></td>
                                            <td>
                                                <input name="products[{{ $i }}][quantity]" type="number" min="1"
                                                    value="{{ $product['quantity'] ?? '' }}" class="form-control">
                                                @error("products.$i.quantity")
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td class="unit"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-row">Xóa</button></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="index">1</td>
                                        <td>
                                            <input name="products[0][product_id]" type="text" class="form-control product-code">
                                            <small class="text-danger error-message"></small>
                                        </td>
                                        <td class="name"></td>
                                        <td>
                                            <input name="products[0][quantity]" type="number" class="form-control" min="1">
                                        </td>
                                        <td class="unit"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-row">Xóa</button></td>
                                    </tr>
                                @endif
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
                        <button type="button" id="add-product"
                            class="btn btn-sm btn-primary mt-2 d-flex align-items-center ms-auto">Thêm
                            sản phẩm</button>
                        <button type="submit" class="btn btn-success mt-3">Đặt hàng</button>
                    </form>
                    {{-- {{$purchase_orders->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('my-js')
    <script>
        $(document).ready(function () {
            // Sự kiện cho các Row ============================================
            function updateIndex() {
                const rows = $('#productTable tbody tr');
                rows.each(function (i) {
                    $(this).find('.index').text(i + 1);

                    $(this).find('input[name^="products"]').each(function () {
                        if ($(this).attr('name').includes('[product_id]')) {
                            $(this).attr('name', `products[${i}][product_id]`);
                        };
                        if ($(this).attr('name').includes('[quantity]')) {
                            $(this).attr('name', `products[${i}][quantity]`);
                        };
                    });
                });

                if (rows.length <= 1) {
                    console.log(rows.length)
                    rows.find('.remove-row').hide();
                } else {
                    rows.find('.remove-row').show();
                }
            }

            // Hàm lấy ngày hôm nay
            function getToday() {
                let d = new Date();
                let month = '' + (d.getMonth() + 1);
                let day = '' + d.getDate();
                let year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [day, month, year].join('-');
            }

            //Thêm dòng
            $('#add-product').click(function () {
                let newRow = `<tr>
                                <td class="index"></td>
                                <td>
                                    <input name="products[][product_id]" type="text" class="form-control product-code">
                                    <small class="text-danger error-message"></small>
                                </td>
                                <td class="name"></td>
                                <td>
                                    <input name="products[][quantity]" type="number" class="form-control" min="1">
                                </td>
                                <td class="unit"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">Xóa</button></td>
                            </tr>`;
                $('#product-rows').append(newRow);
                updateIndex();
            });

            // Xóa dòng
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                updateIndex();
            });


            //Hiện tên sản phẩm
            $(document).on('blur', '.product-code', function () {
                loadProductName($(this));
            });

            $('.product-code').each(function () {
                loadProductName($(this));
            });

            // Khởi tạo ngày đặt hàng cho dòng đầu tiên
            $('#productTable tbody tr').each(function () {
                $(this).find('.order-date').text(getToday());
            });

            updateIndex();

            $('#supplier_name').on('input', function () {
                let query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route("purchase_order.supplier.search") }}',
                        type: 'GET',
                        data: { q: query },
                        success: function (data) {
                            let html = '';
                            if (data.length > 0) {
                                data.forEach(function (item) {
                                    html += `<a href="#" class="list-group-item list-group-item-action supplier-item" data-id="${item.id}">${item.name}</a>`;
                                });
                            } else {
                                html = '<div class="list-group-item">Không tìm thấy nhà cung cấp</div>';
                            }
                            $('#supplier-list').html(html).show();
                        }
                    });
                } else {
                    $('#supplier-list').hide();
                }
            });

            //click chọn NCC
            $(document).on('click', '.supplier-item', function (e) {
                e.preventDefault();
                let name = $(this).text();
                let id = $(this).data('id');
                $('#supplier_name').val(name);
                $('#supplier-id').val(id);
                $('#supplier-list').hide();

            });


            //Nếu không chọn thì bước này sẽ tự động lên DB để lấy dữ liệu tên NCC
            $('#supplier').on('blur', function () {
                let query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route("purchase_order.supplier.search") }}',
                        type: 'GET',
                        data: { q: query },
                        success: function (data) {
                            if (data.length === 1 && data[0].name.toLowerCase() === query.toLowerCase()) {
                                // Nếu tìm thấy đúng một kết quả khớp hoàn toàn
                                $('#supplier-id').val(data[0].id); // giả sử bạn có input hidden để lưu id
                            } else {
                                $('#supplier-id').val(''); // không rõ ràng thì xóa ID
                            }
                        }
                    });
                }
            });


            $(document).click(function (e) {
                if (!$(e.target).closest('#supplier').length) {
                    $('#supplier-list').hide();
                }
            });

            flatpickr("#delivery_date,#order_date", {
                dateFormat: "d/m/Y", // Định dạng ngày/tháng/năm
                allowInput: true,
                defaultDate: "{{ old('delivery_date') ?? 'today' }}"
            });


            // Khi nhập mã sản phẩm, gọi AJAX lấy tên
            function loadProductName(input) {
                let code = input.val();
                input.siblings('.error-message').text('');
                if (code.trim() === '') {
                    input.closest('tr').find('.name').text('');
                    return;
                }
                $.ajax({
                    url: '{{route('purchase_order.checkProductName')}}',
                    method: 'GET',
                    data: { code: code },
                    success: function (res) {
                        if (res.name) {
                            input.closest('tr').find('.name').text(res.name);
                            input.closest('tr').find('.unit').text(res.unit);
                        } else {
                            input.closest('tr').find('.name').text('');
                            input.siblings('.error-message').text('Không tìm thấy sản phẩm');
                        }
                    },
                    error: function () {
                        input.closest('tr').find('.name').text('');
                        input.siblings('.error-message').text('Lỗi server, thử lại sau');
                    }
                });
            }
        })

    </script>
@endsection