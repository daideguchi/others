<?php
class MP_WP_Ajax
{
	public static $get_;
	public static $pst_;
	public static $req_;

	function __construct()
	{
		self::get_request();

		if ( !isset( self::$req_['mp_action'] ) ) MP_::mp_die( -1 );

		$action = str_replace( '-', '_', self::$req_['mp_action'] );

		if ( method_exists( __CLASS__, $action ) ) self::$action();
		else do_action( "mp_action_{$action}" );
                
		die();
	}

	public static function get_request()
	{
		foreach( array( 'get_' => 	INPUT_GET, 'pst_' => INPUT_POST ) as $k => $v )
		{
			self::$$k = filter_input_array( $v );
			if ( is_null( self::$$k ) ) self::$$k = array();
		}
		self::$req_ = array_merge( self::$get_, self::$pst_ );
	}

//// LIST ////

	public static function dim_mail() 
	{
		MP_Mail::dim_object();
	}

	public static function add_mail() 
	{
		MP_Mail::add_object();
	}

	public static function delete_mail() 
	{
		MP_Mail::delete_object();
	}

	public static function add_user() 
	{
		MP_User::add_object();
	}

	public static function dim_user() 
	{
		MP_User::dim_object();
	}

	public static function delete_user() 
	{
		MP_User::delete_object();
	}

//// CUSTOM FIELDS ////

	public static function add_mailmeta()
	{
		MP_Mail_customfields::add();
	}

	public static function delete_mailmeta()
	{
		MP_Mail_customfields::delete();
	}

	public static function add_usermeta()
	{
		MP_User_customfields::add();
	}

	public static function delete_usermeta()
	{
		MP_User_customfields::delete();
	}

////  VIEW MAIL/THEME in thickbox  ////

	public static function get_previewlink()
	{
		$args = array( 'id' => 0, 'main_id' => 0, 'action' => 'mp_ajax', 'mp_action' => 'iview', 'TB_iframe' => 'true' );
		$args['id']		= ( isset( self::$pst_['id'] ) ) ? intval( self::$pst_['id'] ) : 0;
		$args['main_id']	= ( isset( self::$pst_['main_id'] ) ) ? intval( self::$pst_['main_id'] ) : 0;
		$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );    

		MP_::mp_die( $view_url );
	}

	public static function iview()
	{
		$mp_general = get_option( MailPress::option_name_general );

		$id 		= self::$get_['id'];
		$main_id	= self::$get_['main_id'] ?? $id;

		$mail 	= MP_Mail::get( $id );
                
		if ( !$mail ) return false;

		$theme 	= ( isset( self::$get_['theme'] ) && !empty( self::$get_['theme'] ) ) ? self::$get_['theme'] : ( !empty( $mail->theme ) ? $mail->theme : false );
		$mp_user_id= ( isset( self::$get_['mp_user_id'] )  && !empty( self::$get_['mp_user_id'] ) )  ? self::$get_['mp_user_id']  : false;

	// from
		$from 	= ( !empty( $mail->fromemail ) ) ? MP_Mail::display_toemail( $mail->fromemail, $mail->fromname ) : MP_Mail::display_toemail( $mp_general['fromemail'], $mp_general['fromname'] );
	// to
		$to 		= MP_Mail::display_toemail( $mail->toemail, $mail->toname, '', $mp_user_id );
	// subject
		$x = new MP_Mail();
		$subject 	= ( in_array( $mail->status, array( 'sent', 'archived' ) ) ) ? $mail->subject : $x->do_eval( $mail->subject );
		$subject 	= $x->viewsubject( $subject, $id, $main_id, $mp_user_id );
	// template
		$template   = ( in_array( $mail->status, array( 'sent', 'archived' ) ) ) ? false : apply_filters( 'MailPress_draft_template', false, $main_id );

	// content
		$args				= array();
		$args['action'] 	= 'mp_ajax';
		$args['mp_action'] 	= 'viewadmin';
		foreach( array( 'id', 'main_id', 'theme', 'template', 'mp_user_id' ) as $x ) if ( $$x ) $args[$x] = $$x;

		foreach( array( 'html', 'plaintext' ) as $type )
		{
			$args['type'] = $type;
			if ( !empty( $mail->{$type} ) ) $$type = '<iframe id="i' . $type . '" style="width:100%;border:0;height:550px" src="' . esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) ) . '"></iframe>';
		}

	// attachments
		$attachments = '';
		$metas = MP_Mail_meta::has( $args['main_id'], '_MailPress_attached_file' );
		if ( $metas )
		{
			foreach( $metas as $meta )
			{
				$meta_value = unserialize( $meta['meta_value'] );
				$attachments .= '<tr><td><div class="' . self::get_html_mail_icon( $meta_value['name'] ) . '"></div><div>' . MP_Mail::get_attachment_link( $meta, $mail->status ) . '</div></td></tr>';
			}
		}
		$view = true;

		include( MP_ABSPATH . 'mp-includes/html/mail.php' );
	}

	public static function viewadmin() 
	{
		self::$get_['type'] = self::$get_['type'] ?? 'html';
		self::$get_['template'] = apply_filters( 'MailPress_draft_template', self::$get_['template'] ?? false, self::$get_['main_id'] );

		$x = new MP_Mail();
		$x->view( self::$get_ );
	}


