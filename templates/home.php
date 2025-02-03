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
                        <a href="<?php echo get_post_permalink(); ?>"><img src = "<?php echo get_the_post_thumbnail_url(); ?>" class = "post-img"></a>
                        <div><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                            <strong><?php echo "By " . get_the_author(); ?></strong>
                        </a></div>
                        <strong><span><?php echo get_the_date(); ?></span><span><?php echo " " . get_the_time('g:i A'); ?></span></strong>
                        <a href="<?php echo get_post_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                        <?php
                            $content_of_the_post = get_the_content();
                            $words_in_content_of_the_post =  str_word_count($content_of_the_post);
                            $content_new = explode(' ', $content_of_the_post);
                            $content_trimmed_version = implode(' ', array_slice($content_new, 0, 50));
                        ?>
                        <?php if ($words_in_content_of_the_post > 60) : ?>
                            <a href = "<?php echo get_post_permalink(); ?>"><?php echo $content_trimmed_version; ?><span class="read-more">... Read More</span></a>
                        <?php else : ?>
                            <a href = "<?php echo get_post_permalink(); ?>"><?php echo $content_of_the_post ?></a>
                        <?php endif; ?>                            
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>
<?php
get_footer();
?>