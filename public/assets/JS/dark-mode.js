document.addEventListener('DOMContentLoaded', function () {
    const buttonDark = document.getElementById('button-dark');
    const body = document.body;
    buttonDark.addEventListener('click', function () {
        body.classList.toggle('dark-mode-body');
        const navbar = document.querySelector('nav');
        const footer = document.querySelector('footer');
        navbar.classList.toggle('dark-mode-navbar-footer');
        footer.classList.toggle('dark-mode-navbar-footer');
    })
})