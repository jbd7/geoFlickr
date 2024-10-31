$j = jQuery.noConflict();

// Regular expression with the pattern of Flickr images
const re = new RegExp('<img.+src=[\'"].*flickr.com\/.*\/([^\'"]+?)_.*([^(_s|_t|_m)])\.jpg[\'"].*>', 'i');

var toolbar_div = "";

$j(document).ready(geoflickr_findimages);

// Find Flickr images when scrolling has stopped - from https://gomakethings.com/detecting-when-a-visitor-has-stopped-scrolling-with-vanilla-javascript/

	// Setup isScrolling variable
	var isScrolling;

	// Listen for scroll events
	window.addEventListener('scroll', function ( event ) {

		// Clear our timeout throughout the scroll
		window.clearTimeout( isScrolling );

		// Set a timeout to run after scrolling ends
		isScrolling = setTimeout(function() {

			// Run the callback
			//console.log( "GeoFlickrDebug: " + 'GeoFlickr Scrolling has stopped.' );
			geoflickr_findimages();
		}, 1001);

	}, false);


function geoflickr_findimages() {

    toolbar_div = $j("<div class='geoflickr_flickr-toolbar'></div>");
    $j('body').append(toolbar_div);

	// Fetches excluded classes, set in the plugin settings, from wordpress options
	let excluded_classes;
	if (typeof geoflickr_vars.geoflickrexcludedclasses !== "undefined") {
		excluded_classes = geoflickr_vars.geoflickrexcludedclasses.split(' ')
								  .concat(' nogeoflickr')
								  .map(className => className.trim())
								  .filter(Boolean);
	} else {
		excluded_classes = 'nogeoflickr';
	}
	
	
	// Fetches required classes, set in the plugin settings, from wordpress options
	let required_classes;
	if (typeof geoflickr_vars.geoflickrrequiredclasses !== "undefined") {
		required_classes = geoflickr_vars.geoflickrrequiredclasses.split(' ')
								  .map(className => className.trim())
								  .filter(Boolean);
	} else {
		required_classes = '';
	}

	// console.log("GeoFlickrDebug: Excluded classes: " + excluded_classes);
	// console.log("GeoFlickrDebug: Required classes: " + required_classes);


	// Find images with flickr in the img tag
	let flickr_images = $j("img[src*='flickr'], img[data-src*='flickr']");


	// console.log("GeoFlickrDebug: All Flickr images: ");
	// console.log(flickr_images);

	// If there is one or more required class, we only fetch these
	if (required_classes && required_classes.length > 0) {
	  flickr_images = flickr_images.filter(function() {
		const $this = $j(this);
		const $parentFigure = $this.closest("figure");
		const hasRequiredClass = required_classes.some(className => $this.hasClass(className) || $parentFigure.hasClass(className));
		return hasRequiredClass;
	  });
	}
	
	// console.log("GeoFlickrDebug: Required Flickr images: ");
	// console.log(flickr_images);
	

	// Excludes images that have excluded classes in that <img> tag or in the parent <figure> tag
	let filtered_images = flickr_images.filter(function() {
		const $this = $j(this);
		const hasExcludedClass = excluded_classes.some(className => $this.hasClass(className) || $this.closest('figure').hasClass(className));
		return !hasExcludedClass;
	  });


	// console.log("GeoFlickrDebug: After Excluded Images: ");
	// console.log(filtered_images);
	
	// Iterates through found images and add the toolbar
    $j(filtered_images).each(function () {

        $j(this).hover(function () {
            img_html = $j('<div>').append($j(this).clone()).remove().html()
            matches = re.exec(img_html);
            if (matches) {
                geoflickr_show_toolbar(matches[1], $j(this).offset());
            }
        }, function () {
            $j('.geoflickr_flickr-toolbar').hide();
        })
    })
		
}


function geoflickr_show_toolbar(flickr_id, image_offset) {
  /* Adjust balloon position if a toolbar takes up height space at the top of the webpage */

  var adjustment = 0; 
  if (document.getElementById('wprmenu_bar') != null) {
            adjustment += document.getElementById('wprmenu_bar').offsetHeight;
     }
  if (document.getElementById('wpadminbar') != null) {
            adjustment += document.getElementById('wpadminbar').offsetHeight;
     }
  if (geoflickr_vars.geoflickrverticaloffset != null && parseInt(geoflickr_vars.geoflickrverticaloffset)) {
            adjustment += parseInt(geoflickr_vars.geoflickrverticaloffset);
     }
	
	// console.log("GeoFlickrDebug: vert offset = " + geoflickr_vars.geoflickrverticaloffset + " and adjustment is " + adjustment);
	
    const toolbar_top = parseInt(image_offset.top) + 10 - adjustment;
    const toolbar_left = parseInt(image_offset.left) + 10;

	// console.log(("GeoFlickrDebug: window.innerWidth = " + window.innerWidth);
	
	let iframeWidth = 600; // Set the default width for desktop devices
	if (window.innerWidth <= 640 && window.innerWidth > 50) {
	  iframeWidth = window.innerWidth - 40; // Adjust the width for mobile devices
	}
	// TB width will have 29px added, height have 12 px added.
    const toolbar_html = "<a href='?geoflickr_id=" + flickr_id + "&_wpnonce=" + geoflickr_vars.nonce + "&TB_iframe=true&height=400&width=" + iframeWidth + " ' class='thickbox' ><img title='Location' alt='Location' src='" + geoflickr_vars.geoflickrplugindirurl + "images/red_marker16.png' ></a>"

    $j(toolbar_div).html(toolbar_html).css({
        left: toolbar_left + 'px',
        top: toolbar_top + 'px'
    });

    $j(toolbar_div).show();

    //Prevent the toolbar flickr when hovered upon
    $j(toolbar_div).hover(function () {
        $j(this).show()
    }, function () {
        $j(this).hide()
    });

}