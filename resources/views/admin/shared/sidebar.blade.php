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
        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Tổng quan</p>
        </a>
      </li>
<!-- Product -->
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
            <a href="{{ route('pos.product.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.product.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Purchase -->
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
            <a href="{{ route('pos.purchase.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.purchase.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Supplier -->
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
            <a href="{{ route('pos.supplier.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.supplier.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Expense -->
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
            <a href="{{ route('pos.expense.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.expense.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Order -->
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
            <a href="{{ route('pos.order.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.order.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Product Category -->
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
            <a href="{{ route('pos.product_category.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.product_category.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- Customer -->
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
            <a href="{{ route('pos.customer.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.customer.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

<!-- User -->
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
            <a href="{{ route('pos.user.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pos.user.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm mới</p>
            </a>
        </li>
    </ul>
</li>

    <!--end::Sidebar Menu-->
  </nav>
</div>
