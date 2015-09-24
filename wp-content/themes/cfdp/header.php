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

	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1024px)"
	href="<?php bloginfo('stylesheet_directory'); ?>/css/fixed-grid.css" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />

	<link rel="stylesheet" type="text/css" media="screen and (max-width: 1023px)"
	href="<?php bloginfo('stylesheet_directory'); ?>/css/mobile.css" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/general.js"></script>


</head>

<body <?php body_class(); ?>>

<div class="container wrap clearfix">
<a name="top"></a>
<div class="topSpacer grid_12 clearfix"></div>
<!-- Header -->

<div class="logo grid_7"><h1><a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="" /></a></h1></div>

<!-- Mobile Menu -->
<!-- Mobile Menu -->
<div class="mobile-menu-wrapper">
  <select id="mobile-menu">
    <option value="" selected disabled>Menu</option>

    <optgroup label="Oplæg">
      <option value="/oplaeg/#1-faglige">Faglige oplæg</option>
      <option value="/oplaeg/#2-elev">Elevoplæg</option>
      <option value="/oplaeg/#3-foraelder">Forælderoplæg</option>
      <option value="/oplaeg/#4-laeringsmaterialer">Læringsmaterialer</option>
    </optgroup>

    <optgroup label="Produkter">
      <option value="/erfarninger/#1-produkter">Produkter</option>
      <option value="<?php echo get_permalink(1204); ?>">Vidensarkiv</option>
      <option value="<?php echo get_permalink(1638); ?>">Publikationer</option>
      <option value="<?php echo get_permalink(7204); ?>">Digital Trivsel</option>
    </optgroup>

    <optgroup label="Projekter">
      <option value="/projekter/#1-igangvaerende-projekter">Igangværende</option>
      <option value="/projekter/#2-kommende-projekter">Kommende</option>
      <option value="/erfarninger/#2-projekter">Afsluttede</option>
      <option value="<?php echo get_permalink(248); ?>">Bliv Partner</option>
    </optgroup>

    <optgroup label="Mennesker">
      <option value="/mennesker/#team">Hvem er vi?</option>
      <option value="<?php echo get_permalink(517); ?>">Bestyrelsen</option>
      <option value="<?php echo get_permalink(590); ?>">Partnere</option>
      <option value="<?php echo get_permalink(596); ?>">Vil du være med?</option>
    </optgroup>

    <optgroup label="Andet">
      <option value="/search">Søg på cfdp.dk</option>
      <option value="/bliv-medlem">Bliv medlem</option>
      <option value="/om-center-for-digital-paedagogik">Om os</option>
      <option value="/presse">Presse</option>
      <option value="/in-english">English</option>
    </optgroup>

  </select>
</div>



<!-- Top Navigation -->
<div class="topNav grid_5">
	<ul>
		<li><a href="<?php bloginfo('url'); ?>/mennesker/join">Bliv frivillig</a></li>
		<li><a href="<?php bloginfo('url'); ?>/om-center-for-digital-paedagogik">Om os</a></li>
		<li><a href="<?php bloginfo('url'); ?>/presse">Presse</a></li>
		<li><a onclick="return SnapABug.startLink();" href="#">Kontakt</a></li>
		<li><a href="<?php bloginfo('url'); ?>/in-english">English</a></li>
	</ul>
</div>
<!-- search -->
<div class="searchbar grid_5 clearfix">
	<?php include (TEMPLATEPATH . '/searchform.php' ); ?>
</div>
<!-- Navigation -->
<noscript><h2 class="noscript grid_12 clearfix">Javascript er nødvendigt for at gå på opdagelse på cfdp.dk</h2></noscript>
<div class="nav grid_12">
	<ul id="accordion">
		<li id="nav1">
			<!-- Produkter -->
			<div class="tab">
				<span></span>
				<div class="navContent">
					<div class="lineShadow"></div>
					<ul>
						<li><a href="<?php bloginfo('url'); ?>/oplaeg/#1-faglige">Faglige oplæg</a></li>
						<li><a href="<?php bloginfo('url'); ?>/oplaeg/#2-elev">Elevoplæg</a></li>
						<li><a href="<?php bloginfo('url'); ?>/oplaeg/#3-foraelder">Forælderoplæg</a></li>
						<li><a href="<?php bloginfo('url'); ?>/oplaeg/#4-laeringsmaterialer">Læringsmaterialer</a></li>
					</ul>
					<ul class="c2">
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>
				</div>
			</div>
		</li>
		<li id="nav2">
			<!-- Erfaringer -->
			<div class="tab">
				<span></span>
				<div class="navContent">
					<div class="lineShadow"></div>
					<ul>
						<li><a href="<?php bloginfo('url'); ?>/erfarninger/#1-produkter">Produkter</a></li>
						<li><a href="<?php echo get_permalink(1204); ?>">Vidensarkiv</a></li>
						<li><a href="<?php echo get_permalink(1638); ?>">Publikationer</a></li>
						<li><a href="<?php echo get_permalink(7204); ?>">Digital Trivsel</a></li>
					</ul>
					<ul class="c2">
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>
				</div>
			</div>
		</li>
		<li id="nav3">
			<!-- Projekter -->
			<div class="tab">
				<span></span>
				<div class="navContent">
					<div class="lineShadow"></div>
					<ul>
						<li><a href="<?php bloginfo('url'); ?>/projekter/#1-igangvaerende-projekter">Igangværende</a></li>
						<li><a href="<?php bloginfo('url'); ?>/projekter/#2-kommende-projekter">Kommende</a></li>
						<li><a href="<?php bloginfo('url'); ?>/erfarninger/#2-projekter">Afsluttede</a></li>
						<li><a href="<?php echo get_permalink(248); ?>">Bliv Partner</a></li>
						<li>&nbsp;</li>
					</ul>
					<ul class="c2">
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>
				</div>
			</div>
		</li>
		<li id="nav4">
			<!-- Mennesker -->
			<div class="tab">
				<span></span>
				<div class="navContent">
					<div class="lineShadow"></div>
					<ul>
						<li><a href="<?php bloginfo('url'); ?>/mennesker/#team">Hvem er vi?</a></li>
						<li><a href="<?php echo get_permalink(517); ?>">Bestyrelsen</a></li>
						<li><a href="<?php echo get_permalink(590); ?>">Partnere</a></li>
						<li><a href="<?php echo get_permalink(596); ?>">Vil du være med?</a></li>
					</ul>
					<ul class="c2">
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>
				</div>
			</div>
		</li>
	</ul>
</div>
