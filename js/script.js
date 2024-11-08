document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("contact-modal");
    const contactLink = document.getElementById("contact-menu-link");
    const overlay = document.getElementById("modal-overlay");

    // Ouvrir la modale lorsque le lien "Contact" est cliqué
    contactLink.addEventListener("click", function(event) {
        modal.style.display = "block"; // Affiche la modale
        overlay.style.display = "block"; // Affiche l'overlay
    });

    // Fermer la modale en cliquant sur un autre lien du menu
    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach(link => {
        if (link !== contactLink) {
            link.addEventListener("click", function() {
                modal.style.display = "none"; // Cache la modale
                overlay.style.display = "none"; // Cache l'overlay
            });
        }
    });
});

