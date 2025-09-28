export default class VariantComponent {
  /**
   * Khởi tạo VariantComponent
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
    this.variantIndex = 1;

    if (!this.wrapper || !this.addBtn || !this.rowClass || !this.removeBtnClass) return;

    // Thêm row
    this.addBtn.addEventListener('click', () => this.addVariant());

    // Event delegation cho remove button
    this.wrapper.addEventListener('click', (e) => {
      if (e.target.classList.contains(this.removeBtnClass)) {
        this.removeVariant(e.target);
      }
    });
  }

  addVariant() {
    const template = this.wrapper.querySelector(`.${this.rowClass}`).cloneNode(true);

    template.querySelectorAll('input').forEach(input => {
      input.name = input.name.replace(/\d+/, this.variantIndex);
      input.value = '';
    });

    this.wrapper.appendChild(template);
    this.variantIndex++;
  }

    removeVariant(target) {
    const row = target.closest(`.${this.rowClass}`);
    if (!row) return;

    // Kiểm tra nếu là row đầu tiên thì không xóa
    const allRows = this.wrapper.querySelectorAll(`.${this.rowClass}`);
    if (allRows.length <= 1) {
        alert("Phải giữ ít nhất 1 variant!");
        return;
    }

    row.remove();
    }
}
