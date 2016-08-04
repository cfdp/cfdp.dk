
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
        <h2>Blog indlæg</h2>
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
      <h2>Tweets</h2>
      <span class="line"></span>
      <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/CFDPs" data-widget-id="453859743497322497" data-chrome="transparent noheader" data-tweet-limit="3">Tweets by @CFDPs</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div><!-- .right -->
  </div>
</div>




<?php get_footer(); ?>