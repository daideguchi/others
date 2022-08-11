<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen 		= MailPress_page_view_logs;
	const capability	= 'MailPress_view_logs';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/view_logs/';
	const file        	= __FILE__;

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms();
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count    .= 'd';
		$$count	= 0;

		$path 	= self::get_path();

		switch( $action )
		{
			case 'bulk-delete' :
                                foreach( $checked as $file ) { if ( @unlink( $path . '/' . $file ) ) $$count++; }
			break;
		}

		if ( $$count ) $url_parms[$count] = $$count;
		self::mp_redirect( self::url( MailPress_view_logs, $url_parms ) );
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'View logs :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'This screen provides access to all of your mp logs. You can customize the display of this screen to suit your needs.', 'MailPress' ) . '</p>';
		$content .= '<p>' . sprintf( __( 'All mp logs are currently stored in %s.', 'MailPress' ), '<code>' .  MP_UPL_PATH . 'log</code>');

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can customize the display of this screen&#8217;s contents in a number of ways:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( 'You can decide how many logs to list per screen using the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'Depending on which add on you have activated, you may find an autorefresh option in the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '</ul>';


		$current_screen->add_help_tab( array( 	'id'		=> 'screen-display',
										'title'	=> __( 'Screen Display' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'Hovering over a row in the logs list will display action links that allow you to manage your log. You can perform the following actions:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>View</strong> &mdash; display the content of the log file within WordPress administration.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Browse</strong> &mdash; display the content of the log file inside a new tab in your browser.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'action-links',
										'title'	=> __( 'Available Actions' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'You can also permanently delete multiple logs at once. Select the logs you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'bulk-actions',
										'title'	=> __( 'Bulk Actions' ),
										'content'	=> $content )
		);
	}

	// for path
	public static function get_path() 
	{
		return MP_UPL_ABSPATH . 'log';
	}

	// for url
	public static function get_url() 
	{
		return MP_UPL_URL . 'log';
	}

	// for file template
	public static function get_file_template()
	{
		return 'MP_Log_' . get_current_blog_id() . '_';
	}

////  Columns  ////

	public static function get_columns() 
	{
		$columns = array(	'cb'		=> '<input type="checkbox" />', 
						'name'	=> __( 'Name', 'MailPress' ) );
		return $columns;
	}

////  List  ////

	public static function get_list( $args )
	{
		extract( $args );

		$ftmplt	= self::get_file_template();
		$path 	= self::get_path();
		$all		= 0;

		$logs = array();
		if ( is_dir( $path ) && ( $l = opendir( $path ) ) ) 
		{
			while ( ( $file = readdir( $l ) ) !== false ) 
			{
			      	switch ( true )
				{
					case ( $file[0]  == '.' ) :
					break;
					case ( strstr( $file, $ftmplt ) ) :
						$all++;
						if ( isset( $url_parms['s'] ) && ( !strstr( $file, $url_parms['s'] ) ) ) break;
						$logs[filemtime( "$path/$file" ) . $file] = $file;
					break;
				}
			}
			closedir( $l );
		}
		krsort( $logs );

		$total = count( $logs );
		$counts = array('all'		=> $all, 
					'search'	=> 0
		);
		if ( isset( $url_parms['s'] ) ) $counts['search'] = $total;

		$rows  = array_slice ( $logs, $start, $_per_page );

		$subsubsub_urls = false;

		$libs = array(	'all'			=> __( 'All' ), 
					'search'		=> __( 'Search Results' )
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
			$url	= esc_url( add_query_arg( $args, MailPress_view_logs ) );

			$cls = '';
			if ( isset( $url_parms['s'] ) )
			{
				if ( 'search' == $k )
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

		if ( !empty( $out ) )
		{
			$subsubsub_urls = '<li>' . join( ' | </li><li>', $out ) . '</li>';
		}

		return array( $rows, $total, $subsubsub_urls );
	}

////  Row  ////

	public static function get_row( $file, $url_parms )
	{
		static $row_class = '';

		$f 		= substr( $file, strpos( $file, str_replace( ABSPATH, '', WP_CONTENT_DIR ) ) );
		$view_url 	= esc_url( MailPress_view_log . "&id=$f" );
		$browse_url = self::get_url() . '/' . $f;
		$actions['view']   = '<a href="' . $view_url   . '" title="' . esc_attr( sprintf( __(   'View &#8220;%1$s&#8221;', 'MailPress' ) , $file ) ) . '">'	. __( 'View', 'MailPress' ) . '</a>';
		$actions['browse'] = '<a href="' . $browse_url . '" title="' . esc_attr( sprintf( __( 'Browse &#8220;%1$s&#8221;', 'MailPress' ) , $file ) ) . '" target="_blank">'	. __( 'Browse', 'MailPress' ) . '</a>';

		$row_class = ( ' class="alternate"' == $row_class ) ? '' : ' class="alternate"';
		$attributes = 'class="post-title column-title"';

		$out = '';
		$out .= '<tr' . $row_class . '>';

		// cb
		$out .= '<th class="check-column"> <input type="checkbox" name="checked[]" value="' . $file . '" /></th>';

		// file
		$out .= '<td ' . $attributes . '>';
		$out .= '<span><strong>';
		$out .= '<a class="row-title" href="' . $view_url . '" title="' . esc_attr( __( 'View', 'MailPress' ) ) . '">' . $file . '</a>';
		$out .= '</strong></span>';
		$out .= self::get_actions( $actions );
		$out .= '</td>';

		$out .= "</tr>";

		return $out;
	}
}