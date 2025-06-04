<?php

// CPT Registrieren: Events
add_action( 'init', 'register_event_cpt' );

function register_event_cpt() {

    $labels = array(
        'name'                  => _x( 'Events', 'Post Type General Name', 'textdomain' ),
        'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'textdomain' ),
        'menu_name'             => __( 'Events', 'textdomain' ),
        'name_admin_bar'        => __( 'Event', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Event', 'textdomain' ),
        'edit_item'             => __( 'Edit Event', 'textdomain' ),
        'new_item'              => __( 'New Event', 'textdomain' ),
        'view_item'             => __( 'View Event', 'textdomain' ),
        'search_items'          => __( 'Search Events', 'textdomain' ),
        'not_found'             => __( 'No Events found', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Events found in Trash', 'textdomain' ),
    );

    $args = array(
        'label'                 => __( 'Events', 'textdomain' ),
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-calendar-alt',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'events' ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'show_in_rest'          => true, // Gutenberg Editor aktivieren
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
    );

    register_post_type( 'event', $args );
}

// Hinweis: "flush_rewrite_rules();" nur nach Theme- oder Plugin-Aktivierung manuell ausführen, nicht hier automatisch.


