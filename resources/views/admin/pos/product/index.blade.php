@extends('admin.shared.app')
@section('content')
  <main class="app-main" id="main" tabindex="-1">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Danh sách sản phẩm</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Danh sách sản phẩm</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <form id="filterForm" class="row g-2">
                            <div class="col-md-2">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Tên sản phẩm">
                            </div>
                            <div class="col-md-2">
                                <select name="category_id" class="form-control form-control-sm">
                                    <option value="">-- Danh mục --</option>
                                    <option value="1">Áo</option>
                                    <option value="2">Quần</option>
                                    <option value="3">Giày</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">-- Trạng thái --</option>
                                    <option value="active">Đang bán</option>
                                    <option value="inactive">Ngừng bán</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá</th>
                                    <th>Giá sale</th>
                                    <th>Kho</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                <tr><td colspan="9" class="text-center">Đang tải dữ liệu...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul id="pagination" class="pagination pagination-sm m-0 float-end"></ul>
                    </div>
                </div>


            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/pos/product/index.js') }}"></script>
@endpush