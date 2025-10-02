// FormValidator.js
import Helper from "../admin/utils/Helper.js"; // import helper có parseVND, formatVND...

export default class FormValidator {
    constructor(formSelector, rules, onValidSubmit) {
        this.form = document.querySelector(formSelector);
        if (!this.form) return;

        this.rules = rules;
        this.onValidSubmit = onValidSubmit;

        // Các pattern built-in
        this.patterns = {
            number: /^[0-9]+$/,                 
            decimal: /^[0-9]+(\.[0-9]+)?$/,     
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone: /^(0|\+84)(\d{9})$/,
            slug: /^[a-z0-9]+(?:-[a-z0-9]+)*$/,
            vnd: /^[\d.,]+$/
        };

        this.bindEvents();
    }

    showError(field, message) {
        this.removeError(field);
        const error = document.createElement("div");
        error.className = "text-danger small mt-1 validation-error";
        error.innerText = message;
        field.classList.add("is-invalid");
        field.parentNode.appendChild(error);
    }

    removeError(field) {
        field.classList.remove("is-invalid");
        const oldError = field.parentNode.querySelector(".validation-error");
        if (oldError) oldError.remove();
    }

    matchRule(rules, fieldName) {
        // Nếu có rule khớp chính xác thì trả về luôn
        if (rules[fieldName]) {
            return rules[fieldName];
        }

        // Nếu không thì duyệt tất cả keys xem có key nào là regex
        for (const key in rules) {
            try {
                const regex = new RegExp(`^${key}$`); // ví dụ key = variants\\[\\d+\\]\\[import_price\\]
                if (regex.test(fieldName)) {
                    return rules[key];
                }
            } catch (e) {
                // Nếu key không phải regex hợp lệ thì bỏ qua
            }
        }

        return null;
    }

    validateField(field) {
        const name = field.name;
        const rule = this.matchRule(this.rules, name);

        if (!rule) return true; // không có rule -> pass

        let value = "";
        let isChecked = false;

        if (field.type === "checkbox" || field.type === "radio") {
            const group = this.form.querySelectorAll(`[name="${name}"]`);
            isChecked = Array.from(group).some(input => input.checked);
            value = isChecked ? "checked" : "";
        } else {
            value = field.value.trim();
        }

        // 1. Bắt buộc
        if (rule.required) {
            // Nếu field không tồn tại trong form hoặc không có value hợp lệ
            if (!field || value === "" || ((field.type === "checkbox" || field.type === "radio") && !isChecked)) {
                this.showError(field, rule.message?.required || "Vui lòng nhập trường này.");
                return false;
            }
        }

        // 2. Không required mà rỗng -> pass
        if (!rule.required && value === "") {
            this.removeError(field);
            return true;
        }

        // 3. Kiểu dữ liệu
        if (rule.type) {
            if (rule.type === "vnd") {
                const num = Helper.parseVND(value);
                if (isNaN(num) || num <= 0) {
                    this.showError(field, rule.message?.type || "Giá trị tiền không hợp lệ.");
                    return false;
                }
            } else if (this.patterns[rule.type] && !this.patterns[rule.type].test(value)) {
                this.showError(field, rule.message?.type || `Dữ liệu không đúng định dạng ${rule.type}.`);
                return false;
            }
        }

        // 3.5. Min / Max cho số
        if (rule.type === "number" || rule.type === "decimal" || rule.type === "vnd") {
            let num = rule.type === "vnd" ? Helper.parseVND(value) : parseFloat(value);
            if (!isNaN(num)) {
                if (rule.min !== undefined && num < rule.min) {
                    this.showError(field, rule.message?.min || `Giá trị phải >= ${rule.min}.`);
                    return false;
                }
                if (rule.max !== undefined && num > rule.max) {
                    this.showError(field, rule.message?.max || `Giá trị phải <= ${rule.max}.`);
                    return false;
                }
            }
        }

        // 4. Pattern custom
        if (rule.pattern && !rule.pattern.test(value)) {
            this.showError(field, rule.message?.pattern || "Dữ liệu không hợp lệ.");
            return false;
        }

        // 5. Min length
        if (rule.minLength && value.length < rule.minLength) {
            this.showError(field, rule.message?.minLength || `Tối thiểu ${rule.minLength} ký tự.`);
            return false;
        }

        // 6. Max length
        if (rule.maxLength && value.length > rule.maxLength) {
            this.showError(field, rule.message?.maxLength || `Tối đa ${rule.maxLength} ký tự.`);
            return false;
        }

        this.removeError(field);
        return true;
    }

    bindEvents() {
        // lắng nghe blur
        this.form.addEventListener("blur", (e) => {
            const field = e.target;
            if (field.matches("input, textarea, select")) {
                if (this.validateField(field)) {
                    if (field.dataset.type === "vnd") {
                        const num = Helper.parseVND(field.value);
                        field.value = num ? Helper.formatVND(num) : "";
                    }
                }
            }
        }, true); // dùng capture để bắt blur

        // lắng nghe change
        this.form.addEventListener("change", (e) => {
            const field = e.target;
            if (field.matches("input, textarea, select")) {
                this.validateField(field);
            }
        });

        // lắng nghe input
        this.form.addEventListener("input", (e) => {
            const field = e.target;
            if (field.matches("input, textarea, select")) {
                this.validateField(field);
            }
        });

        // lắng nghe submit
        this.form.addEventListener("submit", (e) => {
            e.preventDefault();
            let isValid = true;

            this.form.querySelectorAll("input, textarea, select").forEach(field => {
                if (!this.validateField(field)) isValid = false;
            });

            if (isValid && typeof this.onValidSubmit === "function") {
                const formData = new FormData(this.form);
                const data = {};
                formData.forEach((value, key) => {
                    if (data[key]) {
                        if (!Array.isArray(data[key])) data[key] = [data[key]];
                        data[key].push(value);
                    } else {
                        data[key] = value;
                    }
                });

                const btn = this.form.querySelector('button[type="submit"]');
                if (btn) btn.disabled = true;
                this.onValidSubmit(data, this.form);
            }
        });
    }


}
