<?php
class MP_Import_importers extends MP_options_
{
	var $path = 'import/importers';

	public static function get_all()
	{
		$x = apply_filters( 'MailPress_import_importers_register', array() );
		uasort( $x,array( 'self', 'sort_importers' ) );
		return $x;
	}

	public static function sort_importers( $a, $b ) 
	{
		return strcmp( $a[0], $b[0] );
	}
}