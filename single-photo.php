<?php

get_header(); 

if ( have_posts() ) : 
    while ( have_posts() ) : 
        the_post(); 

        // Récupération des champs personnalisés
        $type = get_post_meta( get_the_ID(), 'type', true );  
        $ref = get_post_meta( get_the_ID(), 'ref', true );
        ?>
        
        <figure id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="content">
                <?php the_content(); ?>
            </div>
            <div class="photo-meta">
                <p>Type :<?php echo $type; ?></p>
                <p>Référence :<?php echo $ref; ?></p>
            </div>

    </figure>

    <?php 
    endwhile; 
else :
    echo '<p>Aucun contenu trouvé</p>';
endif;

get_footer(); 
?>

