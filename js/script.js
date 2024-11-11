document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("contact-modal");
    const contactLink = document.getElementById("contact-menu-link");
    const overlay = document.getElementById("modal-overlay");

    // Ouvrir la modale lorsque le lien "Contact" est cliqué
    contactLink.addEventListener("click", function(event) {
        modal.classList.add("active");
        overlay.classList.add("active");
    });

    // Fermer la modale en cliquant sur un autre lien du menu
    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach(link => {
        if (link !== contactLink) {
            link.addEventListener("click", function() {
                modal.classList.remove("active"); // Cache la modale
                overlay.classList.remove("active"); // Cache l'overlay
            });
        }
    });
});

