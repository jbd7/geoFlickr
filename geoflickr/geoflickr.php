<?php

	/*
	 * Plugin Name: GeoFlickr
	 * Plugin URI: https://www.wordpress.org/plugins/geoflickr/
	 * Description: GeoFlickr displays a map of the location where the photo was taken, for all embedded Flickr photos that contain GPS coordinates.
	 * Author: jbd7
	 * Author URI: https://github.com/jbd7
	 * License: GPL-3.0-or-later
	 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
	 * Version: 1.41
	 * Requires at least: 5.0
	 * Requires PHP: 5.3
	 * 
	 * Copyright (c) 2016 - 2023 jbd7. All rights reserved.
	 * 
	 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
	 * 
	 * You should have received a copy of the GNU General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.
	 */	 

	# Thanks to the original author of Flickr foto info: Tarique Sani (www.sanisoft.com)
	
	# Uncomment the next two lines to see error messages if things fail...
	# error_reporting(E_ALL);
	# ini_set("display_errors", 1);

	define('GEOFLICKR_VERSION', '1.41'); // Use this constant wherever versioning is needed

	add_action('admin_menu', 'geoflickr_config_page');
	add_action('admin_init', 'geoflickr_admininit' );


	function geoflickr_load_scripts() {
			wp_enqueue_script('thickbox');
			wp_enqueue_script('jquery');
			$geoflickr_flickrToolbarJs = plugin_dir_url( __FILE__ ) . 'js/geoflickr_toolbar.js';
			wp_register_script('geoflickr_flickrToolbarJs', $geoflickr_flickrToolbarJs, array('jquery'), GEOFLICKR_VERSION, false);
			
			$translation_array = array(
				//'flickr_api_key' => get_option('geoflickr_flickrapikey'),
				//'google_api_key' => get_option('geoflickr_googleapikey'),
				'geoflickrexcludedclasses' => get_option('geoflickr_excludedclasses'),
				'geoflickrrequiredclasses' => get_option('geoflickr_requiredclasses'),
				'geoflickrverticaloffset' => get_option('geoflickr_verticaloffset'),
				'geoflickrplugindirurl' => plugin_dir_url( __FILE__ ),
				'geoflickr_version' => GEOFLICKR_VERSION, // Plugin version
				'nonce' => wp_create_nonce('geoflickr_nonce_action')
				);

			wp_localize_script( 'geoflickr_flickrToolbarJs', 'geoflickr_vars', $translation_array );

			wp_enqueue_script('geoflickr_flickrToolbarJs', '', array('jquery'), GEOFLICKR_VERSION, true);

		

	}



	function geoflickr_load_styles() {
			wp_enqueue_style('thickbox');
			$geoflickr_flickrToolbarCss =  plugin_dir_url( __FILE__ ) . 'css/geoflickr_toolbar.css';
			wp_register_style('geoflickr_flickrToolbarCss', $geoflickr_flickrToolbarCss, array(), GEOFLICKR_VERSION);
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
		register_setting( 'geoflickr_plugin_options', 'geoflickr_excludedclasses');
		register_setting( 'geoflickr_plugin_options', 'geoflickr_requiredclasses');
		register_setting( 'geoflickr_plugin_options', 'geoflickr_verticaloffset');

	}




	function geoflickr_config_page() {
		add_options_page(
			__('GeoFlickr', 'geoflickr'),
			__('GeoFlickr', 'geoflickr'),
			'manage_options',
			'geoflickr_options',
			'geoflickr_options_page'
		);
	}

	function geoflickr_options_page() {
	?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>GeoFlickr by <a href="https://github.com/jbd7/geoFlickr/" target="_blank">jbd7</a></h2>
		<hr>
		<p>GeoFlickr is aimed at Flickr photographers who are also WordPress bloggers, and who geotag their photos on Flickr.<br>
		<hr>
			<form method="post" action="options.php">
				<?php settings_fields('geoflickr_plugin_options'); ?>
				<?php $geoflickr_optionsflickr = get_option('geoflickr_flickrapikey'); ?>
				<?php $geoflickr_optionsgoogle = get_option('geoflickr_googleapikey'); ?>
				<?php $geoflickr_excludedclasses = get_option('geoflickr_excludedclasses'); ?>
				<?php $geoflickr_requiredclasses = get_option('geoflickr_requiredclasses'); ?>
				<?php $geoflickr_verticaloffset = get_option('geoflickr_verticaloffset'); ?>
				<table class="form-table">
					<tr>
						<th scope="row">Flickr API Key</th>
						<td>
							<input type="text" size="57" name="geoflickr_flickrapikey" value="<?php echo esc_attr($geoflickr_optionsflickr); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Enter your Flickr API key which you can find on the <a href="https://www.flickr.com/services/apps/" target="_blank">Flickr API page</a>.<br>If you don't have one yet, you can request an API key from the <a href='http://www.flickr.com/services/apps/create/apply/' target="_blank">Flickr App Garden</a>. It's free for non-commercial websites and takes a minute to obtain.
						</td>
					</tr>
					<tr>
						<th scope="row">Google API Key (optional)</th>
						<td>
							<input type="text" size="57" name="geoflickr_googleapikey" value="<?php echo esc_attr($geoflickr_optionsgoogle); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Can be left blank, but Google recommends one for Maps API v3.<br>Enter your Google API key enabled for Maps, which can be requested via <a href="https://developers.google.com/maps/documentation/geocoding/get-api-key" target="_blank">Google Developers</a>. It's free up to USD 200 of monthly usage, which covers about 1000 GeoFlickr requests per day.
						</td>
					</tr>
					<tr>
						<th scope="row">Excluded classes (optional)</th>
						<td>
							<input type="text" size="57" name="geoflickr_excludedclasses" value="<?php echo esc_attr($geoflickr_excludedclasses); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Space-separated list of classes for <code>&lt;img&gt;</code> or a parent <code>&lt;figure&gt;</code> tag, on which GeoFlickr will not attach a location balloon.<br>
						Can be left blank. Regardless of this field, images with the class <code>nogeoflickr</code> are automatically excluded.
						</td>
					</tr>
					<tr>
						<th scope="row">Required classes (optional)</th>
						<td>
							<input type="text" size="57" name="geoflickr_requiredclasses" value="<?php echo esc_attr($geoflickr_requiredclasses); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Space-separated list of classes for <code>&lt;img&gt;</code> or a parent <code>&lt;figure&gt;</code> tag, on which GeoFlickr will exclusively attach a location balloon.<br>
						If left blank, GeoFlickr will attach the location balloon to all Flickr images found on the website.<br>
						If not blank, GeoFlickr will only consider Flickr images with the Required classes, minus the Flickr images with the Excluded  classes.
						</td>
					</tr>
					<tr>
						<th scope="row">Vertical offset (optional)</th>
						<td>
							<input type="number" size="57" name="geoflickr_verticaloffset" value="<?php echo esc_attr($geoflickr_verticaloffset); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Offset (pixels) to add to the balloon, to adjust it vertically over a Flickr image. Can be left blank.<br>Use this to compensate for your layout if the ballons do not appear on the top left corner of images (e.g. a site banner added by a plugin). A positive value positions the ballon higher on the page, a negative value positions it lower.
						</td>
					</tr>
				</table>
				<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'geoflickr'); ?>" />
				</p>
			</form>
	</div>
	<?php
	}


	add_filter( 'plugin_action_links', 'geoflickr_plugin_action_links', 10, 2 );

	// Display a Settings link on the main Plugins page

	function geoflickr_plugin_action_links( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$geoflickr_posk_links = '<a href="' . get_admin_url() . 'options-general.php?page=geoflickr_options">' . __('Settings', 'geoflickr') . '</a>';

			// make the 'Settings' link appear first
			array_unshift( $links, $geoflickr_posk_links );
		}

		return $links;
	}
	
	
	add_filter( 'plugin_row_meta', 'geoflickr_plugin_row_meta', 10, 2 );

	// Display links under plugin name

	function geoflickr_plugin_row_meta( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$geoflickr_pluginpage_link = '<a target="_blank" href="https://wordpress.org/plugins/geoflickr/">'.__('Visit plugin site', 'geoflickr').'</a>';
			$geoflickr_donate_link = '<a target="_blank" href="https://www.buymeacoffee.com/jbd7">'.__('Donate', 'geoflickr').'</a>';
			array_push( $links, $geoflickr_pluginpage_link );
			array_push( $links, $geoflickr_donate_link );
		}

		return $links;
	}
