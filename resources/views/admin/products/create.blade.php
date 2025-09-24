@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center my-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Thêm mới sản phẩm</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
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
                    <form class="needs-validation" id="product-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Name -->
                                    <div class="col-md-4">
                                        <label for="name" class="form-label small">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="name" 
                                            name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Taxonomy -->
                                    <div class="col-md-4">
                                        <label for="taxonomy_id" class="form-label small">Danh mục <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="taxonomy_id" name="taxonomy_id">
                                            <option value="">-- Chọn --</option>
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

                                    <!-- Supplier -->
                                    <div class="col-md-4">
                                        <label for="supplier_id" class="form-label small">Nhà cung cấp <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="supplier_id" name="supplier_id">
                                            <option value="">-- Chọn --</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" 
                                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Thumbnail_image -->
                                    <div class="col-md-3">
                                        <label for="thumbnail-image" class="form-label small">Ảnh sản phẩm</label>
                                        <input type="file" class="form-control form-control-sm" id="thumbnail-image" name="thumbnail_image" accept="image/*">
                                        <img id="thumbnail-image-preview" src="#" alt="Preview" style="display:none; max-height: 100px; margin-top:10px;">
                                        @error('thumbnail_image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Price Original -->
                                    <div class="col-md-3">
                                        <label for="price_original" class="form-label small">Giá gốc <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" id="price_original" name="price_original" value="{{ old('price_original') }}">
                                        @error('price_original')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Price Sale -->
                                    <div class="col-md-3">
                                        <label for="price_sale" class="form-label small">Giá bán <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" id="price_sale" name="price_sale" value="{{ old('price_sale') }}">
                                        @error('price_sale')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Unit -->
                                    <div class="col-md-3">
                                        <label for="unit" class="form-label small">Đơn vị <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="unit" 
                                            name="unit" value="{{ old('unit') }}">
                                        @error('unit')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>



                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label small">Mô tả</label>
                                        <textarea class="form-control form-control-sm" id="description" 
                                                name="description" rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-outline-primary btn-sm" type="submit">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/admin/handlers/products/FormHandler.js') }}"></script>
@endpush
