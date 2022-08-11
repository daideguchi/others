<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_comment' ) )
{
/*
Plugin Name: MailPress_comment
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/comment/
Description: Subscribe to comments
Version: 7.2
*/

class MailPress_comment
{
	const meta_key = '_MailPress_subscribe_to_comments_';
	const option   = 'MailPress_comment';

	function __construct()
	{
// for wordpress hooks
// for comment
		add_action( 'comment_form', 					array( __CLASS__, 'comment_form' ) );
		//add_filter( 'comment_form_default_fields', 		array( __CLASS__, 'comment_form_default_fields' ), 8, 1 );
		add_action( 'comment_post', 					array( __CLASS__, 'comment_post' ), 8, 1 );
		add_action( 'wp_set_comment_status', 				array( __CLASS__, 'approve_comment' ) );
// for post
		add_action( 'delete_post', 					array( __CLASS__, 'delete_post' ) );

// for sending mails
		add_filter( 'MailPress_mailinglists_optgroup', 		array( __CLASS__, 'mailinglists_optgroup' ), 5, 2 );
		add_filter( 'MailPress_mailinglists', 			array( __CLASS__, 'mailinglists' ), 5, 1 );
		add_filter( 'MailPress_query_mailinglist', 		array( __CLASS__, 'query_mailinglist' ), 5, 2 );
		add_filter( 'MailPress_query_list_id', 			array( __CLASS__, 'query_list_id' ), 5, 2 );

// for mp_user
		add_action( 'MailPress_activate_user', 			array( __CLASS__, 'activate_user' ), 8, 1 );
		add_action( 'MailPress_deactivate_user', 			array( __CLASS__, 'deactivate_user' ), 8, 1 );
		add_action( 'MailPress_unsubscribe_user', 			array( __CLASS__, 'delete_user' ), 8, 1 );
		add_action( 'MailPress_delete_user', 				array( __CLASS__, 'delete_user' ), 8, 1 );	

// for autoresponder
		add_action( 'MailPress_load_Autoresponder_events',	array( __CLASS__, 'load_Autoresponder_events' ) );

// for sync wordpress user
		add_filter( 'MailPress_has_subscriptions', 		array( __CLASS__, 'has_subscriptions' ), 8, 2 );
		add_action( 'MailPress_sync_subscriptions',		array( __CLASS__, 'sync_subscriptions' ), 8, 2 );	

// for wp admin
		if ( is_admin() )
		{
		// for link on plugin page
			add_filter( 'plugin_action_links', 			array( __CLASS__, 'plugin_action_links' ), 10, 2 );
		// for role & capabilities
			add_filter( 'MailPress_capabilities', 		array( __CLASS__, 'capabilities' ), 1, 1 );
		// for settings
			add_filter( 'MailPress_settings_tab', 		array( __CLASS__, 'settings_tab' ), 8, 10 );
		// for settings subscriptions
			add_filter( 'MailPress_settings_subscriptions_help',		array( __CLASS__, 'settings_subscriptions_help' ), 40, 1 );
			add_action( 'MailPress_settings_subscriptions_form',		array( __CLASS__, 'settings_subscriptions_form' ), 40 );

		// for meta box in user page
			if ( current_user_can( 'MailPress_manage_comments' ) )
			{
				add_action( 'MailPress_add_help_tab_user',		array( __CLASS__, 'add_help_tab_user' ), 10 );
				add_action( 'MailPress_update_meta_boxes_user',	array( __CLASS__, 'update_meta_boxes_user' ) );
				add_action( 'MailPress_add_meta_boxes_user', 	array( __CLASS__, 'add_meta_boxes_user' ), 10, 2 );
			}
		// for dashboard
			add_action( 'MailPress_load_Dashboard_widgets', 	array( __CLASS__, 'load_Dashboard_widgets' ) );
		}

// for mp_users list
		add_filter( 'MailPress_users_columns', 			array( __CLASS__, 'users_columns' ), 30, 1 );
		add_filter( 'MailPress_users_get_row', 			array( __CLASS__, 'users_get_row' ), 30, 4 );

// for posts list
		add_filter( 'manage_edit_columns',				array( __CLASS__, 'manage_edit_columns' ), 10, 1 );
		add_action( 'manage_posts_custom_column',			array( __CLASS__, 'manage_posts_custom_column' ), 10, 2 );

// for comments list
		add_filter( 'manage_edit-comments_columns',		array( __CLASS__, 'manage_edit_comments_columns' ), 10, 1 );
		add_action( 'manage_comments_custom_column',		array( __CLASS__, 'manage_comments_custom_column' ), 10, 2 );
	}

//// Subscriptions ////

	public static function get_checklist( $mp_user_id = false, $args = '' ) 
	{
		$checklist = '';
		$defaults = array ( 	'htmlname' 	=> 'keep_comment_sub', 
						'echo'		=> 1, 
						'type'		=> 'checkbox', 
						'htmlstart'	=> '', 
						'htmlmiddle'	=> '&#160;&#160;', 
						'htmlend'		=> "<br />\n"
					 );
		$r = wp_parse_args( $args, $defaults );
		extract( $r );

		$comment_subs = self::get_subscriptions( $mp_user_id );
		foreach ( $comment_subs as $comment_sub )
		{
			$typ2		 = 'checkbox';
			$k		 = $comment_sub->meta_id;
			$v		 = apply_filters( 'the_title', $comment_sub->post_title );

			$tag 		 = '<input type="' . $typ2 . '" name="' . $htmlname . '[' . $k . ']" id="' . $htmlname . '_' . $k . '" checked="checked" />';
			$htmlstart2  = str_replace( '{{id}}', "{$htmlname}_{$k}", $htmlstart );
			$htmlmiddle2 = $htmlmiddle . str_replace( '&#160;', '', $v );
			$htmlend2    = $htmlend;

			$checklist .= "$htmlstart2$tag$htmlmiddle2$htmlend2";
		}
		return $checklist;
	}

	public static function update_checklist( $mp_user_id )
	{
		$comment_subs = self::get_subscriptions( $mp_user_id );

		$post_ = filter_input_array( INPUT_POST );

		foreach ( $comment_subs as $comment_sub )
		{
			if ( isset( $post_['keep_comment_sub'][$comment_sub->meta_id] ) ) continue;
			delete_post_meta( $comment_sub->post_id, self::meta_key, $mp_user_id );
			new MP_Stat( 'c', $comment_sub->post_id, -1 );
		}
	}

	public static function get_subscriptions( $id ) 
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare( "SELECT a.meta_id, a.post_id, b.post_title FROM $wpdb->postmeta a, $wpdb->posts b WHERE a.meta_key = %s AND a.meta_value = %s AND a.post_id = b.ID;", self::meta_key, $id ) );
	}

	public static function list_unsubscribe( $mp_user_id, $post_id )
	{
		delete_post_meta( $post_id, self::meta_key, $mp_user_id );
	}

