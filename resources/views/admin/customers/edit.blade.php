@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Sửa khách hàng</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Khách hàng</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sửa</li>
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
                        <form class="needs-validation" id="customerEditForm" method="POST" 
                              action="{{ route('admin.customers.update', $customer->id) }}" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label small">Tên khách hàng <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <!-- Group -->
                                    <div class="col-md-6">
                                        <label for="taxonomy_id" class="form-label small">Nhóm khách hàng</label>
                                        <select class="form-select form-select-sm" id="taxonomy_id" name="taxonomy_id">
                                            <option value="">-- Chọn nhóm --</option>
                                            @foreach($taxonomies as $taxonomy)
                                                <option value="{{ $taxonomy->id }}" {{ old('taxonomy_id', $customer->taxonomy_id) == $taxonomy->id ? 'selected' : '' }}>
                                                    {{ $taxonomy->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('taxonomy_id')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-4">
                                        <label for="email" class="form-label small">Email</label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ old('email', $customer->email) }}">
                                        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label small">Số điện thoại</label>
                                        <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                                        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="col-md-4">
                                        <label for="password" class="form-label small">Mật khẩu <small>(Để trống nếu không đổi)</small></label>
                                        <input type="password" class="form-control form-control-sm" id="password" name="password">
                                        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-12">
                                        <label for="address" class="form-label small">Địa chỉ</label>
                                        <textarea class="form-control form-control-sm" id="address" name="address" rows="2">{{ old('address', $customer->address) }}</textarea>
                                        @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-success btn-sm" type="submit">Cập nhật khách hàng</button>
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
<script src="{{ asset('js/admin/customers/edit.js') }}"></script>
@endpush
