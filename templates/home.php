<?php
/*
Template Name: home
*/
get_header();
?>
<!--Main Content-->
<?php
// Variables
$banner_fields = get_field('banner_fields');
$banner_url = $banner_fields['banner'];
?>
<div class="banner-wrapper">
    <!-- <div class="overlay"></div> -->
    <img src="<?php echo $banner_url; ?>" alt="banner" class = "banner">
    <div class = "banner-content">
        <h1>Expression welcomes you!</h1>
        <p>Share your thoughts and feelings with the World.</p>
        <!--Login/Register Buttons-->
        <?php if (!is_user_logged_in()) : ?>
            <button id = "writeBlogButton">Write a Blog?</button>
        <?php endif; ?>
    </div>
</div>
<!--Posts-->
<div class="container">
    <?php
        $args = array(
            'post_type' => 'blogging-expression',
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
    ?>
    <?php if ($query->have_posts()) : ?>
        <div class="cards">
            <?php while($query->have_posts()) : ?>
                <div class="card">
                    <?php $query->the_post(); ?>
                        <img src = "<?php echo get_the_post_thumbnail_url(); ?>" class = "post-img">
                        <div><strong><?php echo "By " . get_the_author(); ?></strong></div>
                        <strong><span><?php echo get_the_date(); ?></span><span><?php echo " " . get_the_time('g:i A'); ?></span></strong>
                        <h3><?php echo get_the_title(); ?></h3>
                        <?php
                            $content_of_the_post = get_the_content();
                            $content_new = explode(' ', $content_of_the_post);
                            $content_trimmed_version = implode(' ', array_slice($content_new, 0, 50));
                        ?>
                        <a href = "<?php echo get_post_permalink(); ?>"><?php echo $content_trimmed_version; ?>... Read More</a>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>
<?php
get_footer();
?>