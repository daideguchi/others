<?php
class MP_Swift_Pop3
{
	const bt = 132;

	var $pop3 = null;

	function __construct( $server, $port, $username, $password, $trace = false )
	{
		$this->server 	= $server;
		$this->port 	= ( int ) $port;
		$this->username 	= $username;
		$this->password 	= $password;
		$this->trace	= $trace;
	}

	function fetch() { return fgets( $this->pop3, 1024 ); }

	function fetch_all()
	{
		$response = $f = '';

		$f = $this->fetch();
		if ( !empty( $f ) )
		{
			while ( !preg_match( "#^\.\r\n#", $f ) )
			{
				if ( $f[0] == '.' ) $f = substr( $f,1 );
				$response .= $f;
				$f = $this->fetch();
		            if ( empty( $f ) ) break;
			}
		}
		return $response;
	}

	function get_response( $cmd = false )
	{
		if ( $cmd )
		{
			fwrite( $this->pop3, "$cmd\r\n" );
			if ( $this->trace )
			{
				if ( 'PASS ' == substr( $cmd, 0, 5 ) ) $cmd = 'PASS ' . str_repeat( '*', strlen( $cmd ) - 5 );
				$bm = " POP cmd    ! $cmd";
				$this->trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );
			}
		}
		
		$response = '';
		do { $response .= $this->fetch(); } while( "\n" != substr( $response, -1 ) );
		if ( $this->trace )
		{
			$bm = " response   ! " . str_replace( "\r\n", '', $response );
			$this->trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );
		}

		if ( ( 'QUIT' == $cmd ) && ( '.' == $response[0] ) ) 	return $response;
		if ( '+' == $response[0] ) 					return $response;

		$bm = " end        ! Abort";
		$this->trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );
		return false;
	}

	function connect()
	{
	// fsockopen 
		$this->pop3 = fsockopen( $this->server, $this->port, $errno, $errstr );

		if ( false === $this->pop3 ) 
		{
			if ( $this->trace )
			{
				if ( empty( $errstr ) ) { $errno = '*'; $errstr = 'Unable to connect to ' . $this->server .  ':' . $this->port; }
				$bm = "*** ERROR **! $errno $errstr";
				$this->trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );
				$bm = " end        ! Abort";
				$this->trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );
			}
			return false;
		}

		$response = $this->get_response();
		if ( !$response ) return false;
	// USER 
		$response = $this->get_response( 'USER ' . $this->username );
		if ( !$response ) return false;
	// PASS 
		$response = $this->get_response( 'PASS ' . $this->password );
		if ( !$response ) return false;

		return true;
	}

	function get_list()
	{
		$this->messages = array();
	
		$response = $this->get_response( 'LIST' );
		if ( !$response ) return false;

		$r = explode( ' ', $response );
		if ( !$r[1] )	return false; // list is empty

		if ( $string = $this->fetch() ) do { $datas = explode( ' ', $string ); $this->messages[] = $datas[0]; $string = $this->fetch(); } while( ".\r\n" != substr( $string, -3 ) );
		return true;
	}

	function get_headers( $id, $headers = array() )
	{
		$this->headers = array();
		$response = $this->get_response( "TOP $id 0" );
		if ( !$response ) return false;

		$this->message = $this->fetch_all();

		$this->extract_headers( $this->message, $headers );
	}

	function get_headers_deep( $id, $headers = array() )
	{
		$this->headers = array();
		$response = $this->get_response( "TOP $id 300" );
		if ( !$response ) return false;

		$this->message = $this->fetch_all();

		$this->extract_headers( $this->message, $headers );
	}

	function extract_headers( $string, $headers = array() )
	{
		$raw_headers = preg_replace( "/\r\n[ \t]+/", ' ', $string ); // Unfold headers
		$raw_headers = explode( "\r\n", $raw_headers );
		$this->headers = array();
		foreach ( $raw_headers as $value ) 
		{
			if ( '' == $value ) continue;
			$k = substr( $value, 0, $pos = strpos( $value, ':' ) );
			$v = ltrim( substr( $value, $pos + 1 ) );
			if ( empty( $k ) ) continue;
			if ( '' == $v )  continue;
			if ( empty( $headers ) || in_array( $k, $headers ) ) $this->headers[$k][] = $v;
		}
		if ( !empty( $headers ) ) $this->sort_headers( $headers );
	}

	function sort_headers( $headers )
	{
		$sort = array_flip( $headers );
		$keys = array_intersect_key( $sort, $this->headers );
		$this->headers = array_merge( $keys, array_intersect_key( $this->headers, $keys ), array_diff_key( $this->headers, $sort ) );
	}

	function get_header( $header, $numeric = false, $item = 0 )
	{
		$this->header = false;

		if ( isset( $this->headers[$header][$item] ) )
		{
			if ( $numeric && is_numeric( $this->headers[$header][$item] ) ) 
			{
				$this->header = trim( $this->headers[$header][$item] );
			}
			elseif ( !$numeric )
			{
				$items = imap_mime_header_decode( $this->headers[$header][$item] );
				$header = '';
				foreach( $items as $item ) $header .= ' ' . $item->text;
				$this->header = trim( $header );
			}
		}

		return $this->header;
	}

	function get_body( $length = 8192 )
	{
		$body = ( $length ) ? substr( $this->message, 0, $length ) : $this->message;
                        
		// Microsoft Exchange Base 64 decoding
		if ( preg_match( '/\r?\n(.*?)\r?\nContent-Type\:\s*text\/plain.*?Content-Transfer-Encoding\:\sbase64\r?\n\r?\n(.*?)\1/is', $body, $matches ) )
			$body = str_replace( $matches[2], base64_decode( str_replace( array( "\n", "\r" ), '', $matches[2] ) ), $body );
                        
		// clean up
		$body = preg_replace( '%--- Below this line is a copy of the message.(.*)%is', '', $body );
		$body = preg_replace( '%------ This is a copy (.*)%is', '', $body );
		$body = preg_replace( '%----- Original message -----(.*)%is', '', $body ); 
		$body = preg_replace( '%Content-Type: message/rfc822.*%is', '', $body );
		$body = preg_replace( '%Content-Description: Delivery report.*\s*?%i', '', $body );
		$body = str_replace( "\r", "", $body );
		$body = str_replace( array( "\n", "\r" ), " ", $body );
		$body = preg_replace( '%\s+%', ' ', $body );

		return $body;
	}

	function get_message( $id )
	{
		$response = $this->get_response( 'RETR ' . $id );
		if ( !$response ) return false;

		$this->message = $this->fetch_all();
	}

	function delete( $id )
	{
		$response = $this->get_response( 'DELE ' . $id );
		if ( !$response ) return false;
	}

	function disconnect()
	{
		$response = $this->get_response( 'QUIT' );
		fclose( $this->pop3 );
		if ( $this->trace )
		{
			$bm = "disconnected!";
			$this->trace->log( '!' . $bm . str_repeat( ' ', self::bt - strlen( $bm ) ) . '!' );
		}
		return true;
	}
}