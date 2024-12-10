<footer>
    <div class="lightbox">
        <img src="">
        <span class="close">&times;</span>
        <span class="prev">&#10094;</span>
        <span class="next">&#10095;</span>
    </div>
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
