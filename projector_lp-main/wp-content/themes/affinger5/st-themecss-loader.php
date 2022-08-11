<?php

header_remove( 'Last-Modified' );
header( 'Content-Type: text/css; charset=utf-8' );
header( 'Expires: Wed, 11 Jan 1984 05:00:00 GMT' );
header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
header( 'Pragma: no-cache' );

include_once( dirname( __FILE__ ) . '/../../../wp-load.php' );

require( dirname( __FILE__ ) . '/st-themecss-variables.php' );

$style = (string) filter_input( INPUT_GET, 'style' );

if ( $style === 'block-editor-style' ) {
	include( dirname( __FILE__ ) . '/block-editor-style.php' );
} elseif ( isset( $GLOBALS['stdata240'] ) && trim( $GLOBALS['stdata240'] ) === 'yes' ) {
	switch ( true ) {
		case ( $style === 'customcss' ):
			echo wp_get_custom_css();

			break;

		default:
			include( dirname( __FILE__ ) . '/st-themecss.php' );

			break;
	}
}else{
	include( dirname( __FILE__ ) . '/st-themecss.php' );
}
