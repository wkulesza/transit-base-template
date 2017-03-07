<?php

/**
 * Various GTFS Utilites to extract information from the agency GTFS data
 * to populate the site and create route posts
 *
 * @package NWOTA
 */

/*
 * Create the admin page for managing GTFS information and settings
 */
function nwota_gtfs_settings_page() {
	add_menu_page('GTFS Settings', 'GTFS Settings', 'manage_options', 'gtfs_fields', 'nwota_settings_page_content', 'dashicons-location');
	add_submenu_page('gtfs_fields', 'GTFS Update', 'GTFS Update', 'manage_options', 'gtfs_update_page', 'nwota_gtfs_update_page');
}
add_action( 'admin_menu', 'nwota_gtfs_settings_page');

function nwota_settings_page_content() {
	?>
	<div class="wrap">
		<h2>GTFS Information and Settings</h2>
		<?php settings_errors(); ?>
		<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
				<form method="post" action="options.php">
					<?php
					settings_fields('gtfs_url');
					do_settings_sections('gtfs_url');
					submit_button();
					?>
				</form>
			</div>
		</div>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'gtfs_fields' );
			do_settings_sections( 'gtfs_fields' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

add_action( 'admin_init', 'nwota_setup_sections');

function nwota_setup_sections() {
	add_settings_section( 'display_options', 'Display Options', 'nwota_display_options', 'gtfs_fields');
	add_settings_section( 'agency_information', 'Agency Information', 'nwota_agency_information', 'gtfs_fields');
	add_settings_section( 'add_gtfs_url', 'Set GTFS Feed', 'nwota_gtfs_feed', 'gtfs_url');
}

function nwota_gtfs_feed() {
	echo '<p class="about-description">Your feed will be used to populate the fields below.</p>';
}

function nwota_display_options() {
	echo 'Change display preferences for imported GTFS information';
}

function nwota_agency_information() {
	echo 'Some agency information is automatically updated from the GTFS feed. However, you may update it here to change how it is displayed, and add optional fields such as an agency description and mission statement.';
}

add_action( 'admin_init', 'nwota_setup_fields' );

/*
 * Create all options to save. Add additional fields to the settings page
 * here. Many but not all are populated from the GTFS feed. Setup code
 * adapted from https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/
 */
function nwota_setup_fields() {
	$fields = array(
		array(
			'uid' 		=> 'route_display', 	// unique id
			'label' 	=> 'Route Display',		// field label
			'section'	=> 'display_options',	// display section
			'type'		=> 'select',			// input type
			'options'	=> array(
				'long_name' => 'Long Name',
				'short_name' => 'Short Name',
				'circle_name' => 'Route Circle + Name',
			),
			'placeholder' => '',				// placeholder text
			'helper'	=> '',					// displayed on right
			'supplemental' => 'Choose how the route name should be displayed in menus and titles',				// display below field
			'default' => 'long_name',			// default value
			'settings' => 'gtfs_fields',		// which settings form
			'classes' => '',					// form field classes 
		),
		array(
			'uid' 		=> 'use_route_circles',
			'label' 	=> 'Use Route Circles',
			'section'	=> 'display_options',
			'type'		=> 'radio',
			'options'	=> array(
			    'true'    => 'Yes',
                'false'   => 'No',
			),
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => 'Only select "Yes" if routes are numbered and use the
                number in the "route short name" field.',
			'default' => 'false',
			'settings' => 'gtfs_fields',
			'classes' => '',
		),
		array(
			'uid' 		=> 'google_api_key',
			'label' 	=> 'Google API Key',
			'section'	=> 'display_options',
			'type'		=> 'text',
			'options'	=> false,
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => 'Required to use planner autocomplete and embedded google maps.',
			'default' => '',
			'settings' => 'gtfs_fields',
			'classes' => 'regular-text',
		),
		array(
			'uid' 		=> 'agency_name',
			'label' 	=> 'Agency Name',
			'section'	=> 'agency_information',
			'type'		=> 'text',
			'options'	=> false,
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => '',
			'default' => '',
			'settings' => 'gtfs_fields',
			'classes' => 'regular-text',
		),
		array(
			'uid' 		=> 'agency_number',
			'label' 	=> 'Phone Number',
			'section'	=> 'agency_information',
			'type'		=> 'text',
			'options'	=> false,
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => '',
			'default' => '',
			'settings' => 'gtfs_fields',
			'classes' => '',
		),
		array(
			'uid' 		=> 'agency_email',
			'label' 	=> 'Contact E-mail',
			'section'	=> 'agency_information',
			'type'		=> 'email',
			'options'	=> false,
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => '',
			'default' => '',
			'settings' => 'gtfs_fields',
			'classes' => 'regular-text',
		),
		array(
			'uid' 		=> 'agency_description',
			'label' 	=> 'Description',
			'section'	=> 'agency_information',
			'type'		=> 'textarea',
			'options'	=> false,
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => '',
			'default' => '',
			'settings' => 'gtfs_fields',
			'classes' => '',		
		),
		array(
			'uid' 		=> 'agency_mission',
			'label' 	=> 'Mission Statement',
			'section'	=> 'agency_information',
			'type'		=> 'textarea',
			'options'	=> false,
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => '',
			'default' => '',
			'settings' => 'gtfs_fields',	
			'classes' => '',	
		),
		array(
			'uid' 		=> 'gtfs_feedurl',
			'label' 	=> 'GTFS Feed URL',
			'section'	=> 'add_gtfs_url',
			'type'		=> 'text',
			'options'	=> false,
			'placeholder' => '',
			'helper'	=> '',
			'supplemental' => '',
			'default' => '',
			'settings' => 'gtfs_url',
			'classes' => 'regular-text',		
		),
	);
	foreach ( $fields as $field ) {
		add_settings_field( $field['uid'], $field['label'], 'nwota_field_callback', $field['settings'], $field['section'], $field);
		register_setting( $field['settings'], $field['uid'] );
	}
}

/**
 * Print an appropriately formatted form field
 *
 * @param array $arguments Arguments for setting up a form field
 */
function nwota_field_callback( $arguments ) {
    $value = get_option( $arguments['uid'] ); 
    if( ! $value ) { 
       $value = $arguments['default']; 
   }
// Check which type of field we want
switch( $arguments['type'] ){
            case 'text':
            case 'password':
            case 'number':
			case 'email' :
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" class="%5$s"/>', $arguments['uid'], $arguments['type'], $arguments['placeholder'], esc_attr($value), $arguments['classes'] );
                break;
            case 'textarea':
                printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], esc_textarea($value) );
                break;
            case 'select':
            case 'multiselect':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $arguments['options'] as $key => $label ){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value, $key, false ), $label );
                    }
                    if( $arguments['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
                }
                break;
            case 'radio':
            case 'checkbox':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked( $value, $key, false ), $label, $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
                break;
        }

