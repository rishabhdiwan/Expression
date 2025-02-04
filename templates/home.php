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
        <h6>Share your thoughts and feelings with the World.</h6>
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
    <?php if ($query->have_posts()) :
        include 'components/blog-cards.php';
    endif; ?>
<?php
get_footer();
?>