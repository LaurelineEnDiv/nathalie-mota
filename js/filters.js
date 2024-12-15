jQuery(document).ready(function ($) {
    function fetchPhotos() {
        const filters = {};

        // Récupérer les filtres actifs
        $(".filter-group").each(function () {
            const taxonomy = $(this).data("taxonomy");
            if (taxonomy !== 'orderby') {
                const selected = $(this).find(".filter-option.active").data("term-id");
                if (selected) {
                    filters[taxonomy] = selected;
                }
            }
        });

        const orderby = $(".filter-group[data-taxonomy='orderby'] .filter-option.active").data("term-id") || "DESC";

        const data = {
            action: "fetch_photos",
            filters: filters,
            orderby: orderby,
            paged: 1,
        };

        $("#loading").show();

        // Requête AJAX
        $.post(ajaxurl, data, function (response) {
            $("#loading").hide();
            if (response.success && response.data.html.trim()) {
                $(".photo-block-container").html(response.data.html);
                $("#load-more-photos").toggle(response.data.has_more);
            } else {
                $(".photo-block-container").html('<p>Aucune photo trouvée.</p>');
                $("#load-more-photos").hide();
            }
        });
    }

    // Activer un filtre au clic
    $(".filter-option").on("click", function () {
        const $group = $(this).closest(".filter-group");
        $group.find(".filter-option").removeClass("active");
        $(this).addClass("active");
        fetchPhotos();
    });

    // Charger plus de photos
    $("#load-more-photos").on("click", function (e) {
        e.preventDefault();
        const paged = parseInt($(this).data("paged")) + 1;
        $(this).data("paged", paged);

        const filters = {};

        $(".filter-group").each(function () {
            const taxonomy = $(this).data("taxonomy");
            if (taxonomy !== 'orderby') {
                const selected = $(this).find(".filter-option.active").data("term-id");
                if (selected) {
                    filters[taxonomy] = selected;
                }
            }
        });

        const orderby = $(".filter-group[data-taxonomy='orderby'] .filter-option.active").data("term-id") || "DESC";

        const data = {
            action: "fetch_photos",
            filters: filters,
            orderby: orderby,
            paged: paged,
        };

        $("#loading").show();

        $.post(ajaxurl, data, function (response) {
            $("#loading").hide();
            if (response.success && response.data.html.trim()) {
                $(".photo-block").append(response.data.html);
                $("#load-more-photos").toggle(response.data.has_more);
            } else {
                $("#load-more-photos").hide();
            }
        });
    });

    // Ouverture/fermeture de la liste des options au clic
    $(".filter-title, .fa-chevron-down").on("click", function () {
        
        const $filterGroup = $(this).closest(".filter-group");
        const $icon = $filterGroup.find("i.fa-solid");
        const $options = $filterGroup.find(".filter-options");

        // Basculer l'affichage des options
        $options.slideToggle(200);

        // Basculer les icônes
        $icon.toggleClass("fa-chevron-down fa-chevron-up");

        // Basculer la classe `open` sur le groupe de filtres
        $filterGroup.toggleClass("open");
    });
});
