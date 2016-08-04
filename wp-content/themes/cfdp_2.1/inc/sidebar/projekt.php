<?php
// Submenu
$themeta = get_post_meta($post->ID, 'Parent category 1', true);
//If not empty then
if($themeta != '') {

	if ( function_exists('get_custom_field_value') ){

		$parent_cat_1 = get_custom_field_value('Parent category 1');
		query_posts(array('category_name' => $parent_cat_1));
?>
<h2><?php echo($parent_cat_1) ?></h2>
<span class="line"></span>

<ul class="menu">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<li>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</li>
<?php endwhile; wp_reset_query(); ?>
</ul>
<?php endif; ?>

<?php	} ?>

<?php	} ?>

<?php
// Submenu 2
$themeta = get_post_meta($post->ID, 'Parent category 2', true);
//If not empty then
if($themeta != '') {

	if ( function_exists('get_custom_field_value') ){

		$parent_cat_2 = get_custom_field_value('Parent category 2');
		query_posts(array('category_name' => $parent_cat_2));
?>
<h2><?php echo($parent_cat_2) ?></h2>
<span class="line"></span>

<ul class="menu">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<li>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</li>
<?php endwhile; wp_reset_query(); ?>
</ul>
<?php endif; ?>

<?php	} ?>

<?php	} ?>

<?php
// Submenu 3
$themeta = get_post_meta($post->ID, 'Parent category 3', true);
//If not empty then
if($themeta != '') {

	if ( function_exists('get_custom_field_value') ){

		$parent_cat_3 = get_custom_field_value('Parent category 3');
		query_posts(array('category_name' => $parent_cat_3));
?>
<h2><?php echo($parent_cat_3) ?></h2>
<span class="line"></span>

<ul class="menu">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<li>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</li>
<?php endwhile; wp_reset_query(); ?>
</ul>
<?php endif; ?>

<?php	} ?>

<?php	} ?>

<?php
	// Tesimonial 1
	$themeta = get_post_meta($post->ID, '1. quote', true);
	//If not empty then
	if($themeta != '') {
?>
<div class="ProductsTml">

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
		<?php edit_post_link('Rediger udtalelser','',''); ?>
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
// retrieve one post with an ID of 5
query_posts('page_id=59');
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	the_content();
	endwhile;
	endif;
	wp_reset_query();
?>



<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('#nav3 div.tab').addClass('tabOpen');
	    lastBlock = $("#nav3 div.tabOpen");
	});
</script>