import Service from "../shared/Service.js"; // Base Service, wrapper fetch

export default class ProductService extends Service {
    constructor() {
        super('/api/products'); // base URL cho products
    }

    // Lấy danh sách products, có thể truyền params (filter, pagination...)
    getProducts(params = {}) {
        return this.get('', params); // GET /api/products
    }

    // Lấy 1 product theo ID
    getProduct(id) {
        return this.get(`/${id}`); // GET /api/products/123
    }

    // Tạo mới product
    createProduct(data) {
        return this.post('', data); // POST /api/products
    }

    // Cập nhật product
    updateProduct(id, data) {
        return this.put(`/${id}`, data); // PUT /api/products/123
    }

    // Xóa product
    deleteProduct(id) {
        return this.delete(`/${id}`); // DELETE /api/products/123
    }
}
