<?php

function _walk(&$value, $key) {
    if (is_array($value))
        array_walk($value, '_walk');
    else
        $value = stripslashes($value);
}

function _clean_options(&$options) {
    array_walk($options, '_walk');
}

function get_google_fonts() {
    $fonts_json = include TT_FW_DIR . '/static/google_fonts.php';
    return json_decode($fonts_json);
}

function seek_multidim_array($haystack, $needle) { // function to return the value of a key from a multidimensional array - mostly used by get_option method
    foreach ($haystack as $key => $value) {
        if ($key === $needle) {
            return $value;
            break;
        } elseif (is_array($value)) {
            $found = seek_multidim_array($value, $needle);
            if (!empty($found)) {
                return $found;
            }
        }
    }
}

function seek_multidim_array_all($haystack, $needle) { // function to return ALL VALUES of a same key from a multidimensional array - mostly used to insert default values in DB at theme init
    $found = '';
    foreach ($haystack as $key => $value) {
        $seek = FALSE;
        if ($key === $needle) {
            return $value . " "; //delimiter for implode latter used
        } elseif (is_array($value)) {
            $seek = seek_multidim_array_all($value, $needle);
            if (!empty($seek) && $seek != '') {
                $found .= $seek;
            }
        }
    }
    if (!empty($found)) {
        return $found;
    } else
        return FALSE;
}

function seek_options($haystack, $needles) { // function to return ALL VALUES of a same key from a multidimensional array - mostly used to insert default values in DB at theme init
    $found = '';
    foreach ($haystack as $key => $value) {
        $seek = FALSE;
        if ($key === $needles) {
            $result = $value . " "; //delimiter for implode latter used
            if (array_key_exists('font_changer', $haystack) && !empty($haystack['font_changer']))
                $result .= $value . " " . $value . "_font ";
            if (array_key_exists('color_changer', $haystack) && !empty($haystack['color_changer']))
                $result .= $value . " " . $value . "_color ";
            if (array_key_exists('font_size_changer', $haystack) && !empty($haystack['font_size_changer']))
                $result .= $value . " " . $value . "_size ";
            if (array_key_exists('icons', $haystack) && !empty($haystack['icons']))
                $result .= $value . " " . $value . "_icon ";
            return $result;
        }elseif (is_array($value)) {
            $seek = seek_options($value, $needles);
            if (!empty($seek) && $seek != '') {
                $found .= $seek;
            }
        }
    }
    if (!empty($found)) {
        return $found;
    } else
        return FALSE;
}

function _get_theme_options() {
    global $tt_theme_options;
    if (is_null($tt_theme_options)) {
        $tt_theme_options = get_option(THEME_OPTIONS);
        $tt_theme_options = unserialize($tt_theme_options);
    }
    return $tt_theme_options;
}

function _go($option_key) { // get admin options by array id
    _get_theme_options();
    global $tt_theme_options;
    if (isset($tt_theme_options[$option_key]))
        return $tt_theme_options[$option_key];
    else
        return NULL;
}

function _gall() {
    _get_theme_options();
    global $tt_theme_options;
    return $tt_theme_options;
}

//Function to escape html tags if text is wrapped in " [ html ] "
function escape_html($html) {
    if (preg_match("@\[([^\]]+)\]@is", $html, $match))
        if (isset($match[1])) {
            $html = preg_replace("#\[([^\]]+)\]#is", htmlspecialchars($match[1]), $html);
        }
    return $html;
}

//does the same as escape_html() only that it echoes the result
function escape_htmle($html) {
    echo escape_html($html);
}

// Start - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.
//Function to render gmap
//function _gmap($container_id){
//  $zoom_lvl = (_go('contact_map_zoom') != '')? _go('contact_map_zoom') : 4;
//  $coords = (_go('contact_map_coords') != '')? _go('contact_map_coords') : "42.60,-41.16";
//  $marker_coords = (_go('contact_map_marker_coords') != '')? _go('contact_map_marker_coords') : "";
//  $icon = (_go('contact_map_icon') != '')? _go('contact_map_icon') : "";
//return "<script type='text/javascript'>
//          function initialize() {
//            var mapOptions = {
//                      center: new google.maps.LatLng($coords),
//                      zoom:$zoom_lvl,
//                      mapTypeId: google.maps.MapTypeId.ROADMAP
//                    };
//                    var map = new google.maps.Map(document.getElementById('$container_id'),mapOptions);
//                    marker = new google.maps.Marker({
//                      map:map,
//                      animation: google.maps.Animation.DROP,
//                      position: new google.maps.LatLng($marker_coords),
//                      icon:'$icon'
//                    });
//                }
//                google.maps.event.addDomListener(window, 'load', initialize);
//              </script>";
//}
// End - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.