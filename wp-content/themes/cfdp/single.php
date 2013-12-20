<?php get_header(); ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('html, body').animate({scrollTop: '265px'});
	});
</script>

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
			<div class="breadcrumbs clearfix">
		    <?php if(function_exists('bcn_display'))
		    {
		        bcn_display();
		    }?>
			</div>


			<div class="grid_8 alpha zi1">

				<div class="entry">
					<?php /* Display dates in indlæg, forsiden, nyheder fra CFDP, international news, */
					if ( in_category( array( 9, 10, 11, 35 ) )){ ?>
						<span class="date">Skrevet for <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' siden'; ?> | Seneste redigeret: <?php the_modified_date(); ?></span>
						<?php
					} ?>
					<?php the_content(); ?>

					<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>


				</div>

				<?php edit_post_link('Rediger','',''); ?>

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