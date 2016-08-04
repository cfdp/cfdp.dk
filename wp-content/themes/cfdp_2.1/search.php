<?php get_header(); ?>

<?php if (have_posts()) : ?>
<div class="searchresults archive content grid_12 clearfix">
	<img src="<?php bloginfo('template_url'); ?>/img/archive.jpg" alt="" />
	<h2 class="thumbHeading grid_12 alpha clearfix">Søgeresultater</h2>
	<div class="breadcrumbs">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>
	</div>
	<div class="results grid_8 alpha zi1">
<?php while (have_posts()) : the_post(); ?>

			<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<?php if ( post_is_in_descendant_category(162) ) {} else { ?>
				<div class="meta">
					Skrevet den <?php the_time('j. F Y') ?> af <?php the_author_posts_link(); ?>
				</div>
			<?php } ?>

			<div class="entry" style="padding-bottom:30px; margin-bottom:30px; border-bottom:1px solid #ddd;">
 				<?php truncate(get_the_excerpt(), 380) ?>
				<a href="<?php the_permalink() ?>" class="more">Læs mere</a>
			</div>

<?php endwhile; ?>
		<div class="paging"><?php wp_pagenavi(); ?></div>
	</div>
<?php else : ?>
	<div class="searchresults archive content grid_12 clearfix">
		<div class="results grid_8 alpha zi1">
			<h2>Fandt desværre ingenting, prøv med nogle andre søgeord ;-)</h2>
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
