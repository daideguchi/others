<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_post' ) )
{
/*
Plugin Name: MailPress_post
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/post/
Description: New Mail : select posts for draft mails ( <span style="color:red;">required !</span> 'manual' template for your mp theme )
Author: Roberto Morales O., Andre Renaut
Version: 7.2
Author URI: http://www.mailpress.org
*/

class MailPress_post
{
	const meta_key        = '_MailPress_post_';
	const meta_key_order  = '_MailPress_post-order';

	function __construct()
	{
// for wp admin
		if ( is_admin() )
		{
		// for role & capabilities
			add_filter( 'MailPress_capabilities', 		array( __CLASS__, 'capabilities' ), 1, 1 );
		// for mails list
			add_filter( 'MailPress_get_icon_mails', 		array( __CLASS__, 'get_icon_mails' ), 8, 2 );
		// for meta box in write post
				add_action( 'do_meta_boxes', 				array( __CLASS__, 'add_meta_boxes_post' ), 8, 3 );
		// for meta box in write page
				add_action( 'MailPress_add_help_tab_write',	array( __CLASS__, 'add_help_tab_write' ), 8 );
				add_action( 'MailPress_update_meta_boxes_write',array( __CLASS__, 'update_meta_boxes_write' ) );
				add_filter( 'MailPress_scripts', 			array( __CLASS__, 'scripts' ), 8, 2 );
				add_action( 'MailPress_add_meta_boxes_write',	array( __CLASS__, 'add_meta_boxes_write' ), 8, 2 );
		}
// trash post
 		add_action( 'trash_post', 			array( __CLASS__, 'trash_post' ), 8, 1 );
// for ajax in write post
		add_action( 'mp_action_add_mpdraft',		array( __CLASS__, 'mp_action_add_mpdraft' ) );
		add_action( 'mp_action_delete_mpdraft',	array( __CLASS__, 'mp_action_delete_mpdraft' ) );
// for ajax in write mail
		add_action( 'mp_action_order_mppost',	array( __CLASS__, 'mp_action_order_mppost' ) );
		add_action( 'mp_action_delete_mppost',array( __CLASS__, 'mp_action_delete_mppost' ) );

// template when posts
		add_filter( 'MailPress_draft_template', array( __CLASS__, 'draft_template' ), 8, 2 );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// for role & capabilities
	public static function capabilities( $capabilities ) 
	{
		$capabilities['MailPress_manage_posts'] = array( 	'name'  => __( 'Posts', 'MailPress' ), 
											'group' => 'mails'
		 );
		return $capabilities;
	}

// for mails list
	public static function get_icon_mails( $out, $mail_id )
	{ 
		if ( MP_Post::object_have_relations( $mail_id ) ) $out .= '<span class="mp_icon mp_icon_post" title="' . esc_attr( __( 'Posts', 'MailPress' ) ) . '"></span>';
		return $out;
	}

// trash post
	public static function trash_post( $post_id )
	{ 
		MP_Post::delete_post( $post_id );
	}

// for meta box in write post  ////
	public static function add_help_tab_write()
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Posts :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'When mixing text with posts, do as follow:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . sprintf( __( 'Create a new %s.', 'MailPress' ), sprintf( '<a href="' . MailPress_write . '" target="_blank">%s</a>', __( 'Mail', 'MailPress' ) ) ) . '</li>';
		$content .= '<li>' . __( 'For each post required, edit them and look for the box &#8220;MailPress drafts&#8221; and select the required draft(s).', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'Going back to the required draft(s), look for the new box &#8220;Posts&#8221; with the selected post(s). You can order them as you like with a drag & drop selecting the left icon of the list', 'MailPress' ) . '</li>';
		$content .= '<li>' . sprintf( __( 'Draft mail with posts can be quickly identified in %1$s with a little pin icon : %2$s', 'MailPress' ), sprintf( '<a href="' . MailPress_mails . '" target="_blank">%s</a>', __( 'Mails list', 'MailPress' ) ) , '<span class="mp_icon mp_icon_post" title="' . esc_attr( __('Posts', 'MailPress' ) ) . '"></span>' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'posts',
										'title'	=> __( 'Posts', 'MailPress' ),
										'content'	=> $content )
		);
	}

	public static function add_meta_boxes_post( $page, $type, $post )
	{
		if ( 'post' != $page ) return;
		if ( 'side' != $type ) return;
		if ( !current_user_can( 'MailPress_manage_posts' ) ) return;


		wp_register_style( 'mp-meta-box-post-drafts', 	'/' . MP_PATH . 'mp-admin/css/mp-meta-box-post-drafts.css' );
		wp_register_style( 'mp_icons', 				'/' . MP_PATH . 'mp-admin/css/_icons.css', array( 'mp-meta-box-post-drafts' ) );
		wp_enqueue_style( 'mp_icons' );

		wp_register_script( 'mp-ajax-response',	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'mp-ajax-response', 	'wpAjax', array( 
			'noPerm' => __( 'An unidentified error has occurred.' ), 
			'broken' => __( 'An unidentified error has occurred.' ), 
			'l10n_print_after' => 'try{convertEntities( wpAjax );}catch( e ){};' 
		 ) );

		wp_register_script( 'mp-lists', 		'/' . MP_PATH . 'mp-includes/js/mp_lists.js', array( 'mp-ajax-response' ), false, 1 );

		wp_register_script( 'mp-meta-box-post-drafts', 	'/' . MP_PATH . 'mp-includes/js/meta_boxes/post/drafts.js',  array( 'mp-lists' ), false, 1 );
		wp_enqueue_script( 'mp-meta-box-post-drafts' );

		wp_register_script( 'mp-thickbox', 		'/' . MP_PATH . 'mp-includes/js/mp_thickbox.js', array( 'thickbox' ), false, 1 );
		wp_enqueue_script( 'mp-thickbox' );

		add_meta_box( 'MailPress_drafts', __( 'MailPress drafts', 'MailPress' ), array( __CLASS__, 'meta_box_post' ), 'post', 'side', 'core' );
	}

	public static function meta_box_post( $post ) 
	{
		include ( MP_ABSPATH . 'mp-includes/meta_boxes/post/drafts.php' );
	}

	public static function mp_action_add_mpdraft()
	{
		if ( !current_user_can( 'MailPress_manage_posts' ) ) MP_::mp_die( '-1' );

		if ( !isset( MP_WP_Ajax::$pst_['post_id'] ) || !MP_WP_Ajax::$pst_['post_id'] ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'mpdraft', 
									'id' => new WP_Error( 'post_id', __( 'Post id unknown, save post first !', 'MailPress' ) )
								   ) );
			$x->send();
		}

		$mpdraft = MP_Post::insert( MP_WP_Ajax::$pst_['newmpdraft'], MP_WP_Ajax::$pst_['post_id'] );

		if ( is_wp_error( $mpdraft ) ) 
		{
			$x = new WP_Ajax_Response( array( 	'what' => 'mpdraft', 
									'id' => $mpdraft
								  ) );
			$x->send();
		}

		$x = new WP_Ajax_Response( array( 	'what' => 'mpdraft', 
								'id' => MP_WP_Ajax::$pst_['newmpdraft'], 
								'data' => self::get_draft_row( MP_WP_Ajax::$pst_['newmpdraft'], stripslashes( MP_WP_Ajax::$pst_['newmpdraft_txt'] ) ),
							  ) );
		$x->send();
	}

	public static function get_draft_row( $id, $subject )
	{
		$edit_url = esc_url( MailPress_edit . "&id=$id" );
		$actions['edit'] = '<a href="' . $edit_url . '" title="' . esc_attr( sprintf( __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ) , $subject ) ) . '">' . $id . '</a>';

		$args = array( 'id' => $id, 'action' => 'mp_ajax', 'mp_action' => 'iview', 'TB_iframe' => 'true' );
		$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );    
		$actions['view'] = '<a href="' . $view_url . '" class="thickbox thickbox-preview" title="' . esc_attr( sprintf( __( 'View &#8220;%1$s&#8221;', 'MailPress' ) , $subject ) ) . '">' . $subject . '</a>';

		$delete_url = esc_url( MP_::url( '#', array(), "delete-mpdraft_$id" ) );
		$actions['delete'] = '<a class="delete:mpdraftchecklist:mpdraft-' . $id . '" data-wp-lists="delete:mpdraftchecklist:mpdraft-' . $id . '" href="' . $delete_url . '" title="' . esc_attr( __( 'Delete link', 'MailPress' ) ) . '"><span class="mp_icon mp_icon_trash" title="' . esc_attr( __( 'Trash', 'MailPress' ) ). '"></span></a>';

		$out  = '<li id="mpdraft-' . $id . '">';
		$out .= '<table class="widefat">';
		$out .= '<td class="mp_edit">';
		$out .= $actions['edit'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $actions['view'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $actions['delete'];
		$out .= '</td>';
		$out .= '</tr>';
		$out .= '</table>';
		$out .= '</li>';
		return $out;
	}

	public static function mp_action_delete_mpdraft()
	{
		$x = MP_Post::delete( MP_WP_Ajax::$pst_['id'], MP_WP_Ajax::$pst_['post_id'] );
		$x = ( $x ) ? MP_WP_Ajax::$pst_['id'] : '-1';
		MP_::mp_die( $x );
	}

		
// for meta box in write page
	public static function update_meta_boxes_write()
	{
	}

	public static function scripts( $scripts, $screen ) 
	{
		if ( $screen != MailPress_page_write ) return $scripts;

		wp_register_script( 'mailpress_write_posts', '/' . MP_PATH . 'mp-admin/js/write_posts.js', array( 'jquery-ui-sortable', 'mp-lists' ), false, 1 );
		wp_localize_script( 'mailpress_write_posts', 	'mp_postsL10n', array( 
			'order_mppost' => wp_create_nonce(  'order_mppost' ),
		 ) );

		$scripts[] = 'mailpress_write_posts';

		return $scripts;
	}

	public static function add_meta_boxes_write( $mail_id, $mp_screen )
	{
		if ( !$mail_id ) return;
		if ( !current_user_can( 'MailPress_manage_posts' ) ) return;

		if ( !MP_Post::get_object_terms( $mail_id ) ) return;

		add_meta_box( 'write_posts', __( 'Posts', 'MailPress' ), array( __CLASS__, 'meta_box' ), MP_AdminPage::screen, 'normal', 'core' );
	}
/**/
	public static function meta_box( $mail )
	{
		$id = $mail->id ?? 0;
		$post_ids = MP_Post::get_object_terms( $id );
		if ( !$post_ids ) return;

		$out  = '<div id="mpposts">' . "\r\n";
		$out .= '	<div id="mppostchecklist" class="list:mppost" data-wp-lists="list:mppost">' . "\r\n";
		foreach ( $post_ids as $post_id ) $out .= self::get_post_row( $post_id ) . "\r\n";
		$out .= '	</div>' . "\r\n";
		$out .= '	<span id="mppost-ajax-response"></span>' . "\r\n";
		$out .= '</div>' . "\r\n";

		echo $out;
	}

	// for ajax
	public static function get_post_row( $id )
	{
                $post = get_post( $id );
                if ( !$post ) return '';

		$delete_nonce = wp_create_nonce( 'delete-write-post_' . $id );

		$ptitle = $post->post_title;

		$actions['sortable'] = '<span class="mppost-handle mp_icon mp_icon_sortable" title="' . esc_attr( __( 'up/down', 'MailPress' ) ) . '"></span>';

		$edit_url = esc_url( add_query_arg( array( 'action' => 'edit', 'post' => $id ) , 'post.php' ) );
		$actions['edit'] = '<a href="' . $edit_url . '" target="_blank" title="' . esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'MailPress' ) , $ptitle ) ) . '">' . $id . '</a>';

		$view_url = $post->guid;
		$actions['view'] = '<a href="' . $view_url . '" target="_blank" title="' . esc_attr( sprintf( __( 'View &#8220;%s&#8221;', 'MailPress' ) , $ptitle ) ) . '">' . $ptitle . '</a>';

		$delete_url = esc_url( MP_::url( '#', array(), "delete-mppost_$id" ) );
		$actions['delete'] = '<a class="delete:mppostchecklist:mppost-' . $id . '" href="' . $delete_url . '" title="' . esc_attr( __( 'Delete link', 'MailPress' ) ) . '"><span class="mp_icon mp_icon_trash" title="' . esc_attr( __('Trash', 'MailPress' ) ) . '"></span></a>';

		$out  = '<div id="mppost-' . $id . '">';
		$out .= '<table class="widefat">';
		$out .= '<tr>';
		$out .= '<td>';
		$out .= $actions['sortable'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $actions['edit'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $actions['view'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $actions['delete'];
		$out .= '</td>';
		$out .= '</tr>';
		$out .= '</table>';
		$out .= '</div>';
		return $out;
	}

	public static function mp_action_order_mppost()
	{
		check_ajax_referer( 'order_mppost', 'security' );

		$meta_value = array();

		$mp_mail_id = MP_WP_Ajax::$pst_['id'];
		$posts = explode( ',', MP_WP_Ajax::$pst_['posts'] );
		foreach( $posts as $post )
		{
			$post_id = str_replace( 'mppost-', '', $post );
			$meta_value[$post_id] = $post_id;
		}
		if ( !MP_Mail_meta::add( $mp_mail_id, self::meta_key_order, $meta_value, true ) )
			MP_Mail_meta::update( $mp_mail_id, self::meta_key_order, $meta_value );

		MP_::mp_die( 1 );
	}

	public static function mp_action_delete_mppost()
	{
		$x = MP_Post::delete( MP_WP_Ajax::$pst_['mail_id'], MP_WP_Ajax::$pst_['id'] );
		$x = ( $x ) ? MP_WP_Ajax::$pst_['id'] : '-1';
		MP_::mp_die( $x );
	}

// template when posts
	public static function draft_template( $template, $main_id )
	{ 
		global $MP_post_ids, $mp_general;

		$MP_post_ids = MP_Post::get_object_terms( $main_id );
		if ( empty( $MP_post_ids ) ) return $template;

		$query_posts = array( 'post__in' => $MP_post_ids, 'ignore_sticky_posts' => 1 );
		if ( class_exists( 'MailPress_newsletter' ) )
			$query_posts['posts_per_page'] = MailPress_newsletter::get_post_limits();

		add_filter( 'posts_orderby', 	array( __CLASS__, 'posts_orderby' ), 8, 1 );
		query_posts( $query_posts );
		remove_filter( 'posts_orderby',array( __CLASS__, 'posts_orderby' ) );
		return 'manual';
	}

	public static function posts_orderby( $orderby = '' )
	{
		global $wpdb, $MP_post_ids;
		$orderby = " FIELD( {$wpdb->posts}.ID, " . implode( ',', $MP_post_ids ) . ' )';
		return $orderby;
	}
}
new MailPress_post();
}