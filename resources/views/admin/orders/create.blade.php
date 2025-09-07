@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Thêm mới đơn hàng</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
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
                    <form method="POST" action="{{ route('admin.orders.store') }}" id="orderCreateForm">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">

                                <!-- Khách hàng -->
                                <div class="col-md-6">
                                    <label for="customerSearch" class="form-label">Khách hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="customerSearch" placeholder="Tìm khách hàng..." autocomplete="off">
                                    <select class="form-select form-select-sm mt-1" id="customerSelect" size="5" style="display:none;"></select>
                                    <input type="hidden" name="customer_id" id="customer_id">
                                    @error('customer_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Ngày đơn hàng -->
                                <div class="col-md-6">
                                    <label for="order_date" class="form-label">Ngày đặt</label>
                                    <input type="date" name="order_date" id="order_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label small">Trạng thái</label>
                                    <select class="form-select form-select-sm" id="status" name="status">
                                        <option value="">-- Chọn trạng thái --</option>
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Phương thức thanh toán -->
                                <div class="col-md-6">
                                    <label for="payment_method" class="form-label small">Phương thức thanh toán</label>
                                    <select class="form-select form-select-sm" id="payment_method" name="payment_method">
                                        <option value="">-- Chọn phương thức --</option>
                                        @foreach($payments as $value => $label)
                                            <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Sản phẩm -->
                                <div class="col-md-12">
                                    <label for="productSearch" class="form-label">Thêm sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="productSearch" placeholder="Tìm sản phẩm...">
                                    <select class="form-select form-select-sm mt-1" id="productSelect" size="5" style="display:none;"></select>
                                    @error('product_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Table sản phẩm đã chọn -->
                                <div class="col-12 mt-2">
                                    <table class="table table-sm table-bordered mb-0 align-middle" id="productSelectedTable" style="display:none;">
                                        <thead class="table-light">
                                            <tr>
                                                <td>Tên sản phẩm</td>
                                                <td>Số lượng</td>
                                                <td class="text-center">Tặng kèm</td>
                                                <td>Giá bán</td>
                                                <td>Triết khấu</td>
                                                <td class="text-center">Hành động</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr class="form-label small">
                                                <td colspan="6" class="text-danger">Tổng <span id="totalAmount">0 ₫</span></td>
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
                            <button class="btn btn-success btn-sm" type="submit">Lưu đơn hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/admin/orders/create.js') }}"></script>
@endpush
