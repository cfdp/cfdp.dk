<?php
/*
Template Name: Newsletter
*/
?>

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
					echo '<h2 class="heading grid_12 alpha clearfix">' . get_the_title() . '</h2>';
				}
			?>

			<div class="grid_12 alpha zi1">

				<div class="entry">
					
					<?php the_content(); ?>
                    <iframe src="http://cfdp.us4.list-manage2.com/subscribe?u=89a2e3056afbe01cc602c0dcd&id=2eab365ff5" frameborder="0" style="width: 100%; height: 700px"></iframe>
					<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
					
					<?php the_tags( 'Tags: ', ', ', ''); ?>
				</div>
				
				<?php edit_post_link('Rediger','',''); ?>
				
				<?php comments_template(); ?>		
			</div>
		
		</div>
	
		
<?php endwhile; endif; ?>	
	
	</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    lastBlock = $("#nav1 div.tabOpen");
	});
</script>
<?php get_footer(); ?>