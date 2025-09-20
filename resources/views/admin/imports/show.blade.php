@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Chi tiết phiếu nhập</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.imports.index') }}">Phiếu nhập</a></li>
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
                        <!-- Thông tin phiếu nhập -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nhà cung cấp:</strong> {{ $purchase->supplier->name ?? '-' }}
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>Ngày nhập:</strong> {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong>Ghi chú:</strong> {{ $purchase->notes ?? '-' }}
                            </div>
                        </div>

                        <!-- Danh sách sản phẩm nhập -->
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>SL</th>
                                    <th>Giá nhập</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($purchase->imports as $item)
                                    @php
                                        $price = $item->price_input ?? 0;
                                        $amount = $item->total_price ?? 0;
                                        $total += $amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->product->name ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($price,0,',','.') }} đ</td>
                                        <td>{{ number_format($amount,0,',','.') }} đ</td>
                                    </tr>
                                @endforeach
                                <tr class="table-light">
                                    <td colspan="3" class="text-end"><strong>Tổng tiền:</strong></td>
                                    <td><strong>{{ number_format($total,0,',','.') }} đ</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <a href="{{ route('admin.imports.index') }}" class="btn btn-secondary btn-sm mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
