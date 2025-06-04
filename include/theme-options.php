
<?php
// Login-Logo aus ACF
add_action( 'login_head', function() {
    $logo = get_field( 'login_logo', 'option' );
    if ( $logo ) {
        $url = wp_get_attachment_image_url( $logo, 'full' );
        echo '<style>.login h1 a { background-image: url(' . esc_url( $url ) . ') !important; height: 135px!important; background-size: contain!important; }</style>';
    }
});

// Footer Text im Frontend anzeigen
function berchain_footer_text() {
    if ( $text = get_field( 'footer_text', 'option' ) ) {
        echo '<div class="footer-text">' . esc_html( $text ) . '</div>';
    }
}

// Social Links im Footer
function berchain_social_links() {
    if ( have_rows( 'social_links', 'option' ) ) {
        echo '<ul class="social-links">';
        while ( have_rows( 'social_links', 'option' ) ) {
            the_row();
            $platform = get_sub_field( 'platform' );
            $url      = get_sub_field( 'url' );
            echo '<li><a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $platform ) . '</a></li>';
        }
        echo '</ul>';
    }
}
