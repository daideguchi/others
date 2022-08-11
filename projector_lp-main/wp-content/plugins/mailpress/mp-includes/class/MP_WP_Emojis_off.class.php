<?php

class MP_WP_Emojis_off
{
	function __construct() 
	{
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_action( 'embed_head', 'print_emoji_detection_script' );

		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		add_filter( 'tiny_mce_plugins', array( __CLASS__, 'tiny_mce_plugins' ) );
		add_filter( 'wp_resource_hints', array( __CLASS__, 'wp_resource_hints' ), 10, 2 );
	}

	public static function tiny_mce_plugins( $plugins ) 
	{
		if ( is_array( $plugins ) ) return array_diff( $plugins, array( 'wpemoji' ) );
		return $plugins;
	}

	public static function wp_resource_hints( $urls, $relation_type )
	{
		if ( 'dns-prefetch' == $relation_type ) 
		{
			$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
			foreach ( $urls as $key => $url ) if ( strpos( $url, $emoji_svg_url_bit ) !== false ) unset( $urls[$key] );
		}
		return $urls;
	}
}