<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_delete_old_mails' ) )
{
/*
Plugin Name: MailPress_delete_old_mails
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/delete_old_mails/
Description: Mails : delete old mails
Version: 7.2
*/

class MailPress_delete_old_mails
{
	const option_name = 'MailPress_delete_old_mails';

	const process_name		= 'mp_process_delete_old_mails';

	const bt = 132;

	function __construct()
	{
		add_action( self::process_name, 				array( $this, 'process' ) );

		$config = get_option( self::option_name );
		if ( 'wpcron' == $config['batch_mode'] )
		{	
			add_action( 'MailPress_schedule_delete_old_mails', 	array( __CLASS__, 'schedule' ) );
		}

		if ( is_admin() )
		{
		// for install
			register_activation_hook( plugin_basename( __FILE__ ), 	array( __CLASS__, 'install' ) );
			register_deactivation_hook( plugin_basename( __FILE__ ),	array( __CLASS__, 'uninstall' ) );
		// for link on plugin page
			add_filter( 'plugin_action_links', 				array( __CLASS__, 'plugin_action_links' ), 10, 2 );

		// for settings
			add_filter( 'MailPress_settings_tab', 				array( __CLASS__, 'settings_tab' ), 20, 1 );
		// for settings batches
			add_filter( 'MailPress_settings_batches_help',		array( __CLASS__, 'settings_batches_help' ), 20, 1 );
			add_action( 'MailPress_settings_batches_update',	array( __CLASS__, 'settings_batches_update' ), 20 );
			add_action( 'MailPress_settings_batches_form',		array( __CLASS__, 'settings_batches_form' ), 20 );
		}	
	}

// process
	public static function process()
	{
		self::schedule();

		global $wpdb;

		$config = get_option( self::option_name );
		if ( !$config ) return false;

		MP_::no_abort_limit();

		$date = date( 'Y-m-d', current_time( 'timestamp' ) - ( $config['days'] * DAY_IN_SECONDS ) );

		$ids = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM $wpdb->mp_mails WHERE status =  'sent' AND DATE( sent ) < %s;", $date ) );

		foreach( $ids as $id ) MP_Mail::delete( $id->id );
	}

// schedule
	public static function schedule()
	{
		$config = get_option( self::option_name );
		$now4cron = current_time( 'timestamp', 'gmt' );

		if ( !wp_next_scheduled( self::process_name ) ) 
			wp_schedule_single_event( $now4cron + $config['every'] * DAY_IN_SECONDS, self::process_name );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// for install
	public static function install() 
	{
		self::uninstall();

		do_action( 'MailPress_schedule_delete_old_mails' );
	}

	public static function uninstall() 
	{
		wp_clear_scheduled_hook( self::process_name );
	}

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'batches' );
	}

// for settings
	public static function settings_tab( $tabs )
	{
		$tabs['batches'] = __( 'Batches', 'MailPress' );
		return $tabs;
	}

// for settings batches
	public static function settings_batches_help( $content )
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/delete_old_mails/help.php' );
		return $content;
	}

	public static function settings_batches_update()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/delete_old_mails/update.php' );
	}

	public static function settings_batches_form()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/delete_old_mails/form.php' );
	}

}
new MailPress_delete_old_mails();
}