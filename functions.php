<?php
//Charge le fichier style.css
function theme_enqueue_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/css/style.css');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

//Charge les fichiers Javascript
function theme_enqueue_scripts() {
    wp_enqueue_script('nav-photos', get_template_directory_uri() . '/js/nav-photos.js', array(), null, true);
    wp_enqueue_script('menu-mobile', get_template_directory_uri() . '/js/menu-mobile.js', array(), null, true);
    wp_enqueue_script('modale-contact', get_template_directory_uri() . '/js/modale-contact.js', array(), null, true);
    wp_enqueue_script('ajax-filters', get_template_directory_uri() . '/js/ajax-filters.js', array('jquery'), null, true);
        // Ajouter la variable ajaxurl pour que JavaScript communique avec WordPress via AJAX
        wp_localize_script('ajax-filters', 'ajaxurl', admin_url('admin-ajax.php'));
    wp_enqueue_script('load-more-photos', get_template_directory_uri() . '/js/load-more-photos.js', array('jquery'), null, true);
        // Transmettre les paramètres Ajax pour la pagination infinie
        wp_localize_script('load-more-photos', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'), // URL pour les requêtes Ajax
        'nonce'    => wp_create_nonce('load_more_nonce'), // Protection avec un nonce
    ));
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



// Traiter la requête AJAX des filtres
function filter_photos() {
    // Vérification des paramètres AJAX
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    // Ajout des conditions selon les filtres sélectionnés
    if (!empty($categorie)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie,
        );
    }
    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    // Afficher les photos filtrées
    get_template_part('template_parts/photo_block', null, $args);

    wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');


// Traiter la requête AJAX du chargement infini
function load_more_photos() {
    // Vérifier le nonce pour la sécurité
    check_ajax_referer('load_more_nonce', 'nonce');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8, 
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>
        <div class="photo-block">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('large');
                    } else {
                        echo '<p>Aucune image disponible</p>';
                    }
                    ?>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
     <?php
        wp_reset_postdata();
    else :
        echo '<p>Aucune autre photo disponible.</p>';
    endif;
    
    wp_die(); // Arrête l'exécution après avoir retourné les résultats
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

?>

