import FormValidator from "../../shared/FormValidator.js";
import ImageComponent from '../../../components/ImageComponent.js';
import VariantComponent from '../../../components/RepeaterComponent.js';

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
        const loadCKEditor = new Promise((resolve, reject) => {
            if (window.ClassicEditor) return resolve();
            const script = document.createElement('script');
            script.src = '/js/libraries/ckeditor.js';
            script.onload = () => resolve();
            script.onerror = () => reject(new Error('Không load được CKEditor từ CDN'));
            document.head.appendChild(script);
        });

        loadCKEditor.then(() => {
            if (typeof ClassicEditor !== 'undefined') {
                ClassicEditor
                    .create(document.querySelector('#description'))
                    .catch(error => {
                        console.error(error);
                    });
            }
        }).catch(error => console.error('Lỗi load CKEditor:', error));
    }

}

document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
