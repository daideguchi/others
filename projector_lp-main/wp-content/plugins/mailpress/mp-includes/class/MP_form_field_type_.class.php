<?php
abstract class MP_form_field_type_
{
	var $field  = null;
	var $prefix = MailPress_form::prefix;

	function __construct( $desc )
	{
		$this->desc = $desc;
		$this->settings	 = dirname( $this->file ) . '/settings.xml';

		add_filter( 'MailPress_form_field_types_register',				array( &$this, 'register' ), 		8, 1 );
		add_filter( "MailPress_form_field_type_{$this->id}_have_file",		array( &$this, 'have_file' ), 		8, 1 );

		add_filter( "MailPress_form_field_type_{$this->id}_submitted",		array( &$this, 'submitted' ), 		8, 1 );

		add_filter( "MailPress_form_field_type_{$this->id}_get_tag",		array( &$this, 'get_tag' ), 	8, 2 );
		add_filter( "MailPress_form_field_type_{$this->id}_get_id",		array( &$this, 'get_id' ), 		8, 1 );
		add_filter( "MailPress_form_field_type_{$this->id}_get_name",		array( &$this, 'get_name' ), 		8, 1 );

		add_action( "MailPress_form_field_type_{$this->id}_settings_form",	array( &$this, 'settings_form' ),8, 1 );
		add_filter( "MailPress_form_field_type_{$this->id}_settings_help",	array( &$this, 'settings_help' ),8, 2 );
	}

	function register( $field_types )
	{
		$field_types[$this->id] = array( 'desc' => $this->desc, 'order' => $this->order );
		return $field_types;
	}

	function have_file( $have_file )
	{
		return $have_file;
	}

	function submitted( $field )
	{
		$this->field = $field;

		$value = $this->get_value();

		if ( !isset( $value ) ) return $this->field;

		$this->field->submitted['value'] = $value;
		$this->field->submitted['text']  = stripslashes( $value );
		return $this->field;
	}

	function get_value()
	{
		$post_ = filter_input_array( INPUT_POST );

		return ( !isset( $post_[$this->prefix][$this->field->form_id][$this->field->id] ) ) ? null : $post_[$this->prefix][$this->field->form_id][$this->field->id];
	}

	function get_tag( $field, $no_reset )
	{
		unset( $this->field );

		$this->field = $field;

		$this->attributes_filter( $no_reset );

		return $this->build_tag();
	}

	function get_formats( $default = '' )
	{
		$form_template = MP_Form::get_template( $this->field->form_id );
		if ( !$form_template ) return $default;

		$form_templates = new MP_Form_templates();
		$f = $form_templates->get_composite_template( $form_template, $this->id );
		return ( is_array( $f ) ) ? array_merge( $default, $f ) : ( ( !empty( $f ) ) ? $f : $default );
	}

	function attributes_filter( $no_reset ) 
	{
		$post_ = filter_input_array( INPUT_POST );

		if ( $no_reset ) $this->field->settings['attributes']['value'] = esc_attr( stripslashes( $post_[$this->prefix][$this->field->form_id][$this->field->id] ) );

		$this->attributes_filter_css();
	}

	function attributes_filter_css() 
	{
		if ( !isset( $this->field->submitted['on_error'] ) ) return;
		$_classes = ( isset( $this->field->settings['controls']['class'] ) ) ? trim( $this->field->settings['controls']['class'] ) : '';
		if ( !empty( $_classes ) )
		{
			$add = $remove = array();
			$error_classes = explode( ' ', $_classes );
			$classes       = explode( ' ', $this->field->settings['attributes']['class'] );
			foreach ( $classes       as $k => $v ) $classes[$k] = trim( $v );
			foreach ( $error_classes as $k => $v ) { $v = trim( $v ); switch ( $v[0] ) { case '+' : $add[] = substr( $v, 1 ); break; case '-' : $remove[] = substr( $v, 1 ); break; default : $add[] = $v; break; } }
			$this->field->settings['attributes']['class'] = implode( ' ', array_merge( array_diff( $classes, $remove ), $add ) );
		}
		$_style = ( isset( $this->field->settings['controls']['style'] ) ) ? trim( $this->field->settings['controls']['style'] ) : '';
		if ( !empty( $_style ) ) $this->field->settings['attributes']['style'] .= $_style;
	}

