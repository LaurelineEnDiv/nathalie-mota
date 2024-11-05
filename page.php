<?php
// page.php - Template pour les pages statiques

get_header(); // Inclut le header du site

if ( have_posts() ) : 
    while ( have_posts() ) : 
        the_post(); 
        ?>
        
        <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="content">
                <?php the_content(); ?>
            </div>
        </article>

    <?php 
    endwhile; 
else :
    echo '<p>Aucune page trouvée</p>';
endif;

get_footer(); // Inclut le footer du site
?>
