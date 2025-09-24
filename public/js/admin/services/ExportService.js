import Service from "../shared/Service.js"; // Base Service, wrapper fetch

export default class ExportService extends Service {
    constructor() {
        super('/api/exports'); // baseUrl trực tiếp cho export-items
    }

    // === Export Items ===
    getExports(params = {}) {
        return this.get('', params); // GET /api/export-items
    }

    getExport(id) {
        return this.get(`/${id}`); // GET /api/export-items/:id
    }

    createExport(data) {
        return this.post('', data); // POST /api/export-items
    }

    updateExport(id, data) {
        return this.put(`/${id}`, data); // PUT /api/export-items/:id
    }

    deleteExport(id) {
        return this.delete(`/${id}`); // DELETE /api/export-items/:id
    }
}
