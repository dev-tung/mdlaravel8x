<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Manh Dung | Admin</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Admin" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Admin, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin admin, bootstrap 5 admin, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq admin, colorlibhq admin admin, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <!--end::Accessibility Features-->
   
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <link rel="stylesheet" href="{{ asset('css/libraries/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}" />

  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.products.create') }}" class="nav-link">+ Thêm sản phẩm</a></li>
            <!-- <li class="nav-item d-none d-md-block"><a href="{{ route('admin.customers.create') }}" class="nav-link">+ Thêm khách hàng</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.exports.create') }}" class="nav-link">+ Thêm đơn hàng</a></li> -->
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">

            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
                <span class="d-none d-md-inline">Admin</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-link btn-sm w-100">Đăng Xuất</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        
  

        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{route('admin.dashboard')}}" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{asset('img/shared/logo-white-transperent.png')}}"
              alt="Manh Dung Logo"
              class="brand-image"
            />
            <!--end::Brand Image-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->


        <!--begin::Sidebar Wrapper-->
        @include('admin.shared.sidebar')
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
            
      <!--begin::App Main-->
      <main class="app-main" id="main" tabindex="-1">
        @include('admin.shared.alert')
        @yield('content')
      </main>
      <!--end::App Main-->

      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::Copyright-->
        <strong>
          © 2025, MANH DUNG SPORTS COMPANY LIMITED.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>  
    <!--end::App Wrapper-->

    <!--begin::Script-->
    <!-- Bootstrap JS + Popper -->

    <script src="{{ asset('js/libraries/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/libraries/adminlte.js') }}"></script>

    <script src="{{ asset('js/admin/shared/App.js') }}"></script>

    @stack('scripts')
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
