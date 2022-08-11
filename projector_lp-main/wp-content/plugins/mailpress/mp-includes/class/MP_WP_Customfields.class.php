<?php
abstract class MP_WP_Customfields
{
	public static function _get_called_class()
	{
		return get_called_class();
	}

	public static function _get_meta_class()
	{
		return self::_get_that( 'class' );
	}

	public static function _get_object_id_name()
	{
		return self::_get_that( 'id' );
	}

	public static function _get_that( $id )
	{
		$those = array( 	'user' => array( 'class' => 'MP_User_meta', 'id' => 'mp_user_id', ),
						'mail' => array( 'class' => 'MP_Mail_meta', 'id' => 'mail_id'   , ),
		);

		$_class = self::_get_called_class();

		return $those[$_class::object_type][$id] ?? false;
	}

	public static function meta_box_browse_customfields( $object )
	{
		$_meta_class = self::_get_meta_class();
		$_class      = self::_get_called_class();

		$metas = $_meta_class::get( $object->id );

		$out = '';
		$out .= '<div id="' . $_class::object_type . '-import">' . "\r\n";

		if ( $metas )
		{
			if ( !is_array( $metas ) ) $metas = array( $metas );

			foreach ( $metas as $k => $meta )
			{
				if ( $meta['meta_key'][0] == '_' ) 		unset( $metas[$k] );
				if ( 'batch_send' == $meta['meta_key'] )	unset( $metas[$k] );
			}

			if ( $metas )
			{
				$out .= '<table class="form-table">' . "\r\n";
				$out .= '<thead><tr><td class="cf-std"></td><td class="cf-kv"><b>' . __( 'Key' ) . '</b></td><td class="cf-kv"><b>' . __( 'Value' ) . '</b></td></tr></thead>' . "\r\n";
				$out .= '<tbody>' . "\r\n";

				foreach ( $metas as $entry )
				{
					$out .= '<tr><td class="cf-std"></td><td class="cf-v"><input type="text" disabled="disabled" value="' . esc_attr( $entry['meta_key'] ) . '" /></td><td class="cf-v"><input type="text" disabled="disabled" value="' . esc_attr( $entry['meta_value'] ) . '" /></td></tr>' . "\r\n";
				}

				$out .= '<tr><td class="cf-std">&#160;</td><td class="cf-std"></td><td class="cf-std"></td></tr>' . "\r\n";
				$out .= '</tbody>' . "\r\n";
				$out .= '</table>' . "\r\n";
			}
			else
			{
				$out .= __( 'No meta data', 'MailPress' );
			}
		}

		$out .= '</div>' . "\r\n";

		echo $out;
	}
/**/
	public static function meta_box_customfields( $object )
	{
		$count = 0;

		global $wpdb;
		$keys = $wpdb->get_col( "SELECT meta_key FROM $wpdb->mp_mailmeta UNION SELECT meta_key FROM $wpdb->mp_usermeta GROUP BY 1 ORDER BY 1 ASC LIMIT 30" );

		foreach ( $keys as $k => $v )
		{
			if ( $keys[$k][0] == '_' ) unset( $keys[$k] );
			if ( 'batch_send' == $v )  unset( $keys[$k] );
		}

		$_meta_class = self::_get_meta_class();
		$_class      = self::_get_called_class();

		$id = $object->id ?? '';
		$metas = $_meta_class::has( $id );

		$out = '';
		$out .= '<div id="postcustomstuff">' . "\r\n";
		$out .= '<div id="ajax-response"></div>' . "\r\n";

		if ( $metas )
		{
			if ( !is_array( $metas ) ) $metas = array( $metas );

			foreach ( $metas as $k => $meta )
			{
				if ( $meta['meta_key'][0] == '_' ) 		unset( $metas[$k] );
				if ( 'batch_send' == $meta['meta_key'] )	unset( $metas[$k] );
			}

			if ( $metas )
			{
				$out .= '<table id="list-table">' . "\r\n";
				$out .= '<thead><tr><th class="left">' . __( 'Name' ) . '</th><th>' . __( 'Value' ) . '</th></tr></thead>' . "\r\n";
				$out .= '<tbody id="the-list" class="list:' . $_class::object_type . 'meta">' . "\r\n";
				foreach ( $metas as $entry )
				{
					$out .= self::meta_box_customfield_row( $entry, $count ) . "\r\n";
				}
				$out .= '</tbody>' . "\r\n";
				$out .= '</table>' . "\r\n";
			}
			else
			{
				$out .= '<table id="list-table" class="hidden">' . "\r\n";
				$out .= '<thead><tr><th class="left">' . __( 'Name' ) . '</th><th>' . __( 'Value' ) . '</th></tr></thead>' . "\r\n";
				$out .= '<tbody id="the-list" class="list:' . $_class::object_type . 'meta">' . "\r\n";
				$out .= '<tr><td></td></tr>' . "\r\n";
				$out .= '</tbody>' . "\r\n";
				$out .= '</table>' . "\r\n";
			}
		}

		$out .= '<p><strong>' . __( 'Add New Custom Field:' ) . '</strong></p>' . "\r\n";

		$out .= '<table id="newmeta">' . "\r\n";
		$out .= '<thead><tr><th class="left"><label for="metakeyselect">' . __( 'Name' ) . '</label></th><th>	<label for="metavalue">' . __( 'Value' ) . '</label></th></tr></thead>' . "\r\n";
		$out .= '<tbody>' . "\r\n";
		$out .= '<tr><td id="newmetaleft" class="left">' . "\r\n";
		if ( $keys ) 
		{ 
			$out .= '<select name="metakeyselect" id="metakeyselect" tabindex="7"><option value="#NONE#">' . __( '- Select -' ) . '</option>';
			foreach ( $keys as $key ) 
			{
				$key = esc_attr( $key );
				$out .= '<option value="' . $key . '">' . $key . '</option>';
			}
			$out .= '</select>' . "\r\n";
			$out .= '<input type="text" name="metakeyinput" id="metakeyinput" class="hide-if-js" tabindex="7" value="" />';
			$out .= '<a href="#postcustomstuff" class="hide-if-no-js" onclick="jQuery( \'#metakeyinput, #metakeyselect, #enternew, #cancelnew\' ).toggle();return false;"><span id="enternew">' . __( 'Enter new' ) . '</span><span id="cancelnew" class="hidden">' . __( 'Cancel' ) . '</span></a>' . "\r\n";
		} 
		else 
		{
			$out .= '<input type="text" name="metakeyinput" id="metakeyinput" tabindex="7" value="" />' . "\r\n";
		}
		$out .= '</td><td><textarea name="metavalue" id="metavalue" tabindex="8" rows="2" cols="25"></textarea></td></tr>' . "\r\n";

		$out .= '<tr><td colspan="2"><div class="submit"><input type="submit" name="add' . $_class::object_type . 'meta" id="addmetasub" class="add:the-list:newmeta button" tabindex="9" value="' . __( 'Add Custom Field' ) . '" />' . wp_nonce_field( 'add-' . $_class::object_type . 'meta', '_ajax_nonce', false, false ) . '</div></td></tr>' . "\r\n";
		$out .= '</tbody>' . "\r\n";
		$out .= '</table>' . "\r\n";
		$out .= '</div>' . "\r\n";
		$out .= '<p>' . __( 'Custom fields can be used to customize your mails, see help above.', 'MailPress' ) . '</p>' . "\r\n";

		echo $out;
	}

