<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_connection_smtp_SMTPUTF8' ) )
{
/*
Plugin Name: MailPress_connection_smtp_SMTPUTF8
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/connection_smtp/
Description: Connection : use Smtp and support SMTPUTF8 ( your SMTP server <span style="color:red;">MUST</span> support <a href="https://en.wikipedia.org/wiki/Extended_SMTP#SMTPUTF8" target="_blank">SMTPUTF8</a> ) 
Version: 7.2
*/

class MailPress_connection_smtp_SMTPUTF8
{
	function __construct()
	{
		defined( 'SWIFT_ADDRESSENCODER' ) or define ( 'SWIFT_ADDRESSENCODER',	'utf8' );

		new MP_Swift_Connection_smtp_SMTPUTF8();

// for wp admin
		if ( is_admin() )
		{
		// for link on plugin page
			add_filter( 'plugin_action_links', 			array( __CLASS__, 'plugin_action_links' ), 10, 2 );
		}
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'connection_smtp' );
	}
}
new MailPress_connection_smtp_SMTPUTF8();
}