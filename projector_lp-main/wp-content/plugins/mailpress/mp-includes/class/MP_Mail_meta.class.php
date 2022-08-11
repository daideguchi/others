<?php
class MP_Mail_meta extends MP_WP_Meta
{
	const object_type = 'mail';

	public static function get_protected()
	{
		return array( '_MailPress_attached_file', '_MailPress_batch_send', '_MailPress_mail_link', '_MailPress_mail_opened', '_MailPress_mail_revisions', '_edit_lock', '_edit_last' );
	}
}