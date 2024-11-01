<?php
/*
Plugin Name: stormia
Plugin URI: http://wordpress.org/plugins/stormia
Description: Show your visitors an interactive live weather radar map with beautiful animations of rain, snow, clouds and thunder! To embed Stormia, simply use this shortcode: [stormia width="800" height="500" lat="40.71" lon="-74.01"]
Version: 1.0.0
Author: windria
Author URI: https://stormia.io
License: GPLv3
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function stormia_embed_shortcode( $atts, $content = null ) {
	$defaults = array(
    'url' => 'map', // using geolocation (default behavior of no url is provided)
		'width' => '800',
		'height' => '500',
    'layer' => 'rain,',
    'zoom' => '5',
    'frameborder' => '0'
	);

	foreach ( $defaults as $default => $value ) { // add defaults
		if ( ! @array_key_exists( $default, $atts ) ) { // mute warning with "@" when no params at all
			$atts[$default] = $value;
		}
	}
  
  if(array_key_exists('lat', $attrs) && array_key_exists('lon', $attrs)) {
    $latlong = '&lat='.$attrs['lat'].'&lon='.$attrs['lon'];
  } else {
    $latlong = '';
  }

	$html .= '<iframe src="https://stormia.io/embed?l='.$attrs["layer"].'&z='.$attrs["zoom"].$latlong.'" style="width:100%;border:0;margin-bottom:0;" height="'.$atts["height"].'" frameborder="'.$atts["frameborder"].'"></iframe><div style="width:100%;text-align:right;">';

	return $html;
}
add_shortcode( 'stormia', 'stormia_embed_shortcode' );


function stormia_plugin_meta( $links, $file ) {
	if ( strpos( $file, 'iframe.php' ) !== false ) {
		$links = array_merge( $links, array( '<a href="https://www.stormia.io/embed" title="Iframe Builder">Map Builder</a>' ) );
		$links = array_merge( $links, array( '<a href="https://www.stormia.io/" title="Live Radar Map">Live Radar Map</a>' ) );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'stormia_plugin_meta', 10, 2 );
