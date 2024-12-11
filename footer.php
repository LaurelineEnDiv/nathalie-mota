<footer>

    <div class="lightbox">
        <figure>
            <img src="">
            <div class="lightbox-meta">
                <div class="lightbox-ref"></div>
                <div class="lightbox-category"></div>
            </div>
        </figure>
        <span class="close">&times;</span>
        <a href="#" class="prev"><i class="fas fa-arrow-left"></i> Précédente</a>
        <a href="#" class="next">Suivante <i class="fas fa-arrow-right"></i></a>
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
