<?php
class MP_Mail_links
{
	public static function process() 
	{
		$get_ = filter_input_array( INPUT_GET );

		foreach( $get_ as $method => $mp_confkey ) if ( method_exists( __CLASS__, $method ) ) $results = self::$method( $mp_confkey );

		if ( !isset( $results ) ) return false;

		if ( is_numeric( $results ) )
		{
			$errs[1] = __( 'unknown user', 'MailPress' );
			$errs[2] = __( 'unknown user', 'MailPress' );
			$errs[3] = __( 'cannot activate user', 'MailPress' );
			$errs[4] = __( 'user already active', 'MailPress' );
			$errs[5] = __( 'unknown user', 'MailPress' );
			$errs[6] = __( 'user not a recipient', 'MailPress' );
			$errs[7] = __( 'user not a recipient', 'MailPress' );
			$errs[8] = __( 'unknown mail', 'MailPress' );
			$errs[9] = __( 'unknown user', 'MailPress' );

			$content  = '<p>' . sprintf( __( '<p> ERROR # %1$s (%2$s) !</p>', 'MailPress' ), $results, $errs[$results] ) . "</p>\n";
			$content .= '<p>' . __( 'Check you are using the appropriate link.', 'MailPress' ) . "</p>\n";
			$content .= "<br />\n";

			return array( 'title' => '', 'content' => $content );
		}
		
		return $results;
	}

	public static function add( $mp_confkey )
	{
		$mp_user_id = MP_User::get_id( $mp_confkey );
		if ( !$mp_user_id ) 						return 5;
		if ( 'active' == MP_User::get_status( $mp_user_id ) ) 	return 4;
		if ( !MP_User::set_status( $mp_user_id, 'active' ) ) 	return 3;

		$email 	= MP_User::get_email( $mp_user_id );
		$url 		= MP_User::get_unsubscribe_url( $mp_confkey );

		$title 	= __( 'Subscription confirmed', 'MailPress' );
		$content 	= '';

		$content .= sprintf( __( '<p><b>%1$s</b> has successfully subscribed.</p>', 'MailPress' ), $email );
		$content .= "<br />\n";
		$content .= "<h3>" . sprintf( __( '<a href="%1$s">Manage Subscription</a>', 'MailPress' ), $url ) . "</h3>\n";
		$content .= "<br />\n";

		return array( 'title' => $title, 'content' => $content );
	}

