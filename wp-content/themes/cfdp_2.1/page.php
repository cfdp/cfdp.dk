
<?php get_header(); ?>
<?php
// Get all custom fields attached to this post and store them in an array
$custom_fields = base_get_all_custom_fields();
?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
            <div class="post-intro">
            <h1><?php the_title(); ?></h1>
            <?php if ( !empty( $meta_teaser ) ) {echo '<p class="text-intro">' . $meta_teaser . '</p>';} ?>   
        </div>
			<div class="grid_8 zi1">
				<div class="entry">
					<?php the_content(); ?>
				</div>


				<?php comments_template(); ?>
			</div>
		</div>


<?php endwhile; endif; ?>

	<div class="sidebar grid_4 zi1 clearfix">
	<?php if( !empty($custom_fields['page_sidebar']) ) { ?>
		<div class="entry">
			<?php echo $custom_fields['page_sidebar']; ?>
		</div>
	<?php } ?>
	</div>
<?php get_footer(); ?>