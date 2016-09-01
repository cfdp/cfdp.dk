<?php
/*
Template Name: Oversigt medarbejder
*/
?>
<?php get_header(); ?>

<?php
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		echo '<h1 class="header-h1">'; the_title(); echo '</h1>';
		echo '<div class="text-intro">'; the_content(); echo '</div>';
	}
}
?>


<?php
$query = new WP_Query(array('post_type'=>'person', 'post_status'=>'publish','meta_key'=>'type', 'meta_value'=>'medarbejder', 'orderby'=>'meta_value_num', 'meta_key'=>'order', 'posts_per_page'=>-1)); ?>

<?php if ( $query->have_posts() ) : ?>

<ul class="persons">
	<!-- the loop -->
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>

		<li class="person">
			<?php if(has_post_thumbnail()) { ?>
				<a class="image" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('medium'); ?>
				</a>
			<?php } else { ?>
				<a class="image" href="<?php the_permalink(); ?>">
					<img src="http://thecatapi.com/api/images/get?format=src&type=jpg">
				</a>
				<?php } ?>
			<h2 class="name"><?php the_title(); ?></h2>
			<?php
				$meta_titel = get_post_meta( get_the_ID(), 'titel', true );
				if ( !empty( $meta_titel ) ) { echo '<span class="title">' . $meta_titel . '</span>'; }
			?>
			<a class="blue-ghost_button" href="<?php the_permalink(); ?>">Se profil</a>

		</li>

	<?php endwhile; ?>
	<!-- end of the loop -->

</ul>

	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
