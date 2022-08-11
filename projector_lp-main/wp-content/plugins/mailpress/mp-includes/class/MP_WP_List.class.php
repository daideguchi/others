<?php
abstract class MP_WP_List
{
	public static function _get_object_class( $object_type )
	{
		return self::_get_that( $object_type, 'class' );
	}

	public static function _get_object_file( $object_type )
	{
		return self::_get_that( $object_type, 'file' );
	}

	public static function _get_object_dims( $object_type )
	{
		return self::_get_that( $object_type, 'dims' );
	}

	public static function _get_that( $object_type, $id )
	{
		$those = array( 	'user' => array( 'class' => 'MP_User', 'file' => 'users', 'dims' => array( 'unsubscribed' => 'waiting', 'waiting' => 'active', 'active' => 'waiting', 'bounced' => 'waiting' )),
						'mail' => array( 'class' => 'MP_Mail', 'file' => 'mails', 'dims' => array( 'sent' => 'archived', 'archived' => 'sent' ), ),
		);

		return $those[$object_type][$id] ?? false;
	}

	public static function add_object( $object_type )
	{
		$_object_class = self::_get_object_class( $object_type );

		require_once( MP_ABSPATH . 'mp-admin/' . self::_get_object_file( $object_type ) . '.php' );

		$url_parms = MP_AdminPage::get_url_parms();
		$url_parms['paged'] = $url_parms['paged'] ?? 1;
		$_per_page = MP_AdminPage::get_per_page();
		$start = ( $url_parms['paged'] - 1 ) * $_per_page;

		list( $objects, $total ) = MP_AdminPage::get_list( array( 'start' => $start, '_per_page' => 1, 'url_parms' => $url_parms ) );

		if ( !$objects ) MP_::mp_die( 1 );

		$x = new WP_Ajax_Response();
		foreach ( ( array ) $objects as $object ) 
		{
			$_object_class::get( $object );
			$html = MP_AdminPage::get_row( $object->id, $url_parms, false );

			$x->add( array( 
				'what' 	=> $object_type, 
				'id' 		=> $object->id, 
				'data' 	=> $html
			 ) );
		}
		$x->send();
	}

	public static function dim_object( $object_type ) 
	{
		$_object_class = self::_get_object_class( $object_type );
		$_object_dims  = self::_get_object_dims( $object_type );

		require_once( MP_ABSPATH . 'mp-admin/' . self::_get_object_file( $object_type ) . '.php' );

		$url_parms 	= MP_AdminPage::get_url_parms();

   		$id = ( int ) MP_WP_Ajax::$pst_['id'] ?? 0;
   		$status = $_object_class::get_status( $id );

		if ( !isset( $_object_dims[$status] ) ) MP_::mp_die();
		if ( !$_object_class::set_status( $id, $_object_dims[$status] ) ) MP_::mp_die( -1 );
        
		$html = MP_AdminPage::get_row( $id, $url_parms );

		$xml = "<rc><![CDATA[0]]></rc><id><![CDATA[$id]]></id><item><![CDATA[$html]]></item><old_status><![CDATA[$status]]></old_status><new_status><![CDATA[" . $_object_dims[$status] . "]]></new_status>"; 

		ob_end_clean();
		header( 'Content-Type: text/xml' );
		MP_::mp_die( "<?xml version='1.0' standalone='yes'?><mp_action>$xml</mp_action>" );
	}

	public static function delete_object( $object_type ) 
	{
		$_object_class = self::_get_object_class( $object_type );

		$id = ( int ) MP_WP_Ajax::$pst_['id'] ?? 0;
		MP_::mp_die( $_object_class::set_status( $id, 'delete' ) ? 1 : 0 );
	}
}