	public static function meta_box_customfield_row( $entry, &$count )
	{
		if ( '_' == $entry['meta_key'] { 0 } )
		{
			return;
		}

		$_class      = self::_get_called_class();

		static $update_nonce = false;
		if ( !$update_nonce )
		{
			$update_nonce = wp_create_nonce( 'add-' . $_class::object_type . 'meta' );
		}

		++ $count;

		$style = ( $count % 2 ) ? ' class="alternate"' : '';
	
		$entry['meta_key'] 	= esc_attr( $entry['meta_key'] );
		$entry['meta_value'] 	= esc_attr( $entry['meta_value'] ); // using a <textarea />
		$entry['meta_id'] 	= ( int ) $entry['meta_id'];

		$delete_nonce 		= wp_create_nonce( 'delete-' . $_class::object_type . 'meta_' . $entry['meta_id'] );
		$out = '';
		$out .= '<tr id="' . $_class::object_type . 'meta-' . $entry['meta_id'] . '"' . $style . '>';
		$out .= '<td class="left">';
		$out .= '<!--<label class="hidden" for="' . $_class::object_type . '[' . $entry['meta_id'] . '][key]">' . __( 'Key' ) . '</label>-->';
		$out .= '<input type="text" name="' . $_class::object_type . 'meta[' . $entry['meta_id'] . '][key]" id="' . $_class::object_type . 'meta[' . $entry['meta_id'] . '][key]" tabindex="6" size="20" value="' . esc_attr( $entry['meta_key'] ) . '" />';
		$out .= '<div class="submit">';
		$out .= '<input type="submit" name="delete' . $_class::object_type . 'meta[' . $entry['meta_id'] . ']" 	class="delete:the-list:' . $_class::object_type . 'meta-' . $entry['meta_id'] . '::_ajax_nonce=' . $delete_nonce . ' delete' . $_class::object_type . 'meta button" tabindex="6" value="' . esc_attr( __( 'Delete' ) ) . '" />';
		$out .= '<input type="submit" name="update' . $_class::object_type . 'meta" 						class="add:the-list:' . $_class::object_type . 'meta-'    . $entry['meta_id'] . '::_ajax_nonce=' . $update_nonce . ' update' . $_class::object_type . 'meta button" tabindex="6" value="' . esc_attr( __( 'Update' ) ) . '" />';
		$out .= '</div>';
		$out .= wp_nonce_field( 'change-' . $_class::object_type . 'meta', '_ajax_nonce', false, false );
		$out .= '</td>';
		$out .= '<td>';
		$out .= '<!--<label class="hidden" for="' . $_class::object_type . 'meta[' . $entry['meta_id'] . '][value]">' . __( 'Value' ) . '</label>-->';
		$out .= '<textarea name="' . $_class::object_type . 'meta[' . $entry['meta_id'] . '][value]" id="' . $_class::object_type . 'meta[' . $entry['meta_id'] . '][value]" tabindex="6" rows="2" cols="30">' . esc_html( $entry['meta_value'] ) . '</textarea>';
		$out .= '</td>';
		$out .= '</tr>';

		return $out;
	}

