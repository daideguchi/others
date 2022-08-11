<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_mailinglist' ) )
{
/*
Plugin Name: MailPress_mailinglist
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/mailinglist/
Description: Mailing lists
Version: 7.2
*/

// 3.

/** for admin plugin pages */
define ( 'MailPress_page_mailinglists', 	'mailpress_mailinglists' );

/** for admin plugin urls */
$mp_file = 'admin.php';
define ( 'MailPress_mailinglists', add_query_arg( 'page', MailPress_page_mailinglists, 	$mp_file ) );

class MailPress_mailinglist
{
	const taxonomy = 'MailPress_mailing_list';

	const option_name_default = 'MailPress_default_mailinglist';

	function __construct()
	{
// for taxonomy
		add_action( 'init', 			array( __CLASS__, 'init' ), 1 );

// for wordpress hooks
// register form
		add_action( 'user_register', 			array( __CLASS__, 'user_register' ), 20, 1 );
		add_action( 'MailPress_register_form', 	array( __CLASS__, 'register_form' ), 20 ); 

// for shortcode
		add_filter( 'MailPress_form_defaults', 	array( __CLASS__, 'form_defaults' ), 8, 1 );
		add_filter( 'MailPress_form_options', 	array( __CLASS__, 'form_options' ), 8, 1 );
		add_filter( 'MailPress_form_submit', 	array( __CLASS__, 'form_submit' ), 8, 2 );
		add_action( 'MailPress_form', 		  	array( __CLASS__, 'form' ), 1, 2 ); 

// for sending mails
		add_filter( 'MailPress_mailinglists_optgroup', 	array( __CLASS__, 'mailinglists_optgroup' ), 8, 2 );
		add_filter( 'MailPress_mailinglists', 			array( __CLASS__, 'mailinglists' ), 8, 1 );
		add_filter( 'MailPress_query_mailinglist', 		array( __CLASS__, 'query_mailinglist' ), 8, 2 );
		add_filter( 'MailPress_query_list_id', 			array( __CLASS__, 'query_list_id' ), 8, 2 );

// for mp_user

		add_action( 'MailPress_activate_user_1st',	array( __CLASS__, 'set_user_mailinglists' ), 1, 1 );
		add_action( 'MailPress_delete_user', 	array( __CLASS__, 'delete_user' ), 1, 1 );

// for autoresponder
		add_action( 'MailPress_load_Autoresponder_events',	array( __CLASS__, 'load_Autoresponder_events' ) );

// for sync wordpress user
		add_filter( 'MailPress_has_subscriptions', array( __CLASS__, 'has_subscriptions' ), 8, 2 );
		add_action( 'MailPress_sync_subscriptions',array( __CLASS__, 'sync_subscriptions' ), 8, 2 );     

// for wp admin
		if ( is_admin() )
		{
		// install
			register_activation_hook(  plugin_basename( __FILE__ ), array( __CLASS__, 'install' ) );
		// for link on plugin page
			add_filter( 'plugin_action_links', 			array( __CLASS__, 'plugin_action_links' ), 10, 2 );
		// for role & capabilities
			add_filter( 'MailPress_capabilities', 		array( __CLASS__, 'capabilities' ), 1, 1 );
		// for load admin page
			add_filter( 'MailPress_load_admin_page', 		array( __CLASS__, 'load_admin_page' ), 10, 1 );
		// for settings
			add_filter( 'MailPress_settings_tab', 		array( __CLASS__, 'settings_tab' ), 10, 1 );
		// for settings subscriptions
			add_filter( 'MailPress_settings_subscriptions_help',		array( __CLASS__, 'settings_subscriptions_help' ), 30, 1 );
			add_action( 'MailPress_settings_subscriptions_form',		array( __CLASS__, 'settings_subscriptions_form'), 30 );
		// for meta box in user page
			if ( current_user_can( 'MailPress_manage_mailinglists' ) )
			{
				add_action( 'MailPress_add_help_tab_user',		array( __CLASS__, 'add_help_tab_user' ), 30 );
				add_action( 'MailPress_update_meta_boxes_user', array( __CLASS__, 'update_meta_boxes_user' ) );
				add_filter( 'MailPress_styles', 			array( __CLASS__, 'styles' ), 8, 2 );
				add_filter( 'MailPress_scripts', 			array( __CLASS__, 'scripts' ), 8, 2 );
				add_action( 'MailPress_add_meta_boxes_user', 	array( __CLASS__, 'add_meta_boxes_user' ), 30, 2 );
			}
		}

// for mp_users list
		add_action( 'MailPress_users_restrict', 	array( __CLASS__, 'users_restrict' ), 10, 1 );
		add_filter( 'MailPress_users_columns', 	array( __CLASS__, 'users_columns' ), 20, 1 );
		add_action( 'MailPress_users_get_list', 	array( __CLASS__, 'users_get_list' ), 10, 2 );
		add_filter( 'MailPress_users_get_row', 	array( __CLASS__, 'users_get_row' ), 20, 4 );

// for form page ( visitor subscription options )
		add_action( 'MailPress_form_visitor_subscription', 	array( __CLASS__, 'form_visitor_subscription' ), 8, 1 );
		add_action( 'MailPress_visitor_subscription', 		array( __CLASS__, 'visitor_subscription' ), 8, 3 );

// for tracking ( add mailinglist )
		add_action( 'MailPress_do_bulk_action_' . MailPress_page_users, array( __CLASS__, 'create_tracking_mailinglist' ), 8, 1 );

// for ajax
		add_action( 'mp_action_add_mlnglst', 	array( __CLASS__, 'mp_action_add_mlnglst' ) );
		add_action( 'mp_action_delete_mlnglst', 	array( __CLASS__, 'mp_action_delete_mlnglst' ) );
		add_action( 'mp_action_add_mailinglist', 	array( __CLASS__, 'mp_action_add_mailinglist' ) );
	}

	public static function init() 
	{
		register_taxonomy( self::taxonomy, 'MailPress_user', array( 'hierarchical' => true , 'update_count_callback' => array( __CLASS__, 'update_count_callback' ) ) );
	}

//// Subscriptions ////

	public static function get_checklist( $mp_user_id = false, $args = '' ) 
	{
		global $mp_subscriptions;
		if ( !isset( $mp_subscriptions['display_mailinglists'] ) ) return false;
		if ( empty( $mp_subscriptions['display_mailinglists'] ) ) return false;

		$checklist = '';
		$defaults = array ( 	'htmlname' 	=> 'keep_mailinglists', 
						'selected' 	=> false, 
						'type'		=> 'checkbox', 
						'show_option_all' => false,
						'htmlstart'	=> '', 
						'htmlmiddle'	=> '&#160;&#160;', 
						'htmlend'		=> "<br />\n"
					 );
		$r = wp_parse_args( $args, $defaults );
		extract( $r );

		if ( $mp_user_id )
		{
			$mp_user_mls = MP_Mailinglist::get_object_terms( $mp_user_id );
		}

		$default_mailing_list = get_option( self::option_name_default );

		$mls = array();
		$mailinglists = apply_filters( 'MailPress_mailinglists', array() );
		foreach ( $mailinglists as $k => $v ) 
		{
			$x = str_replace( __CLASS__ . '~', '', $k, $count );
			if ( 0 == $count ) 	continue;	
			if ( empty( $x ) ) 	continue;

			$mls[$x] = $v;
		}

		foreach ( $mls as $k => $v )
		{
			switch ( $type )
			{
				case 'checkbox' :
					$checked = checked( $mp_user_id && in_array( $k, $mp_user_mls ), true, false );
					$_type   = ( isset( $mp_subscriptions['display_mailinglists'][$k] ) ) ? 'checkbox' : '';

					if ( empty( $_type ) && empty( $checked ) ) break;
					if ( empty( $_type ) )
					{
						$_type   = 'hidden';
						$checked = ' value="on"';
					}

					$tag 		 = '<input type="' . $_type . '" name="' . $htmlname . '[' . $k . ']" id="' . $htmlname . '_' . $k . '"' . $checked . ' />';
					$htmlstart2  = ( 'checkbox' == $_type ) ? str_replace( '{{id}}', "{$htmlname}_{$k}", $htmlstart ) : '';
					$htmlmiddle2 = ( 'checkbox' == $_type ) ? $htmlmiddle . str_replace( '&#160;', '', $v ) : "<!-- " . str_replace( '&#160;', '', $v ) . "-->";
					$htmlend2    = ( 'checkbox' == $_type ) ? $htmlend    : "\n";

					$checklist .= "$htmlstart2$tag$htmlmiddle2$htmlend2";
				break;
				case 'select' :
					if ( !isset( $mp_subscriptions['display_mailinglists'][$k] ) ) break;

					if ( $show_option_all )
					{
						$checklist .= '<option value="">' . $show_option_all . '</option>';
						$show_option_all = false;
					}
					$sel = ( $k == $selected ) ? ' selected="selected"' : '';
					$checklist .= '<option value="' . $k . '"' . $sel . '>' . str_replace( '&#160;', '', $v ) . '</option>';
				break;
			}
		}
		if ( 'select' == $type ) $checklist = $htmlstart . '<select name="' . $htmlname . '">' . $checklist . '</select>' . $htmlend;

		return $checklist;
	}

	public static function update_checklist( $mp_user_id, $name = 'keep_mailinglists' ) 
	{
		global $mp_subscriptions;
		if ( !isset( $mp_subscriptions['display_mailinglists'] ) ) return true;
		if ( empty( $mp_subscriptions['display_mailinglists'] ) )  return true;

		$mp_user_mls = array();

		$post_ = filter_input_array( INPUT_POST );

		if ( isset( $post_[$name] ) )
		{
			foreach ( $post_[$name] as $mailinglist_ID => $v )
			{
				array_push( $mp_user_mls, $mailinglist_ID );
			}
		}
		MP_Mailinglist::set_object_terms( $mp_user_id, $mp_user_mls );
	}

	public static function get_subscriptions( $id ) 
	{
		$mp_user_mls = MP_Mailinglist::get_object_terms( $id );

		if ( empty( $mp_user_mls ) ) return false;

		$mls = array();
		$mailinglists = apply_filters( 'MailPress_mailinglists', array() );

		foreach ( $mailinglists as $k => $v ) 
		{
			$x = str_replace( __CLASS__ . '~', '', $k, $count );
			if ( 0 == $count ) 	continue;	
			if ( empty( $x ) ) 	continue;

			$mls[$x] = str_replace( '&#160;', '', $v );
		}

		foreach ( $mls as $k => $v )
		{
			if ( !in_array( $k, $mp_user_mls ) ) unset( $mls[$k] );
		}

		if ( empty( $mls ) ) return false;

		return $mls;
	}

	public static function list_unsubscribe( $mp_user_id, $mailinglist_id )
	{
		$in = MP_Mailinglist::get_object_terms( $mp_user_id );

		if ( !is_array( $in ) ) return;
		if ( empty( $in ) )     return;

		foreach( $in as $k => $v )
		{
			if ( $v != $mailinglist_id ) continue;
			unset( $in[$k] );
			break;
		}

		MP_Mailinglist::set_object_terms( $mp_user_id, $in );
	}

//// Plugin ////

// for taxonomy
	public static function update_count_callback( $mailinglists )
	{
		global $wpdb;

		foreach ( $mailinglists as $mailinglist ) 
		{
			$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( * ) FROM $wpdb->term_taxonomy a, $wpdb->term_relationships b, $wpdb->mp_users c WHERE a.taxonomy = '" . self::taxonomy . "' AND  a.term_taxonomy_id = b.term_taxonomy_id AND a.term_taxonomy_id = %d AND c.id = b.object_id ", $mailinglist ) );
			$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $mailinglist ) );
		}
	}

