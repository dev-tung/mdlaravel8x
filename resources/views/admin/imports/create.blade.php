@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Thêm mới nhập hàng</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.imports.index') }}">Nhập hàng</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
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
                    <form method="POST" action="{{ route('admin.imports.store') }}" id="purchaseCreateForm">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">

                                <!-- Nhà cung cấp -->
                                <div class="col-md-6">
                                    <label for="supplierSearch" class="form-label">Nhà cung cấp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="supplierSearch" placeholder="Tìm nhà cung cấp..." autocomplete="off">
                                    <select class="form-select form-select-sm mt-1" id="supplierSelect" size="5" style="display:none;"></select>
                                    <input type="hidden" name="supplier_id" id="supplier_id">
                                    @error('supplier_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Ngày nhập hàng -->
                                <div class="col-md-6">
                                    <label for="purchase_date" class="form-label">Ngày nhập</label>
                                    <input type="date" name="purchase_date" id="purchase_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                </div>

                                <!-- Sản phẩm -->
                                <div class="col-md-6">
                                    <label for="productSearch" class="form-label">Thêm sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="productSearch" placeholder="Tìm sản phẩm..." autocomplete="off">
                                    <select class="form-select form-select-sm mt-1" id="productSelect" size="5" style="display:none;"></select>
                                    @error('product_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label small">Trạng thái</label>
                                    <select class="form-select form-select-sm" id="status" name="status">
                                        <option value="">-- Chọn trạng thái --</option>
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Table sản phẩm đã chọn -->
                                <div class="col-12 mt-2">
                                    <table class="table table-sm table-bordered mb-0 align-middle" id="productSelectedTable" style="display:none;">
                                        <thead class="table-light">
                                            <tr>
                                                <td>Tên sản phẩm</td>
                                                <td style="width:130px;">Số lượng</td>
                                                <td style="width:220px;">Giá nhập</td>
                                                <td class="text-center" style="width:90px;">Hành động</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr class="form-label small">
                                                <td colspan="4" class="text-danger">Tổng <span id="totalAmount">0 ₫</span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Ghi chú -->
                                <div class="col-md-12">
                                    <label for="notes" class="form-label">Ghi chú</label>
                                    <input type="text" name="notes" id="notes" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-success btn-sm" type="submit">Lưu nhập hàng</button>
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
<script>
    // ======== Data từ backend ========
    const suppliers = @json($suppliers ?? []);
    const products  = @json($products ?? []);

    // ======== DOM ========
    const supplierSearch   = document.getElementById('supplierSearch');
    const supplierSelect   = document.getElementById('supplierSelect');
    const supplierIdInput  = document.getElementById('supplier_id');

    const productSearch    = document.getElementById('productSearch');
    const productSelect    = document.getElementById('productSelect');
    const productSelectedTable = document.getElementById('productSelectedTable');
    const productTableBody = productSelectedTable.querySelector('tbody');
    const totalAmountEl    = document.getElementById('totalAmount');

    // ======== Helpers ========
    function formatVND(amount) {
        if (amount === '' || amount === null || typeof amount === 'undefined') return '';
        const n = Number(amount) || 0;
        return n.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    function parseNumber(str) {
        if (str === '' || str === null || typeof str === 'undefined') return 0;
        return Number(String(str).replace(/[^\d.-]/g, '')) || 0;
    }

    function updateTotal() {
        let total = 0;
        productTableBody.querySelectorAll('tr').forEach(tr => {
            const qtyInput    = tr.querySelector('input[name^="quantity"]');
            const priceHidden = tr.querySelector('.price-hidden');
            const qty   = parseNumber(qtyInput?.value);
            const price = parseNumber(priceHidden?.value);
            total += qty * price;
        });
        totalAmountEl.textContent = formatVND(total);
        productSelectedTable.style.display = productTableBody.children.length ? 'table' : 'none';
    }

    function clearSelect(el) {
        el.innerHTML = '';
        el.style.display = 'none';
    }

    // ======== Nhà cung cấp ========
    supplierSearch.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        supplierSelect.innerHTML = '';
        const filtered = suppliers.filter(s => s.name.toLowerCase().includes(term));
        if (filtered.length) {
            filtered.forEach(s => {
                const option = document.createElement('option');
                option.value = s.id;
                option.textContent = s.name;
                supplierSelect.appendChild(option);
            });
            supplierSelect.style.display = 'block';
        } else {
            supplierSelect.style.display = 'none';
        }
    });

    function chooseSupplier(option) {
        if (!option) return;
        supplierIdInput.value = option.value;
        supplierSearch.value  = option.textContent;
        clearSelect(supplierSelect);
    }

    supplierSelect.addEventListener('change', function() {
        chooseSupplier(this.selectedOptions[0]);
    });

    supplierSearch.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const first = supplierSelect.options[0];
            chooseSupplier(first);
        }
    });

    // ======== Sản phẩm ========
    productSearch.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        productSelect.innerHTML = '';
        const filtered = products.filter(p => p.name.toLowerCase().includes(term));
        if (filtered.length) {
            filtered.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.name;
                productSelect.appendChild(option);
            });
            productSelect.style.display = 'block';
        } else {
            productSelect.style.display = 'none';
        }
    });

    function attachRowEvents(tr, productId) {
        const qtyInput         = tr.querySelector(`input[name="quantity[${productId}]"]`);
        const priceDisplay     = tr.querySelector(`input[name="product_price_input_display[${productId}]"]`);
        const priceHidden      = tr.querySelector(`input[name="product_price_input[${productId}]"]`);
        const btnDelete        = tr.querySelector('.btn-remove-row');

        // Số lượng: cập nhật tổng khi thay đổi
        qtyInput.addEventListener('input', () => {
            if (parseNumber(qtyInput.value) < 1) qtyInput.value = 1;
            updateTotal();
        });

        // Giá nhập: hiển thị số thô khi focus, định dạng khi blur, vẫn cập nhật tổng khi input
        priceDisplay.addEventListener('focus', function() {
            const raw = priceHidden.value;
            this.value = raw ? String(raw) : '';
            this.select();
        });

        priceDisplay.addEventListener('input', function() {
            const num = parseNumber(this.value);
            priceHidden.value = num;
            updateTotal();
        });

        priceDisplay.addEventListener('blur', function() {
            const num = parseNumber(this.value);
            priceHidden.value = num;
            this.value = num ? formatVND(num) : '';
            updateTotal();
        });

        // Xóa dòng
        btnDelete.addEventListener('click', function() {
            tr.remove();
            updateTotal();
        });
    }

    function addProductRow(id, name) {
        // Không thêm trùng
        if (document.getElementById('product-' + id)) return;

        const tr = document.createElement('tr');
        tr.id = 'product-' + id;
        tr.innerHTML = `
            <td>
                <input type="hidden" name="product_id[]" value="${id}">
                ${name}
            </td>
            <td>
                <input type="number" name="quantity[${id}]" value="1" min="1"
                       class="form-control form-control-sm text-end">
            </td>
            <td>
                <input type="text" name="product_price_input_display[${id}]"
                       value="" placeholder="Nhập giá..."
                       class="form-control form-control-sm text-end">
                <input type="hidden" name="product_price_input[${id}]" value="" class="price-hidden">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger btn-remove-row">Xóa</button>
            </td>
        `;
        productTableBody.appendChild(tr);
        attachRowEvents(tr, id);

        // Hiện bảng nếu lần đầu có dòng
        productSelectedTable.style.display = 'table';

        // Dọn ô tìm kiếm
        productSearch.value = '';
        clearSelect(productSelect);
        updateTotal();
    }

    productSelect.addEventListener('change', function() {
        const opt = this.selectedOptions[0];
        if (opt) addProductRow(opt.value, opt.textContent);
    });

    productSearch.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const first = productSelect.options[0];
            if (first) addProductRow(first.value, first.textContent);
        }
    });

    // ======== Validate trước khi submit ========
    document.getElementById('purchaseCreateForm').addEventListener('submit', function(e) {
        // Supplier
        if (!supplierIdInput.value) {
            e.preventDefault();
            alert('Vui lòng chọn nhà cung cấp');
            return;
        }

        // Ít nhất 1 sản phẩm
        if (!productTableBody.children.length) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 sản phẩm');
            return;
        }

        // Kiểm tra từng dòng
        let valid = true;
        productTableBody.querySelectorAll('tr').forEach(tr => {
            const qtyInput    = tr.querySelector('input[name^="quantity"]');
            const priceHidden = tr.querySelector('.price-hidden');
            const qty   = parseNumber(qtyInput?.value);
            const price = parseNumber(priceHidden?.value);

            if (qty <= 0 || !Number.isFinite(qty)) valid = false;
            if (price <= 0 || !Number.isFinite(price)) valid = false;
        });

        if (!valid) {
            e.preventDefault();
            alert('Vui lòng nhập số lượng (>=1) và giá nhập (>0) cho tất cả sản phẩm');
            return;
        }
    });
</script>
@endpush
