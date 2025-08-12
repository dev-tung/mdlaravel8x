ClassicEditor
    .create(document.querySelector('#description'))
    .catch(error => {
        console.error(error);
    });

setupValidation('posProductCreate', {
  category_id: {
    required: true,
    message: 'Vui lòng chọn danh mục sản phẩm.'
  },
  name: {
    required: true,
    validate: value => value.length >= 3 ? true : 'Tên sản phẩm phải ít nhất 3 ký tự.'
  },
  slug: {
    required: true,
    validate: value => /^[a-z0-9\-]+$/.test(value) ? true : 'Slug chỉ được gồm chữ thường, số và dấu gạch ngang.'
  },
  sku: {
    required: false,
    validate: value => value.length <= 20 ? true : 'SKU không được dài quá 20 ký tự.'
  },
  price: {
    required: true,
    validate: value => (!isNaN(value) && Number(value) >= 0) ? true : 'Giá phải là số lớn hơn hoặc bằng 0.'
  },
  sale_price: {
    required: false,
    validate: value => (value === '' || (!isNaN(value) && Number(value) >= 0)) ? true : 'Giá khuyến mãi phải là số lớn hơn hoặc bằng 0.'
  },
  stock: {
    required: true,
    validate: value => (!isNaN(value) && Number(value) >= 0) ? true : 'Số lượng tồn kho phải là số lớn hơn hoặc bằng 0.'
  },
  status: {
    required: true,
    validate: value => (value === '0' || value === '1') ? true : 'Trạng thái không hợp lệ.'
  },
  agree: {
    required: true,
    message: 'Bạn phải đồng ý trước khi gửi.'
  }
});
