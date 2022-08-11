<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen 		= MailPress_page_forms;
	const capability 	= 'MailPress_manage_forms';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/form/';
	const file        	= __FILE__;

	const add_form_id 	= 'add';
	const list_id 		= 'the-list';
	const tr_prefix_id 	= 'form';

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		$url_parms	= self::get_url_parms( array( 's', 'paged', 'id' ) );
		$checked	= self::$get_['checked'] ?? array();

		$count	= str_replace( 'bulk-', '', $action );
		$count     .= 'd';
		$$count	= 0;

		switch( $action ) 
		{
			case 'bulk-delete' :
				foreach( $checked as $id )
				{
					if ( MP_Form::delete( $id ) )
					{
						$$count++;
					}
				}

				if ( $$count )
				{
					$url_parms[$count] = $$count;
				}
				$url_parms['message'] = ( $$count <= 1 ) ? 3 : 4;
				self::mp_redirect( self::url( MailPress_forms, $url_parms ) );
			break;

			case 'add':
				$e = MP_Form::insert( self::$pst_ );
				$url_parms['message'] = ( $e ) ? 1 : 91;
				unset( $url_parms['s'] );
				self::mp_redirect( self::url( MailPress_forms, $url_parms ) );
			break;
			case 'duplicate' :
				MP_Form::duplicate( $url_parms['id'] );
				self::mp_redirect( self::url( MailPress_forms, $url_parms ) );
			break;
			case 'edited':
				unset( self::$get_['action'] );
				if ( !isset( self::$pst_['cancel'] ) ) 
				{
					$e = MP_Form::insert( self::$pst_ );
					$url_parms['message'] = ( $e ) ? 2 : 92 ;
					$url_parms['action']  = 'edit';
				}
				else
				{
					unset( $url_parms['id'] );
				}

				self::mp_redirect( self::url( MailPress_forms, $url_parms ) );
			break;

			case 'delete':
				MP_Form::delete( $url_parms['id'] );
				unset( $url_parms['id'] );

				$url_parms['message'] = 3;
				self::mp_redirect( self::url( MailPress_forms, $url_parms ) );
			break;
		}
	}

