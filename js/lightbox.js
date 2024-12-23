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
        //Déterminer l'indice de l'image cliquée
        currentImageIndex = $(".lightbox-icon").index(this);

        // Récupérer toutes les données nécessaires
        // map pour parcourir toutes les .lightbox-icon et stocke leurs données dans les tableaux correspondants.
        images = $(".lightbox-icon").map(function () {
            return $(this).data("image");
        }).get();

        references = $(".lightbox-icon").map(function () {
            return $(this).data("ref");
        }).get();

        categories = $(".lightbox-icon").map(function () {
            return $(this).data("category");
        }).get();

        // Mettre à jour et afficher la lightbox
        updateLightboxContent(imageUrl, reference, category);
        $(".lightbox").addClass("active");
    });

    // Mettre à jour l'image, la référence et la catégorie dans la lightbox
    function updateLightboxContent(imageUrl, reference, category) {
        $(".lightbox img").attr("src", imageUrl);
        $(".lightbox .lightbox-ref").text(reference);
        $(".lightbox .lightbox-category").text(category);
    }

    // Fermer la lightbox au clic sur la croix
    $("body").on("click", ".lightbox .close", function () {
        $(".lightbox").removeClass("active");
    });

    // Fermer la lightbox en cliquant à l'extérieur de l'image
    $(".lightbox").on("click", function (e) {
        if ($(e.target).is(".lightbox")) {
            $(".lightbox").removeClass("active");
        }
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

});
