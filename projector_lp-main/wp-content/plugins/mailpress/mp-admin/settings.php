<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= MailPress_page_settings;
	const capability	= 'MailPress_manage_options';
	const help_url		= 'http://blog.mailpress.org/tutorials/';
	const file			= __FILE__;

	public static $first = true;

	public static $err_mess = array();

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$_tabs = self::get_tabs();

		foreach( $_tabs as $_tab => $desc )
		{
			$content = '';

			$file = 'includes/settings/' . $_tab . '/help.php';
			include( $file );

			$current_screen->add_help_tab( array( 'id' => $_tab, 'title' => $desc, 'content' => $content ) );
		}
	}

////  Styles  ////

	public static function print_styles( $s ) 
	{
		$styles = ( is_array( $s ) ) ? $s : array();

		wp_register_style( self::screen, '/' . MP_PATH . 'mp-admin/css/settings.css' );
		$styles[] = self::screen;

		parent::print_styles( $styles );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() ) 
	{
		wp_register_script( 'mp-smtp',	'/' . MP_PATH . 'mp-admin/js/settings_smtp.js', array(), false, 1 );

		wp_register_script( self::screen, 	'/' . MP_PATH . 'mp-admin/js/settings.js', array( 'jquery-ui-tabs', 'mp-smtp' ), false, 1 );
		wp_localize_script( self::screen, 'MP_AdminPageL10n', array( 'requestFile' => admin_url( 'admin-ajax.php' ) ) );
		$scripts[] = self::screen;

		wp_register_style( 'mp_icons', 		'/' . MP_PATH . 'mp-admin/css/_icons.css' );
		$styles[] = 'mp_icons';

		parent::print_scripts( $scripts );
	}

	public static function print_styles_icons( $i = array( 'icon', ) ) 
	{
		return parent::print_styles_icons( $i );
	}

