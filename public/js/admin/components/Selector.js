export default class SelectorInput {
    constructor({ inputEl, options = [], mode = "single", onSelect = null }) {
        this.inputEl = inputEl;
        this.options = options;
        this.mode = mode;
        this.onSelect = onSelect;
        this.selectedOptions = [];
        this.highlightIndex = -1;

        // Dropdown
        this.dropdownEl = document.createElement("div");
        this.dropdownEl.style.position = "absolute";
        this.dropdownEl.style.border = "1px solid #ccc";
        this.dropdownEl.style.background = "#fff";
        this.dropdownEl.style.display = "none";
        this.dropdownEl.style.maxHeight = "200px";
        this.dropdownEl.style.overflowY = "auto";
        this.dropdownEl.style.zIndex = 1000;
        this.dropdownEl.style.boxSizing = "border-box";

        const parent = this.inputEl.parentNode;
        if (getComputedStyle(parent).position === "static") {
            parent.style.position = "relative";
        }
        parent.appendChild(this.dropdownEl);

        // Tag wrapper for multiple
        if (this.mode === "multiple") {
            this.tagWrapper = document.createElement("div");
            this.tagWrapper.style.display = "flex";
            this.tagWrapper.style.flexWrap = "wrap";
            this.tagWrapper.style.gap = "4px";
            this.tagWrapper.style.marginBottom = "2px";
            parent.insertBefore(this.tagWrapper, this.inputEl);
            this.tagWrapper.appendChild(this.inputEl);
            this.inputEl.style.flex = "1 1 auto";
        }

        this.bindEvents();
        this.renderDropdown();
    }

    bindEvents() {
        this.inputEl.addEventListener("input", () => this.renderDropdown());
        this.inputEl.addEventListener("focus", () => this.renderDropdown());
        this.inputEl.addEventListener("keydown", e => this.handleKeyDown(e));

        document.addEventListener("click", e => {
            if (!this.inputEl.contains(e.target) && !this.dropdownEl.contains(e.target)) {
                if (this.mode === "single") this.dropdownEl.style.display = "none";
                this.highlightIndex = -1;
            }
        });
    }

    renderDropdown() {
        const term = (this.inputEl.value || "").toLowerCase();
        let filtered;

        if (this.mode === "multiple") {
            filtered = this.options.filter(
                o => !this.selectedOptions.find(s => s.id === o.id) &&
                     o.label.toLowerCase().includes(term)
            );
        } else {
            filtered = this.options.filter(o => o.label.toLowerCase().includes(term));
        }

        this.dropdownEl.innerHTML = "";
        filtered.forEach((item, idx) => {
            const div = document.createElement("div");
            div.textContent = item.label;
            div.style.padding = "4px 8px";
            div.style.cursor = "pointer";
            if (idx === this.highlightIndex) div.style.background = "#eee";

            div.addEventListener("click", () => this.selectOption(item));
            this.dropdownEl.appendChild(div);
        });

        const hasFiltered = filtered.length > 0;
        const hasRemaining = this.mode === "multiple" && this.options.some(o => !this.selectedOptions.find(s => s.id === o.id));
        const isFocused = document.activeElement === this.inputEl;

        if (hasFiltered || (this.mode === "multiple" && hasRemaining && isFocused)) {
            this.dropdownEl.style.display = "block";
            this.dropdownEl.style.width = this.inputEl.offsetWidth + "px";
        } else {
            this.dropdownEl.style.display = "none";
        }
    }

    selectOption(item) {
        if (this.mode === "single") {
            this.selectedOptions = [item];
            this.inputEl.value = item.label;
            this.dropdownEl.style.display = "none";
        } else {
            if (!this.selectedOptions.find(o => o.id === item.id)) {
                this.selectedOptions.push(item);
            }
            this.inputEl.value = "";
            this.renderTags();
            this.renderDropdown(); // giữ mở dropdown
        }

        this.highlightIndex = -1;
        if (this.onSelect) this.onSelect(this.selectedOptions);
    }

    renderTags() {
        if (!this.tagWrapper) return;
        this.tagWrapper.querySelectorAll(".selector-tag").forEach(el => el.remove());

        this.selectedOptions.forEach(item => {
            const tag = document.createElement("div");
            tag.className = "selector-tag";
            tag.style.display = "flex";
            tag.style.alignItems = "center";
            tag.style.padding = "2px 6px";
            tag.style.background = "#eee";
            tag.style.borderRadius = "4px";
            tag.style.marginRight = "2px";

            const label = document.createElement("span");
            label.textContent = item.label;

            const removeBtn = document.createElement("span");
            removeBtn.textContent = "×";
            removeBtn.style.cursor = "pointer";
            removeBtn.style.marginLeft = "4px";
            removeBtn.addEventListener("click", () => this.removeOption(item));

            tag.appendChild(label);
            tag.appendChild(removeBtn);
            this.tagWrapper.insertBefore(tag, this.inputEl);
        });
    }

    removeOption(item) {
        this.selectedOptions = this.selectedOptions.filter(o => o.id !== item.id);
        if (this.mode === "multiple") this.renderTags();
        this.renderDropdown();
        if (this.onSelect) this.onSelect(this.selectedOptions);
    }

    handleKeyDown(e) {
        const visibleOptions = Array.from(this.dropdownEl.children);
        if (!visibleOptions.length) return;

        switch (e.key) {
            case "ArrowDown":
                e.preventDefault();
                this.highlightIndex = (this.highlightIndex + 1) % visibleOptions.length;
                this.updateHighlight(visibleOptions);
                break;
            case "ArrowUp":
                e.preventDefault();
                this.highlightIndex = (this.highlightIndex - 1 + visibleOptions.length) % visibleOptions.length;
                this.updateHighlight(visibleOptions);
                break;
            case "Enter":
                e.preventDefault();
                if (this.highlightIndex >= 0 && visibleOptions[this.highlightIndex]) {
                    const item = this.mode === "multiple"
                        ? this.options.filter(o => !this.selectedOptions.find(s => s.id === o.id))[this.highlightIndex]
                        : this.options.filter(o => o.label.toLowerCase().includes((this.inputEl.value || "").toLowerCase()))[this.highlightIndex];
                    if (item) this.selectOption(item);
                }
                break;
            case "Backspace":
                if (this.mode === "multiple" && this.inputEl.value === "" && this.selectedOptions.length) {
                    this.removeOption(this.selectedOptions[this.selectedOptions.length - 1]);
                }
                break;
        }
    }

    updateHighlight(visibleOptions) {
        visibleOptions.forEach((div, idx) => {
            div.style.background = idx === this.highlightIndex ? "#eee" : "#fff";
        });
    }

    getSelected() {
        return this.selectedOptions;
    }

    clear() {
        this.selectedOptions = [];
        this.inputEl.value = "";
        if (this.mode === "multiple") this.renderTags();
        this.renderDropdown();
        if (this.onSelect) this.onSelect(this.selectedOptions);
    }
}
