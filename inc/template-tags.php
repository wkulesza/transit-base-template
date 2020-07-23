<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Transit_Base_Template
 */

if ( ! function_exists( 'transit_base_template_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function transit_base_template_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'transit_base_template' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'transit_base_template_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function transit_base_template_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'transit_base_template' ) );
		if ( $categories_list && transit_base_template_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'transit_base_template' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'transit_base_template' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'transit_base_template' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'transit_base_template' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'transit_base_template' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function transit_base_template_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'transit_base_template_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'transit_base_template_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so transit_base_template_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so transit_base_template_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in transit_base_template_categorized_blog.
 */
function transit_base_template_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'transit_base_template_categories' );
}
add_action( 'edit_category', 'transit_base_template_category_transient_flusher' );
add_action( 'save_post',     'transit_base_template_category_transient_flusher' );

/**
 * Creates posts/pages from passed array of post objects
 *
 * Takes in an array of post/page objects and creates a new page or post for each item.
 * By default post type is set to page, post status is set to publish, post template
 * for pages is set to page.php, and post title is set to 'Theme Generated Page - No Title'
 * You must be logged in as an admin and on the admin side for this function to run.
 * 
 * @param array   $args Array of post objects.
 * @param boolean $use_defaults Auto-generate starter pages. ( Default: false )
 * @return void.
 */
function transit_base_template_create_pages( $args = array(), $use_defaults = false ) {

	// Check to make sure you are not on the front-end and it is an
	// admin generating the pages.
	if ( ! is_admin() || ! current_user_can('administrator') ) {
		// Fail silently
		return;
	}
	
	// Setting defaults.
	$defaults = array(
		array( 
			'post_title' => 'About',
		),
		array( 
			'post_title' => 'Contact Us',
		),
		array( 
			'post_title' => 'Interactive Map',
			'page_template' => 'interactive-map.php'
		),
	);

	// Checking whether to use defaults or passed in args.
	if ( $use_defaults ) {
		$pages = $defaults;
	} else {
		$pages = $args;
	}

	if ( empty( $pages ) ) {
		// Fail silently
		return;
	}

	// Loop through and insert pages.
	foreach ( $pages as $page ) {
		
		// Set post title if not set
		if ( ! array_key_exists( 'post_title', $page ) ) {
			$page['post_title'] = 'Theme Generated Page - No Title';
		}

		// Set post status if not set
		if ( ! array_key_exists( 'post_status', $page ) ) {
			$page['post_status'] = 'publish';
		}
			
		// Set post type to page if not set
		if ( ! array_key_exists('post_type', $page ) ) {
			$page['post_type'] = 'page';
		}

		// If post type is page make sure post template is set and if not set it to page.php
		if ( 'page' == $page['post_type'] && ! array_key_exists('page_template', $page ) ) {
			$page['page_template'] = 'page.php';
		}

		$page_exists = get_page_by_title( $page['post_title'] );

		// Check if page_exists and if so, don't create a new one.
		if ( empty( $page_exists ) ) {
			wp_insert_post( $page );
		}
	}
}