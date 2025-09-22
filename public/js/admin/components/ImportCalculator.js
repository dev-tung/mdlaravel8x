// ImportCalculator.js
import Helper from "../utils/Helper.js";

export default class ImportCalculator {
    /**
     * @param {HTMLElement} totalEl - element hiển thị tổng tiền
     */
    constructor(totalEl) {
        this.totalEl = totalEl;
    }

    /**
     * Cập nhật tổng tiền dựa trên danh sách sản phẩm đã chọn
     * @param {Array} selectedProducts - [{id, name, quantity, price}]
     */
    updateTotal(selectedProducts = []) {
        let total = 0;

        selectedProducts.forEach(p => {
            const qty = +p.quantity || 0;
            const price = +p.price || 0;
            total += qty * price;
        });

        if (this.totalEl) {
            this.totalEl.textContent = Helper.formatVND(total);
        }
    }
}
