import Helper from "../utils/Helper.js";

export default class ProductImportSelector {
    constructor(products, searchInput, selectBox, tableBody, calculator, priceValidator, existingProducts = []) {
        this.products = Array.isArray(products) ? products : [];
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.tableBody = tableBody;
        this.calculator = calculator;
        this.priceValidator = priceValidator;
        this.selectedProducts = [];
        this.tableWrapper = document.getElementById('product-selected-table');

        this.bindEvents();

        if (Array.isArray(existingProducts) && existingProducts.length) {
            existingProducts.forEach(p => this.addProduct({
                id: p.id,
                name: p.name,
                quantity: p.quantity,
                price: p.price,
                is_gift: p.is_gift
            }, true));
        }
    }

    // -------------------- Bind events cho search + select --------------------
    bindEvents() {
        // debounce đúng: truyền function đã bind (giả sử Helper.debounce(fn, ms) có signature này)
        this.searchInput.addEventListener('input', Helper.debounce(this.onSearch.bind(this), 250));
        this.selectBox.addEventListener('change', this.onSelect.bind(this));
    }

    // -------------------- Tìm kiếm sản phẩm --------------------
    onSearch() {
        const term = (this.searchInput.value || '').toLowerCase().trim();
        this.selectBox.innerHTML = '';

        if (!term) {
            this.selectBox.style.display = 'none';
            return;
        }

        const filtered = this.products.filter(p => (p.name || '').toLowerCase().includes(term));

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
        // selectOptions bảo đảm làm việc với <select>
        const selected = (this.selectBox.selectedOptions && this.selectBox.selectedOptions[0]) || this.selectBox.options[this.selectBox.selectedIndex];
        if (!selected) return;

        const idStr = String(selected.value);
        // tránh thêm trùng (dựa vào data-id trên row)
        if (this.tableBody.querySelector(`tr[data-id="${idStr}"]`)) {
            // reset UI
            this.searchInput.value = '';
            this.selectBox.style.display = 'none';
            return;
        }

        const productData = {
            id: idStr,
            name: selected.dataset.name || selected.textContent || '',
            quantity: 1,
            price: 0,
            is_gift: 0
        };

        this.addProduct(productData, false);

        // reset UI
        this.searchInput.value = '';
        this.selectBox.style.display = 'none';
    }

    // -------------------- Hàm dùng chung để add product (new hoặc existing) --------------------
    addProduct(productData, isExisting = false) {
        // tránh duplicate trong selectedProducts
        if (this.selectedProducts.find(p => String(p.id) === String(productData.id))) return;

        const tr = this.renderRow(productData);
        this.tableBody.appendChild(tr);

        // lấy input trong row
        const qtyInput      = tr.querySelector(`[name^="quantity"]`);
        const priceHidden   = tr.querySelector(`.price-hidden`);
        const priceDisplay  = tr.querySelector(`[name^="product_import_price_display"]`);
        const giftCheckbox  = tr.querySelector(`[name^="is_gift"]`);

        // nếu là existing, set giá trị
        if (isExisting) {
            qtyInput.value = productData.quantity ?? 1;
            priceHidden.value = (productData.price !== undefined && productData.price !== null) ? productData.price : '';
            priceDisplay.value = productData.price ? Helper.formatVND(productData.price) : '';
            giftCheckbox.checked = !!productData.is_gift;
            if (productData.is_gift) priceDisplay.disabled = true;
        }

        // lưu ở dạng chuẩn (id => string, numbers chuẩn)
        const stored = {
            id: String(productData.id),
            name: productData.name || '',
            quantity: Number(productData.quantity) || 0,
            price: Number(productData.price) || 0,
            is_gift: productData.is_gift ? 1 : 0
        };

        this.selectedProducts.push(stored);

        // bind events, truyền reference tới item đã lưu để cập nhật trực tiếp
        this.bindRowEvents(tr, stored);

        // show table nếu cần
        if (this.tableWrapper) {
            this.tableWrapper.style.display = this.tableWrapper.tagName.toLowerCase() === 'table' ? 'table' : '';
        }

        // cập nhật tổng
        if (this.calculator && typeof this.calculator.updateTotal === 'function') {
            this.calculator.updateTotal(this.selectedProducts);
        }
    }

