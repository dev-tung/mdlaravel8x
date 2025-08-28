@extends('admin.shared.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Taxonomies</h3></div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.taxonomies.create') }}" class="btn btn-success btn-sm">
                        + Thêm mới
                    </a>
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
                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Tên taxonomy" value="{{ request('name') }}" autocomplete="off">
                                </div>

                                <div class="col-auto">
                                    <select name="type" class="form-select form-select-sm">
                                        <option value="">-- Loại --</option>
                                        @foreach($types as $key => $label)
                                            <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">-- Trạng thái --</option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Hiển thị</option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ẩn</option>
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm mx-2 px-4">Lọc</button>
                                    <a href="{{ route('admin.taxonomies.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
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
                                        <tr onclick="window.location='{{ route('admin.taxonomies.edit', $taxonomy->id) }}'" style="cursor: pointer;">
                                            <td>{{ $loop->iteration + ($taxonomies->currentPage() - 1) * $taxonomies->perPage() }}</td>
                                            <td>{{ $taxonomy->name }}</td>
                                            <td>{{ $taxonomy->slug }}</td>
                                            <td>{{ $types[$taxonomy->type] ?? $taxonomy->type }}</td>
                                            <td>{{ $taxonomy->status == 'active' ? 'Hoạt động' : 'Ngừng hoạt động' }}</td>
                                            <td onclick="event.stopPropagation()" class="text-center">
                                                <form action="{{ route('admin.taxonomies.destroy', $taxonomy->id) }}" method="POST" class="d-inline">
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
                                            <td colspan="6" class="text-center">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @include('admin.shared.pagination', ['paginator' => $taxonomies])

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
