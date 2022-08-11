<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= MailPress_page_write;
	const capability	= 'MailPress_edit_mails';
	const help_url		= 'http://blog.mailpress.org/tutorials/';
	const file			= __FILE__;

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		if ( isset( self::$get_['id'] ) )
		{
			$id = self::$get_['id'];
		}

		$list_url = self::url( MailPress_mails, self::get_url_parms() );

		switch( $action ) 
		{
			case 'pause' :
				if ( MP_Mail::set_status( $id, 'paused' ) )
				{
					$list_url .= '&paused=1';
				}
				self::mp_redirect( $list_url );
			break;
			case 'restart' :
				if ( MP_Mail::set_status( $id, 'unsent' ) )
				{
					$list_url .= '&restartd=1';
				}
				self::mp_redirect( $list_url );
			break;
			case 'archive' :
				if ( MP_Mail::set_status( $id, 'archived' ) )
				{
					$list_url .= '&archived=1';
				}
				self::mp_redirect( $list_url );
			break;
			case 'unarchive' :
				if ( MP_Mail::set_status( $id, 'sent' ) )
				{
					$list_url .= '&unarchived=1';
				}
				self::mp_redirect( $list_url );
			break;
			case 'send' :
				if ( 'draft' != MP_Mail::get_status( $id ) )
				{
					break;
				}
				$x = MP_Mail_draft::send( $id );
				$list_url .= ( is_numeric( $x ) )	? '&sent=' . $x : '&notsent=1';
				self::mp_redirect( $list_url );
			break;
			case 'delete' :
				if ( MP_Mail::set_status( $id, 'delete' ) )
				{
					$list_url .= '&deleted=1';
				}
				self::mp_redirect( $list_url );
			break;

			case 'draft' :
				$id = ( empty( self::$pst_['id'] ) ) ? MP_Mail::get_id( __CLASS__ . ' ' . __METHOD__ . ' ' . self::screen ) : ( int ) self::$pst_['id'];

				switch ( true )
				{
				// process attachments
					case isset( self::$pst_['addmeta'] ) :
						MP_Mail_meta::add_meta( $id );
						$parm = "&cfsaved=1";
					break;
					case isset( self::$pst_['updatemailmeta'] ) :
						$cfsaved = 0;
						foreach ( self::$pst_['meta'] as $meta_id => $meta )
						{
							$meta_key = $meta['key'];
							$meta_value = $meta['value'];
							MP_Mail_meta::update_by_id( $meta_id , $meta_key, $meta_value );
							$cfsaved++;
						}
						$parm = "&cfsaved=$cfsaved";
					break;
					case isset( self::$pst_['deletemailmeta'] ) :
						$cfdeleted = 0;
						foreach ( self::$pst_['deletemailmeta'] as $meta_id => $x )
						{
							MP_Mail_meta::delete_by_id( $meta_id );
							$cfdeleted++;
						}
						$parm = "&cfdeleted=$cfdeleted";
					break;
				// process mail
					default :
						$id = ( empty( self::$pst_['id'] ) ) ? MP_Mail::get_id( __CLASS__ . ' ' . __METHOD__ . ' ' . self::screen ) : self::$pst_['id'];

						$scheduled = MP_Mail_draft::update( $id );

					// what else ?
						do_action( 'MailPress_update_meta_boxes_write' );
						$parm = ( $scheduled ) ? "&sched=1" : "&saved=1";

						if ( !$scheduled && isset( self::$pst_['send'] ) )
						{
							wp_cache_delete( $id, 'mp_mail' );
							$x = MP_Mail_draft::send( $id );
							if ( is_numeric( $x ) )
							{
								if ( 0 == $x )
								{
									$parm = "&sent=0";
								}
								else
								{
									$parm = "&sent=$x";
								}
							}
							else
							{
								$parm = "&nodest=0";
							}
						}
					break;
				}
				$HTTP_REFERER = filter_input( INPUT_SERVER, 'HTTP_REFERER' );
				$url = ( strstr( $HTTP_REFERER, MailPress_edit ) ) ? MailPress_edit : MailPress_write;
				$url .= "$parm&id=$id";
				self::mp_redirect( $url );
			break;
		}
	}

