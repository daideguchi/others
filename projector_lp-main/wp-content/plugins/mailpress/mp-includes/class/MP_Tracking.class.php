<?php
class MP_Tracking
{
	public static function process()
	{
		$get_ = filter_input_array( INPUT_GET );

		$meta = MP_Mail_meta::get_by_id( $get_['mm'] );
		if ( $meta )
		{
			do_action( 'mp_tracking_process', $meta ); // will activate if any !
			switch ( $get_['tg'] )
			{
				case ( 'l' ) :
					switch ( $meta->meta_value )
					{
						case '{{subscribe}}' :
							$url = MP_User::get_subscribe_url( $get_['us'] );
						break;
						case '{{unsubscribe}}' :
							$url = MP_User::get_unsubscribe_url( $get_['us'] );
						break;
						case '{{viewhtml}}' :
							$url = MP_User::get_view_url( $get_['us'], $meta->mp_mail_id );
						break;
						default :
							$pattern = '#^(http|https)://[\w-]+[\w.-]+\.[a-zA-Z]{2,6}#i';
							$url = false;
							foreach( array( $meta->meta_value, 'https://' . $meta->meta_value ) as $u ) if ( preg_match( $pattern, $u ) ) $url = $u;
							if ( !$url ) $url = $meta->meta_value;
						break;
					}
					MP_::mp_redirect( $url );
				break;
				case ( 'o' ) :
					header( 'Content-Type: image/gif' );
					readfile( MP_ABSPATH . 'mp-includes/images/_.gif' );
					die();
				break;
			}
		}
		MP_::mp_redirect( home_url() );
	}
}