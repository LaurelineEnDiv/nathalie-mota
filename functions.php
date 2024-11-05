<?php
//Charge le fichier Javascript
function enqueue_theme_scripts() {
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');


// si le titre du menu est "Contact", ajoute un identifiant contact-menu-link au lien pour activer la modale.
function add_contact_menu_id($atts, $item, $args) {
    if ($item->title == 'Contact') { // Titre du lien dans le menu WordPress
        $atts['id'] = 'contact-menu-link';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_contact_menu_id', 10, 3);
?>