import FormValidator from "../../shared/FormValidator.js";
import ImageComponent from '../../../components/ImageComponent.js';
import VariantComponent from '../../../components/VariantComponent.js';

export default class CreateFormHandler {
    constructor() {
        this.initValidator();
        this.initThumbPreview();
        this.initProductVariant();
    }

    initValidator() {
        new FormValidator(
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
        const imageComponent = new ImageComponent();
        imageComponent.Preview('thumbnail-image', 'thumbnail-image-preview');
    }

    initProductVariant(){
        new VariantComponent({
            wrapperId: 'variants-wrapper',
            addBtnId: 'add-variant',
            rowClass: 'variant-row',
            removeBtnClass: 'remove-variant'
        });
    }

}

document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
