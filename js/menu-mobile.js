document.addEventListener('DOMContentLoaded', () => {
    const burgerMenu = document.querySelector('.burger-menu');
    const closeMenu = document.querySelector('.close-menu');
    const mobileMenu = document.querySelector('#mobile-menu-container');

    // Ouvrir le menu
    burgerMenu.addEventListener('click', () => {
        mobileMenu.classList.add('active');
    });

    // Fermer le menu
    closeMenu.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
    });
});