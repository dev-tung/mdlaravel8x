import { Helper } from "../../shared/Helper.js";

// -------------------- Import Calculator --------------------
class ImportCalculator {
    constructor(productTable, totalEl) {
        this.productTable = productTable;
        this.totalEl = totalEl;
    }

    updateTotal() {
        let total = 0;
        for (const tr of this.productTable.querySelectorAll('tr')) {
            const qty = +tr.querySelector('[name^="quantity"]').value || 0;
            const price = +tr.querySelector('.price-hidden').value || 0;
            total += qty * price;
        }
        this.totalEl.textContent = Helper.formatVND(total);
    }
}

// -------------------- Supplier Selector --------------------
class SupplierSelector {
    constructor(suppliers, searchInput, selectBox, hiddenInput) {
        this.suppliers = suppliers;
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

        const filtered = this.suppliers.filter(s => s.name.toLowerCase().includes(term));

        if (filtered.length) {
            filtered.forEach(s => {
                const option = document.createElement('option');
                option.value = s.id;
                option.textContent = s.name;
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
class ImportProductSelector {
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
                const option = document.createElement('option');
                option.value = p.id;
                option.dataset.name = p.name;
                option.textContent = p.name;
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

        this.bindRowEvents(tr);
        document.getElementById('productSelectedTable').style.display = 'table';
        this.searchInput.value = '';
        this.selectBox.style.display = 'none';
        this.calculator.updateTotal();
    }

    renderRow(selected) {
        const tr = document.createElement('tr');
        tr.dataset.id = selected.value;
        tr.innerHTML = `
            <td>
                <input type="hidden" name="product_id[]" value="${selected.value}">
                ${selected.dataset.name}
            </td>
            <td>
                <input type="number" name="quantity[${selected.value}]" value="1"
                       class="form-control form-control-sm" min="1">
            </td>
            <td>
                <input type="text" name="product_price_input_display[${selected.value}]"
                       value="" placeholder="Nhập giá..."
                       class="form-control form-control-sm text-end">
                <input type="hidden" name="product_price_input[${selected.value}]" value="" class="price-hidden">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger">Xóa</button>
            </td>
        `;
        return tr;
    }

    bindRowEvents(tr) {
        const qtyInput = tr.querySelector(`[name^="quantity"]`);
        const priceHidden = tr.querySelector(`.price-hidden`);
        const priceDisplay = tr.querySelector(`[name^="product_price_input_display"]`);

        qtyInput.addEventListener('input', () => {
            if (+qtyInput.value < 1) qtyInput.value = 1;
            this.calculator.updateTotal();
        });

        priceDisplay.addEventListener('focus', function() {
            this.value = priceHidden.value || '';
            this.select();
        });

        priceDisplay.addEventListener('input', function() {
            priceHidden.value = Helper.parseVND(this.value);
            this.calculator.updateTotal();
        }.bind(this));

        priceDisplay.addEventListener('blur', function() {
            const num = Helper.parseVND(this.value);
            priceHidden.value = num;
            this.value = num ? Helper.formatVND(num) : '';
            this.calculator.updateTotal();
        }.bind(this));

        tr.querySelector('button').addEventListener('click', () => {
            tr.remove();
            this.calculator.updateTotal();
            if (!this.tableBody.children.length) {
                document.getElementById('productSelectedTable').style.display = 'none';
            }
        });
    }
}

// -------------------- Import Form --------------------
class ImportForm {
    constructor() {
        this.calculator = new ImportCalculator(
            document.querySelector('#productSelectedTable tbody'),
            document.getElementById('totalAmount')
        );
        this.init();
    }

    async init() {
        try {
            const [suppliers, products] = await Promise.all([
                this.fetchData('/api/suppliers'),
                this.fetchData('/api/products'),
            ]);

            new SupplierSelector(
                suppliers,
                document.getElementById('supplierSearch'),
                document.getElementById('supplierSelect'),
                document.getElementById('supplier_id')
            );

            new ImportProductSelector(
                products,
                document.getElementById('productSearch'),
                document.getElementById('productSelect'),
                document.querySelector('#productSelectedTable tbody'),
                this.calculator
            );

        } catch (err) {
            console.error("Lỗi khi load dữ liệu:", err);
            alert("Không thể tải dữ liệu nhà cung cấp / sản phẩm.");
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
document.addEventListener("DOMContentLoaded", () => new ImportForm());