// If there is help text
   if( $helper = $arguments['helper'] ){
       printf( '<span class="helper"> %s</span>', $helper ); 
   }

// If there is supplemental text
   if( $supplemental = $arguments['supplemental'] ){
       printf( '<p class="description">%s</p>', $supplemental );
   }
}

/*
 * Action hook whenever the GTFS Feed URL is added or updated
 */
add_action('add_option_gtfs_feedurl', 'nwota_update_options');
add_action('update_option_gtfs_feedurl', 'nwota_update_options');

/**
 * Download the GTFS feed to transit-modules/transit-data and
 * update all gtfs options fields
 */
function nwota_update_options() {
	$new_feed = esc_url( get_option('gtfs_feedurl') );
    // This is the directory for keeping the GTFS feed data. Should be located inside the theme.
    // If changed, also update it nwota_gtfs_update()
	$upload_dir = get_template_directory()."/transit-modules/transit-data/";
    // Feed may be renamed to anything, not important. Will be unzipped momentarily.
	$feed_name = "gtfs-feed.zip";
	if ( !file_exists( $upload_dir ) ) {
		mkdir( $upload_dir );
	}
    // Ensure input is a well-formed URL
    if (!filter_var($new_feed, FILTER_VALIDATE_URL)) {
		add_settings_error('gtfs_feedurl_notice', 'gtfs_feed_url_notice', 'ERROR downloading GTFS Feed. Please check URL.', 'error');
		return;
    }
    if ( !($gtfs_feed = file_get_contents($new_feed, true)) ) {
		add_settings_error('gtfs_feedurl_notice', 'gtfs_feed_url_notice', 'ERROR downloading GTFS Feed. Please check URL.', 'error');
		return;
    }
    file_put_contents($upload_dir.$feed_name, $gtfs_feed);
	$zip = new ZipArchive;
	$res = $zip->open( $upload_dir.$feed_name );
	if ($res === TRUE ) {
		$zip->extractTo( $upload_dir );
		$zip->close();
	} else {
		add_settings_error('gtfs_feedurl_notice', 'gtfs_feed_url_notice', 'ERROR downloading GTFS Feed. Please check URL.', 'error');
		return;
	}
	$agencyFile = file( $upload_dir . 'agency.txt');
    // This assumes only one agency is in agency.txt. Must be modified to handle GTFS for multi-agency site
    // Also assumes order of columns in agency.txt
	$agencyInfo = str_getcsv($agencyFile[1]);
    // Get the 2nd column from agency.txt, which is agency_name
	update_option('agency_name',$agencyInfo[1]);
    // get the 5th column from agency.txt, which is agency_number
	update_option('agency_number',$agencyInfo[4]);	
	add_settings_error('gtfs_feedurl_notice', 'gtfs_feed_url_notice', 'Update successful. You may update route information by performing GTFS Update now.', 'updated');
} 

/**
 * Display the GTFS Update settings page
 */
