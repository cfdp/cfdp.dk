<?php
/*
Template Name: Page no sidebar
*/
?>

<?php get_header(); ?>
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="content clearfix">

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<?php echo '<h1 class="heading grid_12 clearfix">' . get_the_title() . '</h1>'; ?>

			<div class="grid_12">

				<div class="entry">

					<?php the_content(); ?>

					<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

					<?php the_tags( 'Tags: ', ', ', ''); ?>

				</div>

			</div>

		</div>


<?php endwhile; endif; ?>

	</div>
<?php get_footer(); ?>