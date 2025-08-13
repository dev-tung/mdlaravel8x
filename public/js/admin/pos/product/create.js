function setupValidation(formId, rules, onSuccess) {
  const form = document.getElementById(formId);

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    let isValid = true;
    let firstErrorField = null;

    // Xóa lỗi cũ
    form.querySelectorAll('.error-msg').forEach(el => el.remove());

    // Lấy tất cả phần tử có name trong form
    form.querySelectorAll('[name]').forEach(field => {
      const fieldName = field.name;
      const config = rules[fieldName];
      if (!config) return; // nếu không có rule thì bỏ qua

      let value = '';

      // Lấy giá trị theo loại phần tử
      if (field.type === 'checkbox') {
        value = field.checked ? '1' : '';
      } else if (field.type === 'radio') {
        const checkedRadio = form.querySelector(`[name="${fieldName}"]:checked`);
        value = checkedRadio ? checkedRadio.value : '';
      } else if (field.tagName.toLowerCase() === 'select') {
        value = field.value;
      } else if (field.type === 'file') {
        value = field.files.length > 0 ? 'uploaded' : '';
      } else {
        value = field.value.trim();
      }

      let error = '';

      // Kiểm tra required
      if (config.required && (value === '' || value === null)) {
        error = config.message || 'Trường này là bắt buộc.';
      }

      // Kiểm tra validate custom
      if (!error && typeof config.validate === 'function') {
        const result = config.validate(value, field);
        if (result !== true) {
          error = result;
        }
      }

      // Nếu có lỗi
      if (error) {
        isValid = false;
        if (!firstErrorField) firstErrorField = field;
        const msg = document.createElement('div');
        msg.className = 'error-msg';
        msg.style.color = 'red';
        msg.textContent = error;
        field.insertAdjacentElement('afterend', msg);
      }
    });

    // Focus vào lỗi đầu tiên nếu có
    if (!isValid && firstErrorField) {
      firstErrorField.focus();
      firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    // Nếu hợp lệ → gọi callback
    if (isValid && typeof onSuccess === 'function') {
      const formData = {};
      form.querySelectorAll('[name]').forEach(input => {
        if (input.type === 'checkbox') {
          formData[input.name] = input.checked ? 1 : 0;
        } else if (input.type === 'radio') {
          const checkedRadio = form.querySelector(`[name="${input.name}"]:checked`);
          formData[input.name] = checkedRadio ? checkedRadio.value : '';
        } else if (input.type === 'file') {
          formData[input.name] = input.files.length > 0 ? input.files[0] : null;
        } else {
          formData[input.name] = input.value.trim();
        }
      });

      onSuccess(formData);
    }
  });
}

// Gọi hàm với rules + gọi API Laravel
setupValidation('posProductCreate', {
  category_id: {
    required: true,
    message: 'Vui lòng chọn danh mục sản phẩm.'
  },
  name: {
    required: true,
    validate: value => value.length >= 3 ? true : 'Tên sản phẩm phải ít nhất 3 ký tự.'
  },
  sku: {
    required: false,
    validate: value => value.length <= 20 ? true : 'SKU không được dài quá 20 ký tự.'
  },
  price: {
    required: true,
    validate: value => (!isNaN(value) && Number(value) >= 0) ? true : 'Giá phải là số >= 0.'
  },
  sale_price: {
    required: false,
    validate: value => (value === '' || (!isNaN(value) && Number(value) >= 0)) ? true : 'Giá KM phải là số >= 0.'
  },
  stock: {
    required: true,
    validate: value => (!isNaN(value) && Number(value) >= 0) ? true : 'Số lượng tồn kho phải là số >= 0.'
  },
  status: {
    required: true,
    validate: value => (value === '0' || value === '1') ? true : 'Trạng thái không hợp lệ.'
  },
  agree: {
    required: true,
    message: 'Bạn phải đồng ý trước khi gửi.'
  }
}, function (data) {
  // Chuẩn bị dữ liệu gửi (FormData hỗ trợ cả file)
  const formData = new FormData();
  for (let key in data) {
    formData.append(key, data[key]);
  }

  // Gọi API Laravel
  fetch('/api/product', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(result => {
      console.log(result);
    })
    .catch(err => {
      console.error('Lỗi API:', err);
      alert('Không thể kết nối đến server.');
    });
});