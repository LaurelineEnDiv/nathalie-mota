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
            $background_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image 
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
        <!--------- Filtres ------------>
        <div class="filters-container">
            <div class="taxonomies">
                <div class="filter-group" data-taxonomy="categorie">
                    <span class="filter-title" data-default-title="Catégories">Catégories</span>
                    <i class="fa-solid fa-chevron-down"></i>
                    <div class="filter-options">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'categorie',
                            'hide_empty' => true,
                        ));
                        foreach ($categories as $category) {
                            echo '<div class="filter-option" data-term-id="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="filter-group" data-taxonomy="format">
                    <span class="filter-title" data-default-title="Formats">Formats</span>
                    <i class="fa-solid fa-chevron-down"></i>
                    <div class="filter-options">
                        <?php
                        $formats = get_terms(array(
                            'taxonomy' => 'format',
                            'hide_empty' => true,
                        ));
                        foreach ($formats as $format) {
                            echo '<div class="filter-option" data-term-id="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="dates">
                <div class="filter-group" data-taxonomy="orderby">
                    <span class="filter-title" data-default-title="Trier par">Trier par</span>
                    <i class="fa-solid fa-chevron-down"></i>
                    <div class="filter-options">
                        <div class="filter-option" data-term-id="DESC">Plus récentes</div>
                        <div class="filter-option" data-term-id="ASC">Plus anciennes</div>
                    </div>
                </div>
            </div>
        </div>

        <!--------- Liste des photos ------------>
        <div class="photo-block-container">
            <?php
            get_template_part('template_parts/photo_block', null, array(
                'post_type' => 'photo',
                'posts_per_page' => 8,             
            ));
            ?>
        </div>
        <!---- Bouton "Charger plus" --->
        <div class="load-more-container">
            <a href="#" id="load-more-photos" data-offset="8">Charger plus</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>