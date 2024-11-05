<footer>
    <div class="footer-widgets">
        <!-- Placez les widgets de pied de page ou tout autre contenu ici -->
    </div>
    <div class="site-info">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. Tous droits réservés.</p>
        <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a> | <a href="/contact">Contact</a></p>
    </div>
</footer>

<?php wp_footer(); // Nécessaire pour les scripts et plugins WordPress ?>
</body>
</html>
