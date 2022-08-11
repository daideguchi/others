<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_embed' ) )
{
/*
Plugin Name: MailPress_embed 
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/embed/
Description: Mail oEmbed ( equivalent of WordPress video embedding but for mails )
Version: 7.2
*/

class MailPress_embed
{
	public static $type = null;
	public static $mp_oembed = null;

	const meta_key = '_mp_oembed_';
	const usecache = true;
	const html_filter = 'mp_embed_oembed_html';
	const unknown = '{{unknown}}';

	function __construct()
	{
		add_action( 'save_post', 				array( __CLASS__, 'save_post' ) );

		add_action( 'MailPress_build_mail_content_start',	array( __CLASS__, 'build_mail_content_start' ) );
		add_action( 'MailPress_build_mail_content_end',		array( __CLASS__, 'build_mail_content_end' ) );
	}

	public static function save_post( $post_ID )
	{
		$post_metas = get_post_custom_keys( $post_ID );
		if ( empty( $post_metas ) )	return;

		foreach( $post_metas as $post_meta_key )
			if ( self::meta_key == substr( $post_meta_key, 0, strlen( self::meta_key ) ) )
				delete_post_meta( $post_ID, $post_meta_key );
	}

	public static function build_mail_content_start( $type )
	{
		//global $wp_embed, $mp_embed;
		//remove_filter( 'the_content', array( $wp_embed, 'autoembed' ), 8 );

		global $mp_embed;

		self::$type = $type;

		if ( 'html' == $type )
		{
			$mp_embed = new MP_Embed();
		}
	}

	public static function build_mail_content_end( $type )
	{
		//global $wp_embed, $mp_embed;
		//add_filter( 'the_content', array( $wp_embed, 'autoembed' ), 8 );

		global $mp_embed;

		if ( 'html' == $type )
		{
			remove_filter( 'MailPress_the_content', array( $mp_embed, 'autoembed' ), 8 );
			$mp_embed = self::$type = null;
		}
	}

	public static function embed_register_handler( $id, $regex, $callback, $priority = 10 )
	{
		global $mp_embed;
		$mp_embed->register_handler( $id, $regex, $callback, $priority );
	}

	public static function embed_unregister_handler( $id, $priority = 10 )
	{
		global $mp_embed;
		$mp_embed->unregister_handler( $id, $priority );
	}

	public static function require_class_oembed()
	{
		$old_file = ABSPATH . WPINC . '/class-oembed.php';
		$new_file = ABSPATH . WPINC . '/class-wp-oembed.php';

		$file = ( is_file( $new_file ) ) ? $new_file : $old_file;

		require_once ( $file );
	}

	public static function _oembed_get( $url, $args = '' )
	{
		self::require_class_oembed();
		$oembed = self::_oembed_get_object();
		return $oembed->get_html( $url, $args );
	}

	public static function _oembed_get_object() 
	{
		if ( is_null( self::$mp_oembed ) ) self::$mp_oembed = new MP_oEmbed();
		self::$mp_oembed->providers = apply_filters( 'mp_oembed_providers', self::$mp_oembed->providers );
		return self::$mp_oembed;
	}

	public static function _oembed_add_provider( $format, $provider, $regex = false )
	{
		self::require_class_oembed();
		$oembed = self::_oembed_get_object();
		$oembed->providers[$format] = array( $provider, $regex );
	}

	public static function _embed_get( $data )
	{
		$out  = '';

		$out .= '<a target="_blank" href="' . esc_url( $data->url ) . '"';
		$out .= ' title="' . esc_attr( $data->title ) . '"';
		$out .= '>';

		$out .= '<img';
		$out .= ' class="mp_'. $data->provider_name . '"';
		$out .= ' width="' . $data->thumbnail_width . 'px"';
		$out .= ' height="' . $data->thumbnail_height . 'px"';
		$out .= ' src="' . $data->thumbnail_url . '"';
		$out .= ' title="' . esc_attr( $data->title ) . '" alt="' . esc_attr( $data->title ) . '"';
		$out .= ' />';

		$out .= '</a>';

		return $out;
	}
}
new MailPress_embed();
}