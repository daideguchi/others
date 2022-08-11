<?php
abstract class MP_privacy_ extends MP_process_pop3_
{
	function __construct()
	{
		$this->config = get_option( $this->option_name );
		if ( !$this->config ) return;

		$this->requests = array( 
			'export_personal_data' => strtolower( $this->config['export_word'] ), 
			'remove_personal_data' => strtolower( $this->config['erase_word'] ), 
		);

		parent::__construct();
	}

	function get_log_title()
	{
		return sprintf( $this->log_title, 'delete' );
	}

	function process_message()
	{
		$this->local_log = array();

		if ( !$this->is_request() )
		{
			$sep = ( count( $this->local_log ) != 1 );
			if ( $sep ) $this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
			foreach( $this->local_log as $local_log ) $this->trace->log( $local_log );
			if ( $sep ) $this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );

			return;
		}

		$bm  = '            !';
		$bm .= str_repeat( '-', $this->bt - strlen( $bm ) );
		$this->trace->log( '!' . $bm . '!' );

		$this->mysql_disconnect( $this->class );
		$this->mysql_connect( $this->class );

		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );

		$bm = ' email      ! ' . $this->email_address;
		$bm .= ( $this->name_address ) ? ' ( ' . $this->name_address . ' ) ' : '';
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$bm = ' action     ! ' . $this->action_name;
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$request_id = wp_create_user_request( $this->email_address, $this->action_name );

		switch(true)
		{
			case ( is_wp_error( $request_id ) ) :
				$bm = ' error      ! ' . $request_id->get_error_message();
				$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );
			break;
			case ( ! $request_id ) :
				$bm = ' error      ! Failed to initiate confirmation request';
				$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );
			break;
			default :
				wp_send_user_request( $request_id );
				$bm = ' success    ! Request mail sent to user (#' . $request_id . ').';
				$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );
			break;
		}

		$bm  = '            !';
		$bm .= str_repeat( '-', $this->bt - strlen( $bm ) );
		$this->trace->log( '!' . $bm . '!' );

		$this->pop3->delete( $this->message_id );
	
		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
	}
}