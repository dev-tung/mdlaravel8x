initFormValidator("#supplierEditForm", {
    name: {
        required: true,
        minLength: 3,
        message: {
            required: "Tên nhà cung cấp là bắt buộc.",
            minLength: "Tên nhà cung cấp phải dài ít nhất 3 ký tự."
        }
    },
    phone: {
        required: false,
        type: "phone",
        message: {
            type: "Số điện thoại không hợp lệ."
        }
    },
    email: {
        required: false,
        type: "email",
        message: {
            type: "Email không hợp lệ."
        }
    },
    address: {
        required: false,
        minLength: 5,
        maxLength: 255,
        message: {
            minLength: "Địa chỉ phải dài ít nhất 5 ký tự.",
            maxLength: "Địa chỉ không được vượt quá 255 ký tự."
        }
    }
}, function (data, form) {
    form.submit();
});
