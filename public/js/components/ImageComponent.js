// ImageComponent.js
export default class ImageComponent {
  
  /**
   * Khởi tạo preview cho một input và preview img
   * @param {string|HTMLElement} fileInputId - id hoặc selector của input
   * @param {string|HTMLElement} previewId - id hoặc selector của img preview
   */
  Preview(fileInputId, previewId) {
    const fileInput = typeof fileInputId === "string" ? document.getElementById(fileInputId) : fileInputId;
    const preview = typeof previewId === "string" ? document.getElementById(previewId) : previewId;

    if (fileInput && preview) {
      fileInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (e) => {
            preview.src = e.target.result;
            preview.style.display = "block";

            // Emit custom event
            const customEvent = new CustomEvent("image-selected", {
              detail: { file, dataURL: e.target.result },
              bubbles: true,
              composed: true
            });
            fileInput.dispatchEvent(customEvent);
          };
          reader.readAsDataURL(file);
        }
      });
    }
  }

  /**
   * Bạn có thể thêm các hàm khác ở đây
   */
  Reset(fileInputId, previewId) {
    const fileInput = typeof fileInputId === "string" ? document.getElementById(fileInputId) : fileInputId;
    const preview = typeof previewId === "string" ? document.getElementById(previewId) : previewId;
    if (fileInput) fileInput.value = "";
    if (preview) {
      preview.src = "";
      preview.style.display = "none";
    }
  }

  UploadOverlay(onSave) {
    const overlay = document.createElement("div");
    Object.assign(overlay.style, {
        display: "none",
        position: "fixed",
        inset: 0,
        background: "rgba(0,0,0,0.5)",
        zIndex: 10000,
        justifyContent: "center",
        alignItems: "center"
    });

    overlay.innerHTML = `
        <div style="
            background:#fff;
            padding:20px;
            border-radius:8px;
            max-width:600px;
            width:90%;
            display:flex;
            flex-direction:column;
            gap:15px;
        ">
            <h3>Upload hình ảnh</h3>
            <input type="file" multiple accept="image/*" class="upload-input form-control form-control-sm" />
            <div class="preview" style="
                display:flex;
                flex-wrap:wrap;
                gap:10px;
                max-height:200px;
                overflow:auto;
                border:1px solid #ddd;
                padding:10px;
                border-radius:4px;
            "></div>
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" class="btn-cancel btn btn-secondary">Hủy</button>
                <button type="button" class="btn-save btn btn-success">Lưu</button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    const input = overlay.querySelector(".upload-input");
    const preview = overlay.querySelector(".preview");
    const btnSave = overlay.querySelector(".btn-save");
    const btnCancel = overlay.querySelector(".btn-cancel");

    let files = [];

    // --- render preview ---
    function renderPreview(list) {
        preview.innerHTML = "";
        list.forEach((file, index) => {
            const url = URL.createObjectURL(file);
            const wrapper = document.createElement("div");
            Object.assign(wrapper.style, { 
              position: "relative",
              cursor: "grab"
            });
            wrapper.draggable = true;   
            wrapper.dataset.index = index;

            // --- drag event ---
            wrapper.addEventListener("dragstart", e => {
                e.dataTransfer.setData("index", index);
                wrapper.style.opacity = "0.5";
            });
            wrapper.addEventListener("dragend", () => {
                wrapper.style.opacity = "1";
            });
            wrapper.addEventListener("dragover", e => {
                e.preventDefault();
            });
            wrapper.addEventListener("drop", e => {
                e.preventDefault();
                const fromIndex = +e.dataTransfer.getData("index");
                const toIndex = +wrapper.dataset.index;

                // đổi vị trí trong mảng files
                const moved = files.splice(fromIndex, 1)[0];
                files.splice(toIndex, 0, moved);

                // render lại theo thứ tự mới
                renderPreview(files);
            });

            // --- ảnh ---
            const img = document.createElement("img");
            Object.assign(img.style, {
                width: "80px",
                height: "80px",
                objectFit: "cover",
                borderRadius: "4px",
                border: "1px solid #ccc"
            });
            img.src = url;

            // --- nút X ---
            const btnRemove = document.createElement("button");
            btnRemove.innerHTML = "×";
            Object.assign(btnRemove.style, {
                position: "absolute",
                top: "-5px",
                right: "-5px",
                width: "20px",
                height: "20px",
                background: "rgba(0,0,0,0.6)",
                color: "#fff",
                border: "none",
                borderRadius: "50%",
                cursor: "pointer",
                display: "flex",
                justifyContent: "center",
                alignItems: "center",
                fontSize: "14px",
                padding: "0"
            });
            btnRemove.addEventListener("click", () => {
                files.splice(index, 1);
                wrapper.remove();
            });

            wrapper.appendChild(img);
            wrapper.appendChild(btnRemove);
            preview.appendChild(wrapper);
        });
    }


    input.addEventListener("change", e => {
        files = Array.from(e.target.files);
        renderPreview(files);
    });

    btnSave.addEventListener("click", () => {
        if (onSave) onSave([...files]);
        close(); // đóng nhưng không xóa files
    });

    btnCancel.addEventListener("click", () => {
        close(true); // hủy thì reset files
    });

    overlay.addEventListener("click", e => {
        if (e.target === overlay) close(true);
    });

    function open() {
        overlay.style.display = "flex";
    }

    function close(clear = false) {
        overlay.style.display = "none";
        input.value = "";
        if (clear) {
            files = [];
            preview.innerHTML = "";
        }
    }

    function setFiles(newFiles) {
        files = [...newFiles];
        renderPreview(files);
    }

    return { open, close, setFiles, get files() { return files; } };
  }
}
