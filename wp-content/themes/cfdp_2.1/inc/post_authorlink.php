<?php
  $author_id = get_the_author_meta('id');
  $person_name = get_cimyFieldValue($author_id, 'personurl');

  if ($person_name) {
    $custom_author_link = '<a href="/person/' . $person_name . '">' . get_the_author() . '</a>';
  } else {
    $custom_author_link = '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author() . '</a>';
  }
?>