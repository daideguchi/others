<?php
abstract class MP_Swift_signer_
{
	function __construct() 
	{
// for signer type & settings
		add_filter( 'MailPress_Swift_Signer_type', 					array( $this, 'Swift_Signer_type' ), 8, 1 );
// for signer
		add_filter( "MailPress_Swift_Signer_{$this->Swift_Signer_type}",	array( $this, 'sign' ), 8, 1 );
	}

	function Swift_Signer_type( $x ) { return $this->Swift_Signer_type; }
}