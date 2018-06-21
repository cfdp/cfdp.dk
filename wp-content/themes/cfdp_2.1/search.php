<?php get_header(); ?>

<?php if (have_posts()) : ?>
<div class="searchresults archive content grid_12 clearfix">
	<h1 class="post-intro clearfix">Søgeresultater</h1>
	<div class="post-intro results">
<?php while (have_posts()) : the_post(); ?>
        
        <div class="search-post-wrapper">
            <div class="post-info">
                <div>
                     <? echo get_avatar( get_the_author_meta('user_email'), $size = '30'); ?>
                </div>
                <div>
                    <p>Af: <?php the_author_posts_link(); ?>&nbsp;·&nbsp;<span>Senest redigeret for <?php echo human_time_diff(get_the_modified_time('U'), current_time('timestamp')); ?> siden</span></p>
                </div>
            </div>
        
            <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

			<div class="entry">
 				<?php truncate(get_the_excerpt(), 250) ?>
			</div>
        </div>

<?php endwhile; ?>
		<div class="paging"><?php wp_pagenavi(); ?></div>
	</div>
<?php else : ?>
	<div class="searchresults archive content grid_12 clearfix">
		<div class="results grid_12">
			<h2>Fandt desværre ingenting, prøv med nogle andre søgeord ;-)</h2>
		</div>
<?php endif; ?>

</div>

<?php get_footer(); ?>
