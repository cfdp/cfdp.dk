<?php get_header(); ?>
<?php
	if(isset($_GET['author_name'])) :
		    // NOTE: 2.0 bug requires: get_userdatabylogin(get_the_author_login());
		    // Is makes it possible to get userID by $curauth->ID
				$curauth = get_user_by('login', $author_name);
		    // $curauth = get_userdatabylogin($author_name);
		else :
		    $curauth = get_userdata(intval($author));
		endif;
?>
<div class="authorPage content grid_12 zi1 clearfix">

	<div class="grid_9 zi1 alpha">
		<h1><?php echo $curauth->display_name; ?></h1>
		<p class="about"><?php echo get_cimyFieldValue($curauth->ID, 'ABOUTWORK');  ?></p>
		<p class="about"><?php echo get_cimyFieldValue($curauth->ID, 'ABOUTPRIVATE');  ?></p>
		<div class="posts grid_6 alpha">
			<h2>Seneste indlæg (<?php echo $curauth->first_name; ?>)</h2>
				<span class="line"></span>
 <?php query_posts($query_string . '&cat=10&posts_per_page=5'); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
       		<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
			<div class="meta">
				Skrevet den <?php the_time('j. F Y') ?> af <?php the_author_posts_link(); ?><?php the_tags(' | Tags: ',', '); ?> <?php comments_popup_link('', '| 1 kommentar', '| % kommentarer', 'comments-link', ''); ?>
			</div>

			<div class="entry">
				<?php truncate(get_the_excerpt(), 350); ?> <a href="<?php the_permalink() ?>" class="more">Læs mere</a>

			</div>

    <?php endwhile; else: ?>
       		<p><?php _e('Ingen indlæg endnu'); ?></p>

    <?php endif; ?>
    		<div class="paging"><?php wp_pagenavi(); ?></div>

		</div>
		<div class="grid_3 omega">
			<div class="links">
				<h2>Sociale links</h2>
				<span class="line"></span>
				<?php //Email
					 if(get_the_author_meta('user_email', $curauth->ID)): ?>
					<a class="email" href='mailto:<?php the_author_meta('user_email', $curauth->ID); ?>'><span></span><?php the_author_meta('user_email', $curauth->ID); ?></a>
				<?php endif; ?>

				<?php //twittter
					 if(get_the_author_meta('twitter', $curauth->ID)): ?>
					<a class="twitter" href='http://twitter.com/<?php the_author_meta('twitter', $curauth->ID); ?>'><span></span>twitter profil</a>
				<?php endif; ?>

				<?php // facebook
					 if(get_the_author_meta('facebook', $curauth->ID)): ?>
					<a class="facebook" href='http://facebook.com/<?php the_author_meta('facebook', $curauth->ID); ?>'><span></span>facebook profil</a>
				<?php endif; ?>

				<?php //linkedin
					if(get_the_author_meta('linkedin', $curauth->ID)): ?>
					<a class="linkedin" href='http://linkedin.com/<?php the_author_meta('linkedin', $curauth->ID); ?>'><span></span>linkedin profil</a>
				<?php endif; ?>

				<?php //website
					 if(get_the_author_meta('user_url', $curauth->ID)): ?>
					<a class="website" href='<?php the_author_meta('user_url', $curauth->ID); ?>'><span></span>mit website</a>
				<?php endif; ?>

					<a class="rssfeed" href='<?php bloginfo('url') ?>/author/<?php authorPermalink(get_the_author());?>/feed/'><span></span>abonner på RSS-feed</a>

			</div>

		</div>


	</div>
	<div class="profileImg grid_3 omega clearfix">
		<img src="<?php echo get_cimyFieldValue($curauth->ID, 'IMGL');  ?>" alt="" />
	</div>
</div>












<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('#nav4 div.tab').addClass('tabOpen');
	    lastBlock = $("#nav4 div.tabOpen");
	});
</script>
<?php get_footer(); ?>