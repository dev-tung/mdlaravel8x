import { FormValidator } from "../../shared/validator.js";

FormValidator("#taxonomyCreateForm", {
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
    console.log("✅ Form hợp lệ:", data);
    form.submit();
});