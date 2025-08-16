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
        <a href="{{ route('admin.dashboard.index') }}" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Tổng quan</p>
        </a>
      </li>
      
<!-- Products -->
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
            <a href="{{ route('admin.products.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.products.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Purchases -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-receipt"></i>
        <p>
            Phiếu nhập
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.purchases.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.purchases.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Suppliers -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-truck"></i>
        <p>
            Nhà cung cấp
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.suppliers.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.suppliers.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Expenses -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-cash-stack"></i>
        <p>
            Chi phí
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.expenses.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.expenses.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Orders -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-cart-check"></i>
        <p>
            Đơn hàng
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Product Categories -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-tags-fill"></i>
        <p>
            Loại sản phẩm
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.taxonomies.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.taxonomies.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Customers -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-person-lines-fill"></i>
        <p>
            Khách hàng
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.customers.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.customers.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Users -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon bi bi-people-fill"></i>
        <p>
            Người dùng
            <i class="nav-arrow bi bi-chevron-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </u