////	Plugin  ////

	public static function comment_form( $post_id ) 
	{
		$out = '';

		$txtsubcomment = __( "Notify me of follow-up comments via email.", 'MailPress' );

		$email = MP_WP_User::get_email();

		if ( is_email( $email ) )
		{
			$i = MP_User::get_id_by_email( $email );
			if ( $i )
			{
				$is_subscriber = self::is_subscriber( $post_id, $i );
				if ( $is_subscriber )
				{
	           		$url = MP_User::get_unsubscribe_url( MP_User::get_key_by_email( $email ) );

					$out .= '<!-- start of code generated by MailPress -->' . "\r\n";
					$out .= '<div class="MailPressCommentform" style="clear:both;">' . "\r\n";
					$out .= '<span>' . sprintf( __( 'You are subscribed to this entry. %1$s.', 'MailPress' ), sprintf( '<a href="%1$s">%2$s</a>', $url, __( 'Manage your subscriptions', 'MailPress' ) ) ) . '</span>' . "\r\n";
					$out .= '</div>' . "\r\n";
					$out .= '<!-- end of code generated by MailPress -->' . "\r\n";

					echo $out;
					return;
				}
			}
		}

		$out .= '<!-- start of code generated by MailPress -->' . "\r\n";
		$out .= '<div class="MailPressCommentform" style="clear:both;">' . "\r\n";
		$out .= '<input type="hidden" name="MailPress[subscribe_to_comments_on]" value="on" />' . "\r\n";
		$out .= '<label for="MailPress_subscribe_to_comments">' . "\r\n";
		$out .= '<input name="MailPress[subscribe_to_comments]" id="MailPress_subscribe_to_comments" type="checkbox" class="MailPressCommentformCheckbox" style="margin:0;padding:0;width:auto;"' . checked( get_option( self::option ), true, false ) . ' />' . "\r\n";
		$out .= '<span>' . $txtsubcomment . '</span>' . "\r\n";
		$out .= '</label>' . "\r\n";
		$out .= '</div>' . "\r\n";
		$out .= '<!-- end of code generated by MailPress -->' . "\r\n";

		echo $out;
	}

	public static function comment_form_default_fields( $fields ) 
	{
		$txtsubcomment = __( 'Notify me of follow-up comments via email.', 'MailPress' );

		$post_id = get_the_ID();

		$email = MP_WP_User::get_email();

		if ( MailPress::is_email( $email ) )
		{
			$i = MP_User::get_id_by_email( $email );
			if ( $i )
			{
				$is_subscriber = self::is_subscriber( $post_id, $i );
				if ( $is_subscriber )
				{
	           			$url = MP_User::get_unsubscribe_url( MP_User::get_key_by_email( $email ) );

						$fields['mailpress-comment']  = '<!-- start of code generated by MailPress -->' . "\n";
						$fields['mailpress-comment'] .= '<p class="comment-form-mailpress"><span>' . sprintf( __( 'You are subscribed to this entry. %1$s.', 'MailPress' ), sprintf( '<a href="%1$s">%2$s</a>', $url, __( 'Manage your subscriptions', 'MailPress' ) ) ) . '</span></p>';
						$fields['mailpress-comment'] .= "\n" . '<!-- end of code generated by MailPress -->' . "\n";
						return $fields;
				}
			}
		}

		$fields['mailpress-comment']  = '<!-- start of code generated by MailPress -->' . "\n";
		$fields['mailpress-comment'] .= '<p class="comment-form-cookies-consent comment-form-mailpress"><input name="MailPress[subscribe_to_comments]" id="MailPress_subscribe_to_comments" type="checkbox" class="MailPressCommentformCheckbox"' . checked( get_option( self::option ), true, false ) . ' />' . 
								'<label for="MailPress_subscribe_to_comments">' .  __( 'Notify me of follow-up comments via email.', 'MailPress' ) . '</label>' .
								'<input type="hidden" name="MailPress[subscribe_to_comments_on]" value="on" /></p>' . "\n";
		$fields['mailpress-comment'] .= '<!-- end of code generated by MailPress -->' . "\n";
		return $fields;
	}

	public static function comment_post( $id ) 
	{
		global $wpdb, $comment;

		$comment 	= $wpdb->get_row( "SELECT * FROM $wpdb->comments WHERE comment_ID = $id LIMIT 1" );
		if ( 'spam' == $comment->comment_approved ) return;

		$post_id 	= $comment->comment_post_ID;

		$email 	= MP_WP_User::get_email();
		$name 	= $comment->comment_author;

		$post_ = filter_input_array( INPUT_POST );

		if ( MailPress::is_email( $email ) )
		{
			$mp_user_id = MP_User::get_id_by_email( $email );
			if ( !$mp_user_id ) $mp_user_id = apply_filters( 'MailPress_user_already_inserted', false );

			if ( $mp_user_id )
			{
				if ( isset( $post_['MailPress']['subscribe_to_comments'] ) && !self::is_subscriber( $post_id, $mp_user_id ) ) 
				{
					add_post_meta( $post_id, self::meta_key, $mp_user_id );
					new MP_Stat( 'c', $post_id, 1 );
				}
			}
			else
			{
				if ( isset( $post_['MailPress']['subscribe_to_comments'] ) )
				{
					$mp_user_id = MP_User::insert( $email, $name );
					if ( $mp_user_id )
					{
						add_post_meta( $post_id, self::meta_key, $mp_user_id );
						new MP_Stat( 'c', $post_id, 1 );
						new MP_Stat( 'u', 'comment', 1 );
						do_action( 'MailPress_new commenter', $mp_user_id, 'MailPress_new commenter' );
					}
				}
			}
		}
		if ( '1' == $comment->comment_approved ) self::approve_comment( $id );
	}

	public static function approve_comment( $id ) 
	{
		global $wpdb, $comment;

		$comment	= $wpdb->get_row( "SELECT * FROM $wpdb->comments WHERE comment_ID = $id LIMIT 1" );

		if ( !$comment ) return false;
        
		if ( '1' != $comment->comment_approved ) return true;

		$post = get_post( $comment->comment_post_ID );

		$mail = new stdClass();

		$mail->Template	= 'comments';

		$mail->recipients_query = "SELECT c.id, c.email, c.name, c.status, c.confkey from $wpdb->comments a, $wpdb->postmeta b, $wpdb->mp_users c WHERE a.comment_ID = $id AND a.comment_post_ID  = b.post_id AND b.meta_value = c.id AND b.meta_key = '" . self::meta_key . "' AND a.comment_author_email <> c.email AND c.status IN ( 'waiting', 'active' ) ;";

		$mail->_list_id = __CLASS__ . '.' . $comment->comment_post_ID;

		$mail->the_title	= apply_filters( 'the_title', $post->post_title );

		$mail->subject	= sprintf( __( '[%1$s] New Comment (%2$s)', 'MailPress' ), get_bloginfo( 'name' ), $mail->the_title );

		$mail->content	= apply_filters( 'comment_text', get_comment_text() );

			$mail->advanced = new stdClass();
			$mail->advanced->comment = $comment;
			$mail->advanced->post    = $post;

		/* deprecated */
			$mail->p = new stdClass();
			$mail->p->id	= $comment->comment_post_ID;
			$mail->c = new stdClass();
			$mail->c->id   	= $id;
		/* deprecated */

		return MailPress::mail( $mail );
	}

