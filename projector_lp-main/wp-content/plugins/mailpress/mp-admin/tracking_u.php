<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen		= 'mailpress_tracking_u';
	const capability	= 'MailPress_tracking_users';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/tracking/';
	const file			= __FILE__;

	const map_of		= 'mp_user';

////  Title  ////

	public static function title() 
	{
		new MP_Tracking_metaboxes( 'user' );

		global $title; 
		$title = __( 'Tracking', 'MailPress' ); 
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Tracking User :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . sprintf( __( 'Depending of your choice in %s settings, several boxes are displayed and are reporting the activity tracked for that mp user.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_settings . '&tab=tracking', __( 'Tracking', 'MailPress' ) ) ) . '</p>';

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

		wp_register_style( 'mp_users', 		'/' . MP_PATH . 'mp-admin/css/users.css' );
		$styles[] = 'mp_users';

		wp_register_style( self::screen, 	'/' . MP_PATH . 'mp-admin/css/tracking_u.css' );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

	public static function print_styles_icons( $i = array( 'browser', 'device', 'flag', 'icon', 'os', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() )  
	{
		$scripts = apply_filters( 'MailPress_autorefresh_js', $scripts );

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/tracking_t.js', array( 'postbox' ), false, 1 );
		wp_localize_script( self::screen, 		'MP_AdminPageL10n',  array( 'screen' => self::screen ) );

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
		$columns = array(	'title'		=> __( 'E-mail', 'MailPress' ),
						'user_name'	=> __( 'Name', 'MailPress' ),
						'author'		=> __( 'Author' ),
						'date'		=> __( 'Date' )
		);
		$columns = apply_filters( 'MailPress_users_columns', $columns );
		return $columns;
	}

////  Row  ////

	public static function get_row( $id, $url_parms, $xtra = false )
	{
		add_filter( 'MailPress_get_icon_users', 	array( __CLASS__, 'get_icon_users' ), 8, 2 ); // just one row !

		global $mp_user;

		$mp_user = $user = MP_User::get( $id );
		$the_user_status = $user->status;

// url's
		$args = array();
		$args['id'] = $id;

		$edit_url = esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ) ) );

		$author = ( 0 == $user->laststatus_user_id ) ? $user->created_user_id : $user->laststatus_user_id;
		if ( $author != 0 && is_numeric( $author ) )
		{
			unset( $url_parms['author'] );
			$wp_user = get_userdata( $author );
			$author_url = esc_url( self::url( MailPress_users, array_merge( array( 'author'=>$author ), $url_parms ) ) );
		}

// actions
		$actions = array();
		$actions['edit'] = '<a href="' . $edit_url . '"  title="' . esc_attr( sprintf( __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ), $mp_user->email ) ) . '">' . __( 'Edit' ) . '</a>';

// table row 
//	class
		$row_class = '';
		if ( 'waiting' == $the_user_status ) $row_class = 'unapproved';
		if ( 'bounced' == $the_user_status ) $row_class = 'bounced';
		if ( 'unsubscribed' == $the_user_status ) $row_class = 'unsubscribed';

		$out = '';
		$out .= '<tr id="user-' . $id . '" class="' . $row_class . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( in_array( $user->status, array('bounced', 'unsubscribed') ) ) ? ' fi' : '' );

			switch ( $column_name ) 
			{
				case 'title' :
					$attributes = sprintf( 'class="username column-username%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( in_array( $user->status, array('bounced', 'unsubscribed') ) ) ? ' fi' : '' );

					$out .= '<td ' . $attributes . '>';
					$out .= self::get_flag_IP();
					$out .= apply_filters( 'MailPress_get_icon_users', '', $mp_user ); 
					$out .= ( get_option( 'show_avatars' ) ) ? get_avatar( $user->email, 32 ) : '';
					$out .= '<strong>';
					$out .= '<a class="row-title" href="' . $edit_url . '" title="' . esc_attr( sprintf( __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ) ,$user->email ) ) . '">';
					$out .= $mp_user->email;
					$out .= '</a>';
					$out .= '</strong>';
					$out .= self::get_actions( $actions );
					$out .= '</td>';
				break;
				case 'user_name' :
					$out .= '<td ' . $attributes . '>';
					$out .= '<abbr title="' . esc_attr( $user->name ) . '">' . esc_attr( $user->name ) . '</abbr>';
					$out .= '</td>';
				break;
				case 'date' :

					$t_time = self::get_user_date( __( 'Y/m/d H:i:s' ) );
					$h_time = self::human_time_diff( self::get_user_date_raw() );

					$out .= '<td ' . $attributes . '>';
					$out .= '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';
					$out .= '</td>';
				break;
				case 'author' :
					$out .= '<td ' . $attributes . '>';
					if ( $author != 0 && is_numeric( $author ) )
					{
						$out .= '<a href="' . $author_url . '" title="' . esc_attr( sprintf( __( 'Users by &#8220;%1$s&#8221;', 'MailPress' ), $wp_user->display_name ) ) . '">' . $wp_user->display_name . '</a>';
					}
					else
					{
						$out .= __( '(unknown)', 'MailPress' );
					}
					$out .= '</td>';
				break;
				default:
					$out .= '<td ' . $attributes . '>';
					$out .= apply_filters( 'MailPress_users_get_row', '', $column_name, $user, $url_parms );
					$out .= '</td>';
				break;
			}
		}
		$out .= '</tr>';

		return $out;
	}

	public static function get_user_date( $d = '' ) {
		$x = self::get_user_date_raw();
		return ( '' == $d ) ? mysql2date( get_option( 'date_format' ), $x ) : mysql2date( $d, $x );
	}

	public static function get_user_date_raw() {
		global $mp_user;
		return ( $mp_user->created >= $mp_user->laststatus ) ? $mp_user->created : $mp_user->laststatus;
	}

	public static function get_user_author_IP() {
		global $mp_user;
		$ip = ( '' == $mp_user->laststatus_IP ) ? $mp_user->created_IP : $mp_user->laststatus_IP;
		return $ip;
	}

	public static function get_flag_IP() 	{
		global $mp_user;
		return ( ( 'ZZ' == $mp_user->created_country ) || empty( $mp_user->created_country ) ) ? '' : '<div class="mp_flag mp_flag_' . strtolower( $mp_user->created_country ) . '" title="' . esc_attr( strtolower( $mp_user->created_country ) ) . '"></div>';
	}

	public static function get_icon_users( $out, $mp_user )
	{
		if ( 'unsubscribed' == $mp_user->status )
		{
			$out .= '<span class="mp_icon mp_icon_unsubscribed" title="' . esc_attr( __( 'Unsubscribed', 'MailPress' ) ) . '"></span>';
		}
		return $out;
	}
}