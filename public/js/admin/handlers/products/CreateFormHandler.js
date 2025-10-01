import FormValidator from "../../shared/FormValidator.js";
import ImageComponent from '../../../components/ImageComponent.js';
import RepeaterComponent from '../../../components/RepeaterComponent.js';
import EditorComponent from '../../../components/EditorComponent.js';

export default class CreateFormHandler {
    constructor() {
        this.initValidator();
        this.initThumbPreview();
        this.initProductVariant();
        this.initCKEditor();
        this.initUploadOverlay();
    }

    initValidator() {
        this.validator = new FormValidator(
            "#product-create-form",
            {
                "name": {
                    required: true,
                    message: { required: "Nhập tên sản phẩm" }
                },
                "taxonomy_id": {
                    required: true,
                    message: { required: "Chọn danh mục" }
                },
                "supplier_id": {
                    required: true,
                    message: { required: "Chọn nhà cung cấp" }
                },
                "variants\\[\\d+\\]\\[import_price\\]": { 
                    required: true, 
                    numeric: true,
                    message: { 
                        required: "Nhập giá nhập",
                        numeric: "Nhập số hợp lệ"
                    }
                },
                "variants\\[\\d+\\]\\[price_original\\]": { 
                    required: true, 
                    numeric: true,
                    message: { 
                        required: "Nhập giá gốc",
                        numeric: "Nhập số hợp lệ"
                    }
                },
                "variants\\[\\d+\\]\\[price_sale\\]": { 
                    required: true, 
                    numeric: true,
                    message: { 
                        required: "Nhập giá bán",
                        numeric: "Nhập số hợp lệ"
                    }
                },
                "variants\\[\\d+\\]\\[quantity\\]": { 
                    required: true, 
                    numeric: true,
                    message: { 
                        required: "Nhập số lượng",
                        numeric: "Nhập số hợp lệ"
                    }
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

    initUploadOverlay(){
        // --- Gắn với nút VariantThumbnailBtn ---
        document.addEventListener("click", e => {
            const btn = e.target.closest(".VariantThumbnailBtn");
            if (!btn) return;

            const uploader = new ImageComponent().UploadOverlay(files => {
                btn.textContent = `(${files.length}) files`; // update text button
                // có thể lưu vào hidden input để submit form
                console.log("Chọn ảnh cho variant:", files);
            });

            uploader.open();
        });

    }

}

document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
