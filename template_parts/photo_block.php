<?php

if (!isset($args)) {
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => 1, // Page par défaut
    );
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
endif;
?>
