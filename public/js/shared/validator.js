export class Validator {
    constructor(formSelector, rules, onValidSubmit) {
        this.form = document.querySelector(formSelector);
        if (!this.form) return;

        this.rules = rules;
        this.onValidSubmit = onValidSubmit;

        this.patterns = {
            number  : /^[0-9]+$/,
            decimal : /^[0-9]+(\.[0-9]+)?$/,
            email   : /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone   : /^(0|\+84)(\d{9})$/,
            slug    : /^[a-z0-9]+(?:-[a-z0-9]+)*$/
        };

        this.attachEvents();
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

    validateField(field) {
        const name = field.name;
        const rule = this.rules[name];
        if (!rule) return true;

        let value = "";
        let isChecked = false;

        if (field.type === "checkbox" || field.type === "radio") {
            const group = this.form.querySelectorAll(`[name="${name}"]`);
            isChecked = Array.from(group).some(input => input.checked);
            value = isChecked ? "checked" : "";
        } else {
            value = field.value.trim();
        }

        // 1. required
        if (rule.required && (value === "" || (field.type === "checkbox" || field.type === "radio") && !isChecked)) {
            this.showError(field, rule.message?.required || "Vui lòng nhập trường này.");
            return false;
        }

        // 2. optional but empty
        if (!rule.required && value === "") {
            this.removeError(field);
            return true;
        }

        // 3. type pattern
        if (rule.type && this.patterns[rule.type] && !this.patterns[rule.type].test(value)) {
            this.showError(field, rule.message?.type || `Sai định dạng ${rule.type}.`);
            return false;
        }

        // 4. min/max number
        if (rule.type === "number" || rule.type === "decimal") {
            let num = parseFloat(value);
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

        // 5. custom regex
        if (rule.pattern && !rule.pattern.test(value)) {
            this.showError(field, rule.message?.pattern || "Dữ liệu không hợp lệ.");
            return false;
        }

        // 6. min/max length
        if (rule.minLength && value.length < rule.minLength) {
            this.showError(field, rule.message?.minLength || `Tối thiểu ${rule.minLength} ký tự.`);
            return false;
        }
        if (rule.maxLength && value.length > rule.maxLength) {
            this.showError(field, rule.message?.maxLength || `Tối đa ${rule.maxLength} ký tự.`);
            return false;
        }

        // 7. custom function
        if (rule.custom && typeof rule.custom === "function") {
            const result = rule.custom(value, field);
            if (result !== true) {
                this.showError(field, result || "Giá trị không hợp lệ.");
                return false;
            }
        }

        this.removeError(field);
        return true;
    }

    attachEvents() {
        // blur/change
        this.form.querySelectorAll("input, textarea, select").forEach(field => {
            field.addEventListener("blur", () => this.validateField(field));
            field.addEventListener("change", () => this.validateField(field));
        });

        // submit
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
                this.onValidSubmit(data, this.form);
            }
        });
    }
}
