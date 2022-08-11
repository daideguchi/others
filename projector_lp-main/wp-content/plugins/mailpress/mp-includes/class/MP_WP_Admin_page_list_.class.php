<?php
abstract class MP_WP_Admin_page_list_ extends MP_WP_Admin_page_
{
	const per_page = true;

	function __construct()
	{
		parent::__construct();

		add_filter( 'set-screen-option',  					array( 'MP_AdminPage', 'set_screen_option' ), 8, 3 );

		add_filter( 'manage_' . MP_AdminPage::screen . '_columns', 	array( 'MP_AdminPage', 'get_columns' ) );
	}

//// Screen Options ////

	public static function admin_head() 
	{
		parent::admin_head();

		if ( MP_AdminPage::per_page )
		{
			global $title;
			add_screen_option( 'per_page', array( 'label' => $title, 'default' => 20 ) );
		}
	}

	public static function set_screen_option( $a, $b, $c )
	{
		return $c;
	}

	public static function get_per_page( $default = 20 )
	{
		$option = MP_AdminPage::screen . '_per_page';
		$per_page = ( int ) get_user_option( $option );
		if ( empty( $per_page ) || $per_page < 1 )
			$per_page = $default;

		return ( int ) apply_filters( $option, $per_page );
	}

//// Columns ////

	public static function get_columns() 
	{
		return false;
	}

	public static function columns_list( $id = true )
	{
		$columns = MP_AdminPage::get_columns();
		$hidden  = MP_AdminPage::get_hidden_columns();
		foreach ( $columns as $key => $display_name ) 
		{
			$tag  = ( 'cb' === $key ) ? 'td' : 'th';
			$thid = ( $id ) ? ' id="' . $key . '"' : '';

			$classes = 'manage-column column-' . $key;
			$classes .= ( 'cb' === $key ) ? ' check-column' : '';
			$classes .= ( 'title' === $key ) ? ' column-primary' : '';
			$classes .= ( in_array( $key, $hidden ) ) ? ' hidden' : '';

			$class = ' class="' . $classes . '"';

			$attributes = '';
			$attributes .= ( 'title' === $key ) ? ' scope="col"' : '';

			echo '<' . $tag . $thid . $class . $attributes . '>' . $display_name . '</' . $tag . '>';
		} 
	}

	public static function get_hidden_columns()
	{
		return get_hidden_columns( MP_AdminPage::screen );
	}

//// List ////

