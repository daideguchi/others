<?php
abstract class MP_bounce_ extends MP_process_pop3_
{
	public static $count = array();

	function get_log_title()
	{
		$xmailboxstatus = array( 0 => 'no changes', 1 => 'mark as read', 2 => 'delete', );
		return sprintf( $this->log_title, $xmailboxstatus[$this->config['mailbox_status']] );
	}

	function process_message()
	{
		$this->local_log = array();

		if ( !$this->is_bounce() )
		{
			$sep = ( count( $this->local_log ) != 1 );
			if ( $sep ) $this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
			foreach( $this->local_log as $local_log ) $this->trace->log( $local_log );
			if ( $sep ) $this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );

			return;
		}

		$user_logmess = $mail_logmess = '';
		$already_processed = $already_stored = false;

		$bm  = '            !';
		$bm .= str_repeat( '-', $this->bt - strlen( $bm ) );
		$this->trace->log( '!' . $bm . '!' );

		$this->mysql_disconnect( $this->class );
		$this->mysql_connect( $this->class );

		if ( !$mp_user = MP_User::get( $this->mp_user_id ) )
		{
			$user_logmess = '** WARNING ** user not in database'; 
			$usermeta['bounce'] = 0;
		}
		else
		{
			$bounce = array( 'message' => $this->pop3->message );

			$usermeta = MP_User_meta::get( $this->mp_user_id, $this->meta_key );
			if ( !$usermeta )
			{
				$usermeta = array();
				$usermeta['bounce'] = 1;
				$usermeta['bounces'][$this->mail_id][] = $bounce;	
				MP_User_meta::add( $this->mp_user_id, $this->meta_key, $usermeta );
			}
			else
			{
				if ( !is_array( $usermeta ) ) $usermeta = array();

				if ( !isset( $usermeta['bounces'][$this->mail_id] ) ) 
				{
					$usermeta['bounces'][$this->mail_id] = array();

					if ( !isset( $usermeta['bounce'] ) ) 	      $usermeta['bounce'] = 1;
					elseif ( !is_numeric( $usermeta['bounce'] ) ) $usermeta['bounce'] = 1;
					else $usermeta['bounce']++;
				}
				else
				{
					$already_processed = true;
					foreach( $usermeta['bounces'][$this->mail_id] as $bounces )
					{
						if ( $bounces['message'] == $bounce['message'] )
						{
							$already_stored = true;
							break;
						}
					}
				}

				if ( !$already_stored ) $usermeta['bounces'][$this->mail_id][] = $bounce;

				if ( !MP_User_meta::add( $this->mp_user_id, $this->meta_key, $usermeta, true ) )
					MP_User_meta::update( $this->mp_user_id, $this->meta_key, $usermeta );
			}

			switch ( true )
			{
				case $already_processed :
					$user_logmess = '-- notice -- bounce previously processed';
				break;
				case ( 'bounced' == $mp_user->status ) :
					$user_logmess = ' <' . $mp_user->email . '> already ** BOUNCED **';
				break;
				case ( $usermeta['bounce'] >= $this->config['max_bounces'] ) :
					MP_User::set_status( $this->mp_user_id, 'bounced' );
					$user_logmess = '** BOUNCED ** <' . $mp_user->email . '>';
				break;
				default :
					$user_logmess = 'new bounce for <' . $mp_user->email . '>';
				break;
			}
		}

		$mailmeta = '';
		if ( !$already_processed )
		{
			switch ( true )
			{
				case ( -1 == $this->mail_id ) :
					$mail_logmess = '** WARNING ** mail unknown';
				break;
				case ( !$mail = MP_Mail::get( $this->mail_id ) ) :
					$mail_logmess = '** WARNING ** mail not in database';
				break;
				default :
					if ( !isset( self::$count[$this->mail_id] ) ) self::$count[$this->mail_id] = MP_Mail_meta::get( $this->mail_id, $this->meta_key );
					self::$count[$this->mail_id] = ( is_numeric( self::$count[$this->mail_id] ) ) ? ( self::$count[$this->mail_id] + 1 ) : 1;
					if ( !MP_Mail_meta::add( $this->mail_id, $this->meta_key, self::$count[$this->mail_id] , true ) )
						MP_Mail_meta::update( $this->mail_id, $this->meta_key, self::$count[$this->mail_id] );
					$mailmeta = self::$count[$this->mail_id];

					$metas = MP_Mail_meta::get( $this->mail_id, '_MailPress_replacements' );
					$mail_logmess = $mail->subject;
					if ( $metas ) foreach( $metas as $k => $v ) $mail_logmess = str_replace( $k, $v, $mail_logmess );
					if ( strlen( $mail_logmess ) > 50 )	$mail_logmess = substr( $mail_logmess, 0, 49 ) . '...';
				break;
			}
		}

		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );

		$bm  = '            ! id         ! bounces   ! ';
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$bm  = ' user       ! ';
		$bm .= str_repeat( ' ', 10 - strlen( $this->mp_user_id ) ) . $this->mp_user_id . ' !';
		$bm .= str_repeat( ' ', 10 - strlen( $usermeta['bounce'] ) ) . ( ( $usermeta['bounce'] ) ? $usermeta['bounce'] : '' ) . ' !';
		$bm .= " $user_logmess";
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$bm  = ' mail       ! ';
		$bm .= str_repeat( ' ', 10 - strlen( $this->mail_id ) )  . $this->mail_id . ' !';
		$bm .= str_repeat( ' ', 10 - strlen( $mailmeta ) ) . $mailmeta . ' !';
		$bm .= " $mail_logmess";
		$this->trace->log( '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!' );

		$bm  = '            !------------+-----------+';
		$bm .= str_repeat( '-', $this->bt - strlen( $bm ) );
		$this->trace->log( '!' . $bm . '!' );
	
		switch ( $this->config['mailbox_status'] )
		{
			case 1 :
				$this->pop3->get_message( $this->message_id );
			break;
			case 2 :
				$this->pop3->delete( $this->message_id );
			break;
			default :
			break;
		}

		$this->trace->log( '!' . str_repeat( '-', $this->bt ) . '!' );
	}
}