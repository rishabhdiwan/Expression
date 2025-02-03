<?php get_header(); ?>
<div class="container">
    <main class="author-page">
        <?php
        // Get author data
        $author = get_queried_object();
        ?>
        
        <section class="author-info">
            <h1>Posts by <?php echo esc_html($author->display_name); ?></h1>
            <p><?php echo esc_html(get_the_author_meta('description', $author->ID)); ?></p>
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
            <?php if ($query->have_posts()) : ?>
                <div class="cards">
                    <?php while ($query->have_posts()) : ?>
                        <div class="card">
                            <?php $query->the_post(); ?>
                            <article class="post">
                                <a href="<?php echo get_post_permalink(); ?>"><img src = "<?php echo get_the_post_thumbnail_url(); ?>" class = "post-img"></a>
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
                            </article>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <?php echo "<p>No posts by this author yet.</p>"; ?>
            <?php endif; ?>
        </section>
    </main>
</div>
<?php get_footer(); ?>
