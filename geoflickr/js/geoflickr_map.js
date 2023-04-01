function geoflickr_init(flickr_api_key, flickr_id) {	    	
	$j=jQuery.noConflict();
	var centerLatitude = 44.339206;
	var centerLongitude = 1.208160;
	var description = '';
	var startZoom = 13;
	var map;

	$j.getJSON('https://api.flickr.com/services/rest/?&method=flickr.photos.geo.getLocation&api_key=' + flickr_api_key + '&photo_id=' + flickr_id + '&format=json&jsoncallback=?',
		{ 'User-Agent': 'GeoFlickr/1.3' },
        function(geodata){
			if(geodata.stat != 'fail' && flickr_id) { 
				centerLatitude  = geodata.photo.location.latitude;
				centerLongitude = geodata.photo.location.longitude;

				if (geodata.photo.location.locality){
					description += geodata.photo.location.locality._content+", "
				}

				if (geodata.photo.location.county){
					description += geodata.photo.location.county._content+", "
				}
				
				if (geodata.photo.location.region){
					description += geodata.photo.location.region._content+", "
				}				
				
				if (geodata.photo.location.country){
					description += geodata.photo.location.country._content
				}				
				
				description += "<br/>"+". <p style='font-size: 6pt' >(Location description may be incomplete or inaccurate)</p>";

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

			} else if (geodata.stat == 'fail' && ! /^\d+$/.test(flickr_id)) {
				// flickr_id not made of digits, something went off.
				errorhtml = '<h2 style="color:grey;">Could not load map</h2>';
				errorhtml += '<p style="color:grey;">Flickr Image ID format incorrect. Please notify the webmaster.</p>';
				
				$j("#geoflickr_map").html(errorhtml);
	
			} else if (geodata.stat == 'fail' && flickr_id) {
				// Flickr API call failed despite a Photo_id. Flickr Error codes: https://www.flickr.com/services/api/flickr.photos.geo.getLocation.htm
				// Error sample: {"stat":"fail","code":100,"message":"Invalid API Key (Key has invalid format)"}
				// */
				errorhtml = '<h2 style="color:grey;">Could not load map</h2>';
				errorhtml += '<p style="color:grey;">Additionally, <a style="color:grey;" href="//www.flickr.com/services/api/flickr.photos.geo.getLocation.htm">Flickr API</a> said: ' + geodata.message + '</p>';
				
				$j("#geoflickr_map").html(errorhtml);
	
			} else {
				// Fallback. Flickr API call didn't respond, something may be off with the Photo_id.
				errorhtml = '<h2 style="color:white; visibility: none;">Location map loading ...</h2>';
				errorhtml += '<p style="color:white; visibility: none;">Additionally, <a style="color:white;" href="//www.flickr.com/services/api/flickr.photos.geo.getLocation.htm">Flickr API</a> is saying: ' + geodata.message + '</p>';
				
				$j("#geoflickr_map").html(errorhtml);
			}		
    	}
    );
}