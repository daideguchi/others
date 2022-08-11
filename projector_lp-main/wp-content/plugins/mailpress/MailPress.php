<?php
/*
Plugin Name: MailPress
Plugin URI: http://www.mailpress.org
Description: The WordPress mailing platform.

Version: 7.2.1

Author: Andre Renaut
Author URI: http://www.mailpress.org
License: WTFPL license

Text Domain: MailPress
Domain Path: /mp-content/languages
*/

/** Absolute path to the MailPress directory. */
define ( 'MP_ABSPATH',	__DIR__ . '/' );

/** Folder name of MailPress plugin. */
define ( 'MP_FOLDER', 	basename( MP_ABSPATH ) );

/** Relative path to the MailPress directory. */
define ( 'MP_PATH', 		PLUGINDIR . '/' . MP_FOLDER . '/' );


/** for admin plugin pages */
define ( 'MailPress_page_mails',	'mailpress_mails' );
define ( 'MailPress_page_write',	'mailpress_write' );
define ( 'MailPress_page_edit',		MailPress_page_mails . '&file=write' );
define ( 'MailPress_page_revision',	MailPress_page_mails . '&file=revision' );
define ( 'MailPress_page_themes',	'mailpress_themes' );
define ( 'MailPress_page_settings',	'mailpress_settings' );
define ( 'MailPress_page_users',	'mailpress_users' );
define ( 'MailPress_page_user',		MailPress_page_users . '&file=uzer' );
define ( 'MailPress_page_addons',	'mailpress_addons' );

/** for admin plugin urls */
$mp_file = 'admin.php';
							
define ( 'MailPress_mails',		add_query_arg( 'page', MailPress_page_mails, 	$mp_file ) );
define ( 'MailPress_write',		add_query_arg( 'page', MailPress_page_write, 	$mp_file ) );
define ( 'MailPress_edit',			add_query_arg( 'page', MailPress_page_edit, 	$mp_file ) );
define ( 'MailPress_revision',		add_query_arg( 'page', MailPress_page_revision, $mp_file ) );
define ( 'MailPress_themes',		add_query_arg( 'page', MailPress_page_themes, 	$mp_file ) );
define ( 'MailPress_settings',		add_query_arg( 'page', MailPress_page_settings, 'options-general.php' ) );
define ( 'MailPress_users',		add_query_arg( 'page', MailPress_page_users, 	$mp_file ) );
define ( 'MailPress_user',			add_query_arg( 'page', MailPress_page_user, 	$mp_file ) );
define ( 'MailPress_addons',		add_query_arg( 'page', MailPress_page_addons, 	'plugins.php' ) );

/** for mysql */
global $wpdb;
$wpdb->mp_mails    = $wpdb->prefix . 'mailpress_mails';
$wpdb->mp_mailmeta = $wpdb->prefix . 'mailpress_mailmeta';
$wpdb->mp_users    = $wpdb->prefix . 'mailpress_users';
$wpdb->mp_usermeta = $wpdb->prefix . 'mailpress_usermeta';
$wpdb->mp_stats    = $wpdb->prefix . 'mailpress_stats';

class MailPress
{
	const option_name_general 			= 'MailPress_general';
	const option_name_test 				= 'MailPress_test';
	const option_name_logs 				= 'MailPress_logs';
	const option_name_subscriptions 		= 'MailPress_subscriptions';
	const option_name_smtp 				= 'MailPress_smtp_config';
	const option_name_sendmail			= 'MailPress_connection_sendmail';
//	php mail() not supported since swiftmailer 6.x

	public static $default_option_logs = array( 'level' => E_ALL, 'lognbr' => 10, 'lastpurge' => '' );

	public static $validator = null;

	function __construct() 
	{
		require_once( 'mp-load.php' );

		spl_autoload_register( array( __CLASS__, 'autoload' ) );					// for class loader

		if ( defined( 'MP_DEBUG_LOG' ) )
		{
			global $mp_debug_log; 
			$mp_debug_log = new MP_Log( 'debug_mailpress', array( 'option_name' => 'debug' ) );
			// Slow heartbeat
			add_filter( 'heartbeat_settings', array(__CLASS__, 'heartbeat_settings'));
		}

		add_action( 'plugins_loaded',			array( __CLASS__, 'plugins_loaded' ) );		// for add-ons & gettext
		add_action( 'init',				array( __CLASS__, 'init' ) );			// for init
		add_action( 'widgets_init',			array( __CLASS__, 'widgets_init' ) );		// for widget
		add_action( 'shutdown',				array( __CLASS__, 'shutdown' ), 999 );		// for shutdown
		add_action( 'mp_process_send_draft',		array( __CLASS__, 'process' ) );		// for scheduled draft

		add_action( 'wp_ajax_mp_ajax',			array( __CLASS__, 'wp_ajax_mp_ajax' ) );	// for ajax
		add_action( 'wp_ajax_mp_mlinks',		array( __CLASS__, 'mail_link' ) );
		add_action( 'wp_ajax_nopriv_mp_mlinks',		array( __CLASS__, 'mail_link' ) );

		add_action( 'wp_ajax_mp_cron',			array( __CLASS__, 'mp_cron' ) );
		add_action( 'wp_ajax_nopriv_mp_cron',		array( __CLASS__, 'mp_cron' ) );

		if ( is_admin() )
		{
			register_activation_hook( plugin_basename( __FILE__ ), array( __CLASS__, 'install' ) );	// for install

			add_action( 'admin_init',		array( __CLASS__, 'admin_init' ) );		// for admin css
			add_action( 'admin_menu',		array( __CLASS__, 'admin_menu' ) );		// for menu

			$in_plugin_update_message = 'in_plugin_update_message-' . MP_FOLDER . '/' . __FILE__;	// for plugin
			add_action($in_plugin_update_message, 	array( __CLASS__, 'in_plugin_update_message' ) );	// * update message
			add_filter( 'plugin_action_links',	array( __CLASS__, 'plugin_action_links' ), 10, 2 );	// * page links
		}

		add_shortcode( 'mailpress',			array( __CLASS__, 'shortcode' ) );		// for shortcode

		do_action( 'MailPress_init' );
	}

