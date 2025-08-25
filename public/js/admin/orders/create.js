initFormValidator("#orderCreateForm", {
    customer_id: {
        required: true,
        message: {
            required: "Khách hàng là bắt buộc."
        }
    },
    product_id: {
        required: true,
        message: {
            required: "Sản phẩm là bắt buộc."
        }
    }
}, function(data, form) {
    form.submit();
});
