<?php 
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen		= MailPress_page_users;
	const capability	= 'MailPress_edit_users';
	const help_url		= 'http://blog.mailpress.org/tutorials/';
	const file			= __FILE__;

////  Redirect  ////

	public static function redirect() 
	{
		add_action( 'MailPress_users_restrict', array( __CLASS__, 'users_restrict' ), 1, 1 );

		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms();
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count	.= 'd';
		$$count	= 0;

		switch( $action )
		{
			case 'bulk-activate' :
				foreach( $checked as $id )
				{
					if ( MP_User::set_status( $id, 'active' ) )
					{
						$$count++;
					}
				}
			break;
			case 'bulk-deactivate' :
				foreach( $checked as $id )
				{
					if ( MP_User::set_status( $id, 'waiting' ) )
					{
						$$count++;
					}
				}
			break;
			case 'bulk-unbounce' :
				foreach( $checked as $id ) { if ( MP_User::set_status( $id, 'waiting' ) )
				{
					MP_User_meta::delete( $id, '_MailPress_bounce_handling' );
					$$count++;
                                } }
			break;
			case 'bulk-delete' :
				foreach( $checked as $id )
				{
					if ( MP_User::set_status( $id, 'delete' ) )
					{
						$$count++;
					}
				}
			break;
			default :
				$$count = do_action( 'MailPress_do_bulk_action_' . self::screen, $action, $checked );
			break;
		}
		if ( $$count )
		{
			$url_parms[$count] = $$count;
		}
		self::mp_redirect( self::url( MailPress_users, $url_parms ) );
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Users :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'This screen provides access to all of your mp users. You can customize the display of this screen to suit your needs.', 'MailPress' ) . '</p>';


		$current_screen->add_help_tab( array( 	'id'        => 'overview',
										'title'        => __( 'Overview' ),
										'content'    => $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can customize the display of this screen&#8217;s contents in a number of ways:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( 'You can hide/display columns based on your needs and decide how many mp users to list per screen using the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'You can filter the list of mp users by status using the text links above the mp users list to only show mp users with that status. The default view is to show all mp users.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'Depending on which add on you have activated, you may find new columns and/or new filters.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'        => 'screen-display',
										'title'        => __( 'Screen Display' ),
										'content'    => $content )
		);

		$content = '';
		$content .= '<p>' . __( 'Hovering over a row in the mp users list will display action links that allow you to manage the mp user. You can perform the following actions depending on mp user status and when available:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Edit</strong> &mdash; takes you to the editing screen for that mp user. You can also reach that screen by clicking on the mp user&#8217;s mail.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Deactivate/Activate</strong> &mdash; deactivated mp user is expected to confirm his subscription. When being activated, mp user receives a confirmation mail.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Delete</strong> &mdash; removes your mp user from this list and delete it permanently.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Tracking</strong> &mdash; displays collected informations during the tracking. Resume all data collected for each mail received by the mp user. Available for any new sent mail after tracking add on activation.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Unbounce</strong> &mdash; when using one of the bounce add-on. Bounced mp user has been over the threshold set in add-on settings.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'action-links',
										'title'	=> __( 'Available Actions' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can also permanently delete multiple mp users at once. Select the mp users you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'bulk-actions',
										'title'	=> __( 'Bulk Actions' ),
										'content'	=> $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, 		'/' . MP_PATH . 'mp-admin/css/users.css' );
		$styles[] =self::screen;

		parent::print_styles( $styles );
	}

	public static function print_styles_icons( $i = array( 'flag', 'icon', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

//// Scripts ////

	public static function print_scripts( $scripts = array() ) 
	{
		wp_register_script( 'mp-ajax-response', 	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'mp-ajax-response', 	'wpAjax', array( 
			'noPerm' => __( 'Update database failed', 'MailPress' ), 
			'broken' => __( 'An unidentified error has occurred.' ), 
			'l10n_print_after' => 'try{convertEntities( wpAjax );}catch( e ){};' 
		 ) );

		wp_register_script( 'mp-lists', 		'/' . MP_PATH . 'mp-includes/js/mp_lists.js', array( 'mp-ajax-response' ), false, 1 );

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/users.js', array( 'mp-lists' ), false, 1 );
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
		$disabled = ( !current_user_can( 'MailPress_delete_users' ) ) ? ' disabled="disabled"' : '';

		$columns = array(	'cb'		=> '<input type="checkbox"' . $disabled .  '/>', 
						'title'		=> __( 'E-mail', 'MailPress' ), 
						'user_name'	=> __( 'Name', 'MailPress' ), 
						'author'		=> __( 'Author' ), 
						'date'		=> __( 'Date' )
		);
		$columns = apply_filters( 'MailPress_users_columns', $columns );
		return $columns;
	}

//// List ////

	public static function get_list( $args ) 
	{
		extract( $args );

		global $wpdb;

		$where = $tables = '';
		$order = "a.created";

		if ( isset( $url_parms['s'] ) )
		{
			$sc = array( 'a.email', 'a.name', 'a.laststatus_IP', 'a.created_IP' );

			$where .= self::get_search_clause( $url_parms['s'], $sc );
		}

		if ( isset( $url_parms['status'] ) && !empty( $url_parms['status'] ) )
		{
			$where .= " AND a.status = '" . $url_parms['status'] . "'";
		}
		if ( isset( $url_parms['author'] ) && !empty( $url_parms['author'] ) )
		{
			$where .= " AND ( a.created_user_id = " . $url_parms['author'] . "  OR a.laststatus_user_id = " . $url_parms['author'] . " ) ";
		}

		list( $where, $tables, $no_cls ) = apply_filters( 'MailPress_users_get_list', array( $where, $tables, false ), $url_parms );

		if ( isset( $url_parms['startwith'] ) )
		{
			$where .= " AND ( a.email >= '" . $url_parms['startwith'] . "' ) ";
			$order = "a.email";
			$no_cls = true;
		}

		$args['query'] = "SELECT DISTINCT SQL_CALC_FOUND_ROWS a.id, a.email, a.name, a.status, a.confkey, a.created, a.created_IP, a.created_agent, a.created_user_id, a.created_country, a.created_US_state, a.laststatus, a.laststatus_IP, a.laststatus_agent, a.laststatus_user_id FROM $wpdb->mp_users a $tables WHERE 1=1 $where ORDER BY $order";
		$args['cache_name'] = 'mp_user';

		list( $_users, $total ) = parent::get_list( $args );

		$counts = array();
		$query = "SELECT status, count( * ) as count FROM $wpdb->mp_users GROUP BY status;";
		$statuses = $wpdb->get_results( $query );

		$subsubsub_urls = false;

		$libs = array(	'all'			=> __( 'All' ), 
					'waiting'		=> __( 'Waiting', 'MailPress' ),
					'active'		=> __( 'Active', 'MailPress' ),
					'bounced'		=> __( 'Bounced', 'MailPress' ),
					'unsubscribed'	=> __( 'Unsubscribed', 'MailPress' ),
					'search'		=> __( 'Search Results' )
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
			$counts['all'] = $wpdb->get_var( "SELECT count( * ) FROM $wpdb->mp_users;" );
			if ( isset( $url_parms['s'] ) )
			{
				$counts['search'] = count( $_users );
			}
			$out = array();

			foreach( $libs as $k => $lib )
			{
				if ( !isset( $counts[$k] ) || !$counts[$k] )
				{
					continue;
				}

				$args = array();
				if ( ( 'search' == $k ) && ( isset( $url_parms['s'] ) ) )  	$args['s'] = $url_parms['s'];
				elseif ( 'all' != $k ) 						$args['status'] = $k;
				$url	= esc_url( add_query_arg( $args, MailPress_users ) );

				$cls = '';
				if ( !$no_cls )
				{
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
				}

				$out[] = sprintf( '<a%1$s href="%2$s">%3$s <span class="count">( <span class="user-count-%4$s">%5$s</span> )</span></a>', $cls, $url, $lib, $k, $counts[$k] );
			}

			if ( !empty( $out ) )
			{
				$subsubsub_urls = '<li>' . join( ' | </li><li>', $out ) . '</li>';
			}
		}

		add_filter( 'MailPress_get_icon_users', 	array( __CLASS__, 'get_icon_users' ), 8, 2 );

		return array( $_users, $total, $subsubsub_urls );
	}

////  Row  ////

	public static function get_row( $id, $url_parms, $checkbox = true )
	{
		global $mp_user;
		static $row_class = '';

		$mp_user = $user = MP_User::get( $id );
		$the_user_status = $user->status;

// url's
		$args			= array();
		$args['id']	= $id;

		$edit_url		= esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ) ) );

		$args['action']	= 'activate';
		$activate_url	= esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ), "activate-user_$id" ) );

		$args['action']	= 'deactivate';
		$deactivate_url	= esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ), "deactivate-user_$id" ) );

		$args['action']	= 'delete';
		$delete_url	= esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ), "delete-user_$id" ) );

		unset( $args['action'] );

