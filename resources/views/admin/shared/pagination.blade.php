<div class="card-footer d-flex justify-content-between align-items-center">
    <!-- Khối chọn số bản ghi -->
    <div class="d-flex align-items-center">
        <form method="GET" action="{{ url()->current() }}" id="perPageForm" class="d-flex align-items-center">
            @foreach(request()->except('per_page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <label for="per_page" class="me-2">Hiển thị</label>
            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
            </select>
            <span class="ms-2">bản ghi/trang</span>
        </form>
    </div>

    <!-- Khối phân trang -->
    <div class="d-flex flex-grow-1">
        <div class="ms-auto">
            {{ $paginator->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
