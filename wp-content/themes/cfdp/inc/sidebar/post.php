<div class="aboutAuthor clearfix block">
	<h2>Indlæggets forfatter</h2>
	<span class="line"></span>
	<a class="imgLink" href="<?php the_author_meta('user_url'); ?>"><?php echo get_avatar( get_the_author_meta('email'), '55' ); ?></a>
	<p class="bio">
		<?php the_author_posts_link(); ?> :
		<?php the_author_meta('description'); ?>
	</p>

	<a class="rssfeed" href='<?php bloginfo('url') ?>/author/<?php authorPermalink(get_the_author());?>/feed/'><span></span>Abonner på RSS-feed</a><br>
	<a class="newsletter" href="/nyhedsbrev"><span></span>Tilmeld nyhedsbrev</a>
</div>



<?php
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
?>
<div class="relatedTags block">
	<h2>Relaterede indlæg</h2>
	<span class="line"></span>
<?php
		$first_tag = $tags[0]->term_id;

	  	$query=array(
	    	'tag__in' => array($first_tag),
	    	'post__not_in' => array($post->ID),
	    	'showposts'=>5,
	    	'caller_get_posts'=>1
	   	);

	  	$my_query = new WP_Query($query);
  		if( $my_query->have_posts() ) {
  			while ($my_query->have_posts()) : $my_query->the_post();
?>
	<p>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Læa <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</p>
<?php
	    	endwhile;
	  	}
?>
</div>
<?php
	}
?>


<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('#nav4 div.tab').addClass('tabOpen');
	    lastBlock = $("#nav4 div.tabOpen");
	});
</script>