	public static function add()
	{
		$_class      = self::_get_called_class();

		if ( !current_user_can( 'MailPress_' . $_class::object_type . '_custom_fields' ) )	MP_::mp_die( -1 );

		check_ajax_referer( 'add-' . $_class::object_type . 'meta' );

		$_meta_class = self::_get_meta_class();

		$c = 0;
		$object_id = ( int ) MP_WP_Ajax::$pst_[ self::_get_object_id_name() ];
		if ( $object_id === 0 ) MP_::mp_die();

		if ( isset( MP_WP_Ajax::$pst_['metakeyselect'] ) || isset( MP_WP_Ajax::$pst_['metakeyinput'] ) ) 
		{
			if ( isset( MP_WP_Ajax::$pst_['metakeyselect'] ) && ( '#NONE#' == MP_WP_Ajax::$pst_['metakeyselect'] ) && empty( MP_WP_Ajax::$pst_['metakeyinput'] ) )	MP_::mp_die( 1 );
			if ( !$meta_id = $_meta_class::add_meta( $object_id ) ) 	MP_::mp_die();

			$response = array( 'position' 	=> 1 );
		}
		else
		{
			$temp = array_keys( MP_WP_Ajax::$pst_[ $_class::object_type . 'meta' ] );
			$meta_id = ( int ) array_pop( $temp );
			$key     = MP_WP_Ajax::$pst_[ $_class::object_type . 'meta' ][$meta_id]['key'];
			$value   = MP_WP_Ajax::$pst_[ $_class::object_type . 'meta' ][$meta_id]['value'];

			if ( !$meta = $_meta_class::get_by_id( $meta_id ) )			MP_::mp_die();
			if ( !$_meta_class::update_by_id( $meta_id , $key, $value ) )	MP_::mp_die( 1 );

			$response = array( 'old_id' 	=> $meta_id, 'position' 	=> 0 );
		}

		$meta = $_meta_class::get_by_id( $meta_id );
		$txt_id = 'mp_' . $_class::object_type . '_id';
		$object_id = ( int ) $meta->$txt_id;
		$meta = get_object_vars( $meta );

		$response = array_merge( $response, array( 'what' => $_class::object_type . 'meta', 'id' => $meta_id, 'data' => self::meta_box_customfield_row( $meta, $c ), 'supplemental' => array( self::_get_object_id_name() => $object_id ) ) );

		$x = new WP_Ajax_Response( $response );

		$x->send();
	}

	public static function delete()
	{
		$_class      = self::_get_called_class();

		if ( !current_user_can( 'MailPress_' . $_class::object_type . '_custom_fields' ) )	MP_::mp_die( -1 );

		$id = ( int ) MP_WP_Ajax::$pst_['id'] ?? 0;
		check_ajax_referer( 'delete-' . $_class::object_type . 'meta_' . $id );

		$_meta_class = self::_get_meta_class();


		MP_::mp_die( $_meta_class::delete_by_id( $id ) ? 1 : 0 );
	}
}