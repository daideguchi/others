<?php
define( 'ST_UPDATE_API_URL', 'http://stupdate.com/api' );
define( 'ST_UPDATE_API_TIMEOUT', 10 );
define( 'ST_UPDATE_CHILD_THEMES', true );

if ( ! function_exists( 'st_update_get_api_key' ) ) {
	function st_update_get_api_key() {
		return (string) get_option( 'st-data265', '' );
	}
}

if ( ! function_exists( 'st_update_is_enabled' ) ) {
	function st_update_is_enabled() {
		return ( get_option( 'st-data401', 'yes' ) === 'yes' );
	}
}

if ( ! function_exists( 'st_update_get_theme_header' ) ) {
	function st_update_get_theme_header( $stylesheet ) {
		$theme = wp_get_theme( $stylesheet );

		$file_headers = array(
			'Name',
			'ThemeURI',
			'Description',
			'Author',
			'AuthorURI',
			'Version',
			'Template',
			'Status',
			'Tags',
			'TextDomain',
			'DomainPath',
		);

		$headers = array();

		foreach ( $file_headers as $file_header ) {
			$headers[ $file_header ] = $theme->get( $file_header );
		}

		return $headers;
	}
}

if ( ! function_exists( 'st_update_api_get' ) ) {
	function st_update_api_get( array $query_args = array() ) {
		$apiKey = st_update_get_api_key();

		if ( $apiKey === '' ) {
			return new WP_Error( 'API key is not set.' );
		}

		$keyHash = password_hash( $apiKey, PASSWORD_BCRYPT );

		if ( $keyHash === false ) {
			return new WP_Error( 'st_update_password_hash_error', 'Cannot create a password hash.' );
		}

		$defaults = array(
			'api_key' => $keyHash,
		);

		$query_args = array_merge( $defaults, $query_args );
		$url        = add_query_arg( $query_args, ST_UPDATE_API_URL );

		$options = array(
			'timeout' => ST_UPDATE_API_TIMEOUT,
			'headers' => array(
				'Accept' => 'application/json',
			),
		);

		$result = wp_remote_get( $url, $options );

		if ( is_wp_error( $result ) ) {
			return new WP_Error( $result->get_error_code(), $result->get_error_message() );
		}

		/** @var WP_HTTP_Requests_Response $response */
		$response = $result['http_response'];

		$status_code = $response->get_status();

		if ( $status_code === null ) {
			return new WP_Error( 'st_update_no_http_status_code', 'The response has no HTTP status code.' );
		}

		if ( $status_code !== 200 ) {
			return new WP_Error(
				'st_update_unexpected_http_status_code',
				get_status_header_desc( $status_code ),
				array( 'status' => $status_code )
			);
		}

		$body = $response->get_data();

		$json = json_decode( $body );

		if ( $json === null ) {
			return new WP_Error( 'st_update_json_decode_error', 'Cannot decode the response body as a JSON.' );
		}

		return $json;
	}
}

if ( ! function_exists( 'st_update_check_update' ) ) {
	function st_update_check_update( $stylesheet, $updates ) {
		$headers = st_update_get_theme_header( $stylesheet );

		$query_args = array(
			'action'  => 'theme_update',
			'name'    => $stylesheet,
			'version' => $headers['Version'],
		);

		$response = st_update_api_get( $query_args );

		if ( is_wp_error( $response ) || count( (array) $response ) === 0 ) {
			if ( isset( $updates, $updates->response ) ) {
				unset( $updates->response[ $stylesheet ] );
			}

			return $updates;
		}

		$update = array(
			'theme'       => $response->name,
			'new_version' => $response->version,
			'url'         => $response->homepage,
			'package'     => $response->archive,
		);

		if ( ! is_object( $updates ) ) {
			$updates           = new stdClass();
			$updates->response = array();
		}

		$updates->response[ $stylesheet ] = $update;

		return $updates;
	}
}

if ( ! function_exists( 'st_update_get_child_themes' ) ) {
	function st_update_get_child_themes( $stylesheet ) {
		$cache = array();

		$cacheKey = hash( 'sha256', serialize( func_get_args() ) );

		if ( isset( $cache[ $cacheKey ] ) ) {
			return $cache[ $cacheKey ];
		}

		$targetTheme = wp_get_theme( $stylesheet );

		if ( $targetTheme->parent() !== false ) {
			$cache[ $cacheKey ] = array();

			return array();
		}

		$themes = wp_get_themes( array( 'errors' => null ) );
		$themes = array_filter(
			$themes,
			function ( $theme ) use ( $stylesheet ) {
				/** @var WP_Theme $theme */
				$_template   = $theme->get_template();
				$_stylesheet = $theme->get_stylesheet();

				return ( $_stylesheet !== $_template && $_template === $stylesheet );
			}
		);

		$cache[ $cacheKey ] = $themes;

		return $themes;
	}
}

if ( ! function_exists( 'st_update_check_updates' ) ) {
	function st_update_check_updates( $updates ) {
		static $cache = null;

		if ( $cache !== null ) {
			return $cache;
		}

		$template = get_template();
		$updates  = st_update_check_update( $template, $updates );

		if ( ST_UPDATE_CHILD_THEMES ) {
			/** @var WP_Theme $theme */
			foreach ( st_update_get_child_themes( $template ) as $theme ) {
				$updates = st_update_check_update( $theme->get_stylesheet(), $updates );
			}
		}

		$cache = $updates;

		return $updates;
	}
}

if ( st_update_is_enabled() ) {
	add_filter( 'site_transient_update_themes', 'st_update_check_updates' );
}

if ( ! function_exists( 'st_update_allow_external_host' ) ) {
	function st_update_allow_external_host( $allow, $host, $url ) {
		static $api_host = null;

		if ( $api_host === null ) {
			$api_host = parse_url( ST_UPDATE_API_URL, PHP_URL_HOST );
		}

		if ( is_string( $api_host ) && ( strtolower( $host ) === strtolower( $api_host ) ) ) {
			return true;
		}

		return $allow;
	}
}

if ( st_update_is_enabled() ) {
	add_filter( 'http_request_host_is_external', 'st_update_allow_external_host', 10, 3 );
}
