document.addEventListener("DOMContentLoaded", function () {
    initFormValidator("#productEditForm", {
        name: {
            required: true,
            minLength: 3,
            message: {
                required: "Tên sản phẩm là bắt buộc.",
                minLength: "Tên sản phẩm phải dài ít nhất 3 ký tự."
            }
        },
        taxonomy_id: {
            required: true,
            message: {
                required: "Danh mục sản phẩm là bắt buộc."
            }
        },
        price_input: {
            required: true,
            type: "decimal", // ✅ cho phép nhập 640.00
            min: 0,
            message: {
                required: "Giá nhập là bắt buộc.",
                type: "Giá nhập phải là số hợp lệ.",
                min: "Giá nhập không được nhỏ hơn 0."
            }
        },
        price_output: {
            required: true,
            type: "decimal", // ✅ cho phép nhập 640.00
            min: 0,
            message: {
                required: "Giá bán là bắt buộc.",
                type: "Giá bán phải là số hợp lệ.",
                min: "Giá bán không được nhỏ hơn 0."
            }
        },
        quantity: {
            required: true,
            type: "number", // số lượng thì chỉ cần nguyên
            min: 0,
            message: {
                required: "Số lượng là bắt buộc.",
                type: "Số lượng phải là số.",
                min: "Số lượng không được nhỏ hơn 0."
            }
        },
        unit: {
            required: false,
            minLength: 1,
            maxLength: 20,
            message: {
                maxLength: "Đơn vị không được vượt quá 20 ký tự."
            }
        },
        thumbnail: {
            required: false
        }
    }, function (data, form) {
        if (confirm("Bạn có chắc chắn muốn cập nhật sản phẩm này?")) {
            form.submit();
        }
    });

    // Preview ảnh mới, thay thế ảnh cũ
    const thumbnailInput = document.getElementById("thumbnail");
    const preview = document.getElementById("thumbnail-preview"); // ảnh cũ đang hiển thị

    if (thumbnailInput && preview) {
        thumbnailInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result; // Thay luôn ảnh cũ
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
