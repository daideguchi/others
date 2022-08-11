<?php
class MP_Privacy extends MP_privacy_
{
	public $option_name	= MailPress_privacy::option_name;

	public $class		= __CLASS__;
	public $log_name 	= 'mp_process_privacy';
	public $log_option_name = 'privacy';
	public $log_title 	= 'Privacy Report ( Request in mailbox : %1$s )';

	public $cron_name 	= 'MailPress_schedule_privacy';

	const headers		= array( 'From', 'Subject' );

	function is_request()
	{
		$this->pop3->get_headers( $this->message_id, self::headers );

		$this->action_name = false;

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

/* looking for data in subject */

		foreach( $this->requests as $request => $word )
		{
			if ( $this->compare( $subject, $word ) )
			{
				$this->action_name = $request;
				break;
			}
		}

		if ( !$this->action_name ) return false;

// from
		$this->has_email();

		if ( !$this->email_address ) return false;

		return ( $this->action_name && $this->email_address );
	}
}