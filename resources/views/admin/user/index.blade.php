@extends('admin.shared.app')
@section('content')
    <!-- Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách nhà cung cấp</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách nhà cung cấp</li>
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
                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Tên nhà cung cấp">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="phone" class="form-control form-control-sm" placeholder="Số điện thoại">
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
                                        <th>Tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                        <th>Địa chỉ</th>
                                        <th>Ngày tạo</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="supplierTableBody">
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
@endsection

@push('scripts')
<script src="{{ asset('js/admin/pos/supplier/index.js') }}"></script>
@endpush
