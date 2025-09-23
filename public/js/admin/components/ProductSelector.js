import Helper from "../utils/Helper.js";

export default class ProductSelector {
    constructor(products, searchInput, selectBox, tableBody, calculator, priceValidator, existingProducts = []) {
        this.products = products;
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.tableBody = tableBody;
        this.calculator = calculator;
        this.selectedProducts = []; // ← lưu sản phẩm đã chọn
        this.priceValidator = priceValidator;

        this.bindEvents();

        // Nếu có existingProducts (edit), render sẵn table
        if (existingProducts.length) {
            existingProducts.forEach(p => this.addExistingProduct(p));
        }
    }

    // -------------------- Bind events cho search + select --------------------
    bindEvents() {
        this.searchInput.addEventListener('input', Helper.debounce(() => this.onSearch()));
        this.selectBox.addEventListener('change', () => this.onSelect());
    }

    // -------------------- Tìm kiếm sản phẩm --------------------
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

    // -------------------- Chọn sản phẩm mới --------------------
    onSelect() {
        const selected = this.selectBox.selectedOptions[0];
        if (!selected || this.tableBody.querySelector(`[data-id="${selected.value}"]`)) return;

        const productData = {
            id: selected.value,
            name: selected.dataset.name,
            quantity: 1,
            price: 0,
            is_gift: 0
        };

        this.selectedProducts.push(productData);
        const tr = this.renderRow(selected);
        this.tableBody.appendChild(tr);
        this.bindRowEvents(tr, productData);

        document.getElementById('product-selected-table').style.display = 'table';
        this.searchInput.value = '';
        this.selectBox.style.display = 'none';

        this.calculator.updateTotal(this.selectedProducts);
    }

    // -------------------- Load product có sẵn (edit) --------------------
    addExistingProduct(p) {
        const selected = { value: p.id, dataset: { name: p.name } };
        const tr = this.renderRow(selected);
        this.tableBody.appendChild(tr);

        const qtyInput      = tr.querySelector(`[name^="quantity"]`);
        const priceHidden   = tr.querySelector(`.price-hidden`);
        const priceDisplay  = tr.querySelector(`[name^="product_import_price_display"]`);
        const giftCheckbox  = tr.querySelector(`[name^="is_gift"]`);

        // set giá trị theo existing product
        qtyInput.value = p.quantity;
        priceHidden.value = p.price;
        priceDisplay.value = p.price ? Helper.formatVND(p.price) : '';
        giftCheckbox.checked = !!p.is_gift;
        
        if (p.is_gift) priceDisplay.disabled = true;

        const productData = {
            id: p.id,
            name: p.name,
            quantity: p.quantity,
            price: p.price,
            is_gift: p.is_gift
        };
        this.selectedProducts.push(productData);

        
        this.bindRowEvents(tr, productData);
        
        document.getElementById('product-selected-table').style.display = 'table';

        this.calculator.updateTotal(this.selectedProducts);
    }


    // -------------------- Render 1 dòng sản phẩm --------------------
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
                <input type="checkbox" name="is_gift[${selected.value}]" value="1" class="form-check-input">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link btn-sm text-danger">Xóa</button>
            </td>
        `;
        return tr;
    }

    // -------------------- Bind event cho từng dòng --------------------
    bindRowEvents(tr, productData) {
        const qtyInput      = tr.querySelector(`[name^="quantity"]`);
        const priceHidden   = tr.querySelector(`.price-hidden`);
        const priceDisplay  = tr.querySelector(`[name^="product_import_price_display"]`);
        const giftCheckbox  = tr.querySelector(`[name^="is_gift"]`);

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
            if (!this.priceValidator.validate()) return;
            const num = Helper.parseVND(e.target.value);
            priceHidden.value = num;
            e.target.value = num ? Helper.formatVND(num) : '';
        });

        giftCheckbox.addEventListener('change', e => {
            const isGift = e.target.checked;
            productData.is_gift = isGift;

            if (isGift) {
                productData.price  = 0;
                priceHidden.value  = 0;
                priceDisplay.value = '';
                priceDisplay.disabled = true;
                this.priceValidator.removeError(priceDisplay);
            } else {
                priceDisplay.disabled = false;
                productData.price = parseFloat(priceHidden.value) || 0;
                priceDisplay.value = productData.price ? Helper.formatVND(productData.price) : '';
            }

            this.calculator.updateTotal(this.selectedProducts);
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
