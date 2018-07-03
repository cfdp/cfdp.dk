<?php
/*
Template Name: Oversigt alle indlæg
*/
?>

<?php get_header(); ?>
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="content clearfix">

		<div id="post-<?php the_ID(); ?>" class="archive">

			<div class="grid_12">

				<div class="entry results">

					<?php the_content(); ?>

				</div>

			</div>

		</div>
    
    </div>


<?php endwhile; endif; ?>

<?php get_footer(); ?>