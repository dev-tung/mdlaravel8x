@extends('admin.shared.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6"><h3 class="mb-0">Chi phí</h3></div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.expenses.create') }}" class="btn btn-success btn-sm">
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
                                    <input type="text" name="name" class="form-control form-control-sm"
                                           placeholder="Tên chi phí" value="{{ request('name') }}" autocomplete="off">
                                </div>

                                <div class="col-auto">
                                    <input type="date" name="expense_date" class="form-control form-control-sm"
                                           value="{{ request('expense_date') }}">
                                </div>

                                <div class="col-auto">
                                    <select name="taxonomy_id" class="form-select form-select-sm">
                                        <option value="">-- Loại chi phí --</option>
                                        @foreach($taxonomies as $t)
                                            <option value="{{ $t->id }}"
                                                {{ request('taxonomy_id') == $t->id ? 'selected' : '' }}>
                                                {{ $t->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm mx-2 px-4">Lọc</button>
                                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên chi phí</th>
                                        <th>Loại chi phí</th>
                                        <th>Số tiền</th>
                                        <th>Ngày chi</th>
                                        <th>Ghi chú</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expenses as $expense)
                                        <tr onclick="window.location='{{ route('admin.expenses.edit', $expense->id) }}'" style="cursor:pointer;">
                                            <td>{{ $loop->iteration + ($expenses->currentPage() - 1) * $expenses->perPage() }}</td>
                                            <td>{{ $expense->name }}</td>
                                            <td>{{ $expense->taxonomy->name }}</td>
                                            <td>{{ number_format($expense->amount, 0, ',', '.') }} đ</td>
                                            <td>{{ $expense->expense_date }}</td>
                                            <td>{{ $expense->note }}</td>
                                            <td onclick="event.stopPropagation()" class="text-center">
                                                <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link text-danger btn-sm p-0"
                                                            onclick="return confirm('Bạn có chắc muốn xóa chi phí này?')">
                                                        Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @include('admin.shared.pagination', ['paginator' => $expenses])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
