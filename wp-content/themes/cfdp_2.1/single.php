<?php include (TEMPLATEPATH . '/inc/post_authorlink.php' ); ?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php
		include (TEMPLATEPATH . '/inc/post_authorlink.php' );
		$meta_teaser = get_post_meta( get_the_ID(), 'teaser', true );
		$meta_author_titel = get_post_meta( get_the_ID(), 'author_titel', true );
		$meta_author_image_id = get_post_meta( get_the_ID(), 'author_image', true );
	?>

<div class="content grid_12 clearfix">
	<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <div class="post-intro">
            <span class="post-tags">
                <?php 
                    $taxonomy = 'category';

                    // get the term IDs assigned to post.
                    $post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
                    // separator between links
                    $separator = ' · ';
                    $categories = get_the_category();
                    $parentid = $categories[0]->category_parent;

                    if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {
                        echo 'Kategorier:';
                        $term_ids = implode( ',' , $post_terms );
                        $terms = wp_list_categories( 'title_li=&style=none&echo=0&child_of=' . $parentid . '&taxonomy=' . $taxonomy . '&include=' . $term_ids );
                        $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

                        // display post categories
                        echo  $terms;
                    }
                ?>
            </span>

            <h1><?php the_title(); ?></h1>
            <?php if ( !empty( $meta_teaser ) ) {echo '<p class="text-intro">' . $meta_teaser . '</p>';} ?>

            <?php if ( post_is_in_descendant_category( 162 ) ) { ?>
                <div class="post-info">
                    <div>
                        <?php
                            $get_author_id = get_the_author_meta('ID');
                            $get_author_gravatar = get_avatar_url($get_author_id, array('size' => 30));
                            echo '<img src="'.$get_author_gravatar.'" alt="'.get_the_title().'" />';
                        ?>
                    </div>
                    <div>
                        <p>Af: <?php echo $custom_author_link; ?>&nbsp;·&nbsp;<span>Senest redigeret for <?php echo human_time_diff(get_the_modified_time('U'), current_time('timestamp')); ?> siden</span></p>
                    </div>
                </div>
            <?php } else if ( !in_category('case') ) { ?>
            <div class="post-info">
                <div>
                    <?php
                        $get_author_id = get_the_author_meta('ID');
                        $get_author_gravatar = get_avatar_url($get_author_id, array('size' => 30));
                        echo '<img src="'.$get_author_gravatar.'" alt="'.get_the_title().'" />';
                    ?>
                </div>
                <div>
                    <p>Indlæg af: <?php echo $custom_author_link; ?>&nbsp;·&nbsp;<span>for <?php echo human_time_diff(get_the_modified_time('U'), current_time('timestamp')); ?> siden</span></p>
                </div>
            </div>
            <?php } ?>
        </div>
        
		<div class="entry <?php if ( !empty( $meta_teaser ) ){ echo 'entry--with-teaser';} ?>">
			<?php the_content(); ?>
            <?php 
                if( comments_open() ) {
                    comments_template();
                }
            ?>
		</div>
        
        <?php if ( has_tag() ) { ?>
		<div class="related-content">
			<?php // Show sidebar based on which cate the post is in.

			if ( post_is_in_descendant_category(162) ) {
				include(TEMPLATEPATH . '/inc/sidebar/produkt.php');
			} elseif ( post_is_in_descendant_category(8) ) {
				include(TEMPLATEPATH . '/inc/sidebar/erfarning.php');
			} elseif ( post_is_in_descendant_category(7) ) {
				include(TEMPLATEPATH . '/inc/sidebar/projekt.php');
			} else {
				include(TEMPLATEPATH . '/inc/sidebar/post.php');
			}

			?>
		</div>
        <?php } ?>
	</div><!-- #post- -->
	<?php endwhile; endif; ?>

</div><!-- .content -->

<?php get_footer(); ?>