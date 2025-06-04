<?php
/* Template Name: Single Post */
get_header();

// Get post data
$post_id = get_the_ID();
$title = get_the_title();
$description = get_field("description");

get_template_part('components/shared-top', null, [
    'custom_title' => 'Blockchain News',
    'custom_description' => 'Aktuelle Nachrichten und Insights aus der Berliner Blockchain-Szene.'
]);
?>

<div class="single-event wrap">
    <article>
        <div class="event-meta">
            <div class="post-date">
                <?php echo get_the_date('j. F Y'); ?>
            </div>
        </div>
        
        <div class="event-content-float">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('large', ['class' => 'float-thumb']);
            } else {
                echo '<img src="' . get_stylesheet_directory_uri() . '/img/def.jpg" class="float-thumb" alt="' . esc_attr(get_the_title()) . '" />';
            }
            ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
        
        
        <?php
        // Get post tags
        $tags = get_the_tags();
        if ($tags) :
        ?>
            <div class="post-tags">
                <?php foreach ($tags as $tag) : ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                        <?php echo esc_html($tag->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
    
    <section class="related-events">
        <h2>More News</h2>
        <div class="related-grid">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
            );
            $related_posts = new WP_Query($args);
            
            if ($related_posts->have_posts()) :
                while ($related_posts->have_posts()) : $related_posts->the_post();
            ?>
                <div class="related-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="<?php the_title(); ?>" />
                        <?php endif; ?>
                        <div class="info">
                            <h3><?php the_title(); ?></h3>
                            <div class="date"><?php echo get_the_date('j. F Y'); ?></div>
                        </div>
                    </a>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>
</div>

<?php get_footer(); ?>

