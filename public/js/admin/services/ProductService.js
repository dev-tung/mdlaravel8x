export async function fetchProducts() {
    try {
        const res = await fetch('/api/products', { headers: { "Accept": "application/json" } });
        if (!res.ok) throw new Error(`API lỗi ${res.status}`);
        return await res.json();
    } catch (e) {
        console.error("Fetch products error:", e);
        return [];
    }
}
