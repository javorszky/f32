<?php

function es_empty_paragraph_fix( $content ) {
	// An array of the offending tags.
	$arr = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);
	// Remove the offending tags and return the stripped content.
	$stripped_content = strtr( $content, $arr );
	return $stripped_content;
}
add_filter( 'the_content', 'es_empty_paragraph_fix' );

function add_locmap() {
	$html = '<div id="map_canvas"></div>';
	return $html;
}
add_shortcode( 'locmap', 'add_locmap' );


function thumbnailify( $atts, $content ) {
	global $post;
	ob_start();
	?>
	<div class="thumbnailyfy cf">
		<?php
		if( has_post_thumbnail() ) {
			the_post_thumbnail( 'casestudy_thumb_small' );
		}
		echo $content;
		?>
	</div>
	<?php
	$content = ob_get_clean();
	return $content;
}

// add_shortcode( 'strip', 'thumbnailify' );

function sanchezit( $atts, $content ) {
	$html = '<p class="blue sanchez">' . $content . '</p>';
	return $html;
}
add_shortcode( 'strong', 'sanchezit' );


?>