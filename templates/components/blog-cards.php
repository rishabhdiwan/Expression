<div class="cards">
    <?php while($query->have_posts()) : ?>
        <div class="card">
            <?php $query->the_post(); ?>
                <a href="<?php echo get_post_permalink(); ?>"><img src = "<?php echo get_the_post_thumbnail_url(); ?>" class = "post-img"></a>
                <?php if ( !is_author() ) : ?>
                    <div class = "post-author-name"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                        <strong><?php echo "By " . get_the_author(); ?></strong>
                    </a></div>
                <?php endif; ?>
                <strong><?php echo get_the_date(); ?><?php echo " " . get_the_time('g:i A'); ?></strong>
                <a href="<?php echo get_post_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                <?php
                    $content_of_the_post = get_the_content();
                    $words_in_content_of_the_post =  str_word_count($content_of_the_post);
                    $content_new = explode(' ', $content_of_the_post);
                    $content_trimmed_version = implode(' ', array_slice($content_new, 0, 35));
                ?>
                <?php if ($words_in_content_of_the_post > 35) : ?>
                    <a href = "<?php echo get_post_permalink(); ?>"><span><?php echo $content_trimmed_version; ?></span><span class="read-more"> Continue Reading ></span></a>
                <?php else : ?>
                    <a href = "<?php echo get_post_permalink(); ?>"><?php echo $content_of_the_post ?></a>
                <?php endif; ?>                            
        </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
</div>