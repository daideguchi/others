<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen		= 'mailpress_tracking_m';
	const capability	= 'MailPress_tracking_mails';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/tracking/';
	const file			= __FILE__;

	const map_of		= 'mp_mail';

////  Title  ////

	public static function title() 
	{ 
		new MP_Tracking_metaboxes( 'mail' );

		global $title; 
		$title = __( 'Tracking', 'MailPress' ); 
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Tracking Mail :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . sprintf( __( 'Depending of your choice in %s settings, several boxes are displayed and are reporting the activity tracked for that mail.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_settings . '&tab=tracking', __( 'Tracking', 'MailPress' ) ) ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'        => 'overview',
										'title'        => __( 'Overview' ),
										'content'    => $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		$styles[] = MP_Map::print_styles();

		$styles[] = 'dashboard';

		wp_register_style( 'mp_mail', 	'/' . MP_PATH . 'mp-admin/css/mails.css', array( 'thickbox' ) );
		$styles[] = 'mp_mail';

		wp_register_style( self::screen, 	'/' . MP_PATH . 'mp-admin/css/tracking_m.css' );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

	public static function print_styles_icons( $i = array( 'browser', 'device', 'domain', 'flag', 'icon', 'os', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() )
	{
		$scripts = apply_filters( 'MailPress_autorefresh_js', $scripts );

		wp_register_script( 'mp-thickbox', 		'/' . MP_PATH . 'mp-includes/js/mp_thickbox.js', array( 'thickbox' ), false, 1 );

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/tracking_t.js', array( 'mp-thickbox', 'postbox' ), false, 1 );
		wp_localize_script( self::screen, 		'MP_AdminPageL10n',  array( 
			'screen' => self::screen
		 ) );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

////  Metaboxes  ////

	public static function admin_head() 
	{
		do_action( 'MailPress_tracking_add_meta_box', self::screen );
		parent::admin_head();
	}

//// Columns ////

	public static function get_columns() 
	{
		$columns = array(	'title'	=> __( 'Subject', 'MailPress' ), 
						'author'	=> __( 'Author' ), 
						'theme'	=> __( 'Theme', 'MailPress' ), 
						'to'		=> __( 'To', 'MailPress' ), 
						'date'	=> __( 'Date' )
		);
		$columns = apply_filters( 'MailPress_mails_columns', $columns );
		return $columns;
	}

////  Row  ////

	public static function get_row( $id, $url_parms, $xtra = false ) 
	{
		global $mp_mail;

		$mp_mail = $mail = MP_Mail::get( $id );
		$the_mail_status = $mail->status;

// url's
		$args = array(	'id'			=> $id,
					'action'		=> 'mp_ajax',
					'mp_action'	=> 'iview',
					'TB_iframe'	=> 'true'
		);
		$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );

// table row 
//	to
		$draft_dest = MP_User::get_mailinglists();

		switch ( true )
		{
			case ( $xtra ) :
				$email_display = '<span class="onerror blinkme">' . $xtra . '</span>';
			break;
			case ( MailPress::is_email( $mail->toemail ) ) :
				$mail_url = self::url( MailPress_mails, $url_parms );
				$mail_url = remove_query_arg( 's', $mail_url );
				$mail_url = esc_url( add_query_arg( 's', $mail->toemail, $mail_url ) );

				$email_display = '';

				if ( get_option( 'show_avatars' ) ) 
				{
					$email_display .= '<div class="tkg_avatar">';
					$email_display .= get_avatar( $mail->toemail, 32 );
					$email_display .= '</div>';
				}
				$email_display .= '<div>';
				$email_display .= '<strong>';
				$email_display .= ( strlen( $mail->toemail ) > 40 ) ? substr( $mail->toemail, 0, 39 ) . '...' : $mail->toemail;
				$email_display .= '</strong>';
				if ( !empty( $mail->toname ) )
				{
					$email_display .= '<br />' . $mail->toname;
				}
				$email_display .= '</div>';
			break;
			case ( isset( $draft_dest[$mail->toemail] ) ) :
				$email_display = '<strong>' . $draft_dest[$mail->toemail] . '</strong>';
			break;
			case ( is_serialized( $mail->toemail ) ) :
				$email_display = '<div class="num post-com-count-wrapper"><a class="post-com-count"><span class="comment-count">' . count( unserialize( $mail->toemail ) ) . '</span></a></div>';
			break;
			default  :
				$email_display = '<span class="onerror">' . __( '(unknown)', 'MailPress' ) . '</span>';
				unset( $actions['send'] );
			break;
		}
		$email_display = apply_filters( 'MailPress_to_mails_column', $email_display, $mail );
		if ( $mailinglist_desc = MP_Mail_meta::get( $mail->id, '_mailinglist_desc' ) )
		{
			$email_display = '<div>' . $email_display . '</div>' . $mailinglist_desc;
		}
//	author
		$author = ( 0 == $mail->sent_user_id ) ? $mail->created_user_id : $mail->sent_user_id;
		if ( $author != 0 && is_numeric( $author ) ) 
		{
			unset( $url_parms['author'] );
			$wp_user 		= get_userdata( $author );
		}
//	subject
		$metas = MP_Mail_meta::get( $id, '_MailPress_replacements' );
		$subject_display = $mail->subject;
		if ( $metas )
		{
			foreach( $metas as $k => $v )
			{
				$subject_display = str_replace( $k, $v, $subject_display );
			}
		}

		$title_title	= esc_attr( sprintf( ( 'draft' == $mail->status ) ?  __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ) : __( 'View &#8220;%1$s&#8221;', 'MailPress' ) , ( '' == $subject_display ) ? __( '(no subject)', 'MailPress' ) : htmlspecialchars( $subject_display, ENT_QUOTES ) ) );

//	attachments
		$attach = false;
		$metas = MP_Mail_meta::has( $id, '_MailPress_attached_file' );
		if ( $metas )
		{
			foreach( $metas as $meta )
			{
				$meta_value = unserialize( $meta['meta_value'] );
				if ( is_file( $meta_value['file_fullpath'] ) )
				{
					$attach = true;
					break;
				}
			}
		}

		$out = '';
		$out .= '<tr id="mail-' . $id . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( 'unsent' == $mail->status ) ? ' fi' : '' );

			switch ( $column_name ) 
			{
				case 'title':
					$attributes = sprintf( 'class="post-title column-title%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( 'unsent' == $mail->status ) ? ' fi' : '' );

					$out .= '<td ' . $attributes . '>';
					if ( 'paused' == $mail->status )
					{
						$out .= '<span class="mp_icon mp_icon_paused" title="' . esc_attr( __( 'Paused', 'MailPress' ) ) . '"></span>';
					}
					if ( $attach )
					{
						$out .= '<span class="mp_icon mp_icon_attachment" title="' . esc_attr( __( 'Attachments', 'MailPress' ) ) . '"></span>';
					}
					$out .= apply_filters( 'MailPress_get_icon_mails', '', $id );

					$out .= '<strong>';
					$out .= '<a class="row-title thickbox thickbox-preview" href="' . $view_url . '" title="' . esc_attr( $title_title ) . '">';
					$out .= ( '' == $subject_display ) ? __( '(no subject)', 'MailPress' ) : ( ( strlen( $subject_display ) > 40 ) ? $subject_display = mb_substr( $subject_display, 0, 39, get_option( 'blog_charset' ) ) . '...' : $subject_display );
					$out .= '</a>';

					switch ( $mail->status ) 
					{
						case 'paused' :
							$out .= ' - ' . __( 'Paused', 'MailPress' );
						break;
						case 'archived' :
							$out .= ' - ' . __( 'Archive', 'MailPress' );
						break;
					}
					$out .= '</strong>';
					$out .= '</td>';
				break;
				case 'author':
					$out .= '<td ' . $attributes . '>';
					if ( $author != 0 && is_numeric( $author ) )
					{
						$out .= $wp_user->display_name;
					}
					else
					{
						$out .= __( '(unknown)', 'MailPress' );
					}
					$out .= '</td>';
				break;
				case 'theme':
					$out .= '<td ' . $attributes . '>';
					$out .= $mail->theme;
					if ( '' != $mail->template )
					{
						$out .=  '<br />(' . $mail->template . ')';
					}
					$out .= '</td>';
				break;
				case 'to':
					$out .= '<td ' . $attributes . '>';
					$out .= $email_display;
					$out .= '</td>';
				break;
				case 'date':
					$t_time = self::get_mail_date( __( 'Y/m/d H:i:s' ) );
					$h_time = self::human_time_diff( self::get_mail_date_raw() );

					$out .= '<td ' . $attributes . '>';
					$out .= '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';
					$out .= '</td>';
				break;
				default:
					$out .= '<td ' . $attributes . '>';
					$out .= apply_filters( 'MailPress_mails_get_row', '', $column_name, $mail, $url_parms );
					$out .= '</td>';
				break;
			}
		}
		$out .= '</tr>';

		return $out;
	}

	public static function get_mail_date( $d = '' ) {
		$x = self::get_mail_date_raw();
		return ( '' == $d ) ? mysql2date( get_option( 'date_format' ), $x ) : mysql2date( $d, $x );
	}

	public static function get_mail_date_raw() {
		global $mp_mail;
		$x = ( $mp_mail->sent >= $mp_mail->created ) ? $mp_mail->sent : $mp_mail->created;
		return $x;
	}
}