  </div>
</div> <!-- .container.wrap.clearfix -->

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Newsletter signup") ) : ?>
<?php endif;?>

<div class="footer-wrapper clearfix">
    <div class="wrap">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
        <?php endif;?>
    </div>
</div>
<div class="footer-logo-wrapper clearfix">
    <div class="wrap">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer-logo") ) : ?>
        <?php endif;?>
    </div>
</div>

<?php wp_footer(); ?>
</body>

</html>