//// Register form ////

	public static function user_register( $wp_user_id )
	{
		$user 	= get_userdata( $wp_user_id );
		$email 	= $user->user_email;
		$mp_user_id	= MP_User::get_id_by_email( $email );

		self::update_checklist( $mp_user_id );
	}

	public static function register_form()
	{
		$checklist_mailinglists = self::get_checklist();
		if ( empty( $checklist_mailinglists ) ) return;

		echo '<br /><p><label>' . __( 'Mailing lists', 'MailPress' ) . '<br /><span style="color:#777;font-weight:normal;">' . $checklist_mailinglists . '</span></label></p>' . "\r\n";
	}

//// Shortcode ////

	public static function form_defaults( $x ) { $x['mailinglist'] = false; return $x; }

	public static function form_options( $x )  { return $x; }

	public static function form_submit( $shortcode_message, $email ) 
	{
		$post_ = filter_input_array( INPUT_POST );

		if ( !isset( $post_['mailinglist'] ) ) 	return $shortcode_message;
		if ( !$post_['mailinglist'] ) 			return $shortcode_message;
		$shortcode = 'shortcode_mailinglists';

		$mp_user_id = MP_User::get_id_by_email( $email );
		$post_[$shortcode] = MP_Mailinglist::get_object_terms( $mp_user_id );

		$post_[$shortcode] = array_flip( array_map( trim, explode( ',', $post_['mailinglist'] ) ) );

		self::update_checklist( $mp_user_id, $shortcode );

		return $shortcode_message . __( '<br />Mailing lists added', 'MailPress' );
	}

	public static function form( $email, $options )  
	{
		if ( !$options['mailinglist'] ) return;

		$x = array();
		foreach ( array_map( "trim", explode( ',', $options['mailinglist'] ) ) as $k => $v ) if ( MP_Mailinglist::get_name( $v ) ) $x[] = $v;
		if ( empty( $x ) ) return;

		echo '<input type="hidden" name="mailinglist" value="' . join( ', ', $x ) . '" />';
	}

