let navbar = document.querySelector('header');

window.addEventListener('scroll', () => {
    if (window.scrollY > 270) {
        navbar.classList.add('navbar2');
    } else {
        navbar.classList.remove('navbar2');
    }
})