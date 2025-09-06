// formValidator.js
export function validator(formSelector, rules, onValidSubmit) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    // Các pattern sẵn có
    const patterns = {
        number  : /^[0-9]+$/,
        decimal : /^[0-9]+(\.[0-9]+)?$/,
        email   : /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        phone   : /^(0|\+84)(\d{9})$/,
        slug    : /^[a-z0-9]+(?:-[a-z0-9]+)*$/
    };

    const showError = (field, message) => {
        removeError(field);
        const error = document.createElement("div");
        error.className = "text-danger small mt-1 validation-error";
        error.innerText = message;
        field.classList.add("is-invalid");
        field.parentNode.appendChild(error);
    };

    const removeError = (field) => {
        field.classList.remove("is-invalid");
        const oldError = field.parentNode.querySelector(".validation-error");
        if (oldError) oldError.remove();
    };

    const validateField = (field) => {
        const name = field.name;
        const rule = rules[name];
        if (!rule) return true;

        let value = "";
        let isChecked = false;

        if (field.type === "checkbox" || field.type === "radio") {
            const group = form.querySelectorAll(`[name="${name}"]`);
            isChecked = Array.from(group).some(input => input.checked);
            value = isChecked ? "checked" : "";
        } else {
            value = field.value.trim();
        }

        // 1. Kiểm tra required
        if (rule.required && (value === "" || (field.type === "checkbox" || field.type === "radio") && !isChecked)) {
            showError(field, rule.message?.required || "Vui lòng nhập trường này.");
            return false;
        }

        // 2. Nếu không bắt buộc nhưng trống -> pass
        if (!rule.required && value === "") {
            removeError(field);
            return true;
        }

        // 3. Kiểm tra type có sẵn
        if (rule.type && patterns[rule.type] && !patterns[rule.type].test(value)) {
            showError(field, rule.message?.type || `Dữ liệu không đúng định dạng ${rule.type}.`);
            return false;
        }

        // 3.5. Min/max cho số
        if (rule.type === "number" || rule.type === "decimal") {
            let num = parseFloat(value);
            if (!isNaN(num)) {
                if (rule.min !== undefined && num < rule.min) {
                    showError(field, rule.message?.min || `Giá trị phải >= ${rule.min}.`);
                    return false;
                }
                if (rule.max !== undefined && num > rule.max) {
                    showError(field, rule.message?.max || `Giá trị phải <= ${rule.max}.`);
                    return false;
                }
            }
        }

        // 4. Custom pattern
        if (rule.pattern && !rule.pattern.test(value)) {
            showError(field, rule.message?.pattern || "Dữ liệu không hợp lệ.");
            return false;
        }

        // 5. Min length
        if (rule.minLength && value.length < rule.minLength) {
            showError(field, rule.message?.minLength || `Tối thiểu ${rule.minLength} ký tự.`);
            return false;
        }

        // 6. Max length
        if (rule.maxLength && value.length > rule.maxLength) {
            showError(field, rule.message?.maxLength || `Tối đa ${rule.maxLength} ký tự.`);
            return false;
        }

        // 7. Custom function
        if (rule.custom && typeof rule.custom === "function") {
            const result = rule.custom(value, field);
            if (result !== true) {
                showError(field, result || "Giá trị không hợp lệ.");
                return false;
            }
        }

        removeError(field);
        return true;
    };

    // Event: blur/change
    form.querySelectorAll("input, textarea, select").forEach(field => {
        field.addEventListener("blur", () => validateField(field));
        field.addEventListener("change", () => validateField(field));
    });

    // Submit
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        let isValid = true;
        form.querySelectorAll("input, textarea, select").forEach(field => {
            if (!validateField(field)) isValid = false;
        });
        if (isValid && typeof onValidSubmit === "function") {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                if (data[key]) {
                    if (!Array.isArray(data[key])) data[key] = [data[key]];
                    data[key].push(value);
                } else {
                    data[key] = value;
                }
            });
            onValidSubmit(data, form);
        }
    });
}
