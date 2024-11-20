/////////// Menu Burger ///////////
document.addEventListener('DOMContentLoaded', () => {
    const burgerMenu = document.querySelector('.burger-menu');
    const navMenu = document.querySelector('.header-menu');

    burgerMenu.addEventListener('click', () => {
        burgerMenu.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
});

/////////// Gestion Modale Contact ///////////
document.addEventListener("DOMContentLoaded", function() {
    const contactLink = document.getElementById("contact-menu-link");
    const modal = document.getElementById("contact-modal");
    const overlay = document.getElementById("modal-overlay");
    const photoContactButton = document.querySelector(".contact-photo a"); 
    const photoReferenceField = document.getElementById("photo-reference-field"); // Champ caché
    const ref = photoContactButton.getAttribute("data-ref");

    // Réinitialiser le champ de référence photo
    const resetPhotoReferenceField = () => {
        if (photoReferenceField) {
            photoReferenceField.value = ""; // Vider le champ à chaque ouverture
        }
    };
    
    // Ouvrir la modale depuis le menu
    contactLink.addEventListener("click", () => {
        resetPhotoReferenceField(); // Ne pas préremplir
        modal.classList.add("active");
        overlay.classList.add("active");
        document.body.style.overflow = 'hidden'; // Empêche le défilement en arrière-plan
    });

    // Ouvrir la modale depuis une page photo 
    photoContactButton.addEventListener("click", () => {
        if (photoReferenceField) {
            photoReferenceField.value = ref; // Préremplir le champ avec la référence
        }
        modal.classList.add("active");
        overlay.classList.add("active");
        document.body.style.overflow = 'hidden';
    });

    // Fermer la modale en cliquant sur l'overlay (zone en dehors de la modale)
    overlay.addEventListener("click", () => {
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


