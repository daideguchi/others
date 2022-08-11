<?php
class MP_Bounce extends MP_bounce_
{
	public $option_name		= MailPress_bounce_handling::option_name;

	public $class			= __CLASS__;
	public $log_name		= MailPress_bounce_handling::process_name;
	public $log_option_name		= 'bounce_handling';
	public $log_title		= 'Bounce Handling Report ( Bounce in mailbox : %1$s )';

	public $cron_name		= 'MailPress_schedule_bounce_handling';

	public $meta_key		= MailPress_bounce_handling::meta_key;

	const headers			= array( 'Subject', 'Return-Path', 'Return-path', 'Received', 'To', 'X-Failed-Recipients', 'Final-Recipient' );

	function is_bounce()
	{
		$prefix 	= preg_quote( substr( $this->config['Return-Path'], 0, strpos( $this->config['Return-Path'], '@' ) ) . '+' );
		$domain 	= preg_quote( substr( $this->config['Return-Path'], strpos( $this->config['Return-Path'], '@' ) + 1 ) );
		$user_mask	= preg_quote( '{{_user_id}}' );

		$this->pop3->get_headers_deep( $this->message_id, self::headers );

		$this->bounce_email = false;
		$this->mail_id      = false;
		$this->mp_user_id   = false;

// subject
		$subject = $this->pop3->get_header( 'Subject' );

		if ( empty( $subject ) )
		{
			$bm = '            ! ** ERROR ** empty header : Subject (?) ';
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			return false;
		}

		$bm = ' Subject    ! ==> ' . $subject;
		$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';

		foreach( $this->pop3->headers as $tag => $headers )
		{
			if ( $tag == 'Subject' ) continue;
			foreach( $headers as $header )
			{
				if ( strpos( $header, $this->config['Return-Path'] ) !== false ) continue;

				switch ( true )
				{
					case ( preg_match( "#{$prefix}[0-9]*\+[0-9]*@{$domain}#", $header ) ) :
						preg_match_all( "/{$prefix}([0-9]*)\+([0-9]*)@{$domain}/", $header, $matches, PREG_SET_ORDER );
						if ( empty( $matches ) ) continue 2;

						$this->bounce_email = $matches[0][0];
						$this->mail_id	    = $matches[0][1];
						$this->mp_user_id   = $matches[0][2];
					break;
					case ( preg_match( "#{$prefix}[0-9]*\+$user_mask@{$domain}#", $header ) ) :
						preg_match_all( "/$prefix([0-9]*)\+$user_mask@$domain/", $header, $matches, PREG_SET_ORDER );
						if ( empty( $matches ) ) continue 2;

						$this->bounce_email	= $matches[0][0];
						$this->mail_id		= $matches[0][1];
						if ( !$mail = MP_Mail::get( $this->mail_id ) )	continue 2;
						if ( !MailPress::is_email( $mail->toemail ) )	continue 2;
						$this->mp_user_id 	= MP_User::get_id_by_email( $mail->toemail );
						if ( !$this->mp_user_id ) continue 2;
					break;
					case ( preg_match_all( "/[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]+@[\._a-zA-Z0-9-]{2,}+/i", $header, $matches, PREG_SET_ORDER ) && ( $this->bounce_email = MailPress::is_email( $matches[0][0] ) ) ) :
						switch( $tag )
						{
							case 'X-Failed-Recipients' :
							case 'Final-Recipient' :

								$this->mail_id = -1;
								$this->mp_user_id = MP_User::get_id_by_email( $this->bounce_email );
								if ( !$this->mp_user_id ) continue 3;
							break;
							default :
								continue 3;
							break;
						}
					break;
					default :
						continue 2;
					break;
				}
			}

			if ( $this->mail_id && $this->mp_user_id && $this->bounce_email )
			{
				break;
			}
		}

		return ( $this->mail_id && $this->mp_user_id && $this->bounce_email );
	}
}