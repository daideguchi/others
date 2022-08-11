<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_autoresponder' ) )
{
/*
Plugin Name: MailPress_autoresponder
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/autoresponder/
Description: Autoresponders ( based on wp-cron )
Version: 7.2
*/

// 3.

/** for admin plugin pages */
define ( 'MailPress_page_autoresponders', 	'mailpress_autoresponders' );

/** for admin plugin urls */
$mp_file = 'admin.php';
define ( 'MailPress_autoresponders',	add_query_arg( 'page', MailPress_page_autoresponders, $mp_file ) );

class MailPress_autoresponder
{
	const taxonomy = 'MailPress_autoresponder';
	const log_name = 'autoresponder';

	const bt = 100;

	function __construct()
	{
// for taxonomy
		add_action( 'init', 			array( __CLASS__, 'init' ), 1 );

// for plugin
		add_action( 'MailPress_addons_loaded', 			array( __CLASS__, 'addons_loaded' ) );

// for autoresponder ( from older mailpress versions )
		add_action( 'mp_autoresponder_process', 			array( __CLASS__, 'process' ) );
		add_action( 'mp_process_autoresponder', 			array( __CLASS__, 'process' ) );

// for wp admin
		if ( is_admin() )
		{
		// for install
			register_activation_hook( plugin_basename( __FILE__ ), 	array( __CLASS__, 'install' ) );
		// for link on plugin page
			add_filter( 'plugin_action_links', 			array( __CLASS__, 'plugin_action_links' ), 10, 2 );
		// for role & capabilities
			add_filter( 'MailPress_capabilities', 		array( __CLASS__, 'capabilities' ), 1, 1 );
		// for settings
			add_action( 'MailPress_settings_logs_form', 		array( __CLASS__, 'settings_logs_form' ), 10 );
		// for load admin page
			add_filter( 'MailPress_load_admin_page', 		array( __CLASS__, 'load_admin_page' ), 10, 1 );
		// for mails list
			add_filter( 'MailPress_get_icon_mails', 		array( __CLASS__, 'get_icon_mails' ), 8, 2 );
		// for meta box in write page
			add_action( 'MailPress_add_help_tab_write',	array( __CLASS__, 'add_help_tab_write' ), 8 );
			add_action( 'MailPress_update_meta_boxes_write',array( __CLASS__, 'update_meta_boxes_write' ) );
			add_filter( 'MailPress_styles', 			array( __CLASS__, 'styles' ), 8, 2 );
			add_filter( 'MailPress_scripts', 			array( __CLASS__, 'scripts' ), 8, 2 );
			add_action( 'MailPress_add_meta_boxes_write',	array( __CLASS__, 'add_meta_boxes_write' ), 8, 2 );
		}

// for ajax
		add_action( 'mp_action_add_atrspndr', 			array( __CLASS__, 'mp_action_add_atrspndr' ) );
		add_action( 'mp_action_delete_atrspndr', 			array( __CLASS__, 'mp_action_delete_atrspndr' ) );
		add_action( 'mp_action_add_wa', 				array( __CLASS__, 'mp_action_add_wa' ) );
		add_action( 'mp_action_delete_wa', 				array( __CLASS__, 'mp_action_delete_wa' ) );
	}

//// Taxonomy ////

	public static function init() 
	{
		register_taxonomy( self::taxonomy, 'MailPress_autoresponder', array( 'update_count_callback' => array( __CLASS__, 'update_count_callback' ) ) );
	}

	public static function update_count_callback( $autoresponders )
	{
		return 0;
	}

//// Plugin ////

	public static function addons_loaded()
	{
		new MP_Autoresponder_events();
	}

////  Autoresponder  ////

	public static function process( $args )
	{
		MP_::no_abort_limit();

		extract( $args );		// $umeta_id, $mail_order
		$meta_id = $umeta_id ?? $meta_id;

		$meta = MP_User_meta::get_by_id( $meta_id );
		$term_id 	= ( !$meta ) ? false : str_replace( '_MailPress_autoresponder_', '', $meta->meta_key );
		if ( !$term_id ) return;
		
		$autoresponder = MP_Autoresponder::get( $term_id );

		do_action( "mp_process_autoresponder_{$autoresponder->description['event']}", $args );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// install
	public static function install() 
	{
		MP_Log::set_option( self::log_name );
	}

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'logs' );
	}

// for role & capabilities
	public static function capabilities( $capabilities )
	{
		$capabilities['MailPress_manage_autoresponders'] = array( 	'name'	=> __( 'Autoresponders', 'MailPress' ),
												'group'	=> 'mails',
												'menu'	=> 15,

												'parent'	=> false,
												'page_title'=> __( 'MailPress Autoresponders', 'MailPress' ),
												'menu_title'=> '&#160;' . __( 'Autoresponders', 'MailPress' ),
												'page'	=> MailPress_page_autoresponders,
												'func'	=> array( 'MP_AdminPage', 'body' )
									 );
		return $capabilities;
	}

// for settings
	public static function settings_logs_form( $logs )
	{
		MP_AdminPage::log_form( self::log_name, $logs, __( 'Autoresponder', 'MailPress' ) );
	}

// for load admin page
	public static function load_admin_page( $hub )
	{
		$hub[MailPress_page_autoresponders] = 'autoresponders';
		return $hub;
	}

// for ajax
	public static function mp_action_add_atrspndr() 
	{
		if ( !current_user_can( 'MailPress_manage_autoresponders' ) ) die( '-1' );

		if ( '' === trim( MP_WP_Ajax::$pst_['name'] ) ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'autoresponder', 
									'id' => new WP_Error( 'autoresponder_name', __( 'You did not enter a valid autoresponder name.', 'MailPress' ) )
								   ) );
			$x->send();
		}

		if ( MP_Autoresponder::exists( trim( MP_WP_Ajax::$pst_['name'] ) ) ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'autoresponder', 
									'id' => new WP_Error( __CLASS__ . '::exists', __( 'The autoresponder you are trying to create already exists.', 'MailPress' ), array( 'form-field' => 'name' ) ), 
								  ) );
			$x->send();
		}
	
		$autoresponder = MP_Autoresponder::insert( MP_WP_Ajax::$pst_, true );

		if ( is_wp_error( $autoresponder ) ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'autoresponder', 
									'id' => $autoresponder
								  ) );
			$x->send();
		}

		if ( !$autoresponder || ( !$autoresponder = MP_Autoresponder::get( $autoresponder ) ) ) 	MP_::mp_die( '0' );

		$autoresponder_full_name 	= $autoresponder->name;

		include ( MP_ABSPATH . 'mp-admin/autoresponders.php' );
		$x = new WP_Ajax_Response( array( 	'what' => 'autoresponder', 
								'id' => $autoresponder->term_id, 
								'data' => MP_AdminPage::get_row( $autoresponder, array() ), 
								'supplemental' => array( 'name' => $autoresponder_full_name, 'show-link' => sprintf( __( 'Autoresponder <a href="#%s">%s</a> added' , 'MailPress' ), "autoresponder-$autoresponder->term_id", $autoresponder_full_name ) )
							  ) );
		$x->send();
	}

	public static function mp_action_delete_atrspndr() 
	{
		$id = ( int ) MP_WP_Ajax::$pst_['id'] ?? 0;
		MP_::mp_die( MP_Autoresponder::delete( $id ) ? '1' : '0' );
	}

