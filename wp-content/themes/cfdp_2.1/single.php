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

		<?php
			if(has_post_thumbnail()) {
				the_post_thumbnail();
			}
		?>
		<div class="entry <?php if ( !empty( $meta_teaser ) ){ echo 'entry--with-teaser';} ?>">
			<h1><?php the_title(); ?></h1>
			<?php if ( !empty( $meta_teaser ) ) {echo '<p class="text-intro">' . $meta_teaser . '</p>';} ?>

			<?php if ( post_is_in_descendant_category( 162 ) ) { ?>
				<p class="post-info">
					Senest redigeret for <?php echo human_time_diff(get_the_modified_time('U'), current_time('timestamp')); ?> siden af <?php echo $custom_author_link; ?>
				</p>
			<?php } else { ?>
			<span class="post-info">
		    Indlæg af <?php echo $custom_author_link ?> for
		    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' siden'; ?>
		  </span>
			<?php } ?>

			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
		</div>
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
		</div><!-- .related-content -->
		<?php comments_template(); ?>
	</div><!-- #post- -->
	<?php endwhile; endif; ?>

</div><!-- .content -->

<?php get_footer(); ?>