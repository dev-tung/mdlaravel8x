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
                    <li class="breadcrumb-item"><a href="{{ route('admin.purchases.index') }}">Nhập hàng</a></li>
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
                    <form method="POST" action="{{ route('admin.purchases.store') }}" id="purchaseCreateForm">
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
                                <div class="col-md-12">
                                    <label for="productSearch" class="form-label">Thêm sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="productSearch" placeholder="Tìm sản phẩm...">
                                    <select class="form-select form-select-sm mt-1" id="productSelect" size="5" style="display:none;"></select>
                                    @error('product_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Table sản phẩm đã chọn -->
                                <div class="col-12 mt-2">
                                    <table class="table table-sm table-bordered mb-0 align-middle" id="productSelectedTable" style="display:none;">
                                        <thead class="table-light">
                                            <tr>
                                                <td>Tên sản phẩm</td>
                                                <td>Số lượng</td>
                                                <td>Giá nhập</td>
                                                <td class="text-center">Hành động</td>
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
    const suppliers = @json($suppliers ?? []);
    const products = @json($products ?? []);

    const supplierSearch = document.getElementById('supplierSearch');
    const supplierSelect = document.getElementById('supplierSelect');
    const supplierIdInput = document.getElementById('supplier_id');

    const productSearch = document.getElementById('productSearch');
    const productSelect = document.getElementById('productSelect');
    const productTable = document.getElementById('productSelectedTable').querySelector('tbody');
    const totalAmountEl = document.getElementById('totalAmount');

    function formatVND(amount) {
        return Number(amount).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    function parseNumber(str) {
        return Number(str.replace(/[^\d.-]/g, '')) || 0;
    }

    function updateTotal() {
        let total = 0;
        productTable.querySelectorAll('tr').forEach(tr => {
            const qty = parseFloat(tr.querySelector('[name^="quantity"]').value) || 0;
            const price = parseFloat(tr.querySelector('.price-hidden').value) || 0;
            total += qty * price;
        });
        totalAmountEl.textContent = formatVND(total);
    }

    // ===================== Nhà cung cấp =====================
    supplierSearch.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        supplierSelect.innerHTML = '';
        const filtered = suppliers.filter(s =>
            s.name.toLowerCase().includes(term)
        );
        if(filtered.length) {
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

    supplierSelect.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        if(selected) {
            supplierIdInput.value = selected.value;
            supplierSearch.value = selected.textContent;
            this.style.display = 'none';
        }
    });

    // ===================== Sản phẩm =====================
    productSearch.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        productSelect.innerHTML = '';
        const filtered = products.filter(p => p.name.toLowerCase().includes(term));
        if(filtered.length) {
            filtered.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.dataset.price_input = p.price_input;
                option.textContent = p.name;
                productSelect.appendChild(option);
            });
            productSelect.style.display = 'block';
        } else {
            productSelect.style.display = 'none';
        }
    });

    productSelect.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        if(selected && !document.getElementById('product-' + selected.value)) {
            const price_input = parseFloat(selected.dataset.price_input);

            const tr = document.createElement('tr');
            tr.id = 'product-' + selected.value;
            tr.innerHTML = `
                <td>
                    <input type="hidden" name="product_id[]" value="${selected.value}">
                    ${selected.textContent}
                </td>
                <td>
                    <input type="number" name="quantity[${selected.value}]" value="1"
                           class="form-control form-control-sm" min="1">
                </td>
                <td>
                    <input type="text" name="product_price_input_display[${selected.value}]"
                           value="${formatVND(price_input)}" class="form-control form-control-sm">
                    <input type="hidden" name="product_price_input[${selected.value}]" value="${price_input}" class="price-hidden">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger">Xóa</button>
                </td>
            `;
            productTable.appendChild(tr);

            tr.querySelector('input[type="number"]').addEventListener('input', updateTotal);
            tr.querySelector('button').addEventListener('click', function() {
                tr.remove();
                selected.selected = false;
                updateTotal();
                if(productTable.children.length === 0) document.getElementById('productSelectedTable').style.display = 'none';
            });

            document.getElementById('productSelectedTable').style.display = 'table';
            productSearch.value = '';
            productSelect.style.display = 'none';

            updateTotal();
        }
    });
</script>
@endpush
