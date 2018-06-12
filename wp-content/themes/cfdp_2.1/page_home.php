<?php
/*
Template Name: Page Home
*/
?>
<?php get_header(); ?>
<div class="content clearfix">
  <div class="grid_12 clearfix">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; endif; ?>
  </div>
  </div>
</div>
<?php get_footer(); ?>