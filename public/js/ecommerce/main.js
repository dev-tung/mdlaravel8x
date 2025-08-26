// Display header search when user scroll top 200px
window.onscroll = function (e) {
    if( window.scrollY >= 200 ){
        document.getElementById('HeaderScroll').style.display = "block";
    }else{
        document.getElementById('HeaderScroll').style.display = "none";
    }
};