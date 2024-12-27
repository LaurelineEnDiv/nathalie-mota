jQuery(document).ready(function ($) {
    // Récupère et affiche les photos filtrées/triées
    function fetchPhotos(offset = 0, append = false) {
        const filters = {};
        $(".taxonomies .filter-group").each(function () {
            const taxonomy = $(this).data("taxonomy");
            const selected = $(this).find(".filter-option.selected").data("term-id");
            if (selected) {
                filters[taxonomy] = selected;
            }
        });

        const orderby = $(".filter-group[data-taxonomy='orderby'] .filter-option.selected").data("term-id") || "DESC";

        const data = {
            action: "fetch_photos",
            filters: filters,
            orderby: orderby,
            offset: offset,
        };

        $.post(ajaxurl, data, function (response) {
            if (response.success && response.data.html.trim()) {
                if (append) {
                    $(".photo-block-container").append(response.data.html);
                } else {
                    $(".photo-block-container").html(response.data.html);
                }

                const newOffset = offset + response.data.loaded;
                $("#load-more-photos").data("offset", newOffset);

                if (response.data.has_more) {
                    $("#load-more-photos").show();
                } else {
                    $("#load-more-photos").hide();
                }
            } else {
                $("#load-more-photos").hide();
            }
        });
    }

    // Gestion du bouton "Charger plus"
    $("#load-more-photos").on("click", function (e) {
        e.preventDefault();
        const $button = $(this);
        const offset = parseInt($button.data("offset")) || 0;
        const newOffset = offset + 8;
        $button.data("offset", newOffset);
        fetchPhotos(offset, true);
    });

    // Gestion de l'ouverture/fermeture des options
    $(".filter-title, .fa-chevron-down").on("click", function (e) {
        e.stopPropagation(); // Empêche la propagation pour éviter que l'événement global soit déclenché
        const $filterGroup = $(this).closest(".filter-group");
        const $icon = $filterGroup.find("i.fa-solid");
        const $options = $filterGroup.find(".filter-options");

        if ($options.is(":hidden")) {
            $options.slideDown(200);
            $icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
            $filterGroup.addClass("open");
        } else {
            $options.slideUp(200);
            $icon.removeClass("fa-chevron-up").addClass("fa-chevron-down");
            $filterGroup.removeClass("open");
        }
    });

    // Gestion de la sélection d'une option
    $(".filter-option").on("click", function () {
        const $group = $(this).closest(".filter-group");
        const $filterTitle = $group.find(".filter-title");
        const selectedText = $(this).text();

        if (!$(this).hasClass("selected")) {
            $group.find(".filter-option").removeClass("selected");
            $(this).addClass("selected");
            $filterTitle.text(selectedText);

            // Fermer la liste et supprimer la classe `open`
            $group.find(".filter-options").slideUp(200, function () {
                $group.removeClass("open"); // Supprime la classe `open` après la fermeture (soit la bordure bleue)
            });
            $group.find("i.fa-solid").removeClass("fa-chevron-up").addClass("fa-chevron-down");

            // Mettre à jour les photos
            fetchPhotos(0);
        } else {
            // Fermer la liste sans action supplémentaire
            $group.find(".filter-options").slideUp(200);
            $group.find("i.fa-solid").removeClass("fa-chevron-up").addClass("fa-chevron-down");
        }
    });

    // Réinitialisation des photos en cliquant en dehors des filtres
    $(document).on("click", function (e) {
        if (!$(e.target).closest(".filter-group").length) {
            // Réinitialiser tous les filtres
            $(".filter-group").each(function () {
                const $filterTitle = $(this).find(".filter-title");
                const defaultTitle = $filterTitle.data("default-title");
                $filterTitle.text(defaultTitle);
                $(this).find(".filter-option").removeClass("selected");
                $(this).removeClass("open");
                $(this).find(".filter-options").hide();
                $(this).find("i.fa-solid").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            });

            // Charger les photos par défaut
            fetchPhotos(0);
        }
    });
});
