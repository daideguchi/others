<?php
class MP_Log
{
	const noMP_Log	= 123456789;

	function __construct( $name, $args = array() )
	{
		$this->errors = self::get_defined_constants( false );

		$defaults = array( 	'path'		=> MP_UPL_ABSPATH,
						'force'		=> false,
						'option_name'	=> 'general',
		);
		$r = wp_parse_args( $args, $defaults );
		extract( $r );

		$this->name 	= $name;
		$this->path 	= $path . 'log';
		$this->option_name= $option_name;

		$this->ftmplt	= 'MP_Log' . '_' . get_current_blog_id() . '_' . $this->name . '_';

		$this->file 	= $this->path . '/' . $this->ftmplt . gmdate( 'Ymd', current_time( 'timestamp' ) ) . '.txt';

		$this->log_options = self::get_option( $this->option_name );

		$this->level = (int) ( $force ) ? 0 : $this->log_options['level'];
		foreach( $this->errors as $k => $v ) { $this->levels[$k] = ( $force ) ? 0 : $k; }

		if ( !is_dir( $this->path ) ) $this->level = self::noMP_Log;
		if ( self::noMP_Log == $this->level ) return;

		if ( 0  != $this->level ) set_error_handler( array( $this, 'logError' ), $this->level );

		$this->start( $force );
	}

	function start( $force = false )
	{
		$plugin_version = ' | (' . MP_Version . ')';

		$REQUEST_URI = '';
		$REQUEST_URI = filter_input( INPUT_SERVER, 'REQUEST_URI' );

		$HTTP_USER_AGENT = '';
		$HTTP_USER_AGENT = filter_input( INPUT_SERVER, 'HTTP_USER_AGENT' );

		$this->data = "\n";

		if ( $force ) 
		{
			$this->log ( " >>> Start | {$this->name} | log forced$plugin_version" );
		}
		elseif ( !empty( $REQUEST_URI ) )
		{
			$this->log ( " >>> Start | {$this->name} | level : {$this->level}$plugin_version | $REQUEST_URI" );
			//$this->log ( " >>>       | {$this->name} | useragent : $HTTP_USER_AGENT" );
		}
		else
		{
			$this->log ( " >>> Start | {$this->name} | level : {$this->level}$plugin_version" );
		}

// purge log
		$this->dopurge();

		ob_start();
	}

	function restart()
	{
		$this->stop();
		$this->data = "";
		ob_start();
	}

	function log( $x, $level=0 )
	{
		if ( stripos( $x, 'simplepie' ) == true ) return;
		if ( strpos( $x, ' WP_Http' ) == true )   return;

		if ( self::noMP_Log    == $this->level ) return;
		if ( $level <= $this->level ) $this->data .= wp_date( 'Y-m-d H:i:s' ) . " -- " . $x . "\n";
	}

	function logError( $error_level, $error_message, $error_file, $error_line )
	{ 
		if ( strpos( $error_message, 'Please use the instanceof operator' ) == true ) return;
		$this->log ( "PHP [" . $this->errors[$error_level] . "] $error_level : $error_message in $error_file at line $error_line ", $error_level );
	}

	function stop()
	{
			if ( self::noMP_Log == $this->level ) return;
			if ( 0   != $this->level ) restore_error_handler();

			$log = ( ob_get_length() ) ? ob_get_contents() : '';
		if ( ob_get_length() ) ob_end_clean();
		if ( !empty( $log ) ) $this->log( $log );

		$this->fh = fopen( $this->file , 'a+' );
		fputs( $this->fh, $this->data ); 
		fclose( $this->fh ); 
	}

	function end( $y = true )
	{
			if ( self::noMP_Log == $this->level ) return;
			if ( 0   != $this->level ) restore_error_handler();

			$log = ( ob_get_length() ) ? ob_get_contents() : '';
		if ( ob_get_length() ) ob_end_clean();
		if ( !empty( $log ) ) $this->log( $log );

		$y = ( $y ) ? "TRUE" : "FALSE";
		$this->log ( " <<< End   | {$this->name} | level : $this->level | status : $y " );

		$this->fh = fopen( $this->file , 'a+' );
		fputs( $this->fh, $this->data ); 
		fclose( $this->fh ); 

// mem'ries ...
		$xs = array( 	'this->data', 'this->errors', 'this->name', 'this->path', 'this->plug', 'this->ftmplt', 'this->level', 'this->levels', 'this->lastpurge', 'this->lognbr' );
		foreach ( $xs as $x ) if ( isset( $$x ) ) unset( $$x );
	}

	function dopurge()
	{
		$now = wp_date( 'Ymd' );
		$this->lastpurge= $this->log_options['lastpurge']      ?? $now;
		$this->lognbr 	= ( int ) $this->log_options['lognbr'] ?? 1;

		if ( $now == $this->lastpurge ) return;

		$this->log_options['lastpurge'] = $now;
		$this->log_options['lognbr']    = $this->lognbr;

		self::update_option( $this->option_name, $this->log_options );

		$xs = array();
		$l = opendir( $this->path );
		if ( $l ) 
		{
			while ( ( $file = readdir( $l ) ) !== false ) if ( preg_match( '#' . $this->ftmplt . '[0-9]#', $file ) ) $xs[] = $file;
			@closedir( $l );
		}

		sort( $xs );
		$y = count( $xs ) - $this->lognbr + 1;

		while ( $y > 0 )
		{
			@unlink( $file = $this->path . '/' . array_shift( $xs ) );
			$this->log ( " **** Purged log file **** " . $file );
			$y--;
		}
	}

	function debug_backtrace()
	{
		$calls = debug_backtrace();
		array_shift( $calls );		// we know who we are !

		$debug_backtrace = array();

		foreach( $calls as $call ) 
		{
			$x = array( 'class' => null, 'function' => null );
			foreach( $x as $k => $v )
			{
				$x[$k] = $call[$k] ?? null;
			}
			$debug_backtrace[] = implode( '/', $x );
		}
		return $debug_backtrace;
	}

	public static function get_defined_constants( $s = true )
	{
		$x = (!$s) ? array() : 	array(	123456789	=> __( 'No logging', 'MailPress' ) , 
									0		=> __( 'simple log', 'MailPress' )
							);

		$f = array();
		$e = get_defined_constants(true);
		$e = $e['Core'];
		foreach( $e as $k => $v)
		{
			if ('E_' == substr($k, 0, 2)) $f[$v] = $k;
		}
		ksort( $f );
		$z = $x + $f;

		return $z;
	}

	public static function get_option( $name )
	{
		$options = get_option( MailPress::option_name_logs );
                if ( !isset( $options[$name] ) )
                {
                    self::set_option( $name );
                    return MailPress::$default_option_logs;
                }
                $option = $options[$name];
                $option['level'] = (int) $option['level'];

                $errors = self::get_defined_constants();
                if ( !isset( $errors[$option['level']] ) ) $option['level'] = (int) MailPress::$default_option_logs['level'];
                return $option;
	}
        
        public static function update_option( $name, $option )
	{
		$logs = get_option( MailPress::option_name_logs );
		$option['level'] = (int) $option['level'];
		$logs[$name] = $option;
		update_option ( MailPress::option_name_logs, $logs );
	}
        
        public static function set_option( $name )
	{
		$logs = get_option( MailPress::option_name_logs );
		if ( !isset( $logs[$name] ) )
		{
			$logs[$name] = MailPress::$default_option_logs;
			update_option( MailPress::option_name_logs, $logs );
		}
	}
}