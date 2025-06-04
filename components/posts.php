<?php $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID()),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) : ?>
        <div class="recent-post-box">
            <div class="wrap">
                <h2 class="recent-post-box-title">More from BerChain</h2>
                <div class="recent-posts">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="post-news">
                            <a href="<?php the_permalink(); ?>" class="thumb">
                                <time class="time-block"><span class="day"><?php echo get_the_date('j'); ?></span><span
                                            class="month"><?php echo get_the_date('F'); ?></span></time>
                                <?php echo has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'large') : '<img src="' . get_template_directory_uri() . '/img/holder.png" alt="Holder Image">' ?>
                            </a>

                            <div class="info">
                                <span class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                                <p><?php echo wp_trim_words(strip_shortcodes(get_the_content()), 20, " "); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
<?php endif; ?>