import Helper from "../utils/Helper.js";

export default class SupplierSelector {
    constructor(suppliers, searchInput, selectBox, hiddenInput) {
        this.suppliers = suppliers;
        this.searchInput = searchInput;
        this.selectBox = selectBox;
        this.hiddenInput = hiddenInput;
        this.bindEvents();
    }

    bindEvents() {
        this.searchInput.addEventListener('input', Helper.debounce(() => this.onSearch()));
        this.selectBox.addEventListener('change', () => this.onSelect());
    }

    onSearch() {
        const term = this.searchInput.value.toLowerCase();
        this.selectBox.innerHTML = '';
        const filtered = this.suppliers.filter(s => s.name.toLowerCase().includes(term));

        if (filtered.length) {
            filtered.forEach(s => {
                const option = document.createElement('option');
                option.value = s.id;
                option.textContent = s.name;
                this.selectBox.appendChild(option);
            });
            this.selectBox.style.display = 'block';
        } else {
            this.selectBox.style.display = 'none';
        }
    }

    onSelect() {
        const selected = this.selectBox.selectedOptions[0];
        if (!selected) return;

        this.hiddenInput.value = selected.value;
        this.hiddenInput.dispatchEvent(new Event("change", { bubbles: true }));

        this.searchInput.value = selected.textContent;
        this.searchInput.dispatchEvent(new Event("blur", { bubbles: true }));

        this.selectBox.style.display = 'none';
    }
}
