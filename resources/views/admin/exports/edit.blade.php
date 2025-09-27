@extends('admin.shared.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center my-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Chỉnh sửa đơn hàng</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.exports.index') }}">đơn hàng</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <form method="POST" action="{{ route('admin.exports.update', $export->id) }}" id="export-form">
                        @csrf
                        @method('PUT')
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Sản phẩm -->
                                    <div class="col-md-12 position-relative DropdownInput">
                                        <label for="product-search" class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="product-search" placeholder="Tìm sản phẩm..." autocomplete="off">
                                        
                                        <select class="form-select form-select-sm mt-1 position-absolute DropdownInputSelect" id="product-select" size="5">
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
                                                    <th>Giá bán</th>
                                                    <th>Triết khấu</th>
                                                    <th class="text-center">Quà tặng</th>
                                                    <th class="text-center">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- JS ProductExportSelector sẽ load existing products từ $export->items --}}
                                            </tbody>
                                            <tfoot>
                                                <tr class="form-label small">
                                                    <td colspan="4" class="text-danger">
                                                        Tổng <span id="total-export-amount">{{ number_format($export->total_export_amount,0,',','.') }} ₫</span>
                                                        <input type="hidden" name="total_export_amount" id="total-export-amount-input" value="{{ $export->total_export_amount }}">
                                                    </td>
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
                                    <!-- Khách hàng -->
                                    <div class="col-md-6 position-relative DropdownInput">
                                        <label for="customer-search" class="form-label">
                                            Khách hàng <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" class="form-control form-control-sm" 
                                            id="customer-search" 
                                            name="customer_search" 
                                            placeholder="Tìm khách hàng..." 
                                            value="{{ old('customer_search', $export->customer->name) }}"
                                            autocomplete="off">

                                        <select class="form-select form-select-sm mt-1 position-absolute DropdownInputSelect" 
                                                id="customer-select" size="5">
                                            <!-- JS bind data -->
                                        </select>

                                        <input type="hidden" name="customer_id" id="customer-id" value="{{ old('customer_id', $export->customer_id) }}">

                                        @error('customer_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Ngày đơn hàng -->
                                    <div class="col-md-6">
                                        <label for="export-date" class="form-label">Ngày lập</label>
                                        <input type="date" name="export_date" id="export-date" class="form-control form-control-sm" 
                                               value="{{ old('export_date', $export->export_date->format('Y-m-d')) }}">
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="status" name="status">
                                            <option value="">-- Chọn --</option>
                                            @foreach($statuses as $value => $label)
                                                <option value="{{ $value }}" @selected(old('status', $export->status) == $value)>
                                                    {{ $label }}
                                                </option>
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
                                                <option value="{{ $value }}" @selected(old('payment_method', $export->payment_method) == $value)>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('payment_method')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Ghi chú -->
                                    <div class="col-md-12">
                                        <label for="notes" class="form-label">Ghi chú</label>
                                        <input type="text" name="notes" id="notes" class="form-control form-control-sm" 
                                               value="{{ old('notes', $export->notes) }}" placeholder="Ghi chú...">
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
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/admin/handlers/exports/FormHandler.js') }}"></script>
@endpush
