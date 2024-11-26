<?php get_header(); ?>

<main>
    <?php
        // Requête pour récupérer une photo aléatoire
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 1, // Une seule photo
            'orderby' => 'rand', // Aléatoire
        );

        $random_photo_query = new WP_Query($args);

        if ($random_photo_query->have_posts()) :
            $random_photo_query->the_post(); // Charger la photo aléatoire
            $background_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image mise en avant
    ?>
        <div class="hero" style="background-image: url('<?php echo esc_url($background_image_url); ?>');">
            <div class="hero-content">
                <h1>Photographe Event</h1>
            </div>
        </div>
    <?php 
        wp_reset_postdata(); // Réinitialiser les données
    ?>
        
    <?php endif; ?>

<div class="container">
    <p>Filtres</p>
    <div class="photo-block-container">
    <?php
    get_template_part('template_parts/photo_block', null, array(
        'post_type' => 'photo',
        'posts_per_page' => -1, // Toutes les photos
        'orderby' => 'date',    // Tri par date
        'order' => 'DESC',      // Plus récentes d'abord
    ));
    ?>
    </div>
</div>
</main>

<?php get_footer(); ?>
