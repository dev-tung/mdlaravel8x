@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3>Khách hàng</h3></div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-success btn-sm">
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
                            <form id="filterForm" class="row g-2" method="GET" action="{{ route('admin.customers.index') }}">
                                <div class="col-auto">
                                    <input type="text" name="name" class="form-control form-control-sm" 
                                        placeholder="Tên khách hàng" value="{{ request('name') }}">
                                </div>
                                <div class="col-auto">
                                    <input type="text" name="email" class="form-control form-control-sm" 
                                        placeholder="Email" value="{{ request('email') }}">
                                </div>
                                <div class="col-auto">
                                    <select name="taxonomy_id" class="form-control form-control-sm">
                                        <option value="">-- Nhóm khách hàng --</option>
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
                                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Tên</th>
                                        <th>Nhóm</th>
                                        <th class="text-center" style="width: 150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $customer)
                                        <tr onclick="window.location='{{ route('admin.customers.edit', $customer->id) }}'" style="cursor: pointer;">
                                            <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->taxonomy->name ?? '-' }}</td>
                                            <td onclick="event.stopPropagation()" class="text-center">
                                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
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
                                            <td colspan="4" class="text-center text-muted">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>

                        <!-- Pagination -->
                        @include('admin.shared.pagination', ['paginator' => $customers])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
