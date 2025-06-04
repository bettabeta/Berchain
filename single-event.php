<?php
/* Template: Single Event */
get_header();

// Customizable Event Header
$header_image     = get_field('event_header_image'); // ACF field for header image
$booking_link     = get_field('event_booking_link'); // ACF field for booking link
$events_page_url  = get_post_type_archive_link('event'); // link back to events archive
$event_start      = get_field('event_start');
$event_end        = get_field('event_end');
$location         = get_field('event_location');
?>

<div class="single-event wrap">
    <nav><a href="<?php echo esc_url(home_url('/berlinevents/')); ?>">← Back to all events</a></nav>
    
    <?php while (have_posts()) : the_post(); 
        $event_start = get_field('event_start');
        $event_end = get_field('event_end');
        $location = get_field('location');
        $booking_link = get_field('booking_link');
    ?>
    
    <h1><?php the_title(); ?></h1>
    
    <div class="event-grid">
        <div class="event-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
            <?php else : ?>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="<?php the_title(); ?>" />
            <?php endif; ?>
        </div>
        
        <div class="event-description">
            <?php the_content(); ?>
            
            <?php if ($booking_link) : ?>
                <a href="<?php echo esc_url($booking_link['url']); ?>" class="event-booking" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html($booking_link['title']); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <article>
        <div class="event-meta">
            <?php if ($event_start) : ?>
                <p><strong>Date:</strong> <?php echo date_i18n("l, j. F Y, H:i", strtotime($event_start));
                    if ($event_end) {
                        echo " - " . date_i18n("H:i", strtotime($event_end));
                    }
                ?></p>
            <?php endif; ?>
            
            <?php if ($location) : ?>
                <p><strong>Location:</strong> <a href="https://www.openstreetmap.org/search?query=<?php echo urlencode($location); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($location); ?></a></p>
            <?php endif; ?>
        </div>
        
        <?php if ($location) : ?>
            <div class="event-map" id="map"></div>
            
            <script>
                function initMap() {
                    const geocoder = new google.maps.Geocoder();
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 15,
                        center: { lat: 52.5200, lng: 13.4050 }, // Berlin coordinates
                    });
                    
                    geocoder.geocode({ address: "<?php echo esc_js($location); ?>" }, (results, status) => {
                        if (status === "OK") {
                            map.setCenter(results[0].geometry.location);
                            new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location,
                            });
                        }
                    });
                }
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
        <?php endif; ?>
        
        <div class="event-content">
            <?php the_content(); ?>
        </div>
    </article>
    
    <?php endwhile; ?>
    
    <section class="related-events">
        <h2>More Events</h2>
        <div class="related-grid">
            <?php
            $args = array(
                'post_type' => 'event',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
            );
            $related_events = new WP_Query($args);
            
            if ($related_events->have_posts()) :
                while ($related_events->have_posts()) : $related_events->the_post();
                    $event_start = get_field('event_start');
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
                            <?php if ($event_start) : ?>
                                <div class="date"><?php echo date_i18n('j. F Y', strtotime($event_start)); ?></div>
                            <?php endif; ?>
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

