<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php
		$meta_teaser = get_post_meta( get_the_ID(), 'teaser', true );
	?>
	
<div class="content grid_12 clearfix">
	<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <div class="post-intro">
            <h1><?php the_title(); ?></h1>
            <?php if ( !empty( $meta_teaser ) ) {echo '<p class="text-intro">' . $meta_teaser . '</p>';} ?>   
            <div class="intro-box">
                <div class="post-tags clearfix">
                    <div class="left">
                        <p>
                            <?php 
                                $taxonomy = 'foredrag_kategori';

                                // get the term IDs assigned to post.
                                $post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
                                // separator between links
                                $separator = ', ';
                                $categories = get_the_category();
                                $parentid = $categories[0]->category_parent;

                                if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {
                                    echo '<strong>Målgruppe: </strong>';
                                    $term_ids = implode( ',' , $post_terms );
                                    $terms = wp_list_categories( 'title_li=&style=none&echo=0&child_of=' . $parentid . '&taxonomy=' . $taxonomy . '&include=' . $term_ids );
                                    $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

                                    // display post categories
                                    echo  $terms;
                                }
                            ?>
                        </p>
                        <p><strong>Pris fra:</strong> <?php the_field('price'); ?> kr.</p>
                    </div>
                    <div class="right">
                        <a href="#lecture-contact" class="blue_button">Kontakt</a>
                    </div>
                </div>
            </div>
        </div>
        
		<div class="entry">
            
            <?php the_content(); ?>
            
            <?php $contactInfo = get_field( "lecture_contact" ); ?>            
            <?php if ( $contactInfo ) : ?>
                <h2 id="lecture-contact">Kontakt</h2>
                <?php echo $contactInfo ?>
            <?php endif; ?>
            
		</div>
		
	</div><!-- #post- -->
	<?php endwhile; endif; ?>

</div><!-- .content -->

<?php get_footer(); ?>