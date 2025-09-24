import Service from "../shared/Service.js"; // Base Service, wrapper fetch

export default class CustomerService extends Service {
    constructor() {
        super('/api/customers'); // base URL cho customers
    }

    // Lấy danh sách customers, có thể truyền params (filter, pagination...)
    getCustomers(params = {}) {
        return this.get('', params); // GET /api/customers
    }

    // Lấy 1 customer theo ID
    getCustomer(id) {
        return this.get(`/${id}`); // GET /api/customers/123
    }

    // Tạo mới customer
    createCustomer(data) {
        return this.post('', data); // POST /api/customers
    }

    // Cập nhật customer
    updateCustomer(id, data) {
        return this.put(`/${id}`, data); // PUT /api/customers/123
    }

    // Xóa customer
    deleteCustomer(id) {
        return this.delete(`/${id}`); // DELETE /api/customers/123
    }
}