////  THEMES  ////

	public static function theme_preview() 
	{
		$args			= array( 'action' => 'mp_ajax', 'mp_action' => 'previewtheme', 'template' => self::$get_['template'], 'stylesheet'=> self::$get_['stylesheet'] );

		foreach( array( 'html', 'plaintext' ) as $type )
		{
			$args['type'] 	= $type;
			$$type		= '<iframe id="i' . $type . '" style="width:100%;border:0;height:550px" src="' . esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) ) . '"></iframe>';
		}

		unset( $view );
		include ( MP_ABSPATH . 'mp-includes/html/mail.php' );
	}

	public static function previewtheme() 
	{
		$url 			= home_url();

		$mail			= new stdClass();
		$mail->Theme 	= self::$get_['stylesheet'];
		$mail->Template 	= 'confirmed';

		$message  = __( 'Congratulations !', 'MailPress' );
		$message .= "\n\n";
		$message .= sprintf( __( 'We confirm your subscription to %1$s emails', 'MailPress' ), get_bloginfo( 'name' ) );
		$message .= "\n\n";

		$mail->plaintext 	= $message;

		$message  = __( 'Congratulations !', 'MailPress' );
		$message .= '<br /><br />';
		$message .= sprintf( __( 'We confirm your subscription to %1$s emails', 'MailPress' ), '<a href="' . $url . '">' . get_bloginfo( 'name' ) . '</a>' );
		$message .= '<br /><br />';

		$mail->html 	= $message;

		$mail->unsubscribe= __( '"Subscription management link"', 'MailPress' );
		$mail->viewhtml 	= __( '"Trouble reading link"', 'MailPress' );

		$x = new MP_Mail();
		$x->args = new stdClass();
		$x->args = $mail;

		$type  = self::$get_['type'];
		$$type = $x->build_mail_content( $type );
		$$type = ( 'html' == $type ) ? $x->process_img( $$type, $x->mail->themedir, 'draft' ) : $$type;
		include MP_ABSPATH . "mp-includes/html/{$type}.php";
	}


