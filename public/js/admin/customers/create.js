document.addEventListener("DOMContentLoaded", function () {
    initFormValidator("#customerCreateForm", {
        name: {
            required: true,
            minLength: 3,
            message: {
                required: "Tên khách hàng là bắt buộc.",
                minLength: "Tên khách hàng phải dài ít nhất 3 ký tự."
            }
        },
        email: {
            required: false,
            type: "email",
            message: {
                type: "Email không hợp lệ."
            }
        },
        phone: {
            required: false,
            minLength: 9,
            maxLength: 15,
            message: {
                minLength: "Số điện thoại quá ngắn.",
                maxLength: "Số điện thoại quá dài."
            }
        },
        password: {
            required: false,
            minLength: 6,
            message: {
                minLength: "Mật khẩu phải ít nhất 6 ký tự."
            }
        }
    }, function(data, form) {
        form.submit();
    });
});

