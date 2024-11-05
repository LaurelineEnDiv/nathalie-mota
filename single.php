<?php
// single.php - Template pour les articles individuels

get_header(); // Inclut le header du site

if ( have_posts() ) : 
    while ( have_posts() ) : 
        the_post(); 
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="content">
                <?php the_content(); ?>
            </div>
        </article>

    <?php 
    endwhile; 
else :
    echo '<p>Aucun contenu trouvé</p>';
endif;

get_footer(); // Inclut le footer du site

//the_post(), the_title(), the_content() sont des fonctions WordPress essentielles qui récupèrent et affichent le contenu de chaque post ou page.
?>

