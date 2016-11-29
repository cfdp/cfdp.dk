<?php get_header(); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php
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
        <?php
            $query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish','author'=>$meta_user, 'posts_per_page'=>5, 'paged'  => $paged)); ?>

            <?php if ( $query->have_posts() ) : ?>
              <div class="divider"></div>
              <section class="blog-posts">

              <h2 class="clearfix">Seneste indlæg</h2>
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

              <?php wp_reset_postdata(); ?>

              <?php else : ?>
                <p><?php _e( 'Desværre, ingen person fundet' ); ?></p>
              <?php endif; ?>

            </div>
          </div> <!-- Blogindlæg END -->
        </section>
      <?php endwhile; endif; ?>



  </div>



<?php get_footer(); ?>