////  Post ////

	public static function delete_post( $id )
	{
		global $wpdb;
		new MP_Stat( 'c', $id, ( -1 * $wpdb->get_var( "SELECT sum( scount ) FROM $wpdb->mp_stats WHERE stype = 'c' AND slib = '$id';" ) ) );
	}

//// Sending Mails ////

	public static function mailinglists_optgroup( $label, $optgroup ) 
	{
		if ( __CLASS__ == $optgroup ) return __( 'Comments', 'MailPress' );
		return $label;
	}

	public static function mailinglists( $draft_dest = array() ) 
	{
		$draft_dest['2'] = __( 'to comments', 'MailPress' );
		$draft_dest['3'] = __( 'to blog & comments', 'MailPress' );
		return $draft_dest;
	}

	public static function query_mailinglist( $query, $draft_toemail ) 
	{
		if ( $query ) return $query;

		global $wpdb;

		switch ( $draft_toemail )
		{
			case '2' :
				return $wpdb->prepare( "SELECT DISTINCT id, email, name, status, confkey FROM $wpdb->mp_users a, $wpdb->postmeta b WHERE a.id = b.meta_value AND a.status in ( 'waiting', 'active' ) AND b.meta_key = %s ;",  self::meta_key );
			break;
			case '3' :
				return $wpdb->prepare( "SELECT id, email, name, status, confkey FROM $wpdb->mp_users WHERE status = 'active' UNION SELECT DISTINCT id, email, name, status, confkey FROM $wpdb->mp_users a, $wpdb->postmeta b WHERE a.id = b.meta_value AND a.status = 'waiting' AND b.meta_key = %s ;", self::meta_key );
			break;
		}
		return $query;
	}

	public static function query_list_id( $list_id, $draft_toemail ) 
	{
		if ( $list_id ) return $list_id;

		switch ( $draft_toemail )
		{
			case '2' :
			case '3' :
				return 'MailPress.' . $draft_toemail;
			break;
		}
		return $list_id;
	}

