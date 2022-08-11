<?php
class MP_Swift
{
	function __construct()
	{
		defined( 'SWIFT_ADDRESSENCODER' ) or define ( 'SWIFT_ADDRESSENCODER',	'idn' );

		require_once ( MP_ABSPATH . 'mp-includes/composer/vendor/autoload.php' );

		Swift_Preferences::getInstance()->setTempDir( MP_UPL_ABSPATH )->setCacheType( 'disk' );
	}
}