@extends('admin.shared.app')

@section('content')
<main class="app-main" id="main" tabindex="-1">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Taxonomies</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Taxonomies</li>
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
                                <div class="col-md-3">
                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Tên taxonomy" value="{{ request('name') }}">
                                </div>

                                <div class="col-md-3">
                                    <select name="type" class="form-select form-select-sm">
                                        <option value="">-- Loại --</option>
                                        @foreach($types as $key => $label)
                                            <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">-- Trạng thái --</option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Hiển thị</option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ẩn</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                                </div>
                            </form>
                        </div>


                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên taxonomy</th>
                                        <th>Slug</th>
                                        <th>Loại</th>
                                        <th>Trạng thái</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($taxonomies as $taxonomy)
                                        <tr>
                                            <td>{{ $loop->iteration + ($taxonomies->currentPage() - 1) * $taxonomies->perPage() }}</td>
                                            <td>{{ $taxonomy->name }}</td>
                                            <td>{{ $taxonomy->slug }}</td>
                                            <td>{{ config('taxonomy.types')[$taxonomy->type] ?? $taxonomy->type }}</td>
                                            <td>{{ $taxonomy->status == 'active' ? 'Hoạt động' : 'Ngừng hoạt động' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.taxonomies.edit', $taxonomy->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                                <form action="{{ route('admin.taxonomies.destroy', $taxonomy->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer clearfix">
                            {{ $taxonomies->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
