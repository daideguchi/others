<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= 'mailpress_user';
	const capability	= 'MailPress_edit_users';
	const help_url		= 'http://blog.mailpress.org/tutorials/';
	const file			= __FILE__;

	const map_of		= 'mp_user';

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		if ( isset( self::$get_['id'] ) )
		{
			$id = self::$get_['id'];
		}

		$list_url = self::url( MailPress_users, self::get_url_parms() );

		switch( $action ) 
		{
			case 'activate' :
				if ( MP_User::set_status( $id, 'active' ) )
				{
					$list_url .= '&activated=1';
				}
				self::mp_redirect( $list_url );
			break;
			case 'deactivate' :
				if ( MP_User::set_status( $id, 'waiting' ) )
				{
					$list_url .= '&deactivated=1';
				}
				self::mp_redirect( $list_url );
			break;
			case 'unbounce' :
				if ( MP_User::set_status( $id, 'waiting' ) )
				{
					MP_User_meta::delete( $id, '_MailPress_bounce_handling' );
					$list_url .= '&unbounced=1';
				}
				self::mp_redirect( $list_url );
			break;
			case 'delete' :
				if ( MP_User::set_status( $id, 'delete' ) )
				{
					$list_url .= '&deleted=1';
				}
				self::mp_redirect( $list_url );
			break;

			case 'save' :
				$id = ( int ) self::$pst_['id'];

				if ( self::$pst_['mp_user_name'] != self::$pst_['mp_user_old_name'] )
				{
					MP_User::update_name( $id, self::$pst_['mp_user_name'] );
				}

				switch ( true )
				{
					case isset( self::$pst_['addmeta'] ) :
						MP_User_meta::add_meta( $id );
					break;
					case isset( self::$pst_['usermeta'] ) :
						foreach ( self::$pst_['usermeta'] as $meta_id => $meta )
						{
							$meta_key = $meta['key'];
							$meta_value = $meta['value'];
							MP_User_meta::update_by_id( $meta_id , $meta_key, $meta_value );
						}
					break;
					case isset( self::$pst_['deletemeta'] ) :
						foreach ( self::$pst_['deletemeta'] as $meta_id => $x )
						{
							MP_User_meta::delete_by_id( $meta_id );
						}
					break;
				}

				// what else ?
				do_action( 'MailPress_update_meta_boxes_user' );

				$parm = "&saved=1";

				$url = MailPress_user;
				$url .= "$parm&id=$id";
				self::mp_redirect( $url );
			break;
		} 
	}

