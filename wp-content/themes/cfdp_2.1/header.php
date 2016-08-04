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


	<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1024px)" href="<?php bloginfo('stylesheet_directory'); ?>/css/fixed-grid.css" />

	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1024px)" href="<?php bloginfo('stylesheet_directory'); ?>/css/desktop.css" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />

	<link rel="stylesheet" type="text/css" media="screen and (max-width: 1023px)" href="<?php bloginfo('stylesheet_directory'); ?>/css/mobile.css" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.sidr.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/general.js"></script>



</head>

<body <?php body_class(); ?>>


<div class="container wrap clearfix" id="content-view">
	<div class="header">
		<a name="top"></a>

		<div class="logo grid_3">
		  <a href="<?php bloginfo('url'); ?>">
		    <img src="<?php bloginfo('template_url'); ?>/img/logo@2x.png" width="215" alt="Logo CfDP" />
		  </a>
		</div>
    <a id="toggle-menu-button" href="#toggle-menu-button">&#9776;&nbsp; Menu</a>

		<div class="nav grid_9 clearfix">
		  <div class="searchbar">
		    <?php include (TEMPLATEPATH . '/searchform.php' ); ?>
		  </div>
		  <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_class' => 'header__menu', 'depth' => '1'  ) ); ?>

		</div>
		<div class="sub-menu-wrap grid_12" id="mobile-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'sub-header-menu', 'container_class' => 'header__sub-menu', 'container_id' => 'mobile-menu-view', 'depth' => '2' ) ); ?>
		</div>
	</div>