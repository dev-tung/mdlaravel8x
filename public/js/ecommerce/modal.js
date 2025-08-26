// Modal category
document.getElementById('HeaderNavCatbtn').onclick = () => {
    document.getElementById('Modalcategory').style.display = "block";
}

document.querySelectorAll('.ModalCloseIcon, .ModalOverlay').forEach( e => {
    e.onclick = () => {
        document.querySelectorAll('.Modal').forEach((e) => {
            e.style.display = "none";
        });
    }
});