<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Warehouse System</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('layout_assets/images/logos/seodashlogo.png')}}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{asset('layout_assets/css/styles.min.css')}}" />
  <script src="{{asset('layout_assets/libs/jquery/dist/jquery.min.js')}}"></script>


</head>

<body>

  <!--  Body Wrapper -->
  <div class="page-wrapper min-vh-100" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
    data-sidebartype="full" data-sidebar-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="{{asset('layout_assets/images/logos/logo-light.svg')}}" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a href="{{route('dashboard')}}" class="sidebar-link" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">Quản lý chung</span>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('user.list')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Quản lý nhân viên</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('product.list')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:danger-circle-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Quản lý sản phẩm</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('inventory.list')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Quản lý tồn kho</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('supplier.list')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Nhà cung cấp</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('customer.list')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Khách hàng</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6" class="fs-6"></iconify-icon>
              <span class="hide-menu">Quản lý nhập hàng</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('purchase_order.list')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:login-3-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Đơn đặt hàng (PO)</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('goods_receipt.list')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:user-plus-rounded-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Phiếu nhập hàng</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('goods_receipt.inbound_detail')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:documents-minimalistic-line-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Chi tiết nhập hàng</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
              <span class="hide-menu">Quản lý xuất hàng</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('comming_soon')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:sticker-smile-circle-2-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Đơn hàng</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('comming_soon')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:planet-3-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Phiếu xuất hàng</span>
              </a>
            </li>
          </ul>
          <div class="unlimited-access hide-menu bg-primary-subtle position-relative mb-7 mt-7 rounded-3">
            <div class="d-flex">
              <div class="unlimited-access-title me-3">
                <h6 class="fw-semibold fs-4 mb-6 text-dark w-75">Upgrade to pro</h6>
                <a href="{{route('comming_soon')}}" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy
                  Pro</a>
              </div>
              <div class="unlimited-access-img">
                <img src="{{asset('layout_assets/images/backgrounds/rocket.png')}}" alt="" class="img-fluid">
              </div>
            </div>
          </div>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper d-flex flex-column min-vh-100">
      <!--  Header Start -->
      @include('admin.layout.nav-bar')
      <!--  Header End -->
      {{-- <div class="container"> --}}
        <div class="d-flex flex-grow-1">
          <div class="row flex-grow-1">
            @yield('content')
          </div>
        </div>
        {{--
      </div> --}}
      @include('admin.layout.footer')

    </div>
  </div>
  @yield('my-js')
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="{{asset('layout_assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('layout_assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{asset('layout_assets/libs/simplebar/dist/simplebar.js')}}"></script>
  <script src="{{asset('layout_assets/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('layout_assets/js/app.min.js')}}"></script>
  <script src="{{asset('layout_assets/js/dashboard.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>