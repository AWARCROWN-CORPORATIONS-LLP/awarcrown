window.addEventListener('scroll', function() {
    const nav = document.querySelector('nav');
    if (window.scrollY > 0) {
        nav.style.boxShadow = "0px 0px 4px black";
    } else {
        nav.style.boxShadow = "none";
    }
});