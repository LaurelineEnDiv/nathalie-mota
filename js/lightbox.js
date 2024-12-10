jQuery(document).ready(function ($) {
    let currentImageIndex = 0;
    let images = [];
    let references = [];
    let categories = [];

    // Ouvrir la lightbox
    $("body").on("click", ".lightbox-icon", function () {
        const imageUrl = $(this).data("image");
        const reference = $(this).data("ref");
        const category = $(this).data("category");
        
        currentImageIndex = $(".lightbox-icon").index(this);

        // Récupérer toutes les données nécessaires
        images = $(".lightbox-icon").map(function () {
            return $(this).data("image");
        }).get();

        references = $(".lightbox-icon").map(function () {
            return $(this).data("ref");
        }).get();

        categories = $(".lightbox-icon").map(function () {
            return $(this).data("category");
        }).get();

        // Mettre à jour la lightbox
        updateLightboxContent(imageUrl, reference, category);
        $(".lightbox").addClass("active");
    });

    // Mettre à jour l'image, la référence et la catégorie dans la lightbox
    function updateLightboxContent(imageUrl, reference, category) {
        $(".lightbox img").attr("src", imageUrl);
        $(".lightbox .lightbox-ref").text(reference || "Référence non disponible");
        $(".lightbox .lightbox-category").text(category || "Catégorie non disponible");
    }

    // Fermer la lightbox
    $("body").on("click", ".lightbox .close", function () {
        $(".lightbox").removeClass("active");
    });

    // Afficher l'image suivante
    $("body").on("click", ".lightbox .next", function () {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        const imageUrl = images[currentImageIndex];
        const reference = references[currentImageIndex];
        const category = categories[currentImageIndex];
        updateLightboxContent(imageUrl, reference, category);
    });

    // Afficher l'image précédente
    $("body").on("click", ".lightbox .prev", function () {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        const imageUrl = images[currentImageIndex];
        const reference = references[currentImageIndex];
        const category = categories[currentImageIndex];
        updateLightboxContent(imageUrl, reference, category);
    });

    // Fermer la lightbox en cliquant à l'extérieur de l'image
    $(".lightbox").on("click", function (e) {
        if ($(e.target).is(".lightbox")) {
            $(".lightbox").removeClass("active");
        }
    });
});
