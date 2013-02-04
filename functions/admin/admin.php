<?php
/**
 * admin.php
 *
 * Purpose: To create admin setting pages.
 * Usage: Add the pages to the $admin_pages array
 * You need to specify a "Page title", "Menu title", "Capability", "Menu slug", "Settings section", "Settings name" and the fields to be included in the Settings page.
 * You have the choice of adding "Textboxes", "Textareas", "WYSIWYGs", "Radio buttons" and "Select boxes".
 * When creating the fields you must specify the following: "Type", "Name" and "Title"
 * If you are adding a set of radio buttons or a select box you need to add an "Options" array specifying "Key" => "Value"
 *
 * @package boilerplate
 */

// add_action( 'template_redirect', 'not_logged_in' );
// add_filter( 'login_redirect', 'redirect_to_frontend', 10, 3 );
// add_filter( 'show_admin_bar', 'remove_admin_bars' );
// add_action('post_edit_form_tag', 'post_edit_form_tag');
// add_action( 'user_register', 'create_user_pages_args' );
// add_action( 'auto_page_creation', 'es_auto_page_creation', 10, 1 );
// add_action( 'after_setup_theme', 'es_add_pages', 99 );


// Run a quick check to see if we are logged into the admin panel.
if( is_admin() ) {

	// Add in the classes.
	require_once( get_template_directory() . '/functions/admin/classes/admin.class.php' );

	// Add in the "Theme page" class.
	require_once( get_template_directory() . '/functions/admin/classes/admin-add-page.class.php' );

	// Create the array that stores the individual settings page information.
	$admin_pages = array();

	// Set up a new settings page as an array part.
	$admin_pages[] = array(
		'page_title' 		=> 'ES Theme Options',
		'menu_title' 		=> 'Theme Options',
		'capability' 		=> 'manage_options',
		'menu_slug' 		=> 'es_theme_options',
		'settings_section'	=> 'es_misc_options_section',
		'settings_name' 	=> 'es_theme_options',
		'settings_desc' 	=> 'Add in the theme options description here!',
		'fields' => array(
			array(
			    'name' 		=> 'exb_twitter',
				'title'		=> 'Twitter account',
				'id'		=> $prefix . 'exb_twit',
				'desc'		=> 'Don\'t use the @',
				'type'		=> 'textbox',
			),
			// array(
			//     'name' 		=> 'exb_facebook',
			// 	'title'		=> 'Facebook account',
			// 	'id'		=> $prefix . 'exb_fb',
			// 	'desc'		=> 'Use the full URL',
			// 	'type'		=> 'textbox',
			// ),
			array(
			    'name'		=> 'exb_linkedin',
				'title'		=> 'Linkedin account',
				'id'		=> $prefix . 'exb_linkedin',
				'desc'		=> 'Use the full URL',
				'type'		=> 'textbox'
			),
			array(
			    'name'		=> 'exb_phone',
				'title'		=> 'Phone number',
				'id'		=> $prefix . 'exb_phonenumber',
				// 'desc'		=> 'Use the full URL',
				'type'		=> 'textbox'
			),
			array(
			    'name'		=> 'exb_email',
				'title'		=> 'Email address',
				'id'		=> $prefix . 'exb_email',
				'desc'		=> 'The email address ini the footer for the "email us" link',
				'type'		=> 'textbox'
			),
			array(
			    'name'		=> 'exb_testimonial_body',
				'title'		=> 'Testimonial test',
				'id'		=> $prefix . 'exb_testimonial',
				// 'desc'		=> 'Use the full URL',
				'type'		=> 'textarea'
			),
			array(
			    'name'		=> 'exb_testimonial_person',
				'title'		=> 'Person\'s name',
				'id'		=> $prefix . 'exb_testimonial_person',
				// 'desc'		=> 'Use the full URL',
				'type'		=> 'textbox'
			),
			array(
			    'name'		=> 'exb_testimonial_company',
				'title'		=> 'The company the test. is from',
				'id'		=> $prefix . 'exb_testimonial_co',
				// 'desc'		=> 'Use the full URL',
				'type'		=> 'textbox'
			),

		)
	);



	// Run a quick check to see if the ES_Admin_Pages class has been included in the functions.
	if( class_exists( 'ES_Admin_Add_Pages' ) ) {
		// Loop through the array and pass the data to the ES_Admin_Pages class.
		foreach( $admin_pages as $admin_page ) {
			new ES_Admin_Add_Pages( $admin_page );
		}
	}

	// Add in the "Sub pages" class.
	require_once( get_template_directory() . '/functions/admin/classes/admin-add-sub-page.class.php' );

	// Create the array that stores the individual settings page information.
	$admin_sub_pages = array();

	// Set up a new settings page as an array part.
	$admin_sub_pages[] = array(
		'parent_slug' 		=> 'edit.php?post_type=projects',
		'page_title' 		=> 'Project settings',
		'menu_title' 		=> 'Project settings',
		'capability' 		=> 'manage_options',
		'menu_slug' 		=> 'es_project_settings',
		'settings_section' 	=> 'es_project_settings_section',
		'settings_name' 	=> 'es_project_settings',
		'settings_desc' 	=> 'Add in the project settings description here!',
		'fields' => array(
			// New textbox
			array(
				'type' 	=> 'textbox',
				'name' 	=> 'es_project_textbox',
				'title' => 'Theme textbox'
			),
			// New textarea
			array(
				'type' 	=> 'textarea',
				'name' 	=> 'es_project_textarea',
				'title' => 'Theme textarea'
			),
			// New WYSIWYG
			array(
				'type' 	=> 'wysiwyg',
				'name' 	=> 'es_project_wysiwyg',
				'title' => 'Theme wysiwyg'
			),
			// New radio buttons
			array(
				'type' 	=> 'radio',
				'name' 	=> 'es_project_checkboxes',
				'title' => 'Theme radio buttons',
				'options' => array(
					'Yes' 	=> 'Y',
					'No' 	=> 'N',
					'Maybe' => 'M'
				),
				'desc' 	=> 'Just a trial of the description array part that can be added to the separate fields...'
			),
			// New radio buttons
			array(
				'type' 	=> 'select',
				'name' 	=> 'es_project_select_box',
				'title' => 'Theme select box',
				'options' => array(
					'David' 	=> 'david',
					'James' 	=> 'james',
					'Matthew' 	=> 'matthew',
					'Patrik' 	=> 'patrik'
				),
				'desc' 	=> 'Just a trial of the description array part that can be added to the separate fields...'
			)
		)
	);

	// Run a quick check to see if the ES_Admin_Pages class has been included in the functions.
	if( class_exists( 'ES_Admin_Add_Pages' ) ) {
		// Loop through the array and pass the data to the ES_Admin_Pages class.
		foreach( $admin_sub_pages as $admin_sub_page ) {
			new ES_Admin_Add_Sub_Pages( $admin_sub_page );
		}
	}
}


