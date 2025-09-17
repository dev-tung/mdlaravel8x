document.addEventListener("DOMContentLoaded", function () {
    // Ẩn tất cả flash messages sau 5 giây
    setTimeout(function() {
        const messages = document.querySelectorAll('.alert');
        messages.forEach(function(msg) {
            // Thêm lớp fade-out
            msg.classList.remove('show');
            msg.classList.add('fade');
            setTimeout(() => msg.remove(), 500); // Xóa khỏi DOM sau 0.5s
        });
    }, 5000); // 5000ms = 5 giây


    document.querySelectorAll("*[data-href]").forEach(row => {
        row.addEventListener("click", () => {
            window.location = row.dataset.href;
        });
    });
});
