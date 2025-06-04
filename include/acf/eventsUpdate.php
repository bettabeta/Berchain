<?php

use om\IcalParser;

add_action('init', 'my_schedulers_activation');

function my_schedulers_activation() {
    if (!wp_next_scheduled('update_event_list')) {
        wp_schedule_event(time(), 'hourly', 'update_event_list');
    }
}

add_action('update_event_list', 'function_for_update_event_list', 100);

function function_for_update_event_list() {
    require_once 'vendor/autoload.php';

    $cal = new IcalParser();
    $results = $cal->parseFile(
        'https://calendar.google.com/calendar/ical/c_31318030e0ac5bfa5b4585f891cb6c55a5004e3cb0b458f9be351ffbcef65943%40group.calendar.google.com/public/basic.ics'
    );

    $eventArr = $cal->getEvents()->sorted();

    if (is_object($eventArr)) {
        $i = 0;
        foreach ($eventArr as $event) {
            if ($i >= (count($eventArr) - 50)) {

                $title = $event["SUMMARY"];
                $description = isset($event['DESCRIPTION']) ? $event['DESCRIPTION'] : '';
                $event_start = $event['DTSTART']->format('Y-m-d H:i:s');
                $event_end = $event['DTEND']->format('Y-m-d H:i:s');
                $location = isset($event['LOCATION']) ? $event['LOCATION'] : '';
                $location_url = $location ? "https://www.google.com/maps/search/" . urlencode($location) : '';

                $existing = get_posts(array(
                    'post_type' => 'event',
                    'post_status' => 'publish',
                    'title' => $title,
                    'meta_query' => array(
                        array(
                            'key' => 'event_start',
                            'value' => $event_start,
                            'compare' => '=',
                        )
                    ),
                    'posts_per_page' => 1,
                    'fields' => 'ids'
                ));

                if (empty($existing)) {
                    $post_id = wp_insert_post(array(
                        'post_type' => 'event',
                        'post_title' => wp_strip_all_tags($title),
                        'post_content' => $description,
                        'post_status' => 'publish'
                    ));

                    if ($post_id) {
                        update_field('event_start', $event_start, $post_id);
                        update_field('event_end', $event_end, $post_id);
                        update_field('event_location', $location, $post_id);
                        update_field('event_link', $location_url, $post_id);

                        $images_arr = [333, 314, 356, 358, 359];
                        $img_id = $images_arr[$i % count($images_arr)];
                        set_post_thumbnail($post_id, $img_id);
                    }
                }
            }
            $i++;
        }
    }
}
