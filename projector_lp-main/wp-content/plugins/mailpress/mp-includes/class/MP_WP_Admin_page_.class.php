<?php
abstract class MP_WP_Admin_page_ extends MP_ 
{
	public static $is_footer = false;

	public static $get_;
	public static $pst_;
	public static $req_;

	function __construct()
	{
		if ( !current_user_can( MP_AdminPage::capability ) ) 
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

		add_action( 'admin_init',      		array( 'MP_AdminPage', 'redirect' ) );
		add_action( 'admin_init',      		array( 'MP_AdminPage', 'title' ) );

		add_action( 'admin_head',      		array( 'MP_AdminPage', 'admin_head' ) );
		add_filter( 'screen_meta_screen', 	array( 'MP_AdminPage', 'screen_meta_screen' ) );
		add_filter( 'current_screen', 		array( 'MP_AdminPage', 'current_screen' ), 8, 1 );

		add_action( 'admin_print_styles', 	array( 'MP_AdminPage', 'print_styles' ) );
		add_action( 'admin_print_scripts' , 	array( 'MP_AdminPage', 'print_header_scripts' ) );
		add_action( 'admin_print_footer_scripts' , array( 'MP_AdminPage', 'print_footer_scripts' ) );

		add_action( 'wp_print_scripts', 		array( 'MP_AdminPage', 'deregister_scripts' ), 100 );
		add_action( 'wp_print_footer_scripts',	array( 'MP_AdminPage', 'deregister_scripts' ), 100 );

		self::get_request();
	}

	public static function get_request()
	{
		foreach( array( 'get_' => 	INPUT_GET, 'pst_' => INPUT_POST ) as $k => $v )
		{
			self::$$k = filter_input_array( $v );
			if ( is_null( self::$$k ) ) self::$$k = array();
		}
		self::$req_ = array_merge( self::$get_, self::$pst_ );
	}

////  Redirect  ////

	public static function redirect()
	{
		$action = false;

		foreach( array( 'action', 'action2' ) as $v )
		{
			if ( !empty( self::$req_[$v] )  && ( self::$req_[$v] != -1 ) ) $action = self::$req_[$v];
			if ( $action ) break;
		}
		return $action;
	}

////  Title  ////

	public static function title() {}

//// Screen Options ////

	public static function admin_head() 
	{
		MP_AdminPage::add_help_tab();
		MP_AdminPage::set_help_sidebar();
	}

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'For more information:' ) . '</strong></p>';
		$content .= '<p>' . sprintf( __( '<a href="%1$s" target="_blank">Support Forum</a>', 'MailPress' ), 'http://groups.google.com/group/mailpress' ) . '</p>';

		$current_screen->add_help_tab( array( 
			'id'		=> 'overview',
			'title'	=> __( 'Overview' ),
			'content'	=> $content )
		);
	}

	public static function set_help_sidebar() 
	{
		global $current_screen;

//		$badge = ( rand( 0, 1 ) ) ? 'mailpress_badge.gif' : 'logo_lmailpress_admin.png" style="width:125px;';
		$badge = 'mailpress_badge.gif';

		$current_screen->set_help_sidebar( 
			  '<div style="text-align:center;">'
			. '<p><a href="http://www.amazon.fr/gp/registry/wishlist/142J4X7XM6N6Q/ref=cm_wl_rlist_go_o?sort=priority&amp;view=null" target="_blank"><img title="' . esc_attr( __( 'Thank you :-) !', 'MailPress' ) ) . '" alt="' . esc_attr( __( 'Thank you :-) !', 'MailPress' ) ) . '" src="' . site_url() . '/' . MP_PATH . 'mp-includes/images/wishlist.png" /></a></p>'
			. '<p><a href="https://paypal.me/arenaut" target="_blank"><img title="' . esc_attr( __( 'Thank you :-) !', 'MailPress' ) ) . '" alt="' . esc_attr( __( 'Thank you :-) !', 'MailPress' ) ) . '" src="' . site_url() . '/' . MP_PATH . 'mp-includes/images/PP_M.png" /></a></p>'
			. '<p><a href="http://groups.google.com/group/mailpress" target="_blank"><img title="' . esc_attr( __( 'Support Forum', 'MailPress' ) ) . '" alt="' . esc_attr( __( 'Support Forum', 'MailPress' ) ) . '" src="' . site_url() . '/' . MP_PATH . 'mp-includes/images/' . $badge . '" /></a></p>'
			. '</div>'
		 );
	}

	public static function screen_meta_screen()
	{
		return MP_AdminPage::screen;
	}

	public static function current_screen( $current_screen )
	{
		$current_screen->id = MP_AdminPage::screen;
		$current_screen->post_type = '';
		return $current_screen;
	}

