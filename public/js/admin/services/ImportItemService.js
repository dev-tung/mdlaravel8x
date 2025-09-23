import Service from "../shared/Service.js"; // Base Service, wrapper fetch

export default class ImportItemService extends Service {
    constructor() {
        super('/api/import-items'); // baseUrl trực tiếp cho import-items
    }

    getByImportId(importId, params = {}) {
        return this.get(`/by-import/${importId}`, params); // GET /api/import-items/by-import/:importId
    }
}
