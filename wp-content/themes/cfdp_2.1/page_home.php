<?php
/*
Template Name: Page Home
*/
?>
<?php get_header(); ?>

<section id="big-video">
    <div class="video" 
         data-src="<?php the_field('fallback_img') ?>" 
         data-video="<?php the_field('banner_video'); ?>" 
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