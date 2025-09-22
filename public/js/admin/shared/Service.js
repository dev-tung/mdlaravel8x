export default class Service {
    constructor(baseUrl = '') {
        this.baseUrl = baseUrl;
    }

    // GET request
    async get(endpoint, params = {}, headers = {}) {
        const url = new URL(this.baseUrl + endpoint, window.location.origin);
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        return this.request(url, { method: 'GET', headers });
    }

    // POST request
    async post(endpoint, body = {}, headers = {}) {
        return this.request(this.baseUrl + endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', ...headers },
            body: JSON.stringify(body)
        });
    }

    // PUT request
    async put(endpoint, body = {}, headers = {}) {
        return this.request(this.baseUrl + endpoint, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', ...headers },
            body: JSON.stringify(body)
        });
    }

    // DELETE request
    async delete(endpoint, headers = {}) {
        return this.request(this.baseUrl + endpoint, { method: 'DELETE', headers });
    }

    // Core request handler
    async request(url, options) {
        try {
            const res = await fetch(url, options);
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return await res.json();
        } catch (err) {
            console.error('API Error:', err);
            throw err;
        }
    }
}
