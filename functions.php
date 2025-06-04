<?php
// Theme Constants

define( 'HOME_PAGE_ID', get_option( 'page_on_front' ) );
define( 'BLOG_ID', get_option( 'page_for_posts' ) );
define( 'POSTS_PER_PAGE', get_option( 'posts_per_page' ) );

/* INCLUDE CUSTOM FUNCTIONS
   ========================================================================== */
// Recommended plugins installer
require_once 'include/plugins/init.php';
// Core functionality
require_once 'include/core.php';
// Events updater
require_once 'include/events/eventsUpdate.php';
// Custom post types
require_once 'include/cpt.php';

// Image sizes on theme activation
function set_default_image_sizes() {
    update_option( 'thumbnail_size_w', 400 );
    update_option( 'thumbnail_size_h', 400 );
    update_option( 'medium_size_w', 800 );
    update_option( 'medium_size_h', 800 );
    update_option( 'large_size_w', 2048 );
    update_option( 'large_size_h', 2048 );
}
add_action( 'after_switch_theme', 'set_default_image_sizes' );

// Enable Featured Images
add_theme_support( 'post-thumbnails' );

/* REGISTER MENUS
   ========================================================================== */
register_nav_menus( array(
    'main_menu'   => 'Main navigation',
    'second_menu' => 'Second navigation',
    'foot_menu'   => 'Footer navigation',
) );

// Utility to get attachment data
function wp_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );
    return array(
        'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption'     => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href'        => get_permalink( $attachment->ID ),
        'src'         => $attachment->guid,
        'title'       => $attachment->post_title,
    );
}

function berchain_enqueue_styles() {
    wp_enqueue_style('berchain-style', get_stylesheet_uri());
    wp_enqueue_style('berchain-main', get_template_directory_uri() . '/scss/main.css');
}
add_action('wp_enqueue_scripts', 'berchain_enqueue_styles');


// Berchain Chat Embed Shortcode
function berchain_custom_chat_embed() {
    ob_start(); ?>
    <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
    <script type="module">
        import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';
        createChat({
            webhookUrl: 'https://berchain.app.n8n.cloud/webhook/42d7ec9d-be2b-4dcb-a36b-b3039aa2970a/chat',
            mode: 'fullscreen',
            target: '#n8n-chat',
            initialMessages: ["Hello, I'm here to help you to discover companies in the Blockchain space"],
            i18n: { en: { title: 'Berchain Companies', subtitle: 'Discover Blockchain companies', footer: '', getStarted: 'New Conversation', inputPlaceholder: 'Which industry or use case are you interested in?' } }
        });
    </script>
    <?php return ob_get_clean();
}
add_shortcode( 'berchain_chat', 'berchain_custom_chat_embed' );

// ACF Options Page
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page(array(
        'page_title' => 'Theme Optionen',
        'menu_title' => 'Theme Optionen',
        'menu_slug'  => 'theme-options',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));
}

// Debug Active Template
add_action( 'wp_footer', function() {
    if ( current_user_can( 'manage_options' ) ) {
        global $template;
        echo '<div style="background:#000;color:#0f0;padding:10px;font-size:12px;z-index:9999;">Aktives Template: ' . basename( $template ) . '</div>';
    }
} );

