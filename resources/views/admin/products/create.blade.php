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
            <div class="row g-2">
                <div class="col-12">
                    <form class="needs-validation" id="product-create-form" method="POST"
                          action="{{ route('admin.products.store') }}"
                          enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <!-- LEFT -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Name -->
                                            <div class="col-md-12">
                                                <label for="name" class="form-label small">Tên sản phẩm <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ old('name') }}" required>
                                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <!-- Short Description -->
                                            <div class="col-md-12">
                                                <label for="short-description" class="form-label small">Mô tả ngắn</label>
                                                <textarea class="form-control form-control-sm" id="short-description" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                                                @error('short_description') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <!-- Description -->
                                            <div class="col-md-12">
                                                <label for="description" class="form-label small">Mô tả</label>
                                                <textarea class="form-control form-control-sm" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Variants -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4>Biến thể sản phẩm</h4>
                                            <button type="button" id="add-variant" class="btn btn-sm btn-outline-secondary mt-2">+ Thêm</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="variants-wrapper">
                                            <div class="row g-2 mb-3 variant-row bg-secondary bg-opacity-10 p-2 rounded">
                                                <div class="mt-0 mx-0 col-auto">
                                                    <label class="form-label small">Ảnh</label>
                                                    <button class="btn btn-sm btn-outline-secondary d-block">(0) files</button>
                                                </div>
                                                <div class="mt-0 mx-0 col">
                                                    <label class="form-label small">Màu sắc</label>
                                                    <select name="variants[0][color]" class="form-control form-control-sm">
                                                        <option value="">-- Màu --</option>
                                                        @foreach(taxonomies('color') as $taxonomy)
                                                            <option value="{{ $taxonomy->id }}">{{ $taxonomy->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mt-0 mx-0 col">
                                                    <label class="form-label small">Size</label>
                                                    <select name="variants[0][size]" class="form-control form-control-sm">
                                                        <option value="">-- Size --</option>
                                                        @foreach(taxonomies('size') as $taxonomy)
                                                            <option value="{{ $taxonomy->id }}">{{ $taxonomy->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mt-0 mx-0 col">
                                                    <label class="form-label small">Giá nhập</label>
                                                    <input type="number" name="variants[0][import_price]" class="form-control form-control-sm">
                                                </div>
                                                <div class="mt-0 mx-0 col">
                                                    <label class="form-label small">Giá bán gốc</label>
                                                    <input type="number" name="variants[0][price_original]" class="form-control form-control-sm">
                                                </div>
                                                <div class="mt-0 mx-0 col">
                                                    <label class="form-label small">Giá bán</label>
                                                    <input type="number" name="variants[0][price_sale]" class="form-control form-control-sm">
                                                </div>
                                                <div class="mt-0 mx-0 col">
                                                    <label class="form-label small">Số lượng</label>
                                                    <input type="number" name="variants[0][quantity]" class="form-control form-control-sm">
                                                </div>
                                                <div class="mt-0 mx-0 col-auto">
                                                    <label class="form-label small">Action</label>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-variant d-block">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Supplier -->
                                            <div class="col-md-12">
                                                <label for="supplier_id" class="form-label small">Nhà cung cấp <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-sm" id="supplier_id" name="supplier_id" required>
                                                    <option value="">-- Chọn --</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                            {{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('supplier_id') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>

                                            <!-- Taxonomy -->
                                            <div class="col-md-12">
                                                <label for="taxonomy_id" class="form-label small">Danh mục <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-sm" id="taxonomy_id" name="taxonomy_id" required>
                                                    <option value="">-- Chọn --</option>
                                                    @foreach(taxonomies('product') as $taxonomy)
                                                        <option value="{{ $taxonomy->id }}" {{ old('taxonomy_id') == $taxonomy->id ? 'selected' : '' }}>
                                                            {{ $taxonomy->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('taxonomy_id') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>

                                            <!-- Unit -->
                                            <div class="col-md-12">
                                                <label for="unit" class="form-label small">Đơn vị</label>
                                                <select class="form-select form-select-sm" id="unit" name="unit" required>
                                                    <option value="">-- Chọn --</option>
                                                    @foreach(taxonomies('unit') as $taxonomy)
                                                        <option value="{{ $taxonomy->id }}" {{ old('unit') == $taxonomy->id ? 'selected' : '' }}>
                                                            {{ $taxonomy->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('unit') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>

                                            <!-- Thumbnail -->
                                            <div class="col-md-12">
                                                <label for="thumbnail-image" class="form-label small">Ảnh sản phẩm</label>
                                                <input type="file" class="form-control form-control-sm" id="thumbnail-image" name="thumbnail_image" accept="image/*" multiple>
                                                <img id="thumbnail-image-preview" class="ProductThumnailPreview" src="{{ display_thumbnail(null) }}" alt="Preview">
                                                @error('thumbnail_image') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="card-footer">
                            <button class="btn btn-outline-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module" src="{{ asset('js/admin/handlers/products/CreateFormHandler.js') }}"></script>
@endpush
