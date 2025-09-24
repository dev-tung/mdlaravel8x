import FormValidator from "../../shared/FormValidator.js";

export default class FormHandler {
    constructor() {
        this.initValidator();
        this.initFormMode(); // phân tách create / edit
    }

    // -------------------- Form validation --------------------
    initValidator() {
        this.validator = new FormValidator(
            "#product-form",
            {
                name: { required: true },
                taxonomy_id: { required: true },
                supplier_id: { required: true },
                price_output: { required: true },
                unit: { required: true }
            },
            (formData, form) => {
                if (!this.priceValidator.validate()) return;
                this.onFormSubmit(formData, form);
            }
        );
    }

    // -------------------- Form mode --------------------
    initFormMode() {
        const productId = document.getElementById('product-id')?.value;
        this.isEdit = !!productId; // phân biệt create / edit
    }

    // -------------------- Submit --------------------
    onFormSubmit(formData, form) {
        form.submit();
    }
}

// -------------------- Khởi tạo khi DOM ready --------------------
document.addEventListener("DOMContentLoaded", () => new FormHandler());
