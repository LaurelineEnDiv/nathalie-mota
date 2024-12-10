jQuery(document).ready(function ($) {
    let currentImageIndex = 0;
    let images = [];

    // Ouvrir la lightbox
    $("body").on("click", ".lightbox-icon", function () {
        const imageUrl = $(this).data("image");
        currentImageIndex = $(".lightbox-icon").index(this);
        images = $(".lightbox-icon").map(function () {
            return $(this).data("image");
        }).get();

        $(".lightbox img").attr("src", imageUrl);
        $(".lightbox").fadeIn();
    });

    // Fermer la lightbox
    $("body").on("click", ".lightbox .close", function () {
        $(".lightbox").fadeOut();
    });

    // Afficher l'image suivante
    $("body").on("click", ".lightbox .next", function () {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        $(".lightbox img").attr("src", images[currentImageIndex]);
    });

    // Afficher l'image précédente
    $("body").on("click", ".lightbox .prev", function () {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        $(".lightbox img").attr("src", images[currentImageIndex]);
    });

    // Fermer la lightbox en cliquant à l'extérieur de l'image
    $(".lightbox").on("click", function (e) {
        if ($(e.target).is(".lightbox")) {
            $(".lightbox").fadeOut();
        }
    });
});
