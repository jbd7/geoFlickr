=== GeoFlickr ===
Contributors: jbd7
Tags: flickr, map, geotagged, gps, geolocation
Tested up to: 6.6
Stable tag: 1.4
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Donate link: https://www.buymeacoffee.com/jbd7

GeoFlickr displays a map of the location where the photo was taken, for all embedded Flickr photos that contain GPS coordinates.

== Description ==

GeoFlickr is a Wordpress plugin that displays a map of the location where the photo was taken, for all embedded Flickr photos that contain GPS coordinates.

For every photo in a wordpress post/page that is hosted on Flickr, this plugin adds a small red balloon in the top left corner when the mouse is hovering over the photo. If the photo is geotagged on Flickr, meaning it contains GPS coordinates in the EXIF metadata, a click on the balloon displays a pop-up featuring a Google Satellite map of the surroundings.

Thanks to Tarique Sani, author of the Flickr foto info plugin, no longer maintained and not working anymore, on which GeoFlickr is based.

GeoFlickr features:

*	very discrete overlay on the image
*	jQuery and thickbox
*	Most calls to the Flickr API are done on the client side - so there is minimal additional load or delay on the server
*	If your photo has geo-location data embedded, shows it as a marker on Google map with reverse geo-location to fetch the place name
*	HTTPS compatible


== Installation ==

1.	Install from your Wordpress site by adding a new plugin, search for GeoFlickr

or

1.	Upload the file geoflickr.zip into the '/wp-content/plugins/' folder of your Wordpress installation
1.	Unzip the plugin to create the GeoFlickr folder
1.	Activate the plugin through the 'Plugins' menu in WordPress

== Upgrade Notice ==

= 1.0 =
The old plugin Flickr foto info doesn't work anymore.
Upgrade to this one if you want to recover functionality, however, the EXIF button and HELP button have not been upgraded.


== Configuration ==

1.	To configure plugin, go to 'Settings' -> 'GeoFlickr' from the Wordpress dashboard
2. 	Enter your flickr API key. The key can be obtained for free by visiting https://www.flickr.com/services/apps/
3.  Enter your Google Maps API key. The key can be set up, for free up to a certain threshold, via https://console.cloud.google.com/google/maps-apis/ by following https://support.google.com/googleapi/answer/6158862

== Usage ==

Any post or page of the Wordpress site, that contains a photo embedded from Flickr, will diplay a red balloon when hovering the mouse on the photo. The balloon will show only if the image has EXIF GPS coordinates on Flickr. A click on that balloon will show the map inside a Thickbox popup.

The plugin automatically considers all posts and pages.

== Thanks ==

Thanks to [tariquesani](http://www.sanisoft.com/ "tarique sani website") who developped Flickr foto info up to v1.4, up to WP3.5.2, until 2014.

== Screenshots ==

1. Embedded Flickr photo on a webpage
2. Embedded Flickr photo on a webpage while mouse on photo
3. Thickbox popup containing the map where the photo was taken

== Changelog ==

= 1.4 (20241030) =
* Tested with Wordpress 6.6
* Security fixes

= 1.3 (20230401) = 
* Tested with Wordpress 6.2
* Added customization parameters: height offset, excluded classes
* Made Thickbox responsive for narrow and mobile browsing
* Hidden scrollbars on the Thickbox while the Google Map is loading

= 1.2 (20230212) = 
* Tested with Wordpress 6.1.1
* Updated API call to Google Maps
* Added handling of response cases from the Flickr API 

= 1.1 (20210908) = 
* Tested with Wordpress 5.8
* Ensured compatibility with lazy-loaded images
* Added a loading wheel before the map is displayed

= 1.02 (20181214) = 
* Tested with Wordpress 5.0.1

= 1.01 (20170410) = 
* Fixed map not loading when _content is empty

= 1.0 (20160917) = 
* Fixed old variables calls with up-to-date ones that support HTTPS
* Fixed links to Flickr since it enforced HTTPS