////  WRITE  ////

	public static function html2txt() 
	{
		if ( !isset( self::$pst_['html'] ) ) return '';
		$content = trim( stripslashes( self::$pst_['html'] ) );
		if ( empty( $content ) ) return '';
		$content = apply_filters( 'MailPress_the_content', $content );
       		if ( empty( $content ) ) return '';
                
		$txt = new MP_Html2txt( $content );
		echo $txt->get_text();
		die();
	}

	public static function autosave()
	{
		global $current_user;

		$data = '';
		$supplemental = array();
		$do_lock 	= true;

		$working_id = $main_id 	= ( int ) self::$pst_['id'];
		$do_autosave= ( bool ) self::$pst_['autosave'];

		if ( -1 == self::$pst_['revision'] )
		{
			if ( $do_autosave ) 
			{
				if ( !$working_id ) $working_id = $main_id = MP_Mail::get_id( __CLASS__ . ' 1 ' . __METHOD__ );

				MP_Mail_draft::update( $working_id );
				$data = sprintf( __( 'Draft saved at %s.', 'MailPress' ), date( __( 'g:i:s a' ), current_time( 'timestamp' ) ) );
				$supplemental['tipe'] = 'mail';
			}
		}
		else
		{
			if ( $last = MP_Mail_lock::check( $main_id ) ) 
			{
				$do_autosave 	= $do_lock = false;
				$last_user 		= get_userdata( $last );
				$last_user_name 	= ( $last_user ) ? $last_user->display_name : __( 'Someone' );	
				$data 		= new WP_Error( 'locked', sprintf( __( 'Autosave disabled: %s is currently editing this mail.' ) , esc_html( $last_user_name )	 ) );
				$supplemental['disable_autosave'] = 'disable';
			}

			if ( $do_autosave ) 
			{
				$working_id = ( int ) self::$pst_['revision'];
				if ( !$working_id )
				{
					$working_id = MP_Mail::get_id( __CLASS__ . ' 2 ' . __METHOD__ );
					MP_Mail_revision::update( $main_id, $working_id, $current_user->ID );
				}

				MP_Mail_draft::update( $working_id, '' );
				$data = sprintf( __( 'Revision saved at %s.', 'MailPress' ), date( __( 'g:i:s a' ), current_time( 'timestamp', true ) ) );
				$supplemental['tipe'] = 'revision';
			}
			else
			{
				if ( self::$pst_['revision'] ) $working_id = ( int ) self::$pst_['revision'];
				$supplemental['tipe'] = 'revision';
			}
		}

		if ( $do_lock && $working_id ) MP_Mail_lock::set( $main_id );

		$x = new WP_Ajax_Response( array ( 	'what' 	=> 'autosave', 
								'id' 		=> $working_id, 
								'old_id' 	=> $main_id, 
								'type' 	=> false, 
								'data' 	=> $working_id ? $data : '', 
								'supplemental' => $supplemental
		 ) );

		$x->send();
	}

	public static function email() 
	{
		echo ( MailPress::is_email( self::$pst_['email'] ) ) ? 1 : 0;
	}

////  REVISIONS  ////

	function get_revision_diffs() 
	{
		$return = array();
		@set_time_limit( 0 );
  
		foreach ( self::$req_['compare'] as $compare_key ) 
		{
			list( $compare_from, $compare_to ) = explode( ':', $compare_key ); // from:to
  
			$return[] = array( 
				'id' => $compare_key,
				'fields' => MP_Mail_revision::get_ui_diff( self::$req_['mail_id'], $compare_from, $compare_to ),
			 );
		}
		wp_send_json_success( $return );
	}


