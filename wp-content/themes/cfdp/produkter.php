<?php
/*
Template Name: Oplaeg
*/
?>
<?php get_header(); ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('#nav1 div.tab').addClass('tabOpen');
	    lastBlock = $("#nav1 div.tabOpen");
	});
</script>

	<div class="products content grid_12 clearfix zi1">

		<?php

		// Produkter category = ID 6
		$categories=get_categories('child_of=162&orderby=slug');

		// post template
		function postContent()
		{
			echo '<h3><a href="'; the_permalink(); echo '">'; the_title(); echo'</a></h3>';
			echo '<a href="'; the_permalink(); echo '">'; the_post_thumbnail( 'medium' ); echo'</a>';
			echo '<p>'; truncate(get_the_excerpt(), 280);
			echo ' <a href="'; the_permalink(); echo '" class="more">Læs mere</a>';
			echo '</p>';
		}
		// array of child cat to cat ID 6 in a foreach
		foreach($categories as $category)
		{
			echo '<div class="category-wrap '.($category->slug).' grid_12 alpha"><div class="grid_12 alpha clearfix">
						<a class="anchor" name="'.($category->slug).'" href=""></a>
						<h2 class="description">'.($category->name).'</h2>
					</div>
						<p class="intro grid_8 alpha clearfix">' .($category->category_description). '</p>';
			echo '<div class="childCatPosts grid_12 alpha clearfix">';
		    // query all post in child cat order asc by title
		    query_posts("posts_per_page=30&cat=$category->cat_ID&meta_key=order&orderby=meta_value_num&order=ASC");
		    // $count used to set css class if post a first or last (1,4=first & 3,6=last ect)
		    if ( have_posts() ) : $count = 0;
					while ( have_posts() ) : the_post();
					$count++;
					if ($count == 1 || $count == 4 || $count == 7 || $count == 10) : ?>

						<div class="post grid_4 alpha">
							<?php postContent() ?>
						</div>

					<?php elseif ($count == 3 || $count == 6 || $count == 9 || $count == 12) : ?>

						<div class="post grid_4 omega">
							<?php postContent() ?>
						</div>
					</div>
					<div class="childCatPosts grid_12 alpha clearfix">

					<?php else : ?>

						<div class="post grid_4">
							<?php postContent() ?>
						</div>

					<?php endif; ?>
				<?php endwhile;
				echo '
				</div>
				<div class="grid_12 clearfix" style="margin-bottom:10px;">
				</div>
				</div><!--/category-->';
				else:
				echo('Desværre ingen indlæg fundet');
				endif;
				wp_reset_query();
		}
		wp_reset_query();

		?>





	</div>


<?php get_footer(); ?>