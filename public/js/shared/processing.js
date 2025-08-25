// === HTML Overlay ===
const overlay = document.createElement('div');
overlay.id = 'globalLoadingOverlay';
overlay.style.cssText = `
  display:none;
  position:fixed;
  inset:0;
  background:rgba(255,255,255,0.8);
  z-index:9999;
  justify-content:center;
  align-items:center;
  font-size:24px;
  color:#333;
`;
overlay.innerHTML = `<div>Đang xử lý...</div>`;
document.addEventListener('DOMContentLoaded', () => {
  // đảm bảo append sau cùng để luôn trên top
  document.body.appendChild(overlay);
});

// === Overlay helpers (có đếm số request đang chạy) ===
let pendingRequests = 0;
let navigationInProgress = false;

function showOverlayNav() {
  navigationInProgress = true;
  overlay.style.display = 'flex';
}
function clearNavFlag() {
  navigationInProgress = false;
  if (pendingRequests === 0) overlay.style.display = 'none';
}
function incOverlay() {
  pendingRequests++;
  overlay.style.display = 'flex';
}
function decOverlay() {
  pendingRequests = Math.max(0, pendingRequests - 1);
  if (pendingRequests === 0 && !navigationInProgress) {
    overlay.style.display = 'none';
  }
}

// === Reset khi trang hiển thị lại ===
window.addEventListener('pageshow', () => { pendingRequests = 0; clearNavFlag(); });
window.addEventListener('load', () => { pendingRequests = 0; clearNavFlag(); });

// === Show overlay khi điều hướng rời trang (an toàn, không dính form invalid) ===
window.addEventListener('beforeunload', () => {
  // Trình duyệt sắp điều hướng rời trang
  showOverlayNav();
});

// === Link nội bộ (loại bỏ #, javascript:, mailto:, tel:, download, target=_blank) ===
document.addEventListener('click', (e) => {
  const link = e.target.closest('a[href]');
  if (!link) return;

  const href = link.getAttribute('href');
  const sameHost = link.hostname === window.location.hostname;
  const isHash = href && href.startsWith('#');
  const isJS = href && href.startsWith('javascript:');
  const isSpecial = href && (href.startsWith('mailto:') || href.startsWith('tel:'));
  const newTab = link.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey || e.button === 1;
  const isDownload = link.hasAttribute('download');
  const optOut = link.dataset.noOverlay !== undefined;

  if (!href || isHash || isJS || isSpecial || !sameHost || newTab || isDownload || optOut) return;

  // Đợi 1 tick để xem có ai preventDefault() không (VD SPA/router)
  setTimeout(() => {
    if (!e.defaultPrevented) showOverlayNav();
  }, 0);
}, false);

// === Form submit: chỉ show nếu hợp lệ và không bị hủy ===
document.addEventListener('submit', (e) => {
  const form = e.target;
  if (!(form instanceof HTMLFormElement)) return;

  // Cho phép opt-out: <form data-no-overlay>
  if (form.dataset.noOverlay !== undefined) return;

  // Xác định nút submit được bấm (để xét formnovalidate/target)
  const submitter = e.submitter || document.activeElement;

  // Tôn trọng HTML5 validation trừ khi có formnovalidate
  const noValidate = form.noValidate || (submitter && submitter.formNoValidate);
  if (!noValidate && !form.checkValidity()) {
    // Không show overlay, để trình duyệt hiển thị lỗi
    return;
  }

  // Nếu submit sang tab mới thì cũng không cần overlay
  const target = (submitter && submitter.getAttribute('formtarget')) || form.getAttribute('target');
  if (target && target.toLowerCase() === '_blank') return;

  // Đợi hết các listener khác (có thể preventDefault để AJAX) rồi mới quyết định
  setTimeout(() => {
    if (!e.defaultPrevented) {
      // Submit thật (điều hướng) -> overlay theo luồng điều hướng
      showOverlayNav();
    }
    // Nếu có preventDefault() và gửi AJAX, overlay sẽ hiển thị ở fetch/axios bên dưới
  }, 0);
}, false);

// === Override fetch (đếm request) ===
if (window.fetch) {
  const originalFetch = window.fetch;
  window.fetch = function (...args) {
    incOverlay();
    return originalFetch.apply(this, args)
      .finally(() => { decOverlay(); });
  };
}

// === Axios interceptor (đếm request) ===
if (window.axios) {
  axios.interceptors.request.use(config => {
    incOverlay();
    return config;
  }, err => {
    decOverlay();
    return Promise.reject(err);
  });

  axios.interceptors.response.use(
    res => { decOverlay(); return res; },
    err => { decOverlay(); return Promise.reject(err); }
  );
}
