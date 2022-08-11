<?php
class MP_List_Unsubscribe extends MP_list_unsubscribe_
{
	public $option_name	= MailPress_list_unsubscribe::option_name;

	public $class		= __CLASS__;
	public $log_name 	= 'mp_process_list_unsubscribe';
	public $log_option_name = 'list_unsubscribe';
	public $log_title 	= 'List-Unsubscribe Report ( Processing mode : %1$s )';

	public $cron_name 	= 'MailPress_schedule_list_unsubscribe';

	const headers		= array( 'From', 'Subject' );

	function is_request()
	{
		$this->pop3->get_headers( $this->message_id, self::headers );

		$this->do_delete = false;

		$this->action  = false;
		$this->mail_id = false;
		$this->confkey = false;
		$this->list_id = false;

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

		$words = explode( '.', $subject );
		$words = array_map( 'trim', $words );

		if ( count( $words ) != 5 ) return false;
		if ( MailPress_list_unsubscribe::key_word != $words[0] ) return false;

		$this->action  = $words[0] ?? false;
		$this->mail_id = $words[1] ?? false;
		$this->confkey = $words[2] ?? false;
		$this->list_id = $words[3] . '.' . $words[4] ?? false;

		$mp_user_id = MP_User::get_id( $this->confkey );

		if ( !$mp_user_id ) 
		{
			$bm = '            ! ** ERROR ** no valid confkey found';
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			return false;
		}

		$this->mp_user = MP_User::get( $mp_user_id );

		if ( !$this->mp_user ) 
		{
			$bm = '            ! ** ERROR ** no valid mp_user found';
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			return false;
		}

// from
		$this->has_email();

		if ( !$this->email_address ) return false;

		if ( !$this->compare( $this->email_address, $this->mp_user->email ) )
		{
			$bm = '            ! ** ERROR ** ' . $this->mp_user->email . ' <> ' . $this->email_address;
			$this->local_log[] = '!' . $bm . str_repeat( ' ', $this->bt - strlen( $bm ) ) . '!';
			$this->do_delete = true;
			return false;
		}

		return ( $this->mail_id && $this->confkey && $this->list_id );
	}
}