<?php

if ( !defined( 'ABSPATH' ) ) {
     exit;
}

if ( ! function_exists( 'st_is_ver' ) ) {
	function st_is_ver( $prefix, $ver = null, $operator = null ) {
		$prefix      = strtolower( $prefix );
		$current_ver = defined( 'AFFINGER_TYPE' ) ? strtolower( AFFINGER_TYPE ) : '';

		if ( strpos( $current_ver, $prefix ) !== 0 ) {
			return false;
		}

		if ( $ver !== null ) {
			$ver      = (string) $ver;
			$operator = ( $operator !== null ) ? $operator : '==';
		} else {
			$ver      = '';
			$operator = ( $operator !== null ) ? $operator : '>=';
		}

		return (bool) version_compare( $current_ver, $prefix . $ver, $operator );
	}
}

if ( ! function_exists( 'st_is_ver_ex' ) ) {
	function st_is_ver_ex( $ver = null, $operator = null ) {
		return st_is_ver( 'EX', $ver, $operator );
	}
}

if ( ! function_exists( 'st_is_ver_af' ) ) {
	function st_is_ver_af( $ver = null, $operator = null ) {
		return st_is_ver( 'AF', $ver, $operator );
	}
}

if ( ! function_exists( 'st_is_ver_st' ) ) {
	function st_is_ver_st( $ver = null, $operator = null ) {
		return st_is_ver( 'ST', $ver, $operator );
	}
}

if ( ! function_exists( 'st_is_ver_ex_af' ) ) {
	function st_is_ver_ex_af( $ex_ver = null, $ex_operator = null, $af_ver = null, $af_operator = null ) {
		return ( st_is_ver_ex( $ex_ver, $ex_operator ) || st_is_ver_af( $af_ver, $af_operator ) );
	}
}
