export default class Helper {
    static formatVND(amount) {
        return Number(amount).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    static parseVND(str) {
        if (!str) return 0;
        return Number(str.toString().replace(/[^\d.-]/g, '')) || 0;
    }

    static debounce(fn, delay = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }
}
