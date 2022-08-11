<?php
abstract class MP_WP_privacy_
{
	function __construct( $name )
	{
		$this->name = $name;

		add_filter( "wp_privacy_personal_data_{$this->type}s",  array( $this, 'register' ), $this->priority );
	}

	function register( $registry )
	{
		$registry[get_class( $this )] = array( $this->type . '_friendly_name' => $this->name, 'callback' => array( $this, $this->type ), );
		return $registry;
	}

	function get_user( $email )
	{
		$email = trim( $email );

		if ( !MailPress::is_email( $email ) ) return false;

		$mp_user = MP_User::get( MP_User::get_id_by_email( $email ) );

		if ( isset( $mp_user->id ) ) $this->mp_user_id = $mp_user->id;

		return ( $mp_user ) ? $mp_user : false;
	}
}



