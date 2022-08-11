<?php
class MP_Mail_draft
{
	public static $pst_;

	public static function update( $id, $status = 'draft' )
	{
		global $wpdb, $mp_general;
		$id = ( int ) $id;

		wp_cache_delete( $id, 'mp_mail' );
		$draft = MP_Mail::get( $id );

// scheduled ?
		$scheduled = false;
		$draft->sent = '0000-00-00 00:00:00';

		wp_clear_scheduled_hook( 'mp_process_send_draft', array( $id ) );

		self::$pst_ = MP_WP_Ajax::$pst_ ?? MP_AdminPage::$pst_;

		if ( isset( self::$pst_['aa'] ) ) 
		{
			foreach ( array( 'aa', 'mm', 'jj', 'hh', 'mn' ) as $timeunit ) 
			{
				$$timeunit = self::$pst_[$timeunit];
				if ( self::$pst_['cur_' . $timeunit] == self::$pst_[$timeunit] ) continue;
	
				$scheduled = true;
			}
		// update schedule ?
			if ( $scheduled )
			{
				$aa = ( $aa < 1 )  ? date( 'Y' ) : $aa;
				$maxd = array( 31,( !( $aa%4 )&&( $aa%100||!( $aa%400 ) ) )?29:28,31,30,31,30,31,31,30,31,30,31 ); 
				$mm = ( $mm < 1 || $mm > 12 ) ? date( 'n' ) : $mm;
				$jj = ( $jj < 1 ) ? 1 : $jj;
				$jj = ( $jj > $maxd[$mm-1] ) ? $maxd[$mm-1] : $jj;
				$hh = ( $hh < 0 || $hh > 23 ) ? 00 : $hh;
				$mn = ( $mn < 0 || $mn > 59 ) ? 00 : $mn;
	
				$draft->sent = date( 'Y-m-d H:i:s', mktime( $hh, $mn, 0, $mm, $jj, $aa ) );
				$sched_time  = strtotime( get_gmt_from_date( $draft->sent ) . ' GMT' );

				wp_schedule_single_event( $sched_time, 'mp_process_send_draft', array( $id ) );

				$old_sched = strtotime( get_gmt_from_date( date( 'Y-m-d H:i:s', mktime( self::$pst_['hidden_hh'], self::$pst_['hidden_mn'], 0, self::$pst_['hidden_mm'], self::$pst_['hidden_jj'], self::$pst_['hidden_aa'] ) ) ) . ' GMT' );
			}
		}

// process attachments
		if ( isset( self::$pst_['type_of_upload'] ) )
		{
			$files = array();
			if ( isset( self::$pst_['Files'] ) ) foreach ( self::$pst_['Files'] as $k => $v ) if ( is_numeric( $k ) ) $files[] = $k;

			$attach = ( empty( $files ) ) ? '' : join( ', ', $files );

			$file_exits = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id FROM $wpdb->mp_mailmeta WHERE mp_mail_id = %d AND meta_key = %s", $id, '_MailPress_attached_file' ) . ( ( empty( $attach ) ) ? ';' : " AND meta_id NOT IN ( $attach );" ) );
			if ( $file_exits ) foreach( $file_exits as $entry ) MP_Mail_meta::delete_by_id( $entry->meta_id );
		}

// mail_format

		if ( isset( self::$pst_['mail_format'] ) )
		{
			MP_Mail_meta::delete( $id, '_MailPress_format' );
			if ( !empty( self::$pst_['mail_format'] ) ) MP_Mail_meta::add( $id, '_MailPress_format', self::$pst_['mail_format'], true );
		}

// recipients
		if ( isset( self::$pst_['to_list'] ) && !empty( self::$pst_['to_list'] ) )
		{
			self::$pst_['toemail'] = self::$pst_['to_list'];
			self::$pst_['toname']  = '';
		}

// content
		if ( isset( self::$pst_['content'] ) ) self::$pst_['html'] = self::$pst_['content'];
		unset( self::$pst_['content'] );


		self::$pst_ = stripslashes_deep( self::$pst_ );


// from
		$fromemail = trim( self::$pst_['fromemail'] );
		$fromname  = trim( self::$pst_['fromname'] ) ;
		if ( $fromemail == $mp_general['fromemail'] && $fromname == $mp_general['fromname'] ) $fromemail = $fromname = '';

		$data = $format = $where = $where_format = array();

		$data['status'] 	= $status; 								$format[] = '%s';
		$data['theme'] 		= self::$pst_['Theme'] ?? '';					$format[] = '%s';
		$data['fromemail']	= $fromemail;		 						$format[] = '%s';
		$data['fromname'] 	= $fromname ; 								$format[] = '%s';
		$data['toemail'] 	= trim( self::$pst_['toemail'] ); 				$format[] = '%s';
		$data['toname'] 	= trim( self::$pst_['toname'] ) ; 				$format[] = '%s';
		$data['subject'] 	= trim( self::$pst_['subject'] );				$format[] = '%s';
		$data['html'] 		= trim( self::$pst_['html'] ); 					$format[] = '%s';
		$data['plaintext'] 	= trim( self::$pst_['plaintext'], " \r\n" ); 		$format[] = '%s';
		$data['created'] 	= self::$pst_['created'] ?? current_time( 'mysql' );	$format[] = '%s';
		$data['created_user_id']= MP_WP_User::get_id(); 					$format[] = '%d';
		$data['sent'] 		= $draft->sent; 							$format[] = '%s';

		if ( $scheduled )
			$data['sent_user_id']   = $data['created_user_id'];				$format[] = '%d';

		$where['id'] 		= $id;								$where_format[] = '%d';

		$wpdb->update( $wpdb->mp_mails, $data, $where, $format, $where_format );

		return ( $scheduled && $sched_time != $old_sched );
	}

