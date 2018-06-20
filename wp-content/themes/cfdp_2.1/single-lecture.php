<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="content grid_12 clearfix">

	<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <div class="post-intro">

            <h1><?php the_title(); ?></h1>

        </div>
        
		<div class="entry">
			<?php the_content(); ?>
		</div>
        
        

	</div><!-- #post- -->
	<?php endwhile; endif; ?>

</div><!-- .content -->

<?php get_footer(); ?>