////  ATTACHMENTS  UPLOAD  ////

	public static function upload_iframe_html()
	{
		$id 		= self::$get_['id'];
		$draft_id 	= self::$get_['draft_id'];
		$bytes 	= apply_filters( 'import_upload_size_limit', wp_max_upload_size() );

		wp_register_script( 'upload_iframe', '/' . MP_PATH . 'mp-includes/js/fileupload/upload_iframe.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'upload_iframe', 'uploadhtmlL10n', array( 
			'id' => $id
		 ) );
		wp_enqueue_script( 'upload_iframe' );

		include MP_ABSPATH . 'mp-includes/html/upload_iframe.php';
	}

	public static function html_mail_attachment() 
	{
		$draft_id 	= self::$req_['draft_id'];
		$id		= self::$req_['id'];
		$file		= self::$req_['file'];

		$xml = self::mail_attachment();

		$xml = str_replace( '>', '&gt;', $xml );
		$xml = str_replace( '<', '&lt;', $xml );

		wp_register_script( 'upload_iframe_xml', '/' . MP_PATH . 'mp-includes/js/fileupload/upload_iframe_xml.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'upload_iframe_xml', 'uploadxmlL10n', array( 
			'id'		=> $id,
			'draft_id' 	=> $draft_id,
			'file' 	=> $file
		 ) );
		wp_enqueue_script( 'upload_iframe_xml' );

		ob_end_clean();
		ob_start();
			include MP_ABSPATH . 'mp-includes/html/upload_iframe_xml.php';
			$html = ob_get_contents();
		ob_end_clean();

		MP_::mp_die( $html );
	}

	public static function html_mail_icon() 
	{
		$fname = self::$req_['fname'];

		MP_::mp_die( self::get_html_mail_icon( $fname ) );
	}

	public static function get_html_mail_icon( $fname ) 
	{
		if ( !class_exists( 'MP_Tracking_files', false ) ) new MP_Tracking_files();

		$fe = apply_filters( 'MailPress_tracking_files_ext_get', pathinfo( $fname, PATHINFO_EXTENSION ) );

		return ( isset( $fe->classes ) ) ? $fe->classes : 'mp_ext mp_ext_unknown';
	}

	public static function mail_attachment()
	{
		$data = self::handle_upload( 'async-upload', self::$req_['draft_id'] );

		if ( is_wp_error( $data ) ) 
		{
			$xml  = "<error><![CDATA[" . $data->get_error_message() . "]]></error>";
		}
		else
		{
			$xml  = "<id><![CDATA[" . $data['id'] . "]]></id>";
			$xml .= "<url><![CDATA[" . $data['url'] . "]]></url>";
			$xml .= "<file><![CDATA[" . $data['file'] . "]]></file>";
		}

		return "<?xml version='1.0' standalone='yes'?><mp_fileupload>$xml</mp_fileupload>";
	}

	public static function handle_upload( $file_id, $draft_id ) 
	{
		$overrides = array( 'test_form'=>false, 'unique_filename_callback' => 'mp_unique_filename_callback' );
		$time = current_time( 'mysql' );

		$uploaded_file = wp_handle_upload( $_FILES[$file_id], $overrides, $time );

		if ( isset( $uploaded_file['error'] ) )
			return new WP_Error( 'upload_error', $uploaded_file['error'] );

// Check file path is ok
		$uploads = wp_upload_dir();
		if ( $uploads && ( false === $uploads['error'] ) ) 							// Get upload directory
		{ 	
			if ( 0 === strpos( $uploaded_file['file'], $uploads['basedir'] ) ) 				// Check that the upload base exists in the file path
			{
				$file = str_replace( $uploads['basedir'], '', $uploaded_file['file'] ); 		// Remove upload dir from the file path
				$file = ltrim( $file, '/' );
			}
		}

// Construct the attachment array
		$object = array( 
					'name' 	=> $_FILES['async-upload']['name'], 
					'mime_type'	=> $uploaded_file['type'], 
					'file'	=> $file, 
					'file_fullpath'	=> str_replace( "\\", "/", $uploaded_file['file'] ), 
					'guid' 	=> $uploaded_file['url']
				 );
// Save the data
		$id = MP_Mail_meta::add( $draft_id, '_MailPress_attached_file', $object );

		$href = esc_url( add_query_arg( array( 'action' => 'mp_ajax', 'mp_action' => 'attach_download', 'id' => $id ), admin_url( 'admin-ajax.php' ) ) );
		return array( 'id' => $id, 'url' => $href, 'file' => $object['file_fullpath'] );
	}

	public static function attach_download()
	{
		$meta_id 	= ( int ) self::$get_['id'];

		$meta = MP_Mail_meta::get_by_id( $meta_id );

		if ( !$meta ) MP_::mp_die( __( 'Cannot Open Attachment 1!', 'MailPress' ) );
		if ( !is_file( $meta->meta_value['file_fullpath'] ) )	MP_::mp_die( __( 'Cannot Open Attachment 2! ' . $meta->meta_value['file_fullpath'], 'MailPress' ) );

		self::download( $meta->meta_value['name'], $meta->meta_value['file_fullpath'], $meta->meta_value['mime_type'] );
	}

	public static function delete_attachment()
	{
		if ( !isset( self::$pst_['meta_id'] ) ) return;
		if ( !is_numeric( self::$pst_['meta_id'] ) ) return;

		$meta_id = ( int ) self::$pst_['meta_id'];
		MP_Mail_meta::delete_by_id( $meta_id );
		MP_::mp_die( 1 );
	}