//// Sending Mails ////

	public static function mailinglists_optgroup( $label, $optgroup ) 
	{
		if ( __CLASS__ == $optgroup ) return __( 'Mailinglists', 'MailPress' );
		return $label;
	}

	public static function mailinglists( $draft_dest = array() ) 
	{
		$args = array( 'hide_empty' => 0, 'hierarchical' => true, 'show_count' => 0, 'orderby' => 'name', 'htmlname' => 'default_mailinglist' );
		foreach ( MP_Mailinglist::array_tree( $args ) as $k => $v ) $draft_dest[$k] = $v;
		return $draft_dest;
	}

	public static function query_mailinglist( $query, $draft_toemail ) 
	{
		if ( $query ) return $query;

		$id = str_replace( __CLASS__ . '~', '', $draft_toemail, $count );
		if ( 0 == $count ) return $query;
		if ( empty( $id ) )  return $query;

		$children = MP_Mailinglist::get_children( $id, ', ', '' );
		$ids = ( '' == $children ) ? ' = ' . $id : ' IN ( ' . $id . $children . ' ) ';

		if ( empty( $ids ) ) return $query;

		global $wpdb;
		return $wpdb->prepare( "SELECT DISTINCT c.id, c.email, c.name, c.status, c.confkey FROM $wpdb->term_taxonomy a, $wpdb->term_relationships b, $wpdb->mp_users c WHERE a.taxonomy = %s AND a.term_taxonomy_id = b.term_taxonomy_id AND a.term_id $ids AND c.id = b.object_id AND c.status = 'active' ", self::taxonomy );
	}

	public static function query_list_id( $list_id, $draft_toemail ) 
	{
		if ( $list_id ) return $list_id;

		$id = str_replace( __CLASS__ . '~', '', $draft_toemail, $count );
		if ( 0 == $count ) return $list_id;
		if ( empty( $id ) )  return $list_id;

		return __CLASS__ . '.' . $id;
	}

