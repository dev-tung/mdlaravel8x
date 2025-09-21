@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row align-items-center my-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Thêm nhập hàng</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.imports.index') }}">Nhập hàng</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-4">
                    <form method="POST" action="{{ route('admin.imports.store') }}" id="purchaseCreateForm">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">

                                <!-- Nhà cung cấp -->
                                <div class="col-md-6">
                                    <label for="supplierSearch" class="form-label">Nhà cung cấp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="supplierSearch" placeholder="Tìm nhà cung cấp..." autocomplete="off">
                                    <select class="form-select form-select-sm mt-1" id="supplierSelect" size="5" style="display:none;"></select>
                                    <input type="hidden" name="supplier_id" id="supplier_id">
                                    @error('supplier_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Ngày nhập hàng -->
                                <div class="col-md-6">
                                    <label for="purchase_date" class="form-label">Ngày nhập</label>
                                    <input type="date" name="purchase_date" id="purchase_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                </div>

                                <!-- Sản phẩm -->
                                <div class="col-md-6">
                                    <label for="productSearch" class="form-label">Thêm sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="productSearch" placeholder="Tìm sản phẩm..." autocomplete="off">
                                    <select class="form-select form-select-sm mt-1" id="productSelect" size="5" style="display:none;"></select>
                                    @error('product_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select form-select-sm" id="status" name="status">
                                        <option value="">-- Chọn trạng thái --</option>
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Table sản phẩm đã chọn -->
                                <div class="col-12 mt-2">
                                    <table class="table table-sm table-bordered mb-0 align-middle" id="productSelectedTable" style="display:none;">
                                        <thead class="table-light">
                                            <tr>
                                                <td>Tên sản phẩm</td>
                                                <td style="width:130px;">Số lượng</td>
                                                <td style="width:220px;">Giá nhập</td>
                                                <td class="text-center" style="width:90px;">Hành động</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr class="form-label small">
                                                <td colspan="4" class="text-danger">Tổng <span id="totalAmount">0 ₫</span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Ghi chú -->
                                <div class="col-md-12">
                                    <label for="notes" class="form-label">Ghi chú</label>
                                    <input type="text" name="notes" id="notes" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-outline-primary btn-sm" type="submit">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/admin/imports/create.js') }}"></script>
@endpush
