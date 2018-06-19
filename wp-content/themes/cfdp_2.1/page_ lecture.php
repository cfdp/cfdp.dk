<?php
/*
Template Name: Page lectures
*/
?>

<?php get_header(); ?>
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="content clearfix">
        <?php echo '<h1 class="heading grid_12 entry clearfix">' . get_the_title() . '</h1>'; ?>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<div class="grid_12">

				<div class="entry">

					<?php the_content(); ?>

				</div>

			</div>

		</div>


<?php endwhile; endif; ?>

	</div>
<?php get_footer(); ?>