////  Title  ////

	public static function title() 
	{ 
		global $title; 
		$title = ( isset( self::$get_['file'] ) && ( 'write' == self::$get_['file'] ) ) ? __( 'Edit Mail', 'MailPress' ) : __( 'Add New Mail', 'MailPress' );

		add_filter( 'tiny_mce_before_init', array( __CLASS__, 'tiny_mce_before_init' ) );
	}

	public static function tiny_mce_before_init( $initArray )
	{
// previously MailPress_fix_TinyMCE
		// Viper video quicktags
		global $VipersVideoQuicktags; 
	
		if ( isset( $VipersVideoQuicktags ) )
		{
			$Viper_mce_buttons = ( 1 == $VipersVideoQuicktags->settings['tinymceline'] ) ? 'mce_buttons' : 'mce_buttons_' . $VipersVideoQuicktags->settings['tinymceline'];
			remove_filter( $Viper_mce_buttons, 		array( &$VipersVideoQuicktags, 'mce_buttons' ) );
			remove_filter( 'mce_external_plugins', 	array( &$VipersVideoQuicktags, 'mce_external_plugins' ) );
			remove_filter( 'tiny_mce_version', 		array( &$VipersVideoQuicktags, 'tiny_mce_version' ) );
			remove_action( 'edit_form_advanced', 		array( &$VipersVideoQuicktags, 'AddQuicktagsAndFunctions' ) );
			remove_action( 'edit_page_form', 		array( &$VipersVideoQuicktags, 'AddQuicktagsAndFunctions' ) );
		}

		// Cforms
		remove_filter( 'mce_buttons', 			'cforms_button' );
		remove_filter( 'mce_external_plugins', 	'cforms_plugin' );
// previously MailPress_fix_TinyMCE

		$x = array( 	'theme_advanced_buttons1'	=> 'fullscreen',
					'plugins'				=> 'wpfullscreen',
		 );

		foreach( $x as $k => $v )
		{
			if ( isset( $initArray[$k] ) )
			{
				$initArray[$k] = str_replace( array( $v, ',,' ) , array( '', ',' ) , $initArray[$k] );
			}
		}
		return $initArray;
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'New Mail :', 'MailPress' ) . '</strong>' . __( 'This screen is divided in two parts:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Fixed</strong>', 'MailPress' );
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Buttons</strong> &mdash; Two buttons to hide/display the plaintext part of your mail.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Recipient(s)</strong> &mdash; select a list or enter a mail + name.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Subject</strong> &mdash; subject of your mail (You can use replacement text here).', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Plaintext editor</strong> &mdash; that you can display or hide using the two buttons above.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Html Editor</strong> &mdash; on top of this editor, Add Media to insert photos, Synchronize to convert your content and fill the plaintext editor from your Html text.', 'MailPress' ) . '</li>';

		$content .= '</ul>';
		$content .= '</li>';
		$content .= '<li>' . __( '<strong>Boxes</strong> &mdash; under the fixed part or in the sidebar.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'While you are typing your mail, an autosave process will work in the background to save your work.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'On first autosave, or save draft, the preview button will appear in the Send box as well as the Attachments box.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'In Send box, you can:', 'MailPress' ) . '</p>';                
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>From</strong> &mdash; change the General settings for this mail.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Theme</strong> &mdash; change the default Theme.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Schedule</strong> &mdash; your mail at another date, based on Wp_cron (see more explanations on your Wp_cron help).', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'        => 'autosave-and-send',
										'title'        => __( 'Autosave and Send', 'MailPress' ),
										'content'    => $content )
		);


		$content = '';
		$content .= '<p>' . __( '<strong>Custom Fields</strong> &mdash; is only used for text replacement in mails.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'Let us say you want to manage honorific (e.g. : Mr, Miss, Sir ...) for all mp users. Create a custom field with name "honorific" and the appropriate value for each mp user. When creating a new Mail, you can write to a set of mp users starting your mail with the following "Dear {{honorific}}" (double opening and closing curly brackets inspired by <code>{{mustache}}</code> ). At the mail level, you can also create a default custom field "honorific" that will be the value if it was missing at the mp user level.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'Custom fields can also be populated when importing mp users (import add-on).', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'customfields',
										'title'	=> __( 'Custom Fields', 'MailPress' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can add attachments to your mail.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'WordPress supports uploading the most common file types, not all file types.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'Not all webhosts permit these files to be uploaded. Also, they may not permit large file uploads. If you are having issues, please check with your host first. .', 'MailPress' ) . '</p>';                
		$content .= '<p>' . sprintf( __( 'Draft mail with attachments can be quickly identified in %1$s with a little clip icon : %2$s', 'MailPress' ), sprintf( '<a href="' . MailPress_mails . '" target="_blank">%s</a>', __( 'Mails list', 'MailPress' ) ) , '<span class="mp_icon mp_icon_attachment" title="' . __('Attachments', 'MailPress' ) . '" ></span>' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'attachments',
										'title'	=> __( 'Attachments', 'MailPress' ),
										'content'	=> $content )
		);


		do_action( 'MailPress_add_help_tab_write' );
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, 		'/' . MP_PATH . 'mp-admin/css/write.css', 	array( 'thickbox' ) );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

	public static function print_styles_icons( $i = array( 'ext', 'icon', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() ) 
	{
		wp_register_script( 'mp-ajax-response', 	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'mp-ajax-response', 'wpAjax', array( 
			'noPerm' => __( 'Email was not sent AND/OR Update database failed', 'MailPress' ), 
			'broken' => __( 'An unidentified error has occurred.' ), 
			'l10n_print_after' => 'try{convertEntities( wpAjax );}catch( e ){};' 
		 ) );

		wp_register_script( 'mp-autosave', 		'/' . MP_PATH . 'mp-includes/js/autosave.js', array( 'schedule', 'mp-ajax-response' ), false, 1 );
		wp_localize_script( 'mp-autosave', 'autosaveL10n', array	( 	
			'autosaveInterval'=> '60', 
			'previewMailText'	=>  __( 'Preview' ), 
			'requestFile' 	=> admin_url( 'admin-ajax.php' ), 
			'savingText'	=> __( 'Saving draft...', 'MailPress' )
		 ) );

		wp_register_script( 'mp_customfields',	'/' . MP_PATH . 'mp-includes/js/mp_customfields.js',false, false, 1 );
		wp_localize_script( 'mp_customfields', 	'MP_CustomFieldsL10n',  array( 
			'object_id' 	=> 'mail_id',
		 ) );

		wp_register_script( 'mp-lists', 		'/' . MP_PATH . 'mp-includes/js/mp_lists.js', array( 'mp-ajax-response', 'mp_customfields' ), false, 1 );

		wp_register_script( 'mp_html_sifiles', 	'/' . MP_PATH . 'mp-includes/js/fileupload/si.files.js', array(), false, 1 );
		wp_register_script( 'mp_html_upload', 	'/' . MP_PATH . 'mp-includes/js/fileupload/htm.js', array( 'mp_html_sifiles' ), false, 1 );
		wp_localize_script( 'mp_html_upload', 'htmuploadL10n', array( 
			'img' => 'images/wpspin_light.gif',
			'iframeurl' 	=> admin_url( 'admin-ajax.php' ), 
			'uploading' 	=> __( 'Uploading ...', 'MailPress' ), 
			'attachfirst' 	=> __( 'Attach a file', 'MailPress' ), 
			'attachseveral' 	=> __( 'Attach another file', 'MailPress' ), 
			'l10n_print_after'=> 'try{convertEntities( htmuploadL10n );}catch( e ){};' 
		 ) );

		wp_register_script( 'mp-thickbox', 		'/' . MP_PATH . 'mp-includes/js/mp_thickbox.js', array( 'thickbox' ), false, 1 );

		$deps = array( 'quicktags', 'mp-autosave', 'mp-lists', 'postbox' );
		if ( user_can_richedit() )	$deps[] = 'editor';
		$deps[] = 'thickbox';
		$deps[] = 'mp-thickbox';
//		$deps[] = ( self::flash() ) ? 'mp_swf_upload' : 'mp_html_upload';
		$deps[] = 'mp_html_upload';

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/write.js', $deps, false, 1 );
		wp_localize_script( self::screen, 'MP_AdminPageL10n', array( 
			'screen' 		=> self::screen,

			'errmess' 		=> __( 'Enter a valid email !', 'MailPress' ), 

			'sendImmediately'	=> __( 'Send <b>immediately</b>', 'MailPress' ),
			'sendOnFuture' 	=> __( 'Schedule for:' ),

			'name_send' 	=> 'send',
			'schedule' 		=> __( 'Schedule' ),
			'send' 		=> __( 'Send',  'MailPress' ),

			'name_save' 	=> 'save',
			'save' 		=> __( 'Save',  'MailPress' ),
			'update' 		=> __( 'Update',  'MailPress' ),

			'html2txt'		=> __( "You are about to replace the content of plaintext area.\n 'Cancel' to stop, 'OK' to replace.",  'MailPress' ),

			'l10n_print_after' => 'try{convertEntities( MP_AdminPageL10n );}catch( e ){};' 
		 ) );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );

		if ( !parent::$is_footer )
		{
			return;
		}
	}

	public static function flash() 
	{
		return false;
	}

