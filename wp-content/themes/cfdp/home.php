
<?php get_header(); ?>

<script type="text/javascript">
  jQuery(document).ready(function($) {
      $('#nav1 div.tab').addClass('tabOpen');
      lastBlock = $("#nav1 div.tabOpen");
  });
</script>

<div class="content">
  <div class="posts">
    <div class="left grid_6">

      <?php $intro_img = new WP_Query('pagename=forside'); while ($intro_img->have_posts()) : $intro_img->the_post(); $do_not_duplicate = $post->ID;
          if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            the_post_thumbnail('thumbnail', array('class' => 'intro-frontpage'));
          }
      endwhile; ?>

      <?php
/*       // Insert image - Thumbnail from page named "forside"
      query_posts( 'id=4084' );

      while ( have_posts() ) : the_post();
        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
          the_post_thumbnail();
        }

      endwhile;
      wp_reset_query();
*/
      ?>


      <div class="latest">
        <h2>Seneste indlæg</h2>
        <span class="line"></span>

<?php //6 seneste indlæg med kategorien forsiden
        $query = array(
          'category__in' => array(9),
          'posts_per_page'  => 2,
        );
        query_posts($query);
          if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
          <div class="post">
            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            <span class="postInfo">
              af <a href="#" class="author"><?php the_author_posts_link(); ?></a> for
              <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' siden'; ?>
              <?php the_tags(' | Tags: ',' , '); ?>
              <?php $comment_count = get_comment_count($post->ID); ?><?php if ($comment_count['approved'] > 0) : ?> | <?php endif; ?>
              <?php comments_popup_link('', '1 Kommentar', '% Kommentarer'); ?>
            </span>
            <?php truncate( get_the_excerpt(), 350); ?>
             <a href="<?php the_permalink() ?>" class="more">Læs indlæg</a>
          </div>

        <?php endwhile; else:
        echo('Desværre, ingen indlæg fundet');
        endif;
        wp_reset_query();
        ?>

        <a href="erfarninger/vidensarkiv/" class="readMore">Læs flere indlæg</a>

      </div>
    </div>
    <div class="right grid_6">
      <div class="slider">
        <?php dynamic_content_gallery(); ?>
      </div>

      <div class="news">
        <h2>Nyheder fra centeret</h2>
        <span class="line"></span>

        <?php //3 seneste indlæg med kategorien nyheder fra CFDP
        query_posts('cat=11&posts_per_page=2');
          if ( have_posts() ) : while ( have_posts() ) : the_post();
        ?>
          <div class="post">
            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            <span class="postInfo">
              af <a href="#" class="author"><?php the_author_posts_link(); ?></a> for
              <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' siden'; ?>
              <?php the_tags(' | Tags: ',' , '); ?>
              <?php $comment_count = get_comment_count($post->ID); ?><?php if ($comment_count['approved'] > 0) : ?> | <?php endif; ?>
              <?php comments_popup_link('', '1 Kommentar', '% Kommentarer'); ?>
            </span>
            <?php truncate(get_the_excerpt(), 350); ?> <a href="<?php the_permalink() ?>" class="more">Læs indlæg</a>
          </div>

        <?php endwhile; else:
        echo('Desværre er der ingen nyheder fra Centeret');
        endif;
        wp_reset_query();
        ?>

        <a href="/kategori/nyheder/" class="readMore">Læs flere nyheder fra centeret</a>

      </div>
    </div>
  </div>
</div>




<?php get_footer(); ?>