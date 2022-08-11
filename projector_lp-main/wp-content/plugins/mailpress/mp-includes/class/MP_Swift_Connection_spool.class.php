<?php
class MP_Swift_Connection_spool extends MP_Swift_connection_
{
	public $Swift_Connection_type = 'spool';

	function connect( $mail_id, $y )
	{

		$spool_path = 'spool/' . get_current_blog_id() . '/';

		$p = MailPress_batch_spool_send::is_path( MP_UPL_ABSPATH . $spool_path . $mail_id ); 

		$y->log( "**** Spool path is : $p ****" );

		$spool =  new Swift_FileSpool( $p );

		return new Swift_SpoolTransport( $spool );
	}
}