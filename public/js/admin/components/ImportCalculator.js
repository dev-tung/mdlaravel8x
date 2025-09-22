import Helper from "../utils/Helper.js";

export default class ImportCalculator {
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
