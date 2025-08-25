@extends('admin.shared.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Thêm mới đơn hàng</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
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
                    <form method="POST" action="{{ route('admin.orders.store') }}" id="orderCreateForm">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">

                                <!-- Khách hàng -->
                                <div class="col-md-6">
                                    <label for="customerSearch" class="form-label">Khách hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="customerSearch" placeholder="Tìm khách hàng..." autocomplete="off">
                                    <select class="form-select form-select-sm mt-1" id="customerSelect" size="5" style="display:none;"></select>
                                    <input type="hidden" name="customer_id" id="customer_id">
                                    @error('customer_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Ngày đơn hàng -->
                                <div class="col-md-6">
                                    <label for="order_date" class="form-label">Ngày đặt</label>
                                    <input type="date" name="order_date" id="order_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
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

                                <!-- Phương thức thanh toán -->
                                <div class="col-md-6">
                                    <label for="payment_method" class="form-label small">Phương thức thanh toán</label>
                                    <select class="form-select form-select-sm" id="payment_method" name="payment_method">
                                        <option value="">-- Chọn phương thức --</option>
                                        @foreach($payments as $value => $label)
                                            <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                                <td class="text-center">Tặng kèm</td>
                                                <td>Giá bán</td>
                                                <td>Triết khấu</td>
                                                <td class="text-center">Hành động</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr class="form-label small">
                                                <td colspan="6" class="text-danger">Tổng <span id="totalAmount">0 ₫</span></td>
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
                            <button class="btn btn-success btn-sm" type="submit">Lưu đơn hàng</button>
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
<script>
    const customers = @json($customers ?? []);
    const products = @json($products ?? []);

    const customerSearch = document.getElementById('customerSearch');
    const customerSelect = document.getElementById('customerSelect');
    const customerIdInput = document.getElementById('customer_id');

    const productSearch = document.getElementById('productSearch');
    const productSelect = document.getElementById('productSelect');
    const productTable = document.getElementById('productSelectedTable').querySelector('tbody');
    const totalAmountEl = document.getElementById('totalAmount');

    // ===================== Helpers =====================
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
            const discount = parseFloat(tr.querySelector('.discount-hidden').value) || 0;
            const finalPrice = Math.max(price, 0);
            total += qty * finalPrice - discount;
        });
        totalAmountEl.textContent = formatVND(total);
    }

    // ===================== Khách hàng =====================
    customerSearch.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        customerSelect.innerHTML = '';
        const filtered = customers.filter(c =>
            c.name.toLowerCase().includes(term) ||
            c.taxonomy?.name?.toLowerCase().includes(term)
        );
        if(filtered.length) {
            filtered.forEach(c => {
                const option = document.createElement('option');
                option.value = c.id;
                option.textContent = `${c.name} - ${c.taxonomy?.name ?? ''}`;
                customerSelect.appendChild(option);
            });
            customerSelect.style.display = 'block';
        } else {
            customerSelect.style.display = 'none';
        }
    });

    customerSelect.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        if(selected) {
            customerIdInput.value = selected.value;
            customerSearch.value = selected.textContent;
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
                option.dataset.price_output = p.price_output;
                option.dataset.price_input = p.price_input;
                option.dataset.quantity = p.quantity;
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
            const price_output = parseFloat(selected.dataset.price_output);
            const price_input = parseFloat(selected.dataset.price_input);
            const maxQty = parseInt(selected.dataset.quantity, 10);

            const tr = document.createElement('tr');
            tr.id = 'product-' + selected.value;
            tr.innerHTML = `
                <td>
                    <input type="hidden" name="product_id[]" value="${selected.value}">
                    ${selected.textContent}
                </td>
                <td>
                    <input type="number" name="quantity[${selected.value}]" value="1"
                           class="form-control form-control-sm" min="1" max="${maxQty}">
                </td>
                <td class="text-center">
                    <input type="checkbox" name="is_gift[${selected.value}]" class="form-check-input">
                </td>
                <td>
                    <input type="text" name="product_price_output_display[${selected.value}]"
                           value="${formatVND(price_output)}" class="form-control form-control-sm" disabled>
                    <input type="hidden" name="product_price_output[${selected.value}]" value="${price_output}" class="price-hidden">
                    <input type="hidden" name="product_price_input[${selected.value}]" value="${price_input}">
                </td>
                <td>
                    <input type="text" name="discount_display[${selected.value}]"
                           value="${formatVND(0)}" class="form-control form-control-sm discount-display">
                    <input type="hidden" name="discount[${selected.value}]" value="0" class="discount-hidden">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger">Xóa</button>
                </td>
            `;
            productTable.appendChild(tr);

            const qtyInput = tr.querySelector(`[name^="quantity"]`);
            const priceHidden = tr.querySelector(`.price-hidden`);
            const priceDisplay = tr.querySelector(`[name^="product_price_output_display"]`);
            const discountHidden = tr.querySelector(`.discount-hidden`);
            const discountDisplay = tr.querySelector(`.discount-display`);
            const giftCheckbox = tr.querySelector(`[name^="is_gift"]`);

            function recalc() {
                if(giftCheckbox.checked) {
                    priceHidden.value = 0;
                    priceDisplay.value = formatVND(0);
                    discountHidden.value = 0;
                    discountDisplay.value = formatVND(0);
                    discountDisplay.disabled = true;
                } else {
                    priceHidden.value = price_output;
                    priceDisplay.value = formatVND(price_output);
                    discountDisplay.disabled = false;
                }
                updateTotal();
            }

            discountDisplay.addEventListener('blur', function() {
                let val = parseNumber(this.value);
                discountHidden.value = val;
                this.value = formatVND(val);
                updateTotal();
            });

            // Check tồn kho khi nhập số lượng (giữ nguyên code của bạn, chỉ thêm kiểm tra)
            qtyInput.addEventListener('input', function() {
                let qty = parseInt(this.value, 10);
                if (qty > maxQty) {
                    alert(`Số lượng chỉ còn ${maxQty}, bạn không thể chọn ${qty}.`);
                    this.value = maxQty;
                }
                if (qty < 1 || isNaN(qty)) {
                    this.value = 1;
                }
                updateTotal();
            });

            giftCheckbox.addEventListener('change', recalc);

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