//// post & mp_user ////

	public static function is_subscriber( $post_id, $mp_user_id ) 
	{
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare( "SELECT count( * ) FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s AND meta_value = %s;", $post_id, self::meta_key, $mp_user_id ) );
	}

//// post ////

	public static function has_subscribers( $post_id ) 
	{
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare( "SELECT count( * ) FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s;", $post_id, self::meta_key ) );
	}

//// mp_user ////

	public static function has_subscribed( $mp_user_id ) 
	{
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare( "SELECT count( * ) FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s;", self::meta_key, $mp_user_id ) );
	}

	public static function unsubscribe( $mp_user_id ) 
	{
		global $wpdb;
		return $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s;", self::meta_key, $mp_user_id ) );
	}

	public static function activate_user( $mp_user_id ) 
	{
		if ( self::has_subscribed( $mp_user_id ) ) new MP_Stat( 'u', 'comment', -1 );
	}

	public static function deactivate_user( $mp_user_id ) 
	{
		if ( self::has_subscribed( $mp_user_id ) ) new MP_Stat( 'u', 'comment', 1 );
	}

	public static function delete_user( $mp_user_id ) 
	{
		if ( self::has_subscribed( $mp_user_id ) ) new MP_Stat( 'u', 'comment', ( -1 * self::unsubscribe( $mp_user_id ) ) );
	}

//// Autoresponders ////

	public static function load_Autoresponder_events()
	{
		new MP_Autoresponder_events_comment();
	}

