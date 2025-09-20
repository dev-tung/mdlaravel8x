<div class="sidebar-wrapper">
  <nav class="mt-2">
    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
      
      <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'menu-open' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="nav-icon bi bi-speedometer"></i>
          <p>Tổng quan</p>
        </a>
      </li>

      <!-- Purchases -->
      <li class="nav-item {{ request()->routeIs('admin.imports.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('admin.imports.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-box-seam"></i>
          <p>Nhập hàng <i class="nav-arrow bi bi-chevron-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.imports.index') }}" class="nav-link {{ request()->routeIs('admin.imports.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.imports.create') }}" class="nav-link {{ request()->routeIs('admin.imports.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Products -->
      <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-box-seam-fill"></i>
          <p>Sản phẩm <i class="nav-arrow bi bi-chevron-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.products.create') }}" class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Suppliers -->
      <li class="nav-item {{ request()->routeIs('admin.suppliers.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-truck"></i>
          <p>Nhà cung cấp <i class="nav-arrow bi bi-chevron-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.suppliers.create') }}" class="nav-link {{ request()->routeIs('admin.suppliers.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Expenses -->
      <li class="nav-item {{ request()->routeIs('admin.expenses.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-cash-stack"></i>
          <p>Chi phí <i class="nav-arrow bi bi-chevron-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.expenses.index') }}" class="nav-link {{ request()->routeIs('admin.expenses.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.expenses.create') }}" class="nav-link {{ request()->routeIs('admin.expenses.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Orders -->
      <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-cart-check"></i>
          <p>Đơn hàng <i class="nav-arrow bi bi-chevron-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.orders.create') }}" class="nav-link {{ request()->routeIs('admin.orders.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Taxonomies -->
      <li class="nav-item {{ request()->routeIs('admin.taxonomies.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('admin.taxonomies.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-tags-fill"></i>
          <p>Danh mục <i class="nav-arrow bi bi-chevron-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.taxonomies.index') }}" class="nav-link {{ request()->routeIs('admin.taxonomies.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.taxonomies.create') }}" class="nav-link {{ request()->routeIs('admin.taxonomies.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Customers -->
      <li class="nav-item {{ request()->routeIs('admin.customers.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
          <i class="nav-icon bi bi-person-lines-fill"></i>
          <p>Khách hàng <i class="nav-arrow bi bi-chevron-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Danh sách</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.customers.create') }}" class="nav-link {{ request()->routeIs('admin.customers.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Thêm mới</p>
            </a>
          </li>
        </ul>
      </li>

    </ul>
  </nav>
</div>
