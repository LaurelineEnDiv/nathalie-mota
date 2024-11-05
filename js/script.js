document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("contact-modal");
    const contactLink = document.getElementById("contact-menu-link");

    // Ouvrir la modale lorsque le lien "Contact" est cliqué
    contactLink.addEventListener("click", function(event) {
        event.preventDefault(); // Empêche le défilement vers le haut de la page
        modal.style.display = "block"; // Affiche la modale
    });

    // Fermer la modale en cliquant en dehors
    window.addEventListener("click", function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });

    // Fermer la modale en cliquant sur un autre lien du menu
    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach(link => {
        if (link !== contactLink) {
            link.addEventListener("click", function() {
                modal.style.display = "none"; // Cache la modale
            });
        }
    });
});

