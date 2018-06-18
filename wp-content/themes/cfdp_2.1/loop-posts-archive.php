<div class="tag-filter">
    <?php
    $taxonomy = 'category';
    $terms = get_terms($taxonomy); // Get all terms of a taxonomy
    echo "<select onChange=\"document.location.href=this.options[this.selectedIndex].value;\">";
    echo "<option>Vælg kategori</option>\n";
    foreach ($terms as $term)
    {
      echo "<option value=\"";
      echo get_term_link($term->slug, $taxonomy);
      echo "\">".$term->name."</option>\n";
    }
          echo "</select>"; ?>
</div>

<div class="loop-content">
    <?php
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    ?>
    <?php include (TEMPLATEPATH . '/inc/post.php' ); ?>
    <?php endwhile; else:
    echo('Desværre, ingen indlæg fundet');
    endif;
    ?>
</div>
    
<div class="paging"><?php wp_pagenavi(); ?></div>