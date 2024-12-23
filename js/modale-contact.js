document.addEventListener("DOMContentLoaded", function() {
    const contactLinks = document.querySelectorAll('.open-modale'); 
    const modal = document.getElementById("contact-modal");
    const overlay = document.getElementById("modal-overlay");
    const photoReferenceField = document.getElementById("photo-reference-field"); // Champ caché

    // Réinitialiser le champ de référence photo
    const resetPhotoReferenceField = () => {
        if (photoReferenceField) {
            photoReferenceField.value = ""; //Vider le champ à chaque ouverture
        }
    };
    
    // Ouvrir la modale au clic sur le lien Contact avec classe open-modale
    contactLinks.forEach(contact => {
        contact.addEventListener("click", (event) => {
            event.preventDefault();

        //Ouverture de la modale avec champ Référence prérempli
            // Récupérer la référence de l'attribut data-ref
            const ref = contact.getAttribute("data-ref");
            // Si l'élément avec l'ID photo-reference-field existe (le champ de formulaire caché) et si une valeur ref a été récupérée
            if (photoReferenceField && ref) {
                photoReferenceField.value = ref; // Préremplir le champ avec la référence
            } else {
                resetPhotoReferenceField(); // Réinitialiser si aucune référence n'est définie
            }

            // Ajout de la classe "active"
            modal.classList.add("active");
            overlay.classList.add("active");
            document.body.style.overflow = 'hidden'; // Empêche le défilement en arrière-plan
        });
    });

    // Fermer la modale en cliquant sur l'overlay (zone en dehors de la modale)
    overlay.addEventListener("click", () => {
        modal.classList.remove("active");
        overlay.classList.remove("active");
        document.body.style.overflow = ''; // Réactive le défilement
    });  
});

