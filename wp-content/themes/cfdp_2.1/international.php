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
        $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;

        $query = array(
          'category__in' => array(35),
          'posts_per_page'  => 6,
          'paged'  => $paged
        );
        query_posts($query);
        if ( have_posts() ) : while ( have_posts() ) : the_post();
        include (TEMPLATEPATH . '/inc/post.php' );
        endwhile; else:
        echo('Desværre, ingen indlæg fundet');
        endif;
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