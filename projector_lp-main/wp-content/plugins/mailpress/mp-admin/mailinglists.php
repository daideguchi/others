<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen		= MailPress_page_mailinglists;
	const capability	= 'MailPress_manage_mailinglists';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/mailinglist/';
	const file			= __FILE__;

	const taxonomy		= MailPress_mailinglist::taxonomy;

	const add_form_id	= 'add';
	const list_id		= 'the-list';
	const tr_prefix_id	= 'mlnglst';

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms( array( 's', 'paged', 'id' ) );
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count	.= 'd';
		$$count	= 0;

		switch( $action ) 
		{
			case 'bulk-delete' :
				foreach( $checked as $id )
				{
					if ( $id == get_option( MailPress_mailinglist::option_name_default ) )
					{
						wp_die( sprintf( __( "Can&#8217;t delete the <strong>%s</strong> mailing list: this is the default one", 'MailPress' ), MP_Mailinglist::get_name( $id ) ) );
					}

					if ( MP_Mailinglist::delete( $id ) )
					{
						$$count++;
					}
				}

				if ( $$count )
				{
					$url_parms[$count] = $$count;
				}

				$url_parms['message'] = ( $$count <= 1 ) ? 3 : 4;
				self::mp_redirect( self::url( MailPress_mailinglists, $url_parms ) );
			break;

			case 'add':
				$e = MP_Mailinglist::insert( self::$pst_ );
				$url_parms['message'] = ( $e && !is_wp_error( $e ) ) ? 1 : 91;
				unset( $url_parms['s'] );
				self::mp_redirect( self::url( MailPress_mailinglists, $url_parms ) );
			break;
			case 'edited':
				unset( self::$get_['action'] );
				if ( !isset( self::$pst_['cancel'] ) ) 
				{
					$e = MP_Mailinglist::insert( self::$pst_ );
					$url_parms['message'] = ( $e && !is_wp_error( $e ) ) ? 2 : 92 ;
				}
				unset( $url_parms['id'] );
				self::mp_redirect( self::url( MailPress_mailinglists, $url_parms ) );
			break;
			case 'delete':
				if ( $url_parms['id'] == get_option( MailPress_mailinglist::option_name_default ) )
				{
					wp_die( sprintf( __( "Can&#8217;t delete the <strong>%s</strong> mailing list: this is the default one", 'MailPress' ), MP_Mailinglist::get_name( $id ) ) );
				}

				MP_Mailinglist::delete( $url_parms['id'] );
				unset( $url_parms['id'] );

				$url_parms['message'] = 3;
				self::mp_redirect( self::url( MailPress_mailinglists, $url_parms ) );
			break;
		}
	}

////  Title  ////

	public static function title()
	{
		if ( isset( self::$get_['id'] ) )
		{
			global $title;
			$title = __( 'Edit Mailinglist', 'MailPress' );
		}
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Mailing lists :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . sprintf( __( 'You can use mailing list to group mp users for sending them any %1$s.', 'MailPress' ),  sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_write, __( 'Mail', 'MailPress' ) ) ) . '</p>';
		$content .= '<p>' . sprintf( __( 'The default mailing list is &#8220;Uncategorized&#8221; until you change it in your %1$s settings.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>',MailPress_settings, __( 'General', 'MailPress' ) ) ) . '</p>';
		$content .= '<p>' . sprintf( __( 'You can also make these mailing list public for subscription with your %1$s settings.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_settings . '&tab=subscriptions', __( 'Subscriptions', 'MailPress' ) ) ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'        => 'overview',
										'title'        => __( 'Overview' ),
										'content'    => $content )
		);

		$content = '';
		$content .= '<p>' . __( 'When adding a new mailing list on this screen, you&#8217;ll fill in the following fields:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Name</strong> &mdash; The name is how it appears on your site.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Slug</strong> &mdash; The &#8220;slug&#8221; is the unique version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Description</strong> &mdash; The description is not prominent by default.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Parent</strong> &mdash; Mailing lists, can have a hierarchy. You might have a Rock&#8217;n roll mailing list, and under that have children mailing lists for Elvis and The Beatles. Totally optional ! To create a sub mailing list, just choose another mailing list from the Parent dropdown.', 'MailPress' ) . '</li>';
		$content .= '</ul>';
		$content .= '<p>' . __( 'You can customize the display of this screen&#8217;s content:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( 'You can hide/display columns based on your needs and decide how many mailing lists to list per screen using the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'        => 'adding-terms',
										'title'        => __( 'Adding Mailinglists', 'MailPress' ),
										'content'    => $content )
		);


	}

