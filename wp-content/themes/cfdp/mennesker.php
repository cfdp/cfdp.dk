<?php
/*
Template Name: Mennesker
*/
?>
<?php get_header(); ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('#nav4 div.tab').addClass('tabOpen');
	    lastBlock = $("#nav4 div.tabOpen");
	});
</script>

	<div class="team content grid_12 clearfix zi1">
		<a href="#" name="team" class="anchor"></a>
		<h1 class="description">Hvem er vi?</h1>
		<p class="intro grid_8 alpha clearfix">
			Centerets ansatte er en palet af unikke personligheder. Vi oplever styrken i vores forskelligheder, når alle byder ind med deres særlige viden, erfaringer, vinkler og nye input. Vores daglige arbejde er præget af den fantastiske energi, der opstår, når mange forskellige fagligheder og livserfaringer mødes.
		</p>

		<div class="row grid_12 alpha">

<?php
global $wpdb;

// http://vuong.fr/myitblog/2010/08/displaying-wp-user-list-including-data-from-cimy-user-extra-fields/

/* Now we build the custom query to get the ID of the users. */

$aUsersID = $wpdb->get_col( $wpdb->prepare("SELECT $wpdb->users.ID FROM $wpdb->users ORDER BY user_nicename ASC", $id, $name ));
/* Once we have the IDs we loop through them with a Foreach statement. */
$count = 0;
foreach ( $aUsersID as $iUserID ) :
$user = get_userdata( $iUserID );

$dont_show_these = array(8, 9, 14, 15, 16, 17, 19, 20, 22, 27, 28);

if( !in_array($user->ID, $dont_show_these) ) {

$count++;
if ($count == 1 || $count == 4 || $count == 7 || $count == 10) { $countclass = 'alpha';}
elseif ($count == 3 || $count == 6 || $count == 9 || $count == 12) { $countclass = 'omega';}
else { $countclass = '';}
?>

<div class="profile grid_4 <?php echo $countclass; ?>">
<?php
// This fetch image from cimyFields
$value = get_cimyFieldValue($user->ID, 'IMGM');
if(strcmp($value, '')) {
	echo '<img src="' . cimy_uef_sanitize_content($value) .'">';
}
else {echo '';}

echo '<h2>' . ucwords( strtolower( $user->first_name . ' ' . $user->last_name ) ) . '</h2>';
echo '<a href="mailto:' . strtolower( $user->user_email ) . '">' .  strtolower( $user->user_email )  . '</a>';
echo '<p>' .  $user->description  . '</p>';?>



<?php /* authorPermalink() does not render the link to praktikant user correctly, manually overriding */
if ( $user->ID == 26 ): ?> 
	<a href="<?php bloginfo('url');?>/author/praktikanter-projektsansatte-og-frivillige/">Se Profil</a> 
<?php else : ?>
	<a href="<?php bloginfo('url');?>/author/<?php authorPermalink($user->display_name);?>/">Se Profil</a> 
<?php endif; ?>

</div>

<?php
}
endforeach; // end the users loop.
?>

		</div>
	</div>


<?php get_footer(); ?>
