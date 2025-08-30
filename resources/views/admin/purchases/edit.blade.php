@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Chỉnh sửa Order</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <form id="orderEditForm" method="POST" action="{{ route('admin.orders.update', $order->id) }}" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label small">Customer ID <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" name="customer_id" value="{{ old('customer_id', $order->customer_id) }}" required>
                                        @error('customer_id') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small">Status <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" name="status" required>
                                            <option value="">-- Chọn trạng thái --</option>
                                            <option value="pending" {{ old('status', $order->status)=='pending'?'selected':'' }}>Pending</option>
                                            <option value="processing" {{ old('status', $order->status)=='processing'?'selected':'' }}>Processing</option>
                                            <option value="completed" {{ old('status', $order->status)=='completed'?'selected':'' }}>Completed</option>
                                            <option value="cancelled" {{ old('status', $order->status)=='cancelled'?'selected':'' }}>Cancelled</option>
                                        </select>
                                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small">Total Amount <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" step="0.01" required>
                                        @error('total_amount') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Payment Method</label>
                                        <input type="text" class="form-control form-control-sm" name="payment_method" value="{{ old('payment_method', $order->payment_method) }}">
                                        @error('payment_method') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Shipping Address</label>
                                        <input type="text" class="form-control form-control-sm" name="shipping_address" value="{{ old('shipping_address', $order->shipping_address) }}">
                                        @error('shipping_address') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small">Note</label>
                                        <textarea class="form-control form-control-sm" name="note" rows="3">{{ old('note', $order->note) }}</textarea>
                                        @error('note') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success btn-sm" type="submit">Cập nhật Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/shared/validation.js') }}"></script>
<script src="{{ asset('js/admin/orders/create.js') }}"></script>
@endpush
