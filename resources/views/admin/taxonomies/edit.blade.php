@extends('admin.shared.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Sửa taxonomy</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.taxonomies.index') }}">Taxonomies</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sửa</li>
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
                        <form class="needs-validation" id="taxonomyEditForm" method="POST" 
                              action="{{ route('admin.taxonomies.update', $taxonomy->id) }}" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label small">
                                            Tên taxonomy <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="name" 
                                               name="name" value="{{ old('name', $taxonomy->name) }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Slug -->
                                    <div class="col-md-6">
                                        <label for="slug" class="form-label small">
                                            Slug
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="slug" 
                                               name="slug" value="{{ old('slug', $taxonomy->slug) }}" required>
                                        @error('slug')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Parent -->
                                    <div class="col-md-6">
                                        <label for="parent_id" class="form-label small">
                                            Taxonomy cha
                                        </label>
                                        <select class="form-select form-select-sm" id="parent_id" name="parent_id">
                                            <option value="">-- Không có --</option>
                                            @foreach($taxonomies as $t)
                                                @if($t->id !== $taxonomy->id)
                                                    <option value="{{ $t->id }}" 
                                                        {{ old('parent_id', $taxonomy->parent_id) == $t->id ? 'selected' : '' }}>
                                                        {{ $t->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Type -->
                                    <div class="col-md-6">
                                        <label for="type" class="form-label small">
                                            Loại taxonomy <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select form-select-sm" id="type" name="type" required>
                                            @foreach($types as $key => $label)
                                                <option value="{{ $key }}" 
                                                    {{ old('type', $taxonomy->type) == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <label for="status" class="form-label small">
                                            Trạng thái <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select form-select-sm" id="status" name="status" required>
                                            <option value="active" {{ old('status', $taxonomy->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="inactive" {{ old('status', $taxonomy->status) == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                        </select>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label small">Mô tả</label>
                                        <textarea class="form-control form-control-sm" id="description" 
                                                  name="description" rows="3">{{ old('description', $taxonomy->description) }}</textarea>
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success btn-sm" type="submit">Cập nhật taxonomy</button>
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
    <script src="{{ asset('js/admin/taxonomies/edit.js') }}"></script>
@endpush