// for mails list
	public static function get_icon_mails( $out, $mail_id )
	{
		if ( MP_Autoresponder::object_have_relations( $mail_id ) ) $out .= '<span class="mp_icon mp_icon_autoresponder" title="' . __( 'Autoresponder', 'MailPress' ) . '"></span>';
		return $out;
	}
		
// for meta box in write page
	public static function add_help_tab_write()
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Autoresponders :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'When scheduling an autoresponder, do as follow:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . sprintf( __( 'Create a new %s and use the appropriate box, link it to the MailPress autoresponder by specifying the delay between the triggered event and the mail release. For a set of mails, you will need to create as many as mails required, linked to the same autoresponder with different delays.', 'MailPress' ), sprintf( '<a href="' . MailPress_write . '" target="_blank">%s</a>', __( 'Mail', 'MailPress' ) ) ) . '</li>';
		$content .= '<li>' . __( 'When saving the mail, a recipient mail is required but will be replaced on time by the right recipient&#8217;s mail.', 'MailPress' ) . '</li>';
		$content .= '<li>' . sprintf( __( 'Autoresponder draft mail can be quickly identified in %1$s with a little clock icon : %2$s', 'MailPress' ), sprintf( '<a href="' . MailPress_mails . '" target="_blank">%s</a>', __( 'Mails list', 'MailPress' ) ) , '<span class="mp_icon mp_icon_autoresponder" title="' . __('Autoresponder', 'MailPress' ) . '"></span>' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'autoresponders',
										'title'	=> __( 'Autoresponders', 'MailPress' ),
										'content'	=> $content )
		);
	}

	public static function meta_box_write_parms()
	{
		$x['table_body_id'] = 'wa-list';				// the-list
		$x['ajax_response'] = 'wa-response'; 			// ajar-response
		$x['table_list_id'] = 'wa-list-table';			// list-table

		$x['tr_prefix_id']  = 'wa';

		return $x;
	}

	public static function update_meta_boxes_write()
	{
	}

	public static function styles( $styles, $screen ) 
	{
		if ( $screen != MailPress_page_write ) return $styles;

		wp_register_style( MailPress_page_autoresponders, '/' . MP_PATH . 'mp-admin/css/write_autoresponders.css' );

		$styles[] = MailPress_page_autoresponders;

		return $styles;
	}

	public static function scripts( $scripts, $screen ) 
	{
		if ( $screen != MailPress_page_write ) return $scripts;

		wp_register_script( MailPress_page_autoresponders, '/' . MP_PATH . 'mp-admin/js/write_autoresponders.js', array( 'mp-lists' ), false, 1 );
		wp_localize_script( MailPress_page_autoresponders, 	'adminautorespondersL10n',	array_merge( 	array( 'pending' => __( '%i% pending' ), 'screen' => MP_AdminPage::screen ),
																			self::meta_box_write_parms(),
																			array( 'l10n_print_after' => 'try{convertEntities( adminautorespondersL10n );}catch( e ){};' )
																 )
		 );
		$scripts[] = MailPress_page_autoresponders;

		return $scripts;
	}

	public static function add_meta_boxes_write( $mail_id, $mp_screen )
	{
		if ( !current_user_can( 'MailPress_manage_autoresponders' ) )	return;
		add_meta_box( 'write_autoresponder', __( 'Autoresponders', 'MailPress' ), array( __CLASS__, 'meta_box' ), MP_AdminPage::screen, 'normal', 'core' );
	}