	public static function autoload( $class )
	{
		if ( 0 == strpos( $class, 'MP_' ) )
		{
			$file = MP_ABSPATH . "mp-includes/class/{$class}.class.php";
			if ( is_file( $file ) ) return require $file;
		}
		return false;
	}

	public static function wp_ajax_mp_ajax()
	{
		new MP_WP_Ajax();
	}

	public static function plugins_loaded() 
	{
		load_plugin_textdomain( 'MailPress', false, MP_FOLDER . '/' . MP_CONTENT_FOLDER . '/' . 'languages' );
		new MP_Addons();
	}

	public static function init()
	{
	// add customized the_content filter to avoid activation link to be visited
		add_filter( 'MailPress_the_content', 'wptexturize' );
		add_filter( 'MailPress_the_content', 'wpautop' );

	// for roles & capabilities
		$role = get_role( 'administrator' );
		foreach ( self::capabilities() as $capability => $v )
		{
			$role->add_cap( $capability );
		}
		do_action( 'MailPress_roles_and_capabilities' );

	// for admin bar menu
		add_action( 'admin_bar_menu', array( __CLASS__, 'admin_bar_menu' ), 71 );

	// for specific mailpress admin page
		if ( is_admin() && self::get_admin_page() )
		{
			self::admin_page();
		}
	}

	public static function capabilities()									// for roles & capabilities
	{
		include ( MP_ABSPATH . 'mp-admin/includes/capabilities/capabilities.php' );
		return apply_filters( 'MailPress_capabilities', $capabilities );
	}

	public static function capability_groups()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/capabilities/capability_groups.php' );
		return apply_filters( 'MailPress_capability_groups', $capability_groups );
	}

	public static function widgets_init()									// for widget
	{
		register_widget( 'MP_Widget' );
	}

	public static function shutdown()
	{
		if ( defined( 'MP_DEBUG_LOG' ) )
		{
			global $mp_debug_log; 
			$mp_debug_log->end( true );
		}
	}

	public static function process( $args )									// for scheduled draft
	{
		return MP_Mail_draft::send( $args );
	}

//// ADMIN ////

	static function heartbeat_settings( $settings )
	{
		$settings['minimalInterval'] = 600;
		return $settings;
	}

	static function is_bot( $HTTP_USER_AGENT = NULL )
	{
		$bots_useragent = array( 'googlebot', 'google', 'bingbot', 'DotBot', '/bot.html', 'msnbot', 'RU_Bot', 'ia_archiver', 'lycos', 'jeeves', 'scooter', 'fast-webcrawler', 'slurp@inktomi', 'turnitinbot', 'technorati', 'yahoo', 'findexa', 'findlinks', 'gaisbo', 'zyborg', 'surveybot', 'bloglines', 'blogsearch', 'ubsub', 'syndic8', 'userland', 'gigabot', 'become.com' );
		$HTTP_USER_AGENT = $HTTP_USER_AGENT ?? filter_input( INPUT_SERVER, 'HTTP_USER_AGENT' );
		foreach ( $bots_useragent as $bot ) if ( stristr( $HTTP_USER_AGENT, $bot ) !== false ) return true;
		return false;
	}

// for install

	public static function install() 
	{
		$min_ver_wp = '5.4';
		include ( MP_ABSPATH . 'mp-admin/includes/install/mailpress.php' );
	}

// for admin stuff

	public static function admin_init()
	{
	// for global css
		$pathcss = MP_ABSPATH . 'mp-admin/css/colors_' . get_user_option( 'admin_color' ) . '.css';
		$css_url         = '/' . MP_PATH . 'mp-admin/css/colors_' . get_user_option( 'admin_color' ) . '.css';
		$css_url_default = '/' . MP_PATH . 'mp-admin/css/colors_fresh.css';
		$css_url = ( is_file( $pathcss ) ) ? $css_url : $css_url_default;
		wp_register_style( 'mailPress_colors', 	$css_url );
		wp_enqueue_style(  'mailPress_colors' );

	// for dashboard
		global $mp_general;
		if ( isset( $mp_general['dashboard'] ) && current_user_can( 'MailPress_edit_dashboard' ) )
			add_filter( 'wp_dashboard_setup', 	array( __CLASS__, 'wp_dashboard_setup' ) );

	// for privacy policy
		new MP_WP_Privacy();
	}

	public static function wp_dashboard_setup()
	{
		new MP_WP_Dashboard_widgets();
	}

