@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Chi tiết đơn hàng</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Thông tin đơn hàng -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Khách hàng:</strong> {{ $order->customer->name ?? '-' }} - {{ $order->customer->taxonomy->name ?? '-' }}
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}
                            </div>
                        </div>

                        <!-- Danh sách sản phẩm -->
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>SL</th>
                                    <th>Quà tặng</th>
                                    <th>Giá bán</th>
                                    <th>Triết khấu</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($order->items as $item)
                                    @php
                                        $price = $item->is_gift ? 0 : $item->product_price_output;
                                        $discount = $item->discount ?? 0;
                                        $amount = $price * $item->quantity - $discount;
                                        $total += $amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->product->name ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-center">{{ $item->is_gift ? 'có' : 'không' }}</td>
                                        <td>{{ number_format($price,0,',','.') }} đ</td>
                                        <td>{{ number_format($discount,0,',','.') }} đ</td>
                                        <td>{{ number_format($amount,0,',','.') }} đ</td>
                                    </tr>
                                @endforeach
                                <tr class="table-light">
                                    <td colspan="5" class="text-end"><strong>Tổng tiền:</strong></td>
                                    <td><strong>{{ number_format($total,0,',','.') }} đ</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
