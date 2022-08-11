<?php
abstract class MP_list_unsubscribe_ extends MP_process_pop3_
{
	function get_log_title()
	{
		return sprintf( $this->log_title, MailPress_list_unsubscribe::actions[$this->config['mode']] );
	}

// process

	function process_message()
	{
		$this->local_log = array();

		if ( !$this->is_request() )
		{
			$sep = ( count( $this->local_log ) != 1 );
			if ( $sep ) $this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
			foreach( $this->local_log as $local_log ) $this->trace->log( $local_log );
			if ( $this->do_delete ) $this->pop3->delete( $this->message_id );
			if ( $sep ) $this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );

			return;
		}
		$bm  = '            !';
		$bm .= str_repeat( '-', $this->bt - strlen( $bm ) );
		$this->trace->log( '!' . $bm . '!' );

		$this->mysql_disconnect( $this->class );
		$this->mysql_connect( $this->class );

		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );

		$bm = ' email      ! ' . $this->mp_user->email . ' ( ' . $this->mp_user->name . ' ) ';
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$bm = ' list_id    ! ' . $this->list_id;
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$bm = ' mail_id    ! ' . $this->mail_id;
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$bm  = '            !';
		$bm .= str_repeat( '-', $this->bt - strlen( $bm ) );
		$this->trace->log( '!' . $bm . '!' );

		MailPress_list_unsubscribe::unsubscribe( 'mail', $this->mp_user, $this->list_id, $this->mail_id );

		$this->pop3->delete( $this->message_id );
	
		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
	}
}