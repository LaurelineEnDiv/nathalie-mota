jQuery(document).ready(function ($) {
    function fetchPhotos() {
        const filters = {};

        // Récupérer les filtres actifs
        $(".filter-group").each(function () {
            const taxonomy = $(this).data("taxonomy");

            // Ignorer le groupe 'orderby' pour ne pas l'inclure dans les taxonomies
            if (taxonomy !== 'orderby') {
                const selected = $(this).find(".filter-option.active").data("term-id");
                if (selected) {
                    filters[taxonomy] = selected;
                }
            }
        });

        // Récupérer l'ordre trié
        const orderby = $(".filter-group[data-taxonomy='orderby'] .filter-option.active").data("term-id") || "DESC";

        const data = {
            action: "fetch_photos",
            filters: filters, // Inclure seulement les taxonomies 
            orderby: orderby, // Passer 'orderby' comme paramètre distinct
            paged: 1, // Réinitialise la pagination lors d'un nouveau filtrage
        };

        $("#loading").show();

        // Requête AJAX
        $.post(ajaxurl, data, function (response) {
            //console.log("Données envoyées :", data);
            $("#loading").hide();
            //vérifier si le contenu HTML retourné est vide. Si c'est le cas, le bouton "Charger plus" est masqué.
            if (response.success && response.data.html.trim()) {
                $(".photo-block-container").html(response.data.html);
                $("#load-more-photos").toggle(response.data.has_more); // Affiche ou masque selon has_more
            } else {
                $(".photo-block-container").html('<p>Aucune photo trouvée.</p>');
                $("#load-more-photos").hide();
            }
        });
    }

    // Activer un filtre au clic
    $(".filter-option").on("click", function () {
        const $group = $(this).closest(".filter-group");
        $group.find(".filter-option").removeClass("active"); // Désactive les autres options
        $(this).addClass("active"); // Active l'option cliquée
        fetchPhotos(); // maj des photos avec les filtres actifs
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

            // Ignorer le groupe 'orderby' pour ne pas l'inclure dans les taxonomies
            if (taxonomy !== 'orderby') {
                const selected = $(this).find(".filter-option.active").data("term-id");
                if (selected) {
                    filters[taxonomy] = selected;
                }
            }
        });

        // Récupérer l'ordre trié
        const orderby = $(".filter-group[data-taxonomy='orderby'] .filter-option.active").data("term-id") || "DESC";

        const data = {
            action: "fetch_photos",
            filters: filters, // Inclure seulement les filtres de taxonomies ici
            orderby: orderby, // Passer 'orderby' comme paramètre distinct
            paged: paged,
        };

        $("#loading").show();

        // Requête AJAX pour charger plus de photos
        $.post(ajaxurl, data, function (response) {
            $("#loading").hide();
            if (response.success && response.data.html.trim()) {
                $(".photo-block").append(response.data.html);
                $("#load-more-photos").toggle(response.data.has_more); // Affiche ou masque selon has_more
            } else {
                $("#load-more-photos").hide();
            }
        });
    });
});
