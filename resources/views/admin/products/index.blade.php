@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Sản phẩm</h3></div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
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
                                            <option value="{{ $supplier->id }}"
                                                {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select name="taxonomy_id" class="form-control form-control-sm">
                                        <option value="">-- Nhóm sản phẩm --</option>
                                        @foreach($taxonomies as $taxonomy)
                                            <option value="{{ $taxonomy->id }}"
                                                {{ request('taxonomy_id') == $taxonomy->id ? 'selected' : '' }}>
                                                {{ $taxonomy->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm mx-2 px-4">Lọc</button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:50px;">#</th>
                                        <th>Tên</th>
                                        <th>Nhóm</th>
                                        <th>Nhà cung cấp</th>
                                        <th>Số lượng</th>
                                        <th>Giá bán</th>
                                        <th class="text-center" style="width:150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr onclick="window.location='{{ route('admin.products.edit', $product->id) }}'" style="cursor:pointer;">
                                            <td>{{ $loop->iteration + ($products->currentPage()-1) * $products->perPage() }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->taxonomy->name ?? '-' }}</td>
                                            <td>{{ $product->supplier->name ?? '-' }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ number_format($product->price_output,0,',','.') }} đ</td>
                                            <td onclick="event.stopPropagation()" class="text-center">
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onclick="event.stopPropagation();" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link text-danger btn-sm p-0" onclick="return confirm('Bạn có chắc muốn xóa khách hàng này?')">
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