////  Title  ////

	public static function title()
	{
		global $title;
		$title = __( 'MailPress User', 'MailPress' );
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'User :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'You can modify information on each mp user:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Name</strong> &mdash; only name can be modified, email being the unique key.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Other tabs</strong> &mdash; check other help tabs for more information.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);

                $content = '';
                $content .= '<p>' . __( '<strong>Custom Fields</strong> &mdash; is only used for text replacement in mails.', 'MailPress' ) . '</p>';
                $content .= '<p>' . __( 'Let us say you want to manage honorific (e.g. : Mr, Miss, Sir ...) for all mp users. Create a custom field with name "honorific" and the appropriate value for each mp user. When creating a new Mail, you can write to a set of mp users starting your mail with the following "Dear {{honorific}}" (double opening and closing curly brackets inspired by <code>{{mustache}}</code> ). At the mail level, you can also create a default custom field "honorific" that will be the value if it was missing at the mp user level.', 'MailPress' ) . '</p>';
                $content .= '<p>' . __( 'Custom fields can also be populated when importing mp users (import add-on).', 'MailPress' ) . '</p>';
                $current_screen->add_help_tab( array( 	'id'		=> 'customfields',
										'title'	=> __( 'Custom Fields', 'MailPress' ),
										'content'	=> $content )
		);
                
                do_action( 'MailPress_add_help_tab_user' );
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		$styles[] = MP_Map::print_styles();

		wp_register_style( self::screen,	'/' . MP_PATH . 'mp-admin/css/user.css', array( 'thickbox' ) );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

	public static function print_styles_icons( $i = array( 'flag', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() ) 
	{
		global $mp_general;

		$deps[] = MP_Map::print_scripts();

		wp_register_script( 'mp-ajax-response', 	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'mp-ajax-response', 	'wpAjax', array( 	
			'noPerm' => __( 'Update database failed', 'MailPress' ), 
			'broken' => __( 'An unidentified error has occurred.' ), 
			'l10n_print_after' => 'try{convertEntities( wpAjax );}catch( e ){};' 
		 ) );

		$deps[] = 'jquery-ui-tabs';

		wp_register_script( 'mp_customfields',	'/' . MP_PATH . 'mp-includes/js/mp_customfields.js',false, false, 1 );
		wp_localize_script( 'mp_customfields', 	'MP_CustomFieldsL10n',  array( 
			'object_id' => 'mp_user_id',
		 ) );

		wp_register_script( 'mp-lists', 		'/' . MP_PATH . 'mp-includes/js/mp_lists.js', array( 'mp-ajax-response', 'mp_customfields' ), false, 1 );

		$deps[] = 'mp-lists';
		$deps[] = 'postbox';

		wp_register_script( 'mp-thickbox', 		'/' . MP_PATH . 'mp-includes/js/mp_thickbox.js', array( 'thickbox' ), false, 1 );
		$deps[] = 'mp-thickbox';

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/user.js', $deps, false, 1 );
		wp_localize_script( self::screen, 		'MP_AdminPageL10n',  array( 
			'screen' => self::screen,
		 ) );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

////  Metaboxes  ////

	public static function admin_head() 
	{
		global $mp_general;

		$id = self::$get_['id'] ?? 0;
		add_meta_box( 'submitdiv',	__( 'Save', 'MailPress' ), 	array( __CLASS__, 'meta_box_submit' ), 	self::screen, 'side', 'core' );

		add_meta_box( 'IP_info', 	__( 'IP info', 'MailPress' ), 	array( __CLASS__, 'meta_box_IP_info' ), 	self::screen, 'side', 'core' );

		if ( current_user_can( 'MailPress_user_custom_fields' ) )
		{
			add_meta_box( 'customfieldsdiv', 	__( 'Custom Fields' ), 	array( __CLASS__, 'meta_box_customfields' ), self::screen, 'normal', 'core' );
		}
		else
		{
			if ( $id )
			{
				$metas = MP_User_meta::get( $id );
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

		do_action( 'MailPress_add_meta_boxes_user', $id, self::screen );

		parent::admin_head();
	}
/**/
	public static function meta_box_submit( $mp_user ) 
	{
		$url_parms 	= self::get_url_parms();

		$args			= array();
		$args['id']	= $mp_user->id;

// url's
		if ( class_exists( 'MailPress_tracking' ) )
		{
			$tracking_url   = esc_url( self::url( MailPress_tracking_u, $args ) );
		}

		if ( current_user_can( 'MailPress_delete_users' ) )
		{
			$args['action']	= 'delete';
			$delete_url	= esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ), "delete-user_{$mp_user->id}" ) );
		}

		if ( 'bounced' == $mp_user->status )
		{
			$args['action'] = 'unbounce';
			$unbounce_url = esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ) ) );
		}

// actions
		$actions		= array();

		if ( isset( $tracking_url ) )
		{
			$actions['tracking'] = '<a class="button preview" href="' . $tracking_url . '">' . __( 'Tracking', 'MailPress' ) . '</a>';
		}

		if ( isset( $delete_url ) )
		{
			$onclick = "onclick=\"return (confirm('" . esc_js(sprintf( __("You are about to delete this MailPress user '%s'\n  'Cancel' to stop, 'OK' to delete.", 'MailPress' ), $mp_user->id )) . "') );\"";
			$actions['delete'] = '<a class="submitdelete" href="' . $delete_url . '" ' . $onclick . '>' . __( 'Delete', 'MailPress' ) . '</a>';
		}

		if ( isset( $unbounce_url ) )
		{
			$onclick = "onclick=\"return (confirm('" . esc_js(sprintf( __("You are about to unbounce this MailPress user '%s'\n  'Cancel' to stop, 'OK' to unbounce.", 'MailPress' ), $mp_user->id )) . "') );\"";
			$actions['unbounce'] = '<a href="' . $unbounce_url . '" ' . $onclick . '>' . __( 'Unbounce', 'MailPress' ) . '</a>';
		}

		$out  = '<div class="submitbox" id="submitpost">' . "\r\n";
		$out .= '	<div id="minor-publishing">' . "\r\n";
		$out .= '		<div id="minor-publishing-actions">' . "\r\n";
		$out .= '   			<span id="unbounce">';
		if ( isset( $actions['unbounce'] ) ) $out .= $actions['unbounce'];
		$out .= '</span>' . "\r\n";
		$out .= '   			<span id="tracking">';
		if ( isset( $actions['tracking'] ) ) $out .= $actions['tracking'];
		$out .= '</span>' . "\r\n";
		$out .= '		</div>' . "\r\n";
		$out .= '		<div class="clear"><br /><br /><br /><br /><br /></div>' . "\r\n";
		$out .= '	</div>' . "\r\n";
		$out .= '	<div id="major-publishing-actions">' . "\r\n";
		$out .= '		<div id="delete-action">' . "\r\n";
		if ( isset( $actions['delete'] ) ) $out .= $actions['delete'] . "\r\n";
		$out .= '		</div>' . "\r\n";
		$out .= '		<div id="publishing-action">' . "\r\n";
		$out .= '			<input type="submit" name="save" id="publish" class="button-primary" value="' . esc_attr( __( 'Save', 'MailPress' ) ) . '" />' . "\r\n";
		$out .= '		</div>' . "\r\n";
		$out .= '		<div class="clear"></div>' . "\r\n";
		$out .= '	</div>' . "\r\n";
		$out .= '</div>' . "\r\n";

		echo $out;
	}
