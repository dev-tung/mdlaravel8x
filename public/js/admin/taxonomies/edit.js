initFormValidator("#taxonomyEditForm", {
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
            required: "Slug bắt buộc.",
            type: "Slug chỉ chứa chữ thường, số và dấu gạch ngang."
        }
    },
    parent_id: {
        required: false,
        type: "number",
        message: {
            type: "Parent ID phải là số nguyên."
        }
    },
    type: {
        required: true,
        message: {
            required: "Loại taxonomy là bắt buộc."
        }
    },
    description: {
        required: false,
        minLength: 5,
        maxLength: 255,
        message: {
            minLength: "Mô tả phải ít nhất 5 ký tự.",
            maxLength: "Mô tả không được vượt quá 255 ký tự."
        }
    },
    status: {
        required: true,
        custom: function(value) {
            // chỉ chấp nhận active / inactive
            if (!["active", "inactive", "1", "0"].includes(value)) {
                return "Trạng thái không hợp lệ.";
            }
            return true;
        },
        message: {
            required: "Trạng thái là bắt buộc."
        }
    }
}, function(data, form) {
    // Submit form khi mọi thứ hợp lệ
    form.submit();
});
