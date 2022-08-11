<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//会話風アイコン1
if ( ! function_exists( 'amp_shortcode_st_kaiwa1' ) ) {
	function amp_shortcode_st_kaiwa1( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata131"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata131"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata134"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata134"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon1 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon1 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

//会話風アイコン2
if ( ! function_exists( 'amp_shortcode_st_kaiwa2' ) ) {
	function amp_shortcode_st_kaiwa2( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata132"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata132"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata135"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata135"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon2 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon2 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

//会話風アイコン3
if ( ! function_exists( 'amp_shortcode_st_kaiwa3' ) ) {
	function amp_shortcode_st_kaiwa3( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata133"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata133"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata136"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata136"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon3 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon3 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

//会話風アイコン4
if ( ! function_exists( 'amp_shortcode_st_kaiwa4' ) ) {
	function amp_shortcode_st_kaiwa4( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata144"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata144"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata145"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata145"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon4 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon4 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

//会話風アイコン5
if ( ! function_exists( 'amp_shortcode_st_kaiwa5' ) ) {
	function amp_shortcode_st_kaiwa5( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata146"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata146"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata147"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata147"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon5 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon5 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

//会話風アイコン6
if ( ! function_exists( 'amp_shortcode_st_kaiwa6' ) ) {
	function amp_shortcode_st_kaiwa6( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata148"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata148"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata149"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata149"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon6 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon6 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

//会話風アイコン7
if ( ! function_exists( 'amp_shortcode_st_kaiwa7' ) ) {
	function amp_shortcode_st_kaiwa7( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata150"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata150"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata151"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata151"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon7 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon7 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

//会話風アイコン8
if ( ! function_exists( 'amp_shortcode_st_kaiwa8' ) ) {
	function amp_shortcode_st_kaiwa8( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata152"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata152"] );
		} else {
			$kaiwaiconurl = get_template_directory_uri() . '/images/no-img.png';
		}
		if ( trim( $GLOBALS["stdata153"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata153"] );
		} else {
			$kaiwaiconname = '';
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon8 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">' . $content . '</div></div><div class="st-kaiwa-face2"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name2">' . $kaiwaiconname . '</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon8 clearfix"><div class="st-kaiwa-face"><amp-img src="' . $kaiwaiconurl . '" height="60" width="60"></amp-img><div class="st-kaiwa-face-name">' . $kaiwaiconname . '</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">' . $content . '</div></div></div>';
		}

	}
}

if ( isset( $GLOBALS['st_kaiwa'], $GLOBALS['st_kaiwa']['plugin_meta'], $GLOBALS['st_kaiwa']['shortcode_collection'] ) ) {
	function st_kaiwa_post_thumbnail_html($html) {
		if ( ! amp_is_amp() ) {
			return $html;
		}

		$html = preg_replace('!<img([^>]*)>!', '<amp-img$1></amp-img>', $html);

		return $html;
	}

	function st_amp_ampified_shortcode_functions($ampified_function, $tag, $callable) {
		/** @var \St\Plugin\Kaiwa\Plugin_Meta $plugin_meta */
		$plugin_meta = $GLOBALS['st_kaiwa']['plugin_meta'];

		/** @var \St\Plugin\Kaiwa\Shortcode_Collection $shortcodes */
		$shortcodes = $GLOBALS[ $plugin_meta->get_prefix() ]['shortcode_collection'];

		if ( strpos( $tag, 'st-kaiwa-' ) !== 0 ) {
			return $ampified_function;
		}

		if ( $shortcodes->has( $tag ) ) {
			return array( $shortcodes->get( $tag ), 'render' );
		}

		return $ampified_function;
	}

	add_filter( 'st_amp_ampified_shortcode_functions', 'st_amp_ampified_shortcode_functions', 10, 3 );
	add_filter( 'st_kaiwa_post_thumbnail_html', 'st_kaiwa_post_thumbnail_html' );
	add_filter( 'st_kaiwa_no_image_html', 'st_kaiwa_post_thumbnail_html' );
}

if ( ! function_exists( 'amp_shortcode_st_amp' ) ) {
	function amp_shortcode_st_amp( $arg, $content = null ) {
		if ( amp_is_amp() ) {
			return do_shortcode( $content );
		}

		return '';
	}
}

add_shortcode( 'st-amp', 'amp_shortcode_st_amp' );

if ( ! function_exists( 'amp_shortcode_st_no_amp' ) ) {
	function amp_shortcode_st_no_amp( $arg, $content = null ) {
		if ( amp_is_amp() ) {
			return '';
		}

		return do_shortcode( $content );
	}
}

add_shortcode( 'st-no-amp', 'amp_shortcode_st_no_amp' );
