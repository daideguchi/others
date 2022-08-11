<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define('ST_AF_KANRI_WYSIWYG_ENABLE', true);

if (!function_exists( 'st_af_kanri_wysiwyg_get_option_name' )) {
	function st_af_kanri_wysiwyg_get_option_name( $location ) {
		return 'st_af_kanri_wysiwyg_0.0.0_to_1.0.1_' . $location;
	}
}

if (!function_exists('st_af_kanri_wysiwyg_is_updated')) {
	function st_af_kanri_wysiwyg_is_updated( $location ) {
		$option_name = st_af_kanri_wysiwyg_get_option_name( $location );
		$isUpdated   = ( get_option( $option_name, '0' ) !== '0' );

		return $isUpdated;
	}
}

if (!function_exists('st_af_kanri_wysiwyg_is_enabled')) {
	function st_af_kanri_wysiwyg_is_enabled() {
		return (defined( 'ST_AF_KANRI_WYSIWYG_ENABLE' ) && ST_AF_KANRI_WYSIWYG_ENABLE);
	}
}

if ( !function_exists( 'st_af_kanri_wysiwyg_revert' ) ) {
	function st_af_kanri_wysiwyg_revert( $location, $option_name, $wysiwyg_content ) {
		if ( !st_af_kanri_wysiwyg_is_updated( $location ) ) {
			return;
		}

		$wysiwyg_content = str_replace( array( "\r", "\n" ), '', $wysiwyg_content );
		$wysiwyg_content = preg_replace( '!<br\s*/?>!', "\n", $wysiwyg_content );
		$wysiwyg_content = strip_tags( $wysiwyg_content );

		update_option( $option_name, $wysiwyg_content );
		update_option( st_af_kanri_wysiwyg_get_option_name( $location ), '0' );
	}
}

if ( !st_af_kanri_wysiwyg_is_enabled() ) {
	st_af_kanri_wysiwyg_revert( 'description_1', 'my-af4', stripslashes( get_option( 'my-af4' ) ) );
	st_af_kanri_wysiwyg_revert( 'description_2', 'my-af8', stripslashes( get_option( 'my-af8' ) ) );
	st_af_kanri_wysiwyg_revert( 'description_3', 'my-af12', stripslashes( get_option( 'my-af12' ) ) );
	st_af_kanri_wysiwyg_revert( 'description_1b', 'my-af4b', stripslashes( get_option( 'my-af4b' ) ) );
	st_af_kanri_wysiwyg_revert( 'description_2b', 'my-af8b', stripslashes( get_option( 'my-af8b' ) ) );
	st_af_kanri_wysiwyg_revert( 'description_3b', 'my-af12b', stripslashes( get_option( 'my-af12b' ) ) );
	st_af_kanri_wysiwyg_revert( 'description_0', 'my-af22', stripslashes( get_option( 'my-af22' ) ) );
}

if (!function_exists('st_af_kanri_wysiwyg_update')) {
	function st_af_kanri_wysiwyg_update( $location = null, $option_name = null, $content = '' ) {
		if ($location === null || $option_name === null) {
			return;
		}

		if ( !st_af_kanri_wysiwyg_is_enabled() ) {
			st_af_kanri_wysiwyg_revert( $location, $option_name, $content );

			return;
		}

		if ( st_af_kanri_wysiwyg_is_updated( $location ) ) {
			return;
		}

		$content = get_option( $option_name, '' );
		$content = '<p>' . nl2br( esc_html( $content ) ) . '</p>';

		update_option( $option_name, $content );
		update_option( st_af_kanri_wysiwyg_get_option_name( $location ), '1' );
	}

	add_action( 'st_af_kanri_editor', 'st_af_kanri_wysiwyg_update', ~PHP_INT_MAX, 3 );
}

if ( !function_exists( 'st_af_kanri_wysiwyg_get_settings' ) ) {
	function st_af_kanri_wysiwyg_get_settings( $location = null, $name = null ) {
		$settings = array(
			'wpautop'          => false,
			'media_buttons'    => true,
			'textarea_rows'    => 10,
		);

		if ($name !== null) {
			$settings['textarea_name'] = $name;
		}

		return $settings;
	}
}

if ( !function_exists( 'st_af_kanri_wysiwyg_editor' ) ) {
	function st_af_kanri_wysiwyg_editor( $location = null, $option_name = null, $content = '' ) {
		if ( $location !== null && $option_name !== null && !st_af_kanri_wysiwyg_is_enabled() ) {
			st_af_kanri_wysiwyg_revert( $location, $option_name, $content );

			$content = stripslashes( get_option( $option_name, '' ) );

			do_action('st_af_kanri_' . $location . '_editor', $location, $option_name, $content);

			return;
		}

		$editor_id = ( $location !== null ) ? ( 'st-af-kanri-' . $location ) : 'st-af-kanri';
		$settings  = st_af_kanri_wysiwyg_get_settings( $location, $option_name );
		$content   = stripslashes( get_option( $option_name, '' ) );

		if ( $location !== null && !st_af_kanri_wysiwyg_is_updated( $location ) ) {
			$content = '<p>' . nl2br( esc_html( $content ) ) . '</p>';
		}

		wp_editor( $content, $editor_id, $settings );
	}

	remove_action( 'st_af_kanri_editor', 'st_af_kanri_editor' );
	add_action( 'st_af_kanri_editor', 'st_af_kanri_wysiwyg_editor', 10, 3 );
}

if ( !function_exists( 'st_af_kanri_wysiwyg_editor_content' ) ) {
	function st_af_kanri_wysiwyg_editor_content( $content, $location, $option_name ) {
		if ( !st_af_kanri_wysiwyg_is_enabled() ) {
			st_af_kanri_wysiwyg_revert( $location, $option_name, $content );

			return '<p>' . nl2br( esc_html( stripslashes( get_option( $option_name, '' ) ) ) ) . '</p>';
		}
		if ( !st_af_kanri_wysiwyg_is_updated( $location ) ) {
			st_af_kanri_wysiwyg_update( $location, $option_name );

			$content = stripslashes( get_option( $option_name, '' ) );
		}

		return $content;
	}

	remove_filter( 'st_af_kanri_rank_description', 'st_af_kanri_default_editor_content' );
	remove_filter( 'st_af_kanri_rank1_description', 'st_af_kanri_default_editor_content' );
	remove_filter( 'st_af_kanri_rank2_description', 'st_af_kanri_default_editor_content' );
	remove_filter( 'st_af_kanri_rank3_description', 'st_af_kanri_default_editor_content' );
	remove_filter( 'st_af_kanri_rank1b_description', 'st_af_kanri_default_editor_content' );
	remove_filter( 'st_af_kanri_rank2b_description', 'st_af_kanri_default_editor_content' );
	remove_filter( 'st_af_kanri_rank3b_description', 'st_af_kanri_default_editor_content' );
	add_filter( 'st_af_kanri_rank1_description', 'st_af_kanri_wysiwyg_editor_content', 10, 6 );
	add_filter( 'st_af_kanri_rank2_description', 'st_af_kanri_wysiwyg_editor_content', 10, 6 );
	add_filter( 'st_af_kanri_rank3_description', 'st_af_kanri_wysiwyg_editor_content', 10, 6 );
	add_filter( 'st_af_kanri_rank1b_description', 'st_af_kanri_wysiwyg_editor_content', 10, 6 );
	add_filter( 'st_af_kanri_rank2b_description', 'st_af_kanri_wysiwyg_editor_content', 10, 6 );
	add_filter( 'st_af_kanri_rank3b_description', 'st_af_kanri_wysiwyg_editor_content', 10, 6 );
}