// actions
		$actions		= array();
		$actions['edit'] = '<a href="' . $edit_url . '"  title="' . esc_attr( sprintf( __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ), $mp_user->email ) ) . '">' . __( 'Edit' ) . '</a>';

		$actions		= apply_filters( 'MailPress_users_actions', $actions, $mp_user, $url_parms );

		$actions['approve']   = '<a href="' . $activate_url	. '" 	class="dim:the-user-list:user-' . $id . ':unapproved:e7e7d3:e7e7d3:">' . __( 'Activate', 'MailPress' )	. '</a>';
		$actions['unapprove'] = '<a href="' . $deactivate_url	. '" 	class="dim:the-user-list:user-' . $id . ':unapproved:e7e7d3:e7e7d3:">' . __( 'Deactivate', 'MailPress' )	. '</a>';

		if ( 'bounced' == $user->status )
		{
			unset( $actions['approve'], $actions['unapprove'] );
			$args['action'] = 'unbounce';
			$unbounce_url = esc_url( self::url( MailPress_user, array_merge( $args, $url_parms ) ) );
			$onclick = "onclick=\"return (confirm('" . esc_js(sprintf( __("You are about to unbounce this MailPress user '%s'\n  'Cancel' to stop, 'OK' to unbounce.", 'MailPress' ), $mp_user->id )) . "'));\"";
			$actions['unbounce'] = '<a href="' . $unbounce_url . '" ' . $onclick . '>' . __( 'Unbounce', 'MailPress' ) . '</a>';
		}

		if ( 'unsubscribed' == $user->status )
		{
			unset( $actions['approve'] );
		}

		$actions['delete'] = '<a href="' . $delete_url . '" class="submitdelete">' . __( 'Delete', 'MailPress' ) . '</a>';

		if ( !current_user_can( 'MailPress_delete_users' ) )
		{
			unset( $actions['delete'] );
		}

