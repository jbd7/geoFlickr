=== geoFlickr ===
Contributors: jbd7
Tags: flickr, geo, geotag, map, maps, google maps, google map, mapping
Requires at least: 3.0
Requires PHP: 5.3
Tested up to: 5.0.1
Stable tag: 1.02
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

geoFlickr displays a "location taken map" for all embedded Flickr photos that contain coordinates.

== Description ==

Wordpress plugin that displays a "location taken map" for all embedded Flickr photos that contain coordinates.

For every photo in a wordpress post/page that is hosted on Flickr, this plugin adds a small red balloon in the top left corner when the mouse is hovering over the photo. If the photo is geotagged on Flickr, a click on the balloon displays a pop-up featuring a Google Satellite map of the surroundings.

Thanks to Tarique Sani, author of the Flickr foto info plugin, no longer maintained and not working anymore, on which geoFlickr is based.

geoFlickr features:

*	very discrete overlay on the image
*	jQuery and thickbox
*	Most calls to the Flickr API are done on the client side - so there is minimal additional load or delay on the server
*	If your photo has geo-location data embedded, shows it as a marker on Google map with reverse geo-location to fetch the place name
*	HTTPS compatible


== Installation ==

1.	Install from your Wordpress site by adding a new plugin, search for geoFlickr

or

1.	Upload the file geoflickr.zip into the '/wp-content/plugins/' folder of your Wordpress installation
1.	Unzip the plugin to create the geoFlickr folder
1.	Activate the plugin through the 'Plugins' menu in WordPress

== Upgrade Notice ==

= 1.0 =
The old plugin Flickr foto info doesn't work anymore.
Upgrade to this one if you want to recover functionality, however, the EXIF button and HELP button have not been upgraded.


== Configuration ==

1.	To configure plugin, go to 'Settings' -> 'geoFlickr' from the Wordpress dashboard
2. 	Enter your flickr API key. The key can be obtained for free by visiting https://www.flickr.com/services/apps/

== Usage ==

There is nothing to do. Any post or page that has a photo from Flickr embedded will diplay a red balloon when hovering the mouse on the photo.
A click on that balloon will show the map.

== Thanks ==

Thanks to [tariquesani](http://www.sanisoft.com/ "tarique sani website") who developped Flickr foto info up to v1.4, up to WP3.5.2, until 2014

== Screenshots ==

1. Embedded Flickr photo on a webpage
2. Embedded Flickr photo on a webpage while mouse on photo
3. Thickbox popup containing the map where the photo was taken

== Changelog ==

= 1.02 (20181214) = 
* Tested with Wordpress 5.0.1

= 1.01 (20170410) = 
* Fixed map not loading when _content is empty

= 1.0 (20160917) = 
* Fixed old variables calls with up-to-date ones that support HTTPS
* Fixed links to Flickr since it enforced HTTPS