////  Metaboxes  ////

	public static function admin_head() 
	{
		$id = self::$get_['id'] ?? 0;
		add_meta_box( 'submitdiv', 		__( 'Send', 'MailPress' ),			array( __CLASS__, 'meta_box_submit' ), 		self::screen, 'side', 'core' );
		add_meta_box( 'attachmentsdiv', 	__( 'Attachments', 'MailPress' ),	array( __CLASS__, 'meta_box_attachments' ), 	self::screen, 'side', 'core' );

		if ( current_user_can( 'MailPress_mail_custom_fields' ) )
		{
			add_meta_box( 'customfieldsdiv', 	__( 'Custom Fields' ),		array( __CLASS__, 'meta_box_customfields' ), 	self::screen, 'normal', 'core' );
		}
		else
		{
			if ( $id )
			{
				$metas = MP_Mail_meta::get( $id );
				if ( $metas ) 
				{
					if ( !is_array( $metas ) )
					{
						$metas = array( $metas );
					}
					foreach ( $metas as $meta )
					{
						if ( $meta->meta_key[0] == '_' )
						{
							continue;
						}
						add_meta_box( 'customfieldsdiv', 	__( 'Custom Fields' ), 	array( __CLASS__, 'meta_box_browse_customfields' ), self::screen, 'normal', 'core' );
						break;
					}
				}
			}
		}

		if ( $id )
		{
			$rev_ids 	= MP_Mail_revision::get( $id );

			if ( isset( $rev_ids ) && $rev_ids )
			{
				add_meta_box( 'revisionbox', 	__( 'Mail Revisions', 'MailPress' ),	array( __CLASS__, 'meta_box_revision' ), 		self::screen, 'normal', 'high' );
			}

		}

		do_action( 'MailPress_add_meta_boxes_write', $id, self::screen );

		parent::admin_head();
	}
