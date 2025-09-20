@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row align-items-center my-2">
            <div class="col-auto"><h3 class="mb-0">Nhập hàng</h3></div>
            <div class="col-auto">
                <a href="{{ route('admin.imports.create') }}" class="btn btn-outline-primary btn-sm">
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
                        <form id="filterForm" class="row g-2" method="GET" action="{{ route('admin.imports.index') }}">
                            <div class="col-auto">
                                <input type="text" name="supplier_name" class="form-control form-control-sm"
                                       placeholder="Tên nhà cung cấp" value="{{ request('supplier_name') }}">
                            </div>
                            <div class="col-auto">
                                <input type="date" name="from_date" class="form-control form-control-sm"
                                       value="{{ request('from_date') }}">
                            </div>
                            <div class="col-auto">
                                <input type="date" name="to_date" class="form-control form-control-sm"
                                       value="{{ request('to_date') }}">
                            </div>
                            <div class="col-auto">
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">-- Trạng thái --</option>
                                    @foreach($statuses as $key => $label)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-primary btn-sm mx-2 px-4">Lọc</button>
                                <a href="{{ route('admin.imports.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Ngày nhập</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th class="text-center" style="width:150px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($imports as $import)
                                    <tr data-import-id="{{ $import->id }}" onclick="window.location='{{ route('admin.imports.show', $import->id) }}'" style="cursor:pointer;">
                                        <td>{{ $loop->iteration + ($imports->currentPage()-1) * $imports->perPage() }}</td>
                                        <td>{{ $import->supplier->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($import->import_date)->format('d/m/Y') }}</td>
                                        <td onclick="event.stopPropagation()">
                                            <select class="form-select form-select-sm py-0 w-auto UpdateStatus" data-id="{{ $import->id }}">
                                                @foreach($statuses as $key => $label)
                                                    <option value="{{ $key }}" {{ $import->status == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ number_format($import->total_amount, 0, ',', '.') }} đ</td>
                                        <td onclick="event.stopPropagation()" class="text-center">
                                            <form action="{{ route('admin.imports.destroy', $import->id) }}" method="POST" onclick="event.stopPropagation();" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link text-danger btn-sm p-0" onclick="return confirm('Bạn có chắc muốn xóa phiếu nhập này?')">
                                                    Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Chưa có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @include('admin.shared.pagination', ['paginator' => $imports])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/imports/index.js') }}"></script>
@endpush