	function build_tag()
	{
		$tag_content = $misc = '';
	// opening tag
		$tag  = '<';
		$tag .= ( isset( $this->field_not_input ) ) ? $this->field->type : 'input';
	// id
		$this->field->settings['attributes']['id']   = $this->get_id( $this->field );
	// name
		$this->field->settings['attributes']['name'] = $this->get_name( $this->field );
	// other attributes
		foreach ( $this->field->settings['attributes'] as $attribute => $value )
		{
/*
			if ( 'tag_content' == $attribute ) { $tag_content = $value; continue; }
			if ( 'misc'        == $attribute ) { $misc = trim( $value ); if ( '' != $misc ) $misc = " $misc"; continue; }
			if ( ''            != trim( $value ) ) $tag .= $this->get_attribute( $attribute, trim( $value ) );
*/
			switch( $attribute )
			{
				case 'tag_content' :
					$tag_content = $value;
				break;
				case 'misc' :
					$misc = trim( $value );
					if ( '' != $misc ) $misc = " $misc";
				break;
				default :
					if ( '' != trim( $value ) ) $tag .= $this->get_attribute( $attribute, trim( $value ) );
				break;
			}
		} 
	// closing tag
		return $tag . ( ( isset( $this->field_not_input ) ) ? "$misc >$tag_content</" . $this->field->type . '>' : "$misc />" );
	}

	function get_attribute( $attr, $value )
	{
		if ( 'value' == $attr ) $value = esc_attr( $value );
		$quote = ( false !== strpos( $value, '"' ) ) ? "'" : '"';
		return " $attr=$quote$value$quote";
	}

	function get_name( $field )
	{
		$this->field = $field;
		return ( isset( $this->field->settings['attributes']['name'] ) ) ?  $this->prefix . '[' . $this->field->form_id.'][' . $this->prefix . $this->field->settings['attributes']['name'] . ']'	: $this->prefix.'[' . $this->field->form_id . '][' . $this->field->id . ']';
	}

	function get_id( $field )
	{
		$this->field = $field;
		return ( isset( $this->field->settings['attributes']['id'] ) )   ?  $this->prefix  .  $this->field->form_id . '_' . $this->field->settings['attributes']['id'] 					: $this->prefix . $this->field->form_id . '_' . $this->field->id; 
	}

	function settings_help( $content, $field )
	{
		$this->field = $field;

		$style = ( $this->id == $this->field->type ) ? '' : ' style="display:none;"';

		$content .= '<div id="field_type_' . $this->id . '_help" class="field_type_help"' . $style . '>';
		$content .= $this->desc;
		$content .= '</div>';
		return $content;
	}

