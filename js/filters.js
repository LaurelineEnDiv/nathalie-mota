jQuery(document).ready(function ($) {
    function fetchPhotos(offset = 0, append = false) {
        //console.log("Offset reçu dans fetchPhotos :", offset);

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
            filters: filters,
            orderby: orderby,
            offset: offset,
        };

        //console.log("Données envoyées dans AJAX :", data);

        // Requête AJAX
        $.post(ajaxurl, data, function (response) {
            if (response.success && response.data.html.trim()) {
                if (append) {
                    $(".photo-block-container").append(response.data.html);
                } else {
                    $(".photo-block-container").html(response.data.html);
                }
                

                // Mettre à jour l'offset 
                const newOffset = offset + response.data.loaded; // `loaded` = nombre d'éléments chargés
                $("#load-more-photos").data("offset", newOffset);

                console.log("Offset initial mis à jour :", newOffset);


                // Afficher ou masquer le bouton en fonction des résultats
                if (response.data.has_more) {
                    $("#load-more-photos").show(); // Affiche le bouton si `has_more` est true
                } else {
                    $("#load-more-photos").hide(); // Masque le bouton si `has_more` est false
                }
            } else {
                if (!append) {
                    $(".photo-block-container").html('<p>Aucune photo trouvée.</p>');
                }
                $("#load-more-photos").hide(); // Masque le bouton s'il n'y a pas de résultats
            }
        });
    }

    // Charger plus de photos
    $("#load-more-photos").on("click", function (e) {
        e.preventDefault();

        // Récupérer l'offset actuel du bouton
        const $button = $(this);
        let offset = parseInt($button.data("offset")) || 0; // Utilisation de `data-offset`

        console.log("Offset envoyé dans la requête AJAX :", offset)
        
        fetchPhotos(offset, true); // Ajouter des photos sans écraser les existantes
    });

    // Gérer la sélection/désélection des options
    $(".filter-option").on("click", function () {

        const $group = $(this).closest(".filter-group");
        const $filterTitle = $group.find(".filter-title");
        const defaultTitle = $filterTitle.data("default-title");
        const selectedText = $(this).text();

        // Vérifier si l'option est déjà active
        if ($(this).hasClass("active")) {
            // Désactiver l'option et rétablir le titre par défaut
            $(this).removeClass("active");
            $filterTitle.text(defaultTitle);
        } else {
            // Activer la nouvelle option et mettre à jour le titre
            $group.find(".filter-option").removeClass("active");
            $(this).addClass("active");
            $filterTitle.text(selectedText);
        }

        // Fermer les options après sélection
        $group.find(".filter-options").hide();
        $group.find("i.fa-solid").removeClass("fa-chevron-up").addClass("fa-chevron-down");
        fetchPhotos(0);
    });

    // Ouverture/fermeture de la liste des options
    $(".filter-title, .fa-chevron-down").on("click", function () {
        const $filterGroup = $(this).closest(".filter-group");
        const $icon = $filterGroup.find("i.fa-solid");
        const $options = $filterGroup.find(".filter-options");
        const $filterTitle = $filterGroup.find(".filter-title");
        const defaultTitle = $filterTitle.data("default-title");

        // Réinitialiser le titre par défaut
        if ($options.is(":hidden")) {
            $filterTitle.text(defaultTitle);
            $filterGroup.find(".filter-option").removeClass("active");
            fetchPhotos(0);
        }

        // Affichage des options avec effet de glissement vertical
        $options.slideToggle(200);
        // Basculer les icônes
        $icon.toggleClass("fa-chevron-down fa-chevron-up");
        // Basculer la classe `open` sur le groupe de filtres
        $filterGroup.toggleClass("open");
    });

});
