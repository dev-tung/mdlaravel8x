@extends('admin.shared.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center my-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Chỉnh sửa phiếu nhập hàng</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.exports.index') }}">Nhập hàng</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('admin.exports.update', $export->id) }}" id="export-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="export-id" name="export_id" value="{{ $export->id ?? '' }}">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Sản phẩm -->
                            <div class="col-md-12 position-relative DropdownInput">
                                <label for="product-search" class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="product-search" placeholder="Tìm sản phẩm..." autocomplete="off">
                                <select class="form-select form-select-sm mt-1 position-absolute DropdownInput-Select" id="product-select" size="5">
                                    <!-- JS sẽ bind data vào đây -->
                                </select>
                                @error('product_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Table sản phẩm đã chọn -->
                            <div class="col-12 mt-2">
                                <table class="table table-sm table-bordered table-striped mb-0 align-middle ProductSelectedTable" id="product-selected-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá nhập</th>
                                            <th class="text-center">Quà tặng</th>
                                            <th class="text-center">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr class="form-label small">
                                            <td colspan="4" class="text-danger">Tổng <span id="total-export-amount">0 ₫</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Nhà cung cấp -->
                            <div class="col-md-6 position-relative DropdownInput">
                                <label for="supplier-search" class="form-label">Nhà cung cấp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="supplier-search" name="supplier_search" value="{{ $export->supplier->name }}" placeholder="Tìm nhà cung cấp..." autocomplete="off">
                                <select class="form-select form-select-sm mt-1 position-absolute DropdownInput-Select" id="supplier-select" size="5">
                                    <!-- JS sẽ bind data vào đây -->
                                </select>
                                <input type="hidden" name="supplier_id" id="supplier-id" value="{{ $export->supplier_id }}">
                                @error('supplier_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Ngày nhập hàng -->
                            <div class="col-md-6">
                                <label for="export-date" class="form-label">Ngày nhập</label>
                                <input type="date" name="export_date" id="export-date" class="form-control form-control-sm" value="{{ old('export_date', $export->export_date->format('Y-m-d')) }}">
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="status" name="status">
                                    <option value="">-- Chọn --</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ old('status', $export->status) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Phương thức thanh toán -->
                            <div class="col-md-6">
                                <label for="payment-method" class="form-label">Phương thức thanh toán <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="payment-method" name="payment_method">
                                    <option value="">-- Chọn --</option>
                                    @foreach($payments as $value => $label)
                                        <option value="{{ $value }}" {{ old('payment_method', $export->payment_method) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Ghi chú -->
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Ghi chú</label>
                                <input type="text" name="notes" id="notes" class="form-control form-control-sm" value="{{ old('notes', $export->notes) }}" placeholder="Ghi chú...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-outline-primary btn-sm" type="submit">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/admin/handlers/exports/FormHandler.js') }}"></script>
@endpush
