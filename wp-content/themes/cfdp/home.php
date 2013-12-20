
<?php get_header(); ?>

<script type="text/javascript">
  jQuery(document).ready(function($) {
      $('#nav1 div.tab').addClass('tabOpen');
      lastBlock = $("#nav1 div.tabOpen");
  });
</script>

<div class="content">
  <div class="slider grid_12">
    <?php dynamic_content_gallery(); ?>
  </div><!-- .slider -->

  <div class="posts">
    <div class="left grid_8">
      <div class="latest">
        <h2>Seneste indlæg</h2>
        <span class="line"></span>

<?php //2 seneste indlæg med kategorien forsiden
        $query = array(
          'category__in' => array(9),
          'posts_per_page'  => 3,
        );
        query_posts($query);
          if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
          <div class="post">
            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            <span class="postInfo">
              af <a href="#" class="author"><?php the_author_posts_link(); ?></a> for
              <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' siden'; ?>
              <?php $comment_count = get_comment_count($post->ID); ?><?php if ($comment_count['approved'] > 0) : ?> | <?php endif; ?>
              <?php comments_popup_link('', '1 Kommentar', '% Kommentarer'); ?>
            </span>
            <?php truncate( get_the_excerpt(), 350); ?>
             <a href="<?php the_permalink() ?>" class="more">Læs&nbsp;indlæg</a>
          </div>

        <?php endwhile; else:
        echo('Desværre, ingen indlæg fundet');
        endif;
        wp_reset_query();
        ?>

        <a href="erfarninger/vidensarkiv/" class="readMore">Læs&nbsp;flere&nbsp;indlæg</a>

      </div>
    </div> <!-- .left -->

    <div class="right grid_4">

      <div class="news">
        <h2>Nyheder fra centeret</h2>
        <span class="line"></span>

        <?php //3 seneste indlæg med kategorien nyheder fra CFDP
        query_posts('cat=11&posts_per_page=1');
          if ( have_posts() ) : while ( have_posts() ) : the_post();
        ?>
          <div class="post">
            <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            <span class="postInfo">
              af <a href="#" class="author"><?php the_author_posts_link(); ?></a> for
              <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' siden'; ?>
              <?php $comment_count = get_comment_count($post->ID); ?><?php if ($comment_count['approved'] > 0) : ?> | <?php endif; ?>
              <?php comments_popup_link('', '1 Kommentar', '% Kommentarer'); ?>
            </span>
            <?php truncate(get_the_excerpt(), 350); ?> <a href="<?php the_permalink() ?>" class="more">Læs&nbsp;indlæg</a>
          </div>

        <?php endwhile; else:
        echo('Desværre er der ingen nyheder fra Centeret');
        endif;
        wp_reset_query();
        ?>

        <a href="/kategori/nyheder/" class="readMore">Læs flere nyheder fra centeret</a>

      </div>
      <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcfdp.dk&amp;width=310&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=112787928922252" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:310px; height:258px;" allowTransparency="true"></iframe>
    </div><!-- .right -->
  </div>
</div>




<?php get_footer(); ?>