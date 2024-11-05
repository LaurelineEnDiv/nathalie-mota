<?php
// Enregistre un emplacement de menu pour le thème
function register_menus() {
    register_nav_menus(
        array(
            'main-menu' => __( 'Menu Principal' ),
        )
    );
}
add_action( 'init', 'register_menus' );
?>
