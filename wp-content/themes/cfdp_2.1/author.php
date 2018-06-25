<?php
	get_header();
	$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>
<div class="content grid_12 clearfix">
    
    <p class="sub-titel">Seneste indlæg</p>
	<h2 class="name"><?php echo $curauth->display_name; ?></h2>
	<div class="blog-posts">
		<?php query_posts($query_string . '&cat=10&posts_per_page=5'); ?>
			<?php include (TEMPLATEPATH . '/inc/posts.php' ); ?>
			<div class="paging"><?php wp_pagenavi(); ?></div>
			<?php wp_reset_query(); ?>
		</div>
</div>

<?php get_footer(); ?>