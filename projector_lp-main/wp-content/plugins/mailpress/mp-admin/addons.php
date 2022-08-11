<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen	= MailPress_page_addons;
	const capability= 'MailPress_manage_addons';
	const help_url	= 'http://blog.mailpress.org/tutorials/add-ons/';
	const file		= __FILE__;

	const per_page 	= false;

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms( array( 'status', 's' ) );
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count	.= 'd';
		$$count	= 0;

		$addons = get_option( MP_Addons::option_name );

		if ( !is_array( $addons ) )
		{
			$addons = array();
		}

		switch( $action )
		{
			case 'bulk-activate' :
				foreach( $checked as $addon )
				{
					if ( isset( $addons[$addon] ) )
					{
						continue;
					}
					if ( MP_Addons::load( $addon ) )
					{
						$addons[$addon] = $addon;
						do_action( "activate_{$addon}" );
						$$count++;
					}
				}
			break;
			case 'bulk-deactivate' :
				foreach( $checked as $addon )
				{
					if ( !isset( $addons[$addon] ) )
					{
						continue;
					}
					unset( $addons[$addon] );
					do_action( "deactivate_{$addon}" );
					$$count++;
				}
			break;
			case 'activate' :
				$addon = self::$get_['addon'];
				if ( isset( $addons[$addon] ) )
				{
					break;
				}
				if ( MP_Addons::load( $addon ) )
				{
					$addons[$addon] = $addon;
					do_action( "activate_{$addon}" );
					$$count++;
				}
			break;
			case 'deactivate' :
				$addon = self::$get_['addon'];
				if ( !isset( $addons[$addon] ) )
				{
					break;
				}
				unset( $addons[$addon] );
				do_action( "deactivate_{$addon}" );
				$$count++;
			break;
		}
		ksort( $addons );

		update_option( MP_Addons::option_name, $addons );

		if ( $$count )
		{
			$url_parms[$count] = $$count;
		}

		self::mp_redirect( self::url( MailPress_addons, $url_parms ) );
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'MailPress Add-ons :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'MailPress Add-ons extend and expand the functionality of MailPress. You can activate it or deactivate it here.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'Conflicts between add-ons may appear, so READ CAREFULLY each description before activation.', 'MailPress' ) . '</p>';
		$content .= '<p>' . sprintf( __( 'All Add-ons are currently stored in %s.', 'MailPress' ), '<code>' . MP_FOLDER . '/' . MP_CONTENT_FOLDER . '/add-ons</code>');
		$content .= '</p>';
		$content .= '<p><i>' . __( 'For Developers : ', 'MailPress') . '</i>';
		$content .= sprintf( __( ' Read this %s for more explanations', 'MailPress' ), sprintf( '<a href="../' . MP_PATH_CONTENT . 'add-ons/readme.txt" target="_blank">%s</a>', 'readme.txt' ) );
		$content .= '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);
	}

//// Columns ////

	public static function get_columns() 
	{
		$columns = array(	'cb' 		=> '<input type="checkbox" />', 
						'title'	=> __( 'Add-on', 'MailPress' ), 
						'desc'	=> __( 'Description' )
		);
		$columns = apply_filters( 'MailPress_addons_columns', $columns );
		return $columns;
	}

//// List ////

	public static function get_list( $args ) 
	{
		extract( $args );

		$addons = MP_Addons::get_all();

		$counts = array('all'		=> count( $addons ), 
					'active'	=> 0, 
					'inactive'	=> 0,
					'search'	=> 0
		);

		foreach( $addons as $k => $v )
		{
			( $v['active'] ) ? $counts['active']++ : $counts['inactive']++;

			if ( isset( $url_parms['s'] ) )
			{
				if ( stripos( $k, $url_parms['s'] ) !== false )
				{
					continue;
				}
				foreach( $v as $kk => $vv )
				{
					if ( stripos( $vv, $url_parms['s'] ) !== false ) continue 2;
				}
				unset( $addons[$k] );
			}
			if ( isset( $url_parms['status'] ) )
			{
				if ( ( $url_parms['status'] == 'inactive' ) && $v['active'] )
				{
					unset( $addons[$k] );
				}
				elseif ( ( $url_parms['status'] == 'active' ) && !$v['active'] )
				{
					unset( $addons[$k] );
				}
			}
		}
		if ( isset( $url_parms['s'] ) )
		{
			$counts['search'] = count( $addons );
		}

		$libs = array(	'all'		=> __( 'All' ), 
					'active'	=>	__( 'Active' ), 
					'inactive'	=> __( 'Inactive' ),
					'search'	=> __( 'Search Results' )
		);

		$out = array();

		foreach( $libs as $k => $lib )
		{
			if ( !isset( $counts[$k] ) || !$counts[$k] )
			{
				continue;
			}

			$args = array();
			if ( ( 'search' == $k ) && ( isset( $url_parms['s'] ) ) )	$args['s'] = $url_parms['s'];
			elseif ( 'all' != $k ) 							$args['status'] = $k;
			$url	= esc_url( add_query_arg( $args, MailPress_addons ) );

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

			$out[] = sprintf( '<a%1$s href="%2$s">%3$s <span class="count">( %5$s )</span></a>', $cls, $url, $lib, $k, $counts[$k] );
		}

		return array( $addons, '<li>' . join( ' | </li><li>', $out ) . '</li>' );
	}