//// mp_user ////

	public static function set_user_mailinglists( $mp_user_id, $user_mailinglists = array() )
	{
		if ( empty( $user_mailinglists ) ) $user_mailinglists = MP_Mailinglist::get_object_terms( $mp_user_id );
		MP_Mailinglist::set_object_terms( $mp_user_id, $user_mailinglists );
	}

	public static function delete_user( $mp_user_id )
	{
		MP_Mailinglist::delete_object( $mp_user_id );

	}

//// Autoresponders ////

	public static function load_Autoresponder_events()
	{
		new MP_Autoresponder_events_mailinglist();
	}

// Sync wordpress user
	public static function has_subscriptions( $has, $mp_user_id )
	{
		$x = MP_Mailinglist::get_object_terms( $mp_user_id );

		if ( empty( $x ) ) return $has;
		return true;
	}

	public static function sync_subscriptions( $oldid, $newid )
	{
		$old = MP_Mailinglist::get_object_terms( $oldid );
		if ( empty( $old ) ) return;
		$new = MP_Mailinglist::get_object_terms( $newid );

		MP_Mailinglist::set_object_terms( $newid, array_merge( $old, $new ) );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// for install
	public static function install()
	{
		global $wpdb;
		if ( !get_option( self::option_name_default ) )
		{
	// Default mailing list
			$name = esc_sql( __( 'Uncategorized', 'MailPress' ) );
			$slug = sanitize_title( sanitize_term_field( 'slug', __( 'Uncategorized', 'MailPress' ), 0, self::taxonomy, 'db' ) );
			$wpdb->query( "INSERT INTO $wpdb->terms ( name, slug, term_group ) VALUES ( '$name', '$slug', '0' )" );
			$term_id = $wpdb->get_var( "SELECT term_id FROM $wpdb->terms WHERE slug = '$slug' " );
			$wpdb->query( "INSERT INTO $wpdb->term_taxonomy ( term_id, taxonomy, description, parent, count ) VALUES ( $term_id, '" . self::taxonomy . "', '', '0', '0' )" );
			add_option( self::option_name_default, $term_id );
		}

	// Synchronize
		$default_mailinglist	= get_option( self::option_name_default );
		$unmatches = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT a.id FROM $wpdb->mp_users a WHERE NOT EXISTS ( SELECT DISTINCT b.id FROM $wpdb->term_taxonomy c, $wpdb->term_relationships d, $wpdb->mp_users b WHERE c.taxonomy = %s AND c.term_taxonomy_id = d.term_taxonomy_id AND b.id = d.object_id AND b.id = a.id )", self::taxonomy ) );
		if ( $unmatches ) foreach ( $unmatches as $unmatch )
		{
			MP_Mailinglist::set_object_terms( $unmatch->id, array( $default_mailinglist ) );
		}
	}

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'subscriptions' );
	}

// for role & capabilities
	public static function capabilities( $capabilities ) 
	{
		$capabilities['MailPress_manage_mailinglists'] = array( 	'name'  => __( 'Mailing lists', 'MailPress' ), 
												'group' => 'users', 
												'menu'  => 60, 

												'parent'		=> false, 
												'page_title'	=> __( 'MailPress Mailing lists', 'MailPress' ), 
												'menu_title'   	=> '&#160;' . __( 'Mailing lists', 'MailPress' ), 
												'page'  		=> MailPress_page_mailinglists, 
												'func'  		=> array( 'MP_AdminPage', 'body' )
										 );
		return $capabilities;
	}

// for load admin page
	public static function load_admin_page( $hub )
	{
		$hub[MailPress_page_mailinglists] = 'mailinglists';
		return $hub;
	}
// for settings
	public static function settings_tab( $tabs )
	{
		$tabs['subscriptions'] = __( 'Subscriptions', 'MailPress' );
		return $tabs;
	}

