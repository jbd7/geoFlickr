<?php
/**
* Template Name: Blank Page
*
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin-top:0px!important">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!-- page title, displayed in your browser bar -->
<title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?></title>

<?php

function geoflickr_load_mapcss() {
	//Deregister styles that may conflict with the blank template
	global $wp_styles;
    	$wp_styles->queue = array();
	//Enqueue blank template style
	$geoflickr_flickrMapCss = plugin_dir_url( __FILE__ ) . 'css/geoflickr_map.css';
	wp_register_style('geoflickr_flickrMapCss', $geoflickr_flickrMapCss);
	wp_enqueue_style( 'geoflickr_flickrMapCss');
	}

function geoflickr_load_mapjs() {
	//Enqueue jQuery for use of geoflickr_map.js
	wp_enqueue_script('jquery');

	//Prepare and enqueue the Google Maps API
	$google_js_url = "https://maps.google.com/maps/api/js";
	$google_api_key = get_option('geoflickr_googleapikey');
	if ($google_api_key !== '') {$google_js_url .= "?key=" . $google_api_key;}
	wp_enqueue_script( 'geoflickr_googlemaps', $google_js_url);

	//Enqueue geoflickr_map
	$geoflickr_flickrMapJs = plugin_dir_url( __FILE__ ) . 'js/geoflickr_map.js';
	wp_register_script('geoflickr_flickrMapJs', $geoflickr_flickrMapJs, array('jquery', 'thickbox'));
	wp_enqueue_script( 'geoflickr_flickrMapJs');
	wp_enqueue_script( 'wprmenu.js');
	}


add_action('wp_enqueue_scripts','geoflickr_load_mapcss', 99);
add_action('wp_enqueue_scripts','geoflickr_load_mapjs', 99);


wp_head();
	
?>
	
</head>

<body>
	<div id="loader"></div>
	

	<div id="geoflickr_map" style="width: 628px; height: 410px"></div>
	<script type="text/javascript">
		var flickr_api_key = "<?php echo get_option('geoflickr_flickrapikey') ?>";
		var flickr_id = <?php echo $_GET['geoflickr_id']; ?>;
		window.onload = geoflickr_init(flickr_api_key, flickr_id);
		
		$j(window).load(function() {
    		$j('#loader').hide();
  		});
		
	</script>

</body>

</html>