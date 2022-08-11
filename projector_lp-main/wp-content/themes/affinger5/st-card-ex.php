<?php
add_filter(
	'st_amp_get_allowed_shortcode_tags',
	function ( $tag_names ) {
		$tag_names[] = 'st-card-ex';

		return $tag_names;
	}
);

add_filter(
	'st_strip_shortcodes_tagnames',
	function ( $tag_names ) {
		$tag_names[] = 'st-card-ex';

		return $tag_names;
	}
);

add_filter( 'st_card_ex_enqueue_styles', '__return_false' );

add_filter(
	'st_card_ex_crawler_settings',
	function ( array $settings ) {
		$settings['http_client']['wp_http']['timeout'] = 120;

		return $settings;
	}
);

add_filter(
	'st_card_ex_show_excerpt',
	function ( $show ) {
		$hide_excerpt_on_pc    = (bool) trim( get_option( 'st-data221', '' ) );
		$show_excerpt_on_phone = (bool) trim( get_option( 'st-data280', '' ) );

		// AMP.
		if ( amp_is_amp() ) {
			return ( ! st_is_mobile() && ! $hide_excerpt_on_pc );
		}

		return ( ! st_is_mobile() && ! $hide_excerpt_on_pc ) || ( st_is_mobile() && $show_excerpt_on_phone );
	}
);

add_filter(
	'st_card_ex_template',
	function ( $name ) {
		// AMP.
		if ( amp_is_amp() ) {
			return 'amp';
		}

		return $name;
	}
);

add_filter(
	'st_card_ex_excerpt_length',
	function ( $length ) {
		$excerpt_length = trim( get_option( 'st-data73', '100' ) );
		$excerpt_length = ( $excerpt_length !== '' ) ? (int) $excerpt_length : 100;

		return $excerpt_length;
	}
);

add_filter(
	'st_card_ex_add_editor_buttons',
	function ( $add ) {
		$hide_editor_buttons = (bool) trim( get_option( 'st-data137', '' ) );

		return ! $hide_editor_buttons;
	}
);
