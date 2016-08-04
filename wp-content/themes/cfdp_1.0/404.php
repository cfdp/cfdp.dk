<?php get_header(); ?>
<div class="archive content grid_12 clearfix">
	<img src="<?php bloginfo('template_url'); ?>/img/archive.jpg" alt="" />
	<h2 class="thumbHeading grid_12 alpha clearfix">404 - Siden ikke fundet :-(</h2>
		<div class="results grid_8 alpha zi1">
			<p>Prøv at søge på det, du leder efter.</p>
			 <div class="searchByBar block">
        <h2>Søg på cfdp.dk</h2>
        <span class="line"></span>
        <?php include (TEMPLATEPATH . '/searchform.php' ); ?>
      </div>
		</div>
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


		</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
	    lastBlock = $("#nav4 div.tabOpen");
	});
</script>
<?php get_footer(); ?>