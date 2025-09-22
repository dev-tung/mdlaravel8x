import Service from "./Service.js"; // Base Service, wrapper fetch

export default class ImportService extends Service {
    async getSuppliers() {
        return this.get("/api/suppliers");
    }

    async getProducts() {
        return this.get("/api/products");
    }
}
