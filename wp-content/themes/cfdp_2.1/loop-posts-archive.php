<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<?php include (TEMPLATEPATH . '/inc/post.php' ); ?>
<?php endwhile; else:
echo('Desværre, ingen indlæg fundet');
endif;
?>
<div class="paging"><?php wp_pagenavi(); ?></div>