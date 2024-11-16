<?php

get_header(); 

if ( have_posts() ) : 
    while ( have_posts() ) : 
        the_post(); 

        // Récupération des champs personnalisés
        $type = get_post_meta( get_the_ID(), 'type', true );  
        $ref = get_post_meta( get_the_ID(), 'ref', true );
        // Récupération des taxonomies
        $formats = get_the_terms( get_the_ID(), 'format' );  
        $categories = get_the_terms( get_the_ID(), 'categorie' );  
        // Récupération année (date de publication)
        $annee = get_the_date('Y');
        ?>
        
        <figure id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="photo-infos">
                <h1><?php the_title(); ?></h1>
                <div class="photo-meta">
                    <p>Référence : <?php echo $ref; ?></p>
                    <p>Catégorie : <?php
                        foreach ($categories as $categorie) {
                            echo $categorie->name . ' '; // Affiche le nom du terme
                        } ?>
                    </p> 
                    <p>Format : <?php
                        foreach ($formats as $format) {
                            echo $format->name . ' '; 
                        } ?>
                    </p>
                    <p>Type : <?php echo $type; ?></p> 
                    <p>Année : <?php echo $annee; ?></p>
                    <div class="separator"></div>
                </div>
            </div>

            <div class="photo">
                <?php the_content(); ?>
            </div>
        </figure>

        <div class="interaction-photo">
            
            <div class="contact-photo">
                <p>Cette photo vous intéresse ?</p>
                <button>Contact</button>
            </div>
            
            <div class="photo-container">
                <!-- Afficher la photo actuelle en miniature -->
                <div class="photo-current">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('thumbnail'); ?>
                    <?php else : ?>
                        <p>Aucune image disponible pour cette photo.</p>
                    <?php endif; ?>
                </div>

                <!-- Navigation avec flèches -->
                <div class="photo-navigation">
                    <?php
                    // Boucle des posts du Custom Post Type "photo"
                    $args = array(
                        'post_type' => 'photo',
                        'posts_per_page' => -1, // Charge toutes les photos
                        'orderby' => 'date', // Tri par date
                        'order' => 'ASC', // Ordre ascendant
                    );

                    $photos_query = new WP_Query($args);

                    // Trouver l'index de la photo actuelle
                    $current_id = get_the_ID();
                    $photos = $photos_query->posts;
                    $current_index = array_search($current_id, wp_list_pluck($photos, 'ID'));

                    // Index des photos suivante et précédente
                    $prev_index = $current_index > 0 ? $current_index - 1 : count($photos) - 1; // Boucle si en début de liste
                    $next_index = ($current_index + 1) % count($photos); // Boucle si en fin de liste

                    // Post précédent
                    $prev_post = $photos[$prev_index];
                    ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-prev" title="Photo précédente">
                        &#x2190; <!-- Flèche gauche -->
                    </a>

                    <?php
                    // Post suivant
                    $next_post = $photos[$next_index];
                    ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-next" title="Photo suivante">
                        &#x2192; <!-- Flèche droite -->
                    </a>
                </div>
            </div>


        </div>

    <?php 
    endwhile; 
else :
    echo '<p>Aucun contenu trouvé</p>';
endif;

get_footer(); 
?>

