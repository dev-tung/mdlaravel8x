export default class ModalComponent {
    constructor(contentHTML, { onOpen, onClose } = {}) {
        this.overlay = document.createElement("div");
        Object.assign(this.overlay.style, {
            display: "none",
            position: "fixed",
            inset: 0,
            background: "rgba(0,0,0,0.5)",
            zIndex: 10000,
            justifyContent: "center",
            alignItems: "center"
        });

        const modalBox = document.createElement("div");
        Object.assign(modalBox.style, {
            background: "#fff",
            padding: "20px",
            borderRadius: "8px",
            maxWidth: "600px",
            width: "90%",
            position: "relative",
            display: "flex",
            flexDirection: "column",
            gap: "15px"
        });

        modalBox.innerHTML = contentHTML;

        // nút đóng (X)
        const closeBtn = document.createElement("span");
        closeBtn.textContent = "×";
        Object.assign(closeBtn.style, {
            position: "absolute",
            top: "10px",
            right: "15px",
            cursor: "pointer",
            fontSize: "20px",
            fontWeight: "bold"
        });
        closeBtn.addEventListener("click", () => this.close());

        modalBox.appendChild(closeBtn);
        this.overlay.appendChild(modalBox);
        document.body.appendChild(this.overlay);

        this.onOpen = onOpen;
        this.onClose = onClose;

        this.overlay.addEventListener("click", e => {
            if (e.target === this.overlay) this.close();
        });
    }

    open() {
        this.overlay.style.display = "flex";
        if (this.onOpen) this.onOpen();
    }

    close() {
        this.overlay.style.display = "none";
        if (this.onClose) this.onClose();
    }

    get element() {
        return this.overlay.querySelector("div"); // modalBox
    }
}
