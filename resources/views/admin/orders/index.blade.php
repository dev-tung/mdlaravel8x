@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6"><h3 class="mb-0">Đơn hàng</h3></div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('admin.orders.create') }}" class="btn btn-success btn-sm">
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
                        <form id="filterForm" class="row g-2" method="GET" action="{{ route('admin.orders.index') }}">
                            <div class="col-auto">
                                <input type="text" name="customer_name" class="form-control form-control-sm"
                                       placeholder="Tên khách hàng" value="{{ request('customer_name') }}">
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
                                <select name="payment_method" class="form-control form-control-sm">
                                    <option value="">-- Thanh toán --</option>
                                    @foreach($payments as $key => $label)
                                        <option value="{{ $key }}" {{ request('payment_method') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm mx-2 px-4">Lọc</button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th>Khách hàng</th>
                                    <th>Nhóm khách hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th class="text-center" style="width:150px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="clickable-row" data-order-id="{{ $order->id }}" data-href="{{ route('admin.orders.show', $order->id) }}" title="{{ $order->notes }}">
                                        <td>{{ $loop->iteration + ($orders->currentPage()-1) * $orders->perPage() }}</td>
                                        <td>{{ $order->customer->name ?? '-' }}</td>
                                        <td>{{ $order->customer->taxonomy->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                        <td onclick="event.stopPropagation()">
                                            <select class="form-select form-select-sm py-0 w-auto UpdateStatus" data-id="{{ $order->id }}">
                                                @foreach($statuses as $key => $label)
                                                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td onclick="event.stopPropagation()">
                                            <select class="form-select form-select-sm py-0 w-auto UpdatePayment" data-id="{{ $order->id }}">
                                                @foreach($payments as $key => $label)
                                                    <option value="{{ $key }}" {{ $order->payment_method == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                            
                                        <td onclick="event.stopPropagation()" class="text-center">
                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onclick="event.stopPropagation();" class="d-inline">
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
                                        <td colspan="8" class="text-center text-muted">Chưa có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @include('admin.shared.pagination', ['paginator' => $orders])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/admin/orders/index.js') }}"></script>
@endpush