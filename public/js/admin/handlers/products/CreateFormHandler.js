import FormValidator from "../../shared/FormValidator.js";

export default class CreateFormHandler {
    constructor() {
        this.initValidator();
        this.initThumbPreview();
        this.initProductVariant();
    }

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
                form.submit();
            }
        );
    }

    initThumbPreview() {
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

    initProductVariant(){
        let variantIndex = 1;

        document.getElementById('add-variant')?.addEventListener('click', () => {
            const wrapper = document.getElementById('variants-wrapper');
            const template = document.querySelector('.variant-row').cloneNode(true);

            template.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\d+/, variantIndex);
                input.value = '';
            });

            wrapper.appendChild(template);
            variantIndex++;
        });

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('.variant-row').remove();
            }
        });
    }

}

document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
