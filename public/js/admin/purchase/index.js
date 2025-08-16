const apiUrl = '/api/product'; // Laravel API endpoint

// Hàm load danh sách sản phẩm
async function loadProducts(page = 1) {
  const formData = new FormData(document.getElementById('filterForm'));
  formData.append('page', page);

  const queryParams = new URLSearchParams(formData).toString();

  const res = await fetch(`${apiUrl}?${queryParams}`);
  const data = await res.json();

  renderTable(data.data);
  renderPagination(data);
}

// Hàm render bảng
function renderTable(products) {
  const tbody = document.getElementById('productTableBody');
  tbody.innerHTML = '';

  if (!products || products.length === 0) {
    tbody.innerHTML = `<tr><td colspan="9" class="text-center">Không có sản phẩm</td></tr>`;
    return;
  }

  products.forEach((p, index) => {
    tbody.innerHTML += `
      <tr>
        <td>${index + 1}</td>
        <td>${p.name}</td>
        <td>${p.category?.name ?? ''}</td>
        <td>${p.price}</td>
        <td>${p.sale_price ?? ''}</td>
        <td>${p.stock}</td>
        <td>${p.status}</td>
        <td>${p.created_at}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-warning">Sửa</button>
          <button class="btn btn-sm btn-danger">Xóa</button>
        </td>
      </tr>
    `;
  });
}

// Hàm render phân trang
function renderPagination(meta) {
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  if (!meta.last_page || meta.last_page <= 1) return;

  for (let i = 1; i <= meta.last_page; i++) {
    pagination.innerHTML += `
      <li class="page-item ${i === meta.current_page ? 'active' : ''}">
        <a class="page-link" href="#" data-page="${i}">${i}</a>
      </li>
    `;
  }

  document.querySelectorAll('#pagination .page-link').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const page = parseInt(e.target.dataset.page);
      loadProducts(page);
    });
  });
}

// Sự kiện lọc form
document.getElementById('filterForm').addEventListener('submit', e => {
  e.preventDefault();
  loadProducts();
});

// Gọi lần đầu
loadProducts();
