function geoflickr_init(flickr_api_key, flickr_id) {	    	
	$j=jQuery.noConflict();
	var centerLatitude = 44.339206;
	var centerLongitude = 1.208160;
	var description = '';
	var startZoom = 13;
	var map;

	$j.getJSON('https://api.flickr.com/services/rest/?&method=flickr.photos.geo.getLocation&api_key=' + flickr_api_key + '&photo_id=' + flickr_id + '&format=json&jsoncallback=?',
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