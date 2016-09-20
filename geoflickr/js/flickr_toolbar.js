$j = jQuery.noConflict();

re = new RegExp('<img.+src=[\'"].*flickr.com\/.*\/([^\'"]+)_.*([^(_s|_t|_m)])\.jpg[\'"].*>', 'i');

toolbar_div = "";

$j(document).ready(function () {

    toolbar_div = $j("<div class='geoflickr_flickr-toolbar'></div>");
    $j('body').append(toolbar_div);

    flickr_images = $j("img[src *='flickr']");

    $j(flickr_images).each(function () {

        $j(this).hover(function () {
            img_html = $j('<div>').append($j(this).clone()).remove().html()
            matches = re.exec(img_html);
            if (matches) {
                show_toolbar(matches[1], $j(this).offset());
            }
        }, function () {
            $j('.geoflickr_flickr-toolbar').hide();
        })
    })
})


function geoflickr_show_toolbar(flickr_id, image_offset) {
  /* Adjust balloon position if a toolbar takes up height space at the top of the webpage */

  adjustment = 0; 
  if (document.getElementById('wprmenu_bar') != null) {
            adjustment += document.getElementById('wprmenu_bar').offsetHeight;
     }
  if (document.getElementById('wpadminbar') != null) {
            adjustment += document.getElementById('wpadminbar').offsetHeight;
     }

    toolbar_top = parseInt(image_offset.top) + 10 - adjustment;
    toolbar_left = parseInt(image_offset.left) + 10;

    toolbar_html = "<a href='" + pluginurl + "/geoflickr/map.php?api_key=" + api_key + "&flickr_id=" + flickr_id + "&TB_iframe=true&height=400&width=600' class='thickbox' ><img title='Location' alt='Location' src='" + pluginurl + "/geoflickr/images/red_marker.16.png' ></a>"

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

    // tb_init('a.thickbox');

}
