<?php
/**
 * Transit Base Template functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Transit_Base_Template
 */

if ( ! function_exists( 'transit_base_template_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function transit_base_template_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Transit Base Template, use a find and replace
		 * to change 'transit-base-template' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'transit-base-template', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'transit-base-template' ),
			'menu-2' => esc_html__( 'Footer', 'transit-base-template' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'transit_base_template_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'transit_base_template_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function transit_base_template_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'transit_base_template_content_width', 640 );
}
add_action( 'after_setup_theme', 'transit_base_template_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function transit_base_template_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'transit-base-template' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'transit-base-template' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'transit-base-template' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'transit-base-template' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Homepage Widgets', 'transit-base-template' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here.', 'transit-base-template' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'transit_base_template_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function transit_base_template_scripts() {
	wp_enqueue_style( 'transit-base-template-style', get_stylesheet_uri() );

	wp_enqueue_script( 'transit-base-template-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	// Load IE JS Polyfills - Down to IE 9
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) ) {
		wp_enqueue_script( 'js-polyfills', get_template_directory_uri() . '/js/polyfills.js', array(), '20201106', true );
	}

	wp_enqueue_script( 'js-collapse', get_template_directory_uri() . '/js/collapse.js', array(), '20201106', true );

	wp_enqueue_script( 'transit-base-template-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	/*****************************************************************
	Change this conditional if planner is used on additional pages
	*****************************************************************/
	
	if ( is_front_page() ) {
		
		$google_api_key = get_theme_mod('tb_theme_google_api_key');

		if ( ! empty( $google_api_key ) ) {
			wp_enqueue_script('google-maps', "https://maps.googleapis.com/maps/api/js?key=" . $google_api_key . "&libraries=places", array(), false, true );
		}
		
		wp_enqueue_style( 'flatpickr-styles', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
		
		wp_enqueue_script( 'flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), false, true );
		
		wp_enqueue_script( 'transit-base-template-planner', get_template_directory_uri() . '/js/planner.js', array('flatpickr'), '20171129', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'transit_base_template_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

function get_svg_icon($icon, $size="medium") {
	$icon_file = $icon . '.svg';
	printf('<span class="icon icon-%s icon-%s">', $icon, $size);
	get_template_part('images/icons/icon', $icon_file);
	echo '</span>';
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Handle Plugin Dependency
*/
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'transit_base_template_register_required_plugin');

function transit_base_template_register_required_plugin() {
	
	$plugins = array( array(
		'name'			=> 'Transit Custom Posts',
		'slug'			=> 'transit-custom-posts',
		'source'		=> 'https://github.com/trilliumtransit/transit-custom-posts/archive/master.zip',
		'required'		=> true,
		'external_url' 	=> 'https://github.com/trilliumtransit/transit-custom-posts'
	) );
	
	$config = array(
		'id'			=> 'transit-base-template',
		'default_path'	=> '',
		'menu'			=> 'tgmpa-install-plugins',
		'parent_slug'	=> 'themes.php',
		'capability'	=> 'edit_theme_options',
		'has_notices'	=> true,
		'dismissable'	=> false,
		'is_automatic'	=> true
	);
	tgmpa( $plugins, $config );
}

// Uncomment to remove the words category and archive from 
// archive page titles
// add_filter( 'get_the_archive_title', function ($title) {
// 	if ( is_category() ) {
//    		$title = single_cat_title( '', false );
// 	} elseif ( is_tag() ) {
// 		$title = single_tag_title( '', false );
// 	} elseif ( is_author() ) {
// 		$title = '<span class="vcard">' . get_the_author() . '</span>' ;
// 	}  
// 	return $title;
// });

// Uncomment to rename/change main post type to news
// add_filter( 'register_post_type_args', function( $args, $post_type ) {
	
// 	if ( 'post' == $post_type ) {
	   
// 		$args['rewrite'] = array( 
// 		   'slug' => 'news',
// 		   'with_front' => true,
// 		);
	   
// 		$args['labels']  = array(
// 		   'name'    => __('News', 'cata'),
// 		   'singular_name' => __('News', 'cata'),
// 		   'add_new' => __('Add Post', 'news', 'cata'),
// 		   'public' => true,
// 	   );

// 	}  

// 	return $args;

// }, 10, 2 );

// Uncomment to change default category 'Uncategorized' to News
// add_action('admin_init', 'cata_remove_wp_default_category' );
