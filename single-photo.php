<?php get_header(); ?>

<main>
    <?php
    if ( have_posts() ) : 
        while ( have_posts() ) : 
            the_post(); 

        // Récupération des champs personnalisés
        $type = get_post_meta( get_the_ID(), 'type', true);  
        $ref = get_post_meta( get_the_ID(), 'ref', true);
        // Récupération des taxonomies
        $formats = get_the_terms( get_the_ID(), 'format' );  
        $categories = get_the_terms( get_the_ID(), 'categorie' );  
        // Récupération année (date de publication)
        $annee = get_the_date('Y');
    ?>
    <div class="single-photo">
        <figure id="post-<?php the_ID(); ?>" class="container"<?php post_class(); ?>>
            <div class="photo-infos">
                <h1><?php the_title(); ?></h1>
                <div class="photo-meta">
                    <p class="title">Référence : <?php echo $ref; ?></p>
                    <p class="title">Catégorie : <?php
                        foreach ($categories as $categorie) {
                            echo $categorie->name . ' '; 
                        } ?>
                    </p> 
                    <p class="title">Format : <?php
                        foreach ($formats as $format) {
                            echo $format->name . ' '; 
                        } ?>
                    </p>
                    <p class="title">Type : <?php echo $type; ?></p> 
                    <p class="title">Année : <?php echo $annee; ?></p>
                </div>
            </div>

            <div class="photo">
                <?php the_content(); ?>
            </div>
        </figure>

        <div>
            <div class="separator half"></div>
        </div>
        
        <div class="interaction-photo container">
            <div class="contact-photo">
                <p>Cette photo vous intéresse ?</p>
                <a href="#" id="contact-photo-btn" class="open-modale" data-ref="<?php echo esc_attr($ref); ?>">Contact</a>
            </div>
            <div class="nav-photos">
            <div class="thumbnail-container">
                <div class="thumbnail-current">
                    <img src="" id="thumbnail-current-img">
                </div>
                <div class="photo-navigation">
                    <?php
                    // Initialisation de la boucle 
                    $args = array(
                        'post_type' => 'photo',
                        'posts_per_page' => -1, // Charge toutes les photos sans limitation de nombre
                        'orderby' => 'date', // Tri par date
                        'order' => 'ASC', // Ordre ascendant
                    );

                    //création de la requête pour récupérer les postypes "photo"
                    $photos_query = new WP_Query($args);

                    // Trouver l'index de la photo actuelle
                    $current_id = get_the_ID();
                    $photos = $photos_query->posts;
                    $current_index = array_search($current_id, wp_list_pluck($photos, 'ID')); //Extrait un tableau contenant uniquement les IDs des photos récupérées.

                    // Calcul des index des photos suivantes et précédentes
                    $prev_index = $current_index > 0 ? $current_index - 1 : count($photos) - 1; // Boucle si en début de liste
                    $next_index = ($current_index + 1) % count($photos); // % pour boucler si en fin de liste

                    // Récupération du Post précédent
                    $prev_post = $photos[$prev_index];
                    $prev_thumbnail = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); //URL de vignette 

                    // Récupération du Post suivant
                    $next_post = $photos[$next_index];
                    $next_thumbnail = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
                    ?>

                    <!-- Lien vers la photo précédente-->
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" 
                    class="nav-prev" 
                    title="Photo précédente"
                    data-thumbnail="<?php echo esc_url($prev_thumbnail); ?>">
                        &#x2190; <!-- Flèche gauche -->
                    </a>
                    <!-- Lien vers la photo suivante-->
                    <a href="<?php echo get_permalink($next_post->ID); ?>" 
                        class="nav-next" 
                        title="Photo suivante" 
                        data-thumbnail="<?php echo esc_url($next_thumbnail); ?>">
                        &#x2192; <!-- Flèche droite -->
                    </a>
                </div>
            </div>
            </div>
        </div>

    <div>
        <div class="separator"></div>
    </div>

    <div class="similar-photos container">
        <p class="title">Vous aimerez aussi</p>
        <div class="photo-block-container">
        <?php
            // Récupération des termes (IDs) de la categorie associés à la photo actuelle
            $current_categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));   

            get_template_part('template_parts/photo_block', null, array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'orderby' => 'rand',
                'post__not_in' => array(get_the_ID()), //Exclut la photo actuellement affichée 
                'tax_query' => array( //requête conditionnelle pour sélectionner uniquement les photos de la même catégorie
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'term_id',
                        'terms' => $current_categories,
                    ),
                ),
            ));
        ?>
        </div>
    </div>

    </div>
    <?php 
    endwhile;
    endif;
    ?>
</main>

<?php get_footer(); ?>

