<?php
	// Testimonial
	$themeta = get_post_meta($post->ID, '1. quote', true);
	//If not empty then
	if($themeta != '') {
?>
<div class="ProductsTml">
	<?php edit_post_link('Rediger udtalelser','',''); ?>
	<h2>Det siger andre om os</h2>
	<span class="line"></span>
	<div>
		<span class="quote"></span>
		<p>
<?php
			if ( function_exists('get_custom_field_value') ){
				get_custom_field_value('1. quote', true);
			}
?>
		</p>
		<p class="quoteBy">
<?php
			if ( function_exists('get_custom_field_value') ){
				get_custom_field_value('1. quote by', true);
			}
?>
		</p>
	</div>
</div>
<?php
	}
?>

<?php
	$themeta = get_post_meta($post->ID, '2. quote', true);
	if($themeta != '') {
?>
<div class="ProductsTml">
	<div>
		<span class="quote"></span>
		<p>
<?php
			if ( function_exists('get_custom_field_value') ){
				get_custom_field_value('2. quote', true);
			}
?>
		</p>
		<p class="quoteBy">
<?php
			if ( function_exists('get_custom_field_value') ){
				get_custom_field_value('2. quote by', true);
			}
?>
		</p>
	</div>
</div>
<?php
	}
//Testimonial end
?>



<?php
	//fetch all post in this post first cat (posts should only contain one cat, but as fallback it only check first cat.)
	$categoryArray = get_the_category();
	$category = $categoryArray[0]->cat_ID;
	//Get this post ID
	$thiscat = get_the_ID();

	//query post of same cat, but exclude this post
	query_posts(array(
	 'cat'      	=> $category,
	 'post__not_in' => array($thiscat)
	));

	if ( have_posts() ) :
?>
<div class="otherProducts">
	<h2>Andre oplæg</h2>
	<span class="line"></span>
<?php
	while ( have_posts() ) : the_post();
?>
	<div class="post">
		<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
		<?php truncate(get_the_excerpt(), 150); ?>
		<a href="<?php the_permalink() ?>" class="more">Læs mere</a>
	</div>
<?php
	endwhile;
?>
</div>
<?php
	endif;
		wp_reset_query();
?>



<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('#nav1 div.tab').addClass('tabOpen');
	    lastBlock = $("#nav1 div.tabOpen");
	});
</script>