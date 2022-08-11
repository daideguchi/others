<?php
class MP_Form_field_types extends MP_options_
{
	var $path = 'form/field_types';
	var $deep = true;

	public static function get_all()
	{
		$x = apply_filters( 'MailPress_form_field_types_register', array() );
		uasort( $x, array( 'self', 'sort_field_types' ) );
		return $x;
	}

	public static function sort_field_types( $a, $b ) 
	{
		return ( $a['order'] > $b['order'] ? 1 : ( ( $a['order'] < $b['order'] ) ? -1 : 0 ) );
	}

	public static function settings_help( $content, $id, $field )
	{
		return apply_filters( "MailPress_form_field_type_{$id}_settings_help", $content, $field ); 
	}

	public static function settings_form( $id, $field )
	{
		do_action( "MailPress_form_field_type_{$id}_settings_form", $field ); 
	}

	public static function get_id( $field )
	{
		return apply_filters( "MailPress_form_field_type_{$field->type}_get_id", $field );
	}

	public static function get_name( $field )
	{
		return apply_filters( "MailPress_form_field_type_{$field->type}_get_name", $field );
	}

	public static function get_tag( $field )
	{
		$post_ = filter_input_array( INPUT_POST );

		$no_reset = ( isset( $post_[MailPress_form::prefix][$field->form_id] ) );
		return apply_filters( "MailPress_form_field_type_{$field->type}_get_tag", $field, $no_reset );
	}

	public static function submitted( $field )
	{
		return apply_filters( "MailPress_form_field_type_{$field->type}_submitted", $field );
	}

// have file loading ?
	public static function have_file( $have_file, $id )
	{
		return apply_filters( "MailPress_form_field_type_{$id}_have_file", $have_file );
	}
}