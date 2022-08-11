<?php
class MP_WP_Meta
{
	public static function _get_called_class()
	{
		return get_called_class();
	}

	public static function _get_meta_table()
	{
		global $wpdb;
		$tables = array ( 'mail' => $wpdb->mp_mailmeta, 'user' => $wpdb->mp_usermeta, );

		$_class = self::_get_called_class();

		return $tables[$_class::object_type];
	}

	public static function _get_meta_column()
	{
		$_class = self::_get_called_class();

		return 'mp_' . $_class::object_type . '_id';
	}


	public static function add( $object_id, $meta_key = false, $meta_value, $unique = false ) 
	{
		$meta_table  = self::_get_meta_table();
		$meta_column = self::_get_meta_column();

		if ( !is_numeric( $object_id ) || !$meta_key || !$meta_table ) return false;

		$data[$meta_column] = $object_id;								$format[] = '%d';
		$data['meta_key']   = stripslashes( $meta_key );					$format[] = '%s';
		$data['meta_value'] = maybe_serialize( stripslashes_deep( $meta_value ) );	$format[] = '%s';

		global $wpdb;

		if ( $unique && $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( * ) FROM $meta_table WHERE meta_key = %s AND $meta_column = %d", $data['meta_key'], $data[$meta_column] ) ) )
		return false;

		$wpdb->insert( $meta_table, $data, $format );

		return $wpdb->insert_id;
	}

	public static function update( $object_id, $meta_key = false, $meta_value = '', $prev_value = '' ) 
	{
		$meta_table  = self::_get_meta_table();
		$meta_column = self::_get_meta_column();

		if ( !is_numeric( $object_id ) || !$meta_key || !$meta_table ) return false;

		$data['meta_value']  = maybe_serialize( stripslashes_deep( $meta_value ) );$format[] = '%s';

		$where[$meta_column] = $object_id;								$where_format[] = '%d';
		$where['meta_key']   = stripslashes( $meta_key );					$where_format[] = '%s';
		if ( !empty( $prev_value ) ) {
			$where['meta_value']  = maybe_serialize( $prev_value );			$where_format[] = '%s';
		}

		global $wpdb;
		$wpdb->update( $meta_table, $data, $where, $format, $where_format );

		return true;
	}

	public static function delete( $object_id, $meta_key = false , $meta_value = '' ) 
	{
		$meta_table  = self::_get_meta_table();
		$meta_column = self::_get_meta_column();

		if ( !is_numeric( $object_id ) || !$meta_table ) return false;

		$meta_key   = stripslashes( $meta_key );
		$meta_value = maybe_serialize( stripslashes_deep( $meta_value ) );

		global $wpdb;

		if ( !empty( $meta_value ) ) 	$wpdb->query( $wpdb->prepare( "DELETE FROM $meta_table WHERE $meta_column = %d AND meta_key = %s AND meta_value = %s", $object_id, $meta_key, $meta_value ) );
		elseif ( $meta_key ) 			$wpdb->query( $wpdb->prepare( "DELETE FROM $meta_table WHERE $meta_column = %d AND meta_key = %s", $object_id, $meta_key ) );
		else  					$wpdb->query( $wpdb->prepare( "DELETE FROM $meta_table WHERE $meta_column = %d", $object_id ) );

		return true;
	}

	public static function get( $object_id, $meta_key = false, $meta_value = '' ) 
	{
		$meta_table  = self::_get_meta_table();
		$meta_column = self::_get_meta_column();

		if ( !is_numeric( $object_id ) || !$meta_table ) return false;

		global $wpdb;

		if ( $meta_key ) 
		{
			if ( empty( $meta_value ) ) 
				$metas = $wpdb->get_col( $wpdb->prepare( "SELECT meta_value FROM $meta_table WHERE $meta_column = %d AND meta_key = %s", $object_id, $meta_key ) );
			else
				$metas = $wpdb->get_col( $wpdb->prepare( "SELECT meta_value FROM $meta_table WHERE $meta_column = %d AND meta_key = %s AND meta_value = %s", $object_id, $meta_key, $meta_value ) );
		}
		else
		{
			$metas = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM $meta_table WHERE $meta_column = %d", $object_id ) );
		}

		if ( empty( $metas ) ) return ( empty( $meta_key ) ) ? array() : '';

		$metas = array_map( 'maybe_unserialize', $metas );

		if ( count( $metas ) == 1 ) 	return $metas[0];
		else					return $metas;
	}


	public static function has( $object_id , $meta_key = false ) 
	{
		$meta_table  = self::_get_meta_table();
		$meta_column = self::_get_meta_column();

		if ( !is_numeric( $object_id ) || !$meta_table ) return false;

		global $wpdb;

		$x = ( $meta_key ) ? "AND meta_key = '".$meta_key."'" : ''; 

		return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $meta_table WHERE $meta_column = %d $x ORDER BY meta_key, meta_id", $object_id ), ARRAY_A );
	}


	public static function update_by_id( $meta_id, $meta_key, $meta_value ) 
	{
		$meta_table  = self::_get_meta_table();

		if ( !is_numeric( $meta_id ) || !$meta_table ) return false;

		$data['meta_value'] = maybe_serialize( stripslashes_deep( $meta_value ) );	$format[] = '%s';
		$data['meta_key']   = stripslashes( $meta_key );					$format[] = '%s';

		$where['meta_id']   = $meta_id;									$where_format[] = '%d';

		global $wpdb;
		$wpdb->update( $meta_table, $data, $where, $format, $where_format );

		return true;
	}

	public static function delete_by_id( $meta_id ) 
	{
		$meta_table  = self::_get_meta_table();

		if ( !is_numeric( $meta_id ) || !$meta_table ) return false;

		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM $meta_table WHERE meta_id = %d", $meta_id ) );

		return true;
	}

	public static function get_by_id( $meta_id ) 
	{
		$meta_table  = self::_get_meta_table();

		if ( !is_numeric( $meta_id ) || !$meta_table ) return false;

		global $wpdb;
		$meta = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $meta_table WHERE meta_id = %d", $meta_id ) );
		if ( $meta )	$meta->meta_value = maybe_unserialize( $meta->meta_value );

		return $meta;
	}


	public static function get_replacements( $object_id )
	{
		if ( !is_numeric( $object_id ) ) return array();

		$metas = self::get( $object_id );

		if ( !$metas ) return array();
		if ( !is_array( $metas ) ) $metas = array( $metas );

		$replacements = array();
		foreach ( $metas as $meta )
		{
			if ( $meta->meta_key[0] == '_' ) continue;
			$replacements['{{' . $meta->meta_key . '}}'] = $meta->meta_value;
		}
		
		$_class = self::_get_called_class();

		return apply_filters( 'MailPress_replacements_' . $_class::object_type, $replacements );
	}


	public static function add_meta( $object_id )
	{
		$_class = self::_get_called_class();

		$object_id = ( int ) $object_id;

		$post_ = filter_input_array( INPUT_POST );

		$metakeyselect 	= isset( $post_['metakeyselect'] ) ? trim( $post_['metakeyselect'] ) : '';
		$metakeyinput 	= isset( $post_['metakeyinput'] )  ? trim( $post_['metakeyinput'] )  : '';
		$meta_value 	= isset( $post_['metavalue'] )     ? trim( $post_['metavalue'] )     : '';

		if ( ( '0' === $meta_value || !empty( $meta_value ) ) && ( ( ( '#NONE#' != $metakeyselect ) && !empty( $metakeyselect ) ) || !empty( $metakeyinput ) ) )
		{
			// We have a key/value pair. If both the select and the
			// input for the key have data, the input takes precedence:

			if ( '#NONE#' != $metakeyselect )				$meta_key = $metakeyselect;
			if ( $metakeyinput )							$meta_key = $metakeyinput; // default
			if ( in_array( $meta_key, $_class::get_protected() ) )	return false;

			return self::add( $object_id, $meta_key, $meta_value );
		}
		return false;
	}
}