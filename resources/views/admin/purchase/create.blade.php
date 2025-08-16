@extends('admin.shared.app')

@section('content')
<main class="app-main" id="main" tabindex="-1">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Thêm mới đơn nhập hàng</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm mới đơn nhập hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <form class="needs-validation" id="posPurchaseCreate" method="POST" novalidate>
                            @csrf
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="product_id" class="form-label small">Sản phẩm<span class="required-indicator sr-only"> (required)</span></label>
                                        <select class="form-select form-select-sm" id="product_id" name="product_id" required>
                                            <option selected disabled value="">Chọn sản phẩm...</option>
                                            <option value="1">Sản phẩm A</option>
                                            <option value="2">Sản phẩm B</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="supplier_id" class="form-label small">Nhà cung cấp<span class="required-indicator sr-only"> (required)</span></label>
                                        <select class="form-select form-select-sm" id="supplier_id" name="supplier_id" required>
                                            <option selected disabled value="">Chọn nhà cung cấp...</option>
                                            <option value="1">Công ty A</option>
                                            <option value="2">Công ty B</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="purchase_date" class="form-label small">Ngày nhập hàng<span class="required-indicator sr-only"> (required)</span></label>
                                        <input type="date" class="form-control form-control-sm" id="purchase_date" name="purchase_date" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label small">Số lượng<span class="required-indicator sr-only"> (required)</span></label>
                                        <input type="number" class="form-control form-control-sm" id="quantity" name="quantity" min="1" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="import_price" class="form-label small">Giá nhập (VNĐ)<span class="required-indicator sr-only"> (required)</span></label>
                                        <input type="number" class="form-control form-control-sm" id="import_price" name="import_price" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_cost" class="form-label small">Tổng tiền (VNĐ)</label>
                                        <input type="number" class="form-control form-control-sm" id="total_cost" name="total_cost" min="0" step="0.01" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success btn-sm" type="submit">Submit form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/shared/validation.js') }}"></script>
    <script src="{{ asset('js/admin/shared/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/pos/purchase/create.js') }}"></script>
@endpush
