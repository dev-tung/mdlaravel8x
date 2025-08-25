// Khởi tạo form validator
document.addEventListener("DOMContentLoaded", function() {
    initFormValidator("#expenseCreateForm", {
        name: {
            required: true,
            minLength: 3,
            maxLength: 255,
            message: {
                required: "Tên chi phí là bắt buộc.",
                minLength: "Tên chi phí phải ít nhất 3 ký tự.",
                maxLength: "Tên chi phí không được vượt quá 255 ký tự."
            }
        },
        taxonomy_id: {
            required: true,
            type: "number",
            message: {
                required: "Loại chi phí là bắt buộc.",
                type: "Loại chi phí không hợp lệ."
            }
        },
        amount: {
            required: true,
            type: "number",
            min: 0,
            message: {
                required: "Số tiền là bắt buộc.",
                type: "Số tiền phải là số.",
                min: "Số tiền phải lớn hơn hoặc bằng 0."
            }
        },
        expense_date: {
            required: true,
            type: "date",
            message: {
                required: "Ngày chi là bắt buộc.",
                type: "Ngày chi không hợp lệ."
            }
        },
        note: {
            required: false,
            maxLength: 500,
            message: {
                maxLength: "Ghi chú không được vượt quá 500 ký tự."
            }
        }
    }, function(data, form) {
        // Submit form khi hợp lệ
        form.submit();
    });
});
