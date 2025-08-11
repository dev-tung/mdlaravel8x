function setupValidation(formId, rules) {
  const form = document.getElementById(formId);
  if (!form) {
    console.warn(`Form với id="${formId}" không tồn tại.`);
    return;
  }

  // Hàm validate 1 trường theo rule
  function validateField(field) {
    const name = field.name;
    const value = field.type === 'checkbox' ? field.checked : field.value.trim();
    const rule = rules[name];
    let valid = true;
    let message = '';

    if (!rule) {
      // Nếu không có rule thì mặc định valid
      return true;
    }

    // Kiểm tra required
    if (rule.required) {
      if (field.type === 'checkbox') {
        if (!value) {
          valid = false;
          message = rule.message || 'Trường này là bắt buộc.';
        }
      } else {
        if (!value) {
          valid = false;
          message = rule.message || 'Trường này là bắt buộc.';
        }
      }
    }

    // Kiểm tra thêm các rule khác nếu trường vẫn valid
    if (valid && rule.validate) {
      const result = rule.validate(value);
      if (result !== true) {
        valid = false;
        message = result;
      }
    }

    // Hiển thị hoặc ẩn thông báo lỗi
    let feedback = field.parentNode.querySelector('.invalid-feedback');
    if (!feedback) {
      feedback = document.createElement('div');
      feedback.className = 'invalid-feedback';
      field.parentNode.appendChild(feedback);
    }
    feedback.textContent = message;

    if (valid) {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
    } else {
      field.classList.add('is-invalid');
      field.classList.remove('is-valid');
    }

    return valid;
  }

  // Validate toàn bộ form
  function validateForm() {
    const inputs = form.querySelectorAll('input, select, textarea');
    let allValid = true;
    inputs.forEach(input => {
      if (!validateField(input)) {
        allValid = false;
      }
    });
    return allValid;
  }

  // Bắt event submit form
  form.addEventListener('submit', function(event) {
    if (!validateForm()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  });

  // Bắt event blur/change cho từng trường
  const inputs = form.querySelectorAll('input, select, textarea');
  inputs.forEach(input => {
    input.addEventListener('blur', () => validateField(input));
    input.addEventListener('change', () => validateField(input));
  });
}


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
