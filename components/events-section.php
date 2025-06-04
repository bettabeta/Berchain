<div class="events-grid-wrap">
    <div class="wrap">
        <div class="title-wrap">
            <div class="eventtitle">
                <h2>Upcoming Events</h2>
            </div>
        </div>

        <style>
            .events-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
                margin-bottom: 2rem;
            }
            .event-post {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
                overflow: hidden;
                flex: 1 1 calc(33.333% - 16px);
                max-width: calc(33.333% - 16px);
                display: flex;
                flex-direction: column;
            }
            .event-post img {
                width: 100%;
                height: 230px;
                object-fit: cover;
            }
            .event-post .info {
                padding: 1rem;
            }
            .event-post .info h3 {
                margin: 0 0 0.5rem;
                font-size: 1.1rem;
            }
            .event-post .info .time,
            .event-post .info .loc-link {
                font-size: 0.9rem;
                color: #555;
            }
            @media (max-width: 768px) {
                .event-post {
                    flex: 1 1 100%;
                    max-width: 100%;
                }
            }
        </style>

        <?php
        $upcoming = new WP_Query(array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'posts_per_page' => 20,
            'meta_key' => 'event_start',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_start',
                    'value' => current_time('Y-m-d H:i:s'),
                    'compare' => '>=',
                    'type' => 'DATETIME'
                )
            )
        ));
        ?>

        <?php if ($upcoming->have_posts()) : ?>
            <div class="events-grid">
                <?php while ($upcoming->have_posts()) : $upcoming->the_post(); ?>
                    <div class="event-post">
                        <a class="thumb" href="<?php the_permalink(); ?>" style="text-decoration:none;">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('medium');
                            } else { ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="">
                            <?php } ?>
                        </a>
                        <div class="info">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="time">
                                <?php
                                echo "Start: " . date_i18n("j F Y H:i", strtotime(get_field('event_start'))) . "<br />";
                                echo "Ende: " . date_i18n("j F Y H:i", strtotime(get_field('event_end')));
                                ?>
                            </div>
                            <?php if ($location = get_field('event_location')): ?>
                                <div class="loc-link">📍 <?php echo esc_html($location); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p>No upcoming events found.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <div class="btn-wrap flex">
            <a class="btn"
               href="https://calendar.google.com/calendar/embed?src=c_31318030e0ac5bfa5b4585f891cb6c55a5004e3cb0b458f9be351ffbcef65943%40group.calendar.google.com"
               data-fancybox data-type="iframe">
                See the full calendar
            </a>
        </div>
    </div>
</div>
