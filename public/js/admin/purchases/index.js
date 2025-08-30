// public/js/purchase.js

document.addEventListener('DOMContentLoaded', function () {

    function updateRowColor(row, statusSelect) {
        console.log(statusSelect);
        if (statusSelect.value !== 'received') {
            row.classList.add('TableWarning');
        } else {
            row.classList.remove('TableWarning');
        }
    }

    function setLoading(select, isLoading) {
        select.disabled = isLoading;
        if (isLoading) {
            select.classList.add('loading');
        } else {
            select.classList.remove('loading');
        }
    }

    document.querySelectorAll('tr[data-purchase-id]').forEach(function (row) {
        const statusSelect = row.querySelector('.UpdateStatus');
        const purchaseId = row.dataset.purchaseId;

        // Màu ban đầu
        updateRowColor(row, statusSelect);

        function updateField(field, value, selectEl) {
            setLoading(selectEl, true);

            fetch(`/api/purchases/update-field/${purchaseId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ field, value })
            })
            .then(res => {
                if (!res.ok) return res.json().then(errData => { throw errData; });
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    updateRowColor(row, statusSelect);
                } else {
                    alert('Cập nhật thất bại: ' + (data.message || 'Không xác định'));
                }
            })
            .catch(err => {
                console.error('Lỗi server:', err);
                let msg = err.message || err.errors || JSON.stringify(err);
                alert('Lỗi server: ' + msg);
            })
            .finally(() => {
                setLoading(selectEl, false);
            });
        }

        statusSelect.addEventListener('change', function () {
            updateRowColor(row, statusSelect); // đổi màu ngay
            updateField('status', this.value, this);
        });
    });
});
