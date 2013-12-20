<?php
/*
Template Name: International
*/
?>
<?php get_header(); ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
lastBlock = $("#nav1 div.tabOpen");
});
</script>

<div class="international content grid_12 clearfix">
	<div class="posts grid_6 alpha zi1">
		<h2>International news</h2>

		<span class="line"></span>
		<?php
		$query = array(
		'category__in' => array(35),
		'posts_per_page' => 6,
		);
		query_posts($query);

		if ( have_posts() ) : while ( have_posts() ) : the_post();
		?>
			<div class="post">
				<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
				<span class="postInfo">written by <a href="#" class="author"><?php the_author_posts_link(); ?></a> | <?php comments_popup_link('Leave a comment', '1 Comment', '% Comments'); ?></span>
				<?php truncate(get_the_excerpt(), 350); ?> <a href="<?php the_permalink() ?>" class="more">read more</a>
			</div><!-- end .post -->
		<?php
		endwhile; else:
			echo('Desværre ingen indlæg fundet');
		endif;

		wp_reset_query();
		?>

		<a href="/kategori/news/" class="readMore">Read more news in english</a>
	</div><!-- end .posts -->

	<div class="about posts grid_6 omega clearfix zi1">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<span class="line"></span>
		<?php the_content(); ?>
		<?php edit_post_link('Rediger','',''); ?>
		<?php endwhile; endif; ?>
	</div><!-- end .about posts -->

</div>

<?php get_footer(); ?>
