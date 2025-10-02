import FormValidator from "../../../components/ValidatorComponent.js";
import ImageComponent from '../../../components/ImageComponent.js';
import RepeaterComponent from '../../../components/RepeaterComponent.js';
import EditorComponent from '../../../components/EditorComponent.js';

export default class FormHandler {
    constructor() {
        this.validator();
        this.uploadIMG();
        this.addVariant();
        this.uploadVariantIMG();
        this.CKEditor();
    }

    validator() {
        this.validator = new FormValidator(
            "#product-form",
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
        const input = document.querySelector(".ProductImageInput");
        const preview = document.querySelector(".ProductPreview");

        if (!input) return;

        let files = [];

        input.addEventListener("change", e => {
            files = Array.from(e.target.files);
            renderPreview();
        });

        function renderPreview() {
            preview.innerHTML = "";

            files.forEach((file, index) => {
                const url = URL.createObjectURL(file);

                const wrapper = document.createElement("div");
                Object.assign(wrapper.style, {
                    position: "relative",
                    cursor: "grab"
                });
                wrapper.setAttribute("draggable", true);
                wrapper.dataset.index = index;

                const img = document.createElement("img");
                Object.assign(img.style, {
                    width: "100px",
                    height: "100px",
                    objectFit: "cover",
                    borderRadius: "4px",
                    border: "1px solid #ccc"
                });
                img.src = url;

                // Nút xóa
                const removeBtn = document.createElement("button");
                removeBtn.textContent = "×";
                Object.assign(removeBtn.style, {
                    position: "absolute",
                    top: "-6px",
                    right: "-6px",
                    width: "20px",
                    height: "20px",
                    borderRadius: "50%",
                    border: "none",
                    background: "rgba(0, 0, 0, 0.6)",
                    color: "#fff",
                    cursor: "pointer",
                    fontSize: "14px",
                    lineHeight: "18px",
                    textAlign: "center",
                    padding: 0
                });

                removeBtn.addEventListener("click", () => {
                    files.splice(index, 1);
                    syncInputFiles();
                    renderPreview();
                });

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                preview.appendChild(wrapper);

                // Drag events
                wrapper.addEventListener("dragstart", e => {
                    e.dataTransfer.setData("text/plain", index);
                });

                wrapper.addEventListener("dragover", e => {
                    e.preventDefault();
                    wrapper.style.border = "2px dashed #007bff";
                });

                wrapper.addEventListener("dragleave", () => {
                    wrapper.style.border = "1px solid #ccc";
                });

                wrapper.addEventListener("drop", e => {
                    e.preventDefault();
                    wrapper.style.border = "1px solid #ccc";
                    const fromIndex = +e.dataTransfer.getData("text/plain");
                    const toIndex = index;
                    if (fromIndex !== toIndex) {
                        const moved = files.splice(fromIndex, 1)[0];
                        files.splice(toIndex, 0, moved);
                        syncInputFiles();
                        renderPreview();
                    }
                });
            });
        }

        function syncInputFiles() {
            const dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            input.files = dt.files;
        }
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

            // Lấy index variant (nếu bạn render có data-index)
            const index = btn.dataset.index || 0;

            // Nếu chưa có uploader thì tạo
            if (!btn.uploader) {
                btn.uploader = new ImageComponent().modalUpload(files => {
                    btn.files = files;
                    btn.textContent = `(${files.length}) files`;

                    // Xoá hidden input cũ (chỉ trong variant container hiện tại)
                    const wrapper = btn.closest(".variant-row") || btn.parentElement;
                    wrapper.querySelectorAll(".variant-images-hidden").forEach(el => el.remove());

                    // Tạo hidden input cho mỗi ảnh
                    files.forEach(file => {
                        const hidden = document.createElement("input");
                        hidden.type = "hidden";
                        hidden.name = `variants[${index}][upload_images][]`;
                        hidden.className = "variant-images-hidden";

                        // Convert file -> base64 trước khi gán
                        const reader = new FileReader();
                        reader.onload = e => hidden.value = e.target.result;
                        reader.readAsDataURL(file);

                        wrapper.appendChild(hidden);
                    });
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
    () => new FormHandler()
);
