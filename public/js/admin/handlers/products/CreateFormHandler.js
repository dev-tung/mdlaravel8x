import FormValidator from "../../../components/FormValidator.js";
import ImageComponent from '../../../components/ImageComponent.js';
import RepeaterComponent from '../../../components/RepeaterComponent.js';
import EditorComponent from '../../../components/EditorComponent.js';

export default class CreateFormHandler {
    constructor() {
        this.initValidator();
        this.initThumbPreview();
        this.initProductVariant();
        this.initCKEditor();
    }

    initValidator() {
        this.validator = new FormValidator(
            "#product-create-form",
            {
                "name": { required: true, message: { required: "Nhập tên sản phẩm" } },
                "taxonomy_id": { required: true, message: { required: "Chọn danh mục" } },
                "supplier_id": { required: true, message: { required: "Chọn nhà cung cấp" } }
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
        new RepeaterComponent({
            wrapperId: 'variants-wrapper',
            addBtnId: 'add-variant',
            rowClass: 'variant-row',
            removeBtnClass: 'remove-variant'
        });
    }

    initCKEditor(){
        new EditorComponent('#description').init();
    }

}

document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
