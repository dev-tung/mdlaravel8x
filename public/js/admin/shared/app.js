// -------------------- Flash Messages --------------------
class FlashMessages {
    constructor(timeout = 5000) {
        this.timeout = timeout;
        this.init()
    }

    init() {
        setTimeout(() => this.hideAll(), this.timeout);
    }

    hideAll() {
        document.querySelectorAll('.alert').forEach(msg => {
            msg.classList.remove('show');
            msg.classList.add('fade');
            setTimeout(() => msg.remove(), 500);
        });
    }

    static show(type = 'info', message = '', timeout = 5000) {
        const container = document.body;
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} show`;
        alert.textContent = message;
        container.prepend(alert);
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500);
        }, timeout);
    }
}

// -------------------- Clickable Rows --------------------
class ClickableRows {
    constructor() {
        this.init()
    }

    init() {
        document.querySelectorAll('*[data-href]').forEach(row =>
            row.addEventListener('click', () => window.location = row.dataset.href)
        );
        document.querySelectorAll('.NoBubble').forEach(el =>
            el.addEventListener('click', e => e.stopPropagation())
        );
    }
}

// -------------------- Global Overlay --------------------
class GlobalOverlay {
    constructor() {
        this.pending = 0;
        this.navInProgress = false;

        // tạo overlay
        this.overlay = document.createElement('div');
        Object.assign(this.overlay.style, {
            display: 'none',
            position: 'fixed',
            inset: 0,
            background: 'rgba(255,255,255,0.8)',
            zIndex: 9999,
            justifyContent: 'center',
            alignItems: 'center',
            flexDirection: 'column',
            fontSize: '18px',
            color: '#333'
        });

        this.overlay.innerHTML = `
            <div style="display:flex; align-items:center; gap:10px;">
                <div class="global-overlay-spinner" style="
                    border: 6px solid #f3f3f3;
                    border-top: 6px solid #2271b1;
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    animation: spin 1s linear infinite;
                "></div>
                <div>Đang xử lý...</div>
            </div>
        `;

        document.body.appendChild(this.overlay);

        // thêm animation keyframes
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        this.initEvents();
        this.overrideFetch();
        this.overrideAxios();

        window.globalOverlay = {
            inc: () => this.inc(),
            dec: () => this.dec(),
            showNavigation: () => this.showNav(),
            clearNavigationFlag: () => this.clearNav()
        };
    }

    show = () => this.overlay.style.display = 'flex';
    hide = () => { if (this.pending === 0 && !this.navInProgress) this.overlay.style.display = 'none'; }
    inc = () => { this.pending++; this.show(); }
    dec = () => { this.pending = Math.max(0, this.pending - 1); this.hide(); }
    showNav = () => { this.navInProgress = true; this.show(); }
    clearNav = () => { this.navInProgress = false; this.hide(); }

    initEvents() {
        ['pageshow', 'load'].forEach(e => window.addEventListener(e, () => { this.pending = 0; this.clearNav(); }));
        window.addEventListener('beforeunload', this.showNav);

        document.addEventListener('click', this.handleLinkClick);
        document.addEventListener('submit', this.handleFormSubmit);
    }

    handleLinkClick = e => {
        const link = e.target.closest('a[href]');
        if (!link) return;

        const href = link.getAttribute('href');
        const sameHost = link.hostname === window.location.hostname;
        const isInvalid = !href || href.startsWith('#') || href.startsWith('javascript:') ||
            href.startsWith('mailto:') || href.startsWith('tel:') ||
            link.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey || e.button === 1 ||
            link.hasAttribute('download') || link.dataset.noOverlay !== undefined || !sameHost;

        if (isInvalid) return;
        setTimeout(() => { if (!e.defaultPrevented) this.showNav(); }, 0);
    }

    handleFormSubmit = e => {
        const form = e.target;
        if (!(form instanceof HTMLFormElement) || form.dataset.noOverlay !== undefined) return;

        const submitter = e.submitter || document.activeElement;
        const noValidate = form.noValidate || submitter?.formNoValidate;
        if (!noValidate && !form.checkValidity()) return;

        const target = (submitter?.getAttribute('formtarget')) || form.getAttribute('target');
        if (target?.toLowerCase() === '_blank') return;

        setTimeout(() => { if (!e.defaultPrevented) this.showNav(); }, 0);
    }

    overrideFetch() {
        if (!window.fetch) return;
        const original = window.fetch;
        window.fetch = (...args) => { this.inc(); return original(...args).finally(() => this.dec()); }
    }

    overrideAxios() {
        if (!window.axios) return;
        axios.interceptors.request.use(cfg => { this.inc(); return cfg; }, err => { this.dec(); return Promise.reject(err); });
        axios.interceptors.response.use(res => { this.dec(); return res; }, err => { this.dec(); return Promise.reject(err); });
    }
}

// -------------------- App --------------------
class App {
    constructor() {
        document.addEventListener('DOMContentLoaded', () => {
            new FlashMessages();
            new ClickableRows();
            new GlobalOverlay();
        });
    }
}

// Khởi tạo App
window.app = new App();
