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


//Gérer les requêtes Ajax pour traiter les filtres et retourner les photos filtrées 
function fetch_photos() {
    // Vérifier et récupérer les filtres
    $filters = isset($_POST['filters']) ? $_POST['filters'] : array();
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // Construire les arguments WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => $order,
        'paged' => $paged,
    );

    // Ajouter les taxonomies aux arguments si définies
    foreach ($filters as $taxonomy => $term_id) {
        $args['tax_query'][] = array(
            'taxonomy' => sanitize_key($taxonomy),
            'field' => 'term_id',
            'terms' => intval($term_id),
        );
    }

    // WP_Query pour récupérer les photos
    ob_start();
    get_template_part('template_parts/photo_block', null, $args);
    $html = ob_get_clean();

    if (!empty($html)) {
        wp_send_json_success(array('html' => $html));
    } else {
        wp_send_json_error();
    }

    wp_die();
}
add_action('wp_ajax_fetch_photos', 'fetch_photos');
add_action('wp_ajax_nopriv_fetch_photos', 'fetch_photos');

?>

