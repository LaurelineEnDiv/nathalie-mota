jQuery(document).ready(function ($) {

    //Récupére les photos filtrées et/ou triées
    function fetchPhotos(offset = 0, append = false) { //offset indique à partir de quelle position charger les photos.
        const filters = {};
        // Récupérer les filtres actifs
        $(".taxonomies .filter-group").each(function () {
            const taxonomy = $(this).data("taxonomy");
            const selected = $(this).find(".filter-option.active").data("term-id");
                if (selected) {
                    filters[taxonomy] = selected;
                }
        });
        // Récupérer le tri par date
        const orderby = $(".filter-group[data-taxonomy='orderby'] .filter-option.active").data("term-id") || "DESC";
        // Préparation des données Ajax
        const data = {
            action: "fetch_photos",
            filters: filters,
            orderby: orderby,
            offset: offset,
        };

        // Envoi de la requête AJAX
        $.post(ajaxurl, data, function (response) {
            if (response.success && response.data.html.trim()) {
                //si la requête réussit, ajoute les phots
                if (append) {
                    $(".photo-block-container").append(response.data.html);
                } else {
                    $(".photo-block-container").html(response.data.html);
                }
                // Met à jour l'offset 
                const newOffset = offset + response.data.loaded; // `loaded` = nombre d'éléments chargés
                $("#load-more-photos").data("offset", newOffset);

                // Visibilité du bouton "Charger plus"
                if (response.data.has_more) {
                    $("#load-more-photos").show(); // Affiche le bouton si `has_more` est true
                } else {
                    $("#load-more-photos").hide(); // Masque le bouton si `has_more` est false
                }
                
            } else {
                $("#load-more-photos").hide(); // Masque le bouton s'il n'y a pas de résultats
            }
        });
    }

    // Gestion du bouton "Charger plus"
    $("#load-more-photos").on("click", function (e) {
        e.preventDefault();
        // Récupérer l'offset actuel du bouton
        const $button = $(this);
        let offset = parseInt($button.data("offset")) || 0;

        // Mettre à jour l'offset dans le DOM
        const newOffset = offset + 8;
        $button.data("offset", newOffset);
        
        // Passer le nouvel offset à fetchPhotos
        fetchPhotos(offset, true); 
    });


    // Ouverture/fermeture des options
    $(".filter-title, .fa-chevron-down").on("click", function () {
        const $filterGroup = $(this).closest(".filter-group");
        const $icon = $filterGroup.find("i.fa-solid");
        const $options = $filterGroup.find(".filter-options");
        const $filterTitle = $filterGroup.find(".filter-title");
        const defaultTitle = $filterTitle.data("default-title");

        // Réinitialiser le titre par défaut
        if ($options.is(":hidden")) {
            $filterTitle.text(defaultTitle);
            $filterGroup.removeClass("open");
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
    

      // Sélection/désélection des options
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

});
