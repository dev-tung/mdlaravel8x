import FormValidator from "../../shared/FormValidator.js";
import ImageComponent from '../../../components/ImageComponent.js';
import VariantComponent from '../../../components/RepeaterComponent.js';
import EditorComponent from '../../../components/EditorComponent.js';

export default class CreateFormHandler {
    constructor() {
        this.initValidator();
        this.initThumbPreview();
        this.initProductVariant();
        this.initCKEditor();
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
        new ImageComponent().Preview('thumbnail-image', 'thumbnail-image-preview');
    }

    initProductVariant(){
        new VariantComponent({
            wrapperId: 'variants-wrapper',
            addBtnId: 'add-variant',
            rowClass: 'variant-row',
            removeBtnClass: 'remove-variant'
        });
    }

    initCKEditor(){
        const editor = new EditorComponent('#description');
        editor.init().then(() => {});
    }

}

document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
