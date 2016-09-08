<?php include (TEMPLATEPATH . '/inc/post_authorlink.php' ); ?>

<?php
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
?>
<div class="relatedTags block">
	<h2>Relaterede indlæg</h2>
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
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Læs <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</p>
<?php
	    	endwhile;
	  	}
?>
</div>
<?php
	}
?>