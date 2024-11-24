<?php
//Charge le fichier style.css
function theme_enqueue_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/css/style.css');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

//Charge le fichier Javascript
function theme_enqueue_scripts() {
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
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

// si le titre du menu est "Contact", ajoute un identifiant contact-menu-link au lien pour activer la modale.
function add_contact_menu_id($atts, $item, $args) {
    if ($item->title == 'Contact') { // Titre du lien dans le menu WordPress
        $atts['id'] = 'contact-menu-link';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_contact_menu_id', 10, 3);

?>