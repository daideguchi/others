<?php
class MP_Swift_Signer_dkim extends MP_Swift_signer_
{
	public $Swift_Signer_type = 'DKIM';

	function sign( $signer = false )
	{
		$config = get_option( Mailpress_signer_dkim::option_name );

		if ( !$config ) return $signer;

		if ( !is_file( $config['privateKey'] ) ) return $signer;

		$privateKey = file_get_contents( $config['privateKey'] );

		return new Swift_Signers_DKIMSigner( $privateKey, $config['domainName'], $config['selector'] );
	}
}