// Sync wordpress user

	public static function has_subscriptions( $has, $mp_user_id )
	{
		$x = self::has_subscribed( $mp_user_id );

		if ( !$x ) return $has;
		return true;
	}

	public static function sync_subscriptions( $oldid, $newid )
	{
		if ( !self::has_subscriptions( false, $oldid ) ) return;
		global $wpdb;
		return $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = %s WHERE meta_key = %s AND meta_value = %s ;", $newid, self::meta_key, $oldid ) );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'subscriptions' );
	}

// for role & capabilities
	public static function capabilities( $capabilities ) 
	{
		$capabilities['MailPress_manage_comments'] = array( 	'name'  => __( 'Comments', 'MailPress' ), 
												'group' => 'users'
										 );
		return $capabilities;
	}

// for settings
	public static function settings_tab( $tabs )
	{
		$tabs['subscriptions'] = __( 'Subscriptions', 'MailPress' );
		return $tabs;
	}

// // for settings subscriptions
	public static function settings_subscriptions_help( $content )
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/subscriptions/comment/help.php' );
		return $content;
	}

	public static function settings_subscriptions_form()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/subscriptions/comment/form.php' );
	}

// for meta box in user page
	public static function add_help_tab_user()
	{
		$post_ = filter_input_array( INPUT_POST );

		if ( !isset( $post_['id'] ) ) return;
		if ( !self::has_subscribers( $post_['id'] ) ) return;

		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Comments :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'You can create, modify comments subscriptions for a mp user.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'comments',
										'title'	=> __( 'Comments', 'MailPress' ),
										'content'	=> $content )
		);
	}

	public static function update_meta_boxes_user() 
	{
		$post_ = filter_input_array( INPUT_POST );

		if ( !isset( $post_['id'] ) ) return;
		if ( !self::has_subscribers( $post_['id'] ) ) return;

		if ( !isset( $post_['keep_comment_sub'] ) ) $post_['keep_comment_sub'] = array();

		self::update_checklist( $post_['id'] );
	}

	public static function add_meta_boxes_user( $mp_user_id, $screen )
	{
		if ( !self::has_subscribed( $mp_user_id ) ) return;

		add_meta_box( 'commentdiv', __( 'Comments', 'MailPress' ), array( __CLASS__, 'meta_box' ), $screen, 'normal', 'core' );
	}

	public static function meta_box( $mp_user )
	{ 
		$check_comments = self::get_checklist( $mp_user->id );
		if ( $check_comments ) echo $check_comments;
	}

// for dashboard
	public static function load_Dashboard_widgets() 
	{
		new MP_WP_Dashboard_widgets_comment();
	}

// for mp_users list
	public static function users_columns( $x )
	{
		$date = array_pop( $x );
		$x['comments']=  __( 'Comments', 'MailPress' );
		$x['date']		= $date;
		return $x;
	}

	public static function users_get_row( $out, $column_name, $mp_user, $url_parms )
	{
		if ( 'comments' == $column_name )
		{
			$o = array();

			global $wpdb;
			$posts = $wpdb->get_results( $wpdb->prepare( "SELECT post_id as id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s ;", self::meta_key, $mp_user->id ) );

			if ( !empty( $posts ) )
			{ 
				foreach ( $posts as $post )
				{
					$post = get_post( $post->id );
					$o[] = $post->post_title;
				}
				$out .= join( ', ', $o );
			}
		}
		return $out;
	}

// for posts list
	public static function manage_edit_columns( $x )
	{
		$x['mp_users']=  __( 'Subscribers', 'MailPress' );
		return $x;
	}

	public static function manage_posts_custom_column( $column_name, $post_id )
	{
		if ( 'mp_users' != $column_name ) return;

		global $wpdb;
		$count = self::has_subscribers( $post_id );
		if ( $count ) echo $count;
	}

// for comments list
	public static function manage_edit_comments_columns( $x )
	{
		$x['mp_subscribed']=  __( 'Subscriber', 'MailPress' );
		return $x;
	}

	public static function manage_comments_custom_column( $column_name, $comment_id )
	{
		if ( 'mp_subscribed' != $column_name ) return;

		$comment = get_comment( $comment_id );
		if ( !empty( $comment->comment_post_ID ) )
		{
			$post_id = $comment->comment_post_ID;
			$mp_user_id = MP_User::get_id_by_email( $comment->comment_author_email );
			if ( $mp_user_id )
			{
				global $wpdb;
				$is_subscriber = self::is_subscriber( $post_id, $mp_user_id );
				if ( $is_subscriber )
				{
					_e( 'yes', 'MailPress' );
					return;
				}
			}
		}
		_e( 'no', 'MailPress' );
	}
}
new MailPress_comment();
}