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
            <h1><?php the_title(); ?></h1>
            <div class="photo-meta">
                <p>Référence : <?php echo $ref; ?></p>
                <p>Catégorie : 
                    <?php
                    foreach ($categories as $categorie) {
                        echo $categorie->name . ' '; // Affiche le nom du terme
                    }
                    ?>
                </p> 
                <p>Format : 
                    <?php
                    foreach ($formats as $format) {
                        echo $format->name . ' '; 
                    }
                    ?>
                </p>
                <p>Type : <?php echo $type; ?></p> 
                <p>Année : <?php echo $annee; ?></p>
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
            
            <div class="photo-navigation">
                <?php 
                // Photo précédente
                $prev_post = get_previous_post();
                if ( $prev_post ) : 
                    $prev_thumbnail = get_the_post_thumbnail( $prev_post->ID, 'thumbnail' ); // Miniature du post précédent
                    ?>
                    <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="nav-prev" title="<?php echo esc_attr( get_the_title( $prev_post->ID ) ); ?>">
                        <span class="nav-thumbnail"><?php echo $prev_thumbnail; ?></span>
                        &#x2190; <!-- Flèche gauche -->
                    </a>
                <?php endif; ?>

                <?php 
                // Photo suivante
                $next_post = get_next_post();
                if ( $next_post ) : 
                    $next_thumbnail = get_the_post_thumbnail( $next_post->ID, 'thumbnail' ); // Miniature du post suivant
                    ?>
                    <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="nav-next" title="<?php echo esc_attr( get_the_title( $next_post->ID ) ); ?>">
                        &#x2192; <!-- Flèche droite -->
                        <span class="nav-thumbnail"><?php echo $next_thumbnail; ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    <?php 
    endwhile; 
else :
    echo '<p>Aucun contenu trouvé</p>';
endif;

get_footer(); 
?>

