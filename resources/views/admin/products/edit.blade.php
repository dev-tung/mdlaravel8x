@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0">Chỉnh sửa sản phẩm</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
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
                        <form class="needs-validation" id="productEditForm" method="POST" 
                              action="{{ route('admin.products.update', $product->id) }}" 
                              enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row g-3">

                                    <!-- Name -->
                                    <div class="col-md-4">
                                        <label for="name" class="form-label small">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="name" 
                                               name="name" value="{{ old('name', $product->name) }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Taxonomy -->
                                    <div class="col-md-4">
                                        <label for="taxonomy_id" class="form-label small">Danh mục</label>
                                        <select class="form-select form-select-sm" id="taxonomy_id" name="taxonomy_id">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($taxonomies as $taxonomy)
                                                <option value="{{ $taxonomy->id }}" 
                                                    {{ old('taxonomy_id', $product->taxonomy_id) == $taxonomy->id ? 'selected' : '' }}>
                                                    {{ $taxonomy->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('taxonomy_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Supplier -->
                                    <div class="col-md-4">
                                        <label for="supplier_id" class="form-label small">Nhà cung cấp</label>
                                        <select class="form-select form-select-sm" id="supplier_id" name="supplier_id">
                                            <option value="">-- Chọn NCC --</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" 
                                                    {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Price Output -->
                                    <div class="col-md-4">
                                        <label for="price_output" class="form-label small">Giá bán</label>
                                        <input type="number" class="form-control form-control-sm" id="price_output" 
                                               name="price_output" value="{{ old('price_output', $product->price_output) }}">
                                        @error('price_output')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Unit -->
                                    <div class="col-md-4">
                                        <label for="unit" class="form-label small">Đơn vị</label>
                                        <input type="text" class="form-control form-control-sm" id="unit" 
                                               name="unit" value="{{ old('unit', $product->unit) }}">
                                        @error('unit')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Thumbnail -->
                                    <div class="col-md-12">
                                        <label for="thumbnail" class="form-label small">Ảnh sản phẩm</label>
                                        <input type="file" class="form-control form-control-sm" id="thumbnail" name="thumbnail" accept="image/*">
                                        <img 
                                            id="thumbnail-preview" alt="Preview" 
                                            src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/150x150?text=No+Image' }}"  
                                            style="max-height: 150px; margin-top:10px;">
                                            
                                        @error('thumbnail')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label small">Mô tả</label>
                                        <textarea class="form-control form-control-sm" id="description" 
                                                  name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-primary btn-sm" type="submit">Cập nhật sản phẩm</button>
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
<script src="{{ asset('js/admin/products/edit.js') }}"></script>
@endpush
