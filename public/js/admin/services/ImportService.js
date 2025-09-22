import Service from "../shared/Service.js"; // Base Service, wrapper fetch

export default class ImportService extends Service {
    constructor() {
        super('/api/import-items'); // baseUrl trực tiếp cho import-items
    }

    // === Import Items ===
    getImports(params = {}) {
        return this.get('', params); // GET /api/import-items
    }

    getImport(id) {
        return this.get(`/${id}`); // GET /api/import-items/:id
    }

    createImport(data) {
        return this.post('', data); // POST /api/import-items
    }

    updateImport(id, data) {
        return this.put(`/${id}`, data); // PUT /api/import-items/:id
    }

    deleteImport(id) {
        return this.delete(`/${id}`); // DELETE /api/import-items/:id
    }
}
