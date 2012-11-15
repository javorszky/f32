<?php





function enQ_scripts() {
	wp_register_script( 'app', get_stylesheet_directory_uri() . '/javascripts/foundation/app-ck.js');
	wp_enqueue_script( 'app' );

	wp_register_style( 'main', get_stylesheet_uri() );
	wp_enqueue_style( 'main' );
}
add_action( 'wp_enqueue_scripts', 'enQ_scripts' );












?>