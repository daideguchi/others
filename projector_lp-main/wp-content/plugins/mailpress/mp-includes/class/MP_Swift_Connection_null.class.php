<?php
class MP_Swift_Connection_null extends MP_Swift_connection_
{
	public $Swift_Connection_type = 'NULL';

	function connect( $mail_id, $y )
	{
		return new Swift_NullTransport();
	}
}