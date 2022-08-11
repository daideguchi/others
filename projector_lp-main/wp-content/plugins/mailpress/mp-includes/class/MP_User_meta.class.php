<?php
class MP_User_meta extends MP_WP_Meta
{
	const object_type = 'user';

	public static function get_protected()
	{
		$protected[] = '_MailPress_mail_sent';
		if ( class_exists( 'MailPress_newsletter' ) ) $protected[] = MailPress_newsletter::meta_key;
		return $protected;
	}
}