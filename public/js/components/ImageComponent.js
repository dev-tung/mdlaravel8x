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

  // Các hàm khác tùy ý...
}
