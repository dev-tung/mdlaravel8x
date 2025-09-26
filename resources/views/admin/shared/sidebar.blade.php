<div class="sidebar-wrapper">
  <nav class="mt-2">
    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
      
      <!-- Dashboard -->
      <!-- <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Tổng quan</p>
        </a>
      </li> -->

      <!-- Imports -->
      <li class="nav-item">
        <a href="{{ route('admin.imports.index') }}" class="nav-link {{ request()->routeIs('admin.imports.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-box-seam"></i>
          <p>Nhập hàng</p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.imports.index') }}" class="nav-link">
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.imports.create') }}" class="nav-link">
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Products -->
      <li class="nav-item">
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-box-seam-fill"></i>
          <p>Sản phẩm</p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link">
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.products.create') }}" class="nav-link">
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Suppliers -->
      <li class="nav-item">
        <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-truck"></i>
          <p>Nhà cung cấp</p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.suppliers.index') }}" class="nav-link">
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.suppliers.create') }}" class="nav-link">
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Expenses -->
      <li class="nav-item">
        <a href="{{ route('admin.expenses.index') }}" class="nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-cash-stack"></i>
          <p>Chi phí</p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.expenses.index') }}" class="nav-link">
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.expenses.create') }}" class="nav-link">
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Exports -->
      <li class="nav-item">
        <a href="{{ route('admin.exports.index') }}" class="nav-link {{ request()->routeIs('admin.exports.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-cart-check"></i>
          <p>Đơn hàng</p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.exports.index') }}" class="nav-link">
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.exports.create') }}" class="nav-link">
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Taxonomies -->
      <li class="nav-item">
        <a href="{{ route('admin.taxonomies.index') }}" class="nav-link {{ request()->routeIs('admin.taxonomies.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-tags-fill"></i>
          <p>Danh mục</p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.taxonomies.index') }}" class="nav-link">
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.taxonomies.create') }}" class="nav-link">
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Customers -->
      <li class="nav-item">
        <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-person-lines-fill"></i>
          <p>Khách hàng</p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.customers.index') }}" class="nav-link">
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.customers.create') }}" class="nav-link">
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

    </ul>
  </nav>
</div>