	function settings_form( $field )
	{
		$this->field = $field;
		$this->type_ok = ( $this->id == $this->field->type );
		$protected = ( isset( $this->field->settings['options']['protected'] ) && $this->field->settings['options']['protected'] );
		$has_controls = $has_controls_checked = false;
		if ( method_exists( $this, 'build_settings_form' ) ) return $this->build_settings_form();

		ob_start();
			include( $this->settings );
			$xml = trim( ob_get_contents() );
		ob_end_clean();

		$xml = simplexml_load_string( $xml, 'SimpleXMLElement', LIBXML_NOCDATA );

		foreach ( $xml->children() as $child )
		{
			$tabs[$child->getName()] = ( string ) $child->tab;
		}

		if ( isset( MP_AdminPage::$get_['action'] ) && ( 'edit' == MP_AdminPage::$get_['action'] ) && $this->type_ok ) { $tabs['html'] = __( 'Html', 'MailPress' ); }

		if ( empty( $tabs ) ) return;

		$style = ( $this->type_ok ) ? '' : ' style="display:none;"';

// help
		$help = "\n\n\n";
		$help .= '<div class="field-type-help" data-id="field_type_' . $this->id . '_help"><ul>';
		foreach( $tabs as $tab_type => $tab )
		{
			$help .= '<li><a href="#help_tab_' . $this->id . '_' . $tab_type . '"><span>' . $tab . '</span></a></li>';
		}
		$help .= '</ul><div style="clear:both;">';
		foreach( $tabs as $tab_type => $tab ) 
		{
			$help .= '<div id="help_tab_' . $this->id . '_' . $tab_type . '" class="help_form_tabs mp_help_tabs help_' . $tab_type . '">';

			switch ( $tab_type )
			{
				case 'html' :
					if ( !isset( $form ) ) $form = MP_Form::get( $this->field->form_id );
					$help .= sprintf( __('This is the html generated, mixing your different settings with the %s selected.', 'MailPress' ), sprintf('<a href="' . esc_url( MP_AdminPage::url( MailPress_templates, array( 'action' => 'edit', 'template' => $form->template ) ) ) . '">%s</a>', __('Template/Subtemplate', 'MailPress' ) ) );
				break;
				default :
					$help .= (string) $xml->{$tab_type}->help;
				break;
			}
			$help .= '</div>';
		}
		$help .= "</div></div>\n\n\n";

// out
		$this->out = "\n\n\n";
		$this->out .= '<div id="field_type_' . $this->id . '_settings" class="field_type_settings"' . $style . '>';
		$this->out .= '<ul>';
		foreach ( $tabs as $tab_type => $tab )
		{
			$this->out .= '<li><a href="#settings_tab_' . $this->id . '_' . $tab_type . '"><span>' . $tab . '</span></a></li>';
		}
		$this->out .= '</ul>';
		$this->out .= '<div style="clear:both;" >';
		foreach ( $tabs as $tab_type => $tab ) 
		{
			$this->out .= '<div id="settings_tab_' . $this->id . '_' . $tab_type . '" class="ui-tabs settings_form_tabs settings_' . $tab_type . '">';
			switch ( $tab_type )
			{
				case 'html' :
					if ( !isset( $form ) ) $form = MP_Form::get( $this->field->form_id );
					$this->out .= '<textarea disabled="disabled" rows="5" cols="40">' . htmlspecialchars( MP_Form::get_field( $this->field, false, $form->template ), ENT_QUOTES ) . '</textarea>';
					$this->out .= '<p><small>' . sprintf( __( 'Templates : %1$s/%2$s', 'MailPress' ), $form->template, $field->template ) . '</small></p>';
				break;
				default :
					foreach ( $xml->{$tab_type}->items as $items )
					{
						foreach ( $items->children() as $child )
						{
							$attribute = $child->getName();
							foreach ( $child->children() as $tags )
							{
								switch ( $tags->getName() )
								{
									case 'checkbox' :
										$checked = $this->settings_checkbox( $tab_type, $attribute, $tags->value, (int) $tags->disabled, ( ( isset( $tags->class ) ) ? $tags->class : false ), ( ( isset( $tags->forced ) ) ? $tags->forced : false )  );
										if ( isset( $tags->class ) && ( 'controls' == (string) $tags->class ) ) $has_controls = true;
										if ( $checked ) $has_controls_checked = true;
										$this->out .= '<label for="' . $this->prefix . $this->id . '_settings_' . $tab_type . '_' . $attribute . '_' . $tags->value . '" class="inline" ><span class="description"><small>' . $tags->text . '</small></span></label>&#160;';
									break;
									case 'hidden' :
										$this->settings_hidden_value( $tab_type, $attribute, $tags->value );
									break;
									case 'is' :
										$this->settings_description( __( 'initial state : ', 'MailPress' ) );
										$values = unserialize( $tags->values );
										$disabled = unserialize( $tags->disabled );
										foreach ( $values as $attribute ) 
										{ 
											$this->settings_checkbox( $tab_type, $attribute, $attribute, ( in_array( $attribute, $disabled ) ) );
											$this->out .= '<label for="' . $this->prefix . $this->id . '_settings_' . $tab_type . '_' . $attribute . '_' . $attribute . '" class="inline" ><span class="description"><small>' . $attribute . '</small></span></label>&#160;';
										}
									break;
									case 'misc' :
										$this->settings_text( 'attributes', 'misc', false, '', 39 );
										$this->out .= '<br /><span class="description"><i style="color:#666;font-size:8px;">' . ( (string) $tags ) . '</i></span><br />';
									break;
									case 'only_text' :
										$this->out .= '<span class="description">' . (string) $tags . '</span>';
									break;
									case 'radio' :
										$this->settings_description( $tags->text );
										$values = unserialize( $tags->values );
										$disabled = unserialize( $tags->disabled );
										foreach ( $values as $value => $value_text )
										{
											$this->settings_radio( $tab_type, $attribute, $value, $value_text, $tags->default, in_array( $value, $disabled ) );
										}
									break;
									case 'select_num' :
										$this->out .= '<span class="description"><small>' . $tags->text;
										$this->out .=  ( 'attributes' == $tab_type ) ? '"' : '';
										$this->settings_select_num( $tab_type, $attribute, (int) $tags->min, (int) $tags->max, (int) $tags->default ); 
										$this->out .=  ( 'attributes' == $tab_type ) ? '"' : '';
										$this->out .= '</small></span>&#160;';
									break;
									case 'select_opt' :
										$values = unserialize( $tags->values );
										$this->out .= '<span class="description"><small>' . $tags->text;
										$this->settings_select_opt( $tab_type, $attribute, $values, $tags->default ); 
										$this->out .= '</small></span>&#160;';
									break;
									case 'text' :
										$this->out .= '<span class="description"><small>';
										$this->out .= ( isset( $tags->text ) ) ? $tags->text : $attribute; 
										$this->out .= ( 'attributes' == $tab_type ) ? '="' : '';
										$this->out .= '</small></span>';
										$this->settings_text( $tab_type, $attribute, ( isset( $tags->disabled ) ) ? (string) $tags->disabled : false, ( isset( $tags->default ) ) ? $tags->default : '', ( isset( $tags->size ) ) ? (string) $tags->size : 32 );
										if ( 'attributes' == $tab_type ) $this->out .= '<span class="description"><small>"</small></span>';
									break;
									case 'textarea' :
										$this->settings_attributes_textarea( $tags->text, $attribute );
										if ( isset( $tags->desc ) ) $this->out .= '<br /><span class="description"><small style="color:#666;">' . $tags->desc . '</small></span>';
									break;
								}
							}
						}
						$this->out .= '<br />';
					}
					if ( ( $has_controls ) && ( 'controls' == $tab_type ) )
					{
						$style = ( $has_controls_checked ) ? '' : ' style="display:none;"'; 
						$this->out .= '<div id="field_type_controls_' . $this->id . '"' . $style . ' class="field_type_controls">';
						$this->out .= '<hr style="border: 0pt none ; margin: 1px 5px 5px 1px; color: rgb( 223, 223, 223 ); background-color: rgb( 223, 223, 223 ); height: 1px;" />';
						$this->out .= __( 'On error <small>(to remove a class : -name_of_class)</small>', 'MailPress' );
						$this->out .= '<br /><div>';
						foreach ( array( 'class', 'style' ) as $attribute )
						{
							$this->out .= '<span class="description"><small>' . $attribute . '="</small></span>"';
							$this->settings_text( $tab_type, $attribute );
							$this->out .= '<span class="description"><small>"</small></span><br />';
						}
						$this->out .= '</div>';
						$this->out .= '</div>';
					}
				break;
			}
			if ( isset( $xml->{$tab_type}->hiddens ) )
			{
				foreach( $xml->{$tab_type}->hiddens->children() as $hidden )
				{
					$attribute = (string) $hidden->getName();
					if ( isset( $hidden->value ) )	$this->settings_hidden_value( $tab_type, $attribute, $hidden->value );
					else						$this->settings_hidden( $tab_type, $attribute );
				}
			}
			$this->out .= '</div>';
		}
		$this->out .= '</div></div>'; // clearboth + tabdiv
		$this->out .= "\n\n\n";

		echo $this->out;
		echo $help;
	}

