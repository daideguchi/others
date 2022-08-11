<?php
abstract class MP_
{

////	no limit ////

	public static function no_abort_limit()
	{
		if ( function_exists( 'ignore_user_abort' ) )	ignore_user_abort( 1 );
		if ( function_exists( 'set_time_limit' ) )		set_time_limit( 0 );
	}

//// image ////

	public static function is_image( $file )
	{
		return ( in_array( substr( strtolower( strrchr( strtolower( $file ), '.' ) ), 1 ), self::ext_image() ) );
	}

	public static function ext_image()
	{
		return array( 'jpg', 'jpeg', 'png', 'gif', 'tif', 'bmp' );
	}

//// url ////

	public static function url( $url, $url_parms = array(), $wpnonce = false )
	{
		$url = add_query_arg( array_map ( 'urlencode', $url_parms ), $url );
		return ( $wpnonce ) ? wp_nonce_url( $url, $wpnonce ) : $url;
	}

//// plugin/add-on ////

	public static function plugin_links( $links, $file, $basename, $tab )
	{
		if ( $basename != $file ) return $links;

		$settings_link = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', add_query_arg( 'tab', $tab, MailPress_settings ), __( 'Settings' ) );
		array_unshift ( $links, $settings_link );
		return $links;
	}

//// form ////

	public static function select_option( $list, $selected, $echo = true )
	{
		$x = '';
		foreach( $list as $value => $label )
		{
			$_selected = ( !is_array( $selected ) ) ? $selected : ( ( in_array( $value, $selected ) ) ? $value : null );
			$x .= sprintf( '<option%1$s value="%2$s">%3$s</option>', self::selected( ( string ) $value, ( string ) $_selected, false, false ), $value, $label );

		}
		if ( !$echo ) return "\n$x\n";
		echo "\n$x\n";
	}

	public static function select_number( $start, $max, $selected, $tick = 1, $echo = true )
	{
		$x = '';
		while ( $start <= $max )
		{
			if ( intval ( $start/$tick ) == $start/$tick )
			{
				$x .= sprintf( '<option%1$s value="%2$s">%3$s</option>', self::selected( ( string ) $start, ( string ) $selected, false, false ), $start, $start );
			}
			$start++;
		}
		if ( !$echo ) return "\n$x\n";
		echo "\n$x\n";
	}

	public static function selected( $selected, $current = true, $echo = true ) 
	{
		return self::__checked_selected_helper( $selected, $current, $echo, 'selected' );
	}

	public static function __checked_selected_helper( $helper, $current, $echo, $type ) 
	{
		$result = ( $helper == $current ) ? sprintf( ' %1$s="%1$s"', $type ) : '';
		if ( $echo ) echo $result;
		return $result;
	}

//// functions ////

	public static function mp_redirect( $r )
	{
		if ( defined( 'MP_DEBUG_LOG' ) && !defined( 'MP_DEBUG_LOG_STOP' ) )
		{
			global $mp_debug_log;
			if ( isset( $mp_debug_log ) )
			{
				$mp_debug_log->log( " mp_redirect : >> $r << " );
			}
			$mp_debug_log->end( true );
			define ( 'MP_DEBUG_LOG_STOP', true );
		}
		wp_redirect( $r );
		self::mp_die();
	}

	public static function mp_die( $r = true )
	{
		if ( defined( 'MP_DEBUG_LOG' ) && !defined( 'MP_DEBUG_LOG_STOP' ) )
		{
			global $mp_debug_log;
			if ( isset( $mp_debug_log ) )
			{
				$mp_debug_log->log( " mp_die : >> $r << " );
			}
			$mp_debug_log->end( true );
			define ( 'MP_DEBUG_LOG_STOP', true );
		}
		die( $r );
	}

	public static function print_scripts_l10n_val( $val0, $is_num = false, $before = "" )
	{
		if ( is_array( $val0 ) )
		{
			$eol = "\t\t";
			$text =  "{\n\t$before";
			foreach( $val0 as $var => $val )
			{
				$text .=  "$eol$var: " . self::print_scripts_l10n_val( $val, $is_num, "\t" . $before );
				$eol = ", \n$before\t\t\t";
			}
			$text .= "\n\t\t$before}";
		}
		else
		{
			$quot = ( stripos( $val0, '"' ) === false ) ? '"' : "'";
			$quot = ( $is_num && is_numeric( $val0 ) ) ? '' : $quot;
			$text = "$quot$val0$quot";
		}
		return $text;
	}

	public static function get_called_function( $function = false, $class = false )
	{
		$calls = debug_backtrace();
		array_shift( $calls );		// we know who we are !

		foreach( $calls as $i => $call )
		{
			foreach( array( 'class', 'function' ) as $word )
			{
				if ( !$$word )
				{
					if ( isset( $call[$word] ) )
					{
						unset( $calls[$i] );
						continue 2;
					}
				}
				else
				{
					if ( !isset( $call[$word] ) )
					{
						unset( $calls[$i] );
						continue 2;
					}
					elseif ( $$word != $call[$word] )
					{
						unset( $calls[$i] );
						continue 2;				
					}
				}
				if ( 'function' == $word )
				{
					array_shift( $calls );
					break 2;
				}
			}
		}
		return ( empty( $calls ) ) ? false : array_shift( $calls );
	}
}