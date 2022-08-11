<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= 'mailpress_revision';
	const capability	= 'MailPress_edit_mails';
	const help_url		= false;
	const file			= __FILE__;

////  Redirect  ////

	public static function redirect() 
	{
		$redirect = MailPress_edit;

		$action	= ( isset( self::$get_['action'] ) ) 	? self::$get_['action'] : false;
		$rev_id	= ( isset( self::$get_['revision'] ) )? absint( self::$get_['revision'] ) : false;
		$id		= ( isset( self::$get_['id'] ) ) 	? absint( self::$get_['id'] ) : false;

		switch ( $action )
		{
			case 'restore' :
				if ( !$revision = MP_Mail::get( $rev_id ) )
				{
					break;
				}
				if ( !$mail = MP_Mail::get( $id ) )
				{
					break;
				}

				check_admin_referer( "restore-mail_{$revision->id}" );

				MP_Mail_revision::restore( $mail, $revision );
				$redirect = add_query_arg( array( 'id' => $id , 'revision' => $rev_id, 'message' => 5 ), MailPress_edit );
			break;
			case 'view' :
			case 'edit' :
			default :
 				if ( !$revision = MP_Mail::get( $rev_id ) )
				{
					break;
				}
				if ( !$mail = MP_Mail::get( $id ) )
				{
					break;
				}

				$redirect = false;
			break;
		}
		if ( $redirect )
		{
			self::mp_redirect( $redirect );
		}
	}

