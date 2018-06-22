
<?php get_header(); ?>

<?php
// Get all custom fields attached to this post and store them in an array
$custom_fields = base_get_all_custom_fields();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
            
            <?php if( !empty($custom_fields['page_sidebar']) ) { ?>
            
                <div class="has-sidebar">
                    <h1 class="header grid_12 entry"><?php the_title(); ?></h1>
                    <div class="grid_8">
                        <div class="entry">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <div class="sidebar grid_4 clearfix">
                        <div class="entry">
                            <?php echo $custom_fields['page_sidebar']; ?>
                        </div>
                    </div>
                    <?php if( comments_open() ) { ?>
                    <div class="grid_8">
                        <div class="entry">
                            <?php comments_template(); ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            
            <?php } else { ?>
            
                <div class="grid_12 no-sidebar">
                    <div class="entry">
                        <h1 class="header"><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </div>
                    <?php if( comments_open() ) { ?>
                    <div class="entry">
                        <?php comments_template(); ?>
                    </div>
                    <?php } ?>
                </div>

            <?php } ?>
            
        </div>

<?php endwhile; endif; ?>

	

<?php get_footer(); ?>