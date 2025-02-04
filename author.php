<?php get_header(); ?>
<!-- Banner -->
<div class="banner-wrapper">
    <img src="/wp-content/themes/expression/assets/images/banner.jpg" alt="banner" class = "author-banner">
    <div class = "banner-content">
        <h2 class = "author-name">
            <?php
            // Get author data
            $author = get_queried_object();
            echo esc_html($author->display_name);
            ?>
        </h2>
    </div>
</div>
<!-- Main Content -->
<div class="container">
    <div class="author-basic-details">
        <div class="image-of-author">
            <?php 
                $author_bio = get_the_author_meta('description', $author->ID);
                $author_image = get_field('author_image');
                if (!empty($author_image) && !empty($author_bio)) :
            ?>
            <img src="<?php echo $author_image; ?>" alt="author-img">
        </div>
        <div class="bio">
            <h3><?php echo esc_html($author->display_name); ?></h3>
            <p><?php echo esc_html($author_bio); ?></p>
        </div>
        <?php endif; ?>
    </div>
    <main class="author-page">        
        <section class="author-info">
            <h2>Articles Posted by <?php echo esc_html($author->display_name); ?></h2>
        </section>    
        <section class="author-posts">
            <?php
            $args = array(
                'author' => $author->ID,
                'post_type' => 'blogging-expression',
                'posts_per_page' => 10,
            );
            $query = new WP_Query($args);
            ?>
            <?php if ($query->have_posts()) :
                include 'templates/components/blog-cards.php';
                else : ?>
                    <?php echo "<p>No posts by this author yet.</p>"; ?>
            <?php endif; ?>
        </section>
    </main>
</div>
<?php get_footer(); ?>
