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

