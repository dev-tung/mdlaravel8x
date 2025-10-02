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
        const { wrapperId, addBtnId, rowClass, removeBtnClass, onCreated } = options;

        this.wrapper = document.getElementById(wrapperId);
        this.addBtn = document.getElementById(addBtnId);
        this.rowClass = rowClass;
        this.removeBtnClass = removeBtnClass;
        this.onCreated = onCreated;

        if (!this.wrapper || !this.addBtn || !this.rowClass || !this.removeBtnClass) return;

        // Đặt index = số lượng row hiện có
        this.repeaterIndex = this.wrapper.querySelectorAll(`.${this.rowClass}`).length;

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

        // clone row đầu tiên
        const template = this.wrapper.querySelector(`.${this.rowClass}`).cloneNode(true);

        // Xóa id để tránh trùng lặp
        template.removeAttribute('id');

        // cập nhật name cho input
        template.querySelectorAll('input, select, textarea').forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, `[${this.repeaterIndex}]`);
            }
            input.value = '';
        });

        this.wrapper.appendChild(template);

        // tăng index cho lần lặp tiếp theo
        this.repeaterIndex++;

        this.onCreated(template);
    }

    removeRepeater(target) {
        const row = target.closest(`.${this.rowClass}`);
        if (!row) return;

        const allRows = this.wrapper.querySelectorAll(`.${this.rowClass}`);
        if (allRows.length <= 1) {
            alert("Phải giữ lại ít nhất 1 dòng!");
            return;
        }

        row.remove();

        // Sau khi xóa, re-index lại toàn bộ
        this.reindex();
    }

    reindex() {
        const rows = this.wrapper.querySelectorAll(`.${this.rowClass}`);
        rows.forEach((row, index) => {
            row.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                }
            });
        });
        this.repeaterIndex = rows.length;
    }

    
}
