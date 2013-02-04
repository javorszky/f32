<?php

register_nav_menus(array(
	'main' => 'Main navigation',
	'footer' => 'Footer navigation'
));

/**
 *
 * Creates a paginated navigation area
 * @name    es_paginate_links
 * @param   array $args
 * @return  string (HTML)
 * @author  Matt
 * @since   1.0
 */
function es_paginate_links( $args = '' ) {
    $defaults = array(
        'base'         => '%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format'       => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
        'total'        => 1,
        'current'      => 0,
        'show_all'     => false,
        'prev_next'    => true,
        'prev_text'    => __('&lt; Previous'),
        'next_text'    => __('Next &gt;'),
        'end_size'     => 1,
        'mid_size'     => 2,
        'type'         => 'plain',
        'add_args'     => false, // array of query args to add
        'add_fragment' => '',
        'menu_class'   => 'clearfix'
    );


    $args = wp_parse_args( $args, $defaults );
    extract($args, EXTR_SKIP);

    // wp_die( es_preit( array( $args ), true ) );
    // es_preit( $args );

    // Who knows what else people pass in $args
    $total = (int) $total;
    if ( $total < 2 )
        return;
    $current  = (int) $current;
    $end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
    $mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
    $add_args = is_array($add_args) ? $add_args : false;
    $r = '';
    $page_links = array();
    $n = 0;
    $dots = false;



    // this is the previous link
    // if pagination is enabled, and we're on a paginated page
    if ( $prev_next && $current ) {
        // if this is not the first page, ever
        if( 1 < $current ) {
            $first = str_replace('%_%', '' , $base);

            if ( $add_args )
                $first = add_query_arg( $add_args, $first );
            $first .= $add_fragment;

            $page_links[] = '<a class="first page_numbers" href="' . $first . '"><<</a>';


            $link = str_replace('%_%', 2 == $current ? '' : $format, $base);
            $link = str_replace('%#%', $current - 1, $link);
            if ( $add_args )
                $link = add_query_arg( $add_args, $link );
            $link .= $add_fragment;

            $page_links[] = '<a class="prev page_numbers" href="' . $link . '">' . $prev_text . '</a>';
            // $page_links[] = '<a class="prev page_numbers" href="' . esc_url( apply_filters( 'es_paginate_links', $link ) ) . '">' . $prev_text . '</a>';
        } else {

            $first = str_replace('%_%', '' , $base);

            if ( $add_args )
                $first = add_query_arg( $add_args, $first );
            $first .= $add_fragment;

            $page_links[] = '<span class="first page_numbers inactive"><<</span>';

            $link = str_replace('%_%', 2 == $current ? '' : $format, $base);
            $link = str_replace('%#%', $current - 1, $link);
            if ( $add_args )
                $link = add_query_arg( $add_args, $link );
            $link .= $add_fragment;

            $page_links[] = '<span class="prev page_numbers inactive">' . $prev_text . '</span>';
            // $page_links[] = '<a class="prev page_numbers" href="' . esc_url( apply_filters( 'es_paginate_links', $link ) ) . '">' . $prev_text . '</a>';
        }
    }


    // these are the number links
    for ( $n = 1; $n <= $total; $n++ ) {
        $n_display = number_format_i18n($n);
        if ( $n == $current ) {
            $page_links[] = "<span class='page_numbers current'>$n_display</span>";
            $dots = true;
        } else {
            if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) {
                $link = str_replace('%_%', 1 == $n ? '' : $format, $base);
                $link = str_replace('%#%', $n, $link);
                if ( $add_args )
                    $link = add_query_arg( $add_args, $link );
                $link .= $add_fragment;
                $page_links[] = "<a class='page_numbers' href='" . $link . "'>$n_display</a>";
                $dots = true;
            } elseif ( $dots && !$show_all ) {
                $page_links[] = '<span class="page_numbers dots">...</span>';
                $dots = false;
            }
        }
    }

    // this is the next link
    if ( $prev_next && $current ) {
        if ( $current < $total || -1 == $total ) {
            $link = str_replace('%_%', $format, $base);
            $link = str_replace('%#%', $current + 1, $link);
            if ( $add_args )
                $link = add_query_arg( $add_args, $link );
            $link .= $add_fragment;

            $page_links[] = '<a class="next page_numbers" href="' . $link . '">' . $next_text . '</a>';


            $last = str_replace('%_%', $format, $base);
            $last = str_replace('%#%', $total, $last);
            if ( $add_args )
                $last = add_query_arg( $add_args, $last );
            $last .= $add_fragment;

            $page_links[] = '<a class="last page_numbers" href="' . $last . '">>></a>';


        } else {
            $link = str_replace('%_%', $format, $base);
            $link = str_replace('%#%', $current + 1, $link);
            if ( $add_args )
                $link = add_query_arg( $add_args, $link );
            $link .= $add_fragment;

            $page_links[] = '<span class="next page_numbers inactive">' . $next_text . '</span>';

            $last = str_replace('%_%', $format, $base);
            $last = str_replace('%#%', $total, $last);
            if ( $add_args )
                $last = add_query_arg( $add_args, $last );
            $last .= $add_fragment;

            $page_links[] = '<span class="last page_numbers inactive">>></a>';
        }
    }

    switch ( $type ) {
        case 'array' :
            return $page_links;
            break;
        case 'list' :
            $r .= "<ul class=\"$menu_class\">\n\t<li>";
            $r .= join("</li>\n\t<li>", $page_links);
            $r .= "</li>\n</ul>\n";
            break;
        default :
            $r = join(" | ", $page_links);
            break;
    }
    return $r;
}

































































































