@extends('admin.shared.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Nhà cung cấp</h3></div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-success btn-sm">
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
                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Tên nhà cung cấp" value="{{ request('name') }}" autocomplete="off">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm mx-2 px-4">Lọc</button>
                                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên nhà cung cấp</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($suppliers as $supplier)
                                        <tr onclick="window.location='{{ route('admin.suppliers.edit', $supplier->id) }}'" style="cursor:pointer;">
                                            <td>{{ $loop->iteration + ($suppliers->currentPage() - 1) * $suppliers->perPage() }}</td>
                                            <td>{{ $supplier->name }}</td>
                                            <td onclick="event.stopPropagation()" class="text-center">
                                                <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
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

                        <!-- Pagination -->
                        @include('admin.shared.pagination', ['paginator' => $suppliers])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
