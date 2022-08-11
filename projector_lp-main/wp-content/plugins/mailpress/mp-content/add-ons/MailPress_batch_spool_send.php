<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_batch_spool_send' ) )
{
/*
Plugin Name: MailPress_batch_spool_send 
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/batch_spool_send/
Description: Mails : Send them in batch mode via spool ( <span style="color:red;">not compatible with Batch_send</span> add-on )
Version: 7.2
*/

class MailPress_batch_spool_send
{
	const meta_key = '_MailPress_batch_spool_send';
	const option_name = 'MailPress_batch_spool_send';
	const log_name = 'batch_spool_send';

	const process_name = 'mp_process_batch_spool_send';

	const bt = 132;

	function __construct()
	{
// prepare mail
		add_filter( 'MailPress_status_mail',					array( __CLASS__, 'status_mail' ) );

// for batch mode
		add_action( self::process_name,				array( __CLASS__, 'process' ) );

		$config = get_option( self::option_name );
		if ( !empty( $config['batch_mode'] ) && 'wpcron' == $config['batch_mode'] )
		{	
			add_action( 'MailPress_schedule_batch_spool_send',	array( __CLASS__, 'schedule' ) );
		}

		if ( is_admin() )
		{
		// for install
			register_activation_hook( plugin_basename( __FILE__ ),	array( __CLASS__, 'install' ) );
			register_deactivation_hook( plugin_basename( __FILE__ ),array( __CLASS__, 'uninstall' ) );
		// for link on plugin page
			add_filter( 'plugin_action_links',				array( __CLASS__, 'plugin_action_links' ), 10, 2 );

		// for settings
			add_filter( 'MailPress_settings_tab',				array( __CLASS__, 'settings_tab' ), 20, 1 );
		// for settings batches
			add_filter( 'MailPress_settings_batches_help',		array( __CLASS__, 'settings_batches_help' ), 20, 1 );
			add_action( 'MailPress_settings_batches_update',	array( __CLASS__, 'settings_batches_update' ), 20 );
			add_action( 'MailPress_settings_batches_form',		array( __CLASS__, 'settings_batches_form' ), 20 );
		// for settings logs
			add_action( 'MailPress_settings_logs_form',				array( __CLASS__, 'settings_logs_form' ), 20, 1 );

			if ( isset( $config['batch_mode'] ) && ( 'wpcron' == $config['batch_mode'] ) )
			{	
			// for autorefresh
				add_filter( 'MailPress_autorefresh_every',		array( __CLASS__, 'autorefresh_every' ), 8, 1 );
				add_filter( 'MailPress_autorefresh_js',		array( __CLASS__, 'autorefresh_js' ), 8, 1 );
			}

		// for meta box in tracking page
			add_action( 'MailPress_tracking_add_meta_box',		array( __CLASS__, 'tracking_add_meta_box' ), 8, 1 );
		}

		// for to mails column
		add_filter( 'MailPress_to_mails_column',				array( __CLASS__, 'to_mails_column' ), 8, 2 );
	}
        
// spool
	public static function is_path( $p )
	{
		if ( is_writable( $p ) ) return $p;

		if ( !is_dir( $p ) ) if ( mkdir( $p, 0777, true ) ) return $p;

		return false;
	}

// prepare mail
	public static function status_mail()
	{
		return 'unsent';
	}

// process
	public static function process()
	{
		MP_::no_abort_limit();

		new MP_Batch_spool();
	}

// schedule
	public static function schedule()
	{
		$config = get_option( self::option_name );
		$now4cron = current_time( 'timestamp', 'gmt' );

		if ( !wp_next_scheduled( self::process_name ) ) 
			wp_schedule_single_event( $now4cron + $config['every'], self::process_name );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// for install
	public static function install() 
	{
		self::uninstall();

		global $wpdb;
		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->mp_mailmeta SET meta_key = %s WHERE meta_key = %s;", self::meta_key, 'batch_spool_send' ) );

		MP_Log::set_option( self::log_name );

		do_action( 'MailPress_schedule_batch_spool_send' );
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
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/batch_spool_send/help.php' );
		return $content;
	}

	public static function settings_batches_update()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/batch_spool_send/update.php' );
	}

	public static function settings_batches_form()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/batch_spool_send/form.php' );
	}

// for settings logs
	public static function settings_logs_form( $logs )
	{
		MP_AdminPage::log_form( self::log_name, $logs, __( 'Spool', 'MailPress' ) );
	}

	public static function autorefresh_every( $every = 30 )
	{
		$config = get_option( self::option_name );
		if ( !$config ) return $every;
		if ( $every < $config['every'] ) return $every;
		return $config['every'];
	}

	public static function autorefresh_js( $scripts )
	{
		return MP_WP_AutoRefresh_js::getInstance( $scripts );
	}

// for meta box in tracking page
	public static function tracking_add_meta_box( $screen )
	{
		if ( 'mailpress_tracking_m' != $screen ) return;
		if ( !isset( MP_AdminPage::$get_['id'] ) ) return;

		if ( !MP_Mail_meta::get( MP_AdminPage::$get_['id'], self::meta_key ) ) return;

		add_meta_box( 'batchspoolsenddiv', __( 'Batch Spool current status', 'MailPress' ), array( __CLASS__, 'meta_box_status' ), $screen, 'normal', 'core' );
	}

	public static function meta_box_status( $mail )
	{ 
		$mailmeta = MP_Mail_meta::get( $mail->id , self::meta_key );

		include ( MP_ABSPATH . 'mp-includes/meta_boxes/mail/batch_status.php' );
	}

// for mails list
	public static function to_mails_column( $to, $mail )
	{
		$mailmeta = MP_Mail_meta::get( $mail->id , self::meta_key );

		if ( $mailmeta )
		{
			if ( $mailmeta['sent'] != $mailmeta['count'] ) return sprintf( _n( _x( '%1$s of %2$s sent', 'Singular', 'MailPress' ), _x( '%1$s of %2$s sent', 'Plural', 'MailPress' ), $mailmeta['sent'] ), $mailmeta['sent'], $mailmeta['count'] );
		}
		else
		{
			if ( self::status_mail() == $mail->status ) return __( 'Pending...', 'MailPress' );
			else
			{
				if ( 'paused' == $mail->status ) return __( 'Paused...', 'MailPress' );
			}
		}

		return $to;
	}
}
new MailPress_batch_spool_send();
}