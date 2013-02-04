<?php

function es_create_cpts () {
	$ppl_labels = array(
		'name' 					=> _x( 'People', 'post type general name' ),
		'singular_name' 		=> _x( 'Person', 'post type singular name' ),
		'add_new' 				=> _x( 'Add New', 'Person' ),
		'add_new_item' 			=> __( 'Add New ' . 'Person' ),
		'edit_item' 			=> __( 'Edit ' . 'Person' ),
		'new_item' 				=> __( 'New ' . 'Person' ),
		'view_item' 			=> __( 'View ' . 'Person' ),
		'search_items' 			=> __( 'Search ' . 'People' ),
		'not_found' 			=> __( 'No ' . 'People' . ' found' ),
		'not_found_in_trash' 	=> __( 'No ' . 'People' . ' found in Trash' ),
		'parent_item_colon' 	=> ''
	);
	// You can rewrite the slug on the front end by adding this to the key => Value on line 42 below.

	$ppl_args = array(
		'labels' 				=> $ppl_labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_menu' 			=> true,
		'query_var' 			=> true,
		'rewrite' 				=> true, // You can use $rewrite VAR above here.
		'capability_type' 		=> 'post',
		'has_archive' 			=> true,
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'thumbnail', 'excerpt', 'editor', 'page-attributes' ),
		'map_meta_cap' 			=> true

	);
	// Register the custom post type.
	register_post_type( 'peoples', $ppl_args );


}
add_action( 'init', 'es_create_cpts' );



function es_create_custom_taxonomies () {
	// Create a custom category taxonomy
	register_taxonomy( 'casestudy-cats', array('casestudies'), array(
		'hierarchical' => true,
		'label' => 'Case Study Types',
		'singular_label' => 'Case Study Type',
		'rewrite' => true,
		'public' => true
		// 'public' => false
	) );

	register_taxonomy( 'people-cats', array('peoples'), array(
		'hierarchical' => true,
		'label' => 'Roles of people',
		'singular_label' => 'Role',
		'rewrite' => true,
		'public' => true
		// 'public' => false
	) );


	// Create a custom tag taxonomy

}
add_action( 'init', 'es_create_custom_taxonomies');



?>