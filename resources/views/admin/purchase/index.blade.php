@extends('admin.shared.app')
@section('content')
<main class="app-main" id="main" tabindex="-1">
    <!-- Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách phiếu nhập</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách phiếu nhập</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <form id="filterForm" class="row g-2">
                                <div class="col-md-3">
                                    <input type="text" name="invoice_code" class="form-control form-control-sm" placeholder="Mã đơn nhập">
                                </div>
                                <div class="col-md-3">
                                    <select name="supplier_id" class="form-control form-control-sm">
                                        <option value="">-- Nhà cung cấp --</option>
                                        <option value="1">Công ty A</option>
                                        <option value="2">Công ty B</option>
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
                                        <th>Mã đơn</th>
                                        <th>Nhà cung cấp</th>
                                        <th>Ngày nhập</th>
                                        <th>Tổng tiền</th>
                                        <th>Ghi chú</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseTableBody">
                                    <tr><td colspan="7" class="text-center">Đang tải dữ liệu...</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <ul id="pagination" class="pagination pagination-sm m-0 float-end"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/pos/purchase/index.js') }}"></script>
@endpush
