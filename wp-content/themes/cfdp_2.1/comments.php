<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		Dette indlæg er beskyttet af et kodeord.
	<?php
		return;
	}
?>
<div class="comments">
<?php if ( have_comments() ) : ?>


	<h2><?php comments_number('Ingen kommentarer endnu', 'En kommentar', '% kommentarer' );?></h2>
	 <div class="lineContainer"><span class="line"></span></div>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<p></p>

	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond">

	<h2><?php comment_form_title( 'Skriv ny kommentar', 'Skriv kommentar til %s' ); ?></h2>
	<span class="line"></span>

	<div class="cancel-comment-reply">
		<?php cancel_comment_reply_link(); ?>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>Du skal være <a href="<?php echo wp_login_url( get_permalink() ); ?>">logget ind</a> for at skrive en kommentar.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

			<p>Du er logget ind som <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log ud af denne konto">Log ud &raquo;</a></p>

		<?php else : ?>

			<div>
				<input type="text" name="author" id="author" placeholder="👤 &nbsp;Navn" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			</div>

			<div>
				<input type="text" name="email" id="email" placeholder="✉️ &nbsp;E-mail" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
				<label for="email">Vi passer godt på din e-mail</label>
			</div>

		<?php endif; ?>

		<!--<p>You can use these tags: <code><?php echo allowed_tags(); ?></code></p>-->

		<div>
			<textarea name="comment" id="comment" cols="58" rows="10" tabindex="4" placeholder="✍ &nbsp;Skriv som du vil skrive til en ven :)"></textarea>
		</div>

		<div>
			<input name="submit" type="submit" class="blue_button" id="submit" tabindex="5" value="Send kommentar" />
			<?php comment_id_fields(); ?>
		</div>

		<?php do_action('comment_form', $post->ID); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>

</div>
</div>

<?php endif; ?>
