<?php
/*
Plugin Name: CfDP Google Analytics Plugin
Plugin URI: http://cfdp.dk
Description: Adds CfDPs Google analytics trascking code to the <head> of your theme, by hooking to wp_head.
Author: Michael Lajlev
Version: 1.0
 */

function wpmudev_google_analytics() { ?>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-2898416-2', 'auto');
    ga('send', 'pageview');

  </script>
<?php }
add_action( 'wp_head', 'cfdp_google_analytics', 10 );
?>


