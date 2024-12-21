<?php
// Récupérer les arguments
if (!isset($args)) {
    $args = array(
        'post_type' => 'photo',
    );
}

// Requête WP_Query avec les arguments 
$query = new WP_Query($args);

// Afficher les photos sous forme de vignettes cliquables
if ($query->have_posts()) : ?>
    <div class="photo-block">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="photo-item">
            <a href="<?php the_permalink(); ?>">
                <?php 
                if (has_post_thumbnail()) {
                    the_post_thumbnail('large'); 
                }
                ?>
            </a>

            <!-- Overlay infos + icône Lightbox -->
            <?php
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category_name = (!empty($categories) && !is_wp_error($categories)) ? esc_html($categories[0]->name) : '';
            ?>
            <div class="photo-overlay">
                <span class="lightbox-icon" 
                    data-image="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"
                    data-ref="<?php echo esc_attr(get_post_meta(get_the_ID(), 'ref', true)); ?>"
                    data-category="<?php echo $category_name; ?>">
                    <i class="fas fa-expand"></i> 
                </span>
                <span class="eye-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon_eye.png">
                </span>
                <div class="photo-reference">
                    <?php echo esc_html(get_post_meta(get_the_ID(), 'ref', true)); ?>
                </div>
                <div class="photo-category">
                    <?php echo $category_name; ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
<?php
    wp_reset_postdata();
endif;
?>