	function settings_description( $text ) 
	{
		$this->out .= '<span class="description"><small>' . $text . '</small></span>';
	}

	function settings_hidden( $setting, $attribute )
	{
		$tags = array (
			'type' 	=> 'hidden',
			'name' 	=> $this->prefix . $this->id . "[settings][$setting][$attribute]",
			'value' 	=> ($this->type_ok && isset($this->field->settings[$setting][$attribute])) ? $this->field->settings[$setting][$attribute] : '',
		);
		$this->out .= $this->settings_tag( 'input', $tags );
	}

	function settings_hidden_value( $setting, $attribute, $value )
	{
		$tags = array (
			'type' 	=> 'hidden',
			'name' 	=> $this->prefix . $this->id . "[settings][$setting][$attribute]",
			'value' 	=> $value,
		);

		$this->out .= $this->settings_tag( 'input', $tags );
	}

	function settings_text( $setting, $attribute, $disabled = false, $default = '', $size = 32 )
	{
		$tags = array (
			'type' 	=> 'text',
			'name' 	=> $this->prefix . $this->id . "[settings][$setting][$attribute]",
			'id' 		=> $this->prefix . $this->id . '_settings_' . $setting . '_' . $attribute,
			'value' 	=> ( ( $this->type_ok && isset( $this->field->settings[$setting][$attribute] ) ) ? $this->field->settings[$setting][$attribute] : $default ),
			'size' 	=> $size,
		);

		$this->out .= $this->settings_tag( 'input', $tags );
	}