//// Styles ////

	public static function print_styles( $styles ) 
	{
		wp_register_style( 'mp_common',	'/' . MP_PATH . 'mp-admin/css/common.css' );

		$styles = ( is_array( $styles ) ) ?  $styles : array();
		$styles = apply_filters( 'MailPress_styles', $styles, MP_AdminPage::screen );
		$styles = ( is_array( $styles ) ) ?  $styles : array();

		$styles = array_merge( $styles, MP_AdminPage::print_styles_icons() );
		array_unshift( $styles, 'mp_common' );
		$styles = array_unique( $styles );

		if ( is_array( $styles ) ) foreach ( $styles as $style ) wp_enqueue_style( $style );
	}

	public static function print_styles_icons( $i = array() ) 
	{
		if ( empty( $i ) ) return $i;

		$s = array();
		foreach( $i as $css )
		{
			if ( !in_array( $css, array( 'browser', 'device', 'domain', 'ext', 'flag', 'icon', 'os', ) ) ) continue;
			wp_register_style( 'mp_' . $css . 's', '/' . MP_PATH . 'mp-admin/css/_' . $css . 's.css' );
			$s[] = 'mp_' . $css . 's';
		}
		return $s;
	}

//// Scripts ////

	public static function print_header_scripts() { MP_AdminPage::print_scripts( array() ); }
	public static function print_footer_scripts() { self::$is_footer = true; MP_AdminPage::print_scripts( array() ); }

	public static function print_scripts( $scripts = array() ) 
	{
		$scripts = apply_filters( 'MailPress_scripts', $scripts, MP_AdminPage::screen );
		if ( is_array( $scripts ) ) foreach ( $scripts as $script )	wp_enqueue_script( $script );
	}

	public static function deregister_scripts()
	{
		$advanced_path = 'advanced/' . get_current_blog_id() . '/scripts';
		$root = MP_UPL_ABSPATH . $advanced_path;
		$root = apply_filters( 'MailPress_advanced_scripts_root', $root );
		$file	= "$root/deregister.xml";

		$y = '';

		if ( is_file( $file ) )
		{
			$x = file_get_contents( $file );
			if ( $xml = simplexml_load_string( $x ) )
			{
				foreach ( $xml->script as $script )
				{
					wp_deregister_script( ( string ) $script );
					$y .= ( !empty( $y ) ) ? ", $script" : $script;
				}
			}
			echo "\n<!-- MailPress_deregister_scripts : $y -->\n";
		}
	}

////  Body  ////

	public static function body() { include( MP_ABSPATH . 'mp-admin/includes/' . basename( MP_AdminPage::file ) ); }

//// Html ////

	public static function get_url_parms( $parms = array( 'mode', 'status', 's', 'paged', 'author', 'startwith' ) )
	{
		$url_parms = array();
		foreach ( $parms as $parm ) if ( isset( self::$req_[$parm] ) )
		{
			if ( isset( self::$req_[$parm] ) )
			{
				$url_parms[$parm] = trim( stripslashes( self::$req_[$parm] ) );
				switch ( $parm )
				{
					case 'startwith' :
						if ( -1 == $url_parms[$parm] ) 	unset( $url_parms[$parm] );
					break;
					case 'paged' :
						if ( 1 >= $url_parms[$parm] ) 	unset( $url_parms[$parm] );
					case 's' :
					case 'author' :
					case 'mailinglist' :
					case 'newsletter' :
						if ( empty( $url_parms[$parm] ) ) unset( $url_parms[$parm] );
					break;
				}
			}
		}
		return $url_parms;
	}

	public static function post_url_parms( $url_parms, $parms = array( 'mode', 'status', 's', 'paged', 'author' ), $echo = true )
	{
		$out = '';

		foreach ( $parms as $key )
			if ( isset( $url_parms[$key] ) )
				$out .= '<input type="hidden" name="' . $key . '" value="' . esc_attr( $url_parms[$key] ) . '" />';

		if ( $echo ) echo $out;

		return $out;
	}

	public static function message( $s, $b = true )
	{
		if ( $b ) 	echo '<div id="message" class="updated fade"><p>' . $s . '</p></div>';
	 	else 		echo '<div id="message" class="error"><p>' 	  . $s . '</p></div>';
	}
}