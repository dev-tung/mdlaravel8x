import { Validator } from "../../shared/validator.js";

class TaxonomyCreatePage {
    constructor() {
        this.initValidator();
        this.bindEvents();
    }

    initValidator() {
        this.validator = new Validator("#taxonomyCreateForm", {
            name: {
                required: true,
                minLength: 3,
                message: {
                    required: "Tên taxonomy là bắt buộc.",
                    minLength: "Tên taxonomy phải dài ít nhất 3 ký tự."
                }
            },
            slug: {
                required: false,
                type: "slug",
                message: {
                    type: "Slug chỉ chứa chữ thường, số và dấu gạch ngang."
                }
            },
            type: {
                required: true,
                message: {
                    required: "Chưa chọn loại taxonomy."
                }
            },
            status: {
                required: true,
                custom: (value) => {
                    if (!["active", "inactive", "1", "0"].includes(value)) {
                        return "Trạng thái không hợp lệ.";
                    }
                    return true;
                },
                message: {
                    required: "Trạng thái là bắt buộc."
                }
            }
        }, (data, form) => {
            this.onSubmit(data, form);
        });
    }

    bindEvents() {
        // Ví dụ thêm nút reset
        const resetBtn = document.querySelector("#btnReset");
        if (resetBtn) {
            resetBtn.addEventListener("click", () => {
                this.clearForm();
            });
        }
    }

    onSubmit(data, form) {
        // Submit logic
        console.log("Dữ liệu hợp lệ:", data);
        form.submit();
    }

    clearForm() {
        const form = document.querySelector("#taxonomyCreateForm");
        if (form) form.reset();
    }
}

// Khởi tạo khi DOM ready
document.addEventListener("DOMContentLoaded", () => new TaxonomyCreatePage());
