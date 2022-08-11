<?php
class MP_Swift_Connection_sendmail extends MP_Swift_connection_
{
	public $Swift_Connection_type = 'SENDMAIL';

	function connect( $mail_id, $y )
	{
		$settings = get_option( MailPress::option_name_sendmail );

		switch ( $settings['cmd'] )
		{
			case 'custom' :
				$conn = new Swift_SendmailTransport( $settings['custom'] );
			break;
			default :
				$conn = new Swift_SendmailTransport();
			break;
		}
		return $conn;
	}
}