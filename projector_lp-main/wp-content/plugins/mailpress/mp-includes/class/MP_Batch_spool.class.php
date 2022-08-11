<?php
class MP_Batch_spool extends MP_WP_db_connect_
{
	public static $count = 0;

	function __construct()
	{
		$this->config = get_option( MailPress_batch_spool_send::option_name );
		$this->report = array();

		$this->trace = new MP_Log( 'mp_process_batch_spool_send', array( 'option_name' => 'batch_spool_send' ) );

		$this->process();
		if ( $this->have_batch() ) do_action( 'MailPress_schedule_batch_spool_send' );

		$this->write_report();
		$this->trace->end( true );
	}

// have_batch
	function have_batch()
	{
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare( "SELECT count( * ) FROM $wpdb->mp_mails WHERE status IN ( %s , %s ) ;", MailPress_batch_spool_send::status_mail(), 'paused' ) );
	}

// process
	function process()
	{
		if ( self::$count ) return;
		self::$count++;

		global $wpdb;

	// select path
		$this->path = MP_UPL_ABSPATH . 'spool/' . get_current_blog_id() . '/';

	// select mail
		$mails = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->mp_mails WHERE status = %s ;", MailPress_batch_spool_send::status_mail() ) );

		if ( !$mails ) { $this->alldone(); return; }

		$this->mail = $this->mailmeta = false;

		$mail = $mailmeta = $this->mail = $this->mailmeta = false;
		$try = 10000;

		foreach ( $mails as $this->mail )
		{
			$this->spool_path = $this->path . $this->mail->id;
			if ( !is_dir( $this->spool_path ) )     // no spool path for this mail => everything was sent
			{
				$this->update_mail_status();
				continue;
			}

			$this->mailmeta = $this->get_mailmeta();
			if ( !$this->mailmeta ) continue;

			if ( $this->mailmeta['try'] < $try )
			{
				$try = $this->mailmeta['try'];
				$mail = $this->mail;
				$mailmeta = $this->mailmeta;				
			}
		}
		if ( !$mail ) { $this->alldone(); return; }

		$this->mail 	= $mail;
		$this->mailmeta	= $mailmeta;
		$this->spool_path = $this->path . $this->mail->id;
		unset( $mails, $mail, $mailmeta );
                
		$this->mailmeta['pass']++;
		$this->report['header']  = 'Batch Spool Report mail #' . $this->mail->id . '  / count : ' . $this->mailmeta['count'] . ' / per_pass : ' . $this->config['per_pass'] . ' / max_try : ' . $this->config['max_retry'];
		$this->report['start']   = $this->mailmeta;
                
	// recipients
		$max = ( $this->mailmeta['try'] ) ? count( $this->mailmeta['failed'] ) : $this->mailmeta['count'];
		$count_recipients = ( ( $this->mailmeta['processed'] + $this->config['per_pass'] ) > $max ) ? fmod( $max, $this->config['per_pass'] ) : $this->config['per_pass'];
                
        // processing
		if ( !$count_recipients )
		{
			$this->report['processing']  = array_merge( $this->mailmeta, array( ">> WARNING >>" => 'No more recipient' ) );
			$this->mailmeta['processed'] = $this->mailmeta['pass'] = 0;
			$this->mailmeta['try']++;
		}
		else
		{
			$this->mailmeta['processed'] += $count_recipients;
			$this->report['processing'] = $this->mailmeta;
			$this->write_report();
                        
        // saving context, if abort, current recipients may or may be not sent anyway empty spool will tell !
			if ( $this->mailmeta['try'] )
			{
				if ( count( $this->mailmeta['failed'] ) <= $count_recipients ) $this->mailmeta['failed'] = array();
				else for ( $i = 1; $i <= $count_recipients; $i++ ) array_shift( $this->mailmeta['failed'] );
			}

			if ( !MP_Mail_meta::add( $this->mail->id, MailPress_batch_spool_send::meta_key, $this->mailmeta, true ) )
				MP_Mail_meta::update( $this->mail->id, MailPress_batch_spool_send::meta_key, $this->mailmeta );
			$this->trace->restart();

	// sending
			$swiftfailed = $this->send();

	// results
			$this->trace->restart();
			switch ( true )
			{
				case ( is_array( $swiftfailed ) ) : 
					$ko = array_flip( $swiftfailed );
				break;
				default : 
					$ko = array();
					break;
			}

			if ( $this->mailmeta['try'] ) $this->mailmeta['failed'] = array_merge( $ko, $this->mailmeta['failed'] );
			else $this->mailmeta['failed'] = array_merge( $this->mailmeta['failed'], $ko );
		}
	// saving context
		$this->report['end']  = $this->mailmeta;
		if ( !MP_Mail_meta::add( $this->mail->id, MailPress_batch_spool_send::meta_key, $this->mailmeta, true ) )
			MP_Mail_meta::update( $this->mail->id, MailPress_batch_spool_send::meta_key, $this->mailmeta );

	// the end for this mail ?
		if ( $this->mailmeta['sent'] == $this->mailmeta['count'] ) 		$this->update_mail_status();
		if ( $this->mailmeta['try'] >= $this->config['max_retry'] + 1 )   $this->update_mail_status();
	}

