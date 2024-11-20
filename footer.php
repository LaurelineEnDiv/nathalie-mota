<footer>
    <div class="separator"></div>
    <nav class="footer-menu">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu', 
                'menu_class'     => 'footer-menu', 
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
