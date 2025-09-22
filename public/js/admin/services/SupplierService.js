export async function fetchSuppliers() {
    try {
        const res = await fetch('/api/suppliers', { headers: { "Accept": "application/json" } });
        if (!res.ok) throw new Error(`API lỗi ${res.status}`);
        return await res.json();
    } catch (e) {
        console.error("Fetch suppliers error:", e);
        return [];
    }
}