////  Row  ////

	public static function get_row( $addon, $url_parms, $xtra = false ) 
	{
		$context = $url_parms['status'] ?? false;
		$actions = array();
// url's
		$args = array();
		$args['addon'] 	= $addon['file'];

// actions
		$actions = array();
		if ( $addon['active'] )
		{
			$row_class			= 'active';
			$args['action']		= 'deactivate';
			$deactivate_url		= esc_url( self::url( MailPress_addons, array_merge( $args, $url_parms ) ) );
			$actions['deactivate']= '<a href="' . $deactivate_url . '">' . __( 'Deactivate' ) . '</a>';
			$actions = apply_filters( 'plugin_action_links', $actions, $addon['file'], '', '' );
		}
		else
		{
			$row_class			= 'inactive';
			$args['action']		= 'activate';
			$activate_url		= esc_url( self::url( MailPress_addons, array_merge( $args, $url_parms ) ) );
			$actions['activate']	= '<a href="' . $activate_url . '">' . __( 'Activate' ) . '</a>';
		}

		$out = '';
		$out .= '<tr id="' . substr( basename( $addon['file'] ), 0, -4 ) . '" class="' . $row_class . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '' );

			switch ( $column_name ) 
			{
				case 'cb':
					$out .= '<th class="check-column"> <input type="checkbox" name="checked[]" value="' . $addon['file'] . '" /></th>';
				break;
				case 'title':
					$haystack = $addon['Name'];
					$needle   = 'MailPress_';
					if ( strpos( $haystack, $needle ) === 0 ) 
					{
						$haystack = substr( $haystack, strlen( $needle ) );
						$haystack = ucfirst( $haystack );
					}

					$out .= '<td ' . $attributes . '>';
					$out .= '<strong>' . $haystack . '</strong>';
					$out .= self::get_actions( $actions, 'row-actions-visible' );
					$out .= '</td>';
				break;
				case 'desc':
					$haystack = $addon['Description'];
					$needle   = 'This is just an add-on for MailPress to ';
					if ( strpos( $haystack, $needle ) === 0 ) 
					{
						$haystack = substr( $haystack, strlen( $needle ) );
						$haystack = ucfirst( $haystack );
					}

					$addon_meta = array();
					if ( !empty( $addon['Version'] ) )
					{
						$addon_meta[] = sprintf( __( 'Version %s' ), $addon['Version'] );
					}
					if ( !empty( $addon['Author'] ) ) 
					{
						$author = $addon['Author'];
						if ( !empty( $addon['AuthorURI'] ) )
						{
							$author = '<a href="' . $addon['AuthorURI'] . '">' . $addon['Author'] . '</a>';
						}
						$addon_meta[] = sprintf( __( 'By %s' ), $author );
					}
					if ( ! empty( $addon['PluginURI'] ) )
					{
						$addon_meta[] = '<a href="' . $addon['PluginURI'] . '">' . __( 'Visit add-on page', 'MailPress' ) . '</a>';
					}

					$out .= '<td ' . $attributes . '>';
					$out .= '<p>' . $haystack . '</p>';
					$out .= implode( ' | ', $addon_meta );
					$out .= '</td>';
				break;
			}
		}
		$out .= '</tr>';

		return $out;
	}
}