////  Title  ////

	public static function title()
	{
		global $title;
		$title = __( 'Mail Revisions', 'MailPress' );
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Revision :', 'MailPress' ) . '</strong></p>';

		$content .= '<p>' . __( 'This screen is used for managing your content revisions.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'Revisions are saved copies of your draft mail (one copy autosaved per WP user per draft), which is created as you update your content. The red text on the left shows the content that was removed. The green text on the right shows the content that was added.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'From this screen you can review, compare, and restore revisions:', 'MailPress' ) . '</p>';
		$content .=  '<ul><li>' . __( 'To navigate between revisions, <strong>drag the slider handle left or right</strong> or <strong>use the Previous or Next buttons</strong>.', 'MailPress' ) . '</li>';
		$content .=  '<li>' . __( 'Compare two different revisions by <strong>selecting the &#8220;Compare any two revisions&#8221; box</strong> to the side.', 'MailPress' ) . '</li>';
		$content .=  '<li>' . __( 'To restore a revision, <strong>click Restore This Revision</strong>. The content of the revision becomes the content of the mail and vice versa.', 'MailPress' ) . '</li></ul>';

		$current_screen->add_help_tab( array( 	'id'        => 'overview',
										'title'        => __( 'Overview' ),
										'content'    => $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, '/' . MP_PATH . 'mp-admin/css/write.css', array( 'revisions', 'thickbox' ) );

		$styles[] = self::screen;
		parent::print_styles( $styles );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() ) 
	{
		$rev_id	= ( isset( self::$get_['revision'] ) ) ? absint( self::$get_['revision'] ) : false;
		$id		= absint( self::$get_['id'] );

		wp_register_script ( self::screen, '/' . MP_PATH . 'mp-admin/js/revisions.js', array( 'wp-backbone', 'jquery-ui-slider', 'hoverIntent', 'thickbox' ), false, 1 );
		wp_localize_script( self::screen, '_wpRevisionsSettings', self::prepare_js( $id, $rev_id, null ) );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

	public static function prepare_js( $id, $selected_revision_id, $from = null ) 
        {
		$revisions = $authors = array();

		$now_gmt = time();
		$revisions = MP_Mail_revision::get_all( $id, false );
		$mail      = $revisions[$id];
		unset( $revisions[$id] );
		$show_avatars = get_option( 'show_avatars' );
	
		//cache_users( wp_list_pluck( $revisions, 'mail_author' ) );
		$i = 0; $r = count( $revisions );
		foreach ( $revisions as $revision )
		{
			$i++;
			$modified = strtotime( $revision->created );
			$restore_link = str_replace( '&amp;', '&', wp_nonce_url( add_query_arg( array( 	'page'	=> MailPress_page_mails ,
																		'file'	=> 'revision',
																		'action'	=> 'restore',
																		'id'		=> $mail->id ,
																		'revision'	=> $revision->id
																		), admin_url( 'admin.php' ) ), "restore-mail_{$revision->id}" )
			);

			if ( ! isset( $authors[ $revision->created_user_id ] ) )
			{
				$authors[ $revision->created_user_id ] = array( 
					'id' 		=> ( int ) $revision->created_user_id,
					'avatar'	=> $show_avatars ? get_avatar( $revision->created_user_id, 32 ) : '',
					'name'	=> get_the_author_meta( 'display_name', $revision->created_user_id ),
				 );
			}
	
			$autosave = ( bool ) ( '' == $revision->status ) ;
			$current = ( $r == $i );
			$current_id = ( $current ) ? $revision->id : false;
	
			$revisions_data = array( 
				'id'         => $revision->id,
				'title'      => $revision->subject,
				'author'     => $authors[ $revision->created_user_id ],
				'date'       => date_i18n( __( 'M j, Y @ H:i' ), $modified ),
				'dateShort'  => date_i18n( _x( 'j M @ H:i', 'revision date short format' ), $modified ),
				'timeAgo'    => sprintf( __( '%s ago' ), human_time_diff( $modified, $now_gmt ) ),
				'autosave'   => $autosave,
				'current'    => $current,
				'restoreUrl' => $restore_link,
			);
			$revisions[ $revision->id ] = apply_filters( 'mp_prepare_revision_for_js', $revisions_data, $revision, $mail );
		}

		/**
		 * If we only have one revision, the initial revision is missing; This happens
		 * when we have an autsosave and the user has clicked 'View the Autosave'
		 */
		if ( 1 === sizeof( $revisions ) )
		{
			$revisions[ $mail->id ] = array(
				'id'         => $mail->id,
				'title'      => $mail->subject,
				'author'     => $authors[ $mail->created_user_id ],
				'date'       => date_i18n( __( 'M j, Y @ H:i' ), strtotime( $mail->created ) ),
				'dateShort'  => date_i18n( _x( 'j M @ H:i', 'revision date short format' ), strtotime( $mail->created ) ),
				'timeAgo'    => sprintf( __( '%s ago' ), human_time_diff( strtotime( $mail->created ), $now_gmt ) ),
				'autosave'   => false,
				'current'    => true,
				'restoreUrl' => false,
			 );
			$current_id = $mail->id;
		}

		// Now, grab the initial diff.
		$compare_two_mode = is_numeric( $from );
		if ( ! $compare_two_mode )
		{
			$found = array_search( $selected_revision_id, array_keys( $revisions ) );
			if ( $found )
			{
				$from = array_keys( array_slice( $revisions, $found - 1, 1, true ) );
				$from = reset( $from );
			}
			else
			{
				$from = 0;
			}
		}
	
		$from = absint( $from );
	
		$diffs = array( array(	'id'		=> $from . ':' . $selected_revision_id,
							'fields'	=> MP_Mail_revision::get_ui_diff( $mail->id, $from, $selected_revision_id ),
		) );
	
		$js = array( 
			'mailId'           => $mail->id,
			'nonce'            => wp_create_nonce( 'revisions-ajax-nonce' ),
			'revisionData'     => array_values( $revisions ),
			'to'               => $selected_revision_id,
			'from'             => $from,
			'diffData'         => $diffs,
			'baseUrl'          => add_query_arg( 	array( 'page' => MailPress_page_mails , 'file' => 'revision', 'id' => $mail->id ), parse_url( admin_url( 'admin.php' ), PHP_URL_PATH ) ),
			'compareTwoMode'   => absint( $compare_two_mode ), // Apparently booleans are not allowed
			'revisionIds'      => array_keys( $revisions ),
		 );

		return $js;
	}
}