import { Helper } from "../../shared/Helper.js";

class OrderCalculator {
    constructor(productTable, totalEl) {
        this.productTable = productTable;
        this.totalEl = totalEl;
    }

    updateTotal() {
        let total = 0;
        this.productTable.querySelectorAll('tr').forEach(tr => {
            const qty = parseFloat(tr.querySelector('[name^="quantity"]').value) || 0;
            const price = parseFloat(tr.querySelector('.price-hidden').value) || 0;
            const discount = parseFloat(tr.querySelector('.discount-hidden').value) || 0;
            total += qty * price - discount;
        });
        this.totalEl.textContent = Helper.formatVND(total);
    }
}

class CustomerSelector {
    constructor(customers, searchInput, selectBox, hiddenInput) {
        this.customers = customers;
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.hiddenInput = hiddenInput;
        this.bindEvents();
    }

    bindEvents() {
        this.searchInput.addEventListener('input', () => this.onSearch());
        this.selectBox.addEventListener('change', () => this.onSelect());
    }

    onSearch() {
        const term = this.searchInput.value.toLowerCase();
        this.selectBox.innerHTML = '';
        const filtered = this.customers.filter(c =>
            c.name.toLowerCase().includes(term) ||
            c.taxonomy?.name?.toLowerCase().includes(term)
        );
        if (filtered.length) {
            filtered.forEach(c => {
                const option = document.createElement('option');
                option.value = c.id;
                option.textContent = `${c.name} - ${c.taxonomy?.name ?? ''}`;
                this.selectBox.appendChild(option);
            });
            this.selectBox.style.display = 'block';
        } else {
            this.selectBox.style.display = 'none';
        }
    }

    onSelect() {
        const selected = this.selectBox.selectedOptions[0];
        if (selected) {
            this.hiddenInput.value = selected.value;
            this.searchInput.value = selected.textContent;
            this.selectBox.style.display = 'none';
        }
    }
}

class ProductSelector {
    constructor(products, searchInput, selectBox, tableBody, calculator) {
        this.products = products;
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.tableBody = tableBody;
        this.calculator = calculator;
        this.bindEvents();
    }

    bindEvents() {
        this.searchInput.addEventListener('input', () => this.onSearch());
        this.selectBox.addEventListener('change', () => this.onSelect());
    }

    onSearch() {
        const term = this.searchInput.value.toLowerCase();
        this.selectBox.innerHTML = '';
        const filtered = this.products.filter(p => p.name.toLowerCase().includes(term));

        if (filtered.length) {
            filtered.forEach(p => {
                let avg_price_input = 0;
                if (p.imports && p.imports.length > 0) {
                    const total = p.imports.reduce((sum, imp) => sum + parseFloat(imp.price_input || 0), 0);
                    avg_price_input = total / p.imports.length;
                }

                const option = document.createElement('option');
                option.value = p.id;
                option.dataset.price_output = p.price_output;
                option.dataset.price_input = avg_price_input;
                option.dataset.quantity = p.quantity;
                option.textContent =
                    `${p.name} - Nhập ${Helper.formatVND(avg_price_input)} - Bán ${Helper.formatVND(p.price_output)} - Còn ${p.quantity}`;
                this.selectBox.appendChild(option);
            });
            this.selectBox.style.display = 'block';
        } else {
            this.selectBox.style.display = 'none';
        }
    }

