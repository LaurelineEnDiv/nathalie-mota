jQuery(document).ready(function ($) {
    // Quand une valeur change dans un select
    $('#photo-filters select').on('change', function () {
        // Récupérer les valeurs sélectionnées
        let categorie = $('#categorie').val();
        let format = $('#format').val();

        // Effectuer une requête AJAX
        $.ajax({
            url: ajaxurl, // Défini par WordPress
            type: 'POST',
            data: {
                action: 'filter_photos', // Action liée à la fonction PHP
                categorie: categorie,
                format: format
            },
            beforeSend: function () {
                // Optionnel : Ajouter un spinner de chargement
                $('.photo-block-container').html('<p>Chargement...</p>');
            },
            success: function (response) {
                // Injecter les résultats dans le conteneur
                $('.photo-block-container').html(response);
            },
            error: function () {
                // Gérer les erreurs éventuelles
                $('.photo-block-container').html('<p>Une erreur est survenue.</p>');
            }
        });
    });
});
