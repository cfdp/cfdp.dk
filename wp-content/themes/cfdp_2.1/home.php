<?php get_header(); ?>

<div class="content clearfix">
  <div class="slider grid_12 clearfix">
    <?php dynamic_content_gallery(); ?>
  </div><!-- .slider -->
  <div class="grid_12 clearfix">
    <div class="blog-posts">
      <h2 class="clearfix">Seneste indlæg</h2>
      <?php
        $query = array('category__in' => array(9), 'posts_per_page'  => 6,);
        query_posts($query);
        include (TEMPLATEPATH . '/inc/posts.php' );
        wp_reset_query();
        ?>
        <a href="/alle-indlaeg/" class="readMore">Læs&nbsp;flere&nbsp;indlæg</a>

      </div>
    </div>
  </div>
</div>




<?php get_footer(); ?>