	public static function del( $mp_confkey )
	{
		$mp_user_id = MP_User::get_id( $mp_confkey );
		if ( !$mp_user_id ) return 1;

		$mp_user = MP_User::get( $mp_user_id );
		$active = ( 'active' == $mp_user->status ) ? true : false;
		$comment = ( $active || ( 'waiting' == $mp_user->status ) );

		$title    =  sprintf( __( 'Manage Subscription (%1$s)', 'MailPress' ), $mp_user->email );
		$content = '';

		$post_ = filter_input_array( INPUT_POST );

		if ( isset( $post_['cancel'] ) )
		{
			$content .= '<p>' . __( 'Cancelled action', 'MailPress' ) ."</p>\n";
			$content .= "<br />\n";
			return array( 'title' => $title, 'content' => $content );
		}

		if ( isset( $post_['delconf'] ) )
		{
			if ( $mp_user->name != $post_['mp_user_name'] )
			{
				MP_User::update_name( $mp_user->id, $post_['mp_user_name'] );
				$mp_user->name = $post_['mp_user_name'];
			}

			if ( class_exists( 'MailPress_comment' ) )	 if ( $comment )	MailPress_comment::update_checklist( $mp_user_id );
			if ( class_exists( 'MailPress_newsletter' ) )  if ( $active ) 	MailPress_newsletter::update_checklist( $mp_user_id );
			if ( class_exists( 'MailPress_mailinglist' ) ) if ( $active ) 	MailPress_mailinglist::update_checklist( $mp_user_id );

			$content .= '<div id="moderated" class="updated fade"><p>' . __( 'Subscriptions saved', 'MailPress' ) . '</p></div>' . "\n";
		}

		$content .= '<form method="post">' . "\n";

		$content .= '<div id="mp_mail_links_name">';
		$content .= '<h3>' . __( 'Name', 'MailPress' ) . "</h3>\n";
		$content .= '<input type="text" name="mp_user_name" size="30" value="' . esc_attr( $mp_user->name ) . '" />' . "\n";
		$content .= '</div>'; 

		$args = array( 'htmlstart' => '<li><label for="{{id}}">', 'htmlmiddle'=> '&#160;', 'htmlend' => "</label></li>\n" );
		$ok = false;
		$checklist     = ( class_exists( 'MailPress_comment' )     && $comment )	? MailPress_comment::get_checklist( $mp_user_id, $args ) 	: false;
		if ( empty( $checklist ) ) $checklist = false;
		if ( $checklist ) 
		{
			$ok = true;
			$content .= '<div id="mp_mail_links_comments">';
			$content .= "<h3>" . __( 'Comments' ) . "</h3>\n";
			$content .= "<ul>$checklist</ul>" ; 
			$content .= '</div>'; 
		}

		$checklist  = ( class_exists( 'MailPress_newsletter' )  && $active ) 	? MailPress_newsletter::get_checklist( $mp_user_id, $args )	: false;
		if ( empty( $checklist ) ) $checklist = false;
		if ( $checklist ) 
		{	
			$ok = true;	
			$content .= '<div id="mp_mail_links_newsletters">';
			$content .= "<h3>" . __( 'Newsletters', 'MailPress' ) . "</h3>\n";
			$content .= "<ul>$checklist</ul>" ; 
			$content .= '</div>'; 
		}

		$checklist = ( class_exists( 'MailPress_mailinglist' ) && $active )	? MailPress_mailinglist::get_checklist( $mp_user_id, $args )	: false;
		if ( empty( $checklist ) ) $checklist = false;
		if ( $checklist )
		{	
			$ok = true;	
			$content .= '<div id="mp_mail_links_mailinglists">';
			$content .= "<h3>" . __( 'Mailing lists', 'MailPress' ) . "</h3>\n";
			$content .= "<ul>$checklist</ul>" ; 
			$content .= '</div>'; 
		}

		if ( $ok )
		{
			$content .= '	<input type="hidden" name="status" value="' . esc_attr( MP_User::get_status( $mp_user_id ) ) . '" />' . "\n<br /><p>";
			$content .= '	<input type="submit" name="delconf" class="button" value="' . esc_attr( __( 'OK', 'MailPress' ) )     . '" />' . "\n";
			$content .= '	<input type="submit" name="cancel"  class="button" value="' . esc_attr( __( 'Cancel', 'MailPress' ) ) . '" /></p>' . "\n";
		}
		else
		{
			$content .= '<br /><br />';
			if ( $active || $comment ) 	$content .= __( 'Nothing to subscribe for ...', 'MailPress' );
			else					$content .= __( 'Your email has been deactivated, ask the administrator ...', 'MailPress' );
			$content .= '<br /><br />';
		}
		$content .= "</form>\n";
		$content .= "<br />\n";
		$content .= '<h3><a href="' . MP_User::get_delall_url( $mp_confkey ) . '">' . __( 'Delete Subscription', 'MailPress' ) . '</a></h3>' . "\n";
		$content .= "<br />\n";
		return array( 'title' => $title, 'content' => $content );
	}

	public static function delall( $mp_confkey )
	{
		$mp_user_id = MP_User::get_id( $mp_confkey );
		if ( !$mp_user_id ) 						return 2;

		$email 	= MP_User::get_email( $mp_user_id );

		$title = __( 'Unsubscribe', 'MailPress' );
		$content = '';

		$post_ = filter_input_array( INPUT_POST );

		if ( isset( $post_['delconf'] ) ) 
		{
			if ( MP_User::set_status( $mp_user_id, 'unsubscribed' ) )
			{
				$content .= sprintf( __( '<p>We confirm that the email address <b>%1$s</b> has been unsubscribed.</p>', 'MailPress' ), $email );
				$content .= "<br />\n";
				return array( 'title' => $title, 'content' => $content );
			}
		}
		elseif ( isset( $post_['cancel'] ) )
		{
			$content .= '<p>' . __( 'Cancelled action', 'MailPress' ) ."</p>\n";
			$content .= "<br />\n";
			return array( 'title' => $title, 'content' => $content );
		}
		else
		{
			$content .= '<p>' .sprintf( __( '<p>Are you sure you want to unsubscribe <b>%1$s</b> from <b>%2$s</b>.</p>', 'MailPress' ), $email, get_bloginfo( 'name' ) ) ."</p>\n";
			$content .= "<br /><br />\n";
			$content .= '<form method="post">' . "\n";
			$content .= '	<input type="submit" name="delconf" class="button" value="' . __( 'OK', 'MailPress' ) . '" />' . "\n";
			$content .= '	<input type="submit" name="cancel"  class="button" value="' . __( 'Cancel', 'MailPress' ) . '" />' . "\n";
			$content .= "</form>\n";
			$content .= "<br />\n";
			return array( 'title' => $title, 'content' => $content );
		}
	}

