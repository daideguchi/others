<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= 'mailpress_page_templates';
	const capability	= 'MailPress_manage_forms';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/form/';
	const file			= __FILE__;

////  Redirect  ////

	public static function redirect() 
	{
		$action = parent::redirect();
		if ( !$action ) return;

		switch( $action ) 
		{
			case 'update' :

				$template = self::$pst_['template'];

				$advanced_path = 'advanced/' . get_current_blog_id() . '/forms';
				$root  = MP_UPL_ABSPATH . $advanced_path;
				$root  = apply_filters( 'MailPress_advanced_forms_root', $root );
				$root .= '/templates';
				$template_file = "$root/$template.xml";

				$args['action']  = 'edit';
				$args['template']= $template;
				$args['message'] = 2;

				$xml = stripslashes( self::$pst_['newcontent'] );

				if ( !simplexml_load_string( $xml ) )
				{
					$args['message'] = 3;
				}
				elseif ( file_put_contents( $template_file, $xml ) )
				{
					$args['message'] = 1;
				}
				self::mp_redirect( self::url( MailPress_templates, $args ) );
			break;
			case 'toedit' :
				$template = self::$pst_['template'];
				$args['action']  = 'edit';
				$args['template']= $template;
				self::mp_redirect( self::url( MailPress_templates, $args ) );
			break;
		}
	}

////  Title  ////

	public static function title()
	{
		global $title;
		$title = __( 'MailPress Forms Templates', 'MailPress' );
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen,		'/' . MP_PATH . 'mp-admin/css/form_templates.css' );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

//// Scripts ////

	public static function print_scripts( $scripts = array() )
	{
		$localize = array( 'cm_url' => site_url() . '/' . MP_PATH . 'mp-includes/js/codemirror/' );

		wp_register_script( 'mp-codemirror','/' . MP_PATH . 'mp-includes/js/codemirror/js/codemirror.js', false, false, 1 );

		wp_register_script( self::screen,	'/' . MP_PATH . 'mp-admin/js/form_templates.js', array( 'mp-codemirror' ), false, 1 );
		wp_localize_script( self::screen, 	'adminCodeMirrorL10n', $localize );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}
}