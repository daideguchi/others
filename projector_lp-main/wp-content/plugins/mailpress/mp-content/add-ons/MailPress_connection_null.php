<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_connection_null' ) )
{
/*
Plugin Name: MailPress_connection_null 
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/connection_null/
Description: Connection : Not sending mails (for test/debug purpose only)
Version: 7.2
*/

class MailPress_connection_null
{
	function __construct()
	{
		new MP_Swift_Connection_null();
	}
}
new MailPress_connection_null();
}