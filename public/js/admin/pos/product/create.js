initFormValidator("#posProductCreate", {
    name: {
        required: true,
        minLength: 3,
        message: {
            required: "Tên sản phẩm bắt buộc.",
            minLength: "Tên sản phẩm phải dài ít nhất 3 ký tự."
        }
    },
    category_id: {
        required: true,
        message: { required: "Vui lòng chọn danh mục." }
    },
    price: {
        required: true,
        type: "number",
        message: {
            required: "Giá gốc bắt buộc.",
            type: "Giá gốc phải là số nguyên."
        }
    },
    sale_price: {
        required: false,
        type: "number",
        message: { type: "Giá khuyến mãi phải là số nguyên." }
    },
    slug: {
        required: true,
        type: "slug",
        message: { type: "Slug chỉ chứa chữ thường, số và dấu gạch ngang." }
    }
}, function (data, form) {



    fetch('/api/product', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // Laravel trả JSON
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // nếu là web route
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(data => {
        console.log('Thành công:', data);
    })
    .catch(err => {
        console.error('Lỗi:', err);
    });





});
