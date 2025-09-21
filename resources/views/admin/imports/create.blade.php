@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row align-items-center my-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Nhập hàng mới</h3>
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
                    <form method="POST" action="{{ route('admin.imports.store') }}" id="importCreateForm">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">
                                <!-- Sản phẩm -->
                                    <div class="col-md-12 position-relative DropdownInput">
                                        <label for="productSearch" class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="productSearch" placeholder="Tìm sản phẩm..." autocomplete="off">
                                        
                                        <select class="form-select form-select-sm mt-1 position-absolute DropdownInput-Select" 
                                                id="productSelect" 
                                                size="5" >
                                            <!-- JS sẽ bind data vào đây -->
                                        </select>

                                        @error('product_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <!-- Table sản phẩm đã chọn -->
                                    <div class="col-12 mt-2">
                                        <table class="table table-sm table-bordered table-striped mb-0 align-middle ProductSelectedTable" id="productSelectedTable" style="display:none;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Giá nhập</th>
                                                    <th class="text-center">Hành động</th>
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
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">


                                    <!-- Nhà cung cấp -->
                                    <div class="col-md-6 position-relative DropdownInput">
                                        <label for="supplierSearch" class="form-label">Nhà cung cấp <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="supplierSearch" name="supplier_search" placeholder="Tìm nhà cung cấp..." autocomplete="off">
                                        
                                        <select class="form-select form-select-sm mt-1 position-absolute DropdownInput-Select" 
                                                id="supplierSelect" 
                                                size="5" >
                                            <!-- JS sẽ bind data vào đây -->
                                        </select>

                                        <input type="hidden" name="supplier_id" id="supplier_id">

                                        @error('supplier_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>



                                    <!-- Ngày nhập hàng -->
                                    <div class="col-md-6">
                                        <label for="import_date" class="form-label">Ngày nhập</label>
                                        <input type="date" name="import_date" id="import_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                    </div>


                                    <!-- Trạng thái -->
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
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

                                    <!-- Ghi chú -->
                                    <div class="col-md-6">
                                        <label for="notes" class="form-label">Ghi chú</label>
                                        <input type="text" name="notes" id="notes" class="form-control form-control-sm">
                                    </div>
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
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/admin/imports/create.js') }}"></script>
@endpush
