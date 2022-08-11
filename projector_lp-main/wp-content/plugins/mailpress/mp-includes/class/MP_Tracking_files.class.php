<?php
class MP_Tracking_files extends MP_options_
{
	var $path = 'tracking/files';

	public static function get_all()
	{
		return apply_filters( 'MailPress_tracking_files_register', array() );
	}
}