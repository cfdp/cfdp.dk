<?php
	get_header();
	$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>
<div class="content grid_12 clearfix">

	<h1 class="name"><?php echo $curauth->display_name; ?></h1>
	<div class="blog-posts">
		<h2>Seneste indlæg</h2>
		<?php query_posts($query_string . '&cat=10&posts_per_page=5'); ?>
			<?php include (TEMPLATEPATH . '/inc/posts.php' ); ?>
			<div class="paging"><?php wp_pagenavi(); ?></div>
			<?php wp_reset_query(); ?>
		</div>
</div>

<?php get_footer(); ?>