/**/
	public static function meta_box_submit( $draft )
	{
		global $mp_general;


		$fromname = $draft->fromname;
		$fromemail= $draft->fromemail;
		$from = "<b>{$fromname}</b> &lt;{$fromemail}&gt;";


   		$datef 		 = __( 'M j, Y @ G:i' );

		$stamp = __( 'Send <b>immediately</b>', 'MailPress' );
		$date = date_i18n( $datef, strtotime( current_time( 'mysql' ) ) );

		$save_post_class = '';
		$publish_name    = 'send';
		$publish_value   = __( 'Send', 'MailPress' );

		if ( $draft && isset( $draft->id ) )
		{

			$args			= array();
			$args['id']	= $draft->id;

// url's
			if ( current_user_can( 'MailPress_delete_mails' ) )
			{
				$args['action']	= 'delete';
				$delete_url = esc_url( self::url( MailPress_write, $args ) );
			}
                        
			$args = array( 'id' => $draft->id, 'action' => 'mp_ajax', 'mp_action' => 'iview', 'TB_iframe' => 'true' );
			$view_url = esc_url( self::url( admin_url( 'admin-ajax.php'), $args ) );

// actions
			$actions		= array();

			if ( isset( $delete_url ) )
			{
				$onclick = "onclick=\"return (confirm('" . esc_js(sprintf( __("You are about to delete this draft '%s'\n  'Cancel' to stop, 'OK' to unbounce.", 'MailPress' ), $draft->id ) ) . "'));\"";
				$actions['delete'] = '<a class="submitdelete" href="' . $delete_url . '" ' . $onclick . '>' . __( 'Delete', 'MailPress' ) . '</a>';
			}

			$actions['view'] = '<a class="preview button" href="' . $view_url . '" target="_blank">' . __( 'Preview', 'MailPress' ) . '</a>';

			if ( $draft->_scheduled )
			{
				$stamp = __( 'Scheduled for: <b>%1$s</b>', 'MailPress' );
	    			$date = date_i18n( $datef, strtotime( $draft->sent ) );

				$save_post_class = ' hidden';
				$publish_name    = 'save';
				$publish_value   = __( 'Update', 'MailPress' );
	            }
		} 

		$publish = ( current_user_can( 'MailPress_send_mails' ) ) ? '<input type="submit" name="' . $publish_name . '" id="publish" class="button-primary" value="' . esc_attr( $publish_value ) . '" />' : '';


		$out = '';
		$out .= '<div class="submitbox" id="submitpost">' . "\r\n";
		$out .= '<div id="minor-publishing"><div class="hidden"></div>' . "\r\n";

		$out .= '<div id="minor-publishing-actions">';
		$out .= '<div id="save-action"><input type="submit" name="save" id="save-post" class="button button-highlighted' . $save_post_class . '" value="' . esc_attr( __( 'Save Draft', 'MailPress' ) ) . '"  /></div>';
		$out .= '<div id="preview-action"><span id="preview-button">' . ( ( isset( $actions['view'] ) ) ? $actions['view'] : '' ) . '</span></div>';
		$out .= '<div class="clear"></div></div>' . "\r\n";

		$out .= '<div id="misc-publishing-actions">';
		$out .= '<div class="misc-pub-section mp_theme">';
		$out .= '<label>' . __( 'From: ', 'MailPress' ) . '</label><b><span id="span_from">' . $from . '</span></b>';
		if ( current_user_can( 'MailPress_write_edit_fromemail' ) )
		{
			$out .= '<a href="#edit_from" class="edit-from hide-if-no-js">' . __( 'Edit' ) . '</a>';
			$out .= '<div id="fromdiv" class="hide-if-js">';
			$out .= '<input type="hidden" name="hidden_fromname"  id="hidden_fromname"  value="' . esc_attr( $fromname ) . '" />';
			$out .= '<input type="hidden" name="hidden_fromemail" id="hidden_fromemail" value="' . esc_attr( $fromemail ) . '" />';
			$out .= __( 'Name: ', 'MailPress' )  . '<input type="text" name="fromname"  id="fromname"  size="25" value="' . esc_attr( $fromname )  . '" /><br />';
			$out .= __( 'Email: ', 'MailPress' ) . '<input type="text" name="fromemail" id="fromemail" size="25" value="' . esc_attr( $fromemail ) . '" /><br />';
			$out .= '<a href="#edit_from" class="save-from hide-if-no-js button">' . __( 'OK' ) . '</a>';
			$out .= '<a href="#edit_from" class="cancel-from hide-if-no-js">' . __( 'Cancel'  ) . '</a>';
			$out .= '</div>';
		}
		else
		{
			$out .= '<input type="hidden" name="fromname"  id="fromname"  value="' . esc_attr( $fromname  ) . '" />';
			$out .= '<input type="hidden" name="fromemail" id="fromemail" value="' . esc_attr( $fromemail ) . '" />';
		}
		$out .= '</div>' . "\r\n";

		$xthemes = array();
		$th = new MP_Themes();
		$themes = $th->themes;

		foreach( $themes as $key => $theme )
		{
			if ( 'plaintext' == $theme['Stylesheet'] )
			{
				unset( $themes[$key] );
			}
			if ( '_' == $theme['Stylesheet'][0] )
			{
				unset( $themes[$key] );
			}
		}

		$xthemes = array( '' => __( 'current', 'MailPress' ) );
		foreach ( $themes as $theme )
		{
			$xthemes[$theme['Stylesheet']] = $theme['Stylesheet'];
		}

		$current_theme = $themes[$th->current_theme]['Stylesheet'];
		$theme = $draft->theme ?? '';

		$out .= '<div class="misc-pub-section mp_theme">';
		$out .= '<label>' . __( 'Theme: ', 'MailPress' ) . '</label><b><span id="span_theme">' . $xthemes[$theme] . '</span></b>';
		$out .= '<a href="#edit_theme" class="edit-theme hide-if-no-js">' . __( 'Edit' ) . '</a>';
		$out .= '<div id="themediv" class="hide-if-js">';
		$out .= '<input type="hidden" name="hidden_theme" id="hidden_theme" value="' . esc_attr( $theme ) . '" />';
		$out .= '<select name="Theme" id="theme">' . self::select_option( $xthemes, $theme, false ) . '</select>';
		$out .= '<a href="#edit_theme" class="save-theme hide-if-no-js button">' . __( 'OK' ) . '</a>';
		$out .= '<a href="#edit_theme" class="cancel-theme hide-if-no-js">' . __( 'Cancel'  ) . '</a>';
		$out .= '</div></div>' . "\r\n";

		$out .= '<div class="misc-pub-section curtime misc-pub-section-last">';
		$out .= '<span id="timestamp">' . sprintf( $stamp, $date ) . '</span>';
		$out .= '<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" tabindex="4">' . __( 'Edit' ) . '</a>';
		$out .= '<div id="timestampdiv" class="hide-if-js">' . self::touch_time( 4 ) . '</div>';
		$out .= '</div>' . "\r\n";

		$out .= '</div><div class="clear"><br /><br /></div></div>' . "\r\n";

		$out .= '<div id="major-publishing-actions">';
		$out .= '<div id="delete-action">' . ( ( isset( $actions['delete'] ) ) ? $actions['delete'] : '' ) . '</div>';
		$out .= '<div id="publishing-action">' . $publish . '</div>';
		$out .= '<div class="clear"></div>' . "\r\n";

		$out .= '</div></div>' . "\r\n";

		echo $out;
	}

	public static function touch_time( $tab_index = 0, $edit = 1, $multi = 0 ) 
	{
		global $wp_locale, $draft;

		$tab_index_attribute = '';
		if ( ( int ) $tab_index > 0 )
		{
			$tab_index_attribute = " tabindex=\"$tab_index\"";
		}

		$time_adj = current_time( 'timestamp' );

		$draft_date = ( $draft->_scheduled ) ? $draft->sent : date_i18n( 'Y-m-d H:i' );

		$jj = ( $edit ) ? mysql2date( 'd', $draft_date, false ) : gmdate( 'd', $time_adj );
		$mm = ( $edit ) ? mysql2date( 'm', $draft_date, false ) : gmdate( 'm', $time_adj );
		$aa = ( $edit ) ? mysql2date( 'Y', $draft_date, false ) : gmdate( 'Y', $time_adj );
		$hh = ( $edit ) ? mysql2date( 'H', $draft_date, false ) : gmdate( 'H', $time_adj );
		$mn = ( $edit ) ? mysql2date( 'i', $draft_date, false ) : gmdate( 'i', $time_adj );
		$ss = ( $edit ) ? mysql2date( 's', $draft_date, false ) : gmdate( 's', $time_adj );

		$cur_jj = gmdate( 'd', $time_adj );
		$cur_mm = gmdate( 'm', $time_adj );
		$cur_aa = gmdate( 'Y', $time_adj );
		$cur_hh = gmdate( 'H', $time_adj );
		$cur_mn = gmdate( 'i', $time_adj );

		$month = '<select name="mm" id="mm" ' . $tab_index_attribute . ' >';
		for ( $i = 1; $i < 13; $i = $i +1 )
		{
			$month .= '<option value="' . zeroise( $i, 2 ) . ( ( $i == $mm ) ? '" selected="selected"' : '"' ) . '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . '</option>' . "\n";
		}
		$month .= '</select>';

		$day    = '<input type="text" name="jj" id="jj" size="2" maxlength="2" ' . $tab_index_attribute . ' autocomplete="off" value="' . $jj . '" />';
		$year   = '<input type="text" name="aa" id="aa" size="4" maxlength="4" ' . $tab_index_attribute . ' autocomplete="off" value="' . $aa . '" />';
		$hour   = '<input type="text" name="hh" id="hh" size="2" maxlength="2" ' . $tab_index_attribute . ' autocomplete="off" value="' . $hh . '" />';
		$minute = '<input type="text" name="mn" id="mn" size="2" maxlength="2" ' . $tab_index_attribute . ' autocomplete="off" value="' . $mn . '" />';

		$out = '';
		$out .= '<div class="timestamp-wrap">';	/* translators: 1: month input, 2: day input, 3: year input, 4: hour input, 5: minute input */
		$out .= sprintf( __( '%1$s%2$s, %3$s @ %4$s : %5$s' ), $month, $day, $year, $hour, $minute );
		$out .= '</div><input type="hidden" name="ss" id="ss" value="' . $ss . '" />';
		$out .= "\n\n";
		foreach ( array( 'mm', 'jj', 'aa', 'hh', 'mn' ) as $timeunit ) 
		{
   			$cur_timeunit = 'cur_' . $timeunit;

			$out .= '<input type="hidden" name="hidden_' . $timeunit . '" id="hidden_' . $timeunit . '" value="' . $$timeunit     . '" />' . "\n";
			$out .= '<input type="hidden" name="cur_'    . $timeunit . '" id="cur_'    . $timeunit . '" value="' . $$cur_timeunit . '" />' . "\n";
		}
		$out .= '<p>';
		$out .= '<a href="#edit_timestamp" class="save-timestamp hide-if-no-js button">' . __( 'OK' )     . '</a>';
		$out .= '<a href="#edit_timestamp" class="cancel-timestamp hide-if-no-js">'      . __( 'Cancel' ) . '</a>';
		$out .= '</p>';

		return $out;
	}

