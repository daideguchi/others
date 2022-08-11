<?php
class MP_Swift_Signer_smime extends MP_Swift_signer_
{
	public $Swift_Signer_type = 'SMime';

	function sign( $signer = false )
	{
		$config = get_option( Mailpress_signer_smime::option_name );

		if ( !$config ) return $signer;

		$signer = new Swift_Signers_SMimeSigner();

		$certificate = ( isset( $config['Certificate'] ) && !empty( $config['Certificate'] ) && is_file( $config['Certificate'] ) );
		$privatekey = ( isset( $config['privateKey'] ) && !empty( $config['privateKey'] ) && is_file( $config['privateKey'] ) );
		$passphrase = ( isset( $config['passphrase'] ) && !empty( $config['passphrase'] ) );
		$encryption = ( isset( $config['Encryption'] ) && !empty( $config['Encryption'] ) && is_file( $config['Encryption'] ) );

		if ( $certificate && $privatekey )
		{
			if ( $passphrase ) 	$signer->setSignCertificate( $config['Certificate'], [$config['privateKey'], $config['passphrase']] );
			else				$signer->setSignCertificate( $config['Certificate'],  $config['privateKey'] );
		}

		if ( $encryption ) $signer->setEncryptCertificate( $config['Encryption'] );


		return $signer;
	}
}