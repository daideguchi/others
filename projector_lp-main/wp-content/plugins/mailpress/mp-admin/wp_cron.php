<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen		= MailPress_page_wp_cron;
	const capability	= 'MailPress_manage_wp_cron';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/wp_cron/';
	const file			= __FILE__;

	const add_form_id	= 'add';
	const list_id		= 'the-list';
	const tr_prefix_id	= 'wpcron';

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms( array( 'paged', 'id', 'sig', 'next_run' ) );
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count	.= 'd';
		$$count	= 0;

		switch( $action ) 
		{
			case 'bulk-delete' :
				$crons = _get_cron_array();
				foreach( $checked as $id ) 
				{
					$x = explode( '::', $id );
					if( isset( $crons[$x[2]][$x[0]][$x[1]] ) )
					{
						wp_unschedule_event( $x[2], $x[0], $crons[$x[2]][$x[0]][$x[1]]['args'] );
						$$count++;
					}
				}

				$url_parms['message'] = ( $$count <= 1 ) ? 3 : 4;
				if ( $$count )
				{
					$url_parms[$count] = $$count;
				}
				self::mp_redirect( self::url( MailPress_wp_cron, $url_parms ) );
			break;

			case 'add':
				self::$pst_['args'] = json_decode( stripslashes( self::$pst_['args'] ), true );
				if( !is_array( self::$pst_['args'] ) )
				{
					self::$pst_['args'] = array();
				}

				self::$pst_['next_run'] = strtotime( self::$pst_['next_run'] );
				if( self::$pst_['next_run'] === false || self::$pst_['next_run'] == -1 )
				{
					self::$pst_['next_run'] = time();
				}

				if( self::$pst_['schedule'] == '_oneoff' )
				{
					$e = wp_schedule_single_event( self::$pst_['next_run'], self::$pst_['name'], self::$pst_['args'] ) === NULL;
				}
				else
				{
					$e = wp_schedule_event( self::$pst_['next_run'], self::$pst_['schedule'], self::$pst_['name'], self::$pst_['args'] ) === NULL;
				}

				$url_parms['message'] = ( $e ) ? 1 : 91;
				self::mp_redirect( self::url( MailPress_wp_cron, $url_parms ) );
			break;
			case 'edited':
				unset( self::$get_['action'] );

				if ( !isset( self::$pst_['cancel'] ) ) 
				{
					$crons = _get_cron_array();
					$x = explode( '::', self::$pst_['id'] );
					if( isset( $crons[$x[2]][$x[0]][$x[1]] ) )
					{
						wp_unschedule_event( $x[2], $x[0], $crons[$x[2]][$x[0]][$x[1]]['args'] );
					}

					self::$pst_['args'] = json_decode( stripslashes( self::$pst_['args'] ), true );
					if( !is_array( self::$pst_['args'] ) )
					{
						self::$pst_['args'] = array();
					}

					self::$pst_['next_run'] = strtotime( self::$pst_['next_run'] );
					if( self::$pst_['next_run'] === false || self::$pst_['next_run'] == -1 )
					{
						self::$pst_['next_run'] = time();
					}

					if( self::$pst_['schedule'] == '_oneoff' )
					{
						$e = wp_schedule_single_event( self::$pst_['next_run'], self::$pst_['name'], self::$pst_['args'] ) === NULL;
					}
					else
					{
						$e = wp_schedule_event( self::$pst_['next_run'], self::$pst_['schedule'], self::$pst_['name'], self::$pst_['args'] ) === NULL;
					}

					$url_parms['message'] = ( $e ) ? 2 : 92 ;
				}
				unset( $url_parms['id'], $url_parms['sig'], $url_parms['next_run'] );
				self::mp_redirect( self::url( MailPress_wp_cron, $url_parms ) );
			break;
			case 'do_now':
				unset( self::$get_['action'] );
				$e = false;

				$crons = _get_cron_array();
				foreach( $crons as $time => $cron ) 
				{
					if( isset( $cron[self::$get_['id']][self::$get_['sig']] ) ) 
					{
						wp_schedule_single_event( time()-1, self::$get_['id'], $cron[self::$get_['id']][self::$get_['sig']]['args'] );
						spawn_cron();
						$e = true;
						break;
					}
				}
				$url_parms['message'] = ( $e ) ? 5 : 95 ;
				unset( $url_parms['id'], $url_parms['sig'], $url_parms['next_run'] );
				self::mp_redirect( self::url( MailPress_wp_cron, $url_parms ) );
			break;
			case 'delete':
				$crons = _get_cron_array();
				if( isset( $crons[$url_parms['next_run']][$url_parms['id']][$url_parms['sig']] ) )
				{
					wp_unschedule_event( $url_parms['next_run'], $url_parms['id'], $crons[$url_parms['next_run']][$url_parms['id']][$url_parms['sig']]['args'] );
				}

				unset( $url_parms['id'], $url_parms['sig'], $url_parms['next_run'] );

				$url_parms['message'] = 3;
				self::mp_redirect( self::url( MailPress_wp_cron, $url_parms ) );
			break;
		}
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen, $wp_version;

		$content = '';
		$content .= '<p><strong>' . __( 'Wp_cron :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'Wp_cron (or WP-Cron or WP_Cron ...) is an internal WordPress set of functions with an API to schedule some jobs inside WordPress.', 'MailPress' );
		$content .= '   ' . __( 'WordPress uses it for scheduled posts, for any potential upgrade (WP, plugins, themes, ...), etc .', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'MailPress uses it for scheduled Mails, for add-ons such as Autoresponder, Newsletter and optionally - depends on your settings - for Batch sending, Bounce handling, Delete old mails.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'MailPress Wp_cron add-on is just a basic facility to give an insight of what is going on in the background.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can customize the display of this screen&#8217;s content in a number of ways:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( 'You can hide/display columns based on your needs and decide how many Wp_cron jobs to list per screen using the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'You will find an autorefresh option in the Screen Options tab as well.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'screen-display',
										'title'	=> __( 'Screen Display' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'Hovering over a row in the Wp_cron jobs list will display action links that allow you to manage your Wp_cron job.', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Edit</strong> &mdash; takes you to the editing form for that instance of a Wp_cron job. You know what you are doing, dude !', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Do now</strong> &mdash; execute that instance of the Wp_cron job immediately.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Delete</strong> &mdash; unschedule that instance of the Wp_cron job immediately.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'action-links',
										'title'	=> __( 'Available Actions' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can also permanently unschedule multiple instances of Wp_cron jobs at once. Select the Wp_cron jobs you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'bulk-actions',
										'title'	=> __( 'Bulk Actions' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'Wp_cron is not a true scheduler.', 'MailPress' );
		$content .= '<br />' . __( 'A true scheduler is a subcomponent of modern OS (cron for Unix/Linux, Scheduled Tasks for Windows ...) and is operational 24/7 (as long as the computer is ON !).', 'MailPress' );
		$content .= '<br />' . __( 'By default, Wp_cron is only operational when your site (WordPress) is visited.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'Documentation is in different places, and mostly for developers :', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . sprintf( __( 'in %s for the wp-cron api,', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://codex.wordpress.org/Category:WP-Cron_Functions', __( 'Codex', 'MailPress' ) ) ) . '</li>';
		$content .= '<li>' . sprintf( __( 'in the source code for %1$s, %2$s ...', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://core.trac.wordpress.org/browser/tags/' . $wp_version . '/src/wp-cron.php', '<code>wp-cron.php</code>' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://core.trac.wordpress.org/browser/tags/' . $wp_version . '/src/wp-includes/cron.php#L0', '<code>wp-includes/cron.php</code>' ) ) . '</li>';
		$content .= '<li>' . sprintf( __( '<code>define(%s, \'true\');</code> in <code>wp-config.php</code> is documented out of WordPress.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', '', "'DISABLE_WP_CRON'" ) );
		$content .= '    ' . __( 'Only disables WordPress from launching Wp_cron jobs and not slowing down your visitors.', 'MailPress' );
		$content .= '<br />' . __( 'All other Wp_cron functions are still available. All you need is to hit <code>wp-cron.php</code> file on desired frequency (see posts below).', 'MailPress' ) . '</li>';
		$content .= '</ul>';
		$content .= '<p>' . __( 'Some posts about Wp_cron :', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . sprintf( '<a href="%1$s" target="_blank">%2$s</a>'  , 'https://www.lucasrolff.com/wordpress/why-wp-cron-sucks/', 'Why WP-Cron sucks' ) . __( ' &mdash; how to launch Wp_cron out of WordPress on a more regular basis and not slow down the visitor who happens to visit when the Wp_cron job is needed to run.' , 'MailPress' ) . '</li>';
		$content .= '<li>' . sprintf( '<a href="%1$s" target="_blank">%2$s</a>'  , 'https://www.100son.net/cron-wordpress-problemes-solutions/', 'Le Cron WordPress : probl&egrave;mes et solutions' ) . __( ' &mdash; (in french)' , 'MailPress' ) . '</li>';
		$content .= '<li>' . sprintf( '<a href="%1$s" target="_blank">%2$s</a>'  , 'https://ben.lobaugh.net/blog/20787/wordpress-how-to-use-wp-cron', 'WordPress: How to use WP-Cron' ) . __( ' &mdash; another post' , 'MailPress' ) . '</li>';
		$content .= '<li>' . sprintf( '<a href="%1$s" target="_blank">%2$s</a>'  , 'http://www.inmotionhosting.com/support/website/wordpress/disabling-the-wp-cronphp-in-wordpress', 'Disabling the wp-cron.php in WordPress ' ) . __( ' &mdash; a short video (in english) from a web host, but you got the idea !' , 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'about-wp-cron',
										'title'	=> __( 'About Wp_cron', 'MailPress' ),
										'content'	=> $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, 	'/' . MP_PATH . 'mp-admin/css/wp_cron.css' );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

//// Scripts ////

	public static function print_scripts( $scripts = array() ) 
	{
		$scripts = apply_filters( 'MailPress_autorefresh_js', $scripts );

		parent::print_scripts( $scripts );
	}

////  Columns  ////

	public static function get_columns() 
	{
		$columns = array(	'cb'		=> '<input type="checkbox" />', 
						'name'	=> __( 'Hook name', 'MailPress' ),
						'next'	=> __( 'Next&#160;run',  'MailPress' ),
						'rec'		=> __( 'Recurrence','MailPress' ),
						'args'	=> __( 'Arguments', 'MailPress' ),
		);
		return $columns;
	}

////  List  ////

	public static function get_list( $args )
	{
		extract( $args );

		$wp_crons = array();

		$crons = _get_cron_array();
		if ( !$crons )
		{
			$crons = array();
		}

		foreach( $crons as $time => $cron )
		{
			foreach( $cron as $hook => $dings )
			{
				foreach( $dings as $sig => $data )
				{
					$wp_crons[] = array(	'hook'	=> $hook,
									'time'	=> $time,
									'sig'		=> $sig,
									'data'	=> $data
					 );
				}
			}
		}

		$total = count( $wp_crons );
		$rows  = array_slice ( $wp_crons, $start, $_per_page );

		return array( $rows, $total );
	}

////  Row  ////

	public static function get_row( $wp_cron, $url_parms )
	{
		static $row_class = '';
// url's
		$args = array();

		$args['id'] = $wp_cron['hook'];
		$args['sig'] = $wp_cron['sig'];
		$args['next_run'] = $wp_cron['time'];

		$id = $args['id'] . '::' . $args['sig'] . '::' . $args['next_run'];

		$args['action'] = 'delete';
		$delete_url = esc_url( self::url( MailPress_wp_cron, array_merge( $args, $url_parms ), 'delete-cron_' . $args['id'] . '_' . $args['sig'] . '_' . $args['next_run'] ) );
		$args['action'] = 'do_now';
		$do_now_url = esc_url( self::url( MailPress_wp_cron, array_merge( $args, $url_parms ) ) );
		$args['action'] = 'edit';
		$edit_url = esc_url( self::url( MailPress_wp_cron, array_merge( $args, $url_parms ) ) );

// actions
		$actions = array();

		$actions['edit']   = '<a href="' . $edit_url   . '">' . __( 'Edit' ) . '</a>';
		$actions['do_now'] = '<a href="' . $do_now_url . '">' . __( 'Do now', 'MailPress' ) . '</a>';
		$actions['delete'] = '<a href="' . $delete_url . '">' . __( 'Delete' ) . '</a>';

		$row_class = ( ' class="alternate"' == $row_class ) ? '' : ' class="alternate"';
		$out  = '';
		$out .= '<tr id="wp_cron::' . $id . '" ' . $row_class . '>';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '' );

			$out .= '<td ' . $attributes . '>';

			switch ( $column_name ) 
			{
				case 'cb':
					$out .= '<input type="checkbox" name="checked[]" value="' . $id . '" />';
				break;
				case 'name':
					$out .= $wp_cron['hook'];
                    		$out .= self::get_actions( $actions );
				break;
				case 'args':
					$out .= json_encode( $wp_cron['data']['args'] );
				break;
				case 'next':
					$timestamp = $wp_cron['time'];

					$time_since = self::time_since( $timestamp );
					$next_date = wp_date( 'D Y/m/d H:i:s', $timestamp );
					$next_date = str_replace( ' ', '&#160;', $next_date );
					
					$out .= $timestamp . ' <abbr title="' . $time_since . '">' . $next_date . '</abbr>';
				break;
				case 'rec':
					$out .= ( $wp_cron['data']['schedule'] ) ? ( '<abbr title="' . esc_attr( sprintf( __( '%1$s sec.' ), $wp_cron['data']['interval'] ) ) . '">' . self::interval( $wp_cron['data']['interval'] ) . '</abbr>' ) : __( 'Non-repeating', 'MailPress' );
				break;
			}

			$out .= '</td>';
		}
		$out .= '</tr>';

		return $out;
	}

	public static function time_since( $newer_date ) 
	{
		return self::interval( $newer_date - current_time( 'timestamp', 'gmt' ) );
	}

	public static function interval( $since , $max = 2 ) 
	{
		// array of time period chunks
		$chunks = array(array( YEAR_IN_SECONDS, 	__( '%s year',   'MailPress' ), __( '%s years',   'MailPress' ) ),
				array( MONTH_IN_SECONDS,	__( '%s month',  'MailPress' ), __( '%s months',  'MailPress' ) ),
				array( WEEK_IN_SECONDS,		__( '%s week',   'MailPress' ), __( '%s weeks',   'MailPress' ) ),
				array( DAY_IN_SECONDS,		__( '%s day',    'MailPress' ), __( '%s days',    'MailPress' ) ),
				array( HOUR_IN_SECONDS,		__( '%s hour',   'MailPress' ), __( '%s hours',   'MailPress' ) ),
				array( MINUTE_IN_SECONDS,	__( '%s minute', 'MailPress' ), __( '%s minutes', 'MailPress' ) ),
				array( 1 ,			__( '%s second', 'MailPress' ), __( '%s seconds', 'MailPress' ) )
		 );

		if( $since <= 0 )
		{
			return __( 'now', 'MailPress' );
		}

		$done = $total = 0;
		$out = '';

		foreach( $chunks as $chunk )
		{
			$count = floor( ( $since - $total ) / $chunk[0] );
			if ( !$count )
			{
				continue;
			}

			$total += $count * $chunk[0];

			if ( $done )
			{
				$out .= ' ';
			}
			$out .= sprintf( _n( $chunk[1], $chunk[2], $count ), $count );
			$done++;
			if ( $done == $max ) break;
		}
		return $out;
	}

	public static function get_schedules() 
	{
		$schedules = array();
		$x = wp_get_schedules();
		uasort( $x, array( 'MP_AdminPage', 'sort_schedules' ) );
		foreach( $x as $name => $data )
		{
			$schedules[$name] = $data['display'] . ' ( ' . self::interval( $data['interval'] ) . ' )';
		}
		$schedules['_oneoff'] = __( 'Non-repeating', 'MailPress' );
		return $schedules;
	}

	public static function sort_schedules( $a, $b ) 
	{
		return $a['interval'] - $b['interval'];
	}

	public static function get( $_hook, $_sig, $_next_run ) 
	{
		$crons = _get_cron_array();
		foreach( $crons as $next_run => $cron ) 
		{
			foreach( $cron as $hook => $dings ) 
			{
				foreach( $dings as $sig => $data ) 
				{
					if( $hook == $_hook && $sig == $_sig && $next_run == $_next_run ) 
					{
						return array( 	'hookname'	=>	$hook,
									'next_run'	=>	$next_run,
									'schedule'	=>	( $data['schedule'] ) ? $data['schedule'] : '_oneoff',
									'sig'		=>	$sig,
									'args'	=>	$data['args']
						 );
	                        }
				}
			}
		}
	}
}