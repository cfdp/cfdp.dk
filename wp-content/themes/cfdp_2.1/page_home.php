<?php
/*
Template Name: Page Home
*/
?>
<?php get_header(); ?>

<?php

// Get the video URL and put it in the $video variable
$videoID = get_post_meta($post->ID, 'banner_video', true);
if ($videoID) {
	$videoURL = 'http://www.youtube.com/watch?v=' . $videoID; 
}
?>

<section id="big-video">
    <div class="video" 
         data-src="<?php the_field('fallback_img') ?>" 
         data-video="<?php echo $videoURL; ?>" 
         data-placeholder="<?php the_field('start_img') ?>">
    </div>
</section>

<div class="content clearfix">
  <div class="grid_12 clearfix">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; endif; ?>
  </div>
  </div>
</div>
<?php get_footer(); ?>