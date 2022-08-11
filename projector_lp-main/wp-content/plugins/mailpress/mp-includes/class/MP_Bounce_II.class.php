<?php
class MP_Bounce_II extends MP_bounce_
{
	public $option_name	= MailPress_bounce_handling_II::option_name;

	public $class		= __CLASS__;
	public $log_name 	= 'mp_process_bounce_handling_II';
	public $log_option_name = 'bounce_handling_II';
	public $log_title 	= 'Bounce Handling II Report ( Bounce in mailbox : %1$s )';

	public $cron_name 	= 'MailPress_schedule_bounce_handling_II';

	public $meta_key	= MailPress_bounce_handling_II::meta_key;

	private $subject_bounce= array();
	private $subject_regex = '';

	private $body_bounce   = array();
	private $body_regex    = '';

	const headers		= array( 'Subject', 'X-MailPress-blog-id', 'X-MailPress-mail-id', 'X-MailPress-user-id' );

	function __construct()
	{
		$this->load_regex();

		parent::__construct();
	}

	function is_bounce()
	{
		$this->pop3->get_headers_deep( $this->message_id, self::headers );

		$this->blog_id = false;
		$this->mail_id = false;
		$this->mp_user_id = false;

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

/* looking for bounce in subject */

		if ( empty( $subject ) || !preg_match( $this->subject_regex, strtolower( $subject ) ) ) return false;

/* looking for bounce in message */

		if ( !$this->parse_body( $this->pop3->get_body( 0 ) ) ) return false;

/* looking for identifiers */

		$this->blog_id = $this->pop3->get_header( 'X-MailPress-blog-id', 1 );
		if ( $this->blog_id === false ) 
		{
			$bm = '            ! ** ERROR ** unknown blog';
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			return false;
		}
		if ( $this->blog_id != get_current_blog_id() )
		{
			$bm = '            ! ** ERROR ** current blog is #' . get_current_blog_id() . ', blog sending mail is #' . $this->blog_id;
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			$this->blog_id = false;
			return false;
		}

		$this->mail_id = $this->pop3->get_header( 'X-MailPress-mail-id', 1 );
		if ( !$this->mail_id ) 
		{
			$bm = '            ! ** ERROR ** unknown original mail';
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			return false;
		}
		$this->mail = MP_Mail::get( $this->mail_id );
		if ( !$this->mail ) 
		{
			$bm = '            ! ** ERROR ** mail unknown #' . $this->mail_id;
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			$this->mail_id = false;
			return false;
		}

		$this->mp_user_id = $this->pop3->get_header( 'X-MailPress-user-id', 1 );
		if ( !$this->mp_user_id && MailPress::is_email( $this->mail->toemail ) )
		{
			$this->mp_user_id = MP_User::get_id_by_email( $mail->toemail );
		}
		if ( !$this->mp_user_id )
		{
			$bm = '            ! ** ERROR ** unknown original recipient';
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			return false;
		}
		$this->mp_user = MP_User::get( $this->mp_user_id );
		if ( !$this->mp_user ) 
		{
			$bm = '            ! ** ERROR ** recipient unknown #' . $this->mp_user_id;
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			$this->mp_user_id = false;
			return false;
		}

		return ( $this->mail_id && $this->mp_user_id && ( $this->blog_id !== false ) );
	}

	function parse_body( $body )
	{
		$status = array();
		if ( preg_match( $this->body_regex, $body, $matches ) ) 
		{
			if ( 3 == count( $matches ) ) preg_match( '/Status\s*?\:\s*?([2|4|5]+)\.(\d{1,3}).(\d{1,3})/is', $matches[2], $status );
			unset( $matches );
		}

		if ( 4 == count( $status ) ) 
		{
			$bounce = false;
			switch ( $status[1] ) 
			{
				case 2:
					$bounce = true;
					break;
				case 4:
					$bounce = $this->RFC_3463_4( $status[2], $status[3] );
					break;
				case 5:
					if ( 5 == $status[2] && 0 == $status[3] ) break;
					$bounce = $this->RFC_3463_5( $status[2], $status[3] );
					break;
			}
			if ( $bounce ) return true;
		}

		foreach ( $this->body_bounce as $rule ) if ( preg_match( '%' . preg_quote( $rule ) . '%is', $body ) ) return true;

		return false;
	}

	// RFC 3463 - Enhanced Mail System Status Codes

	function RFC_3463_4( $code, $subcode )
	{
		if ( ( 5 == $code ) && ( 3 == $subcode ) ) return true;
		return false;
	}

	function RFC_3463_5( $code, $subcode )
	{
		switch ( $code )
		{
			case '1': 
				if ( in_array( $subcode, array( '0','1','2','3','4','5','6' ) ) ) return true;
				break;
			default :
				if ( in_array( $code, array( '2','3','4','5','6','7' ) ) ) return true;
				break;
		}
		return false;
	}

	function load_regex()
	{
		$advanced_path = 'advanced/' . get_current_blog_id() . '/bounces';

		$root = MP_UPL_ABSPATH . $advanced_path;
		$root = apply_filters( 'MailPress_advanced_bounces_root', $root );
		$file	= "$root/II.xml";

		$y = '';

		if ( !is_file( $file ) ) return;

		$x = file_get_contents( $file );
		if ( $xml = simplexml_load_string( $x ) )

		foreach ( $xml->subject->text as $text ) $this->subject_bounce[] = preg_quote( ( string ) $text, '~' );
		$this->subject_regex = '~( ' . implode( '|', $this->subject_bounce ) . ' )~i';

		$this->body_regex = ( string ) $xml->body->regex;
		foreach ( $xml->body->text as $text ) $this->body_bounce[] = ( string ) $text;
	}
}