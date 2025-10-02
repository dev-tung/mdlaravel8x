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
            removeBtnClass: 'remove-variant',
            onCreated: (template) => {
                const btn = template.querySelector(".VariantThumbnailBtn");
                if (btn) {
                    btn.textContent = "(0) files";
                    btn.files = [];          // reset files
                    btn.uploader = null;     // reset uploader
                }
            }
        });
    }

    uploadVariantIMG() {
        document.addEventListener("click", e => {
            const btn = e.target.closest(".VariantThumbnailBtn");
            if (!btn) return;

            // Nếu chưa có uploader thì tạo
            if (!btn.uploader) {
                // Tạo hidden input gắn kèm button (nếu chưa có)
                let hidden = btn.nextElementSibling;
                if (!hidden || hidden.className !== "variant-images-hidden") {
                    hidden = document.createElement("input");
                    hidden.type = "hidden";
                    hidden.name = "variant_images[]";   // 👈 tuỳ bạn muốn đặt name gì
                    hidden.className = "variant-images-hidden";
                    btn.insertAdjacentElement("afterend", hidden);
                }

                btn.uploader = new ImageComponent().UploadOverlay(async files => {
                    btn.files = files;
                    btn.textContent = `(${files.length}) files`;

                    // Convert file -> base64
                    const base64List = await Promise.all(
                        files.map(file => {
                            return new Promise(resolve => {
                                const reader = new FileReader();
                                reader.onload = e => resolve(e.target.result);
                                reader.readAsDataURL(file);
                            });
                        })
                    );

                    // Lưu vào hidden input (dưới dạng JSON string)
                    hidden.value = JSON.stringify(base64List);
                    console.log("Chọn ảnh cho variant:", files, "Hidden value:", hidden.value);
                });
            }

            // Nếu nút đã có files thì set lại preview
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

document.addEventListener("DOMContentLoaded", 
    () => new CreateFormHandler()
);