////  Misc  ////

	public static function get_tabs()
	{
		global $mp_general;

		$_tabs['general'] = __( 'General', 'MailPress' );

		if ( $mp_general || isset( MP_AdminPage::$pst_['general'] ) )
		{
			if ( has_filter( 'MailPress_Swift_Signer_type' ) )
			{
				$t = apply_filters( 'MailPress_Swift_Signer_type', false );
				if ( $t ) $_tabs['signer_' . strtolower( $t )] = $t;
			}

			$t = apply_filters( 'MailPress_Swift_Connection_type', 'SMTP' );
			$_tabs['connection_' . strtolower( $t )] = $t;
			$_tabs = apply_filters( 'MailPress_settings_tab_connection', $_tabs );

			$_tabs['test'] = __( 'Test', 'MailPress' );

			$_tabs = apply_filters( 'MailPress_settings_tab', $_tabs );

			$_tabs['logs'] = __( 'Logs', 'MailPress' );
		}

		return $_tabs;
	}

	public static function save_button()
	{
		$out  = '<p class="submit"><input type="submit" name="Submit" class="button-primary" value="' . esc_attr( __( 'Save Changes' ) ) . '" /></p>' . "\r\n";

		echo $out;
	}

	public static function log_form( $name, $data, $headertext )
	{
		if ( !isset( $data[$name] ) )
		{
			$data[$name] = MailPress::$default_option_logs;
		}

		$xlevel = MP_Log::get_defined_constants();

		$out = '';

		if ( self::$first )
		{
			self::$first = false;

			$out .= '<tr>' . "\r\n";
			foreach( array( __( 'Logs', 'MailPress' ), __( 'Level', 'MailPress' ), __( 'Days', 'MailPress' ), __( 'Last purge', 'MailPress' ), ) as $th )
			{
				$out .= '	<th><strong>' . $th . '</strong></th>' . "\r\n";
			}
			$out .= '</tr>' . "\r\n";
		}

		if ( !isset( $xlevel[$data[$name]['level']] ) ) $data[$name]['level'] = key( array_slice( $xlevel, -1, 1, true) );

		$datepurge = ( empty( $data[$name]['lastpurge'] ) ) ? '' : substr( $data[$name]['lastpurge'],0 , 4 ) . '/' . substr( $data[$name]['lastpurge'],4, 2 ) . '/' . substr( $data[$name]['lastpurge'],6, 2 ); 

		$out .= '<tr class="mp_sep">' . "\r\n";
		$out .= '	<th><label for="logs_' . $name . '_level"><strong>' . $headertext . '</strong></label></th>' . "\r\n";
		$out .= '	<td><select name="logs[' . $name . '][level]" id="logs_' . $name . '_level">'  . self::select_option( $xlevel, $data[$name]['level']  ?? false,     false ) . '</select></td>' . "\r\n";
		$out .= '	<td><select name="logs[' . $name . '][lognbr]">' . self::select_number( 1, 10,   $data[$name]['lognbr'] ?? false, 1, false ) . '</select></td>' . "\r\n";
		$out .= '	<td>' . $datepurge . '<input type="hidden" name="logs[' . $name . '][lastpurge]" value="' . esc_attr( $data[$name]['lastpurge'] ) . '" /></td>' . "\r\n";
		$out .= '</tr>' . "\r\n";

		echo $out;
	}

	public static function cron_form( $config, $name, $add_on, $every = 's_h' )
	{
		$xevery = self::cron_every( $every );

		$out = '';

		$out .= '<tr>' . "\r\n";
		$out .= '	<th>' . __( 'Submit Batch With', 'MailPress' ) . '</th>' . "\r\n";
		$out .= '	<td>' . "\r\n";
		$out .= '		<table class="general mp_cron" id="' . $name . '_mp_cron">' . "\r\n";
		$out .= '			<tr class="em3">' . "\r\n";
		$out .= '				<td class="pr10">' . "\r\n";
		$out .= '					<label for="' . $name . '_wp_cron">' . "\r\n";
		$out .= '						<input type="radio" value="wpcron" name="' . $name . '[batch_mode]" id="' . $name . '_wp_cron"' . checked( 'wpcron', $config['batch_mode'], false ) . ' />' . "\r\n";
		$out .= '						&#160;&#160; ' . __( 'Wp_cron', 'MailPress' ) . "\r\n"; 
		$out .= '					</label>' . "\r\n";
		$out .= '				</td>' . "\r\n";
		$out .= '				<td class="mp_cron_toggle pr10 every' . ( ( 'wpcron' != $config['batch_mode'] ) ? ' mask' : '' ) . '">' . "\r\n";
		$out .= '					' . __( 'Every', 'MailPress' ) . '&#160;&#160;' . "\r\n";
		$out .= '					<select name="' . $name . '[every]" id="' . $name . '_every">';
		$out .= MP_AdminPage::select_option( $xevery, $config['every'] ?? false, false );
		$out .= '</select>' . "\r\n";
		$out .= '					<span class="italic">';

		$out .= ( MP_addons::is_active( 'MailPress_wp_cron' ) ) 
			? sprintf( __('You can check your scheduled jobs, if any, on %1$s', 'MailPress'), sprintf( '<a href="' . MailPress_wp_cron . '" target="_blank">%s</a>', __( 'Tools > Wp_cron', 'MailPress' ) ) ) 
			: sprintf( __('Activate add-on %1$s, so you can check your scheduled jobs, if any.', 'MailPress'), sprintf( '<a href="' . MailPress_addons . '#MailPress_wp_cron' . '" target="_blank">%s</a>', __( 'Wp_cron', 'MailPress' ) ) );

		$out .= '</span>' . "\r\n";
		$out .= '				</td>' . "\r\n";
		$out .= '			</tr>' . "\r\n";
		$out .= '			<tr class="em3">' . "\r\n";
		$out .= '				<td class="pr10">' . "\r\n";
		$out .= '					<label for="' . $name . '_other">' . "\r\n";
		$out .= '						<input type="radio" value="other" name="' . $name . '[batch_mode]" id="' . $name . '_other"' . checked( 'other', $config['batch_mode'], false ) . ' />' . "\r\n";
		$out .= '						&#160;&#160;' . __( 'Other', 'MailPress' ) . "\r\n";
		$out .= '					</label>' . "\r\n";
		$out .= '				</td>' . "\r\n";
		$out .= '				<td class="mp_cron_toggle pr10 other' . ( ( 'other' != $config['batch_mode'] ) ? ' mask' : '' ) . '">' . "\r\n";
		$out .= '					<span class="italic">';
		$out .= __( "Don't forget to set up a cron job/scheduled task at required frequency (out of WordPress)", 'MailPress' ) . '<br />';
		$out .= sprintf( __( 'url for job : "%1$s"', 'MailPress' ), '<code>' . admin_url( 'admin-ajax.php' ) . "?action=mp_cron&hook=" . $add_on::process_name . '</code>' );
		$out .= '</span>' . "\r\n";
		$out .= '				</td>' . "\r\n";
		$out .= '			</tr>' . "\r\n";
		$out .= '		</table>' . "\r\n";
		$out .= '	</td>' . "\r\n";
		$out .= '</tr>' . "\r\n";

		echo $out;
	}

	public static function cron_every( $every = 's_h')
	{
		$freqs = array(
			's_h' => array( /* second to hour */
				30 	=> sprintf( __( '%1$s seconds', 'MailPress' ), '30' ), 
				45 	=> sprintf( __( '%1$s seconds', 'MailPress' ), '45' ), 
				60 	=> sprintf( __( '%1$s minute' , 'MailPress' ) , ''  ), 
				120 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '2'  ), 
				300 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '5'  ), 
				600 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '10' ), 
				900 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '15' ), 
				1800 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '30' ), 
				3600 	=> sprintf( __( '%1$s hour', 	'MailPress' ), ''   ),
			),
			'h_d' => array(  /* hour to day */
				3600 	=> sprintf( __( 'hour', 	'MailPress' ), ''   ),
				3600*2 	=> sprintf( __( '%1$s hours', 	'MailPress' ), '2'  ),
				3600*6 	=> sprintf( __( '%1$s hours', 	'MailPress' ), '6'  ),
				3600*12 => sprintf( __( '%1$s hours', 	'MailPress' ), '12' ),
				3600*24 =>          __( 'day',          'MailPress' ),
			),
			'd_y' => array( /* day to year */
				01 	=> sprintf( __( '%1$s day',  'MailPress' ), '1'   ), 
				05 	=> sprintf( __( '%1$s days', 'MailPress' ), '5'   ),  
				10 	=> sprintf( __( '%1$s days', 'MailPress' ), '10'  ), 
				15 	=> sprintf( __( '%1$s days', 'MailPress' ), '15'  ),  
				30 	=> sprintf( __( '%1$s days', 'MailPress' ), '30'  ),  
				60 	=> sprintf( __( '%1$s days', 'MailPress' ), '60'  ), 
				90 	=> sprintf( __( '%1$s days', 'MailPress' ), '90'  ), 
				120 	=> sprintf( __( '%1$s days', 'MailPress' ), '120' ), 
				360 	=> sprintf( __( '%1$s days', 'MailPress' ), '360' ),
			),
		);
		return ( isset( $freqs[$every] ) ) ? $freqs[$every] : $freqs['s_h'];
	}

	public static function cron_help()
	{
		$content = '';

		// Submit batch with
		$content .= '<tr><th><span>';
		$content .= __( 'Submit batch with', 'MailPress' );
		$content .= '</span></th><td>';
		$content .= '<ul>';
		$content .= '<li>' . __('Wp_cron, select frequency.', 'MailPress') . '</li>';
		$content .= '<li>' . __('Other, follow guidelines.', 'MailPress') . '</li>';
		$content .= '</ul>';
		$content .= '</td></tr>';

		return $content;
	}

	public static function pop3_form( $config, $name )
	{
		$class_srvr = ( isset( MP_AdminPage::$err_mess[$name . '_pop3_server'] ) )   ? ' form-invalid' : '';
		$class_port = ( isset( MP_AdminPage::$err_mess[$name . '_pop3_port']   ) )   ? ' form-invalid' : '';
		$class_user = ( isset( MP_AdminPage::$err_mess[$name . '_pop3_username'] ) ) ? ' class="form-invalid"' : '';

		$out = '';

		$out .= '<tr class="mp_sep">' . "\r\n";
		$out .= '	<th class="thtitle">' . __( 'Pop3', 'MailPress' ) . '</th>' . "\r\n";
		$out .= '	<td></td>' . "\r\n";
		$out .= '</tr>' . "\r\n";
		$out .= '<!-- Pop3 server -->' . "\r\n";
		$out .= '<!-- Pop3 port -->' . "\r\n";
		$out .= '<tr>' . "\r\n";
		$out .= '	<th><label for="' . $name . '_pop3_server">' . __( 'Pop3 Server', 'MailPress' ) . '</label></th>' . "\r\n";
		$out .= '	<td class="field">' . "\r\n";
		$out .= '		<input type="text" name="' . $name . '[pop3][server]" value="' . ( $config['pop3']['server'] ?? '' ) . '" class="regular-text code' . $class_srvr . '" id="' . $name . '_pop3_server" /> ' . "\r\n";
		$out .= __( 'Port', 'MailPress' ) . "\r\n";
		$out .= '		<input type="text" name="' . $name . '[pop3][port]" value="'   . ( $config['pop3']['port']   ?? '' ) . '" class="small-text'        . $class_port . '" />' . "\r\n";
		$out .= '	</td>' . "\r\n";
		$out .= '</tr>' . "\r\n";
		$out .= '<!-- Pop3 username -->' . "\r\n";
		$out .= '<tr' . $class_user . '>' . "\r\n";
		$out .= '	<th><label for="' . $name . '_pop3_username">' . __( 'Login Name', 'MailPress' ) . '</label></th>' . "\r\n";
		$out .= '	<td class="field">' . "\r\n";
		$out .= '		<input type="text" name="' . $name . '[pop3][username]" value="' . ( $config['pop3']['username'] ?? '' ) . '" class="regular-text ltr" id="' . $name . '_pop3_username" />' . "\r\n";
		$out .= '	</td>' . "\r\n";
		$out .= '</tr>' . "\r\n";
		$out .= '<!-- Pop3 pw -->' . "\r\n";
		$out .= '<tr>' . "\r\n";
		$out .= '	<th><label for="' . $name . '_pop3_password">' . __( 'Password', 'MailPress' ) . '</label></th>' . "\r\n";
		$out .= '	<td>' . "\r\n";
		$out .= '		<input type="password" name="' . $name . '[pop3][password]" value="' . ( $config['pop3']['password'] ?? '' ) . '" class="regular-text ltr" id="' . $name . '_pop3_password" />' . "\r\n";
		$out .= '	</td>' . "\r\n";
		$out .= '</tr>' . "\r\n";

		echo $out;
	}

	public static function pop3_help()
	{
		$content = '';

		// POP3 settings
		$content .= '<tr><th><span>';
		$content .= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://en.wikipedia.org/wiki/Post_Office_Protocol', 'POP3' );
		$content .= '</span></th><td>';
		$content .= __( 'To enable access to the dedicated privacy mailbox.', 'MailPress' ); 
		$content .= __( ' All these informations should be provided by your mail server.', 'MailPress' );
		$content .= '</td></tr>';

		return $content;
	}
}