document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("contact-modal");
    const contactLink = document.getElementById("contact-menu-link");
    const overlay = document.getElementById("modal-overlay");
    const modalContent = document.querySelector("#contact-modal .modal-content");

    // Ouvrir la modale lorsque le lien "Contact" est cliqué
    contactLink.addEventListener("click", () => {
        modal.classList.add("active");
        overlay.classList.add("active");
        document.body.style.overflow = 'hidden'; // Empêche le défilement en arrière-plan
    });

    // Fermer la modale en cliquant sur l'overlay (zone en dehors de la modale)
    overlay.addEventListener("click", () => {
        console.log("Clic sur l'overlay détecté");
        modal.classList.remove("active");
        overlay.classList.remove("active");
        document.body.style.overflow = ''; // Réactive le défilement
    });  
});

