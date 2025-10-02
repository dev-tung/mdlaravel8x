import FormValidator from "../../shared/FormValidator.js";
import ImageComponent from '../../../components/ImageComponent.js';
import RepeaterComponent from '../../../components/RepeaterComponent.js';
import EditorComponent from '../../../components/EditorComponent.js';

export default class CreateFormHandler {
    constructor() {
        this.validator();
        this.uploadIMG();
        this.addVariant();
        this.uploadVariantIMG();
        this.CKEditor();
    }

    validator() {
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

    uploadIMG() {
        new ImageComponent().Preview('thumbnail-image', 'thumbnail-image-preview');
    }

    addVariant(){
        new RepeaterComponent({
            wrapperId: 'variants-wrapper',
            addBtnId: 'add-variant',
            rowClass: 'variant-row',
            removeBtnClass: 'remove-variant'
        });
    }

    uploadVariantIMG() {
        document.addEventListener("click", e => {
            const btn = e.target.closest(".VariantThumbnailBtn");
            if (!btn) return;

            // Nếu chưa có uploader gắn vào button → tạo mới
            if (!btn.uploader) {
                btn.uploader = new ImageComponent().UploadOverlay(files => {
                    btn.files = files; // lưu files lại
                    btn.textContent = `(${files.length}) files`;
                });
            }

            // Nếu nút đã có files → set lại preview khi mở
            if (btn.files && btn.files.length) {
                btn.uploader.setFiles(btn.files);
            }

            btn.uploader.open();
        });
    }

    CKEditor(){
        new EditorComponent('#description').init();
    }

}

document.addEventListener("DOMContentLoaded", () => new CreateFormHandler());
