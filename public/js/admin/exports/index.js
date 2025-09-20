document.addEventListener('DOMContentLoaded', function () {

    function updateRowColor(row, statusSelect, paymentSelect) {
        if(statusSelect.value !== 'completed' || paymentSelect.value == 'pending') {
            row.classList.add('TableWarning');
        } else {
            row.classList.remove('TableWarning');
        }
    }

    document.querySelectorAll('tr[data-order-id]').forEach(function(row) {
        const statusSelect  = row.querySelector('.UpdateStatus');
        const paymentSelect = row.querySelector('.UpdatePayment');
        const orderId = row.dataset.orderId;

        updateRowColor(row, statusSelect, paymentSelect);

        function updateField(field, value) {

            fetch(`/api/orders/update-field/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ field, value })
            })
            .then(res => {
                if(!res.ok) return res.json().then(errData => { throw errData; });
                return res.json();
            })
            .then(data => {
                if(data.success) {
                    updateRowColor(row, statusSelect, paymentSelect);
                } else {
                    alert('Cập nhật thất bại: ' + (data.message || 'Không xác định'));
                }
            })
            .catch(err => {
                // Nếu server trả lỗi validate hoặc 500, show chi tiết
                console.error('Lỗi server:', err);
                let msg = err.message || err.errors || JSON.stringify(err);
                alert('Lỗi server: ' + msg);
            });
        }

        statusSelect.addEventListener('change', function() {
            updateField('status', this.value);
        });

        paymentSelect.addEventListener('change', function() {
            updateField('payment_method', this.value);
        });
    });
});
