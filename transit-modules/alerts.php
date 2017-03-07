<?php

/**
 * The Alert custom post type.
 *
 * @package NWOTA
 */

$alert_labels = array(
			'name'               => _x( 'Alerts', 'post type general name' ),
			'singular_name'      => _x( 'alert', 'post type singular name' ),
			'menu_name'          => _x( 'Alerts', 'admin menu'),
			'name_admin_bar'     => _x( 'Alert', 'add new on admin bar'),
			'add_new'            => _x( 'Add New', 'alert'),
			'add_new_item'       => __( 'Add New Alert'),
			'new_item'           => __( 'New Alert'),
			'edit_item'          => __( 'Edit Alert'),
			'view_item'          => __( 'View Alert'),
			'all_items'          => __( 'All Alerts'),
			'search_items'       => __( 'Search Alerts'),
			'not_found'          => __( 'No alerts found.'),
			'not_found_in_trash' => __( 'No alerts found in Trash.')
		);

$alert_args = array(
			'menu_icon' 		 => 'dashicons-warning',
			'labels'             => $alert_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,		
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'alerts' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array( 'title', 'revisions', 'editor')
		);

register_post_type( 'alert', $alert_args );

add_action('init', 'nwota_alert_tax');
function nwota_alert_tax() {
	register_taxonomy(
		'alert-zone',
		array( 'alert', ),
		array(
			'label' => __( 'Alert Zone' ),
			'description' => 'Associate this alert with the correct route(s).',
			'rewrite' => array( 'slug' => 'alert-zone' ),
			'hierarchical' => false,
		)
	);
}

add_action('init', 'nwota_alert_terms');
/*
 * Add each route as an alert-zone term
 */
function nwota_alert_terms() {
    // If routes exist, add each one as an alert zone.
    if ( !post_type_exists( 'route' ) ) {
        return;
    }
    $args = array(
        'numberposts'   => -1,
        'post_type'     => 'route',
    );
    $routes = get_posts( $args );
    if ( !$routes ) {
        return;
    }
    foreach( $routes as $route ) {
        $zone_title = $route->post_title;
        $zone_slug = $route->post_name;
        $zone_exists = term_exists( $zone_title, 'alert-zone');
        if ( $zone_exists ) {
            return;
        }
        $term = wp_insert_term($zone_title, 'alert-zone', array( 'slug'=>$zone_slug ));
    }
}

/*
 * Echo out affected alert zones formatted with route color.
 * If route circles available, use those instead of route names.
 *
 * @param int $post_id    Optional post id, otherwise uses global post
 * @global WP_Post $post  Global post used if no post_id supplied
 * @return bool           Return false if none found, otherwise true
 */
function the_alert_zones( $post_id = null ) {
    if ( empty($post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    $terms = get_the_terms( $post_id, 'alert-zone' );
    if ( $terms && ! is_wp_error( $terms ) ) {
	    $affected = "";
	    foreach ( $terms as $term ) {
            // Requires using taxonomy terms created by nwota_alert_terms to ensure matching
            // the alert name
            $the_route = get_route_by_name( $term->name );
            if ( 'true' == get_option('use_route_circles') ) {
                $affected .= get_route_circle("small", $the_route->ID);
            } else {
	            $affected .= '<div class="post-tag" style="background-color:' . get_route_color( $the_route->ID ) . '">' . $term->name . '</div>';
	        }
        }
    echo $affected;
    }
}