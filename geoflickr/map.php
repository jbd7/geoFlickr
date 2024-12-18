<?php
/**
* Template Name: Photo location map
*
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin-top:0px!important">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!-- page title, displayed in your browser bar -->
<title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?></title>

  <script type="text/javascript">
    // Define the callback function for the Google Maps API, triggers when the GMap is loaded
	function geoflickr_hideloader() {
		// Not needed, #loader is still showing.
	}
  </script>	
	
<?php

function geoflickr_load_mapcss() {
	//Deregister styles that may conflict with the blank template
	global $wp_styles;
    	$wp_styles->queue = array();
	//Enqueue blank template style
	$geoflickr_flickrMapCss = plugin_dir_url( __FILE__ ) . 'css/geoflickr_map.css';
	wp_register_style('geoflickr_flickrMapCss', $geoflickr_flickrMapCss, array(), GEOFLICKR_VERSION);
	wp_enqueue_style( 'geoflickr_flickrMapCss');
	}

function geoflickr_load_mapjs() {
	//Enqueue jQuery for use of geoflickr_map.js
	wp_enqueue_script('jquery');

	
	//Enqueue geoflickr_map
	$geoflickr_flickrMapJs = plugin_dir_url( __FILE__ ) . 'js/geoflickr_map.js';
	/* Defer true, and Dependency on googlemaps as geoflickr_init has a call to google */
	wp_register_script('geoflickr_flickrMapJs', $geoflickr_flickrMapJs, array('jquery', 'thickbox'), GEOFLICKR_VERSION, false);
	wp_enqueue_script( 'geoflickr_flickrMapJs');	
	
	if (file_exists('/wp-content/plugins/wp-responsive-menu/assets/js/wprmenu.js')) {
        wp_enqueue_script('wprmenu.js');
    }
	
	//Prepare and enqueue the Google Maps API
	$google_js_url = "https://maps.googleapis.com/maps/api/js";
	$google_api_key = get_option('geoflickr_googleapikey');
	if ($google_api_key !== '') {$google_js_url .= "?key=" . $google_api_key. "&callback=geoflickr_hideloader";}
	wp_enqueue_script('geoflickr_googlemaps', $google_js_url, array(), GEOFLICKR_VERSION, false);



}


add_action('wp_enqueue_scripts','geoflickr_load_mapcss', 99);
add_action('wp_enqueue_scripts','geoflickr_load_mapjs', 99);


wp_head();
	
?>

</head>

<body>
	<div id="loader" style="text-align: center; margin: auto;"></div>

	<div id="geoflickr_map"></div>
	
	
	<script type="text/javascript">
		
		var flickr_api_key = "<?php echo esc_js(get_option('geoflickr_flickrapikey')); ?>";
		// var flickr_id = "<?php echo (isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'geoflickr_nonce_action') && isset($_GET['geoflickr_id'])) ? esc_js(sanitize_text_field(wp_unslash($_GET['geoflickr_id']))) : ''; ?>";

		<?php
		$geoflickr_id = isset($_GET['geoflickr_id']) ? sanitize_text_field(wp_unslash($_GET['geoflickr_id'])) : '';
		$geoflickr_id = preg_replace('/\D/', '', $geoflickr_id); // Remove all non-digit characters
		?>
		var flickr_id = "<?php echo esc_js($geoflickr_id); ?>";

	    var geoflickr_version = "<?php echo esc_js(GEOFLICKR_VERSION); ?>";


		window.onload = function() {
			// Adapts window to smaller screens
			var mapWidth = (window.parent.innerWidth <= 640 && window.parent.innerWidth > 50) ? window.parent.innerWidth - 40 + 28 - 46 : 628;
			// console.log("Found innerWidth of " + window.innerWidth + " and window.parent.innerWith of " +  window.parent.innerWidth);
			document.getElementById("geoflickr_map").style.width = mapWidth + "px";
			document.getElementById("geoflickr_map").style.height = "412px";
			// Prevents the thicbox to show scrollbars while the GMap is loading
			if (window.parent.document.getElementById('TB_iframeContent')) {
				window.parent.document.getElementById('TB_iframeContent').setAttribute('scrolling', 'no');
			}
			
			// Loads the Google Map
			geoflickr_init(flickr_api_key, flickr_id, geoflickr_version);
			
			// Hides the loader
			var loader = document.querySelector('#loader');
			loader.style.display = 'none';

		};
		
	</script>

</body>

</html>