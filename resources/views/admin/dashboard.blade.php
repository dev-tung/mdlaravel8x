@extends('admin.shared.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6 my-3"><h3>Dashboard</h3></div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Filter -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form class="row g-2" method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="col-2">
                            <select id="filterType" name="filter_type" class="form-select form-select-sm">
                                <option value="day" {{ request()->filter_type =='day'?'selected':'' }}>Ngày</option>
                                <option value="month" {{ request()->filter_type =='month'?'selected':'' }}>Tháng</option>
                                <option value="year" {{ request()->filter_type =='year'?'selected':'' }}>Năm</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <input 
                                id="dateInput"
                                type="{{ request()->filter_type =='day'?'date':(request()->filter_type =='month'?'month':'number') }}"
                                name="date"
                                class="form-control form-control-sm"
                                value="{{ request()->date }}"
                                placeholder="{{ request()->filter_type =='year' ? 'Nhập năm (VD: 2025)' : '' }}"
                            >
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-sm px-4">Lọc</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-4 mb-4">
                <div class="col">
                    <div class="card text-center p-3">
                        <label class="mb-1">Tồn kho</label>
                        <h4>{{ number_format($inventory, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-center p-3">
                        <label class="mb-1">Doanh thu</label>
                        <h4>{{ number_format($revenue, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-center p-3">
                        <label class="mb-1">Triết khấu</label>
                        <h4>{{ number_format($discount, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-center p-3">
                        <label class="mb-1">Chi phí</label>
                        <h4>{{ number_format($expense, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-center p-3">
                        <label class="mb-1">Lợi nhuận gộp</label>
                        <h4>{{ number_format($profit, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-center p-3">
                        <label class="mb-1">Lợi nhuận ròng</label>
                        <h4>{{ number_format($profit - $expense, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
            </div>

            <canvas id="profitChart" style="height: 400px;"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterType = document.getElementById("filterType");
    const dateInput  = document.getElementById("dateInput");

    function updateDateInput() {
        let type = "date";
        let placeholder = "";
        let min = "";
        let max = "";

        if (filterType.value === "day") {
            type = "date";
        } else if (filterType.value === "month") {
            type = "month";
        } else if (filterType.value === "year") {
            type = "number";
            placeholder = "Nhập năm (VD: 2025)";
            min = "2024";
            max = new Date().getFullYear();
        }

        dateInput.type = type;
        dateInput.placeholder = placeholder;
        if (min) dateInput.min = min; else dateInput.removeAttribute("min");
        if (max) dateInput.max = max; else dateInput.removeAttribute("max");
    }

    // Gọi khi load và khi thay đổi select
    updateDateInput();
    filterType.addEventListener("change", updateDateInput);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('profitChart').getContext('2d');
const profitMonths = @json($profitMonths);
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Object.keys(profitMonths).map(m => 'Tháng ' + m),
        datasets: [{
            label:'Lợi nhuận', 
            data:Object.values(profitMonths)
        }]
    },
    options: {
        responsive: false, // canvas chiều cao/width = cố định
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush
