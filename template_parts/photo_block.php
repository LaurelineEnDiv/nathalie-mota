<?php
// Par défaut, aucun argument n'est passé
if (!isset($args)) {
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 6, // Affiche 6 photos par défaut
        'orderby' => 'rand',  // Par défaut, tri aléatoire
    );
}

// Si vous voulez exclure la photo actuelle (utile dans `single-photo`), vous pouvez le gérer dans $args
if (is_singular('photo')) {
    $args['post__not_in'] = array(get_the_ID());
}

// Requête WP_Query avec les arguments 
$query = new WP_Query($args);

// Générer les photos
if ($query->have_posts()) : ?>
    <div class="photo-block">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <?php 
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('large'); 
                    } else {
                        echo '<p>Aucune image disponible</p>';
                    }
                    ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
<?php
    wp_reset_postdata();
else :
    echo '<p>Aucune photo trouvée.</p>';
endif;
?>
