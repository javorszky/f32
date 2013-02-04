<?php


remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);



if( !function_exists('es_preit') ) {
	function es_preit( $obj, $echo = true ) {
		if( $echo ) {
			echo '<pre>';
			print_r( $obj );
			echo '</pre>';
		} else {
			return print_r( $obj, true );
		}
	}
}


// add_image_size( 'nocrop_thumb', 150, 300, false );


/**
 * es_get_the_excerpt
 *
 * Provides a way to get the excerpt of a page by its ID
 *
 * @param  number, boolean $id=false false - get the current post/page's excerpt. Number: get the specific ID-d page's excerpt
 * @return string            The excerpt
 * @author Gabor Javorszky <gabor@electricstudio.co.uk>
 * @since 1.0
 */
function es_get_the_excerpt($id=false, $wcount = 55) {
    global $post;

    $old_post = $post;
    if ($id != $post->ID) {
        $post = get_page($id);
    }

    if (!$excerpt = trim($post->post_excerpt)) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes( $excerpt );
        // $excerpt = apply_filters('the_content', $excerpt);
        $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
        $excerpt = strip_tags($excerpt);
        $excerpt_length = apply_filters('excerpt_length', $wcount);
        $excerpt_more = apply_filters('excerpt_more', ' ');

        $words = preg_split("/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $excerpt = implode(' ', $words);
            $excerpt = $excerpt . $excerpt_more;
        } else {
            $excerpt = implode(' ', $words);
        }
    }

    $post = $old_post;

    return $excerpt;
}



/**
 *
 * Return the ID of a page based on the page slug been passed.
 * @name		es_page_id()
 * @param 		string $page_name
 * @returns 	int
 * @author		Matt <matt@electricstudio.co.uk>
 * @since		1.0
 */
function es_page_id( $page_name = false ) {
	if( $page_name === false )
		return false;
	$arr = array();
	$pages = get_pages();
	foreach ( $pages as $page ) {
		$arr[$page->post_name] = $page->ID;
	}
	return $arr[$page_name];
}





function _format_bytes($a_bytes)
{
    if ($a_bytes < 1024) {
        return $a_bytes .' B';
    } elseif ($a_bytes < 1048576) {
        return round($a_bytes / 1024, 2) .' KiB';
    } elseif ($a_bytes < 1073741824) {
        return round($a_bytes / 1048576, 2) . ' MiB';
    } elseif ($a_bytes < 1099511627776) {
        return round($a_bytes / 1073741824, 2) . ' GiB';
    } elseif ($a_bytes < 1125899906842624) {
        return round($a_bytes / 1099511627776, 2) .' TiB';
    } elseif ($a_bytes < 1152921504606846976) {
        return round($a_bytes / 1125899906842624, 2) .' PiB';
    } elseif ($a_bytes < 1180591620717411303424) {
        return round($a_bytes / 1152921504606846976, 2) .' EiB';
    } elseif ($a_bytes < 1208925819614629174706176) {
        return round($a_bytes / 1180591620717411303424, 2) .' ZiB';
    } else {
        return round($a_bytes / 1208925819614629174706176, 2) .' YiB';
    }
}



function change_post_menu_label() {
    global $menu;
    global $submenu;

    // wp_die( es_preit( array( $submenu ), true ) );
    $menu[5][0] = 'Opinions';
    $submenu['edit.php'][5][0] = 'All Opinions';

    // echo '';
}

function change_post_object_label() {
    global $wp_post_types;
    // wp_die( es_preit( array( $wp_post_types ), true ) );
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Opinions';
    $labels->singular_name = 'Opinion';
    $labels->add_new = 'Add Opinion';
    $labels->add_new_item = 'Add Opinion';
    $labels->edit_item = 'Edit Opinions';
    $labels->new_item = 'Opinion';
    $labels->view_item = 'View Opinion';
    $labels->search_items = 'Search Opinions';
    $labels->not_found = 'No Opinions found';
    $labels->not_found_in_trash = 'No Opinions found in Trash';
}
// add_action( 'init', 'change_post_object_label' );
// add_action( 'admin_menu', 'change_post_menu_label' );

/**
 *
 * Returns the ID for the parent page.
 * @name    es_get_root_page()
 * @param   int $post_ID
 * @param   post_type $type
 * @return  int
 * @author  Matt <matt@electricstudio.co.uk>
 * @since   1.0
 */
function es_get_root_page( $post_ID = false, $type = 'page' ) {
    if( !$post_ID )
        return false;
    $ancestors = get_ancestors( $post_ID, $type );
    $count = count( $ancestors );
    $i = ( $count - 1 );
    if( $count > 0 ) {
        return $ancestors[$i];
    } else {
        return $post_ID;
    }
}

// remove_filter( 'the_content', 'sharing_display', 19 );
// remove_filter( 'the_excerpt', 'sharing_display', 19 );
// remove_filter( 'the_content', 'sharing_display', 19 );
// remove_filter( 'the_excerpt', 'sharing_display', 19 );


// es_preit( $wp_filter );
// wp_die( es_preit( array( !has_filter( 'the_content' ) ? 'returned false' : 'returned true' ), true ) );
function remove_stuff() {
    global $wp_filter;
    remove_filter( 'the_content', 'sharing_display', 19 );

}

add_action( 'template_redirect', 'remove_stuff' );
function checkstuff() {
    global $wp_filter;
    wp_die( es_preit( array( $wp_filter ), true ) );
}
// add_filter( 'the_content', 'checkstuff', 0 );

?>