import FormValidator from "../../shared/FormValidator.js";

export default class CreateFormHandler {
    constructor() {
        this.initValidator();
        this.initEvents();
    }

    // -------------------- Form validation --------------------
    initValidator() {
        this.validator = new FormValidator(
            "#product-create-form",
            {
                name: { 
                    required: true 
                },
                taxonomy_id: { 
                    required: true 
                },
                supplier_id: { 
                    required: true 
                },
                import_price: { 
                    required: true,
                    numeric: true 
                },
                price_original: { 
                    required: true,
                    numeric: true 
                },
                price_sale: { 
                    required: true,
                    numeric: true 
                },
                quantity: { 
                    required: true 
                }
            },
            (formData, form) => {
                this.onFormSubmit(formData, form);
            }
        );
    }

    initEvents() {
        // === Preview ảnh mới ===
        const thumbnailInput = document.getElementById("thumbnail-image");
        const preview = document.getElementById("thumbnail-image-preview");
        if (thumbnailInput && preview) {
            thumbnailInput.addEventListener("change", (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        preview.src = e.target.result; // Hiển thị ảnh chọn
                        preview.style.display = "block"; // đảm bảo hiện ra
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }

    // -------------------- Submit --------------------
    onFormSubmit(formData, form) {
        form.submit();
    }
}

// -------------------- Khởi tạo khi DOM ready --------------------
document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
