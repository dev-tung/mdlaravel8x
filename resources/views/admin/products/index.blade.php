@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center my-2">
                <div class="col-auto">
                    <h3>{{ $products->total() }} sản phẩm</h3>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary btn-sm">
                        + Thêm mới
                    </a>
                </div>  
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <!-- Filter Form -->
                        <div class="card-header">
                            <form id="filterForm" class="row g-2" method="GET" action="{{ route('admin.products.index') }}">
                                <div class="col-auto">
                                    <input type="text" name="name" class="form-control form-control-sm"
                                           placeholder="Tên sản phẩm" value="{{ request('name') }}">
                                </div>
                                <div class="col-auto">
                                    <select name="supplier_id" class="form-control form-control-sm">
                                        <option value="">-- Nhà cung cấp --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select name="taxonomy_id" class="form-control form-control-sm">
                                        <option value="">-- Danh mục --</option>
                                        @foreach($taxonomies as $taxonomy)
                                            <option value="{{ $taxonomy->id }}" {{ request('taxonomy_id') == $taxonomy->id ? 'selected' : '' }}>
                                                {{ $taxonomy->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm mr-2 px-4">Lọc</button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>SKU</th>
                                        <th>Ảnh</th>
                                        <th>Tên</th>
                                        <th>Nhóm</th>
                                        <th>Nhà cung cấp</th>
                                        <th>Số lượng</th>
                                        <th>Giá nhập</th>
                                        <th>Giá gốc</th>
                                        <th>Giá bán</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr data-product-id="{{ $product->id }}" data-href="{{ route('admin.products.edit', $product->id) }}">
                                            <td>{{ $product->sku }}</td>
                                            <td class="NoBubble">
                                                <a href="{{ HPdisplayThumnail($product->thumbnail_image) }}" target="_blank">
                                                    <img id="thumbnail-preview" alt="Preview" src="{{ HPdisplayThumnail($product->thumbnail_image) }}" target="_blank" style="height: 18px">
                                                </a>
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->taxonomy->name ?? '-' }}</td>
                                            <td>{{ $product->supplier->name ?? '-' }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ HPformatCurrency($product->import_price) }}</td>
                                            <td>{{ HPformatCurrency($product->price_original) }}</td>
                                            <td>{{ HPformatCurrency($product->price_sale) }}</td>
                                            <td class="NoBubble text-center">
                                                <a class="btn btn-outline-primary btn-sm px-2 py-1 mr-3" href="{{ route('admin.products.edit', $product->id) }}">Sửa</a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="NoBubble d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm px-2 py-1" onclick="return confirm('Bạn có chắc muốn xóa khách hàng này?')">
                                                        Xóa
                                                    </button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @include('admin.shared.pagination', ['paginator' => $products])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
