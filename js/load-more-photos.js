jQuery(document).ready(function ($) {
    $('#load-more-photos').on('click', function (event) {
        event.preventDefault(); // Empêche le comportement par défaut (revenir en haut)

        let button = $(this);
        let paged = parseInt(button.data('paged')) + 1; // Page suivante

        $('#loading').show(); // Afficher le chargement

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_photos',
                paged: paged,
                nonce: ajax_params.nonce,
            },
            success: function (response) {
                if (response.trim()) {
                    $('.photo-block-container').append(response); // Ajouter les nouvelles photos
                    button.data('paged', paged); // Mettre à jour le numéro de page
                } else {
                    button.hide(); // Masquer le bouton s'il n'y a plus de photos
                }
                $('#loading').hide(); // Masquer le chargement
            },
            error: function () {
                console.log('Erreur lors du chargement des photos.');
                $('#loading').hide();
            },
        });
    });
});
