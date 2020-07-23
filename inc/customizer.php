<?php
/**
 * Transit Base Template Theme Customizer
 *
 * @package Transit_Base_Template
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function transit_base_template_customize_register( $wp_customize ) {

	// Add customizer section for transit base theme options
	$wp_customize->add_section( 'tb_theme_options_section', array(
        'title'      => 'Transit Base Theme Options',
		'capability' => 'edit_theme_options',
		'priority'   => 30
	) );
	
   // Field and control for Google API key
	$wp_customize->add_setting('tb_theme_google_api_key', array(
		'default'           =>'',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('tb_theme_google_api_key_control', array(
		'label'    =>'Google Trip Planner API Key',
		'type'     =>'text',
		'section'  =>'tb_theme_options_section',
		'settings' =>'tb_theme_google_api_key',
	));

	// Field and control for Interactive Map key
	$wp_customize->add_setting('tb_theme_interactive_map_key', array(
		'default'           =>'',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('tb_theme_interactive_map_key_control', array(
		'label'    =>'Interactive Map Key',
		'type'     =>'text',
		'section'  =>'tb_theme_options_section',
		'settings' =>'tb_theme_interactive_map_key',
	));

    // Add Custom CSS section to customizer 
	$wp_customize->add_section( 'custom_css', array(
		'title' => __( 'Custom CSS' ),
		'description' => __( 'Add custom CSS here' ),
		'panel' => '', // Not typically needed.
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	  ) );

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'transit_base_template_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'transit_base_template_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'transit_base_template_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function transit_base_template_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function transit_base_template_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function transit_base_template_customize_preview_js() {
	wp_enqueue_script( 'transit-base-template-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'transit_base_template_customize_preview_js' );
