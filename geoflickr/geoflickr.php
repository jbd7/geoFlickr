<?php

	/*
	 Plugin Name: GeoFlickr
	 Plugin URI: https://github.com/jbd7/geoFlickr/
	 Description: Displays a "location taken map" for all embedded Flickr photos that contain coordinates.
	 Author: jbd7
	 Version: 1.1
	 */

	# Thanks to the original author of Flickr foto info: Tarique Sani (www.sanisoft.com)
	
	# Uncomment the next two lines to see error messages if things fail...
	# error_reporting(E_ALL);
	# ini_set("display_errors", 1);


	add_action('admin_menu', 'geoflickr_config_page');
	add_action('admin_init', 'geoflickr_admininit' );


	function geoflickr_load_scripts() {
			wp_enqueue_script('thickbox');
			wp_enqueue_script('jquery');
			$geoflickr_flickrToolbarJs = plugin_dir_url( __FILE__ ) . 'js/geoflickr_toolbar.js';
			wp_register_script('geoflickr_flickrToolbarJs', $geoflickr_flickrToolbarJs, array('jquery') );
			
			$translation_array = array(
				//'flickr_api_key' => get_option('geoflickr_flickrapikey'),
				//'google_api_key' => get_option('geoflickr_googleapikey'),
				'geoflickrplugindirurl' => plugin_dir_url( __FILE__ )
				);

			wp_localize_script( 'geoflickr_flickrToolbarJs', 'geoflickr_vars', $translation_array );

			wp_enqueue_script( 'geoflickr_flickrToolbarJs', '', array(), null, true);
		

	}



	function geoflickr_load_styles() {
			wp_enqueue_style('thickbox');
			$geoflickr_flickrToolbarCss =  plugin_dir_url( __FILE__ ) . 'css/geoflickr_toolbar.css';
			wp_register_style('geoflickr_flickrToolbarCss', $geoflickr_flickrToolbarCss);
			wp_enqueue_style( 'geoflickr_flickrToolbarCss');
	}


	add_action('wp_enqueue_scripts','geoflickr_load_styles');
	add_action('wp_enqueue_scripts','geoflickr_load_scripts');


	function geoflickr_register_query_vars( $vars ) {
		$vars[] = 'geoflickr_id';
		return $vars;
	}
	add_filter( 'query_vars', 'geoflickr_register_query_vars' );



	function geoflickr_load_map( $template ) {
		$geoflickr_id = get_query_var( 'geoflickr_id' );
		if ('' != $geoflickr_id) {
			$template = dirname( __FILE__ ) . '/map.php';
		}
		return $template;
	}
	add_filter( 'single_template', 'geoflickr_load_map');
	add_filter( 'page_template', 'geoflickr_load_map');

        //Functions for settings page

	function geoflickr_admininit(){
		register_setting( 'geoflickr_plugin_options', 'geoflickr_flickrapikey');
		register_setting( 'geoflickr_plugin_options', 'geoflickr_googleapikey');
	}


	function geoflickr_config_page() {
		add_options_page(__('GeoFlickr'), __('GeoFlickr'), 'manage_options', __FILE__, 'geoflickr_options_page');
	}

	function geoflickr_options_page() {
	?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>GeoFlickr by <a href="https://github.com/jbd7/geoFlickr/" target="_blank">jbd7</a></h2>
			<form method="post" action="options.php">
				<?php settings_fields('geoflickr_plugin_options'); ?>
				<?php $optionsflickr = get_option('geoflickr_flickrapikey'); ?>
				<?php $optionsgoogle = get_option('geoflickr_googleapikey'); ?>
				<table class="form-table">
					<tr>
						<th scope="row">Flickr API Key</th>
						<td>
							<input type="text" size="57" name="geoflickr_flickrapikey" value="<?php echo $optionsflickr; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Enter your Flickr API key which you can find on the <a href="https://www.flickr.com/services/apps/" target="_blank">Flickr API page</a>. If you don't have one yet, you can request an API key from the <a href='http://www.flickr.com/services/apps/create/apply/' target="_blank">Flickr App Garden</a>. It's free for non-commercial websites.
						</td>
					</tr>
					<tr>
						<th scope="row">Google API Key</th>
						<td>
							<input type="text" size="57" name="geoflickr_googleapikey" value="<?php echo $optionsgoogle; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Can be left blank, but Google recommends one for Maps API v3.</br>Enter your Google API key enabled for Maps, which can be requested via <a href="https://developers.google.com/maps/documentation/geocoding/get-api-key" target="_blank">Google Developers</a>. It's free up to USD 200 of monthly usage, which covers about 1000 GeoFlickr requests per day.
						</td>
					</tr>
				</table>
				<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
	</div>
	<?php
	}


	add_filter( 'plugin_action_links', 'geoflickr_plugin_action_links', 10, 2 );

	// Display a Settings link on the main Plugins page

	function geoflickr_plugin_action_links( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$geoflickr_posk_links = '<a href="'.get_admin_url().'options-general.php?page=geoflickr/geoflickr.php">'.__('Settings').'</a>';
			// make the 'Settings' link appear first
			array_unshift( $links, $geoflickr_posk_links );
		}

		return $links;
	}

