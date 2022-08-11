<?php
abstract class MP_process_pop3_ extends MP_WP_db_connect_
{
	public $bt = 132;

	function __construct()
	{
		$this->config = get_option( $this->option_name );
		if ( !$this->config ) return;

		$this->trace = new MP_Log( $this->log_name, array( 'option_name' => $this->log_option_name ) );

		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
		$bm = $this->get_log_title();
		$this->trace->log( '!' . str_repeat( ' ', 5 ) . $bm . str_repeat( ' ', $this->bt - 5 - strlen( $bm ) ) . '!' );
		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
		$bm = " start      !";
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$return = $this->process();

		do_action( $this->cron_name );

		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
		$this->trace->end( $return );
	}

	function get_pop3_config()
	{
		if ( isset( $this->config['pop3'] ) ) return $this->config['pop3'];

		$this->config['pop3'] = get_option( 'MailPress_connection_pop3' );
		update_option( $this->option_name, $this->config );
		return $this->config['pop3'];
	}

// process
	function process()
	{
		$return = true;
		$pop3 = $this->get_pop3_config();

		$this->pop3 = new MP_Swift_Pop3( $pop3['server'], $pop3['port'], $pop3['username'], $pop3['password'], $this->trace );

		$bm = ' connecting ! ' . $pop3['server'] . ':' . $pop3['port'];
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		if ( $this->pop3->connect() )
		{
			if ( $this->pop3->get_list() )
			{
				foreach( $this->pop3->messages as $this->message_id ) $this->process_message();
			}
			else
			{
				$v = ' *** ALL DONE ***       *** ALL DONE ***       *** ALL DONE *** '; 
				$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
				$this->trace->log( '!' . str_repeat( ' ', 15 ) . $v . str_repeat( ' ', $this->bt -15 - strlen( $v ) ) . '!' );
				$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
				$return = false;
			}
			if ( !$this->pop3->disconnect() ) $return = false;
		}
		else $return = false;

		if ( $return )
		{
			$bm = " end        !";
			$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );
		}
		return $return;
	}

	function has_email()
	{
		$this->email_address = false;
		$this->name_address  = false;
// from
		$from = $this->pop3->get_header( 'From' );

		if ( empty( $from ) )
		{
			$bm = '            ! ** ERROR ** empty header : From (?) ' . $this->tag;
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			return;
		}

		$froms = explode( ' ', $from );

		if ( is_array( $froms ) && count( $froms ) )
		{
			$froms = array_map( 'trim', $froms );
			do {
				$from = array_pop( $froms );
				$beg = substr( $from,  0, 1 );
				$end = substr( $from, -1, 1 );
				if ( ( $beg == '<' ) && ( $end == '>' ) ) $from = substr( $from, 1, -1);

				if ( MailPress::is_email( $from ) )
				{
					$this->email_address = $from;
					break;
				}
			}while( count( $froms ) );

			if ( !$this->email_address )
			{
				$bm = ' From:      ! ??? cannot find email ' . $this->tag;
				$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
				return;
			}
		}
		else
		{
			$this->email_address = ( MailPress::is_email( $from ) ) ? $from : false;

			if ( !$this->email_address )
			{
				$bm = ' From:      ! ??? cannot find email ' . $this->tag;
				$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
				return;
			}
		}

		if ( count( $froms ) )
		{
			$from = implode( ' ', $froms );
			$from = trim( $from );
			if ( !empty( $from ) )
			{
				$beg = substr( $from,  0, 1 );
				$end = substr( $from, -1, 1 );
				if ( ( $beg == '"' ) && ( $end == '"' ) ) $from = substr( $from, 1, -1);
				$this->name_address = $from;
			}
		}
	}

	function compare( $a, $b )
	{
		foreach( array( 'a', 'b' ) as $arg )
		{
			$$arg = trim( $$arg );
			$$arg = strtolower( $$arg );
			$$arg = mb_convert_encoding( $$arg, 'utf-8', 'auto' );
		}

		return ( $a == $b );
	}
}