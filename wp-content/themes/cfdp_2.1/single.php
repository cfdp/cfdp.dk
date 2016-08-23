<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="content grid_12 clearfix">

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<?php
				if(has_post_thumbnail()) {
				the_post_thumbnail();
				echo '<h2 class="thumbHeading grid_12 alpha clearfix">' . get_the_title() . '</h2>';
				}
				else {
					echo '<h2 class="heading grid_8 alpha clearfix">' . get_the_title() . '</h2>';
				}
			?>


			<div class="grid_8 alpha zi1">

				<div class="entry">
					<?php the_content(); ?>

					<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>


				</div>



				<?php comments_template(); ?>
			</div>

			<div class="sidebar grid_4 omega zi1 clearfix">
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

		</div>


<?php endwhile; endif; ?>

	</div>


<?php get_footer(); ?>