// Enqueue Swiper Assets
function load_swiper_assets() {
    wp_enqueue_style(  'swiper-css', 'https://unpkg.com/swiper@9/swiper-bundle.min.css' );
    wp_enqueue_script( 'swiper-js',  'https://unpkg.com/swiper@9/swiper-bundle.min.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'load_swiper_assets' );

// iCal Feed for Events
function berchain_add_ical_feed() {
    add_feed( 'events_ical', 'berchain_render_ical_feed' );
}
add_action( 'init', 'berchain_add_ical_feed' );

function berchain_render_ical_feed() {
    header( 'Content-Type: text/calendar; charset=utf-8' );
    echo "BEGIN:VCALENDAR\r\n";
    echo "VERSION:2.0\r\n";
    echo "PRODID:-//BerChain e.V.//Event Calendar//DE\r\n";

    $events = new WP_Query(array(
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'meta_key'       => 'event_start',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => array(array(
            'key'     => 'event_start',
            'value'   => date('Y-m-d H:i:s'),
            'compare' => '>=',
            'type'    => 'DATETIME',
        )),
    ));

    if ( $events->have_posts() ) {
        while ( $events->have_posts() ) {
            $events->the_post();
            $start   = get_field( 'event_start' );
            $uid     = get_the_ID() . '@berchain.org';
            $dtstamp = gmdate( 'Ymd\THis\Z' );
            $dtstart = gmdate( 'Ymd\THis\Z', strtotime( $start ) );

            echo "BEGIN:VEVENT\r\n";
            echo "UID:$uid\r\n";
            echo "DTSTAMP:$dtstamp\r\n";
            echo "DTSTART:$dtstart\r\n";
            echo "SUMMARY:" . esc_textarea( get_the_title() ) . "\r\n";
            $desc = wp_strip_all_tags( get_the_content() );
            echo "DESCRIPTION:" . esc_textarea( $desc ) . "\r\n";
            echo "URL:" . get_permalink() . "\r\n";
            echo "END:VEVENT\r\n";
        }
        wp_reset_postdata();
    }

    echo "END:VCALENDAR\r\n";
}

add_filter('template_include', function($template) {
    if (is_page('events')) {
        $new_template = locate_template('tpl-events.php');
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
});

// WordPress Editor Farben & Global Styles deaktivieren
add_theme_support( 'editor-color-palette', [] );

add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'global-styles' );
}, 100 );

// Einbindung Template / ACF Footer & Social & Logo
require_once get_template_directory() . '/include/theme-options.php';

// Enqueue Leaflet for OpenStreetMap
function load_leaflet_assets() {
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'load_leaflet_assets');

// Load ACF Fields
require_once get_template_directory() . '/include/acf/berlin-blockchain.php';

// Register News Template
add_filter('theme_page_templates', function($templates) {
    $templates['tpl-news.php'] = 'News Template';
    return $templates;
});

// Load more events AJAX handler
function load_more_events() {
    check_ajax_referer('load_more_events', 'nonce');
    
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $current_date = current_time('Y-m-d H:i:s');
    
    $args = array(
        'post_type'      => 'event',
        'posts_per_page' => 9,
        'offset'         => $offset,
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'event_start',
                'compare' => 'EXISTS'
            ),
            array(
                'key'     => 'event_start',
                'value'   => $current_date,
                'compare' => '>=',
                'type'    => 'DATETIME'
            )
        ),
        'orderby'        => 'meta_value',
        'meta_key'       => 'event_start',
        'order'          => 'ASC',
        'post_status'    => 'publish'
    );
    
    $events = new WP_Query($args);
    
    if ($events->have_posts()) {
        while ($events->have_posts()) {
            $events->the_post();
            $event_start = get_field('event_start');
            $event_end = get_field('event_end');
            $location = get_field('event_location');
            
            if (!$event_start) {
                continue;
            }
            
            $date = DateTime::createFromFormat('d/m/Y g:i a', $event_start);
            if (!$date) {
                continue;
            }
            
            $event_year = $date->format('Y');
            $event_month = $date->format('m');
            ?>
            <div class="event-post" 
                 data-year="<?php echo esc_attr($event_year); ?>" 
                 data-month="<?php echo esc_attr($event_month); ?>"
                 data-date="<?php echo esc_attr($date->format('Y-m-d')); ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="event-image">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } else { ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="">
                        <?php } ?>
                    </div>
                    <div class="event-content">
                        <h3><?php the_title(); ?></h3>
                        <?php if ($event_start): ?>
                            <div class="textline">🗓 <?php echo $date->format('j. F Y, H:i'); ?></div>
                        <?php endif; ?>
                        <?php if ($event_end && $event_end !== $event_start): 
                            $end_date = DateTime::createFromFormat('d/m/Y g:i a', $event_end);
                            if ($end_date): ?>
                                <div class="textline">bis <?php echo $end_date->format('j. F Y, H:i'); ?></div>
                            <?php endif;
                        endif; ?>
                        <?php if ($location && mb_strlen($location) <= 30): ?>
                            <div class="textline">📍 <?php echo esc_html($location); ?></div>
                        <?php endif; ?>
                        <div class="event-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
        wp_reset_postdata();
    }
    
    die();
}
add_action('wp_ajax_load_more_events', 'load_more_events');
add_action('wp_ajax_nopriv_load_more_events', 'load_more_events');

function berchain_scripts() {
    // ... existing scripts ...
    wp_enqueue_script('berchain-menu', get_template_directory_uri() . '/js/menu.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'berchain_scripts');

wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

