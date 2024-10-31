# GeoFlickr
GeoFlickr is a WordPress plugin that displays a map of the location where the photo was taken, for all embedded Flickr photos that contain GPS coordinates.

For every photo in a WordPress post/page that is hosted on Flickr, this plugin adds a small red balloon in the top left corner when the mouse is hovering over the photo. If the photo is geotagged on Flickr, a click on the balloon displays a pop-up featuring a Google Satellite map of the surroundings.

Thanks to Tarique Sani, author of the Flickr-foto-info plugin, no longer maintained and not working anymore, on which geoFlickr is based.

GeoFlickr features:
- very discrete overlay on the image
- jQuery and thickbox
- Most calls to the Flickr API are done on the client side - so there is minimal additional load or delay on the server
- If your photo has geo-location data embedded, shows it as a marker on Google map with reverse geo-location to fetch the place name
- HTTPS compatible
