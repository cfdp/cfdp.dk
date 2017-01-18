<?php get_header(); ?>

  <?php
  // Needed for pagination on custome post type
  if ( get_query_var('paged') ) {
      $paged = get_query_var('paged');
  } elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
      $paged = get_query_var('page');
  } else {
      $paged = 1;
  } ?>


  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php
    // fetch custom fields
    $meta_titel = get_post_meta( get_the_ID(), 'titel', true );
    $meta_phone = get_post_meta( get_the_ID(), 'phone', true );
    $meta_desc = get_post_meta( get_the_ID(), 'description', true );
    $meta_desc_html = apply_filters('meta_content', $meta_desc);
    $meta_mail = get_post_meta( get_the_ID(), 'mail', true );
    $meta_linkedin = get_post_meta( get_the_ID(), 'linkedin', true );
    $meta_user = get_post_meta( get_the_ID(), 'user', true );
    $meta_type = get_post_meta( get_the_ID(), 'type', true );
  ?>

  <div class="content grid_12 clearfix">
    <header>
      <?php
        if(has_post_thumbnail()) {
        echo '<div class="profile-image">';
        the_post_thumbnail('medium_large');
        echo '</div>';
        } else {
          echo '<img src="http://thecatapi.com/api/images/get?format=src&type=jpg">';
        }
      ?>
      <h1 class="name"><?php the_title(); ?></h1>
      <?php
        if ( !empty( $meta_titel ) ) { echo '<span class="title">' . $meta_titel . '</span>'; }
      ?>
      <div class="person__info">
        <?php
          if ( !empty( $meta_phone ) ) { echo '<div class="item"><span class="heading">Telefon</span><span class="item__content"><a href="tel:' . $meta_phone . '">' . $meta_phone . '</a></span></div>'; }
          if ( !empty( $meta_mail ) ) { echo '<div class="item"><span class="heading">Email</span><span class="item__content"><a href="mailto:' . $meta_mail . '">' . $meta_mail . '</a></span></div>'; }
          if ( !empty( $meta_linkedin ) ) { echo '<div class="item"><span class="heading">Linkedin</span><span class="item__content"><a href="http://' . $meta_linkedin . '">Se profil</a></span></div>'; }
          // if ( !empty( $meta_type ) ) { echo '<div class="item"><span class="heading">Rolle</span><span class="item__content">' . $meta_type . '</span></div>'; }
        ?>
      </div>
      <?php
        if ( !empty( $meta_desc ) ) { echo '<div class="person__desc">' . $meta_desc_html . '</div>'; }
      ?>
    </header>
    <div id="blogposts"></div>
        <?php
        $query = new WP_Query(
          array(
            'post_type'=>'post',
            'post_status'=>'publish',
            'author'=>$meta_user,
            'posts_per_page'=>5,
            'paged'  => $paged
          )
        );

        $max_pages = $query->max_num_pages;
        $current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        ?>
            <?php if ( $query->have_posts() ) : ?>
              <div class="divider"></div>
              <section class="blog-posts">
              <?php if($current_page == 0){
              echo '<h2 class="clearfix">Seneste indlæg</h2>';
              } else {
                echo '<h2 class="clearfix">Indlæg af ' . get_the_title() . ' (side ' . $current_page . ' af ' . $max_pages . ')</h2>';
              }
              ?>

                <div class="clearfix">
                  <!-- the loop -->
                  <?php while ( $query->have_posts() ) : $query->the_post(); ?>

              <div class="post">
                <?php if(has_post_thumbnail()) { ?>
                <a class="image" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('large'); ?>
                </a>
                <?php } ?>
                <a href="<?php the_permalink(); ?>">
                  <h3><?php the_title(); ?></h3>
                </a>
                <span class="postInfo">
                  <?php echo get_the_author(); ?>  skrev for
                  <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' siden'; ?>
                </span>
                  <p class="text">
                    <?php truncate( get_the_excerpt(), 350); ?> <a href="<?php the_permalink() ?>" class="more">Læs&nbsp;indlæg</a>
                  </p>
              </div>
              <?php endwhile; ?>
              <?php

                // Set to 0 of first page
                if ($current_page !== null && !is_numeric($current_page)) {
                  $current_page = 1;
                }

                //Remove pagination number from url if not first page
                if($current_page !== 1){
                  $url_without_pagination = dirname(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) . '/';
                  ?>

                  <script>
                    // Scroll to posts if not first
                    jQuery(document).ready(function($) {
                      // Handler for .ready() called.
                      $('html, body').animate({
                        scrollTop: $('#blogposts').offset().top
                      }, 900);
                    });
                  </script>
                <?php
                } else {
                  $url_without_pagination = $_SERVER['REQUEST_URI'];
                }

              ?>

              <div class="pagination--custom">

                <?php
                  if($current_page > 1){
                    echo '<a class="blue_button" href="' . $url_without_pagination . ($current_page-1) . '"><span class="meta-nav">&larr;</span> Nyere indlæg</a>';
                  }

                  if($current_page < $max_pages){
                    echo '<a class="blue_button" href="' . $url_without_pagination . ($current_page+1) . '">Tidligere indlæg <span class="meta-nav">&rarr;</span></a>';
                  }
                ?>
              </div>


              <?php wp_reset_postdata(); ?>

              <?php else : ?>
                <p><?php _e( 'Desværre, ingen indlæg fundet' ); ?></p>
              <?php endif; ?>

            </div>
          </div> <!-- Blogindlæg END -->
        </section>
      <?php endwhile; endif; ?>



  </div>



<?php get_footer(); ?>