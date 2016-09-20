<?php

	/*
	 Plugin Name: geoFlickr
	 Plugin URI: https://github.com/jbd7/geoFlickr/
	 Description: Displays a "location taken map" for all embedded Flickr photos that contain coordinates.
	 Author: jbd7
	 Version: 1.0
	 */

	# Thanks to the original author of Flickr foto info: Tarique Sani (www.sanisoft.com)
	
	# Uncomment the next two lines to see error messages if things fail...
	# error_reporting(E_ALL);
	# ini_set("display_errors", 1);



	add_action('admin_menu', 'geoflickr_config_page');

	add_action('admin_init', 'geoflickr_init' );

	add_action('wp_print_scripts','geoflickr_myscriptvars');

	function geoflickr_myscriptvars() {
	?>
	<script type="text/javascript">
		var api_key = "<?php echo get_option('geoflickr_flickrapikey') ?>";
		var pluginurl = "<?php echo plugins_url() ?>";
	</script>
	<?php
	}


	function geoflickr_load_scripts() {
			wp_enqueue_script('thickbox');
			$geoflickr_flickrToolbarJs =  plugins_url() . '/geoflickr/js/flickr_toolbar.js';
			wp_register_script('geoflickr_flickrToolbarJs', $geoflickr_flickrToolbarJs);
			wp_enqueue_script( 'geoflickr_flickrToolbarJs');
	}



	function geoflickr_load_styles() {
			wp_enqueue_style('thickbox');
			$geoflickr_flickrToolbarCss =  plugins_url() . '/geoflickr/css/flickr_toolbar.css';
			wp_register_style('geoflickr_flickrToolbarCss', $geoflickr_flickrToolbarCss);
			wp_enqueue_style( 'geoflickr_flickrToolbarCss');
	}


	add_action('wp_print_styles','geoflickr_load_styles');
	add_action('wp_print_scripts','geoflickr_load_scripts');

	add_action('wp_footer', 'geoflickr_load_tb_fix');


	function geoflickr_load_tb_fix() {
			echo "\n" . '<script type="text/javascript">tb_pathToImage = "' . get_option('siteurl') . '/wp-includes/js/thickbox/loadingAnimation.gif"; tb_closeImage = "' . get_option('siteurl') . '/wp-includes/js/thickbox/tb-close.png";</script>'. "\n";
			echo '<style> #TB_title { background-color:#101010; height:27px; } </style>';
	}



        //Functions for settings page

	function geoflickr_init(){
		register_setting( 'geoflickr_plugin_options', 'geoflickr_flickrapikey');
	}


	function geoflickr_config_page() {
		add_options_page(__('geoFlickr'), __('geoFlickr'), 'manage_options', __FILE__, 'geoflickr_options_page');
	}


	function geoflickr_options_page() {
	?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>geoFlickr by <a href="https://github.com/jbd7/geoFlickr/" target="_blank">jbd7</a></h2>
			<form method="post" action="options.php">
				<?php settings_fields('geoflickr_plugin_options'); ?>
				<?php $options = get_option('geoflickr_flickrapikey'); ?>
				<table class="form-table">
					<tr>
						<th scope="row">Flickr API Key</th>
						<td>
							<input type="text" size="57" name="geoflickr_flickrapikey" value="<?php echo $options; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>
						Enter your Flickr API key which you can find on the <a href="https://www.flickr.com/services/apps/" target="_blank">Flickr API page</a>. If you don't have one yet, you can request an API key from the <a href='http://www.flickr.com/services/apps/create/apply/' target="_blank">Flickr App Garden</a>. It's free for non-commercial websites.
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
