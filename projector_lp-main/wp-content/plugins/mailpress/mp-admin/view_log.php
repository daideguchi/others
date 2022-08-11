<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= 'mailpress_viewlog';
	const capability	= 'MailPress_view_logs';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/view_logs/';
	const file			= __FILE__;

////  Title  ////

	public static function title()
	{
		global $title;
		$title = __( 'MailPress Log', 'MailPress' );
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'View log :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'This screen displays the content of the log file selected.', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'        => 'overview',
										'title'        => __( 'Overview' ),
										'content'    => $content )
		);

		$content = '';

		$current_screen->add_help_tab( array( 	'id'        => 'autorefresh',
										'title'        => __( 'Autorefresh' ),
										'content'    => $content )
		);
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, 	'/' . MP_PATH . 'mp-admin/css/view_log.css' );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() ) 
	{
		$scripts = apply_filters( 'MailPress_autorefresh_files_js', $scripts );

		parent::print_scripts( $scripts );
	}

////  for PATH  ////

	public static function get_path() 
	{
		return MP_UPL_ABSPATH . 'log';
	}


////  for URL  ////
	public static function get_url() 
	{
		return MP_UPL_URL . 'log';
	}
}