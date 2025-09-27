import Helper from "../utils/Helper.js";

export default class ProductExportSelector {
    constructor(products, searchInput, selectBox, tableBody, calculator, priceValidator, existingProducts = []) {
        this.products = products;
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.tableBody = tableBody;
        this.calculator = calculator;
        this.selectedProducts = [];
        this.priceValidator = priceValidator;

        this.bindEvents();

        if (existingProducts.length) {
            existingProducts.forEach(p => this.addExistingProduct(p));
        }
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
                option.dataset.price_sale = p.price_sale;
                option.textContent = p.name;
                this.selectBox.appendChild(option);
            });
            this.selectBox.style.display = 'block';
        } else {
            this.selectBox.style.display = 'none';
        }
    }

    onSelect() {
        const selectedOption = this.selectBox.selectedOptions[0];
        if (!selectedOption || this.tableBody.querySelector(`[data-id="${selectedOption.value}"]`)) return;

        const product = this.products.find(p => p.id == selectedOption.value);
        if (!product) return;

        const productData = {
            id: product.id,
            name: product.name,
            quantity: 1,
            price: product.price_sale || 0,
            discount: 0,
            is_gift: 0
        };

        this.selectedProducts.push(productData);
        const tr = this.renderRow(productData);
        this.tableBody.appendChild(tr);
        this.bindRowEvents(tr, productData);

        document.getElementById('product-selected-table').style.display = 'table';
        this.searchInput.value = '';
        this.selectBox.style.display = 'none';

        this.calculator.updateTotal(this.selectedProducts);
    }

    addExistingProduct(p) {
        const productData = {
            id: p.id,
            name: p.name,
            quantity: p.quantity,
            price: p.price_sale || 0,
            discount: p.discount || 0,
            is_gift: p.is_gift || 0
        };

        const tr = this.renderRow(productData);
        this.tableBody.appendChild(tr);

        // Set giá trị input
        tr.querySelector(`[name="quantity[${p.id}]"]`).value = p.quantity;
        tr.querySelector(`[name="discount[${p.id}]"]`).value = p.discount || 0;
        const discountDisplay = tr.querySelector(`[name="discount_display[${p.id}]"]`);
        discountDisplay.value = p.discount ? Helper.formatVND(p.discount) : '';
        const giftCheckbox = tr.querySelector(`[name="is_gift[${p.id}]"]`);
        giftCheckbox.checked = !!p.is_gift;
        if (p.is_gift) discountDisplay.disabled = true;

        this.selectedProducts.push(productData);
        this.bindRowEvents(tr, productData);

        this.calculator.updateTotal(this.selectedProducts);
    }

    renderRow(product) {
        const tr = document.createElement('tr');
        tr.dataset.id = product.id;
        tr.innerHTML = `
            <td>
                <input type="hidden" name="product_id[${product.id}]" value="${product.id}">
                ${product.name}
            </td>
            <td>
                <input type="number" name="quantity[${product.id}]" value="${product.quantity}" class="form-control form-control-sm" min="1">
            </td>
            <td>
                <input type="hidden" name="price_sale[${product.id}]" value="${product.price}">
                ${Helper.formatVND(product.price)}
            </td>
            <td>
                <input type="text" name="discount_display[${product.id}]" value="${product.discount ? Helper.formatVND(product.discount) : ''}" placeholder="Nhập triết khấu..." class="form-control form-control-sm">
                <input type="hidden" name="discount[${product.id}]" value="${product.discount}" class="discount-hidden">
            </td>
            <td class="text-center">
                <input type="checkbox" name="is_gift[${product.id}]" value="1" class="form-check-input" ${product.is_gift ? 'checked' : ''}>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link btn-sm text-danger">Xóa</button>
            </td>
        `;
        return tr;
    }

    bindRowEvents(tr, productData) {
        const qtyInput = tr.querySelector(`[name="quantity[${productData.id}]"]`);
        const discountHidden = tr.querySelector(`[name="discount[${productData.id}]"]`);
        const discountDisplay = tr.querySelector(`[name="discount_display[${productData.id}]"]`);
        const giftCheckbox = tr.querySelector(`[name="is_gift[${productData.id}]"]`);

        qtyInput.addEventListener('input', () => {
            productData.quantity = +qtyInput.value;
            this.calculator.updateTotal(this.selectedProducts);
        });

        discountDisplay.addEventListener('focus', e => {
            e.target.value = discountHidden.value || '';
            e.target.select();
        });

        discountDisplay.addEventListener('input', e => {
            discountHidden.value = Helper.parseVND(e.target.value);
            productData.discount = discountHidden.value;
            this.calculator.updateTotal(this.selectedProducts);
        });

        discountDisplay.addEventListener('blur', e => {
            const num = Helper.parseVND(e.target.value);
            discountHidden.value = num;
            e.target.value = num ? Helper.formatVND(num) : '';
        });

        giftCheckbox.addEventListener('change', e => {
            const isGift = e.target.checked;
            productData.is_gift = isGift;

            if (isGift) {
                productData.discount = 0;
                discountHidden.value = 0;
                discountDisplay.value = '';
                discountDisplay.disabled = true;
            } else {
                discountDisplay.disabled = false;
                productData.discount = parseFloat(discountHidden.value) || 0;
                discountDisplay.value = productData.discount ? Helper.formatVND(productData.discount) : '';
            }

            this.calculator.updateTotal(this.selectedProducts);
        });

        tr.querySelector('button').addEventListener('click', () => {
            tr.remove();
            this.selectedProducts = this.selectedProducts.filter(p => p.id !== productData.id);
            if (!this.tableBody.children.length) {
                document.getElementById('product-selected-table').style.display = 'none';
            }
            this.calculator.updateTotal(this.selectedProducts);
        });
    }
}
