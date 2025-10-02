import ModalComponent from './ModalComponent.js';

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

  modalUpload(onSave) {
      const modal = new ModalComponent(`
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
      `);

      const root = modal.element;
      const input = root.querySelector(".upload-input");
      const preview = root.querySelector(".preview");
      const btnSave = root.querySelector(".btn-save");
      const btnCancel = root.querySelector(".btn-cancel");

      let files = [];

      function renderPreview(list) {
          preview.innerHTML = "";
          list.forEach((file, index) => {
              const url = URL.createObjectURL(file);
              const wrapper = document.createElement("div");
              Object.assign(wrapper.style, { position: "relative", cursor: "grab" });
              wrapper.draggable = true;
              wrapper.dataset.index = index;

              wrapper.addEventListener("dragstart", e => {
                  e.dataTransfer.setData("index", index);
                  wrapper.style.opacity = "0.5";
                  wrapper.style.cursor = "grabbing";
              });
              wrapper.addEventListener("dragend", () => {
                  wrapper.style.opacity = "1";
                  wrapper.style.cursor = "grab";
              });
              wrapper.addEventListener("dragover", e => e.preventDefault());
              wrapper.addEventListener("drop", e => {
                  e.preventDefault();
                  const fromIndex = +e.dataTransfer.getData("index");
                  const toIndex = +wrapper.dataset.index;
                  const moved = files.splice(fromIndex, 1)[0];
                  files.splice(toIndex, 0, moved);
                  renderPreview(files);
              });

              const img = document.createElement("img");
              Object.assign(img.style, {
                  width: "80px",
                  height: "80px",
                  objectFit: "cover",
                  borderRadius: "4px",
                  border: "1px solid #ccc"
              });
              img.src = url;

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
                  renderPreview(files);
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
          modal.close();
      });

      btnCancel.addEventListener("click", () => {
          files = [];
          preview.innerHTML = "";
          modal.close();
      });

      function open() { modal.open(); }
      function close(clear = false) {
          modal.close();
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
