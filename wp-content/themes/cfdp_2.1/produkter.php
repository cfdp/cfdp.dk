<?php
/*
Template Name: Oplaeg
*/
?>
<?php get_header(); ?>

	<div class="products content grid_12 clearfix zi1">

		<?php

		// Produkter category = ID 6
		$categories=get_categories('child_of=162&orderby=slug');

		// post template
		function postContent()
		{
			echo '<a href="'; the_permalink(); echo '">'; the_post_thumbnail( 'medium' ); echo'</a>';
			echo '<h3><a href="'; the_permalink(); echo '">'; the_title(); echo'</a></h3>';
			echo '<p>'; truncate(get_the_excerpt(), 280);
			echo ' <a href="'; the_permalink(); echo '" class="more">Læs mere</a>';
			echo '</p>';
		}
		// array of child cat to cat ID 6 in a foreach
		foreach($categories as $category)
		{
			echo '<div class="category-wrap '.($category->slug).' grid_12 alpha"><div class="grid_12 alpha clearfix">
						<a class="anchor" name="'.($category->slug).'" href=""></a>
						<h1>'.($category->name).'</h1>
					</div>
						<p class="text-intro grid_12 alpha clearfix">' .($category->category_description). '</p>';
			echo '<div class="childCatPosts clearfix">';
		    // query all post in child cat order asc by title
		    query_posts("posts_per_page=30&cat=$category->cat_ID&meta_key=order&orderby=meta_value_num&order=ASC");
		    // $count used to set css class if post a first or last (1,4=first & 3,6=last ect)
		    if ( have_posts() ) :
					while ( have_posts() ) : the_post(); ?>
						<div class="post clearfix">
							<?php postContent() ?>
						</div>
				<?php endwhile;
				echo '
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