	public static function pagination( $args, $which = '' ) 
	{
		if ( !is_array( $args ) ) if ( is_numeric( $args ) ) $args = array( 'total_items' => $args ); else return;

		$defaults = array ( 	'per_page'	=> self::get_per_page(), 
						'current'	=> isset( self::$req_['paged'] ) ? max( 1, self::$req_['paged'] ) : 1,
					 );
		$r = wp_parse_args( $args, $defaults );
		extract( $r );

		if ( !isset( $total_items ) ) return;
		if ( !isset( $total_pages ) && $per_page > 0 ) $total_pages = ceil( $total_items / $per_page );

		$out = '<span class="displaying-num">' . sprintf( _n( '1 item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';

		$HTTP_HOST		= filter_input( INPUT_SERVER, 'HTTP_HOST' );
		$REQUEST_URI	= filter_input( INPUT_SERVER, 'REQUEST_URI' );

		$current_url = set_url_scheme( 'http://' . $HTTP_HOST	 . $REQUEST_URI );

		$current_url = remove_query_arg( wp_removable_query_args(), $current_url );

		$page_links = array();

		$total_pages_before = '<span class="paging-input">';
		$total_pages_after  = '</span></span>';

		$disable_first = $disable_last = $disable_prev = $disable_next = false;

		if ( $current == 1 ) {
			$disable_first = true;
			$disable_prev  = true;
		}
		if ( $current == 2 ) {
			$disable_first = true;
		}
		if ( $current == $total_pages ) {
			$disable_last = true;
			$disable_next = true;
		}
		if ( $current == $total_pages - 1 ) {
			$disable_last = true;
		}

		if ( $disable_first ) {
			$page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>';
		} else {
			$page_links[] = sprintf(
				'<a class="first-page button" href="%s"><span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span></a>',
				esc_url( remove_query_arg( 'paged', $current_url ) ),
				__( 'First page' ),
				'&laquo;'
			);
		}

		if ( $disable_prev ) {
			$page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>';
		} else {
			$page_links[] = sprintf(
				'<a class="prev-page button" href="%s"><span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span></a>',
				esc_url( add_query_arg( 'paged', max( 1, $current - 1 ), $current_url ) ),
				__( 'Previous page' ),
				'&lsaquo;'
			);
		}

		if ( 'bottom' === $which ) {
			$html_current_page  = $current;
			$total_pages_before = '<span class="screen-reader-text">' . __( 'Current Page' ) . '</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">';
		} else {
			$html_current_page = sprintf(
				'%s<input class="current-page" id="current-page-selector" type="text" name="paged" value="%s" size="%d" aria-describedby="table-paging" /><span class="tablenav-paging-text">',
				'<label for="current-page-selector" class="screen-reader-text">' . __( 'Current Page' ) . '</label>',
				$current,
				strlen( $total_pages )
			);
		}
		$html_total_pages = sprintf( '<span class="total-pages">%s</span>', number_format_i18n( $total_pages ) );
		$page_links[]     = $total_pages_before . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . $total_pages_after;

		if ( $disable_next ) {
			$page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&rsaquo;</span>';
		} else {
			$page_links[] = sprintf(
				'<a class="next-page button" href="%s"><span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span></a>',
				esc_url( add_query_arg( 'paged', min( $total_pages, $current + 1 ), $current_url ) ),
				__( 'Next page' ),
				'&rsaquo;'
			);
		}

		if ( $disable_last ) {
			$page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&raquo;</span>';
		} else {
			$page_links[] = sprintf(
				'<a class="last-page button" href="%s"><span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span></a>',
				esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
				__( 'Last page' ),
				'&raquo;'
			);
		}

		$pagination_links_class = 'pagination-links';
		$out .= "\n" . '<span class="$pagination_links_class">' . join( "\n", $page_links ) . '</span>';

		if ( $total_pages )
			$page_class = $total_pages < 2 ? ' one-page' : '';
		else
			$page_class = ' no-pages';

		$out = '<div class="tablenav-pages' . $page_class . '">' . $out . '</div>';

		echo $out;
	}

	public static function get_search_clause( $s, $sc = array() )
	{
		$replaces = array( "\\" => "\\\\\\\\", "_" => "\_", "%" => "\%", "'" => "\'", );

		foreach( $replaces as $k => $v ) $s = str_replace( $k, $v, $s );

		foreach( $sc as $k => $v ) $sc[$k] = "$v LIKE '%$s%'";

		return ' AND ( ' . join( ' OR ', $sc ) . ' ) '; 
	}

	public static function get_list( $args ) 
	{
		extract( $args );

		global $wpdb;

		$start = abs( ( int ) $start );
		$_per_page = ( int ) $_per_page;

		$rows = $wpdb->get_results( "$query LIMIT $start, $_per_page" );

		self::update_cache( $rows, $cache_name );

		$total = $wpdb->get_var( "SELECT FOUND_ROWS()" );

		return array( $rows, $total );
	}

	public static function get_bulk_actions( $bulk_actions = array(), $name = 'action' )
	{
		$bulk_actions = apply_filters( 'MailPress_bulk_actions_' . MP_AdminPage::screen, $bulk_actions );
		if ( count( $bulk_actions ) <= 1 ) return;

		$out = '';
		$out .= '<select name="' . $name . '">';

		foreach( $bulk_actions as $k => $v )
		{
			$out .= '<option ' . ( ( !empty( $k ) ) ? 'value="bulk-' . $k . '"' : 'selected="selected" value="-1"' ) . '>' . $v . '</option>';

		}

		$out .= '</select>' . "\r\n";
		$out .= '<input type="submit" name="do' . $name . '" id="do' . $name . '" class="button-secondary apply" value="' . esc_attr( __( 'Apply' ) ) . '" />' ; "\r\n";

		echo $out;
	}

//// Row ////

	public static function get_actions( $actions, $class = 'row-actions' )
	{
		foreach ( $actions as $k => $v ) $actions[$k] = '<span class="' . $k . '">' . $v;
		return '<div class="' . $class . '">' . join( ' | </span>', $actions ) . '</span></div>';
	}

	public static function human_time_diff( $m_time )
	{
		$time   = strtotime( get_gmt_from_date( $m_time ) );
		$time_diff = current_time( 'timestamp', true ) - $time;

		if ( $time_diff <= 0 )			return __( 'now', 'MailPress' );
		elseif ( $time_diff < 24*60*60 )	return sprintf( __( '%s ago' ), human_time_diff( $time ) );
		else						return mysql2date( __( 'Y/m/d' ), $m_time );
	}

////  ////

	public static function update_cache( $xs, $y ) 
	{
		foreach ( ( array ) $xs as $x ) wp_cache_add( $x->id, $x, $y );
	}
}