////  MAPS  ////

	public static function latlng()
	{
		$g = MP_Ip::get_current_latlng();

		if (empty( $g ) ) wp_send_json_error( $g );

		wp_send_json_success( $g );
	}

	public static function map_settings()
	{
		if ( 'mp_user' == self::$pst_['type'] )
		{
			if ( !MP_User_meta::add(   self::$pst_['id'], '_MailPress_' . self::$pst_['prefix'], self::$pst_['settings'], true ) )
				MP_User_meta::update( self::$pst_['id'], '_MailPress_' . self::$pst_['prefix'], self::$pst_['settings'] );
		}
		else
		{
			if ( !MP_Mail_meta::add(   self::$pst_['id'], '_MailPress_' . self::$pst_['prefix'], self::$pst_['settings'], true ) )
				MP_Mail_meta::update( self::$pst_['id'], '_MailPress_' . self::$pst_['prefix'], self::$pst_['settings'] );
		}
		MP_::mp_die();

		update_user_meta( MP_WP_User::get_id(), '_MailPress_' . self::$pst_['prefix'], self::$pst_['settings'] );
		MP_::mp_die();
	}

	public static function staticmap()
	{
		unset( self::$pst_['action'] );

		$s = MP_Map::get_staticmap( false, self::$pst_ );

		if (empty( $s ) ) wp_send_json_error( $s );

		wp_send_json_success( $s );
	}

	public static function geocoding()
	{
		$g = MP_Map::get_lnglat( self::$pst_['addr'] );

		if (empty( $g ) ) wp_send_json_error( $g );

		wp_send_json_success( $g );
	}

	public static function rgeocoding()
	{
		$r = MP_Map::get_address( self::$pst_['lng'],  self::$pst_['lat'] );

		if ( empty( $r ) ) wp_send_json_error( $r );

		wp_send_json_success( $r );
	}

////  MISC  ////

	public static function download( $file, $file_fullpath, $mime_type, $name = false )
	{
		$HTTP_USER_AGENT = filter_input( INPUT_SERVER, 'HTTP_USER_AGENT' );

		if ( !$name ) $name = $file;
		if ( strstr( $HTTP_USER_AGENT, 'MSIE' ) ) $file = preg_replace( '/\./', '%2e', $file, substr_count( $file, '.' ) - 1 );

		if( !$fdl = @fopen( $file_fullpath, 'r' ) ) 	MP_::mp_die( __( 'Cannot Open File !', 'MailPress' ) );

		header( "Cache-Control: " );# leave blank to avoid IE errors
		header( "Pragma: " );# leave blank to avoid IE errors
		header( "Content-type: " . $mime_type );
		header( "Content-Disposition: attachment; filename=\"".$file."\"" );
		header( "Content-length:".( string )( filesize( $file_fullpath ) ) );
		sleep( 1 );
		fpassthru( $fdl );
		die();
	}
}