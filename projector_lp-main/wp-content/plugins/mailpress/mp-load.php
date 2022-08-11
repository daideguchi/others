<?php
/**
 * Bootstrap file for 
		1. setting some constants
		2. loading pluggable functions

 * If the mailpress-config.php file is not found then default constant values apply.

**/

// 1.

/** Plugin version. */
require_once ( ABSPATH . 'wp-admin/includes/plugin.php' );
$plugin_data = get_plugin_data( MP_ABSPATH . 'MailPress.php' );
define ( 'MP_Version',	 $plugin_data['Version'] );

/** Loading optional mailpress-config.php file in current directory or parent directory */
$mp_config = 'mailpress-config.php';
foreach ( array( MP_ABSPATH . $mp_config, dirname( MP_ABSPATH ) . '/' . $mp_config ) as $mp_file )
{
	if ( !is_file( $mp_file ) )
	{
		continue;
	}
	require_once( $mp_file );
	break;
}

/** enqueue scripts for form widget. */
defined( 'MP_wp_enqueue_script' ) 	or define ( 'MP_wp_enqueue_script',	true );

/** Folder name of MailPress 'mp-content'. */
defined( 'MP_CONTENT_FOLDER' ) 		or define ( 'MP_CONTENT_FOLDER',	'mp-content' );

/** Absolute path to the MailPress 'mp-content' folder. */
defined( 'MP_CONTENT_DIR' ) 		or define ( 'MP_CONTENT_DIR',		MP_ABSPATH . MP_CONTENT_FOLDER . '/' );

/** Relative path to the MailPress 'mp-content' folder. */
defined( 'MP_PATH_CONTENT' ) 		or define ( 'MP_PATH_CONTENT',		MP_PATH . MP_CONTENT_FOLDER . '/' );

/** Absolute path to the MailPress Uploads directory. */
global $wpdb;
$uds = wp_upload_dir();
$ubd = $uds['basedir'];
$ubu = $uds['baseurl'];

$tail = '/sites/' . get_current_blog_id();
if ( strrpos( $ubd, $tail ) && ( strlen( $ubd ) == ( strlen( substr( $ubd, 0, strrpos( $ubd, $tail ) ) ) + strlen( $tail ) ) ) )
{
	$ubd = substr( $ubd, 0, strrpos( $ubd, $tail ) );
	$ubu = substr( $ubu, 0, strrpos( $ubu, $tail ) );
}
else
{
	$tail = '/' . get_current_blog_id();
	if ( strrpos( $ubd, $tail ) && ( strlen( $ubd ) == ( strlen( substr( $ubd, 0, strrpos( $ubd, $tail ) ) ) + strlen( $tail ) ) ) )
	{
		$ubd = substr( $ubd, 0, strrpos( $ubd, $tail ) );
		$ubu = substr( $ubu, 0, strrpos( $ubu, $tail ) );
	}
}

define ( 'MP_UPL_ABSPATH',	untrailingslashit( $ubd ) . '/mailpress/' );
define ( 'MP_UPL_URL',	untrailingslashit( $ubu ) . '/mailpress/' );
define ( 'MP_UPL_PATH', str_replace( trailingslashit( get_option( 'siteurl' ) ), '', MP_UPL_URL ) );

// 2.

global $mp_general, $mp_subscriptions;
$mp_general		= get_option( MailPress::option_name_general );
$mp_subscriptions	= get_option( MailPress::option_name_subscriptions );

if ( isset( $mp_general['wp_mail'] ) )
{
	include ( MP_ABSPATH . 'mp-includes/wp_pluggable.php' );
}

// 3.

/* solve tracking links whether active or not */
add_action( 'wp_ajax_mp_tracking',		array( 'MP_Tracking', 'process' ) );
add_action( 'wp_ajax_nopriv_mp_tracking',	array( 'MP_Tracking', 'process' ) );

// 4.

/** Debug */
if ( defined( 'WP_DEBUG' ) && WP_DEBUG && !defined( 'MP_DEBUG_LOG' ) ) 
	define( 'MP_DEBUG_LOG', true );
