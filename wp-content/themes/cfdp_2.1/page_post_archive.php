<?php
/*
Template Name: Oversigt alle indlæg
*/
?>

<?php get_header(); ?>
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="content grid_12 clearfix">

		<div id="post-<?php the_ID(); ?>" class="archive">
            <?php echo '<p class="sub-titel">Kategori:</p>' ?>    
			<?php echo '<h2 class="heading alpha grid_12 clearfix">' . get_the_title() . '</h2>'; ?>

			<div class="grid_12">

				<div class="entry results">

					<?php the_content(); ?>

				</div>

			</div>

		</div>
    
    </div>


<?php endwhile; endif; ?>

<?php get_footer(); ?>