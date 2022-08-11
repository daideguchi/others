<?php
abstract class MP_WP_db_connect_
{
	function mysql_disconnect( $x = '0' )
	{
		global $wpdb;
		if ( isset( $this->trace ) ) $this->trace->log( "!            ! [notice] MailPress - Disconnecting from " . DB_NAME . " ( $x )" );

		$closed = $wpdb->close();

		if ( isset( $this->trace ) ) $this->trace->log( "!            ! [notice] MailPress - Disconnected ( $x )" );
	}

	function mysql_connect( $x = '0' )
	{
		global $wpdb;
		if ( isset( $this->trace ) ) $this->trace->log( "!            ! [notice] MailPress - Connecting to " . DB_NAME . " ( $x )" );

		$wpdb->__construct( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );

		if ( isset( $this->trace ) ) $this->trace->log( "!            ! [notice] MailPress - Connected ( $x )" );
	}
}