// for menus

	public static function admin_menu()
	{
		new MP_WP_Admin_Menu();
	}

	public static function admin_bar_menu( $wp_admin_bar )
	{
		new MP_WP_Admin_Bar_Menu( $wp_admin_bar );
	}

// for admin page

	public static function get_admin_page()
	{
		$admin_page = filter_input( INPUT_GET, 'page' );
		$file       = filter_input( INPUT_GET, 'file' );

		return ( !isset( $admin_page ) || strpos( $admin_page, 'mailpress' ) !== 0 ) ? false : ( $admin_page . ( ( isset( $file ) ) ? '&file=' . $file : '' ) );
	}

	public static function admin_page()
	{
		$admin_page = self::get_admin_page();

		if ( !$admin_page ) return;

		$hub = array ( 	MailPress_page_mails 		=> 'mails', 
				MailPress_page_write 		=> 'write', 
				MailPress_page_edit 		=> 'write', 
				MailPress_page_revision 	=> 'revision', 
				MailPress_page_themes		=> 'themes', 
				MailPress_page_settings 	=> 'settings', 
				MailPress_page_users 		=> 'users', 
				MailPress_page_user 		=> 'user',
				MailPress_page_addons		=> 'addons'
		 );
		$hub = apply_filters( 'MailPress_load_admin_page', $hub );
		if ( !isset( $hub[$admin_page] ) )
		{
			return;
		}

		$file = MP_ABSPATH . 'mp-admin/' . $hub[$admin_page] . '.php';
		if ( !is_file( $file ) )
		{
			return;
		}

		require_once( $file );
		if ( !class_exists( 'MP_AdminPage' ) )
		{
			return;
		}

		new MP_AdminPage();
	}

// for plugin

	public static function in_plugin_update_message()
	{
		echo '<p style="color:red;margin:3px 0 0 0;border-top:1px solid #ddd;padding-top:3px">' . sprintf( __( 'IMPORTANT: <a href="%$1s">Read this before attempting to update MailPress</a>', 'MailPress' ), 'http://blog.mailpress.org/tutorials/' ) . '</p>';
	}

	public static function plugin_action_links( $links, $file )
	{
		if ( plugin_basename( __FILE__ ) != $file )
		{
			return $links;
		}

		$addons_link = '<a href="' . MailPress_addons . '" title="' . esc_attr( __( 'Manage MailPress add-ons', 'MailPress' ) ) . '">' . __( 'Add-ons', 'MailPress' ) . '</a>';
		array_unshift ( $links, $addons_link );

		return self::plugin_links( $links, $file, plugin_basename( __FILE__ ), '0' );
	}

	public static function plugin_links( $links, $file, $basename, $tab )
	{
		if ( $basename != $file )
		{
			return $links;
		}

		$settings_link = '<a href="' . esc_url( add_query_arg( 'tab', $tab, MailPress_settings ) ) . '">' . __( 'Settings' ) . '</a>';
		array_unshift ( $links, $settings_link );

		return $links;
	}

////	Subscription form	////

	public static function shortcode( $options=false )
	{
		$options['widget_id'] = 'sc';

		ob_start();
			self::form( $options );
			$x = ob_get_contents();
		ob_end_clean();
		return $x; 
	}

	public static function form( $options = array() )
	{
		static $_widget_id = 0;
		$options['widget_id'] = ( isset( $options['widget_id'] ) ) ? $options['widget_id'] . '_' . $_widget_id : 'mf_' . $_widget_id;
		MP_Widget::widget_form( $options );
		$_widget_id++;
	}

////	Unsubscription	////

	public static function list_unsubscribe( $mp_user_id, $list_id )
	{
		switch( $list_id )
		{
			case 0 : /* unsubscribe from => unknown */

			case 1 : /* unsubscribe from => blog */
			case 4 : /* unsubscribe from => all (active + waiting ) */
			case 5 : /* unsubscribe from => waiting */

			case 2 : /* unsubscribe from => comments */
			case 3 : /* unsubscribe from => blog & comments */

				MP_User::list_unsubscribed( $mp_user_id );

			break;
		}
	}

////	THE MAIL

	public static function is_email( $email )
	{
		self::$validator = new MP_Swift_EmailValidator();
		return ( self::$validator->isValid( $email ) ) ? $email : false;
	}

	public static function mail( $args )
	{
		$x = new MP_Mail();
		return $x->send( $args );
	}

	public static function mail_link() //links in mail
	{
		include ( MP_ABSPATH . 'mp-includes/html/mail_link.php' );
	}

	public static function mp_cron() //wp_cron
	{
		define( 'DOING_CRON', true );
		$hook = filter_input( INPUT_GET, 'hook' );
		do_action( $hook );
	}
}
new MailPress();