/**/
	public static function meta_box( $mail )
	{
		$parms = self::meta_box_write_parms();

        	$id = $mail->id ?? 0;
		$metadata = MP_Autoresponder::get_object_terms( $id );
		$count = 0;

		$out = '';
		$out .= '<div id="mailautoresponderstuff">' . "\r\n";
		$out .= '<div id="' . $parms['ajax_response'] . '"></div>' . "\r\n";

		if ( !$metadata )
		{
			$metadata = array(); 

			$out .= '<table id="' . $parms['table_list_id'] . '" class="hidden">' . "\r\n";
			$out .= '<thead><tr><th class="left">' . __( 'Autoresponder', 'MailPress' ) . '</th><th>' . __( 'Schedule', 'MailPress' ) . '</th></tr></thead>' . "\r\n";
			$out .= '<tbody id="' . $parms['table_body_id'] . '" class="list:' . $parms['tr_prefix_id'] . '"><tr><td></td><td></td></tr></tbody>' . "\r\n";
			$out .= '</table>' . "\r\n";
		}
		else
		{
			$out .= '<table id="' . $parms['table_list_id'] . '">' . "\r\n";
			$out .= '<thead><tr><th class="left">' . __( 'Autoresponder', 'MailPress' ) . '</th><th>' . __( 'Schedule', 'MailPress' ) . '</th></tr></thead>' . "\r\n";
			$out .= '<tbody id="' . $parms['table_body_id'] . '" class="list:' . $parms['tr_prefix_id'] . '">' . "\r\n";
			foreach ( $metadata as $entry ) $out .= self::meta_box_autoresponder_row( $entry, $count ) . "\r\n";
			$out .= '</tbody>' . "\r\n";
			$out .= '</table>' . "\r\n";
		}

		$autoresponders = MP_Autoresponder::get_all();
		foreach( $autoresponders as $autoresponder )
		{
			$_autoresponders[$autoresponder->term_id] = $autoresponder->name;
		}

		if ( empty( $_autoresponders ) )
		{
			$out .= '<p><strong>' . __( 'No autoresponder', 'MailPress' ) . '</strong></p>' . "\r\n";
		}
		else
		{
			$periods = array( 'Y' => __( 'Year', 'MailPress' ), 'M' => __( 'Month', 'MailPress' ), 'W' => __( 'Week', 'MailPress' ), 'D' => __( 'Day', 'MailPress' ), 'H' => __( 'Hour', 'MailPress' ) );

			$out .= '<p><strong>' . __( 'Link to :', 'MailPress' ) . '</strong></p>' . "\r\n";

			$out .= '<table id="add_' . $parms['tr_prefix_id'] . '">' . "\r\n";
			$out .= '<thead>'
					. '<tr><th class="left"><label for="autoresponderselect">' . __( 'Autoresponder', 'MailPress' ) . '</label></th>'
					. '<th><label for="metavalue">' . __( 'Schedule', 'MailPress' ) . '</label></th>'
					. '</tr>'
					. '</thead>' . "\r\n";
			$out .= '<tbody>' . "\r\n";
			$out .= '<tr>' . "\r\n";
			$out .= '<td id="newarleft" class="left">' . "\r\n";
			$out .= '<select name="autoresponderselect" id="autoresponderselect" tabindex="7">' . MP_AdminPage::select_option( $_autoresponders, false, false ) . '</select>' . "\r\n";
			$out .= '</td>';
			$out .= '<td style="vertical-align:top;">' . "\r\n";

			$out .= '<table style="border:none;margin:8px 0 8px 8px;width:95%;">' . "\r\n";
			$out .= '<tbody>' . "\r\n";
			$out .= '<tr>' . "\r\n";
			foreach( $periods as $k => $v )
			{
				$out .= '<td class="arschedule">' . $v . '<br /><select name="autoresponder[schedule][' . $k . ']" >' . MP_AdminPage::select_number( 0, 99, 0, 1, false ) . '</select></td>' . "\r\n";
			}
			$out .= '</tr>' . "\r\n";
			$out .= '</tbody>' . "\r\n";
			$out .= '</table>' . "\r\n";

			$out .= '</td>' . "\r\n";
			$out .= '</tr>' . "\r\n";
			$out .= '<tr>' . "\r\n";
			$out .= '<td>' . "\r\n";
			$out .= '<div class="submit" style="border: 0 none;float: none;padding: 0 8px 8px;">' . "\r\n";
			$out .= '<input type="submit" name="addwrite_autoresponder" id="addmetasub2" class="add:' . $parms['table_body_id'] . ':add_' . $parms['tr_prefix_id'] . ' button" tabindex="9" value="' . __( 'Add', 'MailPress' ) . '" />' . "\r\n";
			$out .= '</div>' . "\r\n";
			$out .= '</td>' . "\r\n";
			$out .= '<td>' . "\r\n";
			$out .= '<p class="description">' . __( 'Not more than one year between two scheduled mails.', 'MailPress' ) . '</p>' . "\r\n";
			$out .= wp_nonce_field( 'add-write-autoresponder', '_ajax_nonce', false, false ) . "\r\n";
			$out .= '</td>' . "\r\n";
			$out .= '</tr>' . "\r\n";
			$out .= '</tbody>' . "\r\n";
			$out .= '</table>' . "\r\n";
		}
		$out .= '</div>' . "\r\n";

		echo $out;
	}
	// for ajax
	public static function meta_box_autoresponder_row( $entry, &$count ) 
	{
		$parms = self::meta_box_write_parms();

		static $update_nonce = false;
		if ( !$update_nonce ) $update_nonce = wp_create_nonce( 'add-write-autoresponder' );

		$r = '';
		++ $count;

		if ( $count % 2 )	$style = 'alternate';
		else				$style = '';

		$entry['meta_id'] 	= ( int ) $entry['meta_id'];

		$delete_nonce 		= wp_create_nonce( 'delete-write-autoresponder_' . $entry['meta_id'] );

		$autoresponders = MP_Autoresponder::get_all();
		foreach( $autoresponders as $autoresponder )
		{
			$_autoresponders[$autoresponder->term_id] = $autoresponder->name;
		}

		$periods = array( 'Y' => __( 'Year', 'MailPress' ), 'M' => __( 'Month', 'MailPress' ), 'W' => __( 'Week', 'MailPress' ), 'D' => __( 'Day', 'MailPress' ), 'H' => __( 'Hour', 'MailPress' ) );

		$out = '';
		$out .= '<tr id="' . $parms['tr_prefix_id'] . '-' . $entry['meta_id'] . '" class="' . $style . '">';
		$out .= '<td class="left">';
		$out .= '<select name="write_autoresponder[' . $entry['meta_id'] . '][key]" id="write_autoresponder_' . $entry['meta_id'] . '_key" tabindex="7">';
		$out .= MP_::select_option( $_autoresponders, $entry['term_id'] ?? false, false );
		$out .= '</select>';
		$out .= '<div class="submit">';
		$out .= '<input type="submit" name="delete_wa-' . $entry['meta_id'] . '" value="' . esc_attr( __( 'Delete' ) ) . '" class="delete:' . $parms['table_body_id'] . ':' . $parms['tr_prefix_id'] . '-' . $entry['meta_id'] . '::_ajax_nonce=' . $delete_nonce . ' delete_wa button" tabindex="6" />';
		$out .= '<input type="submit" name="update_wa-' . $entry['meta_id'] . '" value="' . esc_attr( __( 'Update' ) ) . '" class="add:'    . $parms['table_body_id'] . ':' . $parms['tr_prefix_id'] . '-' . $entry['meta_id'] . '::_ajax_nonce=' . $update_nonce . ' update_wa button" tabindex="6" />';
		$out .= wp_nonce_field( 'change-write_autoresponder', '_ajax_nonce', false, false );
		$out .= '</div>';
		$out .= '</td>';
		$out .= '<td style="vertical-align:top;">';
		$out .= '<table style="border:none;margin:8px 0 8px 8px;width:95%;">';
		$out .= '<tbody>';
		$out .= '<tr>';
		foreach( $periods as $k => $v )
		{
			$out .= '<td class="arschedule">';
			$out .= $v . '<br />';
			$out .= '<select name="write_autoresponder[' . $entry['meta_id'] . '][value][' . $k . ']">';
			$out .= MP_::select_number( 0, 99, $entry['schedule'][$k] ?? false, 1, false );
			$out .= '</select>';
			$out .= '</td>';
		}
		$out .= '</tr>';
		$out .= '</tbody>';
		$out .= '</table>';
		$out .= '</td>';
		$out .= '</tr>';
		$out .= "\n";

		return $out;
	}

