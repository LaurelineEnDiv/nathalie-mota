<?php
//Charge le fichier style.css
function theme_enqueue_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/style/style.css');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

//Charge les fichiers Javascript
function theme_enqueue_scripts() {
    wp_enqueue_script('nav-photos', get_template_directory_uri() . '/js/nav-photos.js', array(), null, true);
    wp_enqueue_script('menu-mobile', get_template_directory_uri() . '/js/menu-mobile.js', array(), null, true);
    wp_enqueue_script('modale-contact', get_template_directory_uri() . '/js/modale-contact.js', array(), null, true);
    wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);
    wp_enqueue_script('filters-script', get_template_directory_uri() . '/js/filters.js', array('jquery'), null, true);
        // Localiser l'URL AJAX
        $ajaxurl = admin_url('admin-ajax.php');
        $inline_script = "var ajaxurl = '" . esc_js($ajaxurl) . "';";
        wp_add_inline_script('filters-script', $inline_script, 'before');

}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


// Enregistre les emplacements de menus
function theme_register_menus() {
    register_nav_menus(
        array(
            'main-menu' => 'Menu Principal',
            'footer-menu' => 'Menu Footer'
        )
    );
}
add_action( 'init', 'theme_register_menus' );

// Attribue la class "open-modale" au lien Contact du menu
function add_contact_menu_class($atts, $item, $args) {
    if ($item->title == 'Contact') { // Titre du lien dans le menu WordPress
            $atts['class'] = 'open-modale'; // Ajoute la classe 
        }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_contact_menu_class', 10, 3);


//Gérer les requêtes Ajax pour filtrer les photos
function fetch_photos() {
    //error_log("Données AJAX reçues : " . print_r($_POST, true));
    
    // Récupérer les paramètres envoyés par AJAX
    $filters = isset($_POST['filters']) ? $_POST['filters'] : array();
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'DESC';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // Arguments WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => $orderby,
        'paged' => $paged,
    );

    // Ajouter les filtres de taxonomies
    if (!empty($filters)) {
        $args['tax_query'] = array(); // Initialiser la tax_query
        foreach ($filters as $taxonomy => $term_id) {
            $args['tax_query'][] = array(
                'taxonomy' => sanitize_key($taxonomy),
                'field' => 'term_id',
                'terms' => intval($term_id),
            );
        }
    }
    
    // Exécutez la requête pour récupérer les photos
    $photo_query = new WP_Query($args);

    ob_start();
    get_template_part('template_parts/photo_block', null, $args);
    $html = ob_get_clean();

    // Vérifier s'il reste des pages à charger
    $has_more = $photo_query->max_num_pages > $paged;

    // Retourner la réponse AJAX avec les données et l'état `has_more`
    if (!empty($html)) {
        wp_send_json_success(array(
            'html' => $html,
            'has_more' => $has_more, // Indique s'il y a d'autres pages
        ));
    } else {
        wp_send_json_success(array(
            'html' => '',
            'has_more' => false, // Aucun contenu supplémentaire
        ));
    }

    wp_die();
}
add_action('wp_ajax_fetch_photos', 'fetch_photos');
add_action('wp_ajax_nopriv_fetch_photos', 'fetch_photos');


?>

