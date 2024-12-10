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
                <div class="photo-overlay">
                    <span class="lightbox-icon" data-image="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>">
                        <i class="fas fa-expand"></i> 
                    </span>
                    <span class="hover-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon_eye.png">
                    </span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php
    wp_reset_postdata();
endif;
?>
