<?php
/*
Template Name: Cases
*/
?>
<?php get_header(); ?>

	<div class="projects content grid_12 clearfix zi1">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				echo '<h2 class="header-h2">'; the_title(); echo '</h2>';
			}
		}
		?>

		<?php

		// post template
		function postContent()
		{
			echo '<h3><a href="'; the_permalink(); echo '">'; the_title(); echo'</a></h3>';
			echo '<a href="'; the_permalink(); echo '">'; the_post_thumbnail( 'medium_large' ); echo'</a>';
			echo '<p class="description">'; truncate(get_the_excerpt(), 320);
			echo ' <a href="'; the_permalink(); echo '" class="more">Læs mere</a>';
			echo '</p>';
		}
		echo '<div class="category-wrap">';

		// query all posts with case category
		query_posts("posts_per_page=30&cat=311&meta_key=order&orderby=meta_value_num&order=ASC");
		if ( have_posts() ) : $count = 0;
				while ( have_posts() ) : the_post();
				$count++;
				if ($count % 2 == 0) : ?>

					<div class="grid_6 omega">
						<div class="post">
							<?php postContent() ?>
						</div>
					</div>

				<?php else : ?>

					<div class="grid_6 alpha">
						<div class="post">
							<?php postContent() ?>
						</div>
					</div>

				<?php endif; ?>
			<?php endwhile;
			echo '
			</div>
			</div><!--/category-->';
			else:
			echo('Desværre ingen indlæg fundet');
			endif;
			wp_reset_query();

?>
</div>


<?php get_footer(); ?>