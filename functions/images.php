<?php
add_theme_support( 'post-thumbnails' );


// add_image_size( 'handle', width, height, crop? );
add_image_size( 'bigembed', 566, '', false );
add_image_size( 'casestudy_thumb', 172, 84, false );
add_image_size( 'people_thumb', 172, 120, false );
add_image_size( 'casestudy_thumb_small', 108, 75, false );
add_image_size( 'opinion_thumb', 160, 160, true );
add_image_size( 'people_tiny', 43, 30, true );
add_image_size( 'page_thumbs', 336, 179, true );


update_option('thumbnail_size_w', 160);
update_option('thumbnail_size_h', 160);


add_filter('image_size_names_choose', 'my_image_sizes');
function my_image_sizes($sizes) {
    $addsizes = array(
        "bigembed" => __( "Inline Fullwidth" )

    );
    $newsizes = array_merge($sizes, $addsizes);
    return $newsizes;
}