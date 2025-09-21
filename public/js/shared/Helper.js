export class Helper {
    static formatVND(amount) {
        return Number(amount).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    static parseVND(str) {
        return Number(str.replace(/[^\d.-]/g, '')) || 0;
    }

    static debounce(fn, delay = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }
}
