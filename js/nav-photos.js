
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


