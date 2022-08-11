<?php
class MP_WP_Pluggable
{
	public static function wp_mail( $to, $subject, $message, $headers = '', $attachments = false ) 
	{
		$atts = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ) );

		$atts['to']          = $atts['to']          ?? array();
		$atts['subject']     = $atts['subject']     ?? '';
		$atts['message']     = $atts['message']     ?? '';
		$atts['headers']     = $atts['headers']     ?? array();
		$atts['attachments'] = $atts['attachments'] ?? array();

		$mail = new stdClass();
		$mail->replacements = $mail->recipients = array();

// attachments
		$attachments = self::wp_mail_arg_in_array( $atts['attachments'], "\n" );

		if ( is_array( $attachments ) )
		{
			foreach ( $attachments as $attachment )
			{
				$attachment = @str_replace( "\\", "/", $attachment );
				if ( @is_file( $attachment ) )
				{
					if ( !isset( $mail->id ) ) $mail->id = MP_Mail::get_id( 'wp_mail_5_4_a' );

					$object = array( 	'name' 	=> basename( $attachment ), 
								'mime_type'	=> 'application/octet-stream', 
								'file'	=> '', 
								'file_fullpath'	=> $attachment, 
								'guid' 	=> ''
					 );
					MP_Mail_meta::add( $mail->id, '_MailPress_attached_file', $object );
				}
			}
		}

// headers
// 'to' can be headers AND string|array of comma separated list of emails !

		$to      = self::wp_mail_arg_in_array( $atts['to'],      ','  );
		$headers = self::wp_mail_arg_in_array( $atts['headers'], "\n" );

		$recipients = array();
		// 'to' always first 
		$_accepted_headers = array( 'to', 'bcc', 'cc', 'from', 'reply_to', 'return_path', );
		// custom headers starting with 'X-' are also accepted
		$_headers = array();

		if ( !empty( $headers ) )
		{
			if ( !isset( $mail->id ) ) $mail->id = MP_Mail::get_id( 'wp_mail_5_4_b' );
			MP_Mail_meta::add( $mail->id, '_MailPress_original_headers', $atts['headers'] );

			foreach ( (array) $headers as $header )
			{
				list( $name, $content ) = explode( ':', $header, 2 );
				$name     = trim( $name );
				$content  = trim( $content );

				$_name    = strtolower( str_replace( '-', '_', $name ) );

				switch ( true )
				{
					case ( in_array( $_name, $_accepted_headers ) ) :
						if ( !isset( $$_name ) ) $$_name = array();
						$$_name[] = $content;
					break;
					case ( strpos( $name, 'X-' ) === 0 ) :
						$_headers['X'][][$name] = $content;
					break;
				}
			}
		}

		foreach( $_accepted_headers as $_name ) 
		{
			if ( !isset( $$_name ) ) continue;
			$$_name = self::wp_mail_arg_in_array( $$_name, ',' );
                        if ( empty( $$_name ) ) { unset( $$_name ); continue; }

			switch( $_name )
			{
				case 'from' :
					list( $from_email, $from_name ) = self::wp_mail_header_to_email( array_shift( $$_name ) );
				break;
				case 'return_path' :
					list( $email, $ename ) = self::wp_mail_header_to_email( array_shift( $$_name ) );
					if ( $email ) $_headers[$_name][0] = $email;
				break;
				case 'to' :
				case 'cc' :
				case 'bcc' :
				case 'reply_to' :
					foreach( $$_name as $content )
					{
						list( $email, $ename ) = self::wp_mail_header_to_email( $content );
						switch( $_name )
						{
							case 'to' :
								if ( $email && $ename ) $recipients[$email] = $ename;
								elseif ( $email ) $recipients[$email] = '';
							break;
							default :
								if ( $email && $ename ) $_headers[$_name][$email] = $ename;
								elseif ( $email ) $_headers[$_name][$email] = '';
							break;
						}
					}
				break;
			}
		}

		if ( !empty( $_headers ) ) 
		{
			if ( !isset( $mail->id ) ) $mail->id = MP_Mail::get_id( 'wp_mail_5_4_c' );
			MP_Mail_meta::add( $mail->id, '_MailPress_accepted_headers', $_headers, true );
		}

