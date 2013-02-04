<?php





function enQ_scripts() {
	wp_register_script( 'app', get_stylesheet_directory_uri() . '/javascripts/foundation/app-ck.js');
	wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/javascripts/foundation/modernizr.custom.10569.js');
	wp_enqueue_script( 'app' );
	wp_enqueue_script( 'modernizr' );
	if( is_page( 'contact' ) ) {
		wp_register_script( 'gmaps', 'http://maps.googleapis.com/maps/api/js?key=AIzaSyAKM-UzY7RzHaawdF5tbdxH5kMsw8qhqBA&sensor=false');
		wp_enqueue_script( 'gmaps' );
	}
	wp_register_style( 'main', get_stylesheet_uri() );
	wp_enqueue_style( 'main' );
}
add_action( 'wp_enqueue_scripts', 'enQ_scripts' );