// for settings subscriptions
	public static function settings_subscriptions_help( $content )
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/subscriptions/mailinglist/help.php' );
		return $content;
	}

	public static function settings_subscriptions_form()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/subscriptions/mailinglist/form.php' );
	}

// for meta box in user page
	public static function add_help_tab_user()
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Mailing lists :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'You can create, modify mailing lists subscriptions for a mp user.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'mailinglists',
										'title'	=> __( 'Mailing lists', 'MailPress' ),
										'content'	=> $content )
		);
	}

	public static function update_meta_boxes_user() 
	{
		if ( !isset( MP_AdminPage::$pst_['id'] ) ) return;
		if ( !isset( MP_AdminPage::$pst_['mp_user_mailinglist'] ) ) MP_AdminPage::$pst_['mp_user_mailinglist'] = array();

		MP_Mailinglist::set_object_terms( MP_AdminPage::$pst_['id'], MP_AdminPage::$pst_['mp_user_mailinglist'] );
	}

	public static function styles( $styles, $screen ) 
	{
		if ( 'mailpress_user' != $screen ) return $styles;

		wp_register_style( 'mp-user-mailinglists', '/' . MP_PATH . 'mp-admin/css/user_mailinglists.css' );

		$styles[] = 'mp-user-mailinglists';

		return $styles;
	}

	public static function scripts( $scripts, $screen ) 
	{
		if ( 'mailpress_user' != $screen ) return $scripts;

		wp_register_script( 'mp-user-mailinglists', '/' . MP_PATH . 'mp-admin/js/user_mailinglists.js', array( 'mp-lists' ), false, 1 );

		$scripts[] = 'mp-user-mailinglists';

		return $scripts;
	}

	public static function add_meta_boxes_user( $mp_user_id, $screen )
	{
		add_meta_box( 'mailinglistdiv', __( 'Mailing lists', 'MailPress' ), array( __CLASS__, 'meta_box' ), $screen, 'normal', 'core' );
	}

	public static function meta_box( $mp_user )
	{
		$mailinglists = get_terms( self::taxonomy, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );
		$most_used_ids = array();

		$out = '';
		$out .= '<ul id="mailinglist-tabs">' . "\r\n";
		$out .= '<li class="tabs"><a href="#mailinglists-all" tabindex="3">' . __( 'All Mailing lists', 'MailPress' ) . '</a>	</li>' . "\r\n";
		$out .= '<li class="hide-if-no-js"><a href="#mailinglists-pop" tabindex="3">' . __( 'Most Used' , 'MailPress' ) . '</a></li>'  . "\r\n";
		$out .= '</ul>' . "\r\n";

		$out .= '<div id="mailinglists-pop" class="tabs-panel hidden">' . "\r\n";
		$out .= '<ul id="mailinglistchecklist-pop" class="mailinglistchecklist form-no-clear" >' . "\r\n";
		foreach ( ( array ) $mailinglists as $mailinglist ) 
		{
			$most_used_ids[] = $mailinglist->term_id;
			$id = "popular-mailinglist-$mailinglist->term_id";
			
			$out .= '<li id="' . $id . '" class="popular-mailinglist">'
					. '<label class="selectit" for="in-' . $id . '">'
					. '<input type="checkbox" id="in-' . $id . '" value="' . ( ( int ) $mailinglist->term_id ) . '" />'
					. esc_html( $mailinglist->name ) 
					. '</label></li>' . "\r\n";
		}
		$out .= '</ul>' . "\r\n";
		$out .= '</div>' . "\r\n";

		$out .= '<div id="mailinglists-all" class="tabs-panel">' . "\r\n";
		$out .= '<ul id="mailinglistchecklist" class="list:mailinglist mailinglistchecklist form-no-clear">' . "\r\n";
		$out .= self::all_mailinglists_checkboxes( $mp_user->id, false, false, $most_used_ids ) . "\r\n";
		$out .= '</ul>' . "\r\n";
		$out .= '</div>' . "\r\n";

		$out .= '<div id="mailinglist-adder" class="wp-hidden-children">' . "\r\n";
		$out .= '<h4>'
				. '<a id="mailinglist-add-toggle" href="#mailinglist-add" class="hide-if-no-js" tabindex="3">'
				. __( '+ Add New mailing list' , 'MailPress' )
				. '</a>'
				. '</h4>' . "\r\n";
		$out .= '<p id="mailinglist-add" class="wp-hidden-child">' . "\r\n";
		$out .= '<label class="screen-reader-text">' . __( 'Add New mailinglist' ) . '</label>' . "\r\n";
		$out .= '<input type="text" name="newmailinglist" id="newmailinglist" class="form-required form-input-tip" value="' . esc_attr( __( 'New mailing list', 'MailPress' ) ) . '" tabindex="3" aria-required="true"/>' . "\r\n";
		$out .= '<label class="screen-reader-text">' . __( 'Parent Mailing list', 'MailPress' ) . ' : </label>' . "\r\n";
		$out .= MP_Mailinglist::dropdown( array( 'hide_empty' => 0, 'htmlname' => 'newmailinglist_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => __( 'Parent Mailing list', 'MailPress' ), 'tab_index' => 3, 'echo' => false ) ) . "\r\n";
		$out .= '<input type="button" id="mailinglist-add-submit" class="add:mailinglistchecklist:mailinglist-add button" value="' . esc_attr( __( 'Add', 'MailPress' ) ) . '" tabindex="3" />' . "\r\n";
		$out .= wp_nonce_field( 'add-mailinglist', '_ajax_nonce', false, false ) . "\r\n";
		$out .= '<span id="mailinglist-ajax-response"></span>' . "\r\n";
		$out .= '</p>' . "\r\n";
		$out .= '</div>' . "\r\n";

		echo $out;
	}

	public static function most_used_checkboxes( $taxonomy, $mp_user_id, $default = 0, $number = 10, $echo = true ) 
	{
		$mailinglists = get_terms( $taxonomy, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => $number, 'hierarchical' => false ) );
		$most_used_ids = array();

		$out = '';
		foreach ( ( array ) $mailinglists as $mailinglist ) 
		{
			$most_used_ids[] = $mailinglist->term_id;
			if ( !$echo ) // hack for AJAX use
				continue;
			$id = "popular-mailinglist-$mailinglist->term_id";

			$out .= '<li id="' . $id . '" class="popular-mailinglist">'
					. '<label class="selectit" for="in-' . $id . '">'
					. '<input type="checkbox" id="in-' . $id . '" value="' . ( ( int ) $mailinglist->term_id ) . '" />'
					. esc_html( $mailinglist->name )
					. '</label>'
					. '</li>' . "\r\n";
		}
		echo $out;

		return $most_used_ids;
	}

	public static function all_mailinglists_checkboxes( $mp_user_id = 0, $descendants_and_self = 0, $selected_mailinglists = false, $popular_mailinglists = false ) 
	{
		$walker = new MP_Mailinglists_Walker_Checklist;

		$descendants_and_self = ( int ) $descendants_and_self;
		$args = array();

		if ( is_array( $selected_mailinglists ) )
			$args['selected_mailinglists'] = $selected_mailinglists;
		elseif ( $mp_user_id )
			$args['selected_mailinglists'] = MP_Mailinglist::get_object_terms( $mp_user_id );
		else
			$args['selected_mailinglists'] = array();

		if ( is_array( $popular_mailinglists ) )
			$args['popular_mailinglists'] = $popular_mailinglists;
		else
			$args['popular_mailinglists'] = MP_Mailinglist::get_all( array( 'fields' => 'ids', 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );

		if ( $descendants_and_self ) 
		{
			$mailinglists = MP_Mailinglist::get_all( array( 'child_of' => $descendants_and_self, 'hierarchical' => 0, 'hide_empty' => 0 ) );
			$self = MP_Mailinglist::get( $descendants_and_self );
			array_unshift( $mailinglists, $self );
		}
		else
		{
			$mailinglists = MP_Mailinglist::get_all( array( 'get' => 'all' ) );
		}

		$all_mailinglists_ids = array();
		$keys = array_keys( $mailinglists );

		foreach( $keys as $k )
		{
			if ( in_array( $mailinglists[$k]->term_id, $args['selected_mailinglists'] ) )
			{
				$all_mailinglists_ids[] = $mailinglists[$k];
				unset( $mailinglists[$k] );
			}
		}

		$args['input_name'] = 'mp_user_mailinglist[]';

		$out = '';
	// Put checked mailinglists on top
		$out .= call_user_func_array( array( &$walker, 'walk' ), array( $all_mailinglists_ids, 0, $args ) );
	// Then the rest of them
		$out .= call_user_func_array( array( &$walker, 'walk' ), array( $mailinglists, 0, $args ) );

		return $out;
	}

// for mp_users list
	public static function users_restrict( $url_parms )
	{
		$x = ( isset( $url_parms['mailinglist'] ) ) ? $url_parms['mailinglist'] : '';
		$dropdown_options = array( 'show_option_all' => __( 'View all mailing lists', 'MailPress' ), 'hide_empty' => 0, 'hierarchical' => true, 'show_count' => 0, 'orderby' => 'name', 'selected' => $x );
		MP_Mailinglist::dropdown( $dropdown_options );
	}

	public static function users_columns( $x )
	{
		$date = array_pop( $x );
		$x['mailinglists']=  __( 'Mailing lists', 'MailPress' );
		$x['date']		= $date;
		return $x;
	}

	public static function users_get_list( $array, $url_parms )
	{
		if ( !isset( $url_parms['mailinglist'] ) || empty( $url_parms['mailinglist'] ) ) return $array;

		global $wpdb;

		list( $where, $tables ) = $array;

		$mailinglists = MP_Mailinglist::get_children( $url_parms['mailinglist'], ', ', '' );
		$in = ( '' == $mailinglists ) ? ' = ' . $url_parms['mailinglist'] : ' IN ( ' . $url_parms['mailinglist'] . $mailinglists . ' ) ';

		$where .= " AND (      b.taxonomy = '" . self::taxonomy . "' 
					 AND b.term_taxonomy_id = c.term_taxonomy_id 
					 AND b.term_id " . $in . "  
					 AND a.id = c.object_id )";

		$tables .= ", $wpdb->term_taxonomy b, $wpdb->term_relationships c";

		return array( $where, $tables, true );
	}

	public static function users_get_row( $out, $column_name, $mp_user, $url_parms )
	{
		if ( 'mailinglists' == $column_name )
		{
			$args = array( 'orderby' => 'name', 'order' => 'ASC', 'fields' => 'all' );
			$mp_user_mls = MP_Mailinglist::get_object_terms( $mp_user->id, $args );

			if ( !empty( $mp_user_mls ) ) 
			{
				$o = array();
				foreach ( $mp_user_mls as $m )
				{
					$o[] = '<a href="' . add_query_arg('mailinglist', $m->term_id, MailPress_users ) . '">' . esc_html( sanitize_term_field( 'name', $m->name, $m->term_id, self::taxonomy, 'display' ) ) . '</a>';
				}
				$out .= join( ', ', $o );
			}
			else
			{
				$out .= __( '(none)', 'MailPress' );
			}
		}
		return $out;
	}

// for form page ( visitor subscription options )
	public static function form_visitor_subscription( $form )
	{
		$selected = get_option( self::option_name_default );
		if ( isset( $form->settings['visitor']['mailinglist'] ) )
			if ( MP_Mailinglist::get( $form->settings['visitor']['mailinglist'] ) ) $selected = $form->settings['visitor']['mailinglist'];

				echo '<label for="visitor_mailinglist"><small>' . __( 'Mailing list', 'MailPress' ) . '</small></label>' . "\r\n";

		$dropdown_options = array( 'hide_empty' => 0, 'hierarchical' => true, 'show_count' => 0, 'orderby' => 'name', 'selected' => $selected, 'htmlname' => 'settings[visitor][mailinglist]', 'htmlid' => 'visitor_mailinglist' );
		MP_Mailinglist::dropdown( $dropdown_options );
	}

	public static function visitor_subscription( $action, $email, $form )
	{
		$mailinglist_ID = $form->settings['visitor']['mailinglist'];

		if ( !MP_Mailinglist::get( $mailinglist_ID ) ) return;

		if ( !$mp_user_id = MP_User::get_id_by_email( $email ) ) return;

		$user_mailinglists = MP_Mailinglist::get_object_terms( $mp_user_id );
		if ( in_array( $mailinglist_ID, $user_mailinglists ) ) return;

		switch ( $action )
		{
			case 'init' :
				MP_Mailinglist::set_object_terms( $mp_user_id, array( $mailinglist_ID ) );
			break;
			case 'add' :
				array_push( $user_mailinglists, $mailinglist_ID );
				MP_Mailinglist::set_object_terms( $mp_user_id, $user_mailinglists );
			break;
		}
	}

// for tracking ( add mailinglist )
	public static function create_tracking_mailinglist( $action )
	{
		if ( !current_user_can( 'MailPress_manage_mailinglists' ) ) MP_::mp_die( '-1' );
		if ( 'create_tracking_mailinglist' != $action ) 	return false;
		if ( !isset( MP_AdminPage::$get_['mail_id'], MP_AdminPage::$get_['track'] ) )	return false;

		$mail_id = MP_AdminPage::$get_['mail_id'];
		$track   = MP_AdminPage::$get_['track'];
                
		// create mailinglist name
		$ml_date = date( 'Ymd' );

		global $wpdb;
		$ml_subject = $wpdb->get_var( $wpdb->prepare( "SELECT subject FROM $wpdb->mp_mails WHERE id = %s LIMIT 1;", $mail_id ) );
		$ml_subject = substr( $ml_subject, 0 , 10 );

		$ml_track = $track;
		foreach ( array( 'http://', 'https://' ) as $http ) $ml_track = str_replace( $http, '', $ml_track );
		$ml_track = substr( str_replace( MailPress_tracking_openedmail, __( 'MailOpened', 'MailPress' ), $ml_track ) , 0 , 10 );

		$ml_name = "{$ml_date} {$ml_subject} {$ml_track}";

		// create mailinglist
		$ml_id = MP_Mailinglist::get_id( $ml_name );
		if ( $ml_id ) MP_Mailinglist::delete( $ml_id );
		$ml_id = MP_Mailinglist::insert( array( 'name' => $ml_name, 'description' => $ml_name ) );
		if ( !$ml_id ) return false;

		// get_users
		global $wpdb;
		$users = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT a.user_id as id FROM $wpdb->mp_tracks a, $wpdb->mp_users b WHERE a.mail_id = %d AND a.track = %s AND a.user_id = b.id AND b.status = 'active' ORDER BY 1", $mail_id, $track ) );
   		if ( empty( $users ) ) return false;
		foreach( $users as $user ) 
		{
			$mls = array();
			$mls = MP_Mailinglist::get_object_terms( $user->id );
			$mls[] = $ml_id;
			$mls = MP_Mailinglist::set_object_terms( $user->id, $mls );
		}

		MP_AdminPage::mp_redirect( MP_AdminPage::url( MailPress_users, array( 'mailinglist' => $ml_id ) ) );
		die();
	}



// for ajax
	public static function mp_action_add_mlnglst()
	{
		if ( !current_user_can( 'MailPress_manage_mailinglists' ) ) MP_::mp_die( '-1' );

		if ( '' === trim( MP_WP_Ajax::$pst_['name'] ) ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'mailinglist', 
									'id' => new WP_Error( 'mailinglist_name', __( 'You did not enter a valid mailing list name.', 'MailPress' ) )
								   ) );
			$x->send();
		}

		if ( MP_Mailinglist::exists( trim( MP_WP_Ajax::$pst_['name'] ) ) ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'mailinglist', 
									'id' => new WP_Error( __CLASS__ . '::exists', __( 'The mailing list you are trying to create already exists.', 'MailPress' ), array( 'form-field' => 'name' ) ), 
								  ) );
			$x->send();
		}
	
		$mailinglist = MP_Mailinglist::insert( MP_WP_Ajax::$pst_, true );

		if ( is_wp_error( $mailinglist ) ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'mailinglist', 
									'id' => $mailinglist
								  ) );
			$x->send();
		}

		if ( !$mailinglist || ( !$mailinglist = MP_Mailinglist::get( $mailinglist ) ) ) 	MP_::mp_die( '0' );

		$level 			= 0;
		$mailinglist_full_name 	= $mailinglist->name;
		$_mailinglist 		= $mailinglist;
		while ( $_mailinglist->parent ) 
		{
			$_mailinglist 		= MP_Mailinglist::get( $_mailinglist->parent );
			$mailinglist_full_name 	= $_mailinglist->name . ' &#8212; ' . $mailinglist_full_name;
			$level++;
		}
		$mailinglist_full_name = esc_attr( $mailinglist_full_name );

		include ( MP_ABSPATH . 'mp-admin/mailinglists.php' );
		$x = new WP_Ajax_Response( array( 	'what' => 'mailinglist', 
								'id' => $mailinglist->term_id, 
								'data' => MP_AdminPage::get_row( $mailinglist, array(), $level, $mailinglist_full_name ), 
								'supplemental' => array( 'name' => $mailinglist_full_name, 'show-link' => sprintf( __( 'Mailing list <a href="#%s">%s</a> added' , 'MailPress' ), "mailinglist-$mailinglist->term_id", $mailinglist_full_name ) )
							  ) );
		$x->send();
	}

	public static function mp_action_delete_mlnglst() 
	{
		$id = ( int ) MP_WP_Ajax::$pst_['id'] ?? 0;
		MP_::mp_die( MP_Mailinglist::delete( $id ) ? '1' : '0' );
	}

	public static function mp_action_add_mailinglist()
	{
		$names = explode( ',', MP_WP_Ajax::$pst_['newmailinglist'] );
		$parent = ( int ) MP_WP_Ajax::$pst_['newmailinglist_parent'];
		if ( $parent < 0 ) $parent = 0;

		$all_mailinglists_ids = isset( MP_WP_Ajax::$pst_['mp_user_mailinglist'] ) ? ( array ) MP_WP_Ajax::$pst_['mp_user_mailinglist'] : array();

		$most_used_ids = ( isset( MP_WP_Ajax::$pst_['popular_ids'] ) ) ? explode( ',', MP_WP_Ajax::$pst_['popular_ids'] ) : false;

		$x = new WP_Ajax_Response();
		foreach ( $names as $name )
		{
			$name = trim( $name );
			$id = MP_Mailinglist::create( $name, $parent );
			$all_mailinglists_ids[] = $id;
			if ( $parent ) continue;										// Do these all at once in a second
			$mailinglist = MP_Mailinglist::get( $id );

			$data = self::all_mailinglists_checkboxes( 0, $id, $all_mailinglists_ids, $most_used_ids );

			$x->add( array(	'what' => 'mailinglist', 
						'id'   => $id, 
						'data' => $data, 
						'position' => -1
					  ) );
		}
		if ( $parent ) 
		{ 									// Foncy - replace the parent and all its children
			$data = self::all_mailinglists_checkboxes( 0, $parent, $all_mailinglists_ids, $most_used_ids );

			$x->add( array( 	'what' => 'mailinglist', 
						'id'   => $parent, 
						'old_id' => $parent, 
						'data' => $data, 
						'position' => -1
					  ) );
		}
		$x->send();
	}
}
new MailPress_mailinglist();
}