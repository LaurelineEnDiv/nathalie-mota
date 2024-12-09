<?php
//Charge le fichier style.css
function theme_enqueue_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/style/style.css');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

//Charge les fichiers Javascript
function theme_enqueue_scripts() {
    wp_enqueue_script('nav-photos', get_template_directory_uri() . '/js/nav-photos.js', array(), null, true);
    wp_enqueue_script('menu-mobile', get_template_directory_uri() . '/js/menu-mobile.js', array(), null, true);
    wp_enqueue_script('modale-contact', get_template_directory_uri() . '/js/modale-contact.js', array(), null, true);
    wp_enqueue_script('filters', get_template_directory_uri() . '/js/filters.js', array('jquery'), null, true);
        // Ajouter la variable ajaxurl pour que JavaScript communique avec WordPress via AJAX
        wp_localize_script('filters', 'myAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'), // URL de l'admin-ajax
    'nonce' => wp_create_nonce('load_more_nonce') // Créer un nonce pour la sécurité
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
function filter_photos_ajax() {
    // Vérifier si les filtres sont définis
    $filters = isset($_POST['filters']) ? json_decode(stripslashes($_POST['filters']), true) : [];
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $tax_query = [];

    // Construire la tax_query à partir des filtres
    if (!empty($filters)) {
        foreach ($filters as $taxonomy => $terms) {
            if (!empty($terms)) {
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $terms,
                    'operator' => 'IN',
                );
            }
        }
    }

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'tax_query' => (!empty($tax_query) ? $tax_query : array()), // S'assurer que tax_query est un tableau
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start(); // Capture le contenu HTML généré
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="photo-block">
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
            </div>
            <?php
        }
        $output = ob_get_clean();
        wp_send_json_success(array('html' => $output)); // Envoyer la réponse AJAX avec le HTML
    } else {
        wp_send_json_success(array('html' => '<p>Aucune photo trouvée.</p>')); // Si aucun post trouvé
    }

    wp_die(); // Terminer le script
}

add_action('wp_ajax_filter_photos', 'filter_photos_ajax');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos_ajax');



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

