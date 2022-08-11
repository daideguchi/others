<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen		= MailPress_page_autoresponders;
	const capability	= 'MailPress_manage_autoresponders';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/autoresponder/';
	const file			= __FILE__;

	const taxonomy		= MailPress_autoresponder::taxonomy;

	const add_form_id	= 'add';
	const list_id		= 'the-list';
	const tr_prefix_id	= 'atrspndr';

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms( array( 's', 'paged', 'id' ) );
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count	.= 'd';
		$$count	= 0;

		switch( $action ) 
		{
			case 'bulk-delete' :
				foreach( $checked as $id )
				{
					if ( MP_Autoresponder::delete( $id ) )
					{
						$$count++;
					}
				}

				if ( $$count )
				{
					$url_parms[$count] = $$count;
				}

				$url_parms['message'] = ( $$count <= 1 ) ? 3 : 4;
				self::mp_redirect( self::url( MailPress_autoresponders, $url_parms ) );
			break;

			case 'add':
				$e = MP_Autoresponder::insert( self::$pst_ );
				$url_parms['message'] = ( $e && !is_wp_error( $e ) ) ? 1 : 91;
				unset( $url_parms['s'] );
				self::mp_redirect( self::url( MailPress_autoresponders, $url_parms ) );
			break;
			case 'edited':
				unset( self::$get_['action'] );
				if ( !isset( self::$pst_['cancel'] ) ) 
				{
					$e = MP_Autoresponder::insert( self::$pst_ );
					$url_parms['message'] = ( $e && !is_wp_error( $e ) ) ? 2 : 92 ;
				}
				unset( $url_parms['id'] );
				self::mp_redirect( self::url( MailPress_autoresponders, $url_parms ) );
			break;
			case 'delete':
				MP_Autoresponder::delete( $url_parms['id'] );
				unset( $url_parms['id'] );

				$url_parms['message'] = 3;
				self::mp_redirect( self::url( MailPress_autoresponders, $url_parms ) );
			break;
		}
	}

