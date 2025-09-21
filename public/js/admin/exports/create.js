import { Helper } from "../../shared/Helper.js";

// -------------------- Export Calculator --------------------
class ExportCalculator {
    constructor(productTable, totalEl) {
        this.productTable = productTable;
        this.totalEl = totalEl;
    }

    updateTotal() {
        let total = 0;
        for (const tr of this.productTable.querySelectorAll('tr')) {
            const qty = +tr.querySelector('[name^="quantity"]').value || 0;
            const price = +tr.querySelector('.price-hidden').value || 0;
            const discount = +tr.querySelector('.discount-hidden').value || 0;
            total += qty * price - discount;
        }
        this.totalEl.textContent = Helper.formatVND(total);
    }
}

// -------------------- Customer Selector --------------------
class CustomerSelector {
    constructor(customers, searchInput, selectBox, hiddenInput) {
        this.customers = customers;
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.hiddenInput = hiddenInput;
        this.bindEvents();
    }

    bindEvents() {
        this.searchInput.addEventListener('input', Helper.debounce(() => this.onSearch()));
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

// -------------------- Product Selector --------------------
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
        this.searchInput.addEventListener('input', Helper.debounce(() => this.onSearch()));
        this.selectBox.addEventListener('change', () => this.onSelect());
    }

    onSearch() {
        const term = this.searchInput.value.toLowerCase();
        this.selectBox.innerHTML = '';

        const filtered = this.products.filter(p => p.name.toLowerCase().includes(term));

        if (filtered.length) {
            filtered.forEach(p => {
                let avg_price_input = 0;
                if (p.imports?.length) {
                    const total = p.imports.reduce((sum, imp) => sum + (+imp.price_input || 0), 0);
                    avg_price_input = total / p.imports.length;
                }

                const option = document.createElement('option');
                option.value = p.id;
                option.dataset.price_output = p.price_output;
                option.dataset.price_input = avg_price_input;
                option.dataset.quantity = p.quantity;
                option.dataset.name = p.name;
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
        if (!selected || this.tableBody.querySelector(`[data-id="${selected.value}"]`)) return;

        const tr = this.renderRow(selected);
        this.tableBody.appendChild(tr);

        this.bindRowEvents(tr, selected);
        document.getElementById('productSelectedTable').style.display = 'table';
        this.searchInput.value = '';
        this.selectBox.style.display = 'none';
        this.calculator.updateTotal();
    }

    renderRow(selected) {
        const price_output = +selected.dataset.price_output;
        const price_input = +selected.dataset.price_input;
        const maxQty = +selected.dataset.quantity;

        const tr = document.createElement('tr');
        tr.dataset.id = selected.value;
        tr.innerHTML = `
            <td>
                <input type="hidden" name="product_id[]" value="${selected.value}">
                ${selected.dataset.name}
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
                <input type="hidden" name="product_import_price[${selected.value}]" value="${price_input}">
            </td>
            <td>
                <input type="text" name="discount_display[${selected.value}]"
                       value="${Helper.formatVND(0)}" class="form-control form-control-sm discount-display">
                <input type="hidden" name="discount[${selected.value}]" value="0" class="discount-hidden">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger">Xóa</button>
            </td>
        `;
        return tr;
    }

    bindRowEvents(tr, selected) {
        const qtyInput = tr.querySelector(`[name^="quantity"]`);
        const priceHidden = tr.querySelector(`.price-hidden`);
        const priceDisplay = tr.querySelector(`[name^="product_price_output_display"]`);
        const discountHidden = tr.querySelector(`.discount-hidden`);
        const discountDisplay = tr.querySelector(`.discount-display`);
        const giftCheckbox = tr.querySelector(`[name^="is_gift"]`);
        const maxQty = +qtyInput.max;
        const price_output = +priceHidden.value;

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

        qtyInput.addEventListener('input', () => {
            let qty = +qtyInput.value;
            if (!qty || qty < 1) qtyInput.value = 1;
            if (qty > maxQty) {
                alert(`Số lượng chỉ còn ${maxQty}`);
                qtyInput.value = maxQty;
            }
            this.calculator.updateTotal();
        });

        discountDisplay.addEventListener('blur', () => {
            const val = Helper.parseVND(discountDisplay.value);
            discountHidden.value = val;
            discountDisplay.value = Helper.formatVND(val);
            this.calculator.updateTotal();
        });

        giftCheckbox.addEventListener('change', recalc);

        tr.querySelector('button').addEventListener('click', () => {
            tr.remove();
            selected.selected = false;
            this.calculator.updateTotal();
            if (!this.tableBody.children.length) {
                document.getElementById('productSelectedTable').style.display = 'none';
            }
        });
    }
}

// -------------------- Export Form --------------------
class ExportForm {
    constructor() {
        this.calculator = new ExportCalculator(
            document.querySelector('#productSelectedTable tbody'),
            document.getElementById('totalAmount')
        );
        this.init();
    }

    async init() {
        try {
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
        try {
            const res = await fetch(url, { headers: { "Accept": "application/json" } });
            if (!res.ok) throw new Error(`API lỗi ${res.status}`);
            return await res.json();
        } catch (e) {
            console.error("Fetch error:", e);
            return [];
        }
    }
}

// -------------------- Init --------------------
document.addEventListener("DOMContentLoaded", () => new ExportForm());
