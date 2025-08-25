@extends('admin.shared.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Thêm mới nhà cung cấp</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm mới nhà cung cấp</li>
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
                        <form class="needs-validation" id="posSupplierCreate" method="POST" novalidate>
                            @csrf
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label small">Tên nhà cung cấp<span class="required-indicator sr-only"> (required)</span></label>
                                        <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label small">Số điện thoại<span class="required-indicator sr-only"> (required)</span></label>
                                        <input type="text" class="form-control form-control-sm" id="phone" name="phone" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label small">Email</label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label small">Địa chỉ</label>
                                        <input type="text" class="form-control form-control-sm" id="address" name="address">
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
@endsection

@push('scripts')
    <script src="{{ asset('js/shared/validation.js') }}"></script>
    <script src="{{ asset('js/admin/shared/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/pos/supplier/create.js') }}"></script>
@endpush