//////////////////////////

// filters for from
		$from_email = apply_filters( 'wp_mail_from',      $from_email ?? false );
		$from_name  = apply_filters( 'wp_mail_from_name', $from_name  ?? false );

// from
		$mail->fromemail  = $from_email ?: NULL;
		$mail->fromname   = $from_name  ?: NULL;

// to
		$mail->recipients = $recipients;

// subject
		$subject = $atts['subject'] ?? '';
		$mail->subject = $subject;

// message
		$message = $atts['message'];

		if ( is_array( $message ) )
		{
			if ( isset( $message['plaintext'] ) )  	$mail->plaintext = $message['plaintext'];
			if ( isset( $message['text/plain'] ) ) 	$mail->plaintext = $message['text/plain'];
			if ( isset( $message['html'] ) )  	$mail->html = $message['html'];
			if ( isset( $message['text/html'] ) )  	$mail->html = $message['text/html'];
		}
		else
		{
			$mail->content = $message;
		}

		return MailPress::mail( $mail );
	}

	public static function wp_mail_arg_in_array( $arg, $sep )
	{
		if ( is_array( $arg ) ) $arg = implode( $sep, $arg );
		$arg = array_unique( array_filter( array_map( 'trim', explode( $sep, trim( str_replace( array( "\r\n", $sep.$sep, $sep.$sep, '  ', '  ', ), array( $sep, $sep, $sep, ' ', ' ', ), $arg ), $sep ) ) ) ) );
		if ( empty( $arg ) ) return array();
		return $arg;
	}

	public static function wp_mail_header_to_email( $string )
	{
		$email = $name = false;

		if ( !is_string( $string ) ) return array( $email, $name, );

		$string = trim( $string );

		if ( preg_match( '/(.*)<(.+)>/', $string, $matches ) && ( count( $matches ) == 3 ) )
		{
			$name  = trim( $matches[1] );

			$beg = substr( $name,  0, 1 );
			$end = substr( $name, -1, 1 );
			if ( ( $beg == '"' ) && ( $end == '"' ) ) $name = trim( substr( $name, 1, -1) );

			$email = trim( $matches[2] );
		}
		else
		{
			$email = trim( $string );
		}

		if ( !MailPress::is_email( $email ) ) $email = false;

		return array( $email, ( $email ) ? $name : false, );
	}

	public static function wp_notify_postauthor( $comment_id, $deprecated = null ) 
	{
		$wp_mail_args = array(
			'to'      => array(),
			'subject' => '',
			'message' => '',
			'headers' => array(),
		);

		$comment = get_comment( $comment_id );
		if ( empty( $comment ) || empty( $comment->comment_post_ID ) ) return false;

		$post    = get_post( $comment->comment_post_ID );
		$author  = get_userdata( $post->post_author );

// to
		if ( $author ) $wp_mail_args['to'][] = $author->user_email;

		$wp_mail_args['to'] = apply_filters( 'comment_notification_recipients', $wp_mail_args['to'], $comment_id );
		$wp_mail_args['to'] = array_filter( $wp_mail_args['to'] );

		if ( ! count( $wp_mail_args['to'] ) ) return false;
		$wp_mail_args['to'] = array_flip( $wp_mail_args['to'] );

		$notify_author = apply_filters( 'comment_notification_notify_author', false, $comment_id );

		if ( $author && ! $notify_author )
		{
			switch( true )
			{
				case ( $comment->user_id == $post->post_author ) :			// The comment was left by the author.
				case ( get_current_user_id() == $post->post_author ) :			// The author moderated a comment on their own post.
				case ( ! user_can( $post->post_author, 'read_post', $post->ID ) ) :	// The post author is no longer a member of the blog.
					unset( $wp_mail_args['to'][$author->user_email] );
				break;
			}
		}

		if ( ! count( $wp_mail_args['to'] ) ) return false;
		$wp_mail_args['to'] = array_flip( $wp_mail_args['to'] );

// subject
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		switch ( $comment->comment_type )
		{
			case 'trackback' :
				$subject = sprintf( __( '[%1$s] Trackback: "%2$s"' ), $blogname, $post->post_title );
			break;
			case 'pingback' :
				$subject = sprintf( __( '[%1$s] Pingback: "%2$s"' ), $blogname, $post->post_title );
			break;
			default: //Comments
				$subject = sprintf( __( '[%1$s] Comment: "%2$s"' ), $blogname, $post->post_title );
			break;
		}
		$wp_mail_args['subject'] = $subject;

// message
		$comment->author_domain = ( WP_Http::is_ip_address( $comment->comment_author_IP ) ) ? gethostbyaddr( $comment->comment_author_IP ) : '';
		$comment_content = wp_specialchars_decode( $comment->comment_content );

		$url['comments'] = get_permalink( $comment->comment_post_ID ) . '#comments';
		$url['permalink']= get_comment_link( $comment );
		$url['trash']  = admin_url( "comment.php?action=trash&c={$comment_id}#wpbody-content" );
		$url['delete'] = admin_url( "comment.php?action=delete&c={$comment_id}#wpbody-content" );
		$url['spam']   = admin_url( "comment.php?action=spam&c={$comment_id}#wpbody-content" );

		$_message = array();
		switch ( $comment->comment_type )
		{
			case 'trackback' :
				$_message[] = sprintf( __( 'New trackback on your post "%s"' ), $post->post_title );
				$_message[] = sprintf( __( 'Website: %1$s (IP address: %2$s, %3$s)' ), $comment->comment_author, $comment->comment_author_IP, $comment->author_domain );
				$_message[] = sprintf( __( 'URL: %s' ), $comment->comment_author_url );
				$_message[] = sprintf( __( 'Comment: %s' ), '' );
				$_message[] = $comment_content;
				$_message[] = '';
				$_message[] = __( 'You can see all trackbacks on this post here:' );
			break;
			case 'pingback' :
				$_message[] = sprintf( __( 'New pingback on your post "%s"' ), $post->post_title );
				$_message[] = sprintf( __( 'Website: %1$s (IP address: %2$s, %3$s)' ), $comment->comment_author, $comment->comment_author_IP, $comment->author_domain );
				$_message[] = sprintf( __( 'URL: %s' ), $comment->comment_author_url );
				$_message[] = sprintf( __( 'Comment: %s' ), '' );
				$_message[] = $comment_content;
				$_message[] = '';
				$_message[] = __( 'You can see all pingbacks on this post here:' );
			break;
			default: //Comments
				$_message[] = sprintf( __( 'New comment on your post "%s"' ), $post->post_title );
				$_message[] = sprintf( __( 'Author: %1$s (IP address: %2$s, %3$s)' ), $comment->comment_author, $comment->comment_author_IP, $comment->author_domain );
				$_message[] = sprintf( __( 'Email: %s' ), $comment->comment_author_email );
				$_message[] = sprintf( __( 'URL: %s' ), $comment->comment_author_url );
				if ( $comment->comment_parent && user_can( $post->post_author, 'edit_comment', $comment->comment_parent ) ) {
					$_message[] = sprintf( __( 'In reply to: %s' ), admin_url( "comment.php?action=editcomment&c={$comment->comment_parent}#wpbody-content" ) );
				}
				$_message[] = sprintf( __( 'Comment: %s' ), '' );
				$_message[] = $comment_content;
				$_message[] = '';
				$_message[] = __( 'You can see all comments on this post here:' );
			break;
		}

		$_message[] = '';
		$_message[] = $url['comments'];
		$_message[] = sprintf( __( 'Permalink: %s' ), $url['permalink'] );
		if ( user_can( $post->post_author, 'edit_comment', $comment_id ) )
		{
			$_message[] = ( EMPTY_TRASH_DAYS ) ? sprintf( __( 'Trash it: %s' ), $url['trash'] ) : sprintf( __( 'Delete it: %s' ), $url['delete'] );
			$_message[] = sprintf( __( 'Spam it: %s' ), $url['spam'] );
		}
		$wp_mail_args['message'] = implode( "\r\n", $_message );		$wp_mail_args['message'] = implode( "\r\n", $_message );

//headers
		$wp_email = 'wordpress@' . preg_replace( '#^www\.#', '', strtolower( $_SERVER['SERVER_NAME'] ) );

		if ( '' == $comment->comment_author ) {
			$wp_mail_args['headers'][] = "From: \"$blogname\" <$wp_email>";
			if ( '' != $comment->comment_author_email ) {
				$wp_mail_args['headers'][] = "Reply-To: $comment->comment_author_email";
			}
		} else {
			$wp_mail_args['headers'][] = "From: \"$comment->comment_author\" <$wp_email>";
			if ( '' != $comment->comment_author_email ) {
				$wp_mail_args['headers'][] = "Reply-To: \"$comment->comment_author_email\" <$comment->comment_author_email>";
			}
		}
		$wp_mail_args['headers'][] = 'Content-Type: text/plain; charset="' . get_option( 'blog_charset' ) . '"';

// filters
		$wp_mail_args['to']      = apply_filters( 'comment_notification_recipients', $wp_mail_args['to'], $comment_id );
		$wp_mail_args['message'] = apply_filters( 'comment_notification_text',       $wp_mail_args['message'], $comment_id );
		$wp_mail_args['subject'] = apply_filters( 'comment_notification_subject',    $wp_mail_args['subject'], $comment_id );
		$wp_mail_args['headers'] = apply_filters( 'comment_notification_headers',    $wp_mail_args['headers'], $comment_id );

// mailpress
// multiple 'to' and headers skipped

		$mail = new stdClass();
		$mail->Template	= 'moderate';
		$mail->toemail 	= $author->user_email;
		$mail->toname   = $author->display_name;
		$mail->subject 	= $wp_mail_args['subject'];
		$mail->content 	= str_replace( "\r\n", "<br />\r\n", $wp_mail_args['message'] );

			$mail->advanced = new stdClass();
			$mail->advanced->comment       = $comment;
			$mail->advanced->user          = $author;
			unset ( $post->post_content, $post->post_excerpt );
			$mail->advanced->post          = $post;
			$mail->advanced->url           = $url;

			$mail->the_title 	       = $post->post_title; 

		return MailPress::mail( $mail );
	}

	public static function wp_notify_moderator( $comment_id ) 
	{
		global $wpdb;

		$wp_mail_args = array(
			'to'      => array(),
			'subject' => '',
			'message' => '',
			'headers' => '',
		);

		$maybe_notify = get_option( 'moderation_notify' );
		$maybe_notify = apply_filters( 'notify_moderator', $maybe_notify, $comment_id );
		if ( ! $maybe_notify ) return true;

		$comment = get_comment( $comment_id );
		if ( empty( $comment ) || empty( $comment->comment_post_ID ) ) return false;

		$post = get_post( $comment->comment_post_ID );
		$author = get_userdata( $post->post_author );

// to
		// Send to the administration and to the post author if the author can modify the comment.
		$wp_mail_args['to'][] = get_option( 'admin_email' );
		if ( $author && !empty( $author->user_email ) && ( get_option( 'admin_email' ) != $author->user_email ) && user_can( $author->ID, 'edit_comment', $comment_id ) )
			$wp_mail_args['to'][] = $author->user_email;

// subject
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$wp_mail_args['subject'] = sprintf( __( '[%1$s] Please moderate: "%2$s"' ), $blogname, $post->post_title );

// message
		$comment->author_domain = ( WP_Http::is_ip_address( $comment->comment_author_IP ) ) ? gethostbyaddr( $comment->comment_author_IP ) : '';
		$comment->waiting = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '0'" );
		$comment_content = wp_specialchars_decode( $comment->comment_content );

		$url['approve']= admin_url( "comment.php?action=approve&c={$comment_id}#wpbody-content" );
		$url['trash']  = admin_url( "comment.php?action=trash&c={$comment_id}#wpbody-content" );
		$url['delete'] = admin_url( "comment.php?action=delete&c={$comment_id}#wpbody-content" );
		$url['spam']   = admin_url( "comment.php?action=spam&c={$comment_id}#wpbody-content" );
		$url['moderate'] = admin_url( "edit-comments.php?comment_status=moderated#wpbody-content" );

		$_message = array();
		switch ( $comment->comment_type )
		{
			case 'trackback':
				$_message[] = sprintf( __( 'A new trackback on the post "%s" is waiting for your approval' ), $post->post_title );
				$_message[] = get_permalink( $comment->comment_post_ID );
				$_message[] = '';
				$_message[] = sprintf( __( 'Website: %1$s (IP address: %2$s, %3$s)' ), $comment->comment_author, $comment->comment_author_IP, $comment->author_domain );
				$_message[] = sprintf( __( 'URL: %s' ), $comment->comment_author_url );
				$_message[] = __( 'Trackback excerpt: ' );
				$_message[] = $comment_content;
			break;
			case 'pingback':
				$_message[] = sprintf( __( 'A new pingback on the post "%s" is waiting for your approval' ), $post->post_title );
				$_message[] = get_permalink( $comment->comment_post_ID );
				$_message[] = '';
				$_message[] = sprintf( __( 'Website: %1$s (IP address: %2$s, %3$s)' ), $comment->comment_author, $comment->comment_author_IP, $comment->author_domain );
				$_message[] = sprintf( __( 'URL: %s' ), $comment->comment_author_url );
				$_message[] = __( 'Pingback excerpt: ' );
				$_message[] = $comment_content;
			break;
			default: //Comments
				$_message[] = sprintf( __( 'A new comment on the post "%s" is waiting for your approval' ), $post->post_title );
				$_message[] = get_permalink( $comment->comment_post_ID );
				$_message[] = '';
				$_message[] = sprintf( __( 'Author: %1$s (IP address: %2$s, %3$s)' ), $comment->comment_author, $comment->comment_author_IP, $comment->author_domain );
				$_message[] = sprintf( __( 'Email: %s' ), $comment->comment_author_email );
				$_message[] = sprintf( __( 'URL: %s' ), $comment->comment_author_url );
				if ( $comment->comment_parent ) {
					$_message[] = sprintf( __( 'In reply to: %s' ), admin_url( "comment.php?action=editcomment&c={$comment->comment_parent}#wpbody-content" ) );
				}
				$_message[] = sprintf( __( 'Comment: %s' ), '' );
				$_message[] = $comment_content;
			break;
		}

		$_message[] = '';
		$_message[] = sprintf( __( 'Approve it: %s' ), $url['approve'] );
		$_message[] = ( EMPTY_TRASH_DAYS ) ? sprintf( __( 'Trash it: %s' ), $url['trash'] ) : sprintf( __( 'Delete it: %s' ), $url['delete'] );
		$_message[] = sprintf( __( 'Spam it: %s' ), $url['spam'] );
		$_message[] = sprintf( 
			_n( 
				'Currently %s comment is waiting for approval. Please visit the moderation panel:',
		 		'Currently %s comments are waiting for approval. Please visit the moderation panel:', 
				$comment->waiting
			),
			number_format_i18n( $comment->waiting )
		 );
		$_message[] = $url['moderate'];

		$wp_mail_args['message'] = implode( "\r\n", $_message );

// filters
		$wp_mail_args['to'] = apply_filters( 'comment_moderation_recipients', $wp_mail_args['to'], $comment_id );
		$wp_mail_args['to'] = array_filter( $wp_mail_args['to'] );	
		
		$wp_mail_args['message'] = apply_filters( 'comment_moderation_text', $wp_mail_args['message'], $comment_id );
		$wp_mail_args['subject'] = apply_filters( 'comment_moderation_subject', $wp_mail_args['subject'], $comment_id );
		$wp_mail_args['headers'] = apply_filters( 'comment_moderation_headers', $wp_mail_args['headers'], $comment_id );


// mailpress
// multiple 'to' and headers skipped

		$mail = new stdClass();
		$mail->Template	= 'moderate';
		$mail->toemail 	= $author->user_email;
		$mail->toname   = $author->display_name;
		$mail->subject 	= $wp_mail_args['subject'];
		$mail->content 	= str_replace( "\r\n", "<br />\r\n", $wp_mail_args['message'] );

			$mail->advanced = new stdClass();
			$mail->advanced->comment = $comment;
			$mail->advanced->user    = $author;	
			unset ( $post->post_content, $post->post_excerpt );
			$mail->advanced->post    = $post;
			$mail->advanced->url     = $url;
		
			$mail->the_title 	 = $post->post_title; 
	
		foreach ( $wp_mail_args['to'] as $email )
		{
			$mail->toemail = $email;
			MailPress::mail( $mail );
		}
		return true;
	}

	public static function wp_password_change_notification( $user ) 
	{
		if ( 0 === strcasecmp( $user->user_email, get_option( 'admin_email' ) ) ) return;

		$wp_mail_args = array(
			'to'      => '',
			'subject' => '',
			'message' => '',
			'headers' => '',
		);

// to 
		$wp_mail_args['to'] = get_option( 'admin_email' );
// subject
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$wp_mail_args['subject'] = __( '[%s] New User Registration' );

// message
		$_message = array();
		$_message[] = sprintf( __( 'Password changed for user: %s' ), $user->user_login );
		$_message[] = '';

		$wp_mail_args['message'] = implode( "\r\n", $_message );

// filters
		$wp_mail_args = apply_filters( 'wp_password_change_notification_email', $wp_mail_args, $user, $blogname );

// mailpress
		$mail = new stdClass();
		$mail->Template	= 'changed_pwd';
		$mail->toemail 	= get_option( 'admin_email' ); // only one recipient
		$mail->toname   = '';
		$mail->subject 	= sprintf( $wp_mail_args['subject'], $blogname );
		$mail->content 	= str_replace( "\r\n", "<br />\r\n", $wp_mail_args['message'] );

			$mail->advanced = new stdClass();
			$mail->advanced->admin   = $mail->toemail;
			$mail->advanced->user    = $user;

		return MailPress::mail( $mail );
	}

	public static function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' )
	{
		// Accepts only 'user', 'admin' , 'both' or default '' as $notify.
		if ( ! in_array( $notify, array( 'user', 'admin', 'both', '' ), true ) ) return;

		$wp_mail_args = array(
			'to'      => '',
			'subject' => '',
			'message' => '',
			'headers' => '',
		);

		$user = get_userdata( $user_id );

// to
		$wp_mail_args['to'] = get_option( 'admin_email' );

// subject
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		if ( 'user' !== $notify )
		{
			$wp_mail_args['subject'] = __( '[%s] New User Registration' );

// message
			$_message = array();
			$_message[] = sprintf( __( 'New user registration on your site %s:' ), $blogname );
			$_message[] = '';
			$_message[] = sprintf( __( 'Username: %s' ), $user->user_login );
			$_message[] = '';
			$_message[] = sprintf( __( 'Email: %s' ), $user->user_email );

			$wp_mail_args['message'] = implode( "\r\n", $_message );

// filters
			$wp_mail_args = apply_filters( 'wp_new_user_notification_email_admin', $wp_mail_args, $user, $blogname );

// mailpress
			$mail = new stdClass();
			$mail->Template	= 'new_user';
			$mail->toemail 	= get_option( 'admin_email' ); // only one recipient
			$mail->toname   = '';
			$mail->subject 	= sprintf( $wp_mail_args['subject'], $blogname );
			$mail->content 	= str_replace( "\r\n", "<br />\r\n", $wp_mail_args['message'] );

			$mail->advanced = new stdClass();
		       	$mail->advanced->admin   = $mail->toemail;
			$mail->advanced->user    = $user;

			MailPress::mail( $mail );
                }

		$wp_mail_args = array(
			'to'      => '',
			'subject' => '',
			'message' => '',
			'headers' => '',
		);

		if ( 'admin' === $notify || empty( $notify ) ) return;

// to
		$wp_mail_args['to'] = $user->user_email;
// subject
		$wp_mail_args['subject'] = __( '[%s] Login Details' );
// message
		$key = get_password_reset_key( $user );
		if ( is_wp_error( $key ) ) return;

		$url = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' );
		$user->plaintext_pass = $url;
		$user->password_url   = $url;

		$_message = array();
		$_message[] = sprintf( __( 'Username: %s' ), $user->user_login );
		$_message[] = '';
		$_message[] = __( 'To set your password, visit the following address:' );
		$_message[] = '';
		$_message[] = $url;
		$_message[] = '';
		$_message[] = wp_login_url();

		$wp_mail_args['message'] = implode( "\r\n", $_message );

// filters
		$wp_mail_args = apply_filters( 'wp_new_user_notification_email', $wp_mail_args, $user, $blogname );

// mailpress
		$mail = new stdClass();
		$mail->Template	= 'new_user';
		$mail->toemail 	= $user->user_email; // only one recipient
		$mail->toname   = '';
		$mail->subject 	= sprintf( $wp_mail_args['subject'], $blogname );
		$mail->content 	= str_replace( "\r\n", "<br />\r\n", $wp_mail_args['message'] );

		$mail->advanced = new stdClass();
		$mail->advanced->user = $user;

		MailPress::mail( $mail );
	}

	public static function retrieve_password_message( $message, $key, $user_login, $user_data  )
	{
		$wp_mail_args = array(
			'to'      => array(),
			'subject' => '',
			'message' => '',
			'headers' => '',
		);

		$user = $user_data;

// to
		$wp_mail_args['to'] = $user_email = $user->user_email;
		$user_login = $user->user_login;

// subject
		$blogname = ( is_multisite() ) ? get_network()->site_name : wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$wp_mail_args['subject'] = sprintf( __( '[%s] Password Reset' ), $blogname );

// message
		$key = get_password_reset_key( $user_data );
		if ( is_wp_error( $key ) ) return $key;

		$url['site']   = network_site_url();
		$url['reset']  = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' );

		$_message = array();
		$_message[] = __( 'Someone has requested a password reset for the following account:' );
		$_message[] = '';
		$_message[] = sprintf( __( 'Site Name: %s' ), $blogname );
		$_message[] = '';
		$_message[] = sprintf( __( 'Username: %s' ), $user_login );
		$_message[] = '';
		$_message[] = __( 'If this was a mistake, just ignore this email and nothing will happen.' );
		$_message[] = '';
		$_message[] = __( 'To reset your password, visit the following address:' );
		$_message[] = '';
		$_message[] = $url['reset'] . "<br />\r\n";

		$wp_mail_args['message'] = implode( "\r\n", $_message );

// mailpress
// filters skipped because we are here through a filter, not a pluggable function

		$mail = new stdClass();
		$mail->Template	= 'retrieve_pwd';
		$mail->toemail 	= $user_email;
		$mail->toname   = $user->display_name;
		$mail->subject 	= $wp_mail_args['subject'];
		$mail->content 	= str_replace( "\r\n", "<br />\r\n", $wp_mail_args['message'] );

			$mail->advanced = new stdClass();
			$mail->advanced->user = $user;
			$mail->advanced->url  = $url;

		if ( MailPress::mail( $mail ) ) return false;
		return $message;
	}

}