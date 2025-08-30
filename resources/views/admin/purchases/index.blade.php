@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6"><h3 class="mb-0">Nhập hàng</h3></div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('admin.purchases.create') }}" class="btn btn-success btn-sm">
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
                        <form id="filterForm" class="row g-2" method="GET" action="{{ route('admin.purchases.index') }}">
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
                                <button type="submit" class="btn btn-primary btn-sm mx-2 px-4">Lọc</button>
                                <a href="{{ route('admin.purchases.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
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
                                @forelse($purchases as $purchase)
                                    <tr data-purchase-id="{{ $purchase->id }}" onclick="window.location='{{ route('admin.purchases.show', $purchase->id) }}'" style="cursor:pointer;">
                                        <td>{{ $loop->iteration + ($purchases->currentPage()-1) * $purchases->perPage() }}</td>
                                        <td>{{ $purchase->supplier->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</td>
                                        <td onclick="event.stopPropagation()">
                                            <select class="form-select form-select-sm py-0 w-auto UpdateStatus" data-id="{{ $purchase->id }}">
                                                @foreach($statuses as $key => $label)
                                                    <option value="{{ $key }}" {{ $purchase->status == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ number_format($purchase->total_amount, 0, ',', '.') }} đ</td>
                                        <td onclick="event.stopPropagation()" class="text-center">
                                            <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST" onclick="event.stopPropagation();" class="d-inline">
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
                    @include('admin.shared.pagination', ['paginator' => $purchases])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/purchases/index.js') }}"></script>
@endpush
