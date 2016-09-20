<?php
	require_once( dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type='text/javascript' src='<?php echo get_option('siteurl'); ?>/wp-includes/js/jquery/jquery.js'></script>

<script type="text/javascript">

$j=jQuery.noConflict();


var api_key = "<?php echo get_option('geoflickr_flickrapikey') ?>";

var centerLatitude = 44.339206;
var centerLongitude = 1.208160;
var description = '';

var startZoom = 13;

var map;



function geoflickr_init() {	    	
    $j.getJSON('https://api.flickr.com/services/rest/?&method=flickr.photos.geo.getLocation&api_key='+api_key+'&photo_id=<?php echo $_GET['flickr_id']; ?>&format=json&jsoncallback=?',
        function(geodata){
			if(geodata.stat != 'fail') { 
				centerLatitude  = geodata.photo.location.latitude;
				centerLongitude = geodata.photo.location.longitude;

				if (geodata.photo.location.locality){
					description += geodata.photo.location.locality._content+", "
				}

				if (geodata.photo.location.county){
					description += geodata.photo.location.county._content+", "
				}
				description += "<br/>"+geodata.photo.location.region._content+", "+geodata.photo.location.country._content+". <p style='font-size: 6pt' >Location description as supplied by Flickr. May be incomplete or inaccurate!</p>";

				var latlng = new google.maps.LatLng(centerLatitude, centerLongitude);
				var mapOptions = {
					zoom: startZoom,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.HYBRID
				};

    				map = new google.maps.Map(document.getElementById("geoflickr_map"),mapOptions);

				var infowindow = new google.maps.InfoWindow({
					    content: description
				});

				var marker = new google.maps.Marker({position:latlng, map:map, title: "Click for address"});

				google.maps.event.addListener(marker, 'click', function() {
  					infowindow.open(map,marker);
				});

			} else {
				errorhtml = "<h1>Sorry! Cannot show location map</h1>";
				errorhtml += "<p>Additionally Flickr said: "+geodata.message+"</p>";
				
				$j("#geoflickr_map").html(errorhtml);
			}		
    	}
    );
}

   
window.onload = geoflickr_init;

</script>

<style>

body {
	font-family: sans-serif;
	margin:0px;
	padding:0px;
	text-align: center;	
}

h1 {
	text-align: center;
	margin: 0px;
	font-family: sans-serif;
}

</style>

</head>

<body>
    <div id="geoflickr_map" style="width: 628px; height: 410px"></div>
</body>

</html>

