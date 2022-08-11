<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_list_unsubscribe' ) )
{
/*
Plugin Name: MailPress_list_unsubscribe
Plugin URI: http://blog.mailpress.org
Description: Users : Implements List-Unsubscribe headers and other stuff to make it work (the best of <a href="https://tools.ietf.org/html/rfc2369" target="_blank">rfc2369</a> & <a href="https://tools.ietf.org/html/rfc8058" target="_blank">rfc8058</a>) 
Version: 7.2
*/

class MailPress_list_unsubscribe
{
	const meta_key     	= '_MailPress_list_unsubscribe';
	const option_name 	= 'MailPress_list_unsubscribe';
	const log_name 		= 'list_unsubscribe';

	const process_name	= 'mp_process_list_unsubscribe';

	const bt = 132;


	const key_word		= 'liun';


	const actions = array (
		'a' 	=> 'delete subscriber',
		'b' 	=> 'unsubscribe from all lists',
		'c' 	=> 'unsubscribe from sending list',
	); 

	const mailto_sc = array(
		'%' => '%25',

		' ' => '%20', '!' => '%21', '"' => '%22', '#' => '%23',	'$' => '%24', '&' => '%26', "'" => '%27', '(' => '%28', ')' => '%29', '*' => '%2A', '+' => '%2B', ',' => '%2C', '-' => '%2D', '/' => '%2F',
		':' => '%3A', ';' => '%3B', '<' => '%3C', '=' => '%3D', '>' => '%3E', '?' => '%3F',
		'@' => '%40',
		'[' => '%5B', '\\' => '%5C',']' => '%5D', '^' => '%5E', '_' => '%5F', 
		'`' => '%60',
		'{' => '%7B', '|' => '%7C', '}' => '%7D', '~' => '%7E',
	);

	function __construct()
	{
// prepare mail
		add_filter( 'MailPress_swift_message_headers',				array( __CLASS__, 'swift_message_headers' ), 10, 2 );

// for batch mode
		add_action( self::process_name,						array( __CLASS__, 'process' ) );

		$config = get_option( self::option_name );
		if ( 'wpcron' == $config['batch_mode'] )
		{	
			add_action( 'MailPress_schedule_list_unsubscribe',		array( __CLASS__, 'schedule' ) );
		}

		if ( is_admin() )
		{
		// for install
			register_activation_hook( plugin_basename( __FILE__ ),		array( __CLASS__, 'install' ) );
			register_deactivation_hook( plugin_basename( __FILE__ ),	array( __CLASS__, 'uninstall' ) );
		// for link on plugin page
			add_filter( 'plugin_action_links',				array( __CLASS__, 'plugin_action_links' ), 10, 2 );

		// for settings
			add_filter( 'MailPress_settings_tab', 				array( __CLASS__, 'settings_tab' ), 50, 1 );
		// for settings logs
			add_action( 'MailPress_settings_logs_form',			array( __CLASS__, 'settings_logs_form' ), 30, 1 );
		}

// for ajax and more
		if ( isset( $_POST['List-Unsubscribe'] ) && ( $_POST['List-Unsubscribe'] == 'One-Click' ) )
			add_action( 'init',		array( __CLASS__, 'mail_link' ), 200 );
		add_action( 'wp_ajax_mp_hlinks',	array( __CLASS__, 'mail_link' ) );
		add_action( 'wp_ajax_nopriv_mp_hlinks',	array( __CLASS__, 'mail_link' ) );
	}

// prepare mail
	public static function swift_message_headers( $message, $row )
	{
		if ( $row->template == 'new_subscriber' ) return $message;

		$config = get_option( self::option_name );

		if ( !$config ) return $message;

		$has_dkim  = ( class_exists( 'Mailpress_signer_dkim' ) );
		$has_email = MailPress::is_email( $config['pop3']['username'] );

		$list_unsubscribe = array();

		$confkey   = $row->confkey   ?? '{{_confkey}}';
		$list_id   = $row->list_id   ?? '{{_list_id}}';

		if ( $has_dkim )
		{
			$list_unsubscribe[] = array( 
					'type'  => 'url',
					'url' 	=> admin_url( 'admin-ajax.php' ),
					'args' 	=> array(
						'action' 	=> 'mp_hlinks',
						self::key_word 	=> $confkey,
						'mid' 		=> $row->id,
						'id' 		=> $list_id,
					),
			);
		}

		if ( $has_email )
		{
			$list_unsubscribe[] = array(
					'type'  => 'mailto',
					'mailto'=> $config['pop3']['username'],
					'args' 	=> array(
						'subject' 	=> self::key_word . '.' . $row->id . '.' . $confkey . '.' . $list_id,
					),
			);
		}
// headers
		if ( !empty( $list_unsubscribe ) )
		{
			$_headers = $message->getHeaders();

			$header = self::get_header( $list_unsubscribe );
			$_headers->addTextHeader( 'List-Unsubscribe', $header );

			if ( $has_dkim )
			{
				$_headers->addTextHeader( 'List-Unsubscribe-Post', 'List-Unsubscribe=One-Click' );
			}
		}

		return $message;
	}

 	public static function get_header( $list_unsubscribe )
 	{
		$header = '';

		foreach( $list_unsubscribe as $v )
		{
			if ( !empty( $header ) ) $header .= ',';

			switch( $v['type'] )
			{
				case 'url' :
					$header .= '<' . self::get_url( $v ) . '>';
				break;
				case 'mailto' :
					$header .= '<mailto:' . self::get_mailto( $v ) . '>';
				break;
			}
		}

		return $header;
 	}

 	public static function get_url( $url )
 	{
		return add_query_arg( $url['args'], $url['url'] );
 	}

	public static function get_mailto( $mailto )
	{
		$args = '';

		foreach( $mailto['args'] as $h => $v )
		{
			if ( !empty( $args ) ) $args .= '&';
			
			$args .= $h . '=' . $v;
		}
		
		return self::mailto( $mailto['mailto'] ) . '?' . $args;
	}

 	public static function mailto( $email )
	{
		$parts = explode( '@', $email );

		$domain_part = array_pop( $parts );
		$local_part  = implode( '@', $parts );

		/*** Refer to RFC 6068 STD66 ***/
		/*** https://tools.ietf.org/html/rfc6068#ref-STD66 ***/

		$local_part = str_replace( array_keys( self::mailto_sc ),  array_values( self::mailto_sc ), $local_part );

		return $local_part . '@' . $domain_part;
	}

// links in mail
	public static function mail_link()
	{
		$config = get_option( self::option_name );
		if ( !$config ) die();

		foreach( array( 'get_' => INPUT_GET, 'pst_' => INPUT_POST, 'srv_' => INPUT_SERVER ) as $k => $v )
		{
			$$k = filter_input_array( $v );
			if ( is_null( $$k ) ) $$k = array();
		}

		if ( empty( $pst_ ) ) 
		{
			$url = ( isset( $get_[self::key_word] ) ) ? MP_User::get_unsubscribe_url( $get_[self::key_word] ) : site_url();
			MP_::mp_redirect( $url );
			die();
		}

		if ( !isset( $pst_['List-Unsubscribe'] ) ) 		die();
		if ( $pst_['List-Unsubscribe'] != 'One-Click' ) 	die();

		$url_components = parse_url( $srv_['REQUEST_URI'] );
		parse_str( $url_components['query'], $args );

		$mail_id = $args['mid']          ?? false;
		$confkey = $args[self::key_word] ?? false;
		$list_id = $args['id']           ?? false;

		if ( !( $mail_id && $confkey && $list_id ) ) die();

		$mp_user_id = MP_User::get_id( $confkey );
		if ( !$mp_user_id ) die();

		$mp_user = MP_User::get( $mp_user_id );
		if ( !$mp_user ) die();

		$trace = new MP_Log( 'mp_process_list_unsubscribe_post', array( 'option_name' => 'list_unsubscribe' ) );

		$trace->log( '!' . str_repeat( '-', self::bt ) . '!' );
		$bm = sprintf( 'List-Unsubscribe-Post Report ( Processing mode : %1$s )', self::actions[$config['mode']] );
		$trace->log( '!' . str_repeat( ' ', 5 ) . $bm . str_repeat( ' ', self::bt - 5 - strlen( $bm ) ) . '!' );

		$trace->log( '!' . str_repeat( '-', self::bt ) . '!' );

		$bm = ' email      ! ' . $mp_user->email . ' ( ' . $mp_user->name . ' ) ';
		$trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );

		$bm = ' list_id    ! ' . $list_id;
		$trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );

		$bm = ' mail_id    ! ' . $mail_id;
		$trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );

		$trace->log( '!' . str_repeat( '-', self::bt ) . '!' );
		$trace->end( 1 );

		self::unsubscribe( 'post', $mp_user, $list_id, $mail_id );

		wp_send_json_success();
		die();
	}

