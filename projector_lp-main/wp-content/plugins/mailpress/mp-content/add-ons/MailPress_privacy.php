<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_privacy' ) && function_exists( 'wp_create_user_request' ) )
{
/*
Plugin Name: MailPress_privacy
Plugin URI: http://blog.mailpress.org
Description: Users : Create Personal Data export/erasure requests from mail sent to a dedicated mailbox with a specific subject
Version: 7.2
*/

class MailPress_privacy
{
	const meta_key     	= '_MailPress_privacy';
	const option_name 	= 'MailPress_privacy';
	const log_name = 'privacy';

	const process_name		= 'mp_process_privacy';

	const bt = 132;

	function __construct()
	{
// for batch mode
		add_action( self::process_name,					array( __CLASS__, 'process' ) );

		$config = get_option( self::option_name );
		if ( 'wpcron' == $config['batch_mode'] )
		{	
			add_action( 'MailPress_schedule_privacy',		array( __CLASS__, 'schedule' ) );
		}

		if ( is_admin() )
		{
		// for install
			register_activation_hook( plugin_basename( __FILE__ ),array( __CLASS__, 'install' ) );
			register_deactivation_hook( plugin_basename( __FILE__ ),array( __CLASS__, 'uninstall' ) );
		// for link on plugin page
			add_filter( 'plugin_action_links',			array( __CLASS__, 'plugin_action_links' ), 10, 2 );

		// for settings
			add_filter( 'MailPress_settings_tab', 		array( __CLASS__, 'settings_tab' ), 50, 1 );
		// for settings logs
			add_action( 'MailPress_settings_logs_form',	array( __CLASS__, 'settings_logs_form' ), 30, 1 );
		}
	}

// process
	public static function process()
	{
		MP_::no_abort_limit();

		new MP_Privacy();
	}

// schedule
	public static function schedule()
	{
		$config = get_option( self::option_name );
		$now4cron = current_time( 'timestamp', 'gmt' );

		if ( !wp_next_scheduled( self::process_name ) ) 
			wp_schedule_single_event( $now4cron + $config['every'], self::process_name );
	}

// check request subject is one word
	public static function one_word( $w ) 
	{
		$w = trim( $w );
		$words = explode( ' ', $w );
		return ( count( $words ) == 1 ) ? $w : false;
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// install
	public static function install() 
	{
		self::uninstall();

		$options = get_option( self::option_name );
		if ( !$options )
		{
			$pop3 = get_option( 'MailPress_connection_pop3' );
			if ( $pop3 )
			{
				unset( $pop3['username'], $pop3['password'] );
				$options['pop3'] = $pop3;
				update_option( self::option_name, $options );
			}
		}

		MP_Log::set_option( self::log_name );

		do_action( 'MailPress_schedule_privacy' );
	}

	public static function uninstall() 
	{
		wp_clear_scheduled_hook( self::process_name );
	}

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'privacy' );
	}

// for settings
	public static function settings_tab( $tabs )
	{
		$tabs['privacy'] = __( 'Privacy', 'MailPress' );
		return $tabs;
	}

// for settings logs	
	public static function settings_logs_form( $logs )
	{
		MP_AdminPage::log_form( self::log_name, $logs, __( 'Privacy', 'MailPress' ) );
	}
}
new MailPress_privacy();
}