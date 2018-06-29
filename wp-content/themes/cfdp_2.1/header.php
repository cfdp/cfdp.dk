<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" />
	<?php } ?>
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" type="image/x-icon" />
	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Over følgende tags &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Oversigt - '; }
		      elseif (is_search()) {
		         echo 'Søg efter &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Ikke fundet - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	<link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i|Montserrat:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1024px)" href="<?php bloginfo('template_url'); ?>/css/fixed-grid.css" />
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1024px)" href="<?php bloginfo('template_url'); ?>/css/desktop.css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 1023px)" href="<?php bloginfo('template_url'); ?>/css/mobile.css" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.sidr.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/js.cookie.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/general.js"></script>
</head>
<body <?php body_class(); ?>>
<!-- Facebook like in footer -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/da_DK/sdk.js#xfbml=1&version=v2.7&appId=159894837393";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    
    
    <div class="menu-overlay clearfix">
        <span class="close-menu">
            <svg width="200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 23" class="close-menu-btn">
            <path class="cross" d="M14.1,11.5l8.6-8.6c0.5-0.5,0.5-1.4-0.1-2c-0.6-0.6-1.5-0.6-2-0.1L12,9.4L3.4,0.8C2.9,0.3,2,0.3,1.4,0.9c-0.6,0.6-0.6,1.5-0.1,2l8.6,8.6l-8.6,8.6c-0.5,0.5-0.5,1.4,0.1,2c0.6,0.6,1.5,0.6,2,0.1l8.6-8.6l8.6,8.6c0.5,0.5,1.4,0.5,2-0.1c0.6-0.6,0.6-1.5,0.1-2L14.1,11.5z"/>
            </svg>
        </span>
        <?php wp_nav_menu(array(
            'menu' => 'main', 
            'container_id' => 'cssmenu', 
            'walker' => new CSS_Menu_Walker()
        )); ?>
        <div class="second-menu mobile">
            <?php wp_nav_menu(array(
                'menu' => 'sekundær menu', 
                'container_id' => 'secondary-menu', 
                'walker' => new CSS_Menu_Walker()
            )); ?>
        </div>
    </div>
    
    
    <div id="search-form" class="search-form"><?php include (TEMPLATEPATH . '/searchform.php' ); ?></div>    
    <div class="header clearfix">
        <!-- <a id="toggle-menu-button" href="#toggle-menu-button">&#9776;&nbsp; Menu</a> -->
		<div class="nav clearfix">
            <div class="left">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 23" class="burger">
                    <path class="line" d="M1.4,3h27.3C29.4,3,30,2.3,30,1.5S29.4,0,28.6,0H1.4C0.6,0,0,0.7,0,1.5S0.6,3,1.4,3z"/>
                    <path class="line" d="M28.6,10H1.4C0.6,10,0,10.7,0,11.5S0.6,13,1.4,13h27.3c0.8,0,1.4-0.7,1.4-1.5S29.4,10,28.6,10z"/>
                    <path class="line" d="M28.6,20H1.4C0.6,20,0,20.7,0,21.5S0.6,23,1.4,23h27.3c0.8,0,1.4-0.7,1.4-1.5S29.4,20,28.6,20z"/>
                </svg>

                <div class="logo">
                    <a href="<?php bloginfo('url'); ?>">
                        <img src="<?php bloginfo('template_url'); ?>/img/logo.svg" width="120" alt="Logo CfDP">
                    </a>
                </div>
            </div> 
            <div class="right">
                <div class="second-menu desktop">
                    <?php wp_nav_menu(array(
                        'menu' => 'sekundær menu', 
                        'container_id' => 'secondary-menu', 
                        'walker' => new CSS_Menu_Walker()
                    )); ?>
                </div>
                <div class="search-icon active">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path class="search-svg" d="M18,16.1l7,7L23.1,25l-7-7A9.9,9.9,0,0,1,10,20,10,10,0,1,1,20,10,9.9,9.9,0,0,1,18,16.1Zm-8,1.3A7.4,7.4,0,1,0,2.7,10,7.4,7.4,0,0,0,10,17.4Z"/></svg>       
                </div>
            </div>    
		</div>
		
	</div>
    
    
    
    
    
    
    
    <!-- Header image logic -->   
    
    

    
    
    <?php if ( is_front_page() ) { ?>
        <section id="big-video">
            <div class="video-overlay">
                <?php the_field('banner_content'); ?>
                <a class="blue_button" href="<?php the_field('cta_btn'); ?>"><?php the_field('link_txt'); ?></a>
            </div>
            <video playsinline autoplay loop muted poster="<?php the_field('start_img') ?>" class="video">
                <source src="<?php the_field('banner_video'); ?>" type="video/mp4">
            </video>
        </section>
    <?php } ?>
    
     <?php if(has_post_thumbnail() && !is_singular('person') && !is_search() || is_archive()) { ?>
        <section id="big-banner">
            <?php if ( is_page_template( 'page_post_archive.php' ) ) { ?>
            <div class="img-container" style="background-image: url('<?php bloginfo('template_url'); ?>/img/fallback.png');">
                <div class="img-overlay">
                <?php the_field('archive_banner_content') ?>
                <div class="tag-filter">
                    <?php
                    $taxonomy = 'category';
                    $terms = get_terms($taxonomy); // Get all terms of a taxonomy
                    echo "<svg class='select-arrow'></svg>";
                    echo "<select onChange=\"document.location.href=this.options[this.selectedIndex].value;\">";
                    echo "<option>Vælg kategori</option>\n";
                    echo "<option value='/alle-indlaeg'>Alle indlæg</option>\n";
                    foreach ($terms as $term)
                    {
                      echo "<option value=\"";
                      echo get_term_link($term->slug, $taxonomy);
                      echo "\">".$term->name."</option>\n";
                    }
                          echo "</select>"; ?>
                </div>
                    <p class="sub-titel"><?php the_title(); ?></p>
                </div>
            </div>

        <?php } elseif ( is_page_template( 'page_lectures.php' ) ) { ?>
            <div class="img-container" style="background-image: url('<?php bloginfo('template_url'); ?>/img/fallback.png');">
                <div class="img-overlay">
                <h1 class="name"><?php the_title(); ?></h1>
                <p><?php the_field('banner_intro'); ?></p>
                </div>
            </div>
            
        <?php } elseif ( is_archive() ) { ?>
            <div class="img-container" style="background-image: url('<?php bloginfo('template_url'); ?>/img/fallback.png');">
                <div class="img-overlay">
                <?php the_field('archive_banner_content', 1204); ?> 
                <div class="tag-filter">
                    <?php
                    $taxonomy = 'category';
                    $terms = get_terms($taxonomy); // Get all terms of a taxonomy
                    echo "<svg class='select-arrow'></svg>";                     
                    echo "<select onChange=\"document.location.href=this.options[this.selectedIndex].value;\">";                     
                    echo "<option>Vælg kategori</option>\n";
                    echo "<option value='/alle-indlaeg'>Alle indlæg</option>\n";
                    foreach ($terms as $term)
                    {
                      echo "<option value=\"";
                      echo get_term_link($term->slug, $taxonomy);
                      echo "\">".$term->name."</option>\n";
                    }
                          echo "</select>"; ?>
                </div>
                    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

			<?php /* If this is a category archive */ if (is_category()) { ?>
			<p class="sub-titel"><?php single_cat_title(); ?></p>	

			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
                <p class="sub-titel"><?php single_cat_title(); ?></p>

			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                <p class="sub-titel"><?php the_time('j. F Y'); ?></p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<p class="sub-titel"><?php the_time('F, Y'); ?></p>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<p class="sub-titel"><?php the_time('Y'); ?></p>

			<?php /* If this is an author archive */ } elseif (is_author()) { ?>	
                <p class="sub-titel">Fofatter Arkiv</p>

			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<p class="sub-titel">Arkiv</p>

			<?php } ?>
                </div>
            </div>

        <?php } else { ?>
            <div class="img-container" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
            </div>

        <?php } ?>
        </section>
    
    
    <?php } ?>
    
    
<div class="container wrap clearfix" id="content-view">