// get mailmeta
	function get_mailmeta()
	{
		$mailmeta = MP_Mail_meta::get( $this->mail->id , MailPress_batch_spool_send::meta_key );

		if ( !$mailmeta )
		{
			$mailmeta = array();

			if ( is_serialized ( $this->mail->toemail ) )	$mailmeta['count'] = count( unserialize( $this->mail->toemail ) );
			else								$mailmeta['count'] = 1;

			$mailmeta['sent'] = $mailmeta['try'] = $mailmeta['processed'] = $mailmeta['pass'] = 0;
			$mailmeta['failed'] = array();
			return $mailmeta;
		}

		$failed = ( isset( $mailmeta['failed'] ) ) ? count( $mailmeta['failed'] ) : 0;

		if ( $mailmeta['sent'] == $mailmeta['count'] ) { $this->update_mail_status(); return false; }

		$processed = $mailmeta['processed'];
		$count     = ( $mailmeta['try'] ) ? $failed : $mailmeta['count'];

		if ( $processed >= $count ) 
		{
			$mailmeta['processed'] = $mailmeta['pass'] = 0;
			$mailmeta['try']++;			
		}

		if ( $mailmeta['try'] >= $this->config ['max_retry'] + 1 ) {	$this->update_mail_status(); return false; }
		if ( $mailmeta['try'] && !$failed ) { $this->update_mail_status(); return false; }

		return $mailmeta;
	}

        // finish
	function update_mail_status( $failed = 0 )
	{
		if ( is_dir( $this->spool_path ) )
		{
			$directoryIterator = new DirectoryIterator( $this->spool_path );
			foreach ( $directoryIterator as $file )
			{
				if ( in_array( $file, array( '.', '..' ) ) ) continue;
				if ( unlink( "{$this->spool_path}/{$file}" ) ) $failed++;
			}
			rmdir( $this->spool_path );
		}

		global $wpdb;
				
		$x = $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->mp_mails SET status = 'sent' WHERE id = %d ", $this->mail->id ) );
		if ( !$failed ) MP_Mail_meta::delete( $this->mail->id , MailPress_batch_spool_send::meta_key );
	}

// batch sending
	function send()
	{
           return $this->swift_processing();
	}

