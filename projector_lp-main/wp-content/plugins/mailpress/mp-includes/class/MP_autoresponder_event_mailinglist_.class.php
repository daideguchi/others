<?php
abstract class MP_autoresponder_event_mailinglist_ extends MP_autoresponder_event_
{
	function to_do( $autoresponder, $args )
	{
		$this->mp_user_id = $args['mp_user_id'];

		return ( $autoresponder->description['settings']['mailinglist_id'] == $args['mailinglist_id'] );
	}

	function settings_form( $settings )
	{
		$mailinglist_id = $settings['mailinglist_id'] ?? get_option( MailPress_mailinglist::option_name_default );

		$out = '';
		$out .= '<label for="autoresponder_mailinglist_' . $this->id . '">' . __( 'Mailing list', 'MailPress' ) . '</label>' . "\r\n";
		$out .= MP_Mailinglist::dropdown( array( 'htmlname' => "description[settings][{$this->id}][mailinglist_id]", 'htmlid' => "autoresponder_mailinglist_{$this->id}", 'selected' => $mailinglist_id, 'hierarchical' => true, 'orderby' => 'name', 'hide_empty' => '0', 'echo' => false, ) ) . "\r\n";
		$out .= '<p>' . __( 'For that mailinglist', 'MailPress' ) . '</p>' . "\r\n";

		echo $out;
	}
}