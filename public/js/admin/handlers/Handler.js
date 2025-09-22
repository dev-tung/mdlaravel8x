export default class Handler {
    constructor(service) {
        this.service = service;  // service API dùng chung
        this.validator = null;   // form validator, handler con sẽ khởi tạo nếu cần
        this.data = {};          // lưu cache dữ liệu chung nếu muốn
    }

    setData(key, value) {
        this.data[key] = value;
    }

    getData(key) {
        return this.data[key];
    }
}