// unsubscribing at last !

	public static function unsubscribe( $context, $mp_user, $list_id, $mail_id )
	{
		$config = get_option( self::option_name );
		if ( !$config ) die();

		do_action( 'MailPress_list_unsubscribe_user', $context, $mp_user, $list_id, $mail_id );

		switch( $config['mode'] )
		{
			case 'a' :
				MP_User::delete( $mp_user->id ) ;
			break;
			case 'b' :
				MP_User::list_unsubscribed( $mp_user->id );
			break;
			case 'c' :
				$c = explode( '.', $list_id );
				$class = $c[0];
				$list  = $c[1];
				if ( method_exists( $class, 'list_unsubscribe' ) ) $class::list_unsubscribe( $mp_user->id, $list );
			break;
		}
	}

// process
	public static function process()
	{
		MP_::no_abort_limit();

		new MP_List_Unsubscribe();
	}

// schedule
	public static function schedule()
	{
		$config = get_option( self::option_name );
		$now4cron = current_time( 'timestamp', 'gmt' );

		if ( !wp_next_scheduled( self::process_name ) ) 
			wp_schedule_single_event( $now4cron + $config['every'], self::process_name );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// install
	public static function install() 
	{
		self::uninstall();

		$options = get_option( self::option_name );
		if ( !$options )
		{
			$pop3 = get_option( 'MailPress_connection_pop3' );
			if ( $pop3 )
			{
				unset( $pop3['username'], $pop3['password'] );
				$options['pop3'] = $pop3;
				update_option( self::option_name, $options );
			}
		}

		MP_Log::set_option( self::log_name );

		do_action( 'MailPress_schedule_list_unsubscribe' );
	}

	public static function uninstall() 
	{
		wp_clear_scheduled_hook( self::process_name );
	}

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'list_unsubscribe' );
	}

// for settings
	public static function settings_tab( $tabs )
	{
		$tabs['list_unsubscribe'] = 'List-Unsubscribe';
		return $tabs;
	}

// for settings logs	
	public static function settings_logs_form( $logs )
	{
		MP_AdminPage::log_form( self::log_name, $logs, __( 'List-Unsubscribe', 'MailPress' ) );
	}
}
new MailPress_list_unsubscribe();
}