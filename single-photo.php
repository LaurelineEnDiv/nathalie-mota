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
            <div class="content">
                <?php the_content(); ?>
            </div>
        </figure>

    <?php 
    endwhile; 
else :
    echo '<p>Aucun contenu trouvé</p>';
endif;

get_footer(); 
?>