	public static function reset_scheduled( $id = NULL )
	{
		if ( NULL == $id ) return false;
		$id = ( int ) $id;

		wp_clear_scheduled_hook( 'mp_process_send_draft', array( $id ) );

		$data = $format = $where = $where_format = array();

		$data['sent']	= '0000-00-00 00:00:00';	$format[] = '%s';

		$where['id'] 	= $id;				$where_format[] = '%d';

		global $wpdb;
		$wpdb->update( $wpdb->mp_mails, $data, $where, $format, $where_format );
	}

	public static function send( $id, $args = array() ) 
	{
		$defaults = array( 	'ajax'		=> 0,
		 );
		$r = wp_parse_args( $args, $defaults );
		extract( $r );

		$id = ( int ) $id;

		self::reset_scheduled( $id );

		$template = apply_filters( 'MailPress_draft_template', false, $id );

		$draft = MP_Mail::get( $id );

		if ( 'draft' != $draft->status ) return false;
		$mail 		= new stdClass();	/* so we duplicate the draft into a new mail */
		$mail->id 		= MP_Mail::get_id( __CLASS__ . ' ' . __METHOD__ );
		$mail->main_id 	= $id;

		if ( !empty( $draft->theme ) ) $mail->Theme = $draft->theme;
		if ( !empty( $template ) )     $mail->Template = $template;

		if ( !empty( $draft->fromemail ) )
		{
			$mail->fromemail= $draft->fromemail;
			$mail->fromname	= $draft->fromname;
		}

		if ( isset( $toemail ) && !empty( $toemail ) )
		{
			$mail->toemail	= $toemail;
			$mail->toname	= $toname ?? '';
		}
		else
		{
			$query = self::get_query_mailinglist( $draft->toemail );
			if ( $query )
			{
				MP_Mail_meta::add( $mail->id, '_mailinglist_id', $draft->toemail, true );
				$draft_dest = MP_User::get_mailinglists();
				MP_Mail_meta::add( $mail->id, '_mailinglist_desc', $draft_dest[$draft->toemail], true );

				$mail->recipients_query = $query;

				$list_id = self::get_query_list_id( $draft->toemail );
				if ( $list_id ) $mail->_list_id = $list_id;
			}
			else
			{
				if 	( !MailPress::is_email( $draft->toemail ) ) return 'y';
				$mail->toemail	= $draft->toemail;
				$mail->toname	= $draft->toname;
			}
		}

		$mail->subject	= $draft->subject;
		$mail->html		= $draft->html;
		$mail->plaintext	= $draft->plaintext;

		$mail->wp_user_id	= $draft->created_user_id;

		$mail->draft 	= true;

		$count = MailPress::mail( $mail );

		if ( 0 === $count )		return 'x'; // no recipient
		if ( !$count ) return 0;			// something wrong !

		if ( $ajax ) 	return array( $mail->id );
		return $count;
	}

//// Recipients queries ////

	public static function get_query_mailinglist( $draft_toemail )
	{
		switch ( $draft_toemail )
		{
			case '1' :
           			global $wpdb;
				return "SELECT id, email, name, status, confkey FROM $wpdb->mp_users WHERE status = 'active';";
			break;
/* 2 & 3 used by comments */
			case '4' :
           			global $wpdb;
				return "SELECT id, email, name, status, confkey FROM $wpdb->mp_users WHERE status IN ( 'active', 'waiting' );";
			break;
			case '5' :
           			global $wpdb;
				return "SELECT id, email, name, status, confkey FROM $wpdb->mp_users WHERE status IN ( 'waiting' );";
			break;
			default :
				return apply_filters( 'MailPress_query_mailinglist', false, $draft_toemail );
			break;
		}
		return false;
	}


//// Recipients lists ////

	public static function get_query_list_id( $draft_toemail )
	{
		return ( in_array( $draft_toemail, array( 1, 4, 5, ) ) ) ? 'MailPress.' . $draft_toemail : apply_filters( 'MailPress_query_list_id', false, $draft_toemail );
	}
}