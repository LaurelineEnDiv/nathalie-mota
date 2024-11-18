/////////// Gestion Modale Contact ///////////
document.addEventListener("DOMContentLoaded", function() {
    const contactLink = document.getElementById("contact-menu-link");
    const modal = document.getElementById("contact-modal");
    const overlay = document.getElementById("modal-overlay");

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

/////////// Gestion navigation image miniature ///////////
document.addEventListener('DOMContentLoaded', () => {
    const currentThumbnail = document.getElementById('thumbnail-current-img');
    const contentImage = document.querySelector('.photo img'); // Sélectionne l'image de the_content()

    // Initialisation de la miniature 
    if (contentImage) {
        currentThumbnail.src = contentImage.src;
    }

    // Changement de l'image au survol
    document.querySelectorAll('.photo-navigation a').forEach(link => {
        link.addEventListener('mouseover', function () {
            const thumbnailUrl = this.getAttribute('data-thumbnail');
            if (thumbnailUrl) {
                currentThumbnail.src = thumbnailUrl;
            }
        });
    });
});


