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
  <div class="grid_12 clearfix">
    <div class="blog-posts">
      <?php
        $query = array('category__in' => array(9), 'posts_per_page'  => 6, 'paged'  => $paged);
        query_posts($query);
        include (TEMPLATEPATH . '/inc/posts.php' );
      ?>

        <div class="paging">
          <?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Tidligere indlæg', 'twentyten' ) ); ?>
          <?php previous_posts_link( __( 'Nyere indlæg <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
        </div>
        <?php wp_reset_query(); ?>


      </div>
    </div>
  </div>
</div>




<?php get_footer(); ?>