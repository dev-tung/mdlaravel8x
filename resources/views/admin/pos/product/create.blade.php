@extends('admin.layouts.app')

@section('content')
  <main class="app-main" id="main" tabindex="-1">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Thêm mới sản phẩm</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Thêm mới sản phẩm</li>
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
            <div class="row g-4">
              <!--begin::Col-->
              <div class="col-12">
                <!--begin::Form Validation-->
                <div class="card mb-4">
                  <!--begin::Form-->
                    <form class="needs-validation" id="posProductCreate" action="{{route('pos_product_store')}}" method="POST" novalidate>
                        @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Row-->
                        <div class="row g-3">

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="name" class="form-label small">Tên sản phẩm<span class="required-indicator sr-only"> (required)</span></label>
                            <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="category_id" class="form-label small">Danh mục sản phẩm<span class="required-indicator sr-only"> (required)</span></label>
                            <select class="form-select form-select-sm" id="category_id" name="category_id" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="1">Điện thoại</option>
                            <option value="2">Laptop</option>
                            <option value="3">Phụ kiện</option>
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="slug" class="form-label small">Slug<span class="required-indicator sr-only"> (required)</span></label>
                            <input type="text" class="form-control form-control-sm" id="slug" name="slug" placeholder="Nhập slug" required>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-3">
                            <label for="price" class="form-label small">Giá gốc (VNĐ)<span class="required-indicator sr-only"> (required)</span></label>
                            <input type="number" class="form-control form-control-sm" id="price" name="price" min="0" placeholder="Nhập giá gốc" required>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-3">
                            <label for="sale_price" class="form-label small">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" class="form-control form-control-sm" id="sale_price" name="sale_price" min="0" placeholder="Nhập giá khuyến mãi">
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-3">
                            <label for="stock" class="form-label small">Số lượng tồn kho<span class="required-indicator sr-only"> (required)</span></label>
                            <input type="number" class="form-control form-control-sm" id="stock" name="stock" min="0" placeholder="Nhập số lượng tồn kho" required>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-3">
                            <label for="status" class="form-label small">Trạng thái</label>
                            <select class="form-select form-select-sm" id="status" name="status">
                            <option value="1" selected>Hiển thị</option>
                            <option value="0">Ẩn</option>
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-12">
                            <label for="short_description" class="form-label small">Mô tả ngắn</label>
                            <textarea class="form-control form-control-sm" id="short_description" name="short_description" rows="3" placeholder="Nhập mô tả ngắn"></textarea>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-12">
                            <label for="description" class="form-label small">Mô tả chi tiết</label>
                            <textarea class="form-control form-control-sm" id="description" name="description" rows="5" placeholder="Nhập mô tả chi tiết"></textarea>
                        </div>
                        <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Body-->

                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button class="btn btn-success btn-sm" type="submit">Submit form</button>
                    </div>
                    <!--end::Footer-->
                    </form>

                  <!--end::Form-->

                </div>
                <!--end::Form Validation-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/validation.js') }}"></script>
    <script src="{{ asset('js/admin/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/pos/product/create.js') }}"></script>
@endpush