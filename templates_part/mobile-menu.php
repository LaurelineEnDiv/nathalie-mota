<div id="mobile-menu-container">
    <!-- Header avec logo et croix -->
    <div class="mobile-header">
        <div class="site-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/logo-nathalie-mota.png" alt="Logo de Nathalie Mota">
            </a>
        </div>
        <button class="close-menu" aria-label="Fermer le menu">
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Menu principal -->
    <nav class="mobile-nav">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'main-menu',
            'menu_class'     => 'mobile-menu',
        ));
        ?>
    </nav>
</div>
