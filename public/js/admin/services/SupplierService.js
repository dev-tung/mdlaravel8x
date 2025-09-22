import Service from "../shared/Service.js"; // Base Service, wrapper fetch

export default class SupplierService extends Service {
    constructor() {
        super('/api/suppliers'); // base URL cho suppliers
    }

    // Lấy danh sách suppliers, có thể truyền params (filter, pagination...)
    getSuppliers(params = {}) {
        return this.get('', params); // GET /api/suppliers
    }

    // Lấy 1 supplier theo ID
    getSupplier(id) {
        return this.get(`/${id}`); // GET /api/suppliers/123
    }

    // Tạo mới supplier
    createSupplier(data) {
        return this.post('', data); // POST /api/suppliers
    }

    // Cập nhật supplier
    updateSupplier(id, data) {
        return this.put(`/${id}`, data); // PUT /api/suppliers/123
    }

    // Xóa supplier
    deleteSupplier(id) {
        return this.delete(`/${id}`); // DELETE /api/suppliers/123
    }
}
