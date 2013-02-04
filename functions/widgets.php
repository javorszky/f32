<?php


$args[] = array(
    'name'          => __( 'Twitter Widget Here', 'theme_text_domain' ),
    'id'            => 'cardew-twitter',
    'description'   => 'Put the twitter widget here',
    'class'         => 'twit-bg',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '<div class="twit-title"><p>',
    'after_title'   => '</p></div>' );

$args[] = array(
    'name'          => __( 'Twitter Widget (Short)', 'theme_text_domain' ),
    'id'            => 'cardew-twitter-short',
    'description'   => 'Put another twitter widget here (the shorter one)',
    'class'         => 'twit-bg twit-bg-short',
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '<div class="twit-title"><p>',
    'after_title'   => '</p></div>' );

foreach ($args as $arg) {
	register_sidebar( $arg );

}
