<?php get_header(); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('html, body').animate({scrollTop: '265px'});
	});
</script>

		<?php if (have_posts()) : ?>
		<div class="archive content grid_12 clearfix">
			<img src="<?php bloginfo('template_url'); ?>/img/archive.jpg" alt="" />

 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

			<?php /* If this is a category archive */ if (is_category()) { ?>
				<h2 class="thumbHeading grid_12 alpha clearfix">Arkiv for &#8216;<?php single_cat_title(); ?>&#8217; kategori</h2>

			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h2 class="thumbHeading grid_12 alpha clearfix">Indlæg med &#8216;<?php single_tag_title(); ?>&#8217; tag</h2>

			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h2 class="thumbHeading grid_12 alpha clearfix">Arkiv for <?php the_time('j. F Y'); ?></h2>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h2 class="thumbHeading grid_12 alpha clearfix">Arkiv for <?php the_time('F, Y'); ?></h2>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h2 class="thumbHeading grid_12 alpha clearfix">Arkiv for <?php the_time('Y'); ?></h2>

			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h2 class="thumbHeading grid_12 alpha clearfix">Forfatter Arkiv</h2>

			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h2 class="thumbHeading grid_12 alpha clearfix">Arkiv</h2>

			<?php } ?>
				<div class="results grid_8 alpha zi1">

			<?php while (have_posts()) : the_post(); ?>

			<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<div class="meta">
				Skrevet den <?php the_time('j. F Y') ?> af <?php the_author_posts_link(); ?>
			</div>
			<div class="entry" style="padding-bottom:30px; margin-bottom:30px; border-bottom:1px solid #ddd;">
 				<?php truncate(get_the_excerpt(), 380) ?>
				<a href="<?php the_permalink() ?>" class="more">Læs mere</a>
			</div>
			<?php endwhile; ?>

			<div class="paging"><?php wp_pagenavi(); ?></div>
	</div>

	<?php else : ?>

		<h2>Intet fundet</h2>
	</div>

	<?php endif; ?>

		<div class="sidebar grid_4 omega zi1 clearfix">
			<div class="searchByDate block">
				<h2>Søg efter dato</h2>
				<span class="line"></span>
				<ul>
					<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
				</ul>

			</div>

			<div class="searchByAuthor block">
				<h2>Søg efter skribent</h2>
				<span class="line"></span>
				<ul>
				<?php wp_list_authors('exclude_admin=0&optioncount=1&show_fullname=1&hide_empty=1'); ?>
				</ul>
			</div>

			<div class="searchByTag block">
				<h2>Søg efter tag</h2>
				<span class="line"></span>
				<?php st_tag_cloud();?>
			</div>

			<div class="searchByBar block">
				<h2>Søg på cfdp.dk</h2>
				<span class="line"></span>
				<?php include (TEMPLATEPATH . '/searchform.php' ); ?>
			</div>
		</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
	    lastBlock = $("#nav4 div.tabOpen");
	});
</script>
<?php get_footer(); ?>