    onSelect() {
        const selected = this.selectBox.selectedOptions[0];
        if (!selected || document.getElementById('product-' + selected.value)) return;

        const price_output = parseFloat(selected.dataset.price_output);
        const price_input = parseFloat(selected.dataset.price_input);
        const maxQty = parseInt(selected.dataset.quantity, 10);

        const tr = document.createElement('tr');
        tr.id = 'product-' + selected.value;
        tr.innerHTML = (`
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
                       value="${Helper.formatVND(price_output)}" class="form-control form-control-sm" disabled>
                <input type="hidden" name="product_price_output[${selected.value}]" value="${price_output}" class="price-hidden">
                <input type="hidden" name="product_price_input[${selected.value}]" value="${price_input}">
            </td>
            <td>
                <input type="text" name="discount_display[${selected.value}]"
                       value="${Helper.formatVND(0)}" class="form-control form-control-sm discount-display">
                <input type="hidden" name="discount[${selected.value}]" value="0" class="discount-hidden">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger">Xóa</button>
            </td>
        `);

        this.tableBody.appendChild(tr);

        this.bindRowEvents(tr, selected, price_output, maxQty);
        document.getElementById('productSelectedTable').style.display = 'table';
        this.searchInput.value = '';
        this.selectBox.style.display = 'none';
        this.calculator.updateTotal();
    }

    bindRowEvents(tr, selected, price_output, maxQty) {
        const qtyInput = tr.querySelector(`[name^="quantity"]`);
        const priceHidden = tr.querySelector(`.price-hidden`);
        const priceDisplay = tr.querySelector(`[name^="product_price_output_display"]`);
        const discountHidden = tr.querySelector(`.discount-hidden`);
        const discountDisplay = tr.querySelector(`.discount-display`);
        const giftCheckbox = tr.querySelector(`[name^="is_gift"]`);

        const recalc = () => {
            if (giftCheckbox.checked) {
                priceHidden.value = 0;
                priceDisplay.value = Helper.formatVND(0);
                discountHidden.value = 0;
                discountDisplay.value = Helper.formatVND(0);
                discountDisplay.disabled = true;
            } else {
                priceHidden.value = price_output;
                priceDisplay.value = Helper.formatVND(price_output);
                discountDisplay.disabled = false;
            }
            this.calculator.updateTotal();
        };

        discountDisplay.addEventListener('blur', () => {
            const val = Helper.parseVND(discountDisplay.value);
            discountHidden.value = val;
            discountDisplay.value = Helper.formatVND(val);
            this.calculator.updateTotal();
        });

        qtyInput.addEventListener('input', () => {
            let qty = parseInt(qtyInput.value, 10);
            if (isNaN(qty) || qty < 1) qtyInput.value = 1;
            if (qty > maxQty) {
                alert(`Số lượng chỉ còn ${maxQty}`);
                qtyInput.value = maxQty;
            }
            this.calculator.updateTotal();
        });

        giftCheckbox.addEventListener('change', recalc);

        tr.querySelector('button').addEventListener('click', () => {
            tr.remove();
            selected.selected = false;
            this.calculator.updateTotal();
            if (this.tableBody.children.length === 0) {
                document.getElementById('productSelectedTable').style.display = 'none';
            }
        });
    }
}

class OrderForm {
    constructor() {
        this.calculator = new OrderCalculator(
            document.querySelector('#productSelectedTable tbody'),
            document.getElementById('totalAmount')
        );

        this.init();
    }

    async init() {
        try {
            // Gọi API song song
            const [customers, products] = await Promise.all([
                this.fetchData('/api/customers'),
                this.fetchData('/api/products'),
            ]);

            new CustomerSelector(
                customers,
                document.getElementById('customerSearch'),
                document.getElementById('customerSelect'),
                document.getElementById('customer_id')
            );

            new ProductSelector(
                products,
                document.getElementById('productSearch'),
                document.getElementById('productSelect'),
                document.querySelector('#productSelectedTable tbody'),
                this.calculator
            );

        } catch (err) {
            console.error("Lỗi khi load dữ liệu:", err);
            alert("Không thể tải dữ liệu khách hàng / sản phẩm.");
        }
    }

    async fetchData(url) {
        const res = await fetch(url, {
            headers: { "Accept": "application/json" }
        });
        if (!res.ok) throw new Error(`API lỗi ${res.status}`);
        return await res.json();
    }
}

// Khởi tạo khi DOM ready
document.addEventListener("DOMContentLoaded", () => new OrderForm());