/**/
	public static function meta_box_plaintext( $draft )
	{
		$out = '';
		$out .= '<textarea name="plaintext" id="plaintext" rows="1" cols="40">' . ( ( isset( $draft->plaintext ) ) ? str_replace( '&', '&amp;', $draft->plaintext ) : '' ) . '</textarea>' . "\r\n";
		$out .= '<div id="div_html2txt" class="hidden">';
		$out .= '<a id="html2txt" class="button hide-if-no-js" onclick="return false;" title="' . esc_attr( __( 'Plaintext from Html', 'MailPress' ) ) . '" href="#"><span class="mp-media-buttons-icon"></span>' . __( 'Synchronize', 'MailPress' ) . '</a>';
		$out .= '</div>';

		echo $out;
	}
/**/
	public static function meta_box_revision( $draft )
	{
		MP_Mail_revision::listing( $draft->id );
	}
/**/
	public static function meta_box_attachments( $draft ) 
	{
		if ( $draft )
		{
			$draft_id = $draft->id ?? 0;
		}

		$divid = 'html-upload-ui';
		$divs  = '<div class="mp_fileupload_txt"><span class="mp_fileupload_txt"></span></div><div class="mp_fileupload_file" id="mp_fileupload_file_div"></div>';

		$out = '';

		$out .= '<script type="text/javascript">' . "\r\n";
		$out .= '/* <![CDATA[ */' . "\r\n";
		$out .= 'var draft_id = ' . $draft_id . ';' . "\r\n";
		$out .= '/* ]]> */' . "\r\n";
		$out .= '</script>' . "\r\n";

		$out .= '<div id="attachment-items">' . "\r\n";
		$out .= self::get_attachments_list( $draft_id );
		$out .= '</div>' . "\r\n";

		$out .= '<div><span id="attachment-errors"></span></div>' . "\r\n";

		$out .= '<div id="html-upload-ui">';
		$out .= '<div class="mp_fileupload_txt"><span class="mp_fileupload_txt button-secondary"></span></div>';
		$out .= '<div class="mp_fileupload_file" id="mp_fileupload_file_div"></div>';
		$out .= '<br class="clear" />';
		$out .= '<input type="hidden" name="type_of_upload" value="html-upload-ui" />';
		$out .= '</div>' . "\r\n";

		echo $out;
	}

	public static function get_attachments_list( $draft_id )
	{
		$out = '';
		$metas = MP_Mail_meta::has( $draft_id, '_MailPress_attached_file' );
		if ( $metas )
		{
			foreach( $metas as $meta )
			{
				$out .= self::get_attachment_row( $meta );
			}
		}
		return $out;
	}

	public static function get_attachment_row( $meta )
	{
		$meta_value = maybe_unserialize( $meta['meta_value'] );
		if ( !is_file( $meta_value['file_fullpath'] ) )
		{
			return;
		}

		if ( !class_exists( 'MP_Tracking_files', false ) ) new MP_Tracking_files();
		$fe = apply_filters( 'MailPress_tracking_files_ext_get', pathinfo( $meta_value['file_fullpath'], PATHINFO_EXTENSION ) );
		$class = $fe->classes ?? 'mp_ext mp_ext_unknown';

		//$fname = ( strlen( $meta_value['name'] ) > 33 ) ? substr( $meta_value['name'], 0, 30 ) . '...' : $meta_value['name'];

		$href = esc_url( add_query_arg( array( 'action' => 'mp_ajax', 'mp_action' => 'attach_download', 'id' => $meta['meta_id'] ), admin_url( 'admin-ajax.php' ) ) );

		$out = '';
		$out .= '<div id="attachment-item-' . $meta['meta_id'] . '" class="attachment-item child-of-' . $meta['mp_mail_id'] . '">';
		$out .= '<table>';
		$out .= '<tr>';
		$out .= '<td><input type="checkbox" name="Files[' . $meta['meta_id'] . ']" value="' . esc_attr( $meta['meta_id'] ) . '" class="mp_fileupload_cb" checked="checked" />	</td>';
		$out .= '<td><div class="' . $class . '"></div><div><a href="' . $href . '" class="attachme" title="' . esc_attr( $meta_value['name'] ) . '">' . $meta_value['name'] . '</a></div></td>';
		$out .= '</tr>';
		$out .= '</table>';
		$out .= '</div>' . "\r\n";

		return $out;
	}

	public static function select_optgroup( $list, $selected, $echo = true )
	{
		foreach( $list as $value => $label )
		{
			$_selected = ( !is_array( $selected ) ) ? $selected : ( ( in_array( $value, $selected ) ) ? $value : null );
			$list[$value] = '<option ' . self::selected( ( string ) $value, ( string ) $_selected, false, false ) . ' value="' . esc_attr( $value ) . '">' . esc_html( $label ) . '</option>';
		}

		$opened = false;

		foreach( $list as $value => $html )
		{
			if ( empty( $value ) )
			{
				continue;
			}
			switch ( true )
			{
				case ( in_array( $value , array( '2', '3' ) ) ) :
					$optgroup = 'MailPress_comment';
				break;
				case ( is_numeric( $value ) ) :
					$optgroup = 'MP_User';
				break;
				default :
					$optgroup = ( $pos = strpos( $value, '~' ) ) ? substr( $value, 0, $pos ) : null;
				break;
			}
			if ( isset( $$optgroup ) )
			{
				continue;
			}
			$list[$value] = ( ( $opened ) ? '</optgroup>' : '' ) . '<optgroup label="' . esc_attr( apply_filters( 'MailPress_mailinglists_optgroup', __( '(unknown)', 'MailPress' ), $optgroup ) ) . '">' . $html;
			$opened = $$optgroup = true;
		}

		$x = implode( '', $list ) . ( ( $opened ) ? '</optgroup>' : '' );

		if ( !$echo )
		{
			return "\n$x\n";
		}
		echo "\n$x\n";
	}
/**/
	public static function meta_box_browse_customfields( $draft )
	{
		MP_Mail_customfields::meta_box_browse_customfields( $draft );
	}

	public static function meta_box_customfields( $draft )
	{
		MP_Mail_customfields::meta_box_customfields( $draft );
	}
}