////  Title  ////

	public static function title()
	{
		if ( isset( self::$get_['id'] ) )
		{
			global $title;
			$title = __( 'Edit Autoresponder', 'MailPress' );
		}
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Autoresponders :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'You can use autoresponders to send one or a set of specific mails based on a specific event triggered by a mp user.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'When adding a new autoresponder on this screen, you&#8217;ll fill in the following fields:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( '<strong>Name</strong> &mdash; The name is used to identify the autoresponder almost everywhere.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Slug</strong> &mdash; The &#8220;slug&#8221; is a unique id for the autoresponder. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Description</strong> &mdash; The description is not prominent by default.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Active</strong> &mdash; whether this autoresponder is active or not.', 'MailPress' );
		$content .= '    ' . __( 'If not active during a certain period of time, All mails that should have been sent on time will be cancelled. following mails in a set, if any, will be lost as well.', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( '<strong>Event</strong> &mdash; depending on add-on activations, events list will be populated accordingly.', 'MailPress' ) . '</li>';
		$content .= '</ul>';
		$content .= '<p>' . __( 'You can customize the display of this screen&#8217;s content:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( 'You can hide/display columns based on your needs and decide how many autoresponders to list per screen using the Screen Options tab.', 'MailPress' ) . '</li>';
		$content .= '</ul>';

		$current_screen->add_help_tab( array( 	'id'		=> 'adding-autoresponder',
										'title'	=> __( 'Adding Autoresponder', 'MailPress' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . __( 'When scheduling an autoresponder, do as follow:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . sprintf( __( 'Create a new %s and use the appropriate box, link it to the MailPress autoresponder by specifying the delay between the triggered event and the mail release. For a set of mails, you will need to create as many as mails required, linked to the same autoresponder with different delays.', 'MailPress' ), sprintf( '<a href="' . MailPress_write . '" target="_blank">%s</a>', __( 'Mail', 'MailPress' ) ) ) . '</li>';
		$content .= '<li>' . __( 'When saving the mail, a recipient mail is required but will be replaced on time by the right recipient&#8217;s mail.', 'MailPress' ) . '</li>';
		$content .= '<li>' . sprintf( __( 'Autoresponder draft mail can be quickly identified in %1$s with a little clock icon : %2$s', 'MailPress' ), sprintf( '<a href="' . MailPress_mails . '" target="_blank">%s</a>', __( 'Mails list', 'MailPress' ) ) , '<span class="mp_icon mp_icon_autoresponder" title="' . esc_attr( __('Autoresponder', 'MailPress' ) ) . '"></span>' ) . '</li>';
		$content .= '</ul>';

		$content .= '<p>';
		if (MP_addons::is_active('MailPress_wp_cron'))
		{
			$content .= sprintf( __('Check the autoresponder mail(s) scheduled, if any, on %1$s', 'MailPress'), sprintf( '<a href="' . MailPress_wp_cron . '" target="_blank">%s</a>', __( 'Tools > Wp_cron', 'MailPress' ) ) );
		}
		else
		{
			$content .= sprintf( __('Activate add-on %1$s, so you can check the autoresponder mail(s) scheduled, if any.', 'MailPress'), sprintf( '<a href="' . MailPress_addons . '#MailPress_wp_cron' . '" target="_blank">%s</a>', __( 'Wp_cron', 'MailPress' ) ) );
		}
		$content .= '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'scheduling-autoresponder',
										'title'	=> __( 'Scheduling Autoresponder', 'MailPress' ),
										'content'	=> $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, 		'/' . MP_PATH . 'mp-admin/css/autoresponders.css',       array( 'thickbox' ) );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

	public static function print_styles_icons( $i = array( 'icon', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

//// Scripts ////

	public static function print_scripts( $scripts = array() )  
	{
		wp_register_script( 'mp-ajax-response',	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'mp-ajax-response', 	'wpAjax', array( 
			'noPerm' => __( 'An unidentified error has occurred.' ), 
			'broken' => __( 'An unidentified error has occurred.' ), 
			'l10n_print_after' => 'try{convertEntities( wpAjax );}catch( e ){};' 
		 ) );

		wp_register_script( 'mp-lists', 		'/' . MP_PATH . 'mp-includes/js/mp_lists.js', array( 'mp-ajax-response' ), false, 1 );

		wp_register_script( 'mp-thickbox', 		'/' . MP_PATH . 'mp-includes/js/mp_thickbox.js', array( 'thickbox' ), false, 1 );

		wp_register_script( 'mp-taxonomy', 		'/' . MP_PATH . 'mp-includes/js/mp_taxonomy.js', array( 'mp-lists' ), false, 1 );
		wp_localize_script( 'mp-taxonomy', 		'MP_AdminPageL10n', array( 	
			'pending' => __( '%i% pending' ), 
			'screen' => self::screen,
			'list_id' => self::list_id,
			'add_form_id' => self::add_form_id,
			'tr_prefix_id' => self::tr_prefix_id,
			'l10n_print_after' => 'try{convertEntities( MP_AdminPageL10n );}catch( e ){};' 
		 ) );

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/autoresponders.js', array( 'mp-taxonomy', 'mp-thickbox', 'jquery-ui-tabs' ), false, 1 );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

//// Columns ////

	public static function get_columns() 
	{
		$columns = array(	'cb'		=> '<input type="checkbox" />',
						'name'	=> __( 'Name', 'MailPress' ),
						'active'	=> __( 'Active', 'MailPress' ),
						'desc'	=> __( 'Description', 'MailPress' ),
						'event' 	=> __( 'Event', 'MailPress' )
		);
		return $columns;
	}

//// List ////

	public static function get_list( $args )
	{
		extract( $args );

		$url_parms = self::get_url_parms( array( 's', 'paged' ) );

		$_args = array(	'offset' 		=> ( $start - 1 ) * $_per_page, 
					'number' 		=> $_per_page, 
					'hide_empty' 	=> 0
		);

		if ( isset( $url_parms['s'] ) )
		{
			$_args['search'] = $url_parms['s'];
		}

		$autoresponders = MP_Autoresponder::get_all( $_args );

		if ( empty( $autoresponders ) )
		{
			return false;
		}

		echo self::_get_list( $autoresponders, $url_parms );
	}

	public static function _get_list( $autoresponders, $url_parms )
	{
		$out = '';

		foreach( $autoresponders as $autoresponder )
		{
			$out .= self::get_row( $autoresponder, $url_parms );
		}

		return $out;
	}

////  Row  ////

	public static function get_row( $autoresponder, $url_parms ) 
	{
		$mp_autoresponder_registered_events = MP_Autoresponder_events::get_all();

		static $row_class = '';

		$autoresponder = MP_Autoresponder::get( $autoresponder );

		$name = $autoresponder->name ;

// url's
		$url_parms['action'] 	= 'edit';
		$url_parms['id'] 	= $autoresponder->term_id;

		$edit_url = esc_url( self::url( MailPress_autoresponders, $url_parms ) );
		$url_parms['action'] 	= 'delete';
		$delete_url = esc_url( self::url( MailPress_autoresponders, $url_parms, 'delete-autoresponder_' . $autoresponder->term_id ) );
// actions
		$actions = array();
		$actions['edit'] = '<a href="' . $edit_url . '">' . __( 'Edit' ) . '</a>';
		$actions['delete'] = '<a class="submitdelete delete:' . self::tr_prefix_id . '" href="' . $delete_url . '">' . __( 'Delete' ) . '</a>';

		$row_class = 'alternate' == $row_class ? '' : 'alternate';

		$out = '';
		$out .= '<tr id="' . self::tr_prefix_id . '-' . $autoresponder->term_id . '" class="iedit ' . $row_class . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '' );

			switch ( $column_name ) 
			{
				case 'cb':
					$out .= '<th class="check-column"> <input type="checkbox" name="checked[]" value="' . $autoresponder->term_id . '" /></th>';
				break;
				case 'name':
					$out .= '<td ' . $attributes . '><strong><a class="row-title" href="' . $edit_url . '" title="' . esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $name ) ) . '">' . $name . '</a></strong><br />';
					$out .= self::get_actions( $actions );
					$out .= '</td>';
				break;
				case 'active':
					$x = ( isset( $autoresponder->description['active'] ) ) ? __( 'Yes', 'MailPress' ) : __( 'No', 'MailPress' );
					$out .= '<td ' . $attributes . '>' . $x . '</td>';
				break;
				case 'desc':
					$out .= '<td ' . $attributes . '>' . stripslashes( $autoresponder->description['desc'] ) . '</td>';
				break;
				case 'event':
					$out .= '<td ' . $attributes . '>' . $mp_autoresponder_registered_events[$autoresponder->description['event']] . '</td>';
				break;
			}
		}
		$out .= '</tr>';

		return $out;
	}
}