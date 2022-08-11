<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'Mailpress_signer_dkim' ) )
{
/*
Plugin Name: MailPress_signer_dkim 
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/signer_dkim/
Description: Signer : use of DKIM
Version: 7.2
*/

class Mailpress_signer_dkim
{
	const option_name = 'MailPress_signer_dkim';

	function __construct()
	{
		new MP_Swift_Signer_dkim();

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
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'signer_dkim' );
	}
}
new Mailpress_signer_dkim();
}