import Helper from "../utils/Helper.js";
import PriceValidator from "./PriceValidator.js";

export default class ProductSelector {
    constructor(products, searchInput, selectBox, tableBody, calculator) {
        this.products = products;
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.tableBody = tableBody;
        this.calculator = calculator;
        this.selectedProducts = []; // ← lưu sản phẩm đã chọn
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

        // Thêm vào state
        const productData = {
            id: selected.value,
            name: selected.dataset.name,
            quantity: 1,
            price: 0 // giá mặc định
        };

        this.selectedProducts.push(productData);

        const tr = this.renderRow(selected);
        this.tableBody.appendChild(tr);
        this.bindRowEvents(tr, productData);

        document.getElementById('product-selected-table').style.display = 'table';
        this.searchInput.value = '';
        this.selectBox.style.display = 'none';
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
                <input type="number" name="quantity[${selected.value}]" value="1" class="form-control form-control-sm" min="1">
            </td>
            <td>
                <input type="text" name="product_import_price_display[${selected.value}]" value="" placeholder="Nhập giá..." class="form-control form-control-sm">
                <input type="hidden" name="product_import_price[${selected.value}]" value="" class="price-hidden">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link btn-sm text-danger">Xóa</button>
            </td>
        `;
        return tr;
    }

    bindRowEvents(tr, productData) {
        const qtyInput  = tr.querySelector(`[name^="quantity"]`);
        const priceHidden = tr.querySelector(`.price-hidden`);
        const priceDisplay = tr.querySelector(`[name^="product_import_price_display"]`);

        qtyInput.addEventListener('input', () => {
            productData.quantity = +qtyInput.value;
            this.calculator.updateTotal(this.selectedProducts);
        });

        priceDisplay.addEventListener('focus', e => {
            e.target.value = priceHidden.value || '';
            e.target.select();
        });

        priceDisplay.addEventListener('input', e => {
            priceHidden.value = Helper.parseVND(e.target.value);
            productData.price = priceHidden.value;
            this.calculator.updateTotal(this.selectedProducts);
        });

        priceDisplay.addEventListener('blur', e => {
            // validate giá
            const priceValidator = new PriceValidator();
            if (!priceValidator.validate()) return;

            const num = Helper.parseVND(e.target.value);
            priceHidden.value = num;
            e.target.value = num ? Helper.formatVND(num) : '';
        });

        tr.querySelector('button').addEventListener('click', () => {
            tr.remove();

            if (!this.tableBody.children.length) {
                document.getElementById('product-selected-table').style.display = 'none';
            }

            this.selectedProducts = this.selectedProducts.filter(p => p.id !== productData.id);
            this.calculator.updateTotal(this.selectedProducts);
        });
    }
}