// table row 
//	class
		$row_class = ( 'alternate' == substr( $row_class, 0, 9 ) ) ? '' : 'alternate ';
		switch ( $the_user_status )
		{
			case 'waiting' :
				$row_class .= 'unapproved';
			break;
			case 'bounced' :
				$row_class .= 'bounced';
			break;
			case 'unsubscribed' :
				$row_class .= 'unsubscribed';
			break;
		}
// 	checkbox
		$disabled = ( !current_user_can( 'MailPress_delete_users' ) ) ? ' disabled="disabled"' : '';
// 	email
		$email_display = $user->email;
		if ( strlen( $email_display ) > 40 )
		{
			$email_display = substr( $email_display, 0, 39 ) . '...';
		}
//	author
		$x			= $url_parms['s'] ?? '';
		$url_parms['s']	= self::get_user_author_IP();
		$ip_url		= esc_url( self::url( MailPress_users, $url_parms ) );
		$url_parms['s']	= $x;

		$author = ( 0 == $user->laststatus_user_id ) ? $user->created_user_id : $user->laststatus_user_id;
		if ( $author != 0 && is_numeric( $author ) )
		{
			unset( $url_parms['author'] );
			$wp_user = get_userdata( $author );
			$author_url = esc_url( self::url( MailPress_users, array_merge( array( 'author' => $author ), $url_parms ) ) );
		}

		$out = '';
		$out .= '<tr id="user-' . $id . '" class="' . $row_class . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( in_array( $user->status, array('bounced', 'unsubscribed') ) ) ? ' fi' : '' );

 			switch ( $column_name ) 
			{
				case 'cb':
					if ( $checkbox )
					{
						$out .= '<th class="check-column">';
						$out .= ' <input type="checkbox" name="checked[]" value="' . $id . '"' . $disabled . ' />';
						$out .= '</th>';
					}
				break;
				case 'title' :

					$attributes = sprintf( 'class="username column-username%2$s%3$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '', ( in_array( $user->status, array('bounced', 'unsubscribed') ) ) ? ' fi' : '' );

					$out .= '<td ' . $attributes . '>';
					$out .= self::get_flag_IP();
					$out .= apply_filters( 'MailPress_get_icon_users', '', $mp_user ); 
					$out .= ( get_option( 'show_avatars' ) ) ? get_avatar( $user->email, 32 ) : '';
					$out .= '<strong>';
					$out .= '<a class="row-title" href="' . $edit_url . '" title="' . esc_attr( sprintf( __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ) ,$user->email ) ) . '">';
					$out .= $email_display;
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

	public static function get_user_date( $d = '' )
	{
		$x = self::get_user_date_raw();
		return ( '' == $d ) ? mysql2date( get_option( 'date_format' ), $x ) : mysql2date( $d, $x );
	}

	public static function get_user_date_raw()
	{
		global $mp_user;
		return ( $mp_user->created >= $mp_user->laststatus ) ? $mp_user->created : $mp_user->laststatus;
	}

	public static function get_user_author_IP()
	{
		global $mp_user;
		$ip = ( '' == $mp_user->laststatus_IP ) ? $mp_user->created_IP : $mp_user->laststatus_IP;
		return $ip;
	}

	public static function get_flag_IP()
	{
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

//// Body ////

	public static function users_restrict( $url_parms )
	{
		global $wpdb;
		$list = array();

		$query = "SELECT DISTINCT UPPER( SUBSTRING( email, 1, 1 ) ) as letter FROM $wpdb->mp_users ORDER BY 1;";
		$letters = $wpdb->get_results( $query );

		if ( $letters )
		{
			$list[-1] = __( 'Starting with...', 'MailPress' );
		}
		foreach ( $letters as $letter )
		{
			$list[$letter->letter] = $letter->letter;
		}

		echo '<select name="startwith" id="letters_dropdown" class="postform">';
		self::select_option( $list, $url_parms['startwith'] ?? -1 );
		echo '</select>';
	}
}