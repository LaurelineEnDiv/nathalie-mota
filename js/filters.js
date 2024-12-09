jQuery(document).ready(function ($) {
    // Fonction pour récupérer les photos via AJAX
    function fetchPhotos() {
        const filters = {};

        // Récupérer les filtres actifs
        $(".filter-group").each(function () {
            const taxonomy = $(this).data("taxonomy");
            const selected = $(this).find(".filter-option.active").data("term-id");
            if (selected) {
                filters[taxonomy] = selected;
            }
        });

        const data = {
            action: "fetch_photos",
            filters: filters,
            order: $(".filter-group[data-taxonomy='orderby'] .filter-option.active").data("term-id") || "DESC",
        };

        $("#loading").show();

        // Requête AJAX
        $.post(ajaxurl, data, function (response) {
            $("#loading").hide();
            if (response.success) {
                $(".photo-block-container").html(response.data.html);
            } 
        });
    }

    // Activer un filtre au clic
    $(".filter-option").on("click", function () {
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        fetchPhotos();
    });

    // Charger plus de photos
    $("#load-more-photos").on("click", function (e) {
        e.preventDefault();

        const paged = parseInt($(this).data("paged")) + 1;
        $(this).data("paged", paged);

        const filters = {};

        // Récupérer les filtres actifs
        $(".filter-group").each(function () {
            const taxonomy = $(this).data("taxonomy");
            const selected = $(this).find(".filter-option.active").data("term-id");
            if (selected) {
                filters[taxonomy] = selected;
            }
        });

        const data = {
            action: "fetch_photos",
            filters: filters,
            order: $(".filter-group[data-taxonomy='orderby'] .filter-option.active").data("term-id") || "DESC",
            paged: paged,
        };

        $("#loading").show();

        // Requête AJAX pour charger plus
        $.post(ajaxurl, data, function (response) {
            $("#loading").hide();
            if (response.success) {
                $(".photo-block").append(response.data.html);
            } else {
                $("#load-more-photos").hide();
            }
        });
    });
});
