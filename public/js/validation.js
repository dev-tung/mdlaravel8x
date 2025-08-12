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
    form.submit();
  });

  // Bắt event blur/change cho từng trường
  const inputs = form.querySelectorAll('input, select, textarea');
  inputs.forEach(input => {
    input.addEventListener('blur', () => validateField(input));
    input.addEventListener('change', () => validateField(input));
  });
}