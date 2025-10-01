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

      input.addEventListener("change", e => {
          files = Array.from(e.target.files);
          preview.innerHTML = "";
          files.forEach(file => {
              const url = URL.createObjectURL(file);
              const img = document.createElement("img");
              Object.assign(img.style, {
                  width: "80px",
                  height: "80px",
                  objectFit: "cover",
                  borderRadius: "4px",
                  border: "1px solid #ccc"
              });
              img.src = url;
              preview.appendChild(img);
          });
      });

      btnSave.addEventListener("click", () => {
          if (onSave) onSave(files);
          close();
      });

      btnCancel.addEventListener("click", () => close());
      overlay.addEventListener("click", e => {
          if (e.target === overlay) close();
      });

      function open() { overlay.style.display = "flex"; }
      function close() { overlay.style.display = "none"; input.value = ""; files = []; preview.innerHTML = ""; }

      return { open, close };
  }
}
