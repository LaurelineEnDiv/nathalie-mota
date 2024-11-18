<footer>
    <div class="separator"></div>
    <nav class="nav-menu">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu', // Doit correspondre au nom du menu 
                'menu_class'     => 'nav-menu', // Classe CSS pour le styliser si besoin
            ) );
            ?>
            <li class="site-info">
                Tous droits réservés
            </li>
    </nav>
</footer>

<?php wp_footer(); // Nécessaire pour les scripts et plugins WordPress ?>
</body>
</html>
