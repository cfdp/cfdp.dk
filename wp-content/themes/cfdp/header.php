<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

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

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	<link rel="stylesheet" type="text/css" media="print"
	href="<?php bloginfo('stylesheet_directory'); ?>/css/print.css" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/general.js"></script>


</head>

<body <?php body_class(); ?>>

<div class="container wrap clearfix">
<a name="top"></a>
<!-- Header -->
<div class="topSpacer grid_12 clearfix"></div>
<div class="logo grid_7"><h1><a href="<?php bloginfo('url'); ?>">Center for Digital Pædagogik</a></h1></div>
<!-- Top Navigation -->
<div class="topNav grid_5">
	<ul>
		<li><a href="<?php bloginfo('url'); ?>/bliv-medlem">Bliv medlem</a></li>
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