////  Title  ////

	public static function title() 
	{ 
		new MP_Form_field_types();
		if ( isset( self::$get_['id'] ) )
		{
			global $title;
			$title = __( 'Edit Form', 'MailPress' );
		} 
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Forms :', 'MailPress' ) . '</strong></p>'
				. '<p>' . __( 'To create a form, you will need to : ', 'MailPress' ) . '</p>'
				. '<ol><li> '
				. sprintf( __( 'Using this form, create a MailPress form linked to a %s.', 'MailPress' ), sprintf( '<a href="' . MailPress_templates . '" target="_blank">%s</a>', __( 'template', 'MailPress' ) ) )
				. '</li><li> '
				. __( 'Once created, select the option &#8220;Fields&#8221; in the forms list, to create your form fields', 'MailPress' )
				. '</li></ol>';

		$content .= '<div id="mp_help" class="mp_help">'
				.'<ul><li>'
				. '<a href="#mp_help_tab_1">' . __( 'Attributes', 'MailPress' ) . '</a>'
				. '</li><li> '
				. '<a href="#mp_help_tab_2">' . __( 'Options', 'MailPress' ) . '</a>'
				. '</li><li> '
				. '<a href="#mp_help_tab_3">' . __( 'Messages', 'MailPress' ) . '</a>'
				. '</li><li> '
				. '<a href="#mp_help_tab_4">' . __( 'Visitor', 'MailPress' ) . '</a>'
				. '</li><li> '
				. '<a href="#mp_help_tab_5">' . __( 'Recipient', 'MailPress' ) . '</a>'
				. '</li></ul> '
		. '<div class="cbh95">'
			. '<div id="mp_help_tab_1" class="mp_help_tabs">'
				. '<table>'
				. '<tr><td>'
				. 'class ='
				. '<td><td>'
				. sprintf( __( 'For css purpose, if you need any class to be set in the %s HTML tag', 'MailPress' ), '<code>form</code>' )
				. '</td></tr>'
				. '<tr><td>'
				. 'style ='
				. '<td><td>'
				. sprintf( __( 'For css purpose, if you need any style to be set in the %s HTML tag', 'MailPress' ), '<code>form</code>' )
				. '</td></tr>'
				. '<tr><td>'
				. '<td><td>'
				. __( "other attributes except 'name' & 'action'", 'MailPress' )
				. '</td></tr>'
				. '</table>'
			. '</div>'
			. '<div id="mp_help_tab_2" class="mp_help_tabs">'
				. '<table>'
				. '<tr><td>'
				. __( 'Reset...', 'MailPress' )
				. '<td><td>'
				. __( 'After submitted, all form fields initialised', 'MailPress' )
				. '</td></tr>'
				. '</table>'
			. '</div>'
			. '<div id="mp_help_tab_3" class="mp_help_tabs">'
				. '<table>'
				. '<tr><td>'
				. __( 'success', 'MailPress' )
				. '<td><td>'
				. __( 'Your message', 'MailPress' )
				. '</td></tr>'
				. '<tr><td>'
				. __( 'failed', 'MailPress' )
				. '<td><td>'
				. __( 'Your message', 'MailPress' )
				. '</td></tr>'
				. '<tr><td>'
				. '<td><td>'
				. __( 'You can choose the location of your message in your html by editing its template... look for {{message}}', 'MailPress' )
				. '</td></tr>'
				. '</table>'
			. '</div>'
			. '<div id="mp_help_tab_4" class="mp_help_tabs">'
				. '<table>'
				. '<tr><td>'
				. __( 'Subscriber', 'MailPress' )
				. '<td><td>'
				. __( 'Choose option.', 'MailPress' )
				. '</td></tr>'
				. '<tr><td>'
				. __( 'Copy', 'MailPress' )
				. '<td><td>'
				. __( 'Choose option.', 'MailPress' )
				. ' <i>'
				. __( 'to be confirmed, will automatically add a checkbox in the form fields.', 'MailPress' )
				. '</i></td></tr>'
				. '</table>'
			. '</div>'
			. '<div id="mp_help_tab_5" class="mp_help_tabs">'
				. '<table>'
				. '<tr><td>'
				. __( 'Email', 'MailPress' )
				. '<td><td>'
				. __( 'Recipient Email', 'MailPress' )
				. '</td></tr>'
				. '<tr><td>'
				. __( 'Name', 'MailPress' )
				. '<td><td>'
				. __( 'Recipient name', 'MailPress' )
				. '</td></tr>'
				. '<tr><td>'
				. '<td><td>'
				. __( 'MailPress theme template must start by "form_", see samples in <code>mailpress/mp-content/themes</code>', 'MailPress' )
				. '</td></tr>'
				. '</table>'
			. '</div>'
			. '</div>'
				. '</div>';
//[mailpress_form id='1']
		$current_screen->add_help_tab( array( 	'id'        => 'overview',
										'title'        => __( 'Overview' ),
										'content'    => $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen,	'/' . MP_PATH . 'mp-admin/css/forms.css', array( 'thickbox' ) );

		$styles[] = self::screen;
		parent::print_styles( $styles );
	}

//// Scripts ////

	public static function print_scripts( $scripts = array() )  
	{
		wp_register_script( 'mp-ajax-response',	'/' . MP_PATH . 'mp-includes/js/mp_ajax_response.js', array( 'jquery', 'jquery-ui-tabs' ), false, 1 );
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

		wp_register_script( self::screen, 		'/' . MP_PATH . 'mp-admin/js/forms.js', array( 'mp-taxonomy', 'mp-thickbox' ), false, 1 );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

//// Columns ////

	public static function get_columns() 
	{
		$columns = array(	'cb'			=> '<input type="checkbox" />',
						'name'		=> __( 'Label', 'MailPress' ),
						'template'		=> __( 'Template', 'MailPress' ),
						'recipient'	=> __( 'Recipient', 'MailPress' ),
						'confirm'		=> __( 'Copy', 'MailPress' ) 
		);
		return $columns;
	}

//// List ////

	public static function get_list( $args )
	{
		extract( $args );

		global $wpdb;

		$where = '';

		if ( isset( $url_parms['s'] ) )
		{
			$sc = array( 'a.label', 'a.description' );

			$where .= self::get_search_clause( $url_parms['s'], $sc );
		}

		$args['query'] = "SELECT DISTINCT SQL_CALC_FOUND_ROWS a.id, a.label, a.description, a.template, a.settings FROM $wpdb->mp_forms a WHERE 1=1 $where ";
		$args['cache_name'] = 'mp_form';

		return parent::get_list( $args );
	}

////  Row  ////

	public static function get_row( $form, $url_parms ) 
	{
		static $row_class = '';

		$form = MP_Form::get( $form );

// url's
		$url_parms['action'] 	= 'edit';

		$url_parms['id'] 	= $form->id;

		$edit_url = esc_url( self::url( MailPress_forms, $url_parms ) );
		$url_parms['action'] 	= 'duplicate';
		$duplicate_url = esc_url( self::url( MailPress_forms, $url_parms, 'duplicate-form_' . $form->id ) );

		$url_parms['action'] 	= 'edit_fields';
		$url_parms['form_id'] = $url_parms['id']; unset( $url_parms['id'] ); 
		$edit_fields_url = esc_url( self::url( MailPress_fields, $url_parms ) );
		$url_parms['id'] = $url_parms['form_id']; unset( $url_parms['form_id'] ); 

		$edit_templates_url = esc_url( self::url( MailPress_templates, array( 'action' => 'edit', 'template' => $form->template ) ) );

		$args = array();
		$args['id']		= $form->id;
		$args['action'] 	= 'mp_ajax';
		$args['mp_action'] 	= 'ifview';
		$args['TB_iframe']	= 'true';
		$view_url			= esc_url( self::url( admin_url( 'admin-ajax.php' ), $args ) );

		$url_parms['action'] 	= 'delete';
		$delete_url = esc_url( self::url( MailPress_forms, $url_parms, 'delete-form_' . $form->id ) );

// actions
		$actions = array();
		$actions['edit'] = '<a href="' . $edit_url . '">' . __( 'Edit' ) . '</a>';
		$actions['edit_templates'] = '<a href="' . $edit_templates_url . '">' . __( 'Templates', 'MailPress' ) . '</a>';
		$actions['edit_fields'] = '<a href="' . $edit_fields_url . '">' . __( 'Fields', 'MailPress' ) . '</a>';
		$actions['duplicate'] = '<a class="dim:' . self::list_id . ':' . self::tr_prefix_id . '-' . $form->id . ':unapproved:e7e7d3:e7e7d3" href="' . $duplicate_url . '">' . __( 'Duplicate', 'MailPress' ) . '</a>';
		$actions['delete'] = '<a class="submitdelete" href="' . $delete_url . '">' . __( 'Delete' ) . '</a>';
		$actions['view'] = '<a class="thickbox thickbox-preview" href="' . $view_url . '" title="' . esc_attr( sprintf( __( 'Form preview #%1$s (%2$s)', 'MailPress' ), $form->id, $form->label ) ) . '" >' . __( 'Preview', 'MailPress' ) . '</a>';

		$row_class = ( 'alternate' == substr( $row_class, 0, 9 ) ) ? '' : 'alternate '; 
		$row_class .= 'iedit';

		$out = '';
		$out .= '<tr id="' . self::tr_prefix_id . '-' . $form->id . '" class="' . $row_class . '">';

		$columns = self::get_columns();
		$hidden  = self::get_hidden_columns();

		foreach ( $columns as $column_name => $column_display_name ) 
		{
			$attributes = sprintf( 'class="%1$s column-%1$s%2$s"', $column_name, ( in_array( $column_name, $hidden ) ) ? ' hidden' : '' );

			switch ( $column_name ) 
			{
				case 'cb':
					$out .= '<th class="check-column"> <input type="checkbox" name="checked[]" value="' . $form->id . '" /></th>';
				break;
				case 'name':
					$out .= '<td ' . $attributes . '><strong><a class="row-title" href="' . $edit_url . '" title="' . esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $form->label ) ) . '">' . $form->label . '</a></strong><br />';
					$out .= self::get_actions( $actions );
					$out .= '</td>';
				break;
	 			case 'template':
	 				$out .= '<td ' . $attributes . '>' . $form->template . '</td>';
	 			break;
	 			case 'Theme':
	 				$out .= '<td ' . $attributes . '>' . $form->settings['recipient']['theme'];
					if ( !empty( $form->settings['recipient']['template'] ) ) $out .= '<br />( ' . $form->settings['recipient']['template'] . ' )'; 
					$out .= '</td>';
	 			break;
	 			case 'recipient':
	 				$out .= '<td ' . $attributes . '>' . $form->settings['recipient']['toemail'];
					if ( !empty( $form->settings['recipient']['toname'] ) ) $out .= '<br />( ' . $form->settings['recipient']['toname'] . ' )'; 
					$out .= '</td>';
	 			break;
				case 'confirm':
	 				$out .= '<td ' . $attributes . '>';
					$mail = $form->settings['visitor']['mail'] ?? 0;
					switch ( $mail )
					{
						case 1 :
							$out .= __( 't.b.c.', 'MailPress' );
						break;
						case 2 :
							$out .= __( 'yes', 'MailPress' );
						break;
						default :
							$out .= __( 'no', 'MailPress' );
						break;
					}
	 				$out .= '</td>';
	 			break;
			}
		}
		$out .= '</tr>';

		return $out;
	}
}