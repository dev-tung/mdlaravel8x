@extends('admin.shared.app')

@section('content')
<main class="app-main" id="main" tabindex="-1">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Sửa sản phẩm</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sửa sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <form class="needs-validation" id="productEditForm" method="POST" 
                              action="{{ route('admin.products.update', $product->id) }}" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row g-3">

                                    <!-- Name -->
                                    <div class="col-md-4">
                                        <label for="name" class="form-label small">
                                            Tên sản phẩm <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="name" 
                                               name="name" value="{{ old('name', $product->name) }}" required>
                                    </div>

                                    <!-- Taxonomy -->
                                    <div class="col-md-4">
                                        <label for="taxonomy_id" class="form-label small">
                                            Danh mục sản phẩm
                                        </label>
                                        <select class="form-select form-select-sm" id="taxonomy_id" name="taxonomy_id">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($taxonomies as $taxonomy)
                                                <option value="{{ $taxonomy->id }}" 
                                                    {{ old('taxonomy_id', $product->taxonomy_id) == $taxonomy->id ? 'selected' : '' }}>
                                                    {{ $taxonomy->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-4">
                                        <label for="price" class="form-label small">
                                            Giá gốc (VNĐ) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control form-control-sm" id="price" 
                                               name="price" value="{{ old('price', $product->price) }}" min="0" required>
                                    </div>

                                    <!-- Sale Price -->
                                    <div class="col-md-4">
                                        <label for="sale_price" class="form-label small">
                                            Giá khuyến mãi (VNĐ)
                                        </label>
                                        <input type="number" class="form-control form-control-sm" id="sale_price" 
                                               name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0">
                                    </div>

                                    <!-- Stock -->
                                    <div class="col-md-4">
                                        <label for="stock" class="form-label small">
                                            Số lượng tồn kho <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control form-control-sm" id="stock" 
                                               name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-4">
                                        <label for="status" class="form-label small">
                                            Trạng thái
                                        </label>
                                        <select class="form-select form-select-sm" id="status" name="status">
                                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                        </select>
                                    </div>

                                    <!-- Short Description -->
                                    <div class="col-md-12">
                                        <label for="short_description" class="form-label small">
                                            Mô tả ngắn
                                        </label>
                                        <textarea class="form-control form-control-sm" id="short_description" 
                                                  name="short_description" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label small">
                                            Mô tả chi tiết
                                        </label>
                                        <textarea class="form-control form-control-sm" id="description" 
                                                  name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-success btn-sm" type="submit">Cập nhật sản phẩm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/shared/validation.js') }}"></script>
    <script src="{{ asset('js/admin/shared/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/pos/product/edit.js') }}"></script>
@endpush
