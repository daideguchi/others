<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_wp_cron' ) )
{
/*
Plugin Name: MailPress_wp_cron
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/wp_cron/
Description: Wp_cron ( view jobs scheduled using WP api in your browser : Tools menu )
Version: 7.2
*/

// 3.

/** for admin plugin pages */
define ( 'MailPress_page_wp_cron', 	'mailpress_wp_cron' );

/** for admin plugin urls */
$mp_file = 'tools.php';
define ( 'MailPress_wp_cron',		add_query_arg( 'page', MailPress_page_wp_cron, 	$mp_file ) );

class MailPress_wp_cron
{
	function __construct()
	{
// for wp admin
		if ( is_admin() )
		{
		// for role & capabilities
			add_filter( 'MailPress_capabilities', 		array( __CLASS__, 'capabilities' ), 1, 1 );
		// for load admin page
			add_filter( 'MailPress_load_admin_page', 	array( __CLASS__, 'load_admin_page' ), 10, 1 );
		}
	}

////  Admin  ////

// for role & capabilities
	public static function capabilities( $capabilities )
	{
		$capabilities['MailPress_manage_wp_cron'] = array( 	'name'	=> __( 'Wp_cron', 'MailPress' ),
											'group'	=> 'admin',
											'menu'	=> 99,

											'parent'	=> 'tools.php',
											'page_title'=> __( 'MailPress wp_cron', 'MailPress' ),
											'menu_title'=> __( 'Wp_cron', 'MailPress' ),
											'page'	=> MailPress_page_wp_cron,
											'func'	=> array( 'MP_AdminPage', 'body' )
									 );
		return $capabilities;
	}

// for load admin page
	public static function load_admin_page( $hub )
	{
		$hub[MailPress_page_wp_cron] = 'wp_cron';
		return $hub;
	}
}
new MailPress_wp_cron();
}