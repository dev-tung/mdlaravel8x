document.addEventListener("DOMContentLoaded", function() {
    // === Khởi tạo CKEditor cho description ===
    let descriptionEditor;
    ClassicEditor
        .create(document.querySelector('#description'))
        .then(editor => {
            descriptionEditor = editor;
            // Set chiều cao cố định
            const editable = editor.ui.view.editable.element;
            editable.style.minHeight = '400px';
            editable.style.height = '400px';
            editable.style.maxHeight = 'none';
            editable.style.overflowY = 'auto';
        })
        .catch(error => { console.error(error); });

    // === Khởi tạo form validator ===
    initFormValidator("#productCreateForm", {
        taxonomy_id: {
            required: true,
            type: "number",
            message: {
                required: "Danh mục sản phẩm là bắt buộc.",
                type: "Danh mục không hợp lệ."
            }
        },
        name: {
            required: true,
            minLength: 3,
            maxLength: 255,
            message: {
                required: "Tên sản phẩm là bắt buộc.",
                minLength: "Tên sản phẩm phải dài ít nhất 3 ký tự.",
                maxLength: "Tên sản phẩm không được vượt quá 255 ký tự."
            }
        },
        slug: {
            required: false,
            type: "slug",
            message: {
                type: "Slug chỉ chứa chữ thường, số và dấu gạch ngang."
            }
        },
        sku: {
            required: false,
            maxLength: 50,
            message: {
                maxLength: "SKU không được vượt quá 50 ký tự."
            }
        },
        price: {
            required: true,
            type: "number",
            min: 0,
            message: {
                required: "Giá gốc là bắt buộc.",
                type: "Giá gốc phải là số.",
                min: "Giá gốc phải lớn hơn hoặc bằng 0."
            }
        },
        sale_price: {
            required: false,
            type: "number",
            min: 0,
            custom: function(value, form) {
                const price = parseFloat(form.querySelector("#price").value) || 0;
                if (value && parseFloat(value) > price) {
                    return "Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.";
                }
                return true;
            },
            message: {
                type: "Giá khuyến mãi phải là số.",
                min: "Giá khuyến mãi phải lớn hơn hoặc bằng 0."
            }
        },
        stock: {
            required: true,
            type: "number",
            min: 0,
            message: {
                required: "Số lượng tồn kho là bắt buộc.",
                type: "Số lượng tồn kho phải là số nguyên.",
                min: "Số lượng tồn kho phải lớn hơn hoặc bằng 0."
            }
        },
        short_description: {
            required: false,
            maxLength: 500,
            message: {
                maxLength: "Mô tả ngắn không vượt quá 500 ký tự."
            }
        },
        description: {
            required: false,
            minLength: 5,
            message: {
                minLength: "Mô tả chi tiết phải ít nhất 5 ký tự."
            }
        },
        status: {
            required: true,
            custom: function(value) {
                if (!["active", "inactive"].includes(value)) {
                    return "Trạng thái không hợp lệ.";
                }
                return true;
            },
            message: {
                required: "Trạng thái là bắt buộc."
            }
        }
    }, function(data, form) {
        // Cập nhật dữ liệu CKEditor trước khi submit
        if (descriptionEditor) {
            form.querySelector('#description').value = descriptionEditor.getData();
        }
        form.submit();
    });
});
