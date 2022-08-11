<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= MailPress_page_themes;
	const capability	= 'MailPress_switch_themes';
	const help_url		= 'http://blog.mailpress.org/tutorials/';
	const file			= __FILE__;

////  Redirect  ////

	public static function redirect() 
	{
		$th = new MP_Themes();

		if ( isset( self::$get_['action'] ) ) 
		{
			check_admin_referer( 'switch-theme_' . self::$get_['stylesheet'] );
			if ( 'activate' == self::$get_['action'] ) 
			{
				$th->switch_theme( self::$get_['template'], self::$get_['stylesheet'] );
				self::mp_redirect( MailPress_themes . '&activated=true' );
			}
		}
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Themes :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'This screen is used for managing your installed themes. Aside from the default theme(s) included with your MailPress installation.', 'MailPress' ) . '</p>';
		$content .= '<p>' . __( 'From this screen you can:', 'MailPress' ) . '</p>';
		$content .= '<ul>';
		$content .= '<li>' . __( 'Hover or tap to see Activate and Live Preview buttons', 'MailPress' ) . '</li>';
		$content .= '<li>' . __( 'Click Live Preview for any theme to see a live preview', 'MailPress' ) . '</li>';
		$content .= '</ul>';
		$content .= '<p>' . __( 'The current theme is displayed highlighted as the first theme.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'overview',
										'title'	=> __( 'Overview' ),
										'content'	=> $content )
		);

		$content = '';
		$content .= '<p>' . sprintf( __( 'All MailPress themes are currently stored in %s.', 'MailPress' ), '<code>' . MP_FOLDER . '/' . MP_CONTENT_FOLDER . '/themes</code>') . '</p>';
		$content .= '<p><i>' . __( 'For Developers : ', 'MailPress') . '</i>';
		$content .= __( ' MailPress theme have some similarities with WordPress theme.', 'MailPress' );
		$content .= '<br />' . __( 'If you develop your own mp theme, make sure to have a back up of your files. WordPress automatic plugin upgrade will erase it when upgrading MailPress.', 'MailPress' );
		$content .= '</p>';

		$current_screen->add_help_tab( array( 	'id'		=> 'adding-themes',
										'title'	=> __( 'Adding Themes', 'MailPress' ),
										'content'	=> $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		$styles[] = 'thickbox';
		parent::print_styles( $styles );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() ) 
	{
		wp_register_script( self::screen, 	'/' . MP_PATH . 'mp-admin/js/themes.js', array( 'thickbox', 'jquery' ), false, 1 );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

//// List ////

	public static function get_list( $args ) 
	{
		extract( $args );

		$th = new MP_Themes();

		foreach( $th->themes as $key => $theme )
		{
			if ( 'plaintext' == $theme['Stylesheet'] )
			{
				unset( $th->themes[$key] );
			}
			if ( '_' == $theme['Stylesheet'][0] )
			{
				unset( $th->themes[$key] );
			}
		}

		$active = $th->themes[$th->current_theme];
		unset( $th->themes[$th->current_theme] );
		ksort( $th->themes );
		$th->themes = array_merge( array( $th->current_theme => $active ), $th->themes );

		return $th;
	}

////  Row  ////

	public static function get_row( $theme, $active )
	{
		$class = array( 'available-theme' );

// table row 
//	class
		$row_class = ( $active ) ? 'theme active' : 'theme';

// url's
		$args = array();
		$args['action']		= 'activate';
		$args['template']	= $theme['Template'];
		$args['stylesheet']	= $theme['Stylesheet'];
		$activate_url		= esc_url( self::url( MailPress_themes, $args, 'switch-theme_' . $theme['Stylesheet'] ) );

		$args['action']		= 'mp_ajax';
     		$args['mp_action']	= 'theme_preview';

		$args['TB_iframe']	= 'true';
		$preview_url		=  esc_url( self::url( admin_url( 'admin-ajax.php' ), $args ) );

// titles's
		$title		= ($active) ? sprintf( __( '<span>Active : </span>%s', 'MailPress'), $theme['Title'] ) : $theme['Title'];
		$activate_title	= sprintf( __( 'Activate &#8220;%s&#8221;' ), $theme['Title'] );
		$preview_title	= sprintf( __( 'Preview of &#8220;%s&#8221;' ), $theme['Title'] );
// actions
		$actions = array();

		$preview['link1']	= '<a class="thickbox thickbox-preview screenshot" href="' . $preview_url . '">';
		if ( $theme['Screenshot'] )
		{
			$preview['link1'] .= '<img src="' . $theme['Theme Root URI'] . '/' . $theme['Stylesheet'] . '/' . $theme['Screenshot'] . '" alt="" />';
		}
		$preview['link1']	.= '</a>';

		$activate['link2']	= '<a class="button activate" href="' . $activate_url . '" title="' . esc_attr( $activate_title ) . '">' . __( 'Activate' ) . '</a>';
		$preview['link2']	= '<a class="button button-primary load-customize hide-if-no-customizethickbox thickbox-preview"  href="' . $preview_url . '" title="' . esc_attr( $preview_title ) . '">' . __( 'Preview' ) . '</a>';
		$links			= ($active) ? $preview['link2'] : $activate['link2'] . $preview['link2']; 

		$out = '';
		$out .= '<div class="' . $row_class . '" tabindex="0">';

		$out .= '<div class="theme-screenshot">';
		$out .= '<img src="' . $theme['Theme Root URI'] . '/' . $theme['Stylesheet'] . '/' . $theme['Screenshot'] . '" alt="" />';
		$out .= '</div>';
		$out .= '<div class="theme-author">' . sprintf( __('By %s', 'MailPress'), $theme['Author'] ) . '</div>';
		$out .= '<div class="theme-id-container">';
		$out .= '<h2 class="theme-name" id="' . $theme['Stylesheet'] . '-name">' . $title . '</h2>';
		$out .= '<div class="theme-actions">' . $links . '</div>';
		$out .= '</div>';

		$out .= '</div>';

		return $out;
	}
}