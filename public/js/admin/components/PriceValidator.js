export default class PriceValidator {
    constructor(tableBody, rowPriceName) {
        this.tableBody = tableBody;
        this.rowPriceName = rowPriceName;
    }

    showError(field, message) {
        this.removeError(field);
        field.classList.add("is-invalid");
        const error = document.createElement("div");
        error.className = "text-danger small mt-1 validation-error";
        error.innerText = message;
        field.parentNode.appendChild(error);
    }

    removeError(field) {
        field.classList.remove("is-invalid");
        const error = field.parentNode.querySelector(".validation-error");
        if (error) error.remove();
    }

    validate() {
        let hasInvalid = false;
        if (!this.tableBody) return true;

        this.tableBody.querySelectorAll('tr').forEach(tr => {
            const priceInput = tr.querySelector(`[name^="${this.rowPriceName}"]`);
            if (!priceInput) return;

            const price = parseFloat(priceInput.value.replace(/[^0-9.-]+/g,"")) || 0;

            if (price <= 0) {
                hasInvalid = true;
                this.showError(priceInput, "Giá không hợp lệ");
            } else {
                this.removeError(priceInput);
            }
        });

        return !hasInvalid;
    }
}