	function settings_checkbox( $setting, $attribute, $value, $disabled = false, $class = false, $forced = false )
	{
		$tags = array (
			'type' 	=> 'checkbox',
			'name' 	=> $this->prefix . $this->id . "[settings][$setting][$attribute]",
			'id' 		=> $this->prefix . $this->id . '_settings_' . $setting . '_' . $attribute . '_' . $value,
			'value' 	=> $value,
			'style' 	=> 'width:auto;',
		);
		if ( $class ) $tags['class'] = 'class';
		if ( $disabled )
		{
			$tags['disabled'] = 'disabled';
			unset( $tags['name'] );
		}

		if ( $forced !== false )
		{
			$tags['checked'] = 'checked';
		}
		else
		{
			$value = (string) $value;
			$v =  (string) ( $this->type_ok && isset( $this->field->settings[$setting][$attribute] ) ) ? $this->field->settings[$setting][$attribute] : null;
			if ( $value == $v ) $tags['checked'] = 'checked';
		}

		$this->out .= $this->settings_tag( 'input', $tags );

		return ( isset( $tags['checked'] ) ) ;
	}

	function settings_radio( $setting, $attribute, $value, $value_text, $default, $disabled = false )
	{
		$tags = array (
			'type' 	=> 'radio',
			'name' 	=> $this->prefix . $this->id . "[settings][$setting][$attribute]",
			'id' 		=> $this->prefix . $this->id . '_settings_' . $setting . '_' . $attribute . '_' . $value,
			'value' 	=> $value,
			'style' 	=> 'width:auto;',
		);
		if ( $disabled )
		{
			$tags['disabled'] = 'disabled';
			unset( $tags['name'] );
		}

		$v = (string) ( $this->type_ok && isset( $this->field->settings[$setting][$attribute] ) ) ? $this->field->settings[$setting][$attribute] : $default;
		$value = (string) $value;

		if ( $value == $v ) $tags['checked'] = 'checked';

		$this->out .= $this->settings_tag( 'input', $tags );

		$style = ( $disabled ) ? ' style="color:#888;"' : ''; 
		$this->out .= '<label class="inline" for="' . $tags['id'] . '"><span class="description"><small' . $style . '>' . $value_text . '</small></span></label>&#160;';
	}

	function settings_select_num( $setting, $attribute, $min, $max, $default )
	{
		$tags = array (
			'name' 	=> $this->prefix . $this->id . "[settings][$setting][$attribute]",
			'id' 		=> $this->prefix . $this->id . '_settings_' . $setting . '_' . $attribute,
		);
		$v = ( $this->type_ok && isset( $this->field->settings[$setting][$attribute] ) ) ? $this->field->settings[$setting][$attribute] : $default;

		$this->out .= $this->settings_tag( 'select', $tags );
		$this->out .= MP_AdminPage::select_number( $min, $max, $v, 1, false );
		$this->out .= '</select>';
	}

	function settings_select_opt( $setting, $attribute, $values, $default )
	{
		$tags = array (
			'name' 	=> $this->prefix . $this->id . "[settings][$setting][$attribute]",
			'id' 		=> $this->prefix . $this->id . '_settings_' . $setting . '_' . $attribute,
		);
		$v = ( $this->type_ok && isset( $this->field->settings[$setting][$attribute] ) ) ? $this->field->settings[$setting][$attribute] : $default;

		$this->out .= $this->settings_tag( 'select', $tags );
		$this->out .= MP_AdminPage::select_option( $values, $v, false );
		$this->out .= '</select>';
	}

	function settings_attributes_textarea( $text, $option )
	{
		$tags = array (
			'type' 	=> 'hidden',
			'name' 	=> $this->prefix . $this->id . '[textareas][]',
			'value' 	=> $option,
		);

		$this->out .= $this->settings_tag( 'input', $tags );
		$this->settings_description( $text );
		$this->out .= '<br />';
		$tags = array (
			'name' 	=> $this->prefix . $this->id . "[settings][attributes][$option]",
			'id' 		=> $this->prefix . $this->id . '_settings_attributes_' . $option,
			'cols' 	=> 40,
			'rows' 	=> 4,
		);
		$this->out .= $this->settings_tag( 'textarea', $tags );
		$this->out .= ( $this->type_ok && isset( $this->field->settings['attributes']['tag_content'] ) ) ? esc_attr( trim( base64_decode( $this->field->settings['attributes']['tag_content'] ) ) ) : '';
		$this->out .= '</textarea>';
	}

	function settings_tag( $type, $tags )
	{
		$o = '<' . $type;
		foreach( $tags as $attr => $v )
		{
			if ( ( 'value' != $attr ) && !$v ) continue;
                if ( empty( $v ) ) $v = (string) '';
			$o .= ' ' . $attr . '="' . esc_attr( $v ) .'"';
		}
		$o.= ( 'input' == $type ) ? ' />' : '>';
		return $o;
	}
}