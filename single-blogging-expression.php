<?php
get_header();
?>
<?php
if (have_posts()) {
    while(have_posts()) {
        the_post();
        ?>
        <div class="container">
            <!--Post-->
            <article>
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="image-of-post">
                <?php echo get_the_date('F j, Y'); ?>
                <?php echo get_the_time('g:i A'); ?>
                <?php echo get_the_author(); ?>
                <h2><?php echo get_the_title(); ?></h2>
                <p><?php echo get_the_content(); ?></p>
            </article>
            <!--Comments-->
            <?php
                // Check if comments are enabled and there are comments
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            ?>
        </div>
        <?php
    }
}
?>
<?php
get_footer();
?>