// send
	function swift_processing()
	{
		new MP_Swift();
                
	//# Swift spool connection #//

		try 
		{
			$spool_conn = new Swift_SpoolTransport( new Swift_FileSpool( $this->spool_path ) );
		}
		catch ( Exception $e ) 
		{
			if ( !( $e instanceof Swift_SwiftException ) ) throw $e;

			$this->trace->log( 'SWIFTMAILER [ERROR] - ' . "There was an unexpected problem accessing spool :\n\n" . $e->getMessage() . "\n\n" );	
			return false;
		}
                
	//# Swift connection #//

		if ( !has_filter( 'MailPress_Swift_Connection_type' ) ) new MP_Swift_Connection_smtp();

		try 
		{
			$Swift_Connection_type = apply_filters( 'MailPress_Swift_Connection_type', null );

			$conn = apply_filters( "MailPress_Swift_Connection_{$Swift_Connection_type}" , $this->mail->id, $this->trace );
                        
			$swift = new Swift_Mailer( $conn );
		}
		catch ( Exception $e ) 
		{
			if ( !( $e instanceof Swift_SwiftException ) ) throw $e;

			$this->trace->log( 'SWIFTMAILER [ERROR] - ' . "There was a problem connecting with $Swift_Connection_type :\n\n" . $e->getMessage() . "\n\n" );	
			$this->mysql_connect( __CLASS__ . ' connect error :  ' . $Swift_Connection_type );
			return false;
		} 

	//# Swift sending ... #//
		try 
		{
 			$swift = apply_filters( 'MailPress_swift_registerPlugin', $swift );
                        
			$this->mysql_disconnect( __CLASS__ );

		//# swift flushing queues #//
			$spool = $spool_conn->getSpool();
			$spool->setMessageLimit( $this->config['per_pass'] );
			$spool->setTimeLimit( $this->config['time_limit'] );
			$this->mailmeta['sent'] += $spool->flushQueue( $conn, $failures );
		}
		catch ( Exception $e ) 
		{
			if ( !( $e instanceof Swift_SwiftException ) ) throw $e;

			$this->trace->log( 'SWIFTMAILER [ERROR] - ' . "There was a problem sending with $Swift_Connection_type :\n\n" . $e->getMessage() . "\n\n" );	
			$this->mysql_connect( __CLASS__ . ' sending error : ' . $Swift_Connection_type );
			return false;
		}

		$this->mysql_connect( __CLASS__ );
                        
		return $failures;
	}

//reports
	function alldone()
	{
		$this->report['header2'] = 'Batch Spool Report';
		$this->report['alldone']  = true;
	}

	function write_report( $zz = 12 )
	{
		$order = array( 'sent', 'processed', 'try', 'pass', 'failed' );
		$unsets = array(  'count', 'per_pass', 'max_try' );
		$t = ( count( $order ) + 1 ) * ( $zz + 1 ) -1;

		foreach( $this->report as $k => $v )
		{
			switch ( $k )
			{
				case 'header' :
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
					$l = strlen( $v );
					$this->trace->log( '!' . str_repeat( ' ', 5 ) . $v . str_repeat( ' ', $t - 5 - $l ) . '!' );
					$this->trace->log( '!' . str_repeat( ' ', 5 ) . $this->spool_path );
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
					$s = '!            !';
					foreach( $order as $o )
					{
						$l = strlen( $o );
						$s .= " $o" . str_repeat( ' ', $zz - $l -1 ) . '!';
					}
					$this->trace->log( $s );
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
				break;
				case 'header2' :
					$t = count( $order ) * 15;
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
					$l = strlen( $v );
					$this->trace->log( '!' . str_repeat( ' ', 5 ) . $v . str_repeat( ' ', $t - 5 - $l ) . '!' );
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
				break;
				case 'alldone' :
					$t = count( $order ) * 15;
					$v = ' *** ALL DONE ***       *** ALL DONE ***       *** ALL DONE *** '; 
					$l = strlen( $v );
					$this->trace->log( '!' . str_repeat( ' ', 5 ) . $v . str_repeat( ' ', $t -15 - $l ) . '!' );
				break;
				case 'locked' :
					$t = count( $order ) * 15;
					$v = " locked : $v "; 
					$l = strlen( $v );
					$this->trace->log( '!' . str_repeat( ' ', 5  ) . $v . str_repeat( ' ', $t -10 - $l ) . '!' );
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
				break;
				case 'end' :
					$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
				default :
					foreach ( $unsets as $unset ) unset( $v[$unset] );
					$c = 0;
					$l = strlen( $k );
					$s = "! $k" . str_repeat( ' ', $zz - $l -1 ) . '!';
					foreach( $order as $o )
					{
						if ( isset( $v[$o] ) ) { if ( is_array( $v[$o] ) ) $v[$o] = count( $v[$o] ); $l = strlen( $v[$o] ); $s .= str_repeat( ' ', $zz - $l -1 ) . $v[$o] .  ' !'; unset( $v[$o] ); $c++;}
					}
					if ( $c < count( $order ) ) do { $s.= str_repeat( ' ', $zz ) . '!'; $c++;} while( $c <  count( $order ) );
					$this->trace->log( $s );
					if ( !empty( $v ) ) foreach( $v as $a => $b ) $this->trace->log( "$a $b" );
				break;
			}
		}
		$this->trace->log( '!' . str_repeat( '-', $t ) . '!' );
		$this->report = array();
	}
}