	public static function view( $mp_confkey )
	{
		global $mp_general;

		$mp_user_id = MP_User::get_id( $mp_confkey );
		if ( !$mp_user_id ) 							return 9;

		$email 	= MP_User::get_email( $mp_user_id );

		$mail_id = (int) filter_input( INPUT_GET, 'id' );
		$mail = MP_Mail::get( $mail_id );
		if ( !$mail )								return 8;

		$title    = $mail->subject;
		$content = '';

		$is_email = ( MailPress::is_email( $mail->toemail ) );

		if ( $is_email && ( $email != $mail->toemail ) )	return 6;
                
		if ( !$is_email )
		{
			$recipients = unserialize( $mail->toemail );
			if ( !( is_array( $recipients ) && ( isset( $recipients[$email] ) ) ) ) 	return 7;

			$m = MP_Mail_meta::get( $mail_id, '_MailPress_replacements' );
			if ( !is_array( $m ) ) $m = array();

			$replacements = array_merge( $m, $recipients[$email] );

			foreach ( $replacements as $k => $v ) $title = str_replace( $k, $v, $title );

			foreach( array( 'html', 'plaintext' ) as $type ) if ( !empty( $mail->{$type} ) ) {foreach( $replacements as $k => $v ) $mail->{$type} = str_replace( $k, $v, $mail->{$type}, $ch );};
		}

		if ( !empty( $mail->html ) )
		{
			$x = new MP_Mail();
			$content = $x->process_img( $mail->html, $mail->themedir, 'draft' );
		}
		elseif ( !empty( $mail->plaintext ) )
			$content = '<!DOCTYPE html><html ' . get_language_attributes() . '><head><meta charset="' . get_bloginfo( 'charset' ) . '/><meta name="viewport" content="width=device-width" /><title>' . get_bloginfo( 'name' ) . ' &gt; ' . $title  . '</title></head><body>' . '<pre>' . htmlspecialchars( $mail->plaintext, ENT_NOQUOTES ) . '</pre>' . '</body></html>';
/*
		$metas = MP_Mail_meta::has( $mail_id, '_MailPress_attached_file' );
		if ( $metas )
		{
			$content .= '<div id="attachments"><table><tr><td style="vertical-align:top;">' . __( 'Attachments', 'MailPress' ) . '</td><td><table>';
                        foreach( $metas as $meta ) { $content .= '<tr><td>&#160;' . MP_Mail::get_attachment_link( $meta, $mail->status ) . '</td></tr>'; }
			$content .= '</table></td></tr></table></div>' . "\n";
		}
*/

		if ( !isset( $mp_general['fullscreen'] ) ) 		return array( 'title' => $title, 'content' => $content );
		
		die( $content );
	}

	public static function arch( $mp_confkey )
	{
		global $mp_general;

		if ( $mp_confkey ) 							return 9;

		$mail_id = (int) filter_input( INPUT_GET, 'id' );
		$mail = MP_Mail::get( $mail_id );
		if ( !$mail )								return 8;
		if ( 'archived' != $mail->status )  				return 8;

		$title    = $mail->subject;
		$content = '';

		if ( !empty( $mail->html ) )
		{
			$x = new MP_Mail();
			$content = $x->process_img( $mail->html, $mail->themedir, 'draft' );
		}
		elseif ( !empty( $mail->plaintext ) )
			$content = '<!DOCTYPE html><html ' . get_language_attributes() . '><head><meta charset="' . get_bloginfo( 'charset' ) . '/><meta name="viewport" content="width=device-width" /><title>' . get_bloginfo( 'name' ) . ' &gt; ' . $title  . '</title></head><body>' . '<pre>' . htmlspecialchars( $mail->plaintext, ENT_NOQUOTES ) . '</pre>' . '</body></html>';

		if ( !isset( $mp_general['fullscreen'] ) ) 		return array( 'title' => $title, 'content' => $content );
		
		die( $content );
	}

	public static function liun( $mp_confkey )
	{
		self::del( $mp_confkey );
	}
}