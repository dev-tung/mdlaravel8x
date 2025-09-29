export default class RepeaterComponent {
    /**
     * Khởi tạo RepeaterComponent
     * @param {Object} options - cấu hình DOM
     *   wrapperId: ID của container chứa các row
     *   addBtnId: ID nút thêm row
     *   rowClass: class row mẫu
     *   removeBtnClass: class nút xóa row
     */
    constructor(options) {
        const { wrapperId, addBtnId, rowClass, removeBtnClass } = options;

        this.wrapper = document.getElementById(wrapperId);
        this.addBtn = document.getElementById(addBtnId);
        this.rowClass = rowClass;
        this.removeBtnClass = removeBtnClass;
        this.repeaterIndex = 1;

        if (!this.wrapper || !this.addBtn || !this.rowClass || !this.removeBtnClass) return;

        // Thêm row
        this.addBtn.addEventListener('click', () => this.addRepeater());

        // Event delegation cho remove button
        this.wrapper.addEventListener('click', (e) => {
        if (e.target.classList.contains(this.removeBtnClass)) {
            this.removeRepeater(e.target);
        }
        });
    }

    addRepeater() {
        const template = this.wrapper.querySelector(`.${this.rowClass}`).cloneNode(true);

        template.querySelectorAll('input').forEach(input => {
        input.name = input.name.replace(/\d+/, this.repeaterIndex);
        input.value = '';
        });

        this.wrapper.appendChild(template);
        this.repeaterIndex++;
    }

    removeRepeater(target) {
        const row = target.closest(`.${this.rowClass}`);
        if (!row) return;

        // Kiểm tra nếu là row đầu tiên thì không xóa
        const allRows = this.wrapper.querySelectorAll(`.${this.rowClass}`);
        if (allRows.length <= 1) {
            alert("Phải giữ lại ít nhất 1 dòng!");
            return;
        }

        row.remove();
    }
}
