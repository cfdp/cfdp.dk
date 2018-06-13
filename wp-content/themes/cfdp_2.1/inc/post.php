<?php
  include (TEMPLATEPATH . '/inc/post_authorlink.php' );
  $meta_teaser = get_post_meta( get_the_ID(), 'teaser', true );
  if ( !empty( $meta_teaser ) ){
    $post_teaser = $meta_teaser;
  } else {
    $post_teaser = get_the_excerpt();
  }
?>

    <div class="post">
        <?php if(has_post_thumbnail()) { ?>
        <a class="image" href="<?php the_permalink(); ?>">
        <div class="post-image" style="background: url('<?php the_post_thumbnail_url(); ?>');background-position: 50% 50%;
            background-repeat: no-repeat;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;"></div>            
        </a>
        <?php } ?>
        <span class="post-tags">Kategorier:
            <?php 
                $taxonomy = 'category';

                // get the term IDs assigned to post.
                $post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
                // separator between links
                $separator = ' · ';
                $categories = get_the_category();
                $parentid = $categories[0]->category_parent;

                if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {

                    $term_ids = implode( ',' , $post_terms );
                    $terms = wp_list_categories( 'title_li=&style=none&echo=0&child_of=' . $parentid . '&taxonomy=' . $taxonomy . '&include=' . $term_ids );
                    $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

                    // display post categories
                    echo  $terms;
                }
            ?>
        </span>
        <a href="<?php the_permalink(); ?>">
            <h3>
                <?php the_title(); ?>
            </h3>
        </a>

        <p class="text">
            <?php truncate( $post_teaser, 180); ?>
        </p>
    </div>