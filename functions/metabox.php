<?php
$prefix = '_es_';

global $meta_boxes;

$meta_boxes = array();

$meta_boxes[] = array(
	'id' => 'people-details',
	'title' => 'Work Title',
	'pages' => array( 'peoples' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name'		=> 'Title',
			'id'		=> $prefix . 'person_title',
			'type'		=> 'text'
		),
		array(
			'name' => 'Big Image of the person',
			'id' => $prefix . 'person_bigshot',
			'type' => 'plupload_image',
			'max_file_uploads' => 1
		)
	)
);


$meta_boxes[] = array(
	'id' => 'office-details',
	'title' => 'Office Details',
	'pages' => array( 'offices' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name'		=> 'Latitude',
			'id'		=> $prefix . 'latitude',
			'type'		=> 'text'
		),
		array(
			'name'		=> 'Longitude',
			'id'		=> $prefix . 'longitude',
			'type'		=> 'text'
		),
		array(
			'name'		=> 'Telephone',
			'id'		=> $prefix . 'telephone',
			'type'		=> 'text'
		),
		array(
			'name'		=> 'Facsimile',
			'id'		=> $prefix . 'fax',
			'type'		=> 'text'
		),
		array(
			'name'		=> 'Email',
			'id'		=> $prefix . 'email',
			'type'		=> 'text'
		),
		array(
			'name'		=> 'Full Address',
			'id'		=> $prefix.'full_address',
			'type'		=> 'textarea',
			'cols'		=> "40",
			'rows'		=> "4"
		)
	)
);

$people_args = array(
	'post_type' => 'peoples',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'title'
);
$peeps = new WP_Query( $people_args );
$array = array();
// wp_die( es_preit( array( $peeps ), true ) );
if( $peeps->have_posts() ) {
	while( $peeps->have_posts() ) {
		$peeps->the_post();
		$array[ $post->ID ] = $post->post_title;
	}
}
$array['guest'] = 'Guest Author';





$meta_boxes[] = array(
	'id' => 'author-info',
	'title' => 'Author Info',
	'pages' => array( 'post' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
	    array(
	    	'name'		=> 'Select the Author',
	    	'id'		=> $prefix . "known_author",
	    	'type'		=> 'select',
	    	// Array of 'key' => 'value' pairs for select box
	    	'options'	=> $array,
	    	// Select multiple values, optional. Default is false.
	    	'multiple'	=> false,
	    	// Default value, can be string (single value) or array (for both single and multiple values)

	    	'desc'		=> 'Select the author from staff, or select Guest author and fill in the following boxes'
	    ),
		array(
			'name'		=> 'Name and title',
			'id'		=> $prefix . 'author_name_title',
			'type'		=> 'text'
		),
		array(
			'name'		=> 'Company / Department',
			'id'		=> $prefix . 'author_dep',
			'type'		=> 'text'
		)
	)
);

/**
 * Register meta boxes
 *
 * @return void
 */
function rw_register_meta_boxes() {
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			if( isset( $meta_box[ 'not_on' ] ) && !rw_maybe_include( $meta_box[ 'not_on' ], 0 ) ) {
				continue;
			}
			if( isset( $meta_box['only_on'] ) && !rw_maybe_include( $meta_box['only_on'], 1 ) ) {
				continue;
			}

			new RW_Meta_Box( $meta_box );
		}
	}
}

add_action( 'admin_init', 'rw_register_meta_boxes' );

/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include( $conditions, $bool = -1 ) {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}

	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );
	switch( $bool ) {
		// if we're including (only_on)
		case 1:
			foreach ( $conditions as $cond => $v ) {
				// Catch non-arrays too
				if ( ! is_array( $v ) ) {
					$v = array( $v );
				}

				switch ( $cond ) {
					case 'id':
						if ( in_array( $post_id, $v ) ) {
							return true;
						}
					break;
					case 'parent':
						$post_parent = $post->post_parent;
						if ( in_array( $post_parent, $v ) ) {
							return true;
						}
					break;
					case 'slug':
						$post_slug = $post->post_name;
						if ( in_array( $post_slug, $v ) ) {
							return true;
						}
					break;
					case 'template':
						$template = get_post_meta( $post_id, '_wp_page_template', true );
						if ( in_array( $template, $v ) ) {
							return true;
						}
					break;
					case 'is_meta':
						$true = 1;
						foreach( $v as $_key => $_value ) {
							$_meta = get_post_meta( $post_id, $_key, true );
							if( $_meta != $_value ) {
								$true = 0;
							} else {
								wp_die( es_preit( array( $post_id, $_meta, $_value, $_key ), true ) );
							}
						}
						if( $true ) {
							return true;
						}
					break;
				}
			}
			break;
		// when we're excluding (not_on)
		case 0:
			foreach ( $conditions as $cond => $v ) {
				// Catch non-arrays too
				if ( ! is_array( $v ) ) {
					$v = array( $v );
				}

				switch ( $cond ) {
					case 'id':
						if ( !in_array( $post_id, $v ) ) {
							return true;
						}
					break;
					case 'parent':
						$post_parent = $post->post_parent;
						if ( !in_array( $post_parent, $v ) ) {
							return true;
						}
					break;
					case 'slug':
						$post_slug = $post->post_name;
						if ( !in_array( $post_slug, $v ) ) {
							return true;
						}
					break;
					case 'template':
						$template = get_post_meta( $post_id, '_wp_page_template', true );
						if ( !in_array( $template, $v ) ) {
							return true;
						}
					break;
				}
			}
			break;
		default:
			return true;
	}


	// If no condition matched
	return false;
}



?>