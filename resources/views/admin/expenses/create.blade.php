@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0">Thêm mới chi phí</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.expenses.index') }}">Chi phí</a></li>
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
                        <form class="needs-validation" id="expenseCreateForm" method="POST" 
                              action="{{ route('admin.expenses.store') }}" novalidate>
                            @csrf
                            <div class="card-body">
                                <div class="row g-3">

                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label small">
                                            Tên chi phí <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="name" 
                                               name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Taxonomy -->
                                    <div class="col-md-6">
                                        <label for="taxonomy_id" class="form-label small">Loại chi phí <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="taxonomy_id" name="taxonomy_id">
                                            <option value="">-- Chọn loại --</option>
                                            @foreach($taxonomies as $taxonomy)
                                                <option value="{{ $taxonomy->id }}" 
                                                    {{ old('taxonomy_id') == $taxonomy->id ? 'selected' : '' }}>
                                                    {{ $taxonomy->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('taxonomy_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Amount -->
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label small">
                                            Số tiền <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" step="0.01" class="form-control form-control-sm" id="amount" 
                                               name="amount" value="{{ old('amount') }}" required>
                                        @error('amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Expense Date -->
                                    <div class="col-md-6">
                                        <label for="expense_date" class="form-label small">Ngày chi <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-sm" id="expense_date" 
                                               name="expense_date" value="{{ old('expense_date') }}">
                                        @error('expense_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Note -->
                                    <div class="col-md-12">
                                        <label for="note" class="form-label small">Ghi chú</label>
                                        <textarea class="form-control form-control-sm" id="note" 
                                                  name="note" rows="2">{{ old('note') }}</textarea>
                                        @error('note')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-success btn-sm" type="submit">Lưu chi phí</button>
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
<script src="{{ asset('js/admin/expenses/create.js') }}"></script>
@endpush
