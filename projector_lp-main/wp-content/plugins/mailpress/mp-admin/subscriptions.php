<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= MailPress_page_subscriptions;
	const capability	= 'MailPress_manage_subscriptions';
	const help_url		= false;
	const file			= __FILE__;

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Subscriptions :', 'MailPress' ) . '</strong></p>';

		$content .= '<p>' . __( 'As a Wp user synchronized with MailPress, you can manage your subscriptions through this admin screen.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);
	}
}