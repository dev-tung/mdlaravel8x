<div class="sidebar-wrapper">
  <nav class="mt-2">
    <!--begin::Sidebar Menu-->
    <ul
      class="nav sidebar-menu flex-column"
      data-lte-toggle="treeview"
      role="navigation"
      aria-label="Main navigation"
      data-accordion="false"
      id="navigation"
    >
      <li class="nav-item menu-open">
        <a href="{{ route('dashboard') }}" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Tổng quan</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-box-seam-fill"></i>
          <p>
            Sản phẩm
            <i class="nav-arrow bi bi-chevron-right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('pos_productcategory_index') }}" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh mục sản phẩm</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('pos_productcategory_create') }}" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới danh mục</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('pos_product_index') }}" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách sản phẩm</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('pos_product_create') }}" class="nav-link">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới sản phẩm</p>
            </a>
          </li>
        </ul>
      </li>
      
    <!--end::Sidebar Menu-->
  </nav>
</div>
