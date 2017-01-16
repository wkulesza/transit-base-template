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
	echo 'Agency information is automatically updated from the GTFS feed. However, you may update it here to change how it is displayed, and add optional fields such as an agency description and mission statement.';
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
			'classes' => '',
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
			'classes' => '',
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
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked( $value[ array_search( $key, $value, true ) ], $key, false ), $label, $iterator );
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
	$upload_dir = get_template_directory()."/transit-modules/transit-data/";
	//Name of the feed; Will rename downloaded feed
	$feed_name = "gtfs-feed.zip";
	if (!file_exists( $upload_dir )) {
		mkdir( $upload_dir );
	}
	try {
		file_put_contents($upload_dir.$feed_name, file_get_contents($new_feed));
	} catch( Exception $ex ) {
		add_settings_error('gtfs_feedurl_notice', 'gtfs_feed_url_notice', 'ERROR downloading GTFS Feed. Please check URL.', 'error');
		return;
	}
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
	foreach ($agencyFile as $line) {
		var_dump(str_getcsv($line));
	}	
} 

/**
 * Display the GTFS Update settings pagea
 */
function nwota_gtfs_update_page() {
	?>
	<div class="wrap">
		<h2>GTFS Site Update</h2>
		<strong>Do not perform an update if you are not sure what you are doing.</strong>
		<br />
		<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
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
					<input type="hidden" name="page" value="<?php echo get_template_directory();?>/functions.php">
					<input type="hidden" name="update" value="true" />
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" value="GTFS Update" class="button button-primary"/>
			</p>
		</form>	
		<?php	
		if(isset($_GET['update'])) {  //
			if(! isset($_GET['backup'])) {
				echo '<br /><strong>Please verify you have backed up the site first.</strong>';
			} else {
				echo '<br /><br />Updating...';
				nwota_gtfs_update();
			}
		}
	echo '</div>';
}

function nwota_gtfs_update() {
	
}


/*
function trillium_gtfs_update_settings_page() {
?>
	<div class="wrap">
	<h1>GTFS Site Update</h1>
	<h2>Synch Site with Live GTFS Data</h2>
	<strong>DO NOT PERFORM AN UPDATE IF YOU ARE UNSURE OF WHAT YOU ARE DOING.</strong>
	<br />
	<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
		<label for="backup">I verify that I have backed up the site before proceeding</label><input type="checkbox" id="backup" name="backup" value="true" /><br />
		<input type="hidden" name="page" value="<?php echo get_template_directory();?>/functions.php">
		<input type="hidden" name="update" value="true" />
		<input type="submit" value="GTFS Update" />
	</form>	
	<?php	
	if(isset($_GET['update'])) {  //
		if(! isset($_GET['backup'])) {
			echo '<br /><strong>Please verify you have backed up the site first.</strong>';
		} else {
			echo '<br /><br />Updating...';
			gtfs_update();
		}
	}	
}

function gtfs_update() {
	//The download link for the zipped GTFS feed
	$feed_download = "http://data.trilliumtransit.com/gtfs/madera-ca-us/madera-ca-us.zip";
	echo "<br />Downloading feed from: ".$feed_download."<br/>";
	//The directory to upload transit data into
	$upload_dir = get_template_directory()."/library/transit-data/";
	//Name of the feed; Will rename downloaded feed
	$feed_name = "madera-ca-us.zip";
	file_put_contents($upload_dir.$feed_name, file_get_contents($feed_download));
	$zip = new ZipArchive;
	$res = $zip->open($upload_dir.$feed_name);
	if ($res === TRUE ) {
		$zip->extractTo($upload_dir);
		$zip->close();
	} else {
		echo '<strong>ERROR OPENING FEED</strong>';
		return;
	}
	
	$handle = fopen($upload_dir."/routes.txt", "r");
	if (! $handle) {
		echo "<strong>ERROR opening routes.txt</strong>";
		return;
	}
	$line_count = 0;
	while (($line = fgets($handle)) !== FALSE) {
		//Skip the column headers (i.e. the first line of the file)
		if ($line_count == 0) {
			$line_count++;
			continue;
		}
		$line_split_by_quotes = explode("\"", $line);
		$line    		= $line_split_by_quotes[0].$line_split_by_quotes[sizeof($line_split_by_quotes)-1];		
		$splitLine          = explode(",", $line);
		$agency_id          = $splitLine[0];
		$route_id           = $splitLine[1];
		$route_short_name   = $splitLine[2];
		$route_long_name    = $splitLine[3];
		$route_desc    		= $splitLine[4]; //implode('"',array_slice($line_split_by_quotes,1,sizeof($line_split_by_quotes)-2));
		$route_type 		= $splitLine[5];
		$route_url		 	= $splitLine[6];
		$route_color 		= '#' . $splitLine[7];
		$route_text_color 	= preg_replace('/^\s+|\n|\r|\s+$/m', '', $splitLine[8]); // strips line break on last entry
		$route_sort_order 	= $splitLine[9]; // strips line break on last entry
		
		$tag_name = str_replace(" ", "_", strtolower($route_long_name));
		
		if ($route_long_name == "") {
			continue;
		}
		
		//Check if the route post already exists. If not, create new route
		$post_to_update_id = null;
		$args = array(
			'post_type'		=> 'route',
			'numberposts'	=> 1,
			'post_status'	=> 'publish',
			'meta_key'		=> 'route_id',
			'meta_value'	=> $route_id
		);
		$route_exists = get_posts( $args );
		if ( $route_exists ) {
			$post_to_update_id = $route_exists[0]->ID;
			echo '<br />updating ' . $route_long_name;
			$updated = array(
				'ID'			=> $post_to_update_id,
				'post_title'	=> $route_long_name,
				'post_name'		=> $tag_name		
			);
			wp_update_post( $updated );
		} else {
			echo '<br />adding ' . $route_long_name;
		
			$my_post = array(
			  'post_title'    	=> $route_long_name,
			  'post_name' 		=> $tag_name,
			  'post_status'  	=> 'publish',
			  'post_type'      	=> 'route',
			  'post_author'   	=> 1
			);
			// Insert the post into the database
			$post_to_update_id = wp_insert_post( $my_post );
		}
		
		update_field('field_582b7ee44819c', $route_id, $post_to_update_id); 
		update_field('field_5826588ad1c81', $route_short_name, $post_to_update_id); 
		update_field('field_582658aad1c82',$route_long_name, $post_to_update_id); 
		update_field('field_582658b1d1c83', $route_desc, $post_to_update_id); 
		update_field('field_582658c3d1c84', $route_color, $post_to_update_id);
		update_field('field_5841caa65fc32', floatval($route_sort_order), $post_to_update_id);
		
		/*
		update_field('field_557b451a67dc8', $route_id, $post_to_update_id); 
		update_field('field_557b458667dc9', $route_short_name, $post_to_update_id); 
		update_field('field_557b459067dca',$route_long_name, $post_to_update_id); 
		update_field('field_557b459867dcb', $route_desc, $post_to_update_id); 
		update_field('field_557b45b367dcd', $route_text_color, $post_to_update_id); 
		update_field('field_557b45a067dcc', $route_color, $post_to_update_id); 
		update_field('field_5593f0425947f', floatval($route_sort_order), $post_to_update_id); 
		$line_count++;

	}
	echo "<br /><strong>Site Update Complete</strong>";	
}
*/