function nwota_gtfs_update_page() {
	?>
	<div class="wrap">
		<h2>GTFS Site Update</h2>
		<strong>Do not perform an update if you are not sure what you are doing.</strong>
		<br />
		<form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="backup">I verify that I have backed up the site before proceeding</label>
						</th>
						<td>
							<input type="checkbox" id="backup" name="backup" value="true" />
						</td>
					</tr>
                    <input type="hidden" name="gtfsupdate_noncename" id="gtfsupdate_noncename" value="<?php echo wp_create_nonce( 'gtfs-update' )?>">
					<input type="hidden" name="action" value="nwota_gtfs_update" />
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" value="GTFS Update" class="button button-primary"/>
			</p>
		</form>	
		<?php	
		if(isset($_GET['submit_status'])) {  //
            if( $_GET['submit_status'] == '100' ) {
                echo '<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"><p>';
                echo 'Submission Error: Illegal request.';
                echo '</p></div>';
            }
            if( $_GET['submit_status'] == '101' ) {
                echo '<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"><p>';
                echo "Submission Error: Insufficient permissions. Please contact your admin.";
                echo '</p></div>';
            }
            if( $_GET['submit_status'] == '102' ) {
                echo '<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"><p>';
                echo "Submission Error: Please confirm you have backed up site.";
                echo '</p></div>';
            }
            if( $_GET['submit_status'] == '103' ) {
                echo '<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"><p>';
                echo "Submission Error: Routes not set up for this theme.";
                echo '</p></div>';
            }
            if( $_GET['submit_status'] == '104' ) {
                echo '<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"><p>';
                echo "Submission Error: Please set GTFS feed correctly in GTFS settings first.";
                echo '</p></div>';
            }
            if( $_GET['submit_status'] == '200' ) {
                echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p>';
                echo "GTFS Update Success. Please ensure <strong>Routes</strong> contain correct information.";
                echo '</p></div>';
            }
		}
	echo '</div>';
}

add_action( 'admin_action_nwota_gtfs_update','nwota_gtfs_update' );

/* 
 * Create and update route custom posts from GTFS data
 */
function nwota_gtfs_update() {
    // Ensure request came from correct screen
    if ( !wp_verify_nonce( $_POST['gtfsupdate_noncename'], 'gtfs-update' )) {
        wp_redirect( $_SERVER['HTTP_REFERER'] . '&submit_status=100');
        exit();
    }
    // Ensure user has Admin capabilities
    if ( !current_user_can( 'update_core')) {
        wp_redirect( $_SERVER['HTTP_REFERER'] . '&submit_status=101');
        exit();
    }
    // Ensure backup was checked
	if(! isset($_POST['backup'])) {
        wp_redirect( $_SERVER['HTTP_REFERER'] . '&submit_status=102');
        exit();
	} 
    // Ensure this theme is actually using custom Route types
	if ( !post_type_exists( 'route' ) ) {
        wp_redirect( $_SERVER['HTTP_REFERER'] . '&submit_status=103');
        exit();
	}
    // Ensure transit data exists
    $gtfs_file = get_template_directory()."/transit-modules/transit-data/routes.txt";
    
    if ( !file_exists( $gtfs_file ) ) {
        wp_redirect( $_SERVER['HTTP_REFERER'] . '&submit_status=104');
        exit();
    }
    // Once validated, perform GTFS Update
    // Map column headers to key=>value pairs
    $gtfs_data = array_map('str_getcsv', file($gtfs_file));
    $header = array_shift($gtfs_data);
    array_walk($gtfs_data, '_combine_array', $header);
    
    foreach( $gtfs_data as $ind=>$route ) {
        // If route_long_name exists, use it as the default name for post title and name
        $default_name = ($route['route_long_name'] == "") ? $route['route_short_name'] : $route['route_long_name'];
        $tag_name = str_replace(" ", "_", strtolower($default_name));
        $route_id = $route['route_id'];
        	
		//Check if the route post already exists. If not, create new route
		$post_to_update_id = null;
		$args = array(
			'post_type'		=> 'route',
			'numberposts'	=> 1,
			'post_status'	=> 'publish',
			'meta_key'		=> 'route_id',
			'meta_value'	=> $route_id,
		);
		$route_exists = get_posts( $args );
		if ( $route_exists ) {
			$post_to_update_id = $route_exists[0]->ID;
			$updated = array(
				'ID'			=> $post_to_update_id,
				'post_title'	=> $default_name,
				'post_name'		=> $tag_name		
			);
			wp_update_post( $updated );
		} else {
		
			$my_post = array(
			  'post_title'    	=> $default_name,
			  'post_name' 		=> $tag_name,
			  'post_status'  	=> 'publish',
			  'post_type'      	=> 'route',
			  'post_author'   	=> 1
			);
			// Insert the post into the database
			$post_to_update_id = wp_insert_post( $my_post );
		}
        // Update route meta fields from GTFS data
        foreach ( $route as $key=>$value ) {
            if ( $key != "" ) {
                update_post_meta($post_to_update_id, $key, $value);  
            }          
        }       
	}
    
    wp_redirect( $_SERVER['HTTP_REFERER'] . '&submit_status=200');
    exit();
}

// Array combine solution from dejiakala@gmail.com
function _combine_array(&$row, $key, $header) {
  $row = array_combine($header, $row);
}