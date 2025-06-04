<?php
/**
 * Template Name: News Template
 * Template Post Type: page
 */
get_header();
?>

<div class="news-list wrap">
    <div class="wrap1720">
        <h2>Latest News</h2>
        
        <div class="news-grid">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 9,
                'paged' => $paged
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $date = get_the_date('d M Y');
                    $date_parts = explode(' ', $date);
            ?>
                    <div class="news-post">
                        <a href="<?php the_permalink(); ?>">
                            <div class="news-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="news-content">
                                <h3><?php the_title(); ?></h3>
                                <div class="textline">📅 <?php echo get_the_date('j. F Y'); ?></div>
                                <div class="news-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No news found.</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<div class="pagination">
    <?php
    echo paginate_links(array(
        'total' => $query->max_num_pages,
        'current' => $paged,
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;'
    ));
    ?>
</div>

<?php get_footer(); ?> 