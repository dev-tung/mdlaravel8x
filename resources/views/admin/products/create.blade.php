@extends('admin.shared.app')

@section('content')
<main class="app-main" id="main" tabindex="-1">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Thêm mới sản phẩm</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Thêm mới sản phẩm</li>
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
                        <form id="productCreateForm" method="POST" action="{{ route('admin.products.store') }}" novalidate>
                            @csrf
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label for="name" class="form-label small">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="taxonomy_id" class="form-label small">Danh mục sản phẩm <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="taxonomy_id" name="taxonomy_id" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($taxonomies as $taxonomy)
                                                <option value="{{ $taxonomy->id }}" {{ old('taxonomy_id') == $taxonomy->id ? 'selected' : '' }}>
                                                    {{ $taxonomy->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('taxonomy_id')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="price" class="form-label small">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" id="price" name="price" min="0" value="{{ old('price') }}" required>
                                        @error('price')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="sale_price" class="form-label small">Giá khuyến mãi (VNĐ)</label>
                                        <input type="number" class="form-control form-control-sm" id="sale_price" name="sale_price" min="0" value="{{ old('sale_price') }}">
                                        @error('sale_price')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="stock" class="form-label small">Số lượng tồn kho <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" id="stock" name="stock" min="0" value="{{ old('stock') }}" required>
                                        @error('stock')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="status" class="form-label small">Trạng thái</label>
                                        <select class="form-select form-select-sm" id="status" name="status">
                                            <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Hiển thị</option>
                                            <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Ẩn</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="short_description" class="form-label small">Mô tả ngắn</label>
                                        <textarea class="form-control form-control-sm" id="short_description" name="short_description" rows="3">{{ old('short_description') }}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="description" class="form-label small">Mô tả chi tiết</label>
                                        <textarea class="form-control form-control-sm" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-success btn-sm" type="submit">Lưu sản phẩm</button>
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
    <script src="{{ asset('js/admin/pos/product/create.js') }}"></script>
@endpush
