<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); // Fonction pour charger les scripts et styles de WordPress et plugins ?>
</head>
<body <?php body_class(); ?>>

<header>
    <div class="site-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo-nathalie-mota.png" alt="Logo de Nathalie Mota, Photographe">
        </a>
    </div>
    <nav class="main-navigation">
        <?php
        // Affiche le menu principal défini dans l’administration WordPress
        wp_nav_menu( array(
            'theme_location' => 'main-menu', 
            'menu_class'     => 'nav-menu',
        ) );
        ?>
    </nav>
</header>

<?php get_template_part('templates_part/contact'); // Inclure la modale de contact ?>

