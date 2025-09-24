import Service from "../shared/Service.js"; // Base Service, wrapper fetch

export default class ExportItemService extends Service {
    constructor() {
        super('/api/export-items'); // baseUrl trực tiếp cho export-items
    }

    getByExportId(exportId, params = {}) {
        return this.get(`/by-export/${exportId}`, params); // GET /api/export-items/by-export/:exportId
    }
}