    // -------------------- Render 1 dòng sản phẩm --------------------
    renderRow(productData) {
        const id = String(productData.id);
        const tr = document.createElement('tr');
        tr.dataset.id = id;
        tr.innerHTML = `
            <td>
                <input type="hidden" name="product_id[]" value="${id}">
                ${productData.name || ''}
            </td>
            <td>
                <input type="number" name="quantity[${id}]" value="${productData.quantity ?? 1}" class="form-control form-control-sm" min="1">
            </td>
            <td>
                <input type="text" name="product_import_price_display[${id}]" value="" placeholder="Nhập giá..." class="form-control form-control-sm">
                <input type="hidden" name="product_import_price[${id}]" value="" class="price-hidden">
            </td>
            <td class="text-center">
                <input type="checkbox" name="is_gift[${id}]" value="1" class="form-check-input">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link btn-sm text-danger">Xóa</button>
            </td>
        `;
        return tr;
    }

    // -------------------- Bind event cho từng dòng --------------------
    bindRowEvents(tr, productDataRef) {
        const qtyInput      = tr.querySelector(`[name^="quantity"]`);
        const priceHidden   = tr.querySelector(`.price-hidden`);
        const priceDisplay  = tr.querySelector(`[name^="product_import_price_display"]`);
        const giftCheckbox  = tr.querySelector(`[name^="is_gift"]`);
        const deleteButton  = tr.querySelector('button');

        // Quantity change
        qtyInput.addEventListener('input', () => {
            productDataRef.quantity = Number(qtyInput.value) || 0;
            this.calculator?.updateTotal(this.selectedProducts);
        });

        // Focus: show raw number for editing
        priceDisplay.addEventListener('focus', e => {
            e.target.value = priceHidden.value || '';
            e.target.select();
        });

        // Input: live-parse -> lưu vào hidden + dữ liệu
        priceDisplay.addEventListener('input', e => {
            const parsed = Helper.parseVND(e.target.value) || 0;
            priceHidden.value = parsed;
            productDataRef.price = Number(parsed) || 0;
            this.calculator?.updateTotal(this.selectedProducts);
        });

        // Blur: validate + format
        priceDisplay.addEventListener('blur', e => {
            // call validator safely: if validate expects element, pass it; else call without param
            let ok = true;
            if (this.priceValidator && typeof this.priceValidator.validate === 'function') {
                try {
                    // First try calling with the element, fallback to no-arg
                    ok = this.priceValidator.validate(priceDisplay);
                } catch (err) {
                    try {
                        ok = this.priceValidator.validate();
                    } catch (err2) {
                        ok = true; // assume valid if validator misbehaves
                    }
                }
            }
            if (!ok) return;

            const num = Helper.parseVND(e.target.value) || 0;
            priceHidden.value = num;
            productDataRef.price = Number(num) || 0;
            e.target.value = num ? Helper.formatVND(num) : '';
            this.calculator?.updateTotal(this.selectedProducts);
        });

        // Gift checkbox
        giftCheckbox.addEventListener('change', e => {
            const isGift = !!e.target.checked;
            productDataRef.is_gift = isGift ? 1 : 0;

            if (isGift) {
                productDataRef.price = 0;
                priceHidden.value = '';
                priceDisplay.value = '';
                priceDisplay.disabled = true;
                if (this.priceValidator && typeof this.priceValidator.removeError === 'function') {
                    this.priceValidator.removeError(priceDisplay);
                }
            } else {
                priceDisplay.disabled = false;
                productDataRef.price = Number(priceHidden.value) || 0;
                priceDisplay.value = productDataRef.price ? Helper.formatVND(productDataRef.price) : '';
            }

            this.calculator?.updateTotal(this.selectedProducts);
        });

        // Delete row
        deleteButton.addEventListener('click', () => {
            tr.remove();
            if (!this.tableBody.children.length && this.tableWrapper) {
                this.tableWrapper.style.display = 'none';
            }
            this.selectedProducts = this.selectedProducts.filter(p => String(p.id) !== String(productDataRef.id));
            this.calculator?.updateTotal(this.selectedProducts);
        });
    }
}