/**/
	public static function meta_box_IP_info( $mp_user )
	{
		$t = array();
		$t['meta_box_IP_info']['settings'] = null;

	// meta_box_IP_info
		$y = false;
		$ip = ( '' == $mp_user->laststatus_IP ) ? $mp_user->created_IP : $mp_user->laststatus_IP;
		$y  = MP_Ip::get_all( $ip );

	// meta_box_IP_info settings
		$t['meta_box_IP_info']['settings'] = MP_User_meta::get( $mp_user->id, '_MailPress_meta_box_IP_info' );
		if ( !$t['meta_box_IP_info']['settings'] ) $t['meta_box_IP_info']['settings'] = get_user_option( '_MailPress_meta_box_IP_info' );
		$def_lat = $y['geo']['lat'] ?? 48.8352;
		$def_lng = $y['geo']['lng'] ?? 2.4718;
		if ( !$t['meta_box_IP_info']['settings'] ) $t['meta_box_IP_info']['settings'] = array( 'center_lat' => $def_lat, 'center_lng' => $def_lng, 'zoomlevel' => 3, 'maptype' => 'NORMAL' );
		$t['meta_box_IP_info']['settings']['prefix'] = 'meta_box_IP_info';
		$t['meta_box_IP_info']['settings']['count'] = 1;

	// meta_box_IP_info markers
		if ( isset( $y['geo'] ) )
		{
			$x = $y['geo'];
			$x['ip'] = $ip;
			if ( isset( $y['html'] ) )     $x['info']  = str_replace( '"', '&quote;', $y['html'] );
			if ( isset( $y['provider'] ) ) $x['info'] .= str_replace( '"', '&quote;', '<div><p style=\'margin:3px;\'><i><small>' . sprintf( __( 'ip data provided by %1$s', 'MailPress' ), $y['provider']['credit'] ) . '</small></i></p></div>' );
			$t['meta_box_IP_info']['markers'][] = $x;
		}

		$out = '';

		$out .= '<script type="text/javascript">' . "\r\n";
		$out .= '/* <![CDATA[ */' . "\r\n";
		foreach ( $t as $var => $val )
		{
			$out .= 'var ' . $var . ' = ' . MP_AdminPage::print_scripts_l10n_val( $val );
		}
		$out .= ';' . "\r\n";
		$out .= '/* ]]> */' . "\r\n";
		$out .= '</script>' . "\r\n";

		$out .= '<div id="meta_box_IP_info_map" style="overflow:hidden;height:400px;width:auto;padding:0;margin:0;"></div>';

		foreach( $t['meta_box_IP_info']['settings'] as $k => $v ) 
		{
                if ( 'prefix' == $k ) continue;
			$out .= '		<input type="hidden" id="meta_box_IP_info_' . $k . '" value="' . esc_attr( $v ) . '" />' . "\r\n";
		}

		echo $out;

		if ( isset( $x['html'] ) )
		{
			echo $x['html'];
		}
		if ( isset( $x['provider'] ) )
		{
			printf( '<div><p class="ipm3"><i><small>' . '%1$s' . '</small></i></p></div>', sprintf( __( 'ip data provided by %1$s', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', $x['provider']['credit'], $x['provider']['credit'] ) ) );
		}
	}
/**/
	public static function meta_box_browse_customfields( $mp_user )
	{
		MP_User_customfields::meta_box_browse_customfields( $mp_user );
	}

	public static function meta_box_customfields( $mp_user )
	{
		MP_User_customfields::meta_box_customfields( $mp_user );
	}
}