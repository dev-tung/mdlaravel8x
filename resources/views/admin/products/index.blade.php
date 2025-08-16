@extends('admin.shared.app')

@section('content')
<main class="app-main" id="main" tabindex="-1">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Sản phẩm</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <!-- Filter Form -->
                        <div class="card-header">
                            <form id="filterForm" class="row g-2">
                                <div class="col-auto">
                                    <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" value="{{ request('name') }}" autocomplete="off">
                                </div>

                                <div class="col-auto">
                                    <select name="taxonomy_id" class="form-select">
                                        <option value="">-- Danh mục --</option>
                                        @foreach($taxonomies as $taxonomy)
                                            <option value="{{ $taxonomy->id }}" {{ request('taxonomy_id') == $taxonomy->id ? 'selected' : '' }}>
                                                {{ $taxonomy->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <select name="status" class="form-select">
                                        <option value="">-- Trạng thái --</option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Hiển thị</option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ẩn</option>
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>SKU</th>
                                        <th>Giá</th>
                                        <th>Stock</th>
                                        <th>Trạng thái</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ optional($product->taxonomy)->name ?? '-' }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ number_format($product->price) }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ $product->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer clearfix">
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
