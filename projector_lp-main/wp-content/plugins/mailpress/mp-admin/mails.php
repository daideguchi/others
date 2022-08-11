<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen		= MailPress_page_mails;
	const capability	= 'MailPress_edit_mails';
	const help_url		= 'http://blog.mailpress.org/tutorials/';
	const file			= __FILE__;

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms();
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count	.= 'd';
		$$count	= 0;

		switch( $action )
		{
			case 'bulk-pause' :
				foreach( $checked as $id )
				{
					if ( MP_Mail::set_status( $id, 'paused' ) )
					{
						$$count++;
					}
				}
			break;
			case 'bulk-restart' :
				foreach( $checked as $id )
				{
					if ( MP_Mail::set_status( $id, 'unsent' ) )
					{
						$$count++;
					}
				}
			break;
			case 'bulk-archive' :
				foreach( $checked as $id )
				{
					if ( MP_Mail::set_status( $id, 'archived' ) )
					{
						$$count++;
					}
				}
			break;
			case 'bulk-unarchive' :
				foreach( $checked as $id )
				{
					if ( MP_Mail::set_status( $id, 'sent' ) )
					{
						$$count++;
					}
				}
			break;
			case 'bulk-send' :
				$sent = $notsent = 0;
				foreach( $checked as $id )
				{
					if ( 'draft' != MP_Mail::get_status( $id ) )
					{
						continue;
					}
					$x = MP_Mail_draft::send( $id );
					$url = ( is_numeric( $x ) ) ? $sent += $x : $notsent++ ;
				}
				if ( $sent )
				{
					$url_parms['sent']    = $sent;
				}
				if ( $notsent )
				{
					$url_parms['notsent'] = $notsent;
				}
			break;
			case 'bulk-delete' :
				foreach( $checked as $id )
				{
					if ( MP_Mail::set_status( $id, 'delete' ) )
					{
						$$count++;
					}
				}
			break;
		}

		if ( $$count )
		{
			$url_parms[$count] = $$count;
		}
		self::mp_redirect( self::url( MailPress_mails, $url_parms ) );
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Mails :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'This screen provides access to all of your mails. You can customize the display of this screen to suit your needs.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can customize the display of this screen&#8217;s contents in a number of ways:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( 'You can hide/display columns based on your needs and decide how many mails to list per screen using the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'You can filter the list of mails by status using the text links above the mails list to only show mails with that status. The default view is to show all mails.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'Depending on which add on you have activated, you may find an autorefresh option in the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'screen-display',
										'title'	=> __( 'Screen Display' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'Hovering over a row in the mails list will display action links that allow you to manage your mail. You can perform the following actions depending on mail status and when available:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Edit</strong> &mdash; takes you to the editing screen for that draft mail. You can also reach that screen by clicking on the mail title.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Send</strong> &mdash; sends the draft mail.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Archive</strong> &mdash; archives any sent mail. This status allows to select some mails such as newsletters to be displayed on your site using a specific WordPress theme page template (see <code>mailpress/mp-content/xtras</code>).', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Delete</strong> &mdash; removes your mail from this list and delete it permanently.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Tracking</strong> &mdash; displays collected informations during the tracking. Available for any new sent mail after tracking add on activation.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'action-links',
										'title'	=> __( 'Available Actions' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can also permanently delete multiple mails at once. Select the mails you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'bulk-actions',
										'title'	=> __( 'Bulk Actions' ),
										'content'	=> $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, 		'/' . MP_PATH . 'mp-admin/css/mails.css',       array( 'thickbox' ) );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

	public static function print_styles_icons( $i = array( 'icon', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

//// Scripts ////

	public static function print_scripts( $scripts = array() ) 
	{
		$scripts = apply_filters( 'MailPress_autorefresh_js', $scripts );

		wp_register_script( 'mp-ajax-response', 	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'mp-ajax-response', 		'wpAjax', array( 
			'noPerm' => __( 'Email was not sent AND/OR Update database failed', 'MailPress' ), 
			'broken' => __( 'An unidentified error has occurred.' ), 
			'l10n_print_after' => 'try{convertEntities( wpAjax );}catch( e ){};' 
		 ) );

		wp_register_script( 'mp-lists', 		'/' . MP_PATH . 'mp-includes/js/mp_lists.js', array( 'mp-ajax-response' ), false, 1 );

		wp_register_script( 'mp-thickbox', 		'/' . MP_PATH . 'mp-includes/js/mp_thickbox.js', array( 'thickbox' ), false, 1 );

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/mails.js', array( 'mp-thickbox', 'mp-lists' ), false, 1 );
		wp_localize_script( self::screen, 	'MP_AdminPageL10n', array( 	
			'pending' => __( '%i% pending' ), 
			'screen' => self::screen, 
			'l10n_print_after' => 'try{convertEntities( MP_AdminPageL10n );}catch( e ){};' 
		 ) );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

//// Columns ////

	public static function get_columns() 
	{
		$disabled = ( !current_user_can( 'MailPress_delete_mails' ) ) ? ' disabled="disabled"' : '';
		$columns = array(	'cb'		=> '<input type="checkbox"' . $disabled .  '/>', 
						'title'	=> __( 'Subject', 'MailPress' ), 
						'author'	=> __( 'Author' ), 
						'theme'	=> __( 'Theme', 'MailPress' ), 
						'to'		=> __( 'To', 'MailPress' ), 
						'date'	=> __( 'Date' )
		);
		$columns = apply_filters( 'MailPress_mails_columns', $columns );
		return $columns;
	}

//// List ////

	public static function get_list( $args ) 
	{
		extract( $args );

		global $wpdb;

		$where = " AND status <> '' ";

		if ( isset( $url_parms['s'] ) )
		{
			$sc = array( 'theme', 'themedir', 'template', 'toemail', 'toname', 'subject', 'html', 'plaintext', 'created', 'sent' );

			$where .= self::get_search_clause( $url_parms['s'], $sc );
		}

		if ( isset( $url_parms['status'] ) && !empty( $url_parms['status'] ) )
		{
			$where .= " AND status = '" . $url_parms['status'] . "'";
		}
		if ( isset( $url_parms['author'] ) && !empty( $url_parms['author'] ) )
		{
			$where .= " AND ( created_user_id = " . $url_parms['author'] . "  OR sent_user_id = " . $url_parms['author'] . " ) ";
		}
		if ( !current_user_can( 'MailPress_edit_others_mails' ) )
		{
			$where .= " AND ( created_user_id = " . MP_WP_User::get_id() . " ) ";
		}

		$args['query'] = "SELECT SQL_CALC_FOUND_ROWS * FROM $wpdb->mp_mails WHERE 1=1 $where ORDER BY created DESC";
		$args['cache_name'] = 'mp_mail';

		list( $_mails, $total ) = parent::get_list( $args );

		$counts = array();
		$query = "SELECT status, count( * ) as count FROM $wpdb->mp_mails GROUP BY status;";
		$statuses = $wpdb->get_results( $query );

		$subsubsub_urls = false;

		$libs = array(	'all'		=> __( 'All' ),
					'archived'	=> __( 'Archive', 'MailPress' ),
					'sent'	=> __( 'Sent', 'MailPress' ),
					'sending'	=> __( 'Pending', 'MailPress' ),
					'paused'	=> __( 'Paused', 'MailPress' ),
					'unsent'	=> __( 'Unsent', 'MailPress' ),
					'draft'	=> __( 'Draft', 'MailPress' ),
					'search'	=> __( 'Search Results' )
		);

		if ( $statuses )
		{
			foreach( $statuses as $status )
			{
				if ( $status->count )
				{
					$counts[$status->status] = $status->count;
				}
			}
			$counts['all'] = $wpdb->get_var( "SELECT count( * ) FROM $wpdb->mp_mails WHERE status <> '';" );
			if ( isset( $url_parms['s'] ) )
			{
				$counts['search'] = count( $_mails );
			}
			$out = array();

			foreach( $libs as $k => $lib )
			{
				if ( !isset( $counts[$k] ) || !$counts[$k] )
				{
					continue;
				}

				$args = array();
				if ( isset( $url_parms['mode'] ) ) 				$args['mode'] = $url_parms['mode'];
				if ( ( 'search' == $k ) && ( isset( $url_parms['s'] ) ) )  	$args['s'] = $url_parms['s'];
				elseif ( 'all' != $k ) 						$args['status'] = $k;
				$url	= esc_url( add_query_arg( $args, MailPress_mails ) );

				$cls = '';
				if ( isset( $url_parms['s'] ) )
				{
					if ( 'search' == $k )
					{
						$cls = ' class="current"';
					}
				}
				elseif ( isset( $url_parms['status'] ) )
				{
					if ( $url_parms['status'] == $k )
					{
						$cls = ' class="current"';
					}
				}
				elseif ( 'all' == $k )
				{
					$cls = ' class="current"';
				}

				$out[] = sprintf( '<a%1$s href="%2$s">%3$s <span class="count">( <span class="mail-count-%4$s">%5$s</span> )</span></a>', $cls, $url, $lib, $k, $counts[$k] );
			}

			if ( !empty( $out ) )
			{
				$subsubsub_urls = '<li>' . join( ' | </li><li>', $out ) . '</li>';
			}
		}
		return array( $_mails, $total, $subsubsub_urls );
	}

////  Row  ////

	public static function get_row( $id, $url_parms, $xtra = false ) 
	{
		global $mp_mail;
		
		$mp_mail = $mail = MP_Mail::get( $id );
		$the_mail_status = $mail->status;

		$url_parms['mode'] = $url_parms['mode'] ?? 'list';
// url's
		$args = array();
		$args['id']	= $id;

		$edit_url		= esc_url( self::url( MailPress_edit, array_merge( $args, $url_parms ) ) );

		$args['action']	= 'pause';
		$pause_url		= esc_url( self::url( MailPress_write, array_merge( $args, $url_parms ) ) );

		$args['action']	= 'restart';
		$restart_url	= esc_url( self::url( MailPress_write, array_merge( $args, $url_parms ) ) );

		$args['action']	= 'archive';
		$archive_url	= esc_url( self::url( MailPress_write, array_merge( $args, $url_parms ), "archive-mail_{$mail->id}" ) );

		$args['action']	= 'unarchive';
		$unarchive_url	= esc_url( self::url( MailPress_write, array_merge( $args, $url_parms ), "unarchive-mail_{$mail->id}" ) );

		$args['action']	= 'send';
		$send_url		= esc_url( self::url( MailPress_write, array_merge( $args, $url_parms ) ) );

		$args['action']	= 'delete';
		$delete_url	= esc_url( self::url( MailPress_write, array_merge( $args, $url_parms ), "delete-mail_$id" ) );

    		$args = array(	'id'			=> $id,
					'action'		=> 'mp_ajax',
					'mp_action'	=> 'iview',
					'TB_iframe'	=> 'true'
		);
		if ( 'draft' == $mail->status )
		{
			if ( !empty( $mail->theme ) ) 
			{
				$args['theme'] = $mail->theme;
			}
		}
		$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );
              
// actions
		$actions = array();
		$actions['edit']	= '<a href="' . $edit_url 		. '">' . __( 'Edit' ) 			. '</a>';
		$actions['send'] 	= '<a href="' . $send_url 		. '">' . __( 'Send', 'MailPress' ) 	. '</a>';
		$actions['pause']	= '<a href="' . $pause_url		. '">' . __( 'Pause', 'MailPress' ) 	. '</a>';
		$actions['restart'] 	= '<a href="' . $restart_url 	. '">' . __( 'Restart', 'MailPress' )	. '</a>';
		$actions = apply_filters( 'MailPress_mails_actions', $actions, $mp_mail, $url_parms );

		$actions['approve']	= '<a href="' . $unarchive_url 	. '" class="dim:the-mail-list:mail-' . $id . ':unapproved:e7e7d3:e7e7d3:?mode=' . $url_parms['mode'] . '" >' . __( 'Unarchive', 'MailPress' )	. '</a>';
		$actions['unapprove']	= '<a href="' . $archive_url 	. '" class="dim:the-mail-list:mail-' . $id . ':unapproved:e7e7d3:e7e7d3:?mode=' . $url_parms['mode'] . '" >' . __( 'Archive', 'MailPress' )	. '</a>';

		$actions['delete']	= '<a href="' . $delete_url	. '" class="submitdelete" >' 			. __( 'Delete', 'MailPress' ) 	. '</a>';
		$actions['view']	= '<a href="' . $view_url		. '" class="thickbox thickbox-preview" >'	. __( 'View', 'MailPress' ) 	. '</a>';

		switch( $mail->status )
		{
			case 'draft' :
				$include = array( 'edit', 'send', 'delete', 'view' );
			break;
			case 'unsent' :
				$include = array( 'pause', 'tracking', 'view' );
			break;
			case 'sending' :
				$include = array( 'pause', 'tracking', 'view' );
			break;
			case 'paused' :
				$include = array( 'restart', 'tracking', 'delete', 'view' );
			break;
			case 'sent' :
				$include = array( 'tracking', 'approve', 'unapprove', 'delete', 'view' );
			break;
			case 'archived' :
				$include = array( 'tracking', 'approve', 'unapprove', 'view' );
			break;
			default :
				$include = array( 'view' );
			break;
		}
		foreach( $actions as $k => $v )
		{
			if ( !in_array( $k, $include ) )
			{
				unset( $actions[$k] );
			}
		}

		if ( !current_user_can( 'MailPress_send_mails' ) )
		{
			unset( $actions['send'] );
		}
		if ( !current_user_can( 'MailPress_delete_mails' ) ) 
		{
			unset( $actions['delete'] );
		}
		if ( !current_user_can( 'MailPress_archive_mails' ) )
		{
			unset( $actions['approve'], $actions['unapprove'] );
		}


// table row 
//	class
		$row_class = 'iedit author-self level-0 format-standard';
		switch ( $the_mail_status )
		{
			case 'archived' :
				$row_class .= ' unapproved';
			break;
			case 'draft' :
				$row_class .= ' draft';
			break;
			case 'unsent' :
				$row_class .= ' unsent';
			break;
		}
// 	checkbox
		$disabled = ( !current_user_can( 'MailPress_delete_mails' ) && !current_user_can( 'MailPress_send_mails' ) ) ? ' disabled="disabled"' : '';
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
				$mail_url2 	    = '<a class="row-title" href="' . $mail_url . '"  title="' . esc_attr( sprintf( __( 'Search &#8220;%1$s&#8221;', 'MailPress' ), $mail->toemail ) ) . '">';
				if ( ( 'detail' == $url_parms['mode'] ) && ( get_option( 'show_avatars' ) ) )
				{
					$email_display .= '<div>';
					$email_display .= $mail_url2;
					$email_display .= get_avatar( $mail->toemail, 32 );
					$email_display .= '</a>';
					$email_display .= '</div>';
				}
				$email_display .= '<div>';
				$email_display .= $mail_url2;
				$email_display .= '<strong>';
				$email_display .= ( strlen( $mail->toemail ) > 40 ) ? substr( $mail->toemail, 0, 39 ) . '...' : $mail->toemail;
				$email_display .= '</strong>';
				$email_display .= '</a>';
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
			$author_url 	= esc_url( self::url( add_query_arg( 'author', $author, MailPress_mails ), $url_parms ) );
		}
//	subject
		$metas = MP_Mail_meta::get( $id, '_MailPress_replacements' );
		$subject_display = $mail->subject;
		if ( $metas ) foreach( $metas as $k => $v )
		{
			$subject_display = str_replace( $k, $v, $subject_display );
		}

		$title_class	= 'row-title';
		$title_class	.=( 'draft' == $mail->status ) ? '' : ' thickbox thickbox-preview';
		$title_link	= ( 'draft' == $mail->status ) ? $edit_url : $view_url;
		$title_title	= esc_attr( sprintf( ( 'draft' == $mail->status ) ?  __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ) : __( 'View &#8220;%1$s&#8221;', 'MailPress' ) , ( '' == $subject_display ) ? __( '(no subject)', 'MailPress' ) : htmlspecialchars( $subject_display, ENT_QUOTES ) ) );

//	attachments
		$attach = false;
		$metas = MP_Mail_meta::has( $id, '_MailPress_attached_file' );
		if ( $metas )
		{
			foreach( $metas as $meta )
			{
				$meta_value = unserialize( $meta['meta_value'] );
				if ( $the_mail_status == 'sent' )
				{
					$attach = true;
					break;
				}
				elseif ( is_file( $meta_value['file_fullpath'] ) )
				{
					$attach = true;
					break;
				}
			}
		}

		$out = '';
		$out .= '<tr id="mail-' . $id . '" class="' . $row_class . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( 'unsent' == $mail->status ) ? ' fi' : '' );

			switch ( $column_name ) 
			{
				case 'cb':
					$out .= '<th class="check-column">';
					if ( isset( $actions['delete'] ) )
					{
						$out .= ' <input type="checkbox" name="checked[]" value="' . $id . '"' . $disabled . ' />';
					}
					$out .= '</th>';
				break;
				case 'title':
					$attributes = sprintf( 'class="title column-title has-row-actions column-primary page-title%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( 'unsent' == $mail->status ) ? ' fi' : '' );

					$out .= '<td ' . $attributes . '>';
					if ( 'paused' == $mail->status )
					{
						$out .= '<span class="mp_icon mp_icon_paused" title="' . esc_attr( __( 'Paused', 'MailPress' ) ) . '"></span>';
					}
					if ( $attach )
					{
						$out .= '<span class="mp_icon mp_icon_attachment" title="' . esc_attr( __( 'Attachments', 'MailPress' ) ) . '"></span>';
					}
					if ( ( 'draft' == $mail->status ) && ( $mp_mail->sent >= $mp_mail->created ) )
					{
						$out .= '<span class="mp_icon mp_icon_scheduled" title="' . esc_attr( __( 'Scheduled', 'MailPress' ) ) . '"></span>';
					}
					$out .= apply_filters( 'MailPress_get_icon_mails', '', $id );

					$out .= '<strong>';
					$out .= '<a class="' . $title_class . '" href="' . $title_link . '" title="' . esc_attr( $title_title ) . '">';
					$out .= ( '' == $subject_display ) ? __( '(no subject)', 'MailPress' ) : ( ( strlen( $subject_display ) > 40 ) ? $subject_display = mb_substr( $subject_display, 0, 39, get_option( 'blog_charset' ) ) . '...' : $subject_display );
					$out .= '</a>';

					switch ( $mail->status ) 
					{
						case 'draft' :
							$out .= ' - ' . __( 'Draft', 'MailPress' );
						break;
						case 'paused' :
							$out .= ' - ' . __( 'Paused', 'MailPress' );
						break;
						case 'archived' :
							$out .= ' - ' . __( 'Archive', 'MailPress' );
						break;
					}
					$out .= '</strong>';
					$out .= self::get_actions( $actions );
					$out .= '</td>';
				break;
				case 'author':
					$out .= '<td ' . $attributes . '>';
					if ( $author != 0 && is_numeric( $author ) )
					{
						$out .= '<a href="' . $author_url . '" title="' . esc_attr( sprintf( __( 'Mails by &#8220;%1$s&#8221;', 'MailPress' ), $wp_user->display_name ) ) . '">' . $wp_user->display_name . '</a>';
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
					$date_status = ( 'draft' == $mail->status ) ? ( ( $mp_mail->sent >= $mp_mail->created ) ? true : __( 'Last Modified', 'MailPress' ) ) : __( 'Sent', 'MailPress' );
					$_scheduled = false;
					if ( true === $date_status )
					{
						$_scheduled = true;
						$date_status= __( 'Scheduled', 'MailPress' );
					}

					$t_time = self::get_mail_date( __( 'Y/m/d H:i:s' ) );
					$m_time = self::get_mail_date_raw();

					$time   = strtotime( get_gmt_from_date( $m_time ) );
					$time_diff = current_time( 'timestamp', true ) - $time;

					if ( $_scheduled )
					{
						$h_time = mysql2date( __( 'Y/m/d' ), $m_time );
					}
					else
					{
			 			$h_time = self::human_time_diff( self::get_mail_date_raw() );
					}

					$out .= '<td ' . $attributes . '>';
					$out .= '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';
					$out .= '<br />';
					$out .= $date_status;
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