<div class="photo-block">
            <?php
            // Vérifier les catégories associées à la photo actuelle
            $current_categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));
            
            // Récupérer deux photos aléatoires dans les mêmes catégories
                $args = array(
                    'post_type' => 'photo',
                    'posts_per_page' => 2, 
                    'orderby' => 'rand', // Aléatoire
                    'post__not_in' => array(get_the_ID()), // Exclure la photo actuelle
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categorie',
                            'field' => 'term_id',
                            'terms' => $current_categories,
                        ),
                    ),
                );

                $photos_query = new WP_Query($args);

                // Si des photos sont trouvées
                if ($photos_query->have_posts()) :
                    while ($photos_query->have_posts()) : $photos_query->the_post(); ?>
                        <div class="photo-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php 
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('large'); 
                                } 
                                ?>
                            </a>
                        </div>
                    <?php endwhile; 
                    wp_reset_postdata(); // Réinitialise les données
                endif;
            ?>
        </div>