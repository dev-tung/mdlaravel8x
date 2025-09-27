@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center my-2">
                <div class="col-auto"><h3 class="mb-0">Đơn hàng</h3></div>
                <div class="col-auto">
                    <a href="{{ route('admin.exports.create') }}" class="btn btn-outline-primary btn-sm">
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
                            <form id="filterForm" class="row g-2" method="GET" action="{{ route('admin.exports.index') }}">
                                <div class="col-auto">
                                    <input type="text" name="customer_name" class="form-control form-control-sm" placeholder="Tên khách hàng" value="{{ request('customer_name') }}">
                                </div>
                                <div class="col-auto">
                                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-auto">
                                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-auto">
                                    <select name="status" class="form-control form-control-sm">
                                        <option value="">-- Trạng thái --</option>
                                        @foreach($statuses as $key => $label)
                                            <option value="{{ $key }}" @selected(request('status') == $key)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mx-2 px-4">Lọc</button>
                                    <a href="{{ route('admin.exports.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày nhập</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Ghi chú</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($exports as $export)
                                        <tr data-export-id="{{ $export->id }}" data-href="{{ route('admin.exports.edit', $export->id) }}">
                                            <td>{{ $loop->iteration + ($exports->currentPage()-1) * $exports->perPage() }}</td>
                                            <td>{{ $export->customer->name ?? '–' }}</td>
                                            <td>{{ $export->export_date->format('d/m/Y') }}</td>
                                            <td class="NoBubble">
                                                <select data-id="{{ $export->id }}" class="form-select form-select-sm py-0 w-auto UpdateStatus">
                                                    @foreach($statuses as $key => $label)
                                                        <option value="{{ $key }}" {{ $export->status == $key ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>{{ number_format($export->total_export_amount, 0, ',', '.') }} đ</td>
                                            <td>{{ $export->notes ?? '–' }}</td>
                                            <td class="NoBubble">
                                                <form action="{{ route('admin.exports.destroy', $export->id) }}" method="POST" class="NoBubble d-inline">
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
                        @include('admin.shared.pagination', ['paginator' => $exports])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