//// Scripts ////

	public static function print_scripts( $scripts = array() ) 
	{
		wp_register_script( 'mp-ajax-response',	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'mp-ajax-response', 	'wpAjax', array( 
			'noPerm' => __( 'An unidentified error has occurred.' ), 
			'broken' => __( 'An unidentified error has occurred.' ), 
			'l10n_print_after' => 'try{convertEntities( wpAjax );}catch( e ){};' 
		 ) );

		wp_register_script( 'mp-lists', 		'/' . MP_PATH . 'mp-includes/js/mp_lists.js', array( 'mp-ajax-response' ), false, 1 );

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-includes/js/mp_taxonomy.js', array( 'mp-lists' ), false, 1 );
		wp_localize_script( self::screen, 		'MP_AdminPageL10n', array( 
			'pending' => __( '%i% pending' ), 
			'screen'  => self::screen,
			'list_id' => self::list_id,
			'add_form_id' => self::add_form_id,
			'tr_prefix_id' => self::tr_prefix_id,
			'l10n_print_after' => 'try{convertEntities( MP_AdminPageL10n );}catch( e ){};' 
		 ) );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

//// Columns ////

	public static function get_columns() 
	{
		$columns = array(	'cb'		=> '<input type="checkbox" />',
						'name'	=> __( 'Name', 'MailPress' ),
						'desc'	=> __( 'Description', 'MailPress' ),
						'allowed'	=> __( 'Allowed', 'MailPress' ),
						'num'		=> __( 'MP users', 'MailPress' )
		);
		return $columns;
	}

//// List ////

	public static function get_list( $args )
	{
		extract( $args );

		$url_parms = self::get_url_parms( array( 's', 'paged' ) );

		$_args = array( 'offset' => ( $start - 1 ) * $_per_page, 'number' => $_per_page, 'hide_empty' => 0 );
		if ( isset( $url_parms['s'] ) )
		{
			$_args['search'] = $url_parms['s'];
		}

		$_mailinglists = MP_Mailinglist::get_all( $_args );
		if ( empty( $_mailinglists ) )
		{
			return false;
		}

		$children = _get_term_hierarchy( self::taxonomy );

		foreach( $_mailinglists as $_mailinglist )
		{
			$_mailinglist->_found = true;
			$mailinglists[$_mailinglist->term_id] = $_mailinglist;
		}
		unset( $_mailinglists, $_mailinglist );

		foreach( $mailinglists as $mailinglist )
		{
			if ( !$my_parent = $mailinglist->parent )
			{
				continue;
			}

			do
			{  
				if ( !isset( $mailinglists[$my_parent] ) )
				{
					$mailinglists[$my_parent] = get_term( $my_parent, self::taxonomy );
				}
				$my_parent = $mailinglists[$my_parent]->parent;  
			} while ( $my_parent );
		}
		echo self::_get_list( $mailinglists, $url_parms, $children );
	}

	public static function _get_list( $mailinglists, $url_parms, &$children, $level = 0, $parent = 0 )
	{
		$out = ''; 
		foreach ( $mailinglists as $key => $mailinglist )  
		{ 
			if ( $parent == $mailinglist->parent )  
			{ 
				$out .= self::get_row( $mailinglist, $url_parms, $level ); 
				unset( $mailinglists[ $key ] ); 
				if ( isset( $children[$mailinglist->term_id] ) )
				{
					$out .= self::_get_list( $mailinglists, $url_parms, $children, $level + 1, $mailinglist->term_id );
				}
			} 
		} 
		return $out;
	}

////  Row  ////

	public static function get_row( $mailinglist, $url_parms, $level, $name_override = false ) 
	{
		global $mp_subscriptions;

		static $row_class = '';

		$mailinglist = MP_Mailinglist::get( $mailinglist );

		$default_mailinglist_id = get_option( MailPress_mailinglist::option_name_default );
		$pad = str_repeat( '&#8212; ', $level );
		$name = ( $name_override ) ? $name_override : $pad . ' ' . $mailinglist->name ;

// url's
		$url_parms['action'] = 'edit';
		$url_parms['id'] = $mailinglist->term_id;

		$edit_url = esc_url( self::url( MailPress_mailinglists, $url_parms ) );
		$url_parms['action']	= 'delete';
		$delete_url = esc_url( self::url( MailPress_mailinglists, $url_parms,  'delete-mailinglist_' . $mailinglist->term_id ) );
// actions
		$actions = array();
		$actions['edit'] = '<a href="' . $edit_url . '">' . __( 'Edit' ) . '</a>';
		$actions['delete'] = '<a class="submitdelete delete-' . self::tr_prefix_id . '" href="' . $delete_url . '">' . __( 'Delete' ) . '</a>';

		if ( $default_mailinglist_id == $mailinglist->term_id )
		{
			unset( $actions['delete'] );
		}

		$mailinglist->allowed = ( isset( $mp_subscriptions['display_mailinglists'][$mailinglist->term_id] ) );


		$row_class  = ( 'alternate' == substr( $row_class, 0, 9 ) ) ? '' : 'alternate ';
		$row_class .= 'iedit';
		$row_class .= ( isset( $mailinglist->_found ) ) ? '' : ' ebeeef';

		$out = '';
		$out .= '<tr id="' . self::tr_prefix_id . '-' . $mailinglist->term_id . '" class="' . $row_class . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '' );

			switch ( $column_name ) 
			{
				case 'cb':
					$out .= '<th class="check-column">';
					if ( $default_mailinglist_id != $mailinglist->term_id )
					{
						$out .= '<input type="checkbox" name="checked[]" value="' . $mailinglist->term_id . '" />';
					}
					else
					{
						$out .= '&#160;';
					}
					$out .= '</th>';
				break;
				case 'name':
					$out .= '<td ' . $attributes . '><strong><a class="row-title" href="' . $edit_url . '" title="' . esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $name ) ) . '">' . $name . '</a></strong><br />';
					$out .= self::get_actions( $actions );
					$out .= '</td>';
	 			break;
	 			case 'desc':
	 				$out .= '<td ' . $attributes . '>' . stripslashes( $mailinglist->description ) . '</td>';
	 			break;
	 			case 'allowed':
	 				$out .= '<td ' . $attributes . '>' . ( ( $mailinglist->allowed ) ? __( 'yes', 'MailPress' ) : __( 'no', 'MailPress' ) ) . '</td>';
	 			break;
				case 'num':
					$mailinglist->count = number_format_i18n( $mailinglist->count );

					if ( current_user_can( 'MailPress_edit_users' ) )
					{
						$url	= esc_url( add_query_arg( 'mailinglist', $mailinglist->term_id, MailPress_users ) );
						$mp_users_count = ( $mailinglist->count > 0 ) ? '<a href="' . $url . '">' . $mailinglist->count . '</a>' : $mailinglist->count;
					}
					else
					{
						$mp_users_count =  $mailinglist->count;
					}

					$attributes = sprintf( 'class="num column-num%2$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '' );

					$out .= '<td ' . $attributes . '>' . $mp_users_count . '</td>';
	 			break;
			}
		}
		$out .= '</tr>';

		return $out;
	}
}