// for ajax	

	public static function mp_action_add_wa()
	{
		if ( !current_user_can( 'MailPress_manage_autoresponders' ) )	die( '-1' );

		$c = 0;
		$object_id = ( int ) MP_WP_Ajax::$pst_['mail_id'];
		if ( $object_id === 0 ) MP_::mp_die();

		if ( isset( MP_WP_Ajax::$pst_['autoresponderselect'] ) || isset( MP_WP_Ajax::$pst_['autoresponder']['schedule'] ) ) 
		{
			if ( !$meta_id = self::add_meta( $object_id ) ) MP_::mp_die();

			$response = array( 'position' 	=> 1 );
		}
		else
		{
			$_ak = array_keys( MP_WP_Ajax::$pst_['write_autoresponder'] );
			$meta_id   = ( int ) array_pop( $_ak );
			$key   = '_MailPress_autoresponder_' . MP_WP_Ajax::$pst_['write_autoresponder'][$meta_id]['key'];
			$value = MP_WP_Ajax::$pst_['write_autoresponder'][$meta_id]['value'];

			if ( !$meta = MP_Mail_meta::get_by_id( $meta_id ) )		MP_::mp_die();
			if ( !MP_Mail_meta::update_by_id( $meta_id , $key, $value ) )	MP_::mp_die( 1 );

			$response = array( 'old_id' 	=> $meta_id, 'position' 	=> 0 );
		}

		$meta = MP_Mail_meta::get_by_id( $meta_id );
		$object_id = ( int ) $meta->mp_mail_id;
		$meta = get_object_vars( $meta );

		$response = array_merge( $response, array( 'what' => 'write-autoresponder', 'id' => $meta_id, 'data' => self::meta_box_autoresponder_row( MP_Autoresponder::get_term_meta_id( $meta_id ), $c ), 'supplemental' => array( 'mail_id' => $object_id ) ) );

		$x = new WP_Ajax_Response( $response );

		$x->send();

	}

	public static function add_meta( $mail_id )
	{
		$post_ = filter_input_array( INPUT_POST );

		$mail_id = ( int ) $mail_id;
		if ( isset( $post_['autoresponder']['schedule'] ) ) foreach ( $post_['autoresponder']['schedule'] as $k => $v ) if ( $v <10 ) $post_['autoresponder']['schedule'][$k] = '0' . $v;

		$meta_key 	= isset( $post_['autoresponderselect'] ) ? '_MailPress_autoresponder_' . trim( $post_['autoresponderselect'] ) : '';
		$meta_value= $post_['autoresponder']['schedule'] ?? array();

		if ( empty( $meta_value ) || empty ( $meta_key ) ) return false;

		return MP_Mail_meta::add( $mail_id, $meta_key, $meta_value );
	}

	public static function mp_action_delete_wa()
	{
		if ( !current_user_can( 'MailPress_manage_autoresponders' ) )	MP_::mp_die( '-1' );

		$id = ( int ) MP_WP_Ajax::$pst_['id'] ?? 0;

		if ( !$meta = MP_Mail_meta::get_by_id( $id ) ) 				MP_::mp_die( '1' );
		if ( MP_Mail_meta::delete_by_id( $meta->meta_id ) )			MP_::mp_die( '1' );
		MP_::mp_die( '0' );
	}
}
new MailPress_autoresponder();
}