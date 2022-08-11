<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if (locate_template('st-is-ver-check.php') !== '') {
	require_once locate_template('st-is-ver-check.php');
}

if (locate_template('st-plugin-support.php') !== '') {
	require_once locate_template('st-plugin-support.php');
}

if (locate_template('st-example.php') !== '') {
	require_once locate_template('st-example.php');
}

if (locate_template('st-affiliate-manager.php') !== '') {
	require_once locate_template('st-affiliate-manager.php');
}

if (locate_template('st-kanri.php') !== '') {
require_once locate_template('st-kanri.php');
}

if (locate_template('st-toc.php') !== '') {
	require_once locate_template('st-toc.php');
}

if (locate_template('st-card-ex.php') !== '') {
	require_once locate_template('st-card-ex.php');
}

if (locate_template('st-lazy-load.php') !== '') {
	require_once locate_template('st-lazy-load.php');
}

if (locate_template('st-replace-meta-box.php') !== '') {
	require_once locate_template('st-replace-meta-box.php');
}

if (locate_template('st-export-meta-box.php') !== '') {
	require_once locate_template('st-export-meta-box.php');
}

if (locate_template('st-theme-customization.php') !== '') {
	require_once locate_template('st-theme-customization.php');
}

if (locate_template('st-widgets.php') !== '') {
require_once locate_template('st-widgets.php');
}

if (locate_template('st-title.php') !== '') {
require_once locate_template('st-title.php');
}

if (locate_template('st-category.php') !== '') {
require_once locate_template('st-category.php');
}

if (locate_template('functions-amp.php') !== '') {
	require_once locate_template('functions-amp.php');
}

if (locate_template('st-structured-data.php') !== '') {
	require_once locate_template('st-structured-data.php');
}

if (locate_template('st-update.php') !== '') {
	require_once locate_template('st-update.php');
}

if ( !function_exists( 'st_after_setup_theme' ) ) {

	function st_after_setup_theme() {

		$original_color_a = get_option( 'st-data460', '' ) !== '' ? get_option( 'st-data460' ) : '#43a047';
		$original_color_b = get_option( 'st-data461', '' ) !== '' ? get_option( 'st-data461' ) : '#795548';
		$original_color_c = get_option( 'st-data462', '' ) !== '' ? get_option( 'st-data462' ) : '#ec407a';
		$original_color_d = get_option( 'st-data463', '' ) !== '' ? get_option( 'st-data463' ) : '#9e9d24';

		add_theme_support( 'title-tag' );

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Pale pink' ),
					'slug'  => 'pale-pink',
					'color' => '#f78da7',
				),
				array(
					'name'  => __( 'Soft red' ),
					'slug'  => 'soft-red',
					'color' => '#e6514c',
				),
				array(
					'name'  => __( 'Light grayish red' ),
					'slug'  => 'light-grayish-red',
					'color' => '#fdebee',
				),
				array(
					'name'  => __( 'Vivid yellow' ),
					'slug'  => 'vivid-yellow',
					'color' => '#ffc107',
				),
				array(
					'name'  => __( 'Very pale yellow' ),
					'slug'  => 'very-pale-yellow',
					'color' => '#fffde7',
				),
				array(
					'name'  => __( 'Light green cyan' ),
					'slug'  => 'light-green-cyan',
					'color' => '#7bdcb5',
				),
				array(
					'name'  => __( 'Pale cyan blue' ),
					'slug'  => 'pale-cyan-blue',
					'color' => '#8ed1fc',
				),
				array(
					'name'  => __( 'Vivid cyan blue' ),
					'slug'  => 'vivid-cyan-blue',
					'color' => '#0693e3',
				),
				array(
					'name'  => __( 'Very light gray' ),
					'slug'  => 'very-light-gray',
					'color' => '#fafafa',
				),
				array(
					'name'  => __( 'Very dark gray' ),
					'slug'  => 'very-dark-gray',
					'color' => '#313131',
				),
				array(
					'name'  => __( 'White' ),
					'slug'  => 'white',
					'color' => '#ffffff',
				),
				array(
					'name'  => __( 'Original Color A' ),
					'slug'  => 'original-color-a',
					'color' => $original_color_a,
				),
				array(
					'name'  => __( 'Original Color B' ),
					'slug'  => 'original-color-b',
					'color' => $original_color_b,
				),
				array(
					'name'  => __( 'Original Color C' ),
					'slug'  => 'original-color-c',
					'color' => $original_color_c,
				),
				array(
					'name'  => __( 'Original Color D' ),
					'slug'  => 'original-color-d',
					'color' => $original_color_d,
				),
			)
		);
	}
}
add_action( 'after_setup_theme', 'st_after_setup_theme' );

if ( !function_exists( 'st_enqueue_scripts' ) ) {
	function st_enqueue_scripts() {

		wp_deregister_script( 'jquery' );

		wp_enqueue_script(
			'jquery',
			'//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
			array(),
			'1.11.3',
			false
		);

		if ( ( isset($GLOBALS['stdata398']) && $GLOBALS['stdata398'] === 'yes' ) && ( trim( $GLOBALS['stdata30'] ) === '' && trim( $GLOBALS['stdata266'] ) === '' ) ) { // スライドショー機能の全停止が有効かつ画像スライドショー又は記事スライドショーも未使用
		} else {
			wp_register_script(
				'slick',
				get_template_directory_uri() . '/vendor/slick/slick.js',
				array( 'jquery' ),
				'1.5.9',
				true
			);

			wp_enqueue_script( 'slick' );
		}

		if ( isset($GLOBALS['stdata64']) && $GLOBALS['stdata64'] === 'yes' ) {
			wp_enqueue_script(
				'smoothscroll',
				get_template_directory_uri() . '/js/smoothscroll.js',
				array('jquery')
			);
		}

		wp_enqueue_script( 'base', get_template_directory_uri() . '/js/base.js', array( 'jquery' ), false, true );

		wp_localize_script(
			'base',
			'ST',
			array(
				'ajax_url'              => admin_url( 'admin-ajax.php' ),
				'expand_accordion_menu' => ( $GLOBALS['stdata235'] === 'yes' ),
				'sidemenu_accordion'    => (bool) get_theme_mod( 'st_sidemenu_accordion' ),
				'is_mobile'             => wp_is_mobile(),
			)
		);

		if ( !st_is_mobile() && trim( $GLOBALS['stdata87'] ) === '' ) {
			wp_enqueue_script(
				'scroll',
				get_template_directory_uri() . '/js/scroll.js',
				array( 'jquery' ),
				false,
				true
			);
		}

		if ( isset($GLOBALS['stdata111']) && $GLOBALS['stdata111'] === 'yes' ) {
			wp_enqueue_script(
				'jquery.tubular',
				get_template_directory_uri() . '/js/jquery.tubular.1.0.js',
				array( 'jquery' ),
				false,
				true
			);
		}

		if ( ! st_speed_on() // 読み込みを停止して表示速度を優先する が無効
			|| ( trim( $GLOBALS['stdata415'] ) === '' && trim( $GLOBALS['stdata468'] ) !== '' ) // SNS設定でコピーが非表示がnull且つこの記事タイトルとURLをコピーボタンを表示が無効
		   ) {
			wp_enqueue_script(
				'st-copy-text',
				get_template_directory_uri() . '/js/st-copy-text.js',
				array( 'jquery' ),
				false,
				true
			);
		}

	}
}
add_action( 'wp_enqueue_scripts', 'st_enqueue_scripts' );

if ( ! function_exists( 'st_admin_enqueue_scripts' ) ) {
	function st_admin_enqueue_scripts( $hook_suffix ) {
		$data = [
			'affiliate_manager_enabled' => st_is_affiliate_manager_enabled(),
			'af_cpt_enabled'            => st_is_af_cpt_enabled(),
			'tag_plugin_enabled'        => st_is_tag_plugin_enabled(),
			'st_toc_enabled'            => st_is_st_toc_enabled(),
		];

		$json = json_encode( $data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );

		wp_localize_script(
			'jquery',
			'ST',
			[
				'l10n_print_after' => 'ST = ' . $json,
			]
		);
	}
}
add_action( 'admin_enqueue_scripts', 'st_admin_enqueue_scripts' );

if ( !function_exists( '_st_get_google_font' ) ) {
	function _st_get_google_font() {
		$style = null;

		if ( trim( $GLOBALS['stdata49'] ) !== '') {
			$style = esc_url($GLOBALS['stdata49']);
		}

		return $style;
	}
}

if ( !function_exists( 'st_enqueue_styles' ) ) {
	function st_enqueue_styles() {
		$style_dependencies = array();
		wp_register_style(
			'normalize',
			get_template_directory_uri() . '/css/normalize.css',
			array(),
			'1.5.9',
			'all'
		);

		wp_register_style(
			'font-awesome',
			get_template_directory_uri() . '/css/fontawesome/css/font-awesome.min.css',
			array('normalize'),
			'4.7.0',
			'all'
		);

		if ( ! st_speed_on() ) {
			wp_register_style(
				'font-awesome-animation',
				get_template_directory_uri() . '/css/fontawesome/css/font-awesome-animation.min.css',
				array('normalize'),
				false,
				'all'
			);
		}
		
		wp_register_style(
			'st_svg',
			get_template_directory_uri() . '/st_svg/style.css',
			array('normalize'),
			false,
			'all'
		);
		
		$style_dependencies[] = 'normalize';
		$style_dependencies[] = 'font-awesome';
		if ( ! st_speed_on() ) { $style_dependencies[] = 'font-awesome-animation'; }
		$style_dependencies[] = 'st_svg';

		if ( ( isset($GLOBALS['stdata398']) && $GLOBALS['stdata398'] === 'yes' ) && ( trim( $GLOBALS['stdata30'] ) === '' && trim( $GLOBALS['stdata266'] ) === '' ) ) { // スライドショー機能の全停止が有効かつ画像スライドショー又は記事スライドショーも未使用
		} else {
			wp_register_style(
				'slick',
				get_template_directory_uri() . '/vendor/slick/slick.css',
				array(),
				'1.8.0',
				'all'
			);

			wp_register_style(
				'slick-theme',
				get_template_directory_uri() . '/vendor/slick/slick-theme.css',
				array('slick'),
				'1.8.0',
				'all'
			);

			$style_dependencies[] = 'slick';
			$style_dependencies[] = 'slick-theme';
		}

		if ( isset( $GLOBALS["stdata430"] ) && $GLOBALS["stdata430"] === 'yes' ): // display=swapの付与
			$googlefont_swap = '&display=swap';
		else:
			$googlefont_swap = '';
		endif;

		if ( ( isset( $GLOBALS["stdata311"] ) && $GLOBALS["stdata311"] === 'roundedmplus1c' ) ||  ( isset( $GLOBALS["stdata98"] ) && $GLOBALS["stdata98"] === 'roundedmplus1c' ) ) { // M PLUS Rounded 1cを使用
			wp_register_style(
				'fonts-googleapis-roundedmplus1c',
				'//fonts.googleapis.com/css?family=M+PLUS+Rounded+1c:400,700&display=swap&subset=japanese'. $googlefont_swap,
				array(),
				false,
				'all'
			);
		}

		if ( ( isset( $GLOBALS["stdata311"] ) && $GLOBALS["stdata311"] === 'noto' ) ||  ( isset( $GLOBALS["stdata98"] ) && $GLOBALS["stdata98"] === 'noto' ) ) { // Noto Sansを使用
			wp_register_style(
				'fonts-googleapis-notosansjp',
				'//fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&display=swap&subset=japanese'. $googlefont_swap,
				array(),
				false,
				'all'
			);
		}

		if ( trim( $GLOBALS['stdata42'] ) !== '' ) { // 電話番号を追加する
			wp_register_style(
				'fonts-googleapis-lato700',
				'//fonts.googleapis.com/css?family=Lato:700'. $googlefont_swap,
				array(),
				false,
				'all'
			);
		}

		if ( ( isset( $GLOBALS["stdata311"] ) && $GLOBALS["stdata311"] === 'roundedmplus1c' ) ||  ( isset( $GLOBALS["stdata98"] ) && $GLOBALS["stdata98"] === 'roundedmplus1c' ) ) { $style_dependencies[] = 'fonts-googleapis-roundedmplus1c'; }
		if ( ( isset( $GLOBALS["stdata311"] ) && $GLOBALS["stdata311"] === 'noto' ) ||  ( isset( $GLOBALS["stdata98"] ) && $GLOBALS["stdata98"] === 'noto' ) ) { $style_dependencies[] = 'fonts-googleapis-notosansjp'; }
		if ( trim( $GLOBALS['stdata42'] ) !== '' ) { $style_dependencies[] = 'fonts-googleapis-lato700'; }

		if ( ( $custom_font = _st_get_google_font() ) !== null ) {
			wp_register_style(
				'fonts-googleapis-custom',
				$custom_font,
				array(),
				false,
				'all'
			);

			$style_dependencies[] = 'fonts-googleapis-custom';
		}

		wp_register_style(
			'style',
			get_template_directory_uri() . '/style.css',
			$style_dependencies,
			false,
			'all'
		);

		if ( is_child_theme() ) {
			wp_register_style(
				'child-style',
				get_stylesheet_uri(),
				array( 'style' ),
				false,
				'all'
			);

			wp_enqueue_style( 'child-style' );
		} else {
			wp_enqueue_style( 'style' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'st_enqueue_styles' );

if ( ! st_speed_on() ) {
	if ( isset( $GLOBALS['stdata438'] ) && $GLOBALS['stdata438'] === 'yes' ) {
		function st_google_matelial_design() {
			echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">'. "\n";
		}
		add_action( 'wp_head', 'st_google_matelial_design' );
	}
}

if (!function_exists('st_auto_post_slug')) {
	function st_auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
		if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
			$slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
		}

		return $slug;
	}

	if ( isset($GLOBALS['stdata4']) && $GLOBALS['stdata4'] === 'yes' ) {
		add_filter( 'wp_unique_post_slug', 'st_auto_post_slug', 10, 4 );
	}
}

$custom_bgcolor_defaults = array(
	'default-color' => '#f2f2f2',
);
add_theme_support( 'custom-background', $custom_bgcolor_defaults );

if(trim($GLOBALS['stdata62']) !== ''){
	$heightpx = $GLOBALS['stdata62'];
}else{
	$heightpx = 500;
}
if(trim($GLOBALS['stdata70']) !== ''){
	$headerwidthpx = $GLOBALS['stdata70'];
}else{
	$headerwidthpx = 2200;
}
$custom_header = array(
	'random-default' => false,
	'width' => $headerwidthpx,
	'height' => $heightpx,
	'flex-height' => true,
	'flex-width' => false,
	'default-text-color' => '',
	'header-text' => false,
	'uploads' => true,
	'default-image' => get_stylesheet_directory_uri() . '/images/af.png',
);
add_theme_support( 'custom-header', $custom_header );

if (!function_exists('st_custom_excerpt_length')) {
    function st_custom_excerpt_length($length) {
	if(trim($GLOBALS['stdata73']) !== ''){
		$excerptcount = $GLOBALS['stdata73'];
	}else{
		$excerptcount = 100;
	}
	    return $excerptcount;
    }
}
add_filter( 'excerpt_length', 'st_custom_excerpt_length', 999 );

if ( ! function_exists( 'st_get_the_excerpt' ) ) {
	function st_get_the_excerpt( $post = null, $length = 100 ) {
		$replace_filter = _st_function_replace_filter(
			'excerpt_length',
			'st_custom_excerpt_length',
			999,
			function () use ( $length ) {
				return $length;
			}
		);

		return $replace_filter( function () use ( $post ) {
			return apply_filters( 'the_excerpt', get_the_excerpt( $post ) );
		} );
	}
}

if ( ! function_exists( 'st_the_excerpt' ) ) {
	function st_the_excerpt( $post = null, $length = 100 ) {
		echo st_get_the_excerpt( $post, $length );
	}
}

if ( ! function_exists( 'st_the_content' ) ) {

	function st_the_content( $context = 'general', $more_link_text = null, $strip_teaser = false ) {
		ob_start();

		the_content( $more_link_text, $strip_teaser );

		$content = ob_get_clean();
		$context = (array) $context;
		$content = apply_filters( 'st_the_content', $content, $context );

		echo $content;
	}
}

if ( ! function_exists( '_st_some_in_arrray' ) ) {
	/** `in_array($needle, $heystack)` の $needle の配列対応版 */
	function _st_any_in_array( array $needles, array $heystack ) {
		$_heystack = $heystack;

		sort( $_heystack );

		foreach ( $needles as $needle ) {
			$_needle = (array) $needle;

			sort( $_needle );

			if ( array_intersect( $_needle, $heystack ) === $_needle ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'st_insert_content_ads' ) ) {
	function st_insert_content_ads( $content, array $context = array( 'general' ) ) {
		static $cache = array();

		sort( $context );

		$context   = array_unique( $context );
		$cache_key = hash( 'sha256', serialize( array( $content, $context ) ) );

		if ( isset( $cache[ $cache_key ] ) ) {
			echo $cache[ $cache_key ];
		}

		$target_contexts = array(
			array( 'single', 'main' ),
			array( 'page', 'main' ),
			'topin',
		);

		if ( amp_is_amp() || ! _st_any_in_array( $target_contexts, $context ) ) {
			$cache[ $cache_key ] = $content;

			return $content;
		}

		$ad_html              = trim( stripslashes( get_option( 'st-data312', '' ) ) );
		$insert_ads_into_post = (bool) get_option( 'st-data313', '' );
		$insert_ads_into_page = (bool) get_option( 'st-data314', '' );
		$before_1st           = (bool) get_option( 'st-data315', '' );
		$before_2nd           = (bool) get_option( 'st-data316', '' );
		$before_3rd           = (bool) get_option( 'st-data317', '' );
		$before_4th           = (bool) get_option( 'st-data318', '' );
		$before_5th           = (bool) get_option( 'st-data319', '' );

		$is_single = is_single();
		$is_page   = is_page();
		$is_home   = is_home();
		$is_topin  = in_array( 'topin', $context, true );

		$inserted_page_id_on_front = (int) get_option( 'st-data9', '' );
		$insert_page_on_front      = ( $inserted_page_id_on_front > 0 );
		$page_id_on_front          = (int) get_option( 'page_on_front' );
		$show_page_on_front        = ( get_option( 'show_on_front' ) === 'page' && ( $page_id_on_front > 0 ) );
		$post_id                   = ( $is_home && $insert_page_on_front ) ? $inserted_page_id_on_front : get_queried_object_id();

		$show_ads_on_page = true;

		$hide_ads         = ( $is_single || $is_page || ( $is_home && $insert_page_on_front ) )
			? (bool) get_post_meta( $post_id, 'koukoku_set', true )
			: false;

		$insert_ads = ( $is_topin && $is_home && $insert_page_on_front && $show_ads_on_page && ! $hide_ads && $insert_ads_into_page ) ||
		              ( is_front_page() && $show_page_on_front && $show_ads_on_page && ! $hide_ads && $insert_ads_into_page ) ||
		              ( $is_single && ! $hide_ads && $insert_ads_into_post ) ||
		              ( $is_page && $show_ads_on_page && ! $hide_ads && $insert_ads_into_page );

		if ( $ad_html === '' || ! $insert_ads ) {
			$cache[ $cache_key ] = $content;

			return $content;
		}

		$ad_html  = '<div class="st-h-ad">' . $ad_html . '</div>';

		$excluded_classes = array(
			'st-cardbox-t',
		);

		$befores = array(
			1 => $before_1st,
			2 => $before_2nd,
			3 => $before_3rd,
			4 => $before_4th,
			5 => $before_5th,
		);

		$current_count = 0;
		$pattern       = <<<REGEXP
<(?<type>h2)(?<attr>(?:.*?\sclass\s*=\s*(?<quote>["'])(?<class>.*?)\k<quote>)?[^>]*)>(?<content>[\s\S]*?)</\k<type>>
REGEXP;

		$content = preg_replace_callback(
			'!' . $pattern . '!',
			function ( $matches ) use ( $ad_html, $excluded_classes, $befores, &$current_count ) {
				if ( $current_count >= 5 ) {
					return $matches[0];
				}

				$classes = array_map( 'trim', explode( ' ', $matches['class'] ) );

				if ( _st_any_in_array( $excluded_classes, $classes ) ) {
					return $matches[0];
				}

				$current_count ++;

				if ( ! $befores[ $current_count ] ) {
					return $matches[0];
				}

				$h_html = $ad_html .
				          '<' . $matches['type'] . $matches['attr'] . '>' . $matches['content'] . '</' . $matches['type'] . '>';

				return $h_html;
			},
			$content
		);

		$cache[ $cache_key ] = $content;

		return $content;
	}
}
add_filter( 'st_the_content', 'st_insert_content_ads', PHP_INT_MAX, 2 );

if ( ! function_exists( '_st_wp_specialchars' ) ) {
	function _st_wp_specialchars( $string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false ) {
		$string = (string) $string;

		if ( strlen( $string ) === 0 ) {
			return '';
		}

		if ( ! preg_match( '/[&<>"\']/', $string ) ) {
			return $string;
		}

		if ( empty( $quote_style ) ) {
			$quote_style = ENT_NOQUOTES;
		} elseif ( ! in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) ) {
			$quote_style = ENT_QUOTES;
		}

		if ( ! $charset ) {
			static $_charset = null;

			if ( ! isset( $_charset ) ) {
				$alloptions = wp_load_alloptions();
				$_charset   = isset( $alloptions['blog_charset'] ) ? $alloptions['blog_charset'] : '';
			}

			$charset = $_charset;
		}

		if ( in_array( $charset, array( 'utf8', 'utf-8', 'UTF8' ) ) ) {
			$charset = 'UTF-8';
		}

		$_quote_style = $quote_style;

		if ( $quote_style === 'double' ) {
			$quote_style  = ENT_COMPAT;
			$_quote_style = ENT_COMPAT;
		} elseif ( $quote_style === 'single' ) {
			$quote_style = ENT_NOQUOTES;
		}

		if ( ! $double_encode ) {
			$string = wp_kses_normalize_entities( $string );
		}

		$parts          = preg_split( '!(<[^>]*(?:>|$))!', $string, - 1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		$escaped_string = '';

		foreach ( $parts as $part ) {
			if ( preg_match( '!^(<i\s+[^>]*?class\s*=\s*["\'].*?["\'][^>]*>|</i>)$!u', $part ) ) {
				$escaped_string .= $part;
			} else {
				$escaped_string .= @htmlspecialchars( $part, $quote_style, $charset, $double_encode );
			}
		}

		if ( $_quote_style === 'single' ) {
			$escaped_string = str_replace( "'", '&#039;', $escaped_string );
		}

		return $escaped_string;
	}
}

if ( ! function_exists( 'st_esc_html_i' ) ) {
	function st_esc_html_i( $text ) {
		$safe_text = wp_check_invalid_utf8( $text );
		$safe_text = _st_wp_specialchars( $safe_text, ENT_QUOTES );

		return apply_filters( 'esc_html', $safe_text, $text );
	}
}

if ( ! function_exists( 'st_get_template_part' ) ) {
	function st_get_template_part( $slug, $name = null, array $vars = array() ) {
		do_action( 'get_template_part_' . $slug, $slug, $name );

		$templates = array();
		$name      = (string) $name;

		if ( $name !== '' ) {
			$templates[] = $slug . '-' . $name . '.php';
		}

		$templates[] = $slug . '.php';

		st_locate_template( $templates, true, false, $vars );
	}
}

if ( ! function_exists( 'st_locate_template' ) ) {
	function st_locate_template( $template_names, $load = false, $require_once = true, array $vars = array() ) {
		$located = locate_template( $template_names, false );

		if ( $load && $located !== '' ) {
			st_load_template( $located, $require_once, $vars );
		}

		return $located;
	}
}

if ( ! function_exists( 'st_load_template' ) ) {
	function st_load_template( $_template_file, $require_once = true, array $_vars = array() ) {
		global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		if ( is_array( $wp_query->query_vars ) ) {
			extract( $wp_query->query_vars, EXTR_SKIP );
		}

		if ( isset( $s ) ) {
			$s = esc_attr( $s );
		}

		extract( $_vars, EXTR_SKIP );

		if ( $require_once ) {
			require_once $_template_file;
		} else {
			require $_template_file;
		}
	}
}

if ( !function_exists( 'st_custom_excerpt_more' ) ) {
	function st_custom_excerpt_more( $more ) {
		return ' ... ';
	}
}
add_filter( 'excerpt_more', 'st_custom_excerpt_more' );

if ( !function_exists( 'st_wrap_h3' ) ) {
	function st_wrap_h3( $the_content ) {
			$the_content = preg_replace(
				'!(<h3(?:\s+[^>]*)?>)(.+?)(</h3>)!is',
				'$1<i class="fa fa-check-circle"></i><span>$2</span>$3',
				$the_content
			);

		return $the_content;
	}

	if ( isset($GLOBALS['stdata3']) && $GLOBALS['stdata3'] === 'yes' ) {
		add_filter( 'the_content', 'st_wrap_h3' );
	}
}

if ( !function_exists( 'st_is_mobile' ) ) {
	function st_is_mobile() {
		$use_w3tc_settings = trim( $GLOBALS['stdata394'] ) !== '' &&
		                     is_callable( array( 'W3TC\Dispatcher', 'component' ) );

		if ( $use_w3tc_settings ) {
			$mobile = W3TC\Dispatcher::component( 'Mobile_UserAgent' );

			if ( $mobile !== null ) {
				return ( $mobile->get_group() !== false );
			}
		}

		$useragents = array(
			'iPhone', // iPhone
			'iPod', // iPod touch
			'Android.*Mobile', // 1.5+ Android *** Only mobile
			'Windows.*Phone', // *** Windows Phone
			'dream', // Pre 1.5 Android
			'CUPCAKE', // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS', // Palm Pre Experimental
			'incognito', // Other iPhone browser
			'webmate' // Other iPhone browser

		);

		$pattern = '/' . implode( '|', $useragents ) . '/iu';
		$ua      = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';

		return (bool) preg_match( $pattern, $ua );
	}
}

if ( !function_exists( 'st_searchform' ) ) {
	function st_searchform(  ) {
		ob_start();

		get_template_part( 'searchform' );

		return ob_get_clean();
	}
	add_shortcode( '検索', 'st_searchform' );
}

if ( !function_exists( 'st_copy_url_btn' ) ) {
	function st_copy_url_btn(  ) {
		ob_start();

		get_template_part( 'st-copy-btn' );

		return ob_get_clean();
	}
	add_shortcode( 'st-copy-url-btn', 'st_copy_url_btn' );
}

if ( ! function_exists( '_st_store_global_query' ) ) {
	function _st_store_global_query(array $stack = []) {
		global $wp_query, $post, $pages, $page, $numpages, $multipage, $more;

		$stack[] = compact('wp_query', 'post', 'pages', 'page', 'numpages', 'multipage', 'more');

		return $stack;
	}
}

if ( ! function_exists( '_st_restore_global_query' ) ) {
	function _st_restore_global_query(array $stack = []) {
		global $wp_query, $post, $pages, $page, $numpages, $multipage, $more;

		$last = array_pop($stack);

		extract($last, EXTR_OVERWRITE);

		return $stack;
	}
}

if ( ! function_exists( '_st_function_without_filter' ) ) {
	function _st_function_without_filter( $tag, $function_to_remove, $priority = 10 ) {
		return function ( $callable ) use ( $tag, $function_to_remove, $priority ) {
			remove_filter( $tag, $function_to_remove, $priority );

			$result = $callable();

			add_filter( $tag, $function_to_remove, $priority );

			return $result;
		};
	}
}

if ( ! function_exists( '_st_function_replace_filter' ) ) {
	function _st_function_replace_filter( $tag, $function_to_replace, $priority = 10, $function ) {
		return function ( $callable ) use ( $tag, $function_to_replace, $priority, $function ) {
			$without_filter = _st_function_without_filter( $tag, $function_to_replace, $priority );

			return $without_filter( function () use ( $tag, $priority, $function, $callable ) {
				add_filter( $tag, $function, $priority );

				$result = $callable();

				remove_filter( $tag, $function, $priority );

				return $result;
			} );
		};
	}
}

if ( ! function_exists( '_st_query_calculate_offset' ) ) {
	function _st_query_calculate_offset( WP_Query $query ) {
		$posts_per_page = (int) $query->get( 'posts_per_page', get_option( 'posts_per_page', '10' ) );

		if ( $posts_per_page === - 1 ) {
			return 0;
		}

		$offset = $query->get( 'offset' );

		if ( $offset !== '' ) {
			return absint( $offset );
		}

		$paged          = absint( $query->get( 'paged', '1' ) );
		$paged          = min( max( 1, $paged ), $query->max_num_pages );
		$posts_per_page = absint( $query->get( 'posts_per_page', get_option( 'posts_per_page', '10' ) ) );

		return ( $paged - 1 ) * $posts_per_page;
	}
}

if ( ! function_exists( '_st_query_has_next_page' ) ) {
	function _st_query_has_next_page( WP_Query $query ) {
		if ( ! $query->have_posts() ) {
			return false;
		}

		$paged = max( 1, absint( $query->get( 'paged', '1' ) ) );

		return ( $paged < $query->max_num_pages );
	}
}

if ( !function_exists( 'st_designfont_c' ) ) {
	function st_designfont_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontsize'        => '',
			'color'  => '',
			'textshadow'  => '#424242',
			'webfont'  => 'on',
			'fontweight'         => 'bold',
			'margin'   => '0 0 20px 0',
			'fontawesome'  => '',
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . (int) $fontsize . '%;' : ''; //文字サイズ
		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : ''; //太字
		$color_css  = ( $color !== '' ) ? 'color: ' . $color . ';' : ''; //文字色
		$textshadow_css  = ( $textshadow !== '' ) ? 'text-shadow:1px 1px 1px '.$textshadow.';' : ''; //テキストシャドウ
		$webfont_class  = ( $webfont !== '' ) ? 'st-web-font ' : ''; //webfontを適応するクラス
		$margin_css  = ( $margin !== '' ) ? 'margin: ' . $margin . ';' : ''; //マージン
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' aria-hidden="true"></i>' : ''; //Webアイコン
		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-designfont '. esc_attr( $webfont_class . $myclass_class ) .'" style="' . esc_attr( $fontsize_css . $color_css . $textshadow_css . $fontweight_css . $margin_css ) . '">' . $fontawesome_html  . $content . '</p>';
	}
}
add_shortcode('st-designfont','st_designfont_c');

if ( !function_exists( 'st_google_icon_c' ) ) {
	function st_google_icon_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontsize'        => '',
			'color'  => '',
			'googleicon'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . (int) $fontsize . '%;' : ''; //文字サイズ
		$color_css  = ( $color !== '' ) ? 'color: ' . $color . ';' : ''; //文字色
		$googleicon_html = ( $googleicon !== '' ) ? '<i class="material-icons" style="'. esc_attr( $fontsize_css . $color_css ) .'">'. esc_attr( $googleicon ) .'</i>' : ''; //Googleアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return $googleicon_html;
	}
}
add_shortcode('st-google-icon','st_google_icon_c');

if ( !function_exists( 'st_rank_c' ) ) {
	function st_rank_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'rankno'    => '',
			'bgcolor' => '#fafafa',
			'color'   => '#000000',
			'bordercolor' => '',
			'radius'   => '',
			'star' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$rankno_int   = ( $rankno !== '' ) ? (int) $rankno : ''; //id
		$bgcolor_css = ( $bgcolor !== '' ) ? 'padding-left:10px;background-color:' . $bgcolor . ';' : ''; //背景
		$color_css   = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //テキスト色
		$bordercolor_css        = ( $bordercolor !== '' ) ? 'border-bottom:solid 1px ' . $bordercolor . ';' : ''; //ボーダー
		$radius_css  = ( $radius !== '' ) ? 'border-radius: ' . $radius . 'px;' : '';
		$marginbottom_css  = ( ( $bgcolor !== '' ) || ( $bordercolor !== '' ) ) ? 'margin-bottom: 15px;' : '';
		
		if ( ( $rankno_int !== 1 ) && ( $rankno_int !== 2 ) && ( $rankno_int !== 3 ) ) :
			$rankno_int = '-normal';
		endif;
		
		if ( $star !== '' ){
			if ( $star === '5' ){
            	$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
            }elseif ( $star === '45' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i>';
			}elseif ( $star === '4' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '35' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '3' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '2' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '1' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}else{
			$star_mark = '';
		}

		$star_html = ( $star_mark !== '' ) ? '<br/><span class="st-star">'.$star_mark.'</span>' : ''; //スター

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="rankid' . $rankno_int . '" style="margin-bottom:10px;'.$bgcolor_css.$radius_css.$bordercolor_css.$color_css.$marginbottom_css.'"><h4 class="rankh4 rankh4-sc">' . $content . $star_html . '</h4></div>';
	}
}
add_shortcode('st-rank','st_rank_c');

if ( !function_exists( 'st_label_c' ) ) {
	function st_label_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'label'    => 'おすすめ',
			'bgcolor' => '#fafafa',
			'color'   => '#000000',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$text_html   = ( $label !== '' ) ? $label : '注目'; //ラベルテキスト
		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景
		$color_css   = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //ラベル色

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="kanren st-labelbox"><div class="st-labelbox-label"><span style="' . esc_attr( $bgcolor_css . $color_css ) . '" class="st-labelbox-label-text">' . esc_html( $text_html ) . '</span></div>' . $content . '</div>';
	}
}
add_shortcode('st-label','st_label_c');

if ( !function_exists( 'st_ribon_c' ) ) {
	function st_ribon_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'label'    => 'おすすめ',
			'top' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$text_html   = ( $label !== '' ) ? $label : 'おすすめ'; //ラベルテキスト
		$top_css = ( $top !== '' ) ? 'style="top:' . esc_attr( $top ) . 'px;"' : ''; //topの位置

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="st-ribon-box"><p class="st-ribon-label" '. $top_css .'><span class="st-ribon-text">'. $text_html .'</span></p>' . $content . '</div>';
	}
}
add_shortcode('st-ribon','st_ribon_c');

if ( !function_exists( 'st_wide_background_c' ) ) {
	function st_wide_background_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'bgcolor' => '',
			'backgroud_image' => '',
			'align' => '',
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : '';
		$backgroud_image_css  = ( $backgroud_image !== '' ) ? 'background-image: url(\''.esc_url($backgroud_image).'\');' : '';
		$myclass_class  = ( $myclass !== '' ) ? $myclass : '';

		if ( $align === 'l' ) :
			$align_class = 'st-wide-background-left ';
		elseif ( $align === 'r' ) :
			$align_class = 'st-wide-background-right ';
		else:
			$align_class = 'st-wide-background ';
		endif;

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div style="' . $bgcolor_css . $backgroud_image_css . '" class="'. $align_class . esc_attr ( $myclass_class ) .'">' . $content . '</div>';
	}
}
add_shortcode('st-wide-background','st_wide_background_c');

if ( !function_exists( 'st_wide_background_c' ) ) {
	function st_wide_background_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'bgcolor' => '',
			'backgroud_image' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : '';
		$backgroud_image_css  = ( $backgroud_image !== '' ) ? 'background-image: url(\''.esc_url($backgroud_image).'\');' : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div style="' . $bgcolor_css . $backgroud_image_css . '" class="st-wide-background">' . $content . '</div>';
	}
}
add_shortcode('st-wide-background','st_wide_background_c');

if ( !function_exists( 'st_count_reset' ) ) {
	function st_count_reset( $arg, $content = null ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return '<div class="st-count-reset">'.$content.'</div>';
	}
	add_shortcode( 'st-count-reset', 'st_count_reset' );
}

if ( !function_exists( 'st_comment_out_func' ) ) {
	function st_comment_out_func( $arg, $content = null ) {
		return null;
	};
}
add_shortcode('st-comment-out', 'st_comment_out_func');

if ( !function_exists( 'st_div_c' ) ) {
	function st_div_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'class'       => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$class_attr  = ( $class !== '' ) ? $class : ''; //class

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="'. $class_attr .'">' . $content . '</div>';

	}
}
add_shortcode('st-div','st_div_c');

if ( !function_exists( 'st_pre_c' ) ) {
	function st_pre_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'myclass'       => '',
			'text'    => '',
			'fontawesome' => 'fa-code',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス
		$text_html   = ( $text !== '' ) ? $text : ''; //テキスト
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i> ' : '<i class="fa fa-code" aria-hidden="true"></i> '; //Webアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>!', '', $content );
		$content = preg_replace( '!</p>!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<pre class="st-pre '. esc_attr( $myclass_class ) .'"><span class="st-pre-text">' . $fontawesome_html . $text_html . '</span>' . $content . '</pre>';

	}
}
add_shortcode('st-pre','st_pre_c');

if ( !function_exists( 'st_input_tab_c' ) ) {
	function st_input_tab_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'bgcolor'            => '',
			'color'      => '',
            'fontweight' => '',
			'width'     => '30',
			'value' => '',
			'text' => 'タブ',
			'checked' => '',
			'event' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : 'font-weight:normal;'; //見出し太字
		$bgcolor_css        = ( $bgcolor !== '' ) ? 'background-color:' . $bgcolor . ';' : ''; //背景色
        $color_css        = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$width_css = ( $width !== '' ) ? 'width:calc('. $width .'% - 5px );' : 'width:30%;';
		$value_attr       = ( $value !== '' ) ? intval($value) : '';
		$text_attr        = ( $text !== '' ) ? $text : '';
		$checked_attr        = ( $checked !== '' ) ? 'checked="checked"' : '';
		$event_attr        = ( $event !== '' ) ? 'onclick="ga(\'send\', \'event\', \'linkclick\', \'click\', \''. esc_attr($event) . '\');"' : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<input id="tab'. $value_attr .'" class="st-tab-label" title="'. $text_attr .'" '. $checked_attr .' name="st-tab" type="radio" value="'. $value_attr .'" '. $event_attr .'/><label for="tab'. $value_attr .'" style="'. $width_css . $fontweight_css . $bgcolor_css . $color_css .'">'. $text_attr .'</label>';
	}
}
add_shortcode('st-input-tab','st_input_tab_c');

if ( !function_exists( 'st_tab_content_c' ) ) {
	function st_tab_content_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'bgcolor'            => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$bgcolor_css     = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景色

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div id="st-tab-content" style="'. $bgcolor_css .'">' . $content . '</div>';
	}
}
add_shortcode('st-tab-content','st_tab_content_c');

if ( !function_exists( 'st_tab_main_c' ) ) {
	function st_tab_main_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'bgcolor'            => '',
			'bordercolor' => '',
			'value'            => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$value_attr = ( $value !== '' ) ? intval($value) : ''; //コンテンツナンバー
		$bordercolor_css = ( $bordercolor !== '' ) ? 'border:1px solid ' . $bordercolor . ';' : ''; //ボーダー
		$bgcolor_css     = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景色
		$padding_css     = (( $bgcolor !== '' ) || ( $bordercolor !== '' )) ? 'padding:10px;' : ''; //余白

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div id="st-tab-main'. $value_attr .'" class="st-tab-main" style="'. $bgcolor_css . $bordercolor_css . $padding_css .'">' . $content . '</div>';
	}
}
add_shortcode('st-tab-main','st_tab_main_c');

if ( !function_exists( 'st_user_comment_box' ) ) {
	function st_user_comment_box( $atts, $content = null ) {
		$atts = shortcode_atts( array(
        	'title'           => '',
            'user_text'           => '',
			'color'           => '',
            'star' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$color_css   = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$border_color_css   = ( $color !== '' ) ? 'border-color:' . $color . ';' : ''; //ボーダー色
        $title_html   = ( $title !== '' ) ? $title : ''; //タイトル
        $user_text_html   = ( $user_text !== '' ) ? $user_text : ''; //ユーザー属性

		if ( $star !== '' ){
			if ( $star === '5' ){
            	$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
            }elseif ( $star === '45' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i>';
			}elseif ( $star === '4' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '35' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '3' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '2' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '1' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}else{
			$star_mark = '';
		}

		$star_html = ( $star_mark !== '' ) ? '<span class="st-star">'.$star_mark.'</span>' : ''; //スター

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );    
        
		return '<div class="st-user-comment-box" style="'. $border_color_css .'">
<div class="st-user-comment-img">' . $content . '</div><div class="st-user-comment-text"><p style="'. $color_css .'">' . esc_html($title_html) . '</p><p class="st-user-comment-attribute">' . esc_html($user_text_html) .  $star_html .'</p>
</div>
</div>';
	}
}
add_shortcode('st-user-comment-box','st_user_comment_box');

if ( !function_exists( 'st_arrow' ) ) {
	function st_arrow(  ) {
		return '<div class="st-down"></div>';
	}
	add_shortcode( '下矢印', 'st_arrow' );
}

if ( !function_exists( 'st_triangle_down' ) ) {
	function st_triangle_down( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'color'   => '#000000',
		), $atts );
		extract( array_map( 'trim', $atts ), EXTR_SKIP );
		
		$color_css   = ( $color !== '' ) ? 'border-top-color:' . $color . ';' : ''; //色
		return '<div class="st-triangle-down" style="' . esc_attr( $color_css ) . '"></div>';
	}

	add_shortcode( 'st-under-t', 'st_triangle_down' );
}

if ( !function_exists( 'st_maru' ) ) {

	function st_maru(  ) {
		return '<i class="fa fa-circle-o" aria-hidden="true"></i>';
	}

	add_shortcode( 'st-maru', 'st_maru' );
}

if ( !function_exists( 'st_x' ) ) {

	function st_x(  ) {
		return '<i class="fa fa-times" aria-hidden="true"></i>';
	}

	add_shortcode( 'st-x', 'st_x' );
}

if ( !function_exists( 'st_login_check' ) ) {

	function st_login_check( $atts, $content = null ) {
		if ( is_user_logged_in() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return $content;
		}

		return '';
	}

	add_shortcode( 'login-only', 'st_login_check' );
}

if ( !function_exists( 'st_logout_check' ) ) {

	function st_logout_check( $atts, $content = null ) {
		if ( ! is_user_logged_in() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return $content;
		}

		return '';
	}

	add_shortcode( 'logout-only', 'st_logout_check' );
}


if ( !function_exists( 'st_if_is_pc' ) ) {
	function st_if_is_pc( $atts, $content = null ) {
		if ( !wp_is_mobile() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return $content;
		}

		return '';
	}

	add_shortcode( 'pc', 'st_if_is_pc' );
}

if ( !function_exists( 'st_if_is_nopc' ) ) {
	function st_if_is_nopc( $atts, $content = null ) {
		if ( wp_is_mobile() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return $content;
		}

		return '';
	}

	add_shortcode( 'nopc', 'st_if_is_nopc' );
}

if ( !function_exists( 'st_frontsc_func' ) ) {
	function st_frontsc_func( $arg, $content = null ) {
		if( is_front_page() && !is_paged() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return '<div>'.$content.'</div>';
		};
	};
}
add_shortcode('frontonly', 'st_frontsc_func');

if ( !function_exists( 'st_no_frontsc_func' ) ) {
	function st_no_frontsc_func( $arg, $content = null ) {
		if( ! is_front_page() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return '<div>'.$content.'</div>';
		};
	};
}
add_shortcode('no-frontonly', 'st_no_frontsc_func');


if ( !function_exists( 'st_pagesc_func' ) ) {
	function st_pagesc_func( $arg, $content = null ) {
		if( is_page() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return '<div>'.$content.'</div>';
		};
	};
}
add_shortcode('pageonly', 'st_pagesc_func');

if ( !function_exists( 'st_postsc_func' ) ) {
	function st_postsc_func( $arg, $content = null ) {
		if( is_single() ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return '<div>'.$content.'</div>';
		};
	};
}
add_shortcode('postonly', 'st_postsc_func');

if ( !function_exists( 'st_categorysc_func' ) ) {
	function st_categorysc_func( $arg, $content = null ) {
		$atts = shortcode_atts(
			array(
				'cat' => '0',
			),
			$arg
		);

		if ( $content === null || $content === '' ) {
			return '';
		}

		$queried_object_id     = get_queried_object_id();
		$is_main_query         = is_main_query();
		$is_single             = is_single();
		$is_category           = $is_main_query && is_category();
		$is_home_or_front_page = $is_main_query &&
		                         ( get_the_ID() === $queried_object_id ) && ( is_home() || is_front_page() );

		if ( $is_home_or_front_page ) {
			return '';
		}

		if ( ! $is_single && ! $is_category ) {
			return '';
		}

		$cat_ids = explode( ',', $atts['cat'] );
		$cat_ids = array_reduce(
			$cat_ids,
			function ( $new_cat_ids, $cat_id ) {
				$cat_id = trim( $cat_id );

				if ( preg_match( '/\A[0-9]+\z/', $cat_id ) ) {
					$new_cat_ids[] = (int) $cat_id;
				}

				return $new_cat_ids;
			},
			array()
		);
		$cat_ids = array_unique( $cat_ids );
		$cat_id  = implode( ',', $cat_ids );
		$cat_id  = ( $cat_id !== '' ) ? $cat_id : '0';
		$cat_ids = array_map( 'intval', explode( ',', $cat_id ) );

		if ( in_array( 0, $cat_ids, true ) ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return '<div>' . $content . '</div>';
		}

		if ( $is_single && in_category( $cat_ids ) ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return '<div>' . $content . '</div>';
		}

		if ( $is_category && in_array( $queried_object_id, $cat_ids, true ) ) {
			$content = do_shortcode( shortcode_unautop( $content ) );
			return '<div>' . $content . '</div>';
		}

		return '';
	}
}
add_shortcode( 'catonly', 'st_categorysc_func' );

if ( ! function_exists( 'st_cardsc_func' ) ) {
	function st_cardsc_func( $arg, $content = '' ) {
		$globals = array();
		$globals = _st_store_global_query( $globals );

		$atts = shortcode_atts(
			array(
				'id'       => '0',
				'label'    => '',
				'name'     => '',
				'bgcolor'  => '#ffa520',
				'color'    => '#ffffff',
				'readmore' => 'off',
				'fontawesome'  => '',
			),
			$arg
		);

		$atts = array_map( 'trim', $atts );

		$post_id    = (int) $atts['id'];
		$post_query = new WP_Query( array(
			'p'              => $post_id,
			'post_type'      => 'any',
			'posts_per_page' => 1,
		) );

		if ( ! $post_query->have_posts() ) {
			_st_restore_global_query( $globals );

			return '';
		}

		$card_label  = $atts['label'];
		$card_name   = $atts['name'];
		$bgcolor_css = ( $atts['bgcolor'] !== '' ) ? 'background:' . $atts['bgcolor'] . ';' : '';
		$color_css   = ( $atts['color'] !== '' ) ? 'color:' . $atts['color'] . ';' : '';
		$readmore    = ( $atts['readmore'] === 'on' );
		$fontawesome_html = ( $atts['fontawesome'] !== '' ) ? '<i class="fa ' . esc_attr( $atts['fontawesome'] ) . '" aria-hidden="true"></i>' : '';

		$wpp_view_limit = trim( get_option( 'st-data223', '' ) );
		$wpp_view_limit = ( $wpp_view_limit !== '' ) ? (int) $wpp_view_limit : 9999;

		$wpp_view_limit_label = trim( get_option( 'st-data224', '' ) );
		$wpp_view_limit_label = ( $wpp_view_limit_label !== '' ) ? $wpp_view_limit_label : '殿堂';

		$show_wpp_view_count = (bool) trim( get_option( 'st-data229', '' ) );
		$default_thumbnail   = trim( get_option( 'st-data97', '' ) );
		$hide_excerpt_on_pc  = (bool) trim( get_option( 'st-data221', '' ) );

		$html = '';

		while ( $post_query->have_posts() ) {
			$post_query->the_post();

			ob_start();

			?>
			<a href="<?php the_permalink() ?>" class="st-cardlink">
			<div class="kanren st-cardbox">
				<?php if ( $card_label !== '' || $fontawesome_html !== '' ): //ラベルを挿入 ?>
					<div class="st-cardbox-label"><span style="<?php echo esc_attr( $bgcolor_css . $color_css ); ?>" class="st-cardbox-label-text"><?php echo $fontawesome_html; ?><?php echo esc_html( $card_label ); ?></span></div>
				<?php elseif ( $show_wpp_view_count && function_exists( 'wpp_get_views' ) ): ?>
					<?php $wpp_view_count = max(0, (int) wpp_get_views( get_the_ID(), null, false ) ); // 計測数 ?>
					<?php if ( $wpp_view_count > $wpp_view_limit ): ?>
						<div class="st-cardbox-label st-wppview-limit-over"><span style="<?php echo esc_attr( $bgcolor_css . $color_css ); ?>" class="st-cardbox-label-text"><?php echo esc_html( $wpp_view_limit_label ); ?></span></div>
					<?php else: ?>
						<div class="st-cardbox-label"><span style="<?php echo esc_attr( $bgcolor_css . $color_css ); ?>" class="st-cardbox-label-text"><?php echo esc_html( number_format_i18n( $wpp_view_count ) );?><span class="wpp-text">view</span></span></div>
					<?php endif; ?>
				<?php endif; ?>
				<dl class="clearfix">
					<dt class="st-card-img">
							<?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
								<?php get_template_part( 'st-thumbnail' ); ?>
							<?php else: // サムネイルを持っていないときの処理 ?>
								<?php if ( $default_thumbnail !== '' ): ?>
									<img src="<?php echo esc_url( $default_thumbnail ); ?>" alt="no image" title="no image" width="300" height="300" />
								<?php else: ?>
									<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
								<?php endif; ?>
							<?php endif; ?>
					</dt>
					<dd>
						<?php if (  $card_name !== '' ): //タイトルを変更 ?>
							<h5 class="st-cardbox-t"><?php echo esc_html( $card_name ); ?></h5>
						<?php else: ?>
							<h5 class="st-cardbox-t"><?php the_title(); ?></h5>
						<?php endif; ?>

						<?php if ( ( ! $hide_excerpt_on_pc && ! st_is_mobile() ) || ( st_is_mobile() && trim( $GLOBALS['stdata280'] ) !== '' ) ): ?>
							<div class="st-card-excerpt smanone">
								<?php the_excerpt(); //抜粋文 ?>
							</div>
						<?php endif; ?>
						<?php if ( $readmore ): ?>
							<p class="cardbox-more">続きを見る</p>
						<?php endif; ?>
					</dd>
				</dl>
			</div>
			</a>
			<?php

			$html = ob_get_clean();
		}

		wp_reset_postdata();

		_st_restore_global_query( $globals );

		return $html;
	}
}
add_shortcode( 'st-card', 'st_cardsc_func' );

if ( ! function_exists( 'st_manage_oembed' ) ) {
	function st_manage_oembed() {
		global $wp;
		global $wp_embed;

		$oembed_disabled = ( get_option( 'st-data238', '' ) === 'yes' );

		$wp_embed->usecache = true;

		add_filter( 'oembed_ttl', function ( $time ) {
			return 60 * 60 * 24;
		} );

		if ( ! $oembed_disabled ) {
			return;
		}

		add_filter( 'embed_maybe_make_link', function ($output, $url)  {
			return $url;
		}, 10, 2);

		$wp->public_query_vars = array_diff(
			$wp->public_query_vars,
			array(
				'embed',
			)
		);

		remove_filter( 'the_content_feed', '_oembed_filter_feed_content' );
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result' );
		remove_filter( 'oembed_response_data', 'get_oembed_response_data_rich' );
		remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result' );
		add_filter( 'embed_oembed_discover', '__return_false', PHP_INT_MAX );

		add_filter( 'tiny_mce_plugins',
			function ( $plugins ) {
				return array_diff( $plugins, array( 'wpembed' ) ); }
		);

		add_filter(
			'rewrite_rules_array',
			function ( $rules ) {
				foreach ( $rules as $rule => $rewrite ) {
					if ( strpos( $rewrite, 'embed=true' ) !== false ) {
						unset( $rules[ $rule ] );
					}
				}

				return $rules;
			}
		);
	}
}
add_action( 'init', 'st_manage_oembed' );

if ( ! function_exists( '_st_process_shortcodes' ) ) {
	function _st_function_create_shortcode_processor( $name, $processor ) {
		return function ( $content, $tags_to_process = array(), $ignore_html = false ) use ( $name, $processor ) {
			static $cache = array();

			global $shortcode_tags;

			$tags_to_process = is_array( $tags_to_process ) ? $tags_to_process : array( $tags_to_process );
			$tags_to_process = array_unique( $tags_to_process );

			sort( $tags_to_process );

			$cacheKey = hash( 'sha256', serialize( array( $content, $tags_to_process ) ) );

			if ( isset( $cache[ $cacheKey ] ) ) {
				return $cache[ $cacheKey ];
			}

			if ( strpos( $content, '[' ) === false ) {
				return $content;
			}

			if ( empty( $shortcode_tags ) || ! is_array( $shortcode_tags ) ) {
				return $content;
			}

			preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );

			$tags_to_process = apply_filters( 'st_' . $name . '_shortcodes_tagnames', $tags_to_process, $content );
			$tagnames        = array_intersect( $tags_to_process, $matches[1] );

			if ( empty( $tagnames ) ) {
				return $content;
			}

			$content = do_shortcodes_in_html_tags( $content, $ignore_html, $tagnames );
			$pattern = get_shortcode_regex( $tagnames );

			$content = preg_replace_callback( "/{$pattern}/", $processor, $content );
			$content = unescape_invalid_shortcodes( $content );

			$cache[ $cacheKey ] = $content;

			return $content;
		};
	}
}

if ( ! function_exists( '_st_do_shortcodes' ) ) {
	function _st_do_shortcodes( $content, $tags_to_do = array(), $ignore_html = false ) {
		static $process_shortcodes = null;

		if ( $process_shortcodes === null ) {
			$process_shortcodes = _st_function_create_shortcode_processor( 'do', 'do_shortcode_tag' );
		}

		return $process_shortcodes( $content, $tags_to_do, $ignore_html );
	}
}

if ( ! function_exists( '_st_strip_shortcodes' ) ) {
	function _st_strip_shortcodes( $content, $tags_to_remove = array() ) {
		static $process_shortcodes = null;

		if ( $process_shortcodes === null ) {
			$process_shortcodes = _st_function_create_shortcode_processor(
				'strip',
				function ( $matches ) {
					if ( $matches[1] === '[' && $matches[6] === ']' ) {
						return $matches[1] . substr( $matches[0], 1, - 1 ) . $matches[6];
					}

					return $matches[1] . $matches[6];
				}
			);
		}

		return $process_shortcodes( $content, $tags_to_remove, true );
	}
}

if ( !function_exists( 'st_trim_excerpt' ) ) {
	function st_trim_excerpt( $text = '' ) {
		global $page, $pages;
		if ( $text !== '' ) {
			$text = preg_replace( '@<(noscript)[^>]*?>.*?</\\1>@siu', '', $text );

			return wp_strip_all_tags( $text );
		}

		$post  = get_post();
		$page  = $page ? $page : 1;
		$pages = is_array( $pages ) ? $pages : array( $post->post_content );

		$text = get_the_content( '' );
		$text = _st_strip_shortcodes( $text, [ 'st-catgroup', 'st-taggroup', 'st-postgroup', 'st-card', 'st_af', 'wpdm_package', 'st-pv-monitor', 'st-osusume' ] );
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]&gt;', $text );

		$excerpt_length = apply_filters( 'excerpt_length', 55 );

		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
		$text         = wp_trim_words( $text, $excerpt_length, $excerpt_more );

		return $text;
	}
}
add_filter( 'get_the_excerpt', 'st_trim_excerpt', 9 );

if ( !function_exists( 'st_margin' ) ) {
	function st_margin( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'margin'   => '0 0 20px 0',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$margin_css  = ( $margin !== '' ) ? 'margin: ' . $margin . ';' : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="st-margin" style="' . esc_attr( $margin_css ) . '">' . $content . '</div>';
	}
}
add_shortcode('st-margin','st_margin');

if ( !function_exists( 'st_minihukidashi' ) ) {
	function st_minihukidashi( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
			'bgcolor' => '#fffde7',
			'color'   => '#1a1a1a',
			'margin'   => '0 0 20px 0',
			'fontsize'           =>  '',
			'fontweight'         => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景
		$color_css   = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$before_css  = ( $bgcolor !== '' ) ? 'border-top-color: ' . $bgcolor . ';' : '';
		$margin_css  = ( $margin !== '' ) ? 'margin: ' . $margin . ';' : '';
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . $fontsize . '%;' : ''; //文字サイズ
		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : ''; //太字

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-minihukidashi" style="' . esc_attr( $bgcolor_css . $color_css . $margin_css . $fontsize_css . $fontweight_css ) . '"><span style="' . esc_attr( $before_css ) . '"></span>' . $fontawesome_html . $content . '</p>';
	}
}
add_shortcode('st-minihukidashi','st_minihukidashi');

if ( !function_exists( 'st_marumozi' ) ) {
	function st_marumozi( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
			'bgcolor' => '#fffde7',
			'color'   => '#1a1a1a',
			'radius'   => '30',
			'margin'   => '0 10px 0 0',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景
		$color_css   = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$radius_css  = ( $radius !== '' ) ? 'border-radius: ' . $radius . 'px;' : '';
		$margin_css  = ( $margin !== '' ) ? 'margin: ' . $margin . ';' : '';
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<span class="st-marumozi" style="' . esc_attr( $bgcolor_css . $color_css . $radius_css . $margin_css ) . '">' . $fontawesome_html . $content . '</span>';
	}
}
add_shortcode('st-marumozi','st_marumozi');

if ( !function_exists( 'st_marumozi_big' ) ) {
	function st_marumozi_big( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
			'bgcolor' => '#fffde7',
			'color'   => '#1a1a1a',
			'radius'   => '30',
			'margin'   => '0 10px 0 0',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景
		$color_css   = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$radius_css  = ( $radius !== '' ) ? 'border-radius: ' . $radius . 'px;' : '';
		$margin_css  = ( $margin !== '' ) ? 'margin: ' . $margin . ';' : '';
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-marumozi-big-p"><span class="st-marumozi-big" style="' . esc_attr( $bgcolor_css . $color_css . $radius_css . $margin_css ) . '">' . $fontawesome_html . $content . '</span></p>';
	}
}
add_shortcode('st-marumozi-big','st_marumozi_big');

if ( !function_exists( 'st_memo_c' ) ) {
	function st_memo_c( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'fontawesome' => 'fa-file-text-o',
			'bordercolor' => '',
			'bgcolor' => '#fafafa',
			'iconcolor' => '#919191',
			'color' => '#000000',
			'iconsize' => '100',
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );
				
		if ( $bordercolor !== '' ){
			$bordercolor = $bordercolor;		
		}elseif ( $iconcolor === '#919191' ){
			$bordercolor = '#E0E0E0';
		}else{
			$bordercolor = $iconcolor;			
		}
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$bgcolor_css      = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景
		$color_css        = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$iconcolor_css        = ( $iconcolor !== '' ) ? 'color:' . $iconcolor . ';' : ''; //見出し色
		$iconsize_css        = ( $iconsize !== '' ) ? 'font-size:' . $iconsize . '%;' : ''; //フォントサイズ
		$bordercolor_css        = ( $bordercolor !== '' ) ? 'border-color:' . $bordercolor . ';' : ''; //ボーダー
		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス
		
		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		
		return '<div class="clip-memobox ' . esc_attr ( $myclass_class ) . '" style="' . esc_attr( $bgcolor_css . $color_css ) . '"><div class="clip-fonticon" style="' . esc_attr( $iconsize_css . $iconcolor_css ) . '">' . $fontawesome_html . '</div><div class="clip-memotext" style="' . esc_attr( $bordercolor_css ) . '"><p style="' . esc_attr( $color_css ) . '">'.$content.'</p></div></div>';
	}
}
add_shortcode('st-cmemo','st_memo_c');

if ( !function_exists( 'st_square_checkbox_c' ) ) {
	function st_square_checkbox_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'bgcolor' => '',
			'bordercolor'   => '',
			'borderwidth'        => '3',
			'fontweight'         => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景
		$bordercolor_css        = ( $bordercolor !== '' ) ? 'border-color:' . $bordercolor . ';' : ''; //ボーダー
		$borderwidth_css  = ( $borderwidth !== '' ) ? 'border-width:' . $borderwidth . 'px;' : ''; //枠線の太さ
		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : ''; //太字
		$nobox_class  = ( ( $borderwidth !== '' ) || ( $bgcolor !== '' ) ) ? '' : ' st-square-checkbox-nobox';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div style="' . $bgcolor_css . $bordercolor_css . $borderwidth_css . $fontweight_css . '" class="st-square-checkbox' . $nobox_class . '">' . $content . '</div>';
	}
}
add_shortcode('st-square-checkbox','st_square_checkbox_c');

if ( !function_exists( 'st_item_box_c' ) ) {
	function st_item_box_c( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'link' => '#',
			'target' => '_blank',
			'rel' => 'nofollow',
			'img' => '',
			'title' => '',
			'price' => '',
            'star' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );
        
        $noimg = get_template_directory_uri().'/images/no-img.png';
				
		if ( $star !== '' ){
			if ( $star === '5' ){
            	$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
            }elseif ( $star === '45' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i>';
			}elseif ( $star === '4' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '35' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '3' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '2' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '1' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}else{
			$star_mark = '';
		}
        
		$link_url = ( $link !== '' ) ? esc_html($link) : '#'; //リンク先
		$target_attr     = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$rel_attr        = ( $rel !== '' ) ? 'rel="nofollow' : ''; //nofollow
		$img_url    = ( $img !== '' ) ? $img : $noimg; //画像URL
		$title_html       = ( $title !== '' ) ? '<h5 class="st-cardbox-t">' . esc_html($title) . '</h5>' : ''; //タイトル
		$price_html        = ( $price !== '' ) ? '<p class="itembox-price">価格' . esc_html($price) . '円</p>' : ''; //料金
		$star_html        = ( $star_mark !== '' ) ? '<span class="itembox-star st-star">'.$star_mark.'</span><br/>' : ''; //スター

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		
		return '<a href="'.$link_url.'" class="itembox-link"><div class="kanren st-cardbox st-itmebox"><dl class="clearfix"><dt><img src="' . $img_url . '"/></dt><dd>' . $title_html . '<div class="itembox-guide"><p>'.$star_html.$content.'</p>'.$price_html.'</div></dd></dl></div></a>';
	}

}
add_shortcode('st-itembox','st_item_box_c');

if ( !function_exists( 'st_button_c' ) ) {
	function st_button_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
			'title'       => 'ボタン',
			'type'        => 'A',
			'rel'         => '',
			'url'         => '#',
			'target'      => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン'; //テキスト
		$type         = ( $type !== '' ) ? $type : 'A'; //タイプ
		$url          = ( $url !== '' ) ? $url : '#'; //URL
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : ''; //nofollow
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット

		if ( trim( $fontawesome ) !== '' ) {
			$fontawesome_html = '<i class="fa  ' . esc_attr( $fontawesome ) . '" aria-hidden="true"></i>';
		} else {
			$fontawesome_html = '';
		} //Webアイコン

		if ( $type === 'A' ) { //タイプ
			return '<div class="rankstlink-r2"><p><a href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . '</a></p></div>';
		} else {
			return '<div class="rankstlink-l2"><p><a href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . '</a></p></div>';
		}
	}
}
add_shortcode('st-button','st_button_c');

if ( !function_exists( 'st_mybutton_c' ) ) {
	function st_mybutton_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome'        => '',
			'title'              => 'ボタン',
			'rel'                => '',
			'url'                => '#',
			'target'             => '',
			'fontawesome'        => 'fa-check-circle',
			'fontawesome_after'  => '',
			'bgcolor'            => '#ffffff',
			'bgcolor_top'            => '',
			'bordercolor'        => '#757575',
			'borderwidth'        => '2',
			'borderradius'       => '5',
			'fontweight'         => 'bold',
			'color'              => '#424242',
			'width'              => '',
			'fontsize'           =>  '',
			'ref'                =>  '',
			'shadow'            => '',
			'class'       => '',
			'event' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン'; //テキスト
		$url          = ( $url !== '' ) ? $url : '#'; //URL
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : ''; //nofollow
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$fontawesome_after_html = ( $fontawesome_after !== '' ) ? '<i class="fa fa-after ' . esc_attr( $fontawesome_after ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン（後）
		$bordercolor_css  = ( $bordercolor !== '' ) ? 'border-color:' . $bordercolor . ';' : ''; //枠線
		$borderwidth_css  = ( $borderwidth !== '' ) ? 'border-width:' . $borderwidth . 'px;' : ''; //枠線の太さ
		$borderradius_css = ( $borderradius !== '' ) ? 'border-radius:' . $borderradius . 'px;' : ''; //枠線の丸み
		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : 'font-weight:normal;'; //見出し太字
		$color_css        = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$width_html  = ( $width !== '' ) ? 'width:' . $width . '%;' : ''; //幅
		$width_class  = ( $width === '' ) ? ' st-btn-default' : ''; //幅のクラス
		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . $fontsize . '%;' : ''; //文字サイズ
		$rel_class  = ( $ref !== '' ) ? ' st-reflection' : ''; //光る演出
		$noborder_class  = ( $borderwidth !== '' ) ? '' : ' st-mybtn-noborder'; //枠線の無いクラス
		$shadow_css  = ( $shadow !== '' ) ? 'box-shadow:0 3px 0 ' . $shadow . ';' : ''; //影
		$class_attr  = ( $class !== '' ) ? $class : ''; //class
		$event_attr        = ( $event !== '' ) ? ' onclick="ga(\'send\', \'event\', \'linkclick\', \'click\', \''. esc_attr($event) . '\');"' : '';
		
		if( ( $bgcolor_top !== '' ) && ( $bgcolor !== '' ) ):
			$bgcolor_css  = 'background:' . $bgcolor . '; background: linear-gradient(to bottom, ' . $bgcolor_top . ', ' . $bgcolor . ');';
		elseif( ( $bgcolor_top == '' ) && ( $bgcolor !== '' ) ):
			$bgcolor_css  = 'background:' . $bgcolor . ';';
		else:
			$bgcolor_css  = '';
		endif;

		return '<p class="'. $class_attr . ' st-mybtn' . $rel_class .  $width_class . $noborder_class . '" style="'.$bgcolor_css.$bordercolor_css.$borderwidth_css.$borderradius_css.$fontsize_css.$fontweight_css.$color_css.$width_html.$shadow_css.'"><a style="'.$fontweight_css.$color_css.'" href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . $event_attr . '>' . $fontawesome_html . esc_html( $title ) . $fontawesome_after_html .'</a></p>';

	}
}
add_shortcode('st-mybutton','st_mybutton_c');

if ( !function_exists( 'st_mybutton_mini_c' ) ) {
	function st_mybutton_mini_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome'        => '',
			'title'              => 'ボタン',
			'rel'                => '',
			'url'                => '#',
			'target'             => '',
			'fontawesome'        => 'fa-check-circle',
			'fontawesome_after'  => '',
			'bgcolor'            => '#ffffff',
			'bgcolor_top'            => '',
			'borderradius'       => '5',
			'fontweight'         => 'bold',
			'color'              => '#424242',
			'fontsize'           =>  '',
			'ref'                =>  '',
			'shadow'            => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン'; //テキスト
		$url          = ( $url !== '' ) ? $url : '#'; //URL
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : ''; //nofollow
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$fontawesome_after_html = ( $fontawesome_after !== '' ) ? '<i class="fa fa-after ' . esc_attr( $fontawesome_after ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン（後）
		$borderradius_css = ( $borderradius !== '' ) ? 'border-radius:' . $borderradius . 'px;' : ''; //枠の丸み
		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : 'font-weight:normal;'; //見出し太字
		$color_css        = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . $fontsize . '%;' : ''; //文字サイズ
		$rel_class  = ( $ref !== '' ) ? ' st-reflection' : ''; //光る演出
		$shadow_css  = ( $shadow !== '' ) ? 'box-shadow:0 1px 0 ' . $shadow . ';' : ''; //影
		
		if( ( $bgcolor_top !== '' ) && ( $bgcolor !== '' ) ):
			$bgcolor_css  = 'background:' . $bgcolor . '; background: linear-gradient(to bottom, ' . $bgcolor_top . ', ' . $bgcolor . ');';
		elseif( ( $bgcolor_top == '' ) && ( $bgcolor !== '' ) ):
			$bgcolor_css  = 'background:' . $bgcolor . ';';
		else:
			$bgcolor_css  = '';
		endif;

		return '<span class="st-mybtn st-mybtn-mini' . $rel_class .'"><a  style="'.$bgcolor_css.$borderradius_css.$fontsize_css.$fontweight_css.$color_css.$shadow_css.'" href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . $fontawesome_after_html .'</a></span>';

	}
}
add_shortcode('st-mybutton-mini','st_mybutton_mini_c');

if ( !function_exists( 'st_mcbutton_c' ) ) {
	function st_mcbutton_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome'        => '',
			'title'              => 'ボタン',
			'rel'                => '',
			'url'                => '#',
			'target'             => '',
			'fontawesome'        => 'fa-check-circle',
			'fontawesome_after'  => '',
			'bgcolor'            => '#ffffff',
			'bgcolor_top'            => '',
			'bordercolor'        => '#757575',
			'borderwidth'        => '2',
			'borderradius'       => '5',
			'fontweight'         => 'bold',
			'color'              => '#424242',
			'width'              => '',
			'fontsize'           =>  '',
			'ref'                =>  '',
			'shadow'            => '',

			'mcbox_title'           =>  '',
			'mcbox_bg'           =>  '',
			'mcbox_color'        =>  '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン'; //テキスト
		$url          = ( $url !== '' ) ? $url : '#'; //URL
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : ''; //nofollow
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$fontawesome_after_html = ( $fontawesome_after !== '' ) ? '<i class="fa fa-after ' . esc_attr( $fontawesome_after ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン（後）
		$bordercolor_css  = ( $bordercolor !== '' ) ? 'border-color:' . $bordercolor . ';' : ''; //枠線
		$borderwidth_css  = ( $borderwidth !== '' ) ? 'border-width:' . $borderwidth . 'px;' : ''; //枠線の太さ
		$borderradius_css = ( $borderradius !== '' ) ? 'border-radius:' . $borderradius . 'px;' : ''; //枠線の丸み
		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : 'font-weight:normal;'; //見出し太字
		$color_css        = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$width_html  = ( $width !== '' ) ? 'width:' . $width . '%;' : ''; //幅
		$width_class  = ( $width === '' ) ? ' st-btn-default' : ''; //幅のクラス
		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . $fontsize . '%;' : ''; //文字サイズ
		$rel_class  = ( $ref !== '' ) ? ' st-reflection' : ''; //光る演出
		$shadow_css  = ( $shadow !== '' ) ? 'box-shadow:0 3px 0 ' . $shadow . ';' : ''; //影

		$mcbox_title        = ( $mcbox_title !== '' ) ? $mcbox_title : '';
		$mcbox_bg_css        = ( $mcbox_bg !== '' ) ? 'margin-bottom: 20px;padding: 20px 10px;background:' . $mcbox_bg . ';' : '';
		$mcbox_color_css        = ( $mcbox_color !== '' ) ? 'color:' . $mcbox_color . ';' : '';
		$mcbox_title_html       = ( $mcbox_title !== '' ) ? '<p class="st-mcbox-title center" style="' . $mcbox_color_css . '">' . $mcbox_title . '</p>' : '';
		
		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . $fontsize . '%;' : ''; //文字サイズ
		
		if( ( $bgcolor_top !== '' ) && ( $bgcolor !== '' ) ):
			$bgcolor_css  = 'background:' . $bgcolor . '; background: linear-gradient(to bottom, ' . $bgcolor_top . ', ' . $bgcolor . ');';
		elseif( ( $bgcolor_top == '' ) && ( $bgcolor !== '' ) ):
			$bgcolor_css  = 'background:' . $bgcolor . ';';
		else:
			$bgcolor_css  = '';
		endif;

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="st-mcbtn-box" style="' . $mcbox_bg_css . '">' . $mcbox_title_html . '<p class="st-mybtn' . $rel_class .  $width_class .'" style="'.$bgcolor_css.$bordercolor_css.$borderwidth_css.$borderradius_css.$fontsize_css.$fontweight_css.$color_css.$width_html.$shadow_css.'"><a style="'.$fontweight_css.$color_css.'" href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . $fontawesome_after_html .'</a></p><p class="st-mcbox-text">' . $content . '</p></div>';

	}
}
add_shortcode('st-mcbutton','st_mcbutton_c');

if ( !function_exists( 'st_step_c' ) ) {
	function st_step_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'step_no'            => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$step_no_html = ( $step_no !== '' ) ? $step_no : '1'; //ステップ数

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-step-title"><span class="st-step-box"><span class="st-step">step<br/><span class="st-step-no">'. $step_no_html .'</span></span></span>' . $content . '</p>';
	}
}
add_shortcode('st-step','st_step_c');

if ( !function_exists( 'st_point_c' ) ) {
	function st_point_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontsize'        => '',
			'bordercolor'  => '',
			'fontweight'         => 'bold',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . (int) $fontsize . '%;' : ''; //文字サイズ
		$fontweight_css  = ( $fontweight !== '' ) ? 'font-weight:bold;' : ''; //太字
        $bordercolor_css  = ( $bordercolor !== '' ) ? 'padding-bottom:20px;border-bottom:1px dotted ' . $bordercolor . ';' : ''; //下線

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-point" style="' . esc_attr( $fontsize_css . $bordercolor_css ) . '"><span class="st-point-text" style="' . esc_attr( $fontweight_css ) . '">' . $content . '</span></p>';
	}
}
add_shortcode('st-point','st_point_c');

if ( !function_exists( 'st_mybox_c' ) ) {
	function st_mybox_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome'  => 'fa-check-circle',
			'title'        => 'ポイント',
			'bgcolor'      => '#ffffff',
			'bordercolor'  => '#757575',
			'borderwidth'  => '2',
			'borderradius' => '5',
			'titleweight'  => 'bold',
			'title_bordercolor' => '',
			'color'        => '#424242',
			'fontsize'        => '',
			'myclass'  => '',
			'margin'   => '25px 0',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$bgcolor_css      = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';' : ''; //背景
		$bordercolor_css  = ( $bordercolor !== '' ) ? 'border-color:' . $bordercolor . ';' : ''; //枠線
		$borderwidth_css  = ( $borderwidth !== '' ) ? 'border-width:' . $borderwidth . 'px;' : 'border-width: 0;'; //枠線の太さ
		$borderradius_css = ( $borderradius !== '' ) ? 'border-radius:' . $borderradius . 'px;' : ''; //枠線の丸み
		$titleweight_css  = ( $titleweight !== '' ) ? 'font-weight:bold;' : 'font-weight:normal;'; //見出し太字
		$color_css        = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . (int) $fontsize . '%;' : ''; //文字サイズ
		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス
		$margin_css  = ( $margin !== '' ) ? 'margin: ' . $margin . ';' : ''; //マージン

		$titlebox    = '';
		$title_class = '';

		if ( $title !== '' ){
			$title_class = ' has-title ';

			if ( $bgcolor === '#ffffff' || $bgcolor === '' ){
				$titlebg = 'background: #ffffff;';
			} else {
				$titlebg = 'text-shadow: #fff 3px 0px 0px, #fff 2.83487px 0.981584px 0px, #fff 2.35766px 1.85511px 0px, #fff 1.62091px 2.52441px 0px, #fff 0.705713px 2.91581px 0px, #fff -0.287171px 2.98622px 0px, #fff -1.24844px 2.72789px 0px, #fff -2.07227px 2.16926px 0px, #fff -2.66798px 1.37182px 0px, #fff -2.96998px 0.42336px 0px, #fff -2.94502px -0.571704px 0px, #fff -2.59586px -1.50383px 0px, #fff -1.96093px -2.27041px 0px, #fff -1.11013px -2.78704px 0px, #fff -0.137119px -2.99686px 0px, #fff 0.850987px -2.87677px 0px, #fff 1.74541px -2.43999px 0px, #fff 2.44769px -1.73459px 0px, #fff 2.88051px -0.838246px 0px;';
			}

			if ( $title_bordercolor ){
				$title_bordercolor_css  = 'border-bottom-color: '. $title_bordercolor;
				$myclass_class .=  ' st-title-border';
			}else{
				$title_bordercolor_css  = '';
			}

			$titlebox = '<p class="st-mybox-title" style="' . esc_attr( $color_css . $titleweight_css . $titlebg . $fontsize_css . $title_bordercolor_css ) . '">' . $fontawesome_html . $title . '</p>';

		}

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		return '<div class="st-mybox ' . esc_attr ( $title_class . $myclass_class ) . '" style="' . esc_attr( $bgcolor_css . $bordercolor_css . $borderwidth_css . $borderradius_css . $margin_css ) . '">' . $titlebox .
		       '<div class="st-in-mybox">' . $content . '</div>' .
		       '</div>';
	}
}
add_shortcode('st-mybox','st_mybox_c');

if ( !function_exists( 'st_midasibox_c' ) ) {
	function st_midasibox_c( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'fontawesome'  => 'fa-file-text-o',
			'title'        => '見出し（全角15文字）',
			'bgcolor'      => '#ffffff',
			'bordercolor'  => '#919191',
			'borderwidth'  => '2',
			'borderradius' => '5',
			'titleweight'  => 'bold',
			'color'        => '#000000',
			'myclass'  => '',
		), $atts);

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontawesome_html = $fontawesome !== '' ? '<i class="fa  ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : '';
		$bgcolor_css      = $bgcolor !== '' ? 'background:' . $bgcolor . ';' : ''; //背景
		$color_css        = $color !== '' ? 'color:' . $color . ';' : ''; //見出し色
		$borderwidth_css  = $borderwidth !== '' ? 'border-width:' . $borderwidth . 'px;' : '';
		$titleweight_css  = ( $titleweight !== '' ) ? 'font-weight:bold;' : 'font-weight:normal;'; //見出し太字
		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス

		$bordercolor_css    = '';
		$bc_bordercolor_css = '';

		if ( $bordercolor !== '' ) {
			$bordercolor_css    = 'border-color:' . $bordercolor . ';';
			$bc_bordercolor_css = 'background:' . $bordercolor . ';';
		}

		$borderradius_css = '';
		$title_class      = '';
		$title_class = $title !== '' ?  'has-title ' : ''; // タイトルありのクラスをつける場合

		if ( $borderradius !== '' ) {
			if (  $title  !== '' ) {
				$borderradius_css = 'border-radius:0 ' . $borderradius . 'px ' . $borderradius . 'px;';
			} else {
				$borderradius_css = 'border-radius:' . $borderradius . 'px;overflow:hidden;';
			}
		}

		$titleradius = $borderradius !== '' ? 'border-radius: 0 0 ' . $borderradius . 'px 0;' : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="freebox ' . $title_class . $myclass_class .'" style="' . esc_attr( $bgcolor_css . $bordercolor_css . $borderwidth_css . $borderradius_css ) . '">' .
		       '<p class="p-free" style="' . esc_attr( $bc_bordercolor_css . $bordercolor_css . $titleweight_css ) . '">' .
		       '<span class="p-entry-f" style="' . esc_attr( $bc_bordercolor_css . $color_css . $titleweight_css . $titleradius ) . '">' . $fontawesome_html . esc_html( $title ) . '</span>' .
		       '</p>' .
		       '<div class="free-inbox">' . $content . '</div>' .
		       '</div>';
	}
}
add_shortcode('st-midasibox','st_midasibox_c');

if ( !function_exists( 'st_midasibox_intitle_c' ) ) {
	function st_midasibox_intitle_c( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'fontawesome'  => 'fa-file-text-o',
			'title'        => '見出し（全角15文字）',
			'bgcolor'      => '#ffffff',
			'bordercolor'  => '#919191',
			'borderwidth'  => '2',
			'borderradius' => '5',
			'titleweight'  => 'bold',
			'color'        => '#000000',
			'myclass'  => '',
		), $atts);

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontawesome_html = $fontawesome !== '' ? '<i class="fa  ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$bgcolor_css      = $bgcolor !== '' ? 'background:' . $bgcolor . ';' : ''; //背景
		$color_css        = $color !== '' ? 'color:' . $color . ';' : ''; //見出し色
		$borderwidth_css  = $borderwidth !== '' ? 'border-width:' . $borderwidth . 'px;' : ''; //枠線の太さ
		$titleweight_css  = ( $titleweight !== '' ) ? 'font-weight:bold;' : 'font-weight:normal;'; //見出し太字
		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス

		$bordercolor_css    = ''; //枠線
		$bc_bordercolor_css = ''; //背景色

		if ( $bordercolor !== '' ) { //枠線色あり
			$bordercolor_css    = 'border-color:' . $bordercolor . ';'; //枠線
			$bc_bordercolor_css = 'background:' . $bordercolor . ';'; //枠線と同じ色を背景色に
		}

		$borderradius_css = '';
		$title_class      = ''; // あタイトルありのクラスをつけない場合
		$title_class = $title !== '' ?  'has-title ' : ''; // タイトルありのクラスをつける場合

		$borderradius_css = ( $borderradius !== '' ) ? 'border-radius:' . $borderradius . 'px;overflow:hidden;' : '';

		$titleradius = $borderradius !== '' ? 'border-radius:' . $borderradius . 'px ' . $borderradius . 'px 0 0;' : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="freebox freebox-intitle ' . $title_class . $myclass_class .'" style="' . esc_attr( $bgcolor_css . $bordercolor_css . $borderwidth_css . $borderradius_css ) . '">' .
		       '<p class="p-free">' .
		       '<span class="p-entry-f" style="' . esc_attr( $bc_bordercolor_css . $color_css . $titleweight_css . $titleradius ) . '">' . $fontawesome_html . esc_html( $title ) . '</span>' .
		       '</p>' .
		       '<div class="free-inbox">' . $content . '</div>' .
		       '</div>';
	}
}
add_shortcode('st-midasibox-intitle','st_midasibox_intitle_c');

if ( !function_exists( 'st_slidebox_c' ) ) {
	function st_slidebox_c( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'text'    => '+ クリックして下さい',
			'bgcolor' => '',
			'color'   => '',
			'margin_bottom'   => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$text_html   = ( $text !== '' ) ? $text : '+ クリックして下さい'; //テキスト
		$bgcolor_css = ( $bgcolor !== '' ) ? 'background:' . $bgcolor . ';padding:15px;border-radius:5px;' : ''; //背景
		$color_css   = ( $color !== '' ) ? 'style="color:' . esc_attr($color) . ';"' : ''; //ラベル色
		$margin_bottom_css  = ( $margin_bottom !== '' ) ? 'margin-bottom:' . (int) $margin_bottom . 'px;' : ''; //下のマージン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="st-slidebox-c" style="' . esc_attr( $margin_bottom_css . $bgcolor_css ) .'"><p class="st-btn-open" ' . $color_css . '>' . $text_html . '</p><div class="st-slidebox">' . $content . '</div></div>';
	}
}
add_shortcode('st-slidebox','st_slidebox_c');

if ( !function_exists( 'st_flexbox' ) ) {
	function st_flexbox( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'url'             => '',
        	'title'           => '',
			'width'           => '',
			'height'          => '',
			'color'           => '#fff',
			'bgcolor'         => '',
			'fontsize'        => '200',
			'radius'          => '',
			'shadow'          => '',
			'bordercolor'     => '',
			'borderwidth'     => '',
			'backgroud_image' => '',
			'fontawesome'     => '',
			'blur'            => '',
			'left'            => '',
			'margin_bottom'            => '0',
			'target' => '',
			'rel' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$height_css  = ( $height !== '' ) ? 'height:' . (int) $height . 'px;' : 'height:auto;'; //高さ
		$width_css  = ( $width !== '' ) ? 'width:' . (int) $width . 'px;' : 'width:100%;box-sizing:border-box;'; //幅
		$color_css   = ( $color !== '' ) ? 'color:' . $color . ';' : ''; //見出し色
		$bgcolor_css   = ( $bgcolor !== '' ) ? 'background-color:' . $bgcolor . ';' : ''; //背景色
		$fontsize_css  = ( $fontsize !== '' ) ? 'font-size:' . (int) $fontsize . '%;' : ''; //文字サイズ
		$radius_css  = ( $radius !== '' ) ? 'border-radius: ' .  (int) $radius . 'px;' : '';
		$shadow_css  = ( $shadow !== '' ) ? 'text-shadow:1px 1px 1px ' . $shadow . ';' : ''; //影
		$backgroud_image_css  = ( $backgroud_image !== '' ) ? 'background-image: url(\''.esc_url($backgroud_image).'\');' : ''; //背景画像
		$left_class   = ( $left !== '' ) ? ' st-flexbox-left' : ''; //左寄せ
		$margin_bottom_css  = ( $margin_bottom !== '' ) ? 'margin-bottom:' . (int) $margin_bottom . 'px;' : ''; //下のマージン
		$target_attr     = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$rel_attr        = ( $rel !== '' ) ? 'rel="nofollow"' : ''; //nofollow
        
        if ( ( $bordercolor !== '' ) && ( $borderwidth !== '' ) ): // ボーダー
        	$border_css  = 'border: solid '. $bordercolor . ' ' . $borderwidth .'px;';
        else:
        	$border_css  = '';
        endif;
		
		if ( ( $bgcolor !== '' ) ||  ( $backgroud_image !== '' ) || ( $border_css !== '' )  ):
			$space_css = 'padding:20px;';
		else:
			$space_css = '';
		endif;
		
		if ( ( $blur !== '' ) &&  ( $backgroud_image !== '' ) ):
			$blur_class = ' st-blur';
		else:
			$blur_class = '';
		endif;
        
		if ( trim( $fontawesome ) !== '' ) { //Webアイコン
			$fontawesome_html = '<i class="fa  ' . esc_attr( $fontawesome ) . '" aria-hidden="true"></i>';
		} else {
			$fontawesome_html = '';
		}
		
		if ( trim( $url ) !== '' ) { //link
			$url_front_html = '<a href="' . esc_url($url) . '" class="st-flexbox-link" ' . $rel_attr . $target_attr . '>';
			$url_back_html  = '</a>';
		} else {
			$url_front_html = '';
			$url_back_html  = '';
		}		
		
        $title_html        = ( $title !== '' ) ? '<p class="st-header-flextitle" style="'.$fontsize_css.$color_css.$shadow_css.'">' . $fontawesome_html . $title . '</p>' : ''; //テキスト

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );    
        
		return $url_front_html . '<div class="st-header-flexwrap' . $blur_class . $left_class . '" style="'.$height_css.$width_css.$bgcolor_css.$radius_css.$border_css.$backgroud_image_css.$space_css.$margin_bottom_css.'"><div class="st-header-flexbox">' . $title_html . $content . '</div></div>' . $url_back_html;
	}
}
add_shortcode('st-flexbox','st_flexbox');

if ( ! function_exists( '_st_get_term_descendant' ) ) {
	function _st_get_term_descendants( $term_id, $taxonomy ) {
		static $cache = array();

		$term_id  = (int) $term_id;
		$cacheKey = hash( 'sha256', serialize( array( $term_id, $taxonomy ) ) );

		if ( isset( $cache[ $cacheKey ] ) ) {
			return $cache[ $cacheKey ];
		}

		$term_ids = get_term_children( $term_id, $taxonomy );

		if ( is_wp_error( $term_ids ) ) {
			$term_ids = array();
		}

		$cache[ $cacheKey ] = $term_ids;

		return $term_ids;
	}
}

if ( ! function_exists( '_st_parse_cat_id_string' ) ) {

	function _st_parse_cat_id_string( $cat_ids, $includes_descendants = true ) {
		$cat_ids = array_map( 'trim', explode( ',', $cat_ids ) );
		$cat_ids = array_map( 'intval', array_filter( $cat_ids ) );

		$including_ids = array();
		$excluding_ids = array();

		foreach ( $cat_ids as $cat_id ) {
			if ( $cat_id > 0 ) {
				$including_ids = $includes_descendants
					? array_merge( $including_ids, array( $cat_id ), _st_get_term_descendants( $cat_id, 'category' ) )
					: array_merge( $including_ids, array( $cat_id ) );
			} elseif ( $cat_id < 0 ) {
				$cat_id        = absint( $cat_id );
				$excluding_ids = $includes_descendants
					? array_merge( $excluding_ids, array( $cat_id ), _st_get_term_descendants( $cat_id, 'category' ) )
					: array_merge( $excluding_ids, array( $cat_id ) );
			}
		}

		return array(
			array_unique( $including_ids ),
			array_unique( $excluding_ids ),
		);
	}
}

if ( ! function_exists( '_st_parse_responsive_column_settings' ) ) {

	function _st_parse_responsive_column_settings( $settings, $default_settings = array( 3, 2, 1 ) ) {
		$setting_count = count( $default_settings );
		$settings      = array_pad( explode( ',', $settings ), $setting_count, 0 );
		$settings      = array_slice( $settings, 0, $setting_count );

		return array_map(
			function ( $key ) use ( $settings, $default_settings ) {
				/** @var string[] $settings */
				$value = (int) trim( $settings[ $key ] );

				return $value > 0 ? $value : $default_settings[ $key ];
			},
			array_keys( $settings )
		);
	}
}

if ( ! function_exists( '_st_get_responsive_thumbnail_size' ) ) {

	function _st_get_responsive_thumbnail_size( $column_settings ) {
		$sizes = array(
			1 => 'st_post_slider_1',
			2 => 'st_post_slider_2',
			3 => 'st_post_slider_3',
		);

		$max_slides_to_show = max( $column_settings );

		if ( isset( $sizes[ $max_slides_to_show ] ) ) {
			return $sizes[ $max_slides_to_show ];
		}

		return $sizes[3];
	}
}

if ( ! function_exists( '_st_get_the_responsive_post_thumbnail' ) ) {
	function _st_get_the_responsive_post_thumbnail( array $columm_settings, $post = null, $resize = true ) {
		$post              = get_post( $post );
		$thumbnail_size    = $resize ? _st_get_responsive_thumbnail_size( $columm_settings ) : 'full';

		if ( has_post_thumbnail() ) {
			return get_the_post_thumbnail( $post, $thumbnail_size );
		}

		$default_image_size = array( 'width' => 343, 'height' => 254, 'crop' => true );
		$default_thumbnail  = trim( get_option( 'st-data97', '' ) );
		$no_img             = ( $default_thumbnail !== '' )
			? $default_thumbnail
			: get_template_directory_uri() . '/images/no-img.png';

		if ($resize) {
			$image_sizes       = wp_get_additional_image_sizes();
			$image_size        = isset( $image_sizes[ $thumbnail_size ] ) // px
				? $image_sizes[ $thumbnail_size ]
				: $default_image_size;
		} else {
			$image_size = getimagesize( $no_img );
			$image_size = $image_size
				? array( 'width' => $image_size[0], 'height' => $image_size[1], 'crop' => true )
				: $default_image_size;
		}

		$size = max( $image_size['width'], $image_size['height'] );

		$post_thumbnail = sprintf(
			'<img src="%s" alt="no image" title="no image" width="%s" height="%s">',
			esc_url( $no_img ),
			$size,
			$size
		);

		return $post_thumbnail;
	}
}

if ( ! function_exists( 'st_catgroup' ) ) {
	function st_catgroup( $atts, $content = null ) {
		$globals = array();
		$globals = _st_store_global_query( $globals );

		$default_slides_to_show = array( 3, 2, 1 );

		$atts = shortcode_atts(
			array(
				'cat'            => '',
				'page'           => '5',
				'order'          => 'desc',
				'orderby'        => 'date',
				'child'          => 'off',
				'slide'          => 'off',
				'slides_to_show' => implode( ',', $default_slides_to_show ),
				'slide_date'     => 'on',
				'slide_more'     => 'ReadMore',
				'slide_center'   => 'off',
				'fullsize_type'  => '',
			),
			$atts
		);

		$atts = array_map( 'trim', $atts );

		list( $including_ids, $excluding_ids ) = _st_parse_cat_id_string(
			$atts['cat'],
			$atts['child'] === 'on'
		);

		$page = (int) $atts['page'];

		$order = strtoupper( $atts['order'] );
		$order = in_array( $order, array( 'ASC', 'DESC' ), true ) ? $order : 'DESC';

		if( isset( $GLOBALS["stdata398"] ) && $GLOBALS["stdata398"] === 'yes' ):
			$atts['slide'] = '' ;
		endif;

		$slide          = ( $atts['slide'] === 'on' );
		$slide_date     = ( $atts['slide_date'] !== 'off' );
		$slides_to_show = _st_parse_responsive_column_settings( $atts['slides_to_show'], $default_slides_to_show );
		$slide_center   = ( $atts['slide_center'] === 'on' );
		$fullsize_type  = in_array($atts['fullsize_type'], ['text', 'card'], true) ? $atts['fullsize_type'] : '';

		$cat_group_query = new WP_Query( array(
			'post_type'           => 'post',
			'category__in'        => $including_ids,
			'category__not_in'    => $excluding_ids,
			'orderby'             => $atts['orderby'],
			'order'               => $order,
			'posts_per_page'      => $page,
			'ignore_sticky_posts' => true,
		) );

		_st_restore_global_query( $globals );

		ob_start();

		$vars = array(
			'slides_to_show'  => $slides_to_show,
			'slide_date'      => $slide_date,
			'slide_more'      => trim( $atts['slide_more'] ),
			'slide_center'    => $slide_center,
			'fullsize_type'   => $fullsize_type,
		);
		$amp       = amp_is_amp() ? 'amp' : null;
		$is_slider = ( $slide && ! $amp );

		if ( $is_slider ) {
			$vars['slide_query']   = $cat_group_query;
			$vars['is_rank']       = false;
			$vars['show_category'] = true;
		} else {
			$vars['cat_group_query'] = $cat_group_query;
		}

		$template_slug = $is_slider ? 'st-shortcode-slider' : 'st-shortcode-kanren';

		st_get_template_part( $template_slug, $amp, $vars );

		$html = ob_get_clean();

		_st_restore_global_query( $globals );

		return $html;
	}
}

add_shortcode( 'st-catgroup', 'st_catgroup' );

if ( ! function_exists( 'st_postgroup' ) ) {
	function st_postgroup( $atts, $content = null ) {
		$globals = array();
		$globals = _st_store_global_query( $globals );

		$atts = shortcode_atts(
			array(
				'id' => '',
				'rank' => '0',
			),
			$atts
		);

		$atts = array_map( 'trim', $atts );

		$post_ids = explode( ',', $atts['id'] );
		$post_ids = array_unique( array_map( 'intval', array_filter( $post_ids ) ) );

		$post_group_query = new WP_Query( array(
			'post_type'           => 'any',
			'post__in'            => $post_ids,
			'posts_per_page'      => - 1,
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => true,
		) );

		_st_restore_global_query( $globals );

		ob_start();

		$amp = amp_is_amp() ? 'amp' : null;

		$vars = array(
			'post_group_query' => $post_group_query,
			'is_rank'          => (bool) $atts['rank'],
		);

		st_get_template_part( 'st-shortcode-itiran', $amp, $vars );

		$html = ob_get_clean();

		_st_restore_global_query( $globals );

		return $html;
	}
}

add_shortcode( 'st-postgroup', 'st_postgroup' );

if ( !function_exists( 'st_osusume' ) ) {
	function st_osusume( $atts, $content = null ) {
		ob_start();

		$hide_thumbnail = get_option( 'st-data5', '' );
		$amp            = amp_is_amp() ? 'amp' : null;

		if ( $hide_thumbnail === 'yes' ) {
			st_get_template_part( 'popular-thumbnail-off', $amp, array( 'doing_st_osusume_shortcode' => true ) );
		} else {
			st_get_template_part( 'popular-thumbnail-on', $amp, array( 'doing_st_osusume_shortcode' => true ) );
		}

		return ob_get_clean();
	}
}
add_shortcode( 'st-osusume', 'st_osusume' );

add_theme_support( 'post-thumbnails' );
add_image_size( 'st_thumb150', 150, 150, true );
// スライダーサムネイル
if ( trim($GLOBALS['stdata398']) === '' ): // スライドショー機能の全停止が無効
	add_image_size( 'st_post_slider_1', 640, 475, true );
	add_image_size( 'st_post_slider_2', 343, 254, true );
	add_image_size( 'st_post_slider_3', 202, 150, true );
endif;

if ( ! has_image_size( 'st_kaiwa_image' ) ) {
	add_image_size( 'st_kaiwa_image', 60, 60, true );
}
if ( ! function_exists( 'st_image_size_names_choose' ) ) {
	function st_image_size_names_choose( $sizes ) {
		return array_merge(
			$sizes,
			array(
				'st_kaiwa_image' => '会話風アイコン',
			)
		);
	}
}
add_filter( 'image_size_names_choose', 'st_image_size_names_choose' );

if ( ! function_exists( 'st_meta_thumbnail' ) ) {
	function st_meta_thumbnail() {
		$st_ogp_url = trim( get_option( 'st-data264', '' ) ); // デフォルトのアイキャッチ画像設定
		if ( ( is_page() || is_single() ) && has_post_thumbnail() ) {
	  		echo '<meta name="thumbnail" content="'. wp_get_attachment_url( get_post_thumbnail_id() ) .'">'. "\n";	
		}elseif( $st_ogp_url ) {
	  		echo '<meta name="thumbnail" content="'. esc_attr( $st_ogp_url) .'">'. "\n";	
		}else {
		}
	}
}
add_action( 'wp_head', 'st_meta_thumbnail' );

add_action( 'init', 'my_custom_menus' );
function my_custom_menus() {
    register_nav_menus(
	   array(
		  'primary-menu' => __( 'ヘッダー用メニュー', 'default' ),
		  'primary-menu-side' => __( 'ヘッダー用メニュー（横列）', 'default' ),
		  'secondary-menu' => __( 'フッター用メニュー', 'default' ),
		  'sidepage-menu' => __( 'サイド用メニュー', 'default' ),
		  'guidemap-menu' => __( 'ガイドマップメニュー', 'default' ),
		  'guidemap-menu2' => __( 'ガイドマップメニュー2', 'default' ),
		  'smartphone-menu' => __( 'スマートフォン用スライドメニュー', 'default' ),
		  'smartphone-middlemenu' => __( 'スマートフォン用ミドルメニュー', 'default' ),
		  'smartphone-footermenu' => __( 'スマートフォンフッター用メニュー', 'default' )
	   )
    );
}

add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'automatic-feed-links' );

if ( isset( $GLOBALS['stdata240'] ) && trim( $GLOBALS['stdata240'] ) === 'yes' ) {
	if ( ! function_exists( 'st_add_editor_styles' ) ) {
		function st_add_editor_styles( $settings, $editor_id ) {
			$st_editor_styles = array();
			$add_all          = ( is_admin() && function_exists( 'get_current_screen' ) );
			$add_all          = ( $add_all && $editor_id === 'content' );

			if ( $add_all ) {
				$screen  = get_current_screen();
				$add_all = $add_all && ( $screen && isset( $screen->id ) );
				$add_all = $add_all && (
					( $screen->id === 'post' && $screen->post_type === 'post' ) ||
					( $screen->id === 'page' && $screen->post_type === 'page' ) ||
					$screen->id === 'edit-page'
				);
			}

			if ( ! $add_all ) {
				add_editor_style( 'editor-style.css' );

				return $settings;
			}

			$st_editor_styles[] = get_template_directory_uri() . '/css/normalize.css';
			$st_editor_styles[] = get_template_directory_uri() . '/css/fontawesome/css/font-awesome.min.css';
			if ( ! st_speed_on() ) { $st_editor_styles[] = get_template_directory_uri() . '/css/fontawesome/css/font-awesome-animation.min.css'; }
			$st_editor_styles[] = get_template_directory_uri() . '/st_svg/style.css';
			$st_editor_styles[] = 'editor-style.css';
			$st_editor_styles[] = '//fonts.googleapis.com/css?family=Montserrat:400';

			if ( ( $custom_font = _st_get_google_font() ) !== null ) {
				$st_editor_styles[] = $custom_font;
			}

			$st_editor_styles[] = 'st-themecss-loader.php';
			$st_editor_styles[] = 'st-rankcss.php';
			$st_editor_styles[] = get_template_directory_uri() . '/editor-style-rich.php';

			if ( $add_all ) {
				foreach ( $st_editor_styles as $editor_style ) {
					add_editor_style( $editor_style );
				}
			}

			return $settings;
		}
	}

	add_filter( 'wp_editor_settings', 'st_add_editor_styles', 10, 2 );
}else{
	add_editor_style( 'editor-style.css' );
}

if ( ! function_exists( 'st_enqueue_block_editor_assets' ) ) {
	function st_enqueue_block_editor_assets() {
		wp_register_style(
			'st-block-editor-style',
			get_template_directory_uri() . '/st-themecss-loader.php?style=block-editor-style',
			apply_filters( 'st_block_editor_style_dependencies', array( 'wp-components' ) )
		);

		wp_enqueue_style( 'st-block-editor-style' );
	}
}

add_action( 'enqueue_block_editor_assets', 'st_enqueue_block_editor_assets' );

if ( !function_exists( 'st_custom_editor_settings' ) ) {
	function st_custom_editor_settings( $initArray ) {
		$initArray['body_id'] = 'primary';
		$initArray['body_class'] = 'post';
		$initArray['valid_children'] = '+body[style|i],+div[div|span],+span[span]';
		
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'st_custom_editor_settings' );

if ( isset( $GLOBALS['stdata128'] ) && trim( $GLOBALS['stdata128'] ) !== '' ) { //全体のwidth 
	$st_pcsite_width = (int) $GLOBALS['stdata128'];
	$st_content_width = $st_pcsite_width - 140;
}else{
	$st_content_width = 920;
}

if ( !isset( $content_width ) ) {
	$content_width = $st_content_width;
}

if ( isset($GLOBALS['stdata2']) && $GLOBALS['stdata2'] === '' ) {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
}

if ( ! function_exists( '_st_get_page_info' ) ) {
	function _st_get_page_info() {
		$post = get_post();
		$page = ( $page = (int) get_query_var( 'page', 1 ) ) ? $page : 1;
		$more = 0;

		if ( $post->ID === get_queried_object_id() && ( is_page() || is_single() ) ) {
			$more = 1;
		} elseif ( is_feed() ) {
			$more = 1;
		}

		$content = $post->post_content;

		if ( strpos( $content, '<!--nextpage-->' ) !== false ) {
			$content = str_replace( "\n<!--nextpage-->\n", '<!--nextpage-->', $content );
			$content = str_replace( "\n<!--nextpage-->", '<!--nextpage-->', $content );
			$content = str_replace( "<!--nextpage-->\n", '<!--nextpage-->', $content );

			if ( strpos( $content, '<!--nextpage-->' ) === 0 ) {
				$content = substr( $content, 15 );
			}

			$pages = explode( '<!--nextpage-->', $content );
		} else {
			$pages = array( $post->post_content );
		}

		$pages     = apply_filters( 'content_pagination', $pages, $post );
		$numpages  = count( $pages );
		$multipage = 0;

		if ( $numpages > 1 ) {
			if ( $page > 1 ) {
				$more = 1;
			}

			$multipage = 1;
		}

		return array(
			'multipage' => $multipage,
			'more'      => $more,
			'page'      => $page,
			'numpages'  => $numpages,
		);
	}
}

if ( ! function_exists( '_st_link_page' ) ) {
	function _st_link_page_url( $i ) {
		global $wp_rewrite;

		$post       = get_post();
		$query_args = array();

		if ( $i === 1 ) {
			$url = get_permalink();
		} else {
			if ( get_option( 'permalink_structure' ) === '' ||
			     in_array( $post->post_status, array( 'draft', 'pending' ) )
			) {
				$url = add_query_arg( 'page', $i, get_permalink() );
			} elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( get_permalink() ) .
				       user_trailingslashit( $wp_rewrite->pagination_base . '/' . $i, 'single_paged' );
			} else {
				$url = trailingslashit( get_permalink() ) . user_trailingslashit( $i, 'single_paged' );
			}
		}

		if ( is_preview() ) {
			if ( ( $post->post_status !== 'draft' ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
				$query_args['preview_id']    = wp_unslash( $_GET['preview_id'] );
				$query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
			}

			$url = get_preview_post_link( $post, $query_args, $url );
		}

		return $url;
	}
}

if ( ! function_exists( 'st_adjacent_posts_rel_link' ) ) {
	function st_adjacent_posts_rel_link() {
		if ( is_single() || is_page() ) {
			$page_info = _st_get_page_info();
			$multipage = $page_info['multipage'];
			$page      = $page_info['page'];
			$numpages  = $page_info['numpages'];

			if ( ! $multipage ) {
				return;
			}

			if ( $page > 1 ) {
				echo '<link rel="prev" href="' . _st_link_page_url( $page - 1 ) . '" />' . PHP_EOL;
			}

			if ( $page < $numpages ) {
				echo '<link rel="next" href="' . _st_link_page_url( $page + 1 ) . '" />' . PHP_EOL;
			}

			return;
		}

		$paged = ( $paged = (int) get_query_var( 'paged', 1 ) ) ? $paged : 1;

		if ( get_previous_posts_link() ) {
			echo '<link rel="prev" href="' . get_pagenum_link( $paged - 1 ) . '" />' . PHP_EOL;
		}

		if ( get_next_posts_link() ) {
			echo '<link rel="next" href="' . get_pagenum_link( $paged + 1 ) . '" />' . PHP_EOL;
		}
	}
}

add_action('wp_head', 'st_adjacent_posts_rel_link');

if ( !function_exists( 'st_custom_content_more_link' ) ) {
	function st_custom_content_more_link( $output ) {
		$output = preg_replace( '/#more-[\d]+/i', '', $output );

		return $output;
	}
}
add_filter( 'the_content_more_link', 'st_custom_content_more_link' );

if ( !function_exists( 'no_self_ping' ) ) {
	function no_self_ping( &$links ) {
		$home = home_url();
		foreach ( $links as $l => $link )
			if ( 0 === strpos( $link, $home ) )
				unset($links[$l]);
	}
add_action( 'pre_ping', 'no_self_ping' );
}

if ( !function_exists( 'st_youtube_img' ) ) {
	function st_youtube_img( $youtube_id ) {

		extract(shortcode_atts(array(
			'id' => '',
		), $youtube_id), EXTR_SKIP);

		$youtube_link = '<div class="st-youtube"><a href="//www.youtube.com/watch?v='.$id.'" target="_blank" rel="nofollow"><i class="fa fa-youtube-play"></i><img src="//img.youtube.com/vi/'.$id.'/mqdefault.jpg" alt="" width="100%" height="auto" /></a></div>';

		return $youtube_link;
	}

	add_shortcode( 'youtube', 'st_youtube_img' );
}

if ( !function_exists( 'st_wrap_iframe_in_div' ) ) {
	function st_wrap_iframe_in_div( $the_content ) {
		//YouTube
		$the_content =
		    preg_replace( '/<iframe[^>]+?youtube\.com[^<]+?<\/iframe>/is',
			   '<div
		class="youtube-container">${0}</div>',
			   $the_content );

		return $the_content;
	}
}

if ( !function_exists( 'st_singular_wrap_iframe_in_div' ) ) {
	function st_singular_wrap_iframe_in_div( $the_content ) {
		if ( is_singular() ) {
			$the_content = st_wrap_iframe_in_div( $the_content );
		}

		return $the_content;
	}
}
add_filter('the_content','st_singular_wrap_iframe_in_div');

if ( !function_exists( 'st_register_sidebars' ) ) {
	function st_register_sidebars() {

		register_sidebar( array(
			'id' => 'sidebar-10',
			'name' => 'サイドバートップ',
			'description' => 'サイドバーの一番上に表示されるコンテンツエリアです。',
			'before_widget' => '<div id="%1$s" class="ad %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title"><span>',
			'after_title' => '</span></p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-1',
			'name' => 'サイドバーウィジェット',
			'description' => 'サイドバーに表示されるコンテンツです',
			'before_widget' => '<div id="%1$s" class="ad %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="menu_underh2"><span>',
			'after_title' => '</span></h4>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-2',
			'name' => 'スクロール広告用',
			'description' => 'サイドバーの下でコンテンツに追尾するボックスエリアです。「カスタムHTML」等をここにドロップして内容を入力して下さい。アドセンスは禁止です。※PC以外では非表示部分',
			'before_widget' => '<div id="%1$s" class="ad %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="menu_underh2" style="text-align:left;"><span>',
			'after_title' => '</span></h4>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-3',
			'name' => '広告・Googleアドセンス用336px（A）',
			'description' => 'Googleアドセンス336pxに適したボックス。PC閲覧時記事下に表示される1つ目。「カスタムHTML」をここにドロップしてコードを入力して下さい。',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-29',
			'name' => '広告・Googleアドセンス用336px（B）',
			'description' => 'Googleアドセンス336pxに適したボックス。PC閲覧時記事下に表示される2つ目。「カスタムHTML」をここにドロップしてコードを入力して下さい。',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-4',
			'name' => '広告・Googleアドセンスのスマホ用',
			'description' => 'スマートフォン用のGoogleアドセンスボックスで記事下に1つ及び[adsense]ショートコードを利用した時にも挿入されます。「カスタムHTML」をここにドロップしてコードを入力して下さい。',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-26',
			'name' => '広告・Googleインフィード広告',
			'description' => 'Googleのインフィード広告を一覧に表示（※テーマ管理で別途表示を有効化）。「カスタムHTML」をここにドロップしてコードを入力して下さい。',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-23',
			'name' => 'PCのみ投稿記事上に表示',
			'description' => 'PC閲覧時のみ投稿記事上（AMPを除く）に一括表示されます。「テキスト」等をここにドロップしてコードを入力して下さい。',
			'before_widget' => '<div id="%1$s" class="st-widgets-box pc-widgets-top %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-20',
			'name' => '広告・スマホ用上部のみ',
			'description' => 'スマホ閲覧時にヘッダー下に表示される「レスポンシブ リンク」専用エリア。「テキスト」をここにドロップしてコードを入力して下さい。',
			'before_widget' => '<div id="%1$s" class="st-sp-top-only-widgets adsbygoogle %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-9',
			'name' => '広告・スマホ用記事下のみ',
			'description' => 'スマホのみ記事下に表示されるボックスエリアです。',
			'before_widget' => '<div id="%1$s" class="sc-post-widgets-underonly %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-16',
			'name' => '投稿記事の上に一括表示',
			'description' => '投稿記事の上に一括表示されます。「テキスト」等をここにドロップしてコードを入力して下さい。',
			'before_widget' => '<div id="%1$s" class="st-widgets-box post-widgets-top %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-5',
			'name' => '投稿記事の下に一括表示',
			'description' => '投稿記事の下に一括表示されます。「テキスト」等をここにドロップしてコードを入力して下さい。',
			'before_widget' => '<div id="%1$s" class="st-widgets-box post-widgets-bottom %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-17',
			'name' => '固定記事の上に一括表示',
			'description' => '固定記事の上に一括表示されます。「テキスト」等をここにドロップしてコードを入力して下さい。',
			'before_widget' => '<div id="%1$s" class="st-widgets-box page-widgets-top %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-6',
			'name' => '固定記事の下に一括表示',
			'description' => '固定記事の下に一括表示されます。「テキスト」等をここにドロップしてコードを入力して下さい。',
			'before_widget' => '<div id="%1$s" class="st-widgets-box page-widgets-bottom %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-8',
			'name' => 'ヘッダー右（フッター）ウィジェット',
			'description' => 'ヘッダー右とフッターに表示されるウィジェットです※タイトルは反映されません（フッターはテーマ管理で非表示に出来ます）',
			'before_widget' => '<div id="%1$s" class="headbox %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-31',
			'name' => 'ヘッダー画像エリア上のウィジェット',
			'description' => 'ヘッダー画像の上に挿入するウィジェットです。',
			'before_widget' => '<div id="%1$s" class="top-content %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-14',
			'name' => 'ヘッダー画像エリアウィジェット',
			'description' => 'ヘッダー画像の代わりに挿入するウィジェットです。',
			'before_widget' => '<div id="%1$s" class="top-content %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );
		
		register_sidebar( array(
			'id' => 'sidebar-28',
			'name' => 'ヘッダー画像エリア下のウィジェット',
			'description' => 'ヘッダー画像の下に挿入するウィジェットです。',
			'before_widget' => '<div id="%1$s" class="st-header-under-widgets %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-11',
			'name' => 'フッター右用ウィジェット（2列目）',
			'description' => 'フッターの右側に表示されるウィジェットです。ここを使用するとPCで見た時にフッターのロゴ等が左寄りになり2カラムになります。',
			'before_widget' => '<div id="%1$s" class="footer-rbox %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-30',
			'name' => 'フッター右用ウィジェット（3列目）',
			'description' => 'フッターの右側に表示されるウィジェットです。※「フッター右用ウィジェット（2列目）」が使用されている場合のみ表示されます',
			'before_widget' => '<div id="%1$s" class="footer-rbox-b %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-12',
			'name' => 'トップページ上部ウィジェット',
			'description' => 'トップページの上部に表示されるウィジェットです。「お知らせ」や「告知」スペースなどに',
			'before_widget' => '<div id="%1$s" class="top-wbox-t %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-13',
			'name' => 'トップページ下部ウィジェット',
			'description' => 'トップページの下部に表示されるウィジェットです。トップのみに表示したいリンクや広告などに',
			'before_widget' => '<div id="%1$s" class="top-wbox-u %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-15',
			'name' => 'オリジナルのショートコード作成ウィジェット',
			'description' => 'ショートコードoriginalscの挿入することで表示できるウィジェットです',
			'before_widget' => '<div id="%1$s" class="%2$s" style="padding:10px 0;">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-18',
			'name' => 'スマートフォンのフッターに固定するウィジェット',
			'description' => 'スマートフォン表示時にフッターに固定する広告用ウィジェットエリアです',
			'before_widget' => '<div id="footer-ad" class="%2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-19',
			'name' => 'AMPサイドバーウィジェット',
			'description' => 'AMP専用サイドバーに表示されるコンテンツです※一部未対応タグがございます',
			'before_widget' => '<div id="%1$s" class="ad %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="menu_underh2">',
			'after_title' => '</h4>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-21',
			'name' => 'カテゴリの上に一括表示',
			'description' => 'カテゴリページの上に一括表示されます。「テキスト」等をここにドロップしてコードを入力して下さい。（カテゴリ別に表示するショートコード[catonly cat="id"]表示したい内容[/catonly]が利用できます）※タイトルは反映されません',
			'before_widget' => '<div id="%1$s" class="st-widgets-box cat-widgets-top %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-22',
			'name' => 'カテゴリの下に一括表示',
			'description' => 'カテゴリページの下に一括表示されます。「テキスト」等をここにドロップしてコードを入力して下さい。（カテゴリ別に表示するショートコード[catonly cat="id"]表示したい内容[/catonly]が利用できます）※タイトルは反映されません',
			'before_widget' => '<div id="%1$s" class="st-widgets-box cat-widgets-bottom %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-24',
			'name' => '404ページ',
			'description' => '記事が見つからない時に表示される404ページに挿入するウィジェットです',
			'before_widget' => '<div id="%1$s" class="st-w-404 %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h5">',
			'after_title' => '</h5>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-25',
			'name' => 'スライドメニュー内上に表示',
			'description' => 'スライドメニュー上部に一括表示されます。※JSによりメニュー内の高さを取得するため挿入コンテンツによっては読み込みが遅くなる場合がございます',
			'before_widget' => '<div id="%1$s" class="st-widgets-box ac-widgets-top %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );
		
		register_sidebar( array(
			'id' => 'sidebar-27',
			'name' => 'スライドメニュー内下に表示',
			'description' => 'スライドメニュー下部に一括表示されます。※JSによりメニュー内の高さを取得するため挿入コンテンツによっては読み込みが遅くなる場合がございます',
			'before_widget' => '<div id="%1$s" class="st-widgets-box ac-widgets-bottom %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-32',
			'name' => '検索結果ページ（上部）に表示',
			'description' => '検索結果ページの上部に表示されます',
			'before_widget' => '<div id="%1$s" class="st-widgets-box search-widgets-top %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );

		register_sidebar( array(
			'id' => 'sidebar-33',
			'name' => '検索結果ページ（下部）に表示',
			'description' => '検索結果ページの下部に表示されます',
			'before_widget' => '<div id="%1$s" class="post st-widgets-box search-widgets-top %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<p class="st-widgets-title">',
			'after_title' => '</p>',
		) );
	}
}

add_action( 'widgets_init', 'st_register_sidebars' );

if ( !function_exists( 'st_get_mtime' ) ) {
	function st_get_mtime( $format ) {
		$mtime = (int) get_the_modified_time( 'Ymd' );
		$ptime = (int) get_the_time( 'Ymd' );

		if ( $ptime > $mtime ) {
			return get_the_time( $format );
		} elseif ( $ptime === $mtime ) {
			return null;
		} else {
			return get_the_modified_time( $format );
		}
	}
}

if ( !function_exists( 'st_rss_feed_copyright' ) ) {
	function st_rss_feed_copyright( $content ) {
		$content = $content . '<p>Copyright &copy; ' . esc_html( date( 'Y' ) ) .
				 ' <a href="' . esc_url( home_url() ) . '">' .
				 apply_filters( 'bloginfo', get_bloginfo( 'name' ), 'name' ) .
				 '</a> All Rights Reserved.</p>';

		return $content;
	}
}
add_filter( 'the_excerpt_rss', 'st_rss_feed_copyright' );
add_filter( 'the_content_feed', 'st_rss_feed_copyright' );

if ( !function_exists( 'st_showads' ) ) {
	function st_showads() {
		ob_start();

		get_template_part( 'st-ad' );

		$ads = ob_get_clean();

		return $ads;
	}

	add_shortcode( 'adsense', 'st_showads' );
}

if ( !function_exists( 'st_shortcode' ) ) {
	function st_shortcode() {
		ob_start();

		get_template_part( 'st-shortcode' );

		$osc = ob_get_clean();

		return $osc;
	}

	add_shortcode( 'originalsc', 'st_shortcode' );
}

if ( !function_exists( 'st_stchildlink' ) ) {
	function st_stchildlink() {
		global $post;
		$args = array(
			'post_parent' => $post->ID,
			'post_type' => 'page',
		'orderby' => 'menu_order',
		'order'   => 'ASC',
		);

		$subpages = new WP_query( $args );

		if ( $subpages->have_posts() ) {
			$output = '<aside class="pagelist-box"><div class="st-childlink">';

			while ( $subpages->have_posts() ) {
				$subpages->the_post();
				$output .= '<p class="kopage-t"><a href="' . esc_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">' .get_the_title() .'</a></p>' .
						 apply_filters( 'the_excerpt', get_the_excerpt() );
			}
			wp_reset_postdata();

			$output .= '</div></aside>';

		} else {
			$output = '';
		}

		return $output;
	}

	add_shortcode( 'stchildlink', 'st_stchildlink' );
}

if ( !function_exists( 'st_shortcode_tp' ) ) {
	function st_shortcode_tp( $atts, $content = '' ) {
		return get_stylesheet_directory_uri() . '/' . ltrim($content, '/\\');
	}

	add_shortcode( 'tp', 'st_shortcode_tp' );
}

if ( !function_exists( 'st_shortcode_commentout' ) ) {
	function st_shortcode_commentout( $atts, $content = null ) {
		return null;
	}
	add_shortcode('st-out', 'st_shortcode_commentout');
}

if ( !function_exists( 'st_svg_close_class' ) ) {
	function st_svg_close_class() {
		if ( $GLOBALS['stdata247'] ):
			$st_svg_close_icon = $GLOBALS['stdata247'];
		else:
			$st_svg_close_icon = '';
		endif;
		
    	if ($st_svg_close_icon === 'thin'){
			$st_svg_close_icon = 'st-svg-menu_thin';
		} elseif ($st_svg_close_icon === 'cut') {
			$st_svg_close_icon = 'st-svg-menu_cut';
		} else {
			$st_svg_close_icon = 'st-svg-menu';
		}
			echo esc_attr( $st_svg_close_icon );
		}
}

if ( !function_exists( 'st_wrap_class' ) ) {
	function st_wrap_class() {
		global $wp_query;

		if ( is_single() or is_page() ) {
			$postID = $wp_query->post->ID;
			$column1 = get_post_meta( $postID, 'columnck', true );
		} else {
			$column1 = '';
		};

		$stdata11 = get_option( 'st-data11' );

		if ( ( isset($GLOBALS['stdata77']) && $GLOBALS['stdata77'] === 'yes' ) || ( is_home() && $stdata11 === 'yes' ) || ( $column1 === 'yes' && !is_home() )  || ( is_category() && ( isset($GLOBALS['stdata233']) && $GLOBALS['stdata233'] === 'yes' ) ) ) {
			$wrapclass = 'colum1';
		} elseif ( ( isset($GLOBALS['stdata77']) && $GLOBALS['stdata77'] === 'lp' ) || ( is_home() && $stdata11 === 'lp' ) || ( $column1 === 'lp' && !is_home() ) ) {
			$wrapclass = 'colum1 lp';
		} else {
			$wrapclass = '';
		}

		echo esc_attr( $wrapclass );
	}
}

if ( !function_exists( 'st_wrap_class_check' ) ) {
	function st_wrap_class_check() {
		if ( in_array( get_option( 'st-data77' ), array( 'yes', 'lp' ), true ) ) {
			return true;
		}

		$queried_object_id = get_queried_object_id();

		if ( ( is_single() || is_page() ) && get_post_meta( $queried_object_id, 'columnck', true ) === 'yes' ) {
			return true;
		}

		if ( is_home() && get_option( 'st-data11' ) === 'yes' ) {
			return true;
		}

		if ( is_category() && get_option( 'st-data233' ) === 'yes' ) {
			return true;
		}

		if ( st_is_ver_ex() ) {
			if ( ( is_category() || is_tag() ) && st_get_term_meta( $queried_object_id, 'colom_check' ) === 'yes' ) {
				return true;
			}
		}

		return false;
	}
}

if ( !function_exists( 'st_hidden_class' ) ) {
	function st_hidden_class() {
		if ( (is_single() && isset($GLOBALS['stdata24']) && $GLOBALS['stdata24'] === 'yes') || //投稿ページ
		(is_page() && isset($GLOBALS['stdata104']) && $GLOBALS['stdata104'] === 'yes') ||  //固定ページ
		( ( isset($GLOBALS['stdata24']) && $GLOBALS['stdata24'] === 'yes') && ( isset($GLOBALS['stdata104']) && $GLOBALS['stdata104'] === 'yes') )){ //両方にチェック
		$hiedeclass = 'st-hide';
		}else{
		$hiedeclass = '';
		}
	echo esc_attr( $hiedeclass );
	}
}


if ( !function_exists( 'st_head_class' ) ) {
	function st_head_class() {
		if ( isset($GLOBALS['stdata52']) && $GLOBALS['stdata52'] === 'yes' ) {
		$headwide = 'st-headwide';
		}else{
		$headwide = '';
		}
	echo esc_attr( $headwide );
	}
}


if ( !function_exists( 'st_headerwide_class' ) ) {
	function st_headerwide_class() {
		if ( isset($GLOBALS['stdata29']) && $GLOBALS['stdata29'] === 'yes' ) {
			$headerwide = '-wide';
		}else{
			$headerwide = '';
		}

	echo esc_attr( $headerwide );
	}
}

if ( !function_exists( 'st_get_marugazou_class' ) ) {
	function st_get_marugazou_class() {
		if ( isset($GLOBALS['stdata48']) && $GLOBALS['stdata48'] === 'yes' ) {
			$kadomaru = 'kadomaru';
		}else{
			$kadomaru = '';
		}

		return $kadomaru;
	}
}

if ( !function_exists( 'st_marugazou_class' ) ) {
	function st_marugazou_class() {
		echo esc_attr( st_get_marugazou_class() );
	}
}

if ( !function_exists( 'st_marugazou_r_class' ) ) {
	function st_marugazou_r_class() {
		if ( isset($GLOBALS['stdata48']) && $GLOBALS['stdata48'] === 'yes' ) {
			$kadomaru_r = 'kadomaru';
		}else{
			$kadomaru_r = '';
		}

	return esc_attr( $kadomaru_r );
	}
}

if ( !function_exists( 'st_eyecatch_class' ) ) {
	function st_eyecatch_class() {

		if ( isset($GLOBALS['stdata241']) && $GLOBALS['stdata241'] === 'yes' ) {
			$st_eyecatch_class = 'st-eyecatch';
		} else {
			$st_eyecatch_class = '';
		}

		echo esc_attr( $st_eyecatch_class );
	}
}

if ( !function_exists( 'st_text_copyck' ) ) {
	function st_text_copyck() {
		global $wp_query;
		if( is_single() or is_page() && !is_front_page() ){
			$postID = $wp_query->post->ID;
			$textcopyck1 = get_post_meta( $postID, 'textcopyck', true );
		}else{
		$textcopyck1 = '';
		}

	if ( isset( $textcopyck1 ) && $textcopyck1 === 'yes' ){
		$st_textcopyck = '';
	} else {
		if ( ! is_user_logged_in() && ( isset($GLOBALS['stdata19']) && $GLOBALS['stdata19'] === 'yes' ) ) {
			$st_textcopyck = 'oncontextmenu="return false" onMouseDown="return false;" style="-moz-user-select: none; -khtml-user-select: none; user-select: none;-webkit-touch-callout:none; -webkit-user-select:none;"';
		} else {
			$st_textcopyck = '';
		}
	}
		echo $st_textcopyck ;
	}
}

if (!function_exists('st_icon_head')) {
	function st_icon_head() {
		if ( trim( $GLOBALS["stdata26"] ) !== '' ) {
		$fabiconurl = esc_url( $GLOBALS["stdata26"] );
		echo '<link rel="shortcut icon" href="'.$fabiconurl.'" >'."\n";
		}
		if ( trim( $GLOBALS["stdata27"] ) !== '' ) {
		$appletouchiconurl = esc_url( $GLOBALS["stdata27"] );
		echo '<link rel="apple-touch-icon-precomposed" href="'.$appletouchiconurl.'" />'."\n";
		}

	}
    
}
add_action('wp_head', 'st_icon_head');

if (!function_exists('st_metadescription_head')) {
	function st_metadescription_head() {
		if ( trim( $GLOBALS["stdata34"] ) !== '' && ( is_front_page()) ) {
		$stdescription_top = esc_attr( $GLOBALS["stdata34"] );
		echo '<meta name="description" content="' . $stdescription_top .'">'. "\n";
		}

	}
}
add_action('wp_head', 'st_metadescription_head');

if (!function_exists('st_metakeywords_head')) {
	function st_metakeywords_head() {
		if ( trim( $GLOBALS["stdata46"] ) !== '' && ( is_front_page()) ) {
		$stmetakeywords_top = esc_attr( $GLOBALS["stdata46"] );
		echo '<meta name="keywords" content="' . $stmetakeywords_top .'">'. "\n";
		}

	}
}
add_action('wp_head', 'st_metakeywords_head');

if (!function_exists('st_satikoadds_head')) {
	function st_satikoadds_head() {
		if ( trim( $GLOBALS["stdata14"] ) !== '' ) {
		$satiko = stripslashes( $GLOBALS["stdata14"] );
		echo '<meta name="google-site-verification" content="'.$satiko.'" />'."\n";
		}
	}
}
add_action('wp_head', 'st_satikoadds_head');

if ( !function_exists( 'st_kaiseki_footer ' ) ) {
	function st_kaiseki_footer() {
		if ( trim( $GLOBALS["stdata23"] ) !== '' ) {
		$kaiseki = stripslashes ( $GLOBALS["stdata23"] );
		echo $kaiseki ."\n";
		}
	}
}
add_action( 'wp_footer', 'st_kaiseki_footer', 1 );

if ( !function_exists( 'st_code_header' ) ) {
	function st_code_header() {
		if ( trim( $GLOBALS["stdata130"] ) !== '' ) {
		$st_code_h = stripslashes ( $GLOBALS["stdata130"] );
		echo $st_code_h ."\n";
		}
	}
}
add_action( 'wp_head', 'st_code_header', 10 );

if ( !function_exists( 'st_login_ver' ) ) {
	function st_login_ver() {
		$my_theme = wp_get_theme(get_template());
		echo '<!-- '. $my_theme->Name . $my_theme->Version .'-->';
	}
}
add_action( 'login_footer', 'st_login_ver', 1 );

if ( !function_exists( 'st_fontawesome4_header' ) ) {
	function st_fontawesome4_header() {
		if ( isset( $GLOBALS["stdata400"] ) && $GLOBALS["stdata400"] === 'yes' ) {
			$st_fontawesome4_style = get_template_directory_uri();
			echo '<link rel="stylesheet" id="font-awesome-css"  href="' . $st_fontawesome4_style . '/css/fontawesome/css/font-awesome.min.css?ver=4.7.0" type="text/css" media="all" />';
		}
	}
}
add_action( 'wp_head', 'st_fontawesome4_header', 11 );

if ( ! function_exists( 'st_auto_adsense_code_header' ) ) {
	function st_auto_adsense_code_header() {
		$hide_on_top      = (bool) get_option( 'st-data243', '' );
		$hide_on_post     = (bool) get_option( 'st-data244', '' );
		$hide_on_page     = (bool) get_option( 'st-data245', '' );
		$hide_on_category = (bool) get_option( 'st-data246', '' );

		if ( // ページ別非表示 (全体設定)
			is_404() || // 404
			( is_front_page() && $hide_on_top ) || 
			( is_single() && $hide_on_post ) || 
			( is_page() && $hide_on_page ) || 
			( is_category() && $hide_on_category ) 
		) {
			return;
		}

		if ( is_single() || is_page() ) { 
			$post_id         = get_queried_object_id();
			$no_auto_adsense = (bool) get_post_meta( $post_id, 'auto_adsense_koukoku_set', true ); 
			$no_ads          = (bool) get_post_meta( $post_id, 'koukoku_set', true ); 

			if ( $no_auto_adsense || $no_ads ) { 
				return;
			}
		}

		$auto_adsense_code = trim( get_option( 'st-data242', '' ) );

		if ( $auto_adsense_code !== '' ) {
			echo stripslashes( $auto_adsense_code ) . "\n";
		}
	}
}
add_action( 'wp_head', 'st_auto_adsense_code_header' );

if ( !function_exists( 'st_playnow_footer ' ) ) {
	function st_playnow_footer() {
		if(!wp_is_mobile()):
			if ( ((trim( $GLOBALS["stdata110"] ) !== '') && (trim( $GLOBALS["stdata111"] ) !== '')) && (trim( $GLOBALS["stdata117"] ) !== '') && ( ($GLOBALS["stdata117"])  === 'yes') ) {
				$playurl = esc_attr($GLOBALS["stdata110"]) ;
				if( is_front_page() || (trim( $GLOBALS["stdata116"] ) !== '') && ( ($GLOBALS["stdata116"])  === 'yes')):
					echo '<p id="playnow"><i class="fa fa-youtube-play" aria-hidden="true"></i><a href="//youtu.be/'.$playurl.'" rel="nofollow" target="_blank">PLAY NOW</a></p>';
				endif;
			}
		endif;
	}
}
add_action( 'wp_footer', 'st_playnow_footer', 1 );

if ( !function_exists( 'st_add_author_filter' ) ) {
	function st_add_author_filter() {
		global $post_type;
		if ( $post_type == 'post' ) {
			wp_dropdown_users( array('show_option_all' => 'すべてのユーザー', 'name' => 'author') );
		}
	}
}
add_action( 'restrict_manage_posts', 'st_add_author_filter' );

if (!function_exists('st_tiny_mce_before_init')) {
	function st_tiny_mce_before_init( $init_array ) {
	$init_array['block_formats'] = '段落=p;見出し2=h2;見出し3=h3;見出し4=h4;見出し5=h5;見出し6=h6';
	$init_array['fontsize_formats'] = '70% 80% 90% 120% 130% 150% 200% 250% 300%';
	$style_formats = array (
		array(
			'title' => 'テキスト',
			'items' => array(
				array( 'title' => '赤字', 'inline' => 'span', 'classes' => 'st-aka' ),
				array( 'title' => '太字', 'inline' => 'span', 'classes' => 'huto' ),
				array( 'title' => '赤字（太字）', 'inline' => 'span', 'classes' => 'hutoaka' ),
				array( 'title' => '大文字', 'inline' => 'span', 'classes' => 'oomozi' ),
				array( 'title' => '小文字', 'block' => 'p', 'classes' => 'komozi' ),
				array( 'title' => 'ドット線', 'inline' => 'span', 'classes' => 'dotline' ),
				array( 'title' => '参照リンク', 'block' => 'p', 'classes' => 'st-share' ),
				array( 'title' => '参考', 'inline' => 'span', 'classes' => 'sankou' ),
				array( 'title' => '必須', 'inline' => 'span', 'classes' => 'st-hisu' ),
				array( 'title' => '打消し', 'inline' => 'del' ),
				array( 'title' => 'code', 'inline' => 'code' ),
				array( 'title' => 'code風', 'inline' => 'span', 'classes' => 'st-code' ),
				array( 'title' => 'NotoSans（フォント）', 'inline' => 'span', 'classes' => 'st-notosans' ),
				array( 'title' => 'RoundedM+1c（フォント）', 'inline' => 'span', 'classes' => 'st-m1c' ),
			),
		),
		array(
			'title' => 'アニメーション',
			'items' => array(
				array( 'title' => '45°揺れ', 'inline' => 'span', 'classes' => 'fa faa-wrench animated st-animate' ),
				array( 'title' => 'ベル揺れ', 'inline' => 'span', 'classes' => 'fa faa-ring animated st-animate' ),
				array( 'title' => '横揺れ', 'inline' => 'span', 'classes' => 'fa faa-horizontal animated st-animate' ),
				array( 'title' => '縦揺れ', 'inline' => 'span', 'classes' => 'fa faa-vertical animated st-animate' ),
				array( 'title' => '点滅', 'block' => 'p', 'classes' => 'fa faa-flash animated st-animate' ),
				array( 'title' => 'バウンド', 'inline' => 'span', 'classes' => 'fa faa-bounce animated st-animate' ),
				array( 'title' => '回転', 'block' => 'p', 'classes' => 'fa faa-spin animated st-animate' ),
				array( 'title' => 'ふわふわ', 'inline' => 'span', 'classes' => 'fa faa-float animated st-animate' ),
				array( 'title' => '大小', 'inline' => 'span', 'classes' => 'fa faa-pulse animated st-animate' ),
				array( 'title' => 'シェイク', 'inline' => 'span', 'classes' => 'fa faa-shake animated st-animate' ),
				array( 'title' => 'シェイク（強）', 'inline' => 'span', 'classes' => 'st-shake st-animate' ),
				array( 'title' => '拡大（ゆれ）', 'inline' => 'span', 'classes' => 'fa faa-tada animated st-animate' ),
				array( 'title' => '過ぎる', 'inline' => 'span', 'classes' => 'fa faa-passing animated st-animate' ),
				array( 'title' => '戻る', 'inline' => 'span', 'classes' => 'fa faa-passing-reverse animated st-animate' ),
				array( 'title' => 'バースト', 'inline' => 'span', 'classes' => 'fa faa-burst animated st-animate' ),
				array( 'title' => '落ちる', 'inline' => 'span', 'classes' => 'fa faa-falling animated st-animate' ),
			),
		),
		array(
			'title' => 'アイコン',
			'items' => array(
				array( 'title' => 'はてな', 'block' => 'span', 'classes' => 'hatenamark2 on-color' ),
				array( 'title' => '注意', 'block' => 'span', 'classes' => 'attentionmark2 on-color' ),
				array( 'title' => '人物', 'block' => 'span', 'classes' => 'usermark2 on-color' ),
				array( 'title' => 'チェック', 'block' => 'span', 'classes' => 'checkmark2 on-color' ),
				array( 'title' => 'メモ', 'block' => 'span', 'classes' => 'memomark2 on-color' ),
				array( 'title' => '王冠', 'block' => 'span', 'classes' => 'oukanmark on-color' ),
				array( 'title' => '初心者マーク', 'block' => 'span', 'classes' => 'bigginermark on-color' ),
			),
		),
		array(
			'title' => '見出し',
			'items' => array(
				array( 'title' => 'キャッチコピー', 'inline' => 'span', 'classes' => 'st-h-copy' ),
				array( 'title' => 'キャッチコピー（+目次）', 'inline' => 'span', 'classes' => 'st-h-copy-toc' ),
				array( 'title' => '記事タイトル', 'block' => 'p', 'classes' => 'entry-title' ),
				array( 'title' => 'h2風', 'block' => 'p', 'classes' => 'h2modoki' ),
				array( 'title' => 'h3風', 'block' => 'p', 'classes' => 'h3modoki' ),
				array( 'title' => 'h4風', 'block' => 'p', 'classes' => 'h4modoki' ),
				array( 'title' => 'h5風', 'block' => 'p', 'classes' => 'h5modoki' ),
				array( 'title' => 'まとめ', 'block' => 'h4', 'classes' => 'st-matome' ),
				array( 'title' => 'カウント', 'block' => 'span', 'classes' => 'st-count' ),
			),
		),
		array(
			'title' => 'ランキング（管理CSS対応）',
			'items' => array(
				array( 'title' => 'ランキング1位（基本）', 'block' => 'h4', 'classes' => 'rankh4 rankno-1' ),
				array( 'title' => 'ランキング2位', 'block' => 'h4', 'classes' => 'rankh4 rankno-2' ),
				array( 'title' => 'ランキング3位', 'block' => 'h4', 'classes' => 'rankh4 rankno-3' ),
				array( 'title' => 'ランキング4位以下', 'block' => 'h4', 'classes' => 'rankh4 rankno-4' ),
			),
		),
		array(
			'title' => 'マーカー',
			'items' => array(
				array( 'title' => '黄マーカー', 'inline' => 'span', 'classes' => 'ymarker' ),
				array( 'title' => '黄マーカー（細）', 'inline' => 'span', 'classes' => 'ymarker-s' ),
				array( 'title' => '赤マーカー', 'inline' => 'span', 'classes' => 'rmarker' ),
				array( 'title' => '赤マーカー（細）', 'inline' => 'span', 'classes' => 'rmarker-s' ),
				array( 'title' => '青マーカー', 'inline' => 'span', 'classes' => 'bmarker' ),
				array( 'title' => '青マーカー（細）', 'inline' => 'span', 'classes' => 'bmarker-s' ),
				array( 'title' => '鼠マーカー', 'inline' => 'span', 'classes' => 'gmarker' ),
				array( 'title' => '鼠マーカー（細）', 'inline' => 'span', 'classes' => 'gmarker-s' ),
			),
		),
		array(
			'title' => '写真',
			'items' => array(
				array( 'title' => '枠線', 'inline' => 'span', 'classes' => 'photoline' ),
				array( 'title' => 'ポラロイド風', 'block' => 'div', 'classes' => 'st-photohu' ),
				array( 'title' => 'ワイド', 'block' => 'div', 'classes' => 'st-eyecatch-width' ),
			),
		),
		array(
			'title' => 'ボックス',
			'items' => array(
				array( 'title' => '黄色', 'block' => 'div', 'classes' => 'yellowbox', 'wrapper' => true ),
				array( 'title' => '薄赤', 'block' => 'div', 'classes' => 'redbox', 'wrapper' => true ),
				array( 'title' => 'グレー', 'block' => 'div', 'classes' => 'graybox', 'wrapper' => true ),
				array( 'title' => '引用風', 'block' => 'div', 'classes' => 'inyoumodoki', 'wrapper' => true ),
				array( 'title' => 'ワイド背景', 'block' => 'div', 'classes' => 'st-wide-background', 'wrapper' => true ),
				array( 'title' => 'ワイド背景（左寄せ）', 'block' => 'div', 'classes' => 'st-wide-background-left', 'wrapper' => true ),
				array( 'title' => 'ワイド背景（右寄せ）', 'block' => 'div', 'classes' => 'st-wide-background-right', 'wrapper' => true ),
			),
		),
		array(
			'title' => 'リスト',
			'items' => array(
				array( 'title' => 'ドット下線（リスト）', 'block' => 'div', 'classes' => 'st-list-border', 'wrapper' => true ),
				array( 'title' => 'マル（リスト）', 'block' => 'div', 'classes' => 'st-list-circle', 'wrapper' => true ),
				array( 'title' => 'マル+ドット下線（リスト）', 'block' => 'div', 'classes' => 'st-list-circle st-list-border', 'wrapper' => true ),
				array( 'title' => '簡易チェック（リスト）', 'block' => 'div', 'classes' => 'st-list-check', 'wrapper' => true ),
				array( 'title' => '簡易チェック+ドット下線（リスト）', 'block' => 'div', 'classes' => 'st-list-check st-list-border', 'wrapper' => true ),
				array( 'title' => 'チェックボックス（番号なしリスト）', 'block' => 'div', 'classes' => 'st-square-checkbox st-square-checkbox-nobox', 'wrapper' => true ),
				array( 'title' => 'チェックリスト（番号なしリスト）', 'block' => 'div', 'classes' => 'maruck', 'wrapper' => true ),
				array( 'title' => 'ナンバリング（番号付きリスト）', 'block' => 'div', 'classes' => 'maruno', 'wrapper' => true ),
				array( 'title' => 'ナンバリング四角（リスト）', 'block' => 'div', 'classes' => 'st-list-no', 'wrapper' => true ),
				array( 'title' => 'ナンバリング四角+ドット下線（リスト）', 'block' => 'div', 'classes' => 'st-list-no st-list-border', 'wrapper' => true ),
			),
		),
		array(
			'title' => 'レイアウト',
			'items' => array(
				array( 'title' => '回り込み解除', 'block' => 'div', 'classes' => 'clearfix', 'wrapper' => true ),
				array( 'title' => 'センター寄せ', 'block' => 'div', 'classes' => 'center', 'wrapper' => true ),
				array( 'title' => 'センター寄せ（スマホのみ）', 'block' => 'div', 'classes' => 'sp-center', 'wrapper' => true ),
				array( 'title' => '下に余白', 'block' => 'div', 'classes' => 'under-space', 'wrapper' => true ),
				array( 'title' => 'カードスタイル', 'block' => 'div', 'classes' => 'st-cardstyle', 'wrapper' => true ),
				array( 'title' => 'カードスタイルB', 'block' => 'div', 'classes' => 'st-cardstyleb' , 'wrapper' => true ),
				array( 'title' => 'ランキングボックス', 'block' => 'div', 'classes' => 'rankst-wrap', 'wrapper' => true ),
				array( 'title' => 'width100%リセット', 'block' => 'span', 'classes' => 'resetwidth', 'wrapper' => true ),
				array( 'title' => 'imgインラインボックス', 'block' => 'span', 'classes' => 'inline-img', 'wrapper' => true ),
			),
		),
		array(
			'title' => 'テーブル',
			'items' => array(
				array( 'title' => '横スクロール', 'block' => 'div', 'classes' => 'scroll-box', 'wrapper' => true ),
				array( 'title' => '中央配置', 'block' => 'div', 'classes' => 'st-centertable', 'wrapper' => true ),
				array( 'title' => '装飾なし', 'block' => 'div', 'classes' => 'notab', 'wrapper' => true ),
			),
		),
	);
	$init_array['style_formats'] = json_encode( $style_formats );
	$init['style_formats_merge'] = false;
	return $init_array;
	}
}
add_filter( 'tiny_mce_before_init', 'st_tiny_mce_before_init' );

if ( !function_exists( '_st_insert_tiny_mce_button' ) ) {
	function _st_insert_tiny_mce_button( $button, $buttons, $position = 1 ) {
		$button_count = count( $buttons );

		if ( $button_count === 0 || $button_count < $position ) {
			$buttons[] = $button;

			return $buttons;
		}

		if ( $position === 1 ) {
			array_unshift( $buttons, $button );

			return $buttons;
		}

		$index   = $position - 1;
		$before  = array_slice( $buttons, 0, $index, true );
		$after   = array_slice( $buttons, $index, true );
		$buttons = array_merge( $before, array( $button ), $after );

		return $buttons;
	}
}

if ( !function_exists( 'st_tiny_mce_style_select' ) ) {
	function st_tiny_mce_style_select( $buttons ) {
		$position = 2;

		$button = 'styleselect';

		unset( $buttons[$button] );

		return _st_insert_tiny_mce_button( $button, $buttons, $position );
	}
}

add_filter( 'mce_buttons_2', 'st_tiny_mce_style_select' );

if (!function_exists('st_add_orignal_quicktags')) {

	function st_add_orignal_quicktags() {
		if ( wp_script_is( 'quicktags' ) ) { ?>
			<script type="text/javascript">
				<?php if ( trim($GLOBALS['stdata198']) === '' ): ?>
					QTags.addButton('ed_p', 'P', '<p>', '</p>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata188']) === '' ): ?>
					QTags.addButton('ed_huto', '太字', '<span class="huto">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata189']) === '' ): ?>
					QTags.addButton('ed_staka', '赤字', '<span class="st-aka">', '</span>');
					QTags.addButton('ed_hutoaka', '太字（赤）', '<span class="hutoaka">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata190']) === '' ): ?>
					QTags.addButton('ed_oomozi', '大文字', '<span class="oomozi">', '</span>');
					QTags.addButton('ed_sizechange', '%指定', '<span style="font-size:150%">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata191']) === '' ): ?>
					QTags.addButton('ed_komozi', '小文字', '<p class="komozi">', '</p>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata192']) === '' ): ?>
					QTags.addButton('ed_dotline', 'ドット線', '<span class="dotline">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata193']) === '' ): ?>
					QTags.addButton('ed_ymarker', '黄マーカー', '<span class="ymarker">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata194']) === '' ): ?>
					QTags.addButton('ed_rmarker', '赤マーカー', '<span class="rmarker">', '</span>');
					QTags.addButton('ed_sansyou', '参照リンク', '<p class="st-share">', '</p>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata195']) === '' ): ?>
					QTags.addButton('ed_sankou', '参考', '<span class="sankou">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata196']) === '' ): ?>
					QTags.addButton('ed_hisu', '必須', '<span class="st-hisu">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata197']) === '' ): ?>
					QTags.addButton('ed_photoline', '写真に枠線', '<span class="photoline">', '</span>');
					QTags.addButton('ed_photohu', 'ポラロイド風', '<div class="st-photohu">', '</div>');
					QTags.addButton('ed_photo_lavel', 'ラベル', '[st-label label="おすすめ" bgcolor="" color=""]', '[/st-label]');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata156']) === '' ): ?>
					//QTags.addButton('ed_entry', '記事タイトルデザイン', '<p class="entry-title">', '</p>');
					QTags.addButton('ed_count', 'カウント', '<span class="st-count">', '</span>');
					QTags.addButton('ed_count', 'カウントのリセット範囲', '<div class="st-count-reset">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata199']) === '' ): ?>
					QTags.addButton('ed_code', 'code', '<code>', '</code>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata157']) === '' ): ?>
					QTags.addButton('ed_ads', 'アドセンス', '[adsense]', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata158']) === '' ): ?>
					QTags.addButton('ed_sc', 'オリジナルSC', '[originalsc]', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata159']) === '' ): ?>
					QTags.addButton('ed_freebox', 'フリーボックス', '<div style="padding:10px 0;"><div class="freebox"><p class="p-free"><span class="p-entry-f">タイトル（全角15文字）</span></p><div class="free-inbox">ここに本文を記述</div></div></div>', '');
					QTags.addButton('ed_mybox', 'マイボックス', '[st-mybox title="" fontawesome="" color="#757575" bordercolor="#f3f3f3" bgcolor="#f3f3f3" borderwidth="0" borderradius="5" titleweight=""]', '[/st-mybox]');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata160']) === '' ): ?>
					QTags.addButton('ed_toc', '目次（TOC+）', '[toc]', '');
				
					if (typeof ST !== 'undefined' && ST.st_toc_enabled) {
						QTags.addButton('ed_st_toc', '目次（すごいもくじ）', '\n\n[st_toc]\n\n', '');
						QTags.addButton( 'ed_data_st_toc_h', '目次上書きdata', " data-st-toc-h=\"\"", '' );
					}
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata161']) === '' ): ?>
					QTags.addButton('ed_star', 'スター', '[star5]', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata162']) === '' ): ?>
					//QTags.addButton('ed_stchildlink', '固定ページ子ページリンク', '[stchildlink]', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata232']) === '' ): ?>
					QTags.addButton('ed_blogcard', 'ブログカード風', '[st-card id=',' ]');

					if (typeof ST !== 'undefined' && ST.affiliate_manager_enabled) {
						QTags.addButton('ed_rankgroup', 'ランキング', '[st-rankgroup id="', '" label="" name=""]');
					}

					QTags.addButton('ed_youtube', 'YouTubeID', '[youtube id=',' ]');
					QTags.addButton('ed_btnlink_l', 'ボタンA', '<div class="rankstlink-r2"><p><a href="#">ボタンA</a></p></div>', '');
					QTags.addButton('ed_btnlink_r', 'ボタンB', '<div class="rankstlink-l2"><p><a href="#">ボタンB</a></p></div>', '');
					QTags.addButton('ed_matome', 'まとめ', '<h4 class="st-matome">', '</h4>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata163']) === '' ): ?>
					QTags.addButton('ed_clearfix', '回り込み解除', '<div class="clearfix">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata164']) === '' ): ?>
					QTags.addButton('ed_center', 'センター寄せ', '<div class="center">', '</div>');
					QTags.addButton('ed_spcenter', 'センター寄せ（スマホのみ）', '<div class="sp-center">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata165']) === '' ): ?>
					QTags.addButton('ed_bottom', '下に余白', '<div style="padding-bottom:10px">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata166']) === '' ): ?>
					QTags.addButton('ed_yellowbox', '黄色ボックス', '<div class="yellowbox">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata167']) === '' ): ?>
					QTags.addButton('ed_redbox', '薄赤ボックス', '<div class="redbox">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata168']) === '' ): ?>
					QTags.addButton('ed_graybox', 'グレーボックス', '<div class="graybox">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata169']) === '' ): ?>
					QTags.addButton('ed_stcardstyle', 'カードスタイル', '<div class="st-cardstyle">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata170']) === '' ): ?>
					QTags.addButton('ed_stcardstyleb', 'カードスタイルB', '<div class="st-cardstyleb">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata171']) === '' ): ?>
					QTags.addButton('ed_inyoumodoki', '引用風', '<div class="inyoumodoki">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata172']) === '' ): ?>
					QTags.addButton('ed_maruno', 'ナンバリング（番号付きリスト）', '<div class="maruno">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata173']) === '' ): ?>
					QTags.addButton('ed_maruck', 'チェックリスト（番号なしリスト）', '<div class="maruck">', '</div>');
					QTags.addButton('ed_maruck_b', 'チェックボックス（番号なしリスト）', '<div class="st-square-checkbox st-square-checkbox-nobox">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata174']) === '' ): ?>
					QTags.addButton('ed_kintou', 'ulタグを囲む均等横並び', '<div class="kintou">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata176']) === '' ): ?>
					QTags.addButton('ed_resetwidth', 'width100%リセット', '<span class="resetwidth">', '</span>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata175']) === '' ): ?>
					QTags.addButton('ed_scroll_box', 'table横スクロールボックス', '<div class="scroll-box">', '</div>');
					QTags.addButton('ed_st_centertable', 'table中央配置', '<div class="st-centertable">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata200']) === '' ): ?>
					QTags.addButton('ed_notab', '装飾なしテーブル', '<div class="notab">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata177']) === '' ): ?>
					QTags.addButton('ed_smanone', 'スマホに表示しないボックス', '[pc]', '[/pc]');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata178']) === '' ): ?>
					QTags.addButton('ed_pcnone', 'PCに表示しないボックス', '[nopc]', '[/nopc]');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata179']) === '' ): ?>
					QTags.addButton('ed_responbox', 'PCとTab左右40:60%', '<div class="clearfix responbox"><div class="lbox"><p>左側のコンテンツ40%</p></div><div class="rbox"><p>右側のコンテンツ60%</p></div></div>', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata180']) === '' ): ?>
					QTags.addButton('ed_responbox50', 'PCとTab左右50%', '<div class="clearfix responbox50"><div class="lbox"><p>左側のコンテンツ50%</p></div><div class="rbox"><p>右側のコンテンツ50%</p></div></div>', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata181']) === '' ): ?>
					QTags.addButton('ed_responbox50s', '全サイズ左右50%', '<div class="clearfix responbox50 smart50"><div class="lbox"><p>左側のコンテンツ50%</p></div><div class="rbox"><p>右側のコンテンツ50%</p></div></div>', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata182']) === '' ): ?>
					QTags.addButton('ed_responbox30s', '全サイズ左右30:70%', '<div class="clearfix responbox30 smart30"><div class="lbox"><p>左側のコンテンツ30%</p></div><div class="rbox"><p>右側のコンテンツ70%</p></div></div>', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata183']) === '' ): ?>
					QTags.addButton('ed_responboxfree', '全サイズ左右free%', '<div class="clearfix responboxfree smartfree"><div class="lbox" style="width:50%"><p>左側のコンテンツ%</p></div><div class="rbox" style="width:50%"><p>右側のコンテンツ%</p></div></div>', '');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata184']) === '' ): ?>
					QTags.addButton('ed_ranktitle', 'ランキング大見出し', '<h3 class="rankh3"><span class="rankh3-in">', '</span></h3>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata185']) === '' ): ?>
					QTags.addButton('ed_rankarea', 'ランキングエリア背景', '<div class="rankst-wrap">', '</div>');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata232']) === '' ): ?>
					QTags.addButton('ed_st_af_cpt', 'タグID', '[st_af id="', '"]');
					QTags.addButton('ed_st_af_slug', 'タグSlug', '[st_af name="', '"]');
					QTags.addButton('ed_st_css_no', 'CSSNO', 'class="st-css-no"', '');
					QTags.addButton('ed_st_out', 'コメントアウト', '[st-out]', '[/st-out]');
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata186']) === '' ): ?>
					QTags.addButton( 'ed_ive', 'イベント', "onclick=\"ga('send', 'event', 'linkclick', 'click', 'hoge');\"", '' );
				<?php endif; ?>

				<?php if ( trim($GLOBALS['stdata187']) === '' ): ?>
					QTags.addButton( 'ed_nofollow', 'nofollow', " rel=\"nofollow\"", '' );
				<?php endif; ?>

			</script>
			<?php
		}
	}
}
if ( trim($GLOBALS['stdata137']) === '' ) {
	add_action('admin_print_footer_scripts', 'st_add_orignal_quicktags');
}

if ( !function_exists( 'st_tiny_mce_visual_buttons' ) ) {
	function st_tiny_mce_visual_buttons( $buttons ) {
		$custom_buttons = array(
			'st_listbox_1'         => PHP_INT_MAX,
			'st_button_huto'    => PHP_INT_MAX,
			'st_button_hutoaka' => PHP_INT_MAX,
			'st_button_mycolor' => PHP_INT_MAX,
			'st_button_mymarker' => PHP_INT_MAX,
			'st_button_ruby' => PHP_INT_MAX,
			'st_button_count' => PHP_INT_MAX,
			'st_button_photoline'  => PHP_INT_MAX,
			'st_button_kadomaru_bg'  => PHP_INT_MAX,
			'st_btnlink_custom_main' => PHP_INT_MAX,
			'st_button_blogcard'    => PHP_INT_MAX,
			'st_button_st_toc'  => PHP_INT_MAX,
		);

		foreach ( $custom_buttons as $custom_button => $position ) {
			$buttons = _st_insert_tiny_mce_button( $custom_button, $buttons, $position );
		}

		return $buttons;
	}
}
if ( trim($GLOBALS['stdata137']) === '' ) {
	add_filter( 'mce_buttons_2', 'st_tiny_mce_visual_buttons' );
}

if ( !function_exists( 'st_register_tiny_mce_plugins' ) ) {
	function st_register_tiny_mce_plugins( $plugins ) {
		$plugins['st_plugin'] = get_template_directory_uri() . '/js/tinymce-st-plugin.js';

		return $plugins;
	}
}
add_filter( 'mce_external_plugins', 'st_register_tiny_mce_plugins' );

if ( !function_exists( 'st_editor_option_content_retriever' ) ) {
	function st_editor_option_content_retriever( $name ) {
		return stripslashes( get_option( $name, '' ) );
	}
}

if ( !function_exists( 'st_get_the_editor_content' ) ) {
	function st_get_the_editor_content( $name, $content_retriever = null ) {
		$content_retriever = is_callable( $content_retriever ) ? $content_retriever : 'st_editor_option_content_retriever';

		return call_user_func( $content_retriever, $name );
	}
}

if ( !function_exists( 'st_the_editor_content' ) ) {
	function st_the_editor_content( $name, $content_retriever = null ) {
		$content = st_get_the_editor_content( $name, $content_retriever );

		add_filter( 'the_content', 'st_wrap_iframe_in_div' );

		$content = apply_filters( 'the_content', $content );

		remove_filter( 'the_content', 'st_wrap_iframe_in_div' );

		$content = apply_filters( 'st_the_editor_content', $content );
		$content = str_replace( ']] > ', ']]&gt;', $content );

		echo $content;
	}
}

if ( ! function_exists( 'st_pre_term_description' ) ) {
	function st_pre_term_description( $value, $taxonomy ) {
		if ( in_array( $taxonomy, array( 'category' ), true ) ) {
			return $value;
		}

		return wp_filter_kses( $value ); 
	}
}
remove_filter( 'pre_term_description', 'wp_filter_kses' );
add_filter( 'pre_term_description', 'st_pre_term_description', 10, 2 );

if ( ! function_exists( 'st_term_description' ) ) {
	function st_term_description( $value, $term_id, $taxonomy, $context ) {
		$allow_html       = false;
		$trim_description = false;

		if ( is_admin() && function_exists( 'get_current_screen' ) ) {
			$screen     = get_current_screen();
			$taxonomies = array( 'category' );

			$allow_html = $screen &&
			              ( $screen->base === 'term' && in_array( $screen->taxonomy, $taxonomies, true ) ) &&
			              ( $context === 'display' && in_array( $taxonomy, $taxonomies, true ) );

			$trim_description = $screen &&
			                    ( $screen->base === 'edit-tags' && in_array( $screen->taxonomy, $taxonomies, true ) ) &&
			                    ( $context === 'display' && in_array( $taxonomy, $taxonomies, true ) );
		}

		if ( $allow_html ) {
			$term = get_term( $term_id );

			if ( ! $term || is_wp_error( $term ) ) {
				return '';
			}

			return $term->description;
		}

		$description = $value;
		$description = wptexturize( $description );
		$description = convert_chars( $description );
		$description = wpautop( $description );
		$description = shortcode_unautop( $description );

		if ( $trim_description ) {
			$description = strip_tags( $description );
			$description = preg_replace( '/[\r\n]+]/', ' ', $description );
			$description = mb_strimwidth( $description, 0, 128 /* 長さ */, '..' );
		}

		return $description;
	}
}
remove_filter( 'term_description', 'wptexturize' );
remove_filter( 'term_description', 'convert_chars' );
remove_filter( 'term_description', 'wpautop' );
remove_filter( 'term_description', 'shortcode_unautop' );
add_filter( 'term_description', 'st_term_description', 10, 4 );

if ( isset($GLOBALS['stdata45']) && $GLOBALS['stdata45'] === 'yes' ) {
	add_filter('widget_text', 'do_shortcode' );
}

function wp_custom_admin_css() {
	echo "\n" . '<link href="' .get_template_directory_uri(). '/css/fontawesome/css/font-awesome.min.css' . '" rel="stylesheet" type="text/css" />' . "\n";
	echo "\n" . '<link href="' .get_template_directory_uri(). '/st_svg/style.css' . '" rel="stylesheet" type="text/css" />' . "\n";
}
add_action('admin_head', 'wp_custom_admin_css', 100);

if ( trim($GLOBALS['stdata47']) === '' ) {
	add_filter( 'auto_update_core', '__return_false' );
}

function st_admin_script(){
	wp_enqueue_script( 'st-admin-script', get_template_directory_uri() . '/st-admin-script.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'st_admin_script' );

if ( !function_exists( 'st_body_class' ) ) {
	function st_body_class( $classes ) {
		if ( st_is_mobile() ) {
			$classes[] = 'mobile';
		}

		$test_queries = array(
			'front-page' => is_front_page(),
		);

		foreach ( $test_queries as $class => $is_true ) {
			$classes[] = $is_true ? $class : ('not-' . $class);
		}

		return array_unique( $classes );
	}
}
add_filter( 'body_class', 'st_body_class' );

if ( !function_exists( 'st_author' ) ) {
	function st_author() {
		if (
			isset( $GLOBALS['stdata210'] ) && $GLOBALS['stdata210'] === 'yes' && is_single() || // 投稿ページで「この記事を書いた人」を出力
			isset( $GLOBALS['stdata212'] ) && $GLOBALS['stdata212'] === 'yes' && is_page() // 固定ページで「この記事を書いた人」を出力
			):
				if ( (trim($GLOBALS['stdata17']) !== '' ) && ($GLOBALS['stdata17'] === 'yes') ) {
				echo '<p class="author" style="display:none;"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . get_the_author() . '" class="vcard author">'. '<span class="fn">' . get_the_author() . '</span>' . '</a></p>';
				}else{
				echo '<p class="author" style="display:none;"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . get_the_author() . '" class="vcard author">'. '<span class="fn">author</span>' . '</a></p>';
				}
		else:
				if ( (trim($GLOBALS['stdata17']) !== '' ) && ($GLOBALS['stdata17'] === 'yes') ) {
				echo '<p class="author">執筆者: <a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . get_the_author() . '" class="vcard author">'. '<span class="fn">' . get_the_author() . '</span>' . '</a></p>';
				}else{
				echo '<p class="author" style="display:none;"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . get_the_author() . '" class="vcard author">'. '<span class="fn">author</span>' . '</a></p>';
				}
		endif;
	}
}


if ( isset($GLOBALS['stdata58']) && $GLOBALS['stdata58'] === 'yes' ) {
	remove_action('do_feed_rdf', 'do_feed_rdf');
	remove_action('do_feed_rss', 'do_feed_rss');
	remove_action('do_feed_rss2', 'do_feed_rss2');
	remove_action('do_feed_atom', 'do_feed_atom');
}

if ( !function_exists( 'st_add_posts_columns' ) ) {
	function st_add_posts_columns($columns, $post_type) {
		$show_extra_columns = ( get_option( 'st-data129', '' ) === 'yes' );

		if ( $show_extra_columns && post_type_supports( $post_type, 'thumbnail' ) ) {
			$columns['thumbnail'] = 'サムネイル';
		}

		$columns['postid'] = 'ID';

		if ( $show_extra_columns && post_type_supports( $post_type, 'editor' ) ) {
			$columns['count'] = '文字数';
		}

		echo '<style type="text/css">
		.fixed .column-thumbnail {width: 120px;}
		.fixed .column-postid {width: 5%;}
		.fixed .column-count {width: 5%;}
		</style>';

		return $columns;
	}
}
if ( !function_exists( 'st_add_posts_columns_row' ) ) {
	function st_add_posts_columns_row($column_name, $post_id) {
		$show_extra_columns = ( get_option( 'st-data129', '' ) === 'yes' );

		if ( $show_extra_columns && 'thumbnail' === $column_name ) {
			$thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
			echo ( $thumb ) ? $thumb : '−';
		} elseif ( 'postid' === $column_name ) {
			echo esc_html( $post_id );
		} elseif ( $show_extra_columns && 'count' === $column_name ) {
			$count = esc_html( mb_strlen(strip_tags(get_post_field('post_content', $post_id))) );
		echo $count;
		}
	}
}

add_filter( 'manage_posts_columns', 'st_add_posts_columns', 10, 2 );
add_action( 'manage_posts_custom_column', 'st_add_posts_columns_row', 10, 2 );
add_filter( 'manage_pages_columns', function ( $columns ) { return st_add_posts_columns( $columns, 'page' ); } );
add_action( 'manage_pages_custom_column', 'st_add_posts_columns_row', 10, 2 );

if ( isset($GLOBALS['stdata61']) && $GLOBALS['stdata61'] === 'yes' ) {
	if ( ! function_exists( 'st_mytheme_init' ) ) {
		function st_mytheme_init() {
			global $wp_rewrite;
			$wp_rewrite->use_trailing_slashes = false;
			$wp_rewrite->page_structure = $wp_rewrite->root . '%pagename%.html';
		flush_rewrite_rules( false );
		}
	}
	add_action( 'init', 'st_mytheme_init' );
}

if ( ! function_exists( 'st_redirect_to_canonical_paged_url' ) ) {
	function st_redirect_to_canonical_paged_url() {
		$paged = (int) get_query_var( 'paged' );

		if ( $paged !== 1 ) {
			return;
		}

		$home_url_parts = @parse_url( home_url() );

		if ($home_url_parts === false) {
			return;
		}

		$base_url = $home_url_parts['scheme'] . '://' . $home_url_parts['host'] .
		            ( isset( $home_url_parts['port'] ) ? ':' . $home_url_parts['port'] : '' );

		$current_url       = $base_url . add_query_arg( array() );
		$current_url_parts = @parse_url( $current_url );

		if ( $current_url_parts === false ) {
			return;
		}

		$query    = isset( $current_url_parts['query'] ) ? $current_url_parts['query'] : '';
		$fragment = isset( $current_url_parts['fragment'] ) ? '#' . $current_url_parts['fragment'] : '';

		$queries = [];

		parse_str( $query, $queries );
		unset( $queries['paged'] );

		$front_page_url = home_url() .
		                  ( ( count( $queries ) > 0 ) ? '?' . build_query( $queries ) : '' ) .
		                  $fragment;

		if ( is_front_page() || is_search() ) {
			wp_redirect( $front_page_url, 301 );

			exit;
		}

		$show_page_on_front = ( get_option( 'show_on_front' ) === 'page' );
		$page_on_front      = get_option( 'page_on_front', '0' );

		if ( $show_page_on_front && $page_on_front === '0' && is_home() ) {
			wp_redirect( $front_page_url, 301 );

			exit;
		}

		$canonical_url = $base_url . remove_query_arg( 'paged' );

		wp_redirect( $canonical_url, 301 );

		exit;
	}
}

add_action( 'template_redirect', 'st_redirect_to_canonical_paged_url' );

if ( ! function_exists( 'st_admin_manage_taxonomy_sortable_columns' ) ) {
	function st_admin_manage_taxonomy_sortable_columns( $sortable_columns ) {
		$sortable_columns['id'] = 'id';

		return $sortable_columns;
	}
}

add_filter( 'manage_edit-category_sortable_columns', 'st_admin_manage_taxonomy_sortable_columns' );
add_filter( 'manage_edit-post_tag_sortable_columns', 'st_admin_manage_taxonomy_sortable_columns' );

if ( ! function_exists( 'st_admin_manage_taxonomy_columns' ) ) {
	function st_admin_manage_taxonomy_columns( $columns ) {
		$index   = array_search( 'description', array_keys( $columns ), true ) ?: 0;
		$columns = array_merge(
			array_slice( $columns, 0, $index ),
			array( 'id' => 'ID' ),
			array_slice( $columns, $index )
		);

		return $columns;
	}
}

add_filter( 'manage_edit-category_columns', 'st_admin_manage_taxonomy_columns' );
add_filter( 'manage_edit-post_tag_columns', 'st_admin_manage_taxonomy_columns' );

if ( ! function_exists( 'st_admin_manage_taxonomy_custom_column' ) ) {
	function st_admin_manage_taxonomy_custom_column( $blank_string, $column_name, $term_id ) {
		if ( $column_name === 'id' ) {
			echo esc_html( $term_id );
		}
	}
}

add_action( 'manage_category_custom_column', 'st_admin_manage_taxonomy_custom_column', 10, 3 );
add_action( 'manage_post_tag_custom_column', 'st_admin_manage_taxonomy_custom_column', 10, 3 );

if ( ! function_exists( 'st_admin_print_edit_tags_styles' ) ) {
	function st_admin_print_edit_tags_styles() {
		?>
		<style>
			.fixed .column-id {
				width: 6%;
			}
		</style>
		<?php
	}
}

add_action( 'admin_print_styles-edit-tags.php', 'st_admin_print_edit_tags_styles' );

add_action('admin_print_styles','st_admin_print_styles');
function st_admin_print_styles(){
	echo '<link href="'.get_template_directory_uri().'/admin.css" type="text/css" rel="stylesheet" madia="all" />'. PHP_EOL;
}

if ( isset( $GLOBALS['stdata450']) && $GLOBALS['stdata450'] === 'yes' ):
	add_action('admin_print_styles','st_admin_post_status_styles');
	function st_admin_post_status_styles(){
		echo '<style> .post-state {color: #f44336;} </style>'.PHP_EOL;
	}
endif;

function sanitize_checkbox($input){
	if($input==true){
		return true;
	}else{
		return false;
	}
}

function st_sanitize_choices( $input, $setting ) {
    global $wp_customize;
 
    $control = $wp_customize->get_control( $setting->id );

    if ( array_key_exists( $input, $control->choices ) ) {
	   return $input;
    } else {
	   return $setting->default;
    }
}

function sanitize_int($input){
	return intval($input);
}

if ( !function_exists( 'st_force_to_hex_color' ) ) {
	function st_force_to_hex_color( $color ) {
		$color = trim( $color );

		if ( $color === '' ) {
			return $color;
		}

		if ( !preg_match( '|\A([A-Fa-f0-9]{3}){1,2}\z|', $color ) ) {
			return $color;
		}

		$color = '#' . $color;

		return $color;
	}
}

if ( !function_exists( 'sanitize_hex_color' ) ) {
	function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		if ( preg_match( '|\A#([A-Fa-f0-9]{3}){1,2}\z|', $color ) ) {
			return $color;
		}

		return null;
	}
}

if ( ! function_exists( 'st_canonical' ) ) {
	function st_canonical() {
		$page_id_on_top    = (int) get_option( 'st-data9' );
		$queried_object_id = get_queried_object_id();
		$is_page_on_top    = ( $page_id_on_top !== 0 && $queried_object_id === $page_id_on_top );

		if ( $is_page_on_top ) {
			echo '<link rel="canonical" href="' . esc_url( home_url() ) . '" />' . "\n";

			return;
		}

		rel_canonical();
	}
}
remove_action( 'wp_head', 'rel_canonical' );
add_action( 'wp_head', 'st_canonical' );

if ( !function_exists( 'st_noheader_class' ) ) {
	function st_noheader_class(){
		if( !has_header_image() || ( st_is_mobile() && trim($GLOBALS['stdata71']) !== '' ) || ( has_header_image() && ( trim($GLOBALS["stdata76"]) === 'yes' ||  trim($GLOBALS["stdata88"]) === 'yes' ) ) ){
			echo 'noheader';
		}else{
			echo 'onheader';
		}
	}
}

if ( isset($GLOBALS['stdata126']) && $GLOBALS['stdata126'] === 'yes' ) {

	function remove_dashboard_widgets() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);        // 現在の状況
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']); // アクティビティ
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);  // 最近のコメント
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);   // 被リンク
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);          // プラグイン
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);        // クイック投稿
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);      // 最近の下書き
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);            // WordPressブログ
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);          // WordPressフォーラム
	}
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
	remove_action( 'welcome_panel', 'wp_welcome_panel' );

	function so_screen_layout_columns( $columns ) {
		$columns['dashboard'] = 2;
		return $columns;
	}
	add_filter( 'screen_layout_columns', 'so_screen_layout_columns' );
	function so_screen_layout_dashboard() {
		return 2;
	}
	add_filter( 'get_user_option_screen_layout_dashboard', 'so_screen_layout_dashboard' );

}

if ( !function_exists( 'st_kaiwasc1_func' ) ) {
	function st_kaiwasc1_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata131"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata131"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata134"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata134"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon1 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon1 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa1', 'st_kaiwasc1_func');

if ( !function_exists( 'st_kaiwasc2_func' ) ) {
	function st_kaiwasc2_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata132"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata132"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata135"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata135"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon2 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon2 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa2', 'st_kaiwasc2_func');

if ( !function_exists( 'st_kaiwasc3_func' ) ) {
	function st_kaiwasc3_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata133"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata133"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata136"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata136"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon3 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon3 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa3', 'st_kaiwasc3_func');

if ( !function_exists( 'st_kaiwasc4_func' ) ) {
	function st_kaiwasc4_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata144"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata144"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata145"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata145"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon4 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon4 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa4', 'st_kaiwasc4_func');

if ( !function_exists( 'st_kaiwasc5_func' ) ) {
	function st_kaiwasc5_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata146"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata146"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata147"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata147"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon5 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon5 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa5', 'st_kaiwasc5_func');

if ( !function_exists( 'st_kaiwasc6_func' ) ) {
	function st_kaiwasc6_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata148"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata148"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata149"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata149"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon6 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon6 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa6', 'st_kaiwasc6_func');

if ( !function_exists( 'st_kaiwasc7_func' ) ) {
	function st_kaiwasc7_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata150"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata150"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata151"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata151"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon7 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon7 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa7', 'st_kaiwasc7_func');

if ( !function_exists( 'st_kaiwasc8_func' ) ) {
	function st_kaiwasc8_func( $arg, $content = null ) {
		if ( trim( $GLOBALS["stdata152"] ) !== '' ) {
			$kaiwaiconurl = esc_url( $GLOBALS["stdata152"] );
		}else{
			$kaiwaiconurl = get_template_directory_uri().'/images/no-img.png';		
		}
		if ( trim( $GLOBALS["stdata153"] ) !== '' ) {
			$kaiwaiconname = esc_html( $GLOBALS["stdata153"] );
		}else{
			$kaiwaiconname = '';			
		}

		if( isset($arg[0]) && ($arg[0] === 'r') ){
			return '<div class="st-kaiwa-box kaiwaicon8 clearfix"><div class="st-kaiwa-area2"><div class="st-kaiwa-hukidashi2">'.$content.'</div></div><div class="st-kaiwa-face2"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name2">'.$kaiwaiconname.'</div></div></div>';
		} else {
			return '<div class="st-kaiwa-box kaiwaicon8 clearfix"><div class="st-kaiwa-face"><img src="'.$kaiwaiconurl.'" width="60px"><div class="st-kaiwa-face-name">'.$kaiwaiconname.'</div></div><div class="st-kaiwa-area"><div class="st-kaiwa-hukidashi">'.$content.'</div></div></div>';
		}

	};
}
add_shortcode('st-kaiwa8', 'st_kaiwasc8_func');

if ( !function_exists( 'st_star5_func' ) ) {
	function st_star5_func( $arg, $content = null ) {
		return '<span class="y-star"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star5', 'st_star5_func');

if ( !function_exists( 'st_star45_func' ) ) {
	function st_star45_func( $arg, $content = null ) {
		return '<span class="y-star"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span><span class="w-star"><i class="fa fa-star-half-o" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star45', 'st_star45_func');

if ( !function_exists( 'st_star4_func' ) ) {
	function st_star4_func( $arg, $content = null ) {
		return '<span class="y-star"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span><span class="w-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star4', 'st_star4_func');

if ( !function_exists( 'st_star35_func' ) ) {
	function st_star35_func( $arg, $content = null ) {
		return '<span class="y-star"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span><span class="w-star"><i class="fa fa-star-half-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star35', 'st_star35_func');

if ( !function_exists( 'st_star3_func' ) ) {
	function st_star3_func( $arg, $content = null ) {
		return '<span class="y-star"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span><span class="w-star"><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star3', 'st_star3_func');

if ( !function_exists( 'st_star2_func' ) ) {
	function st_star2_func( $arg, $content = null ) {
		return '<span class="y-star"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span><span class="w-star"><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star2', 'st_star2_func');

if ( !function_exists( 'st_star1_func' ) ) {
	function st_star1_func( $arg, $content = null ) {
		return '<span class="y-star"><i class="fa fa-star" aria-hidden="true"></i></span><span class="w-star"><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star1', 'st_star1_func');

if ( !function_exists( 'st_star0_func' ) ) {
	function st_star0_func( $arg, $content = null ) {
		return '<span class="w-star"><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></span>';
	};
}
add_shortcode('star0', 'st_star0_func');

if ( isset($GLOBALS['stdata155']) && $GLOBALS['stdata155'] === 'yes' ) {
	if ( ! function_exists( 'st_no_pageing' ) ) {
		function st_no_pageing( $pages, $post ) {
			if ( ! wp_is_mobile() ) {
				$content   = str_replace( "\n<!--nextpage-->\n", '<!--nextpage-->', $post->post_content );
				$content   = str_replace( "\n<!--nextpage-->", '<!--nextpage-->', $content );
				$content   = str_replace( "<!--nextpage-->\n", '<!--nextpage-->', $content );
				$pages     = array( str_replace( '<!--nextpage-->', '', $content ) );
			}

			return $pages;
		}
	}
	add_action( 'content_pagination', 'st_no_pageing', 10, 2 );
}

if ( ! function_exists( '_st_remove_target_attr' ) ) {
	function _st_remove_target_attr( $content, $allowed_values = array(), $disallowed_values = 'all' ) {
		$pattern = '!(<a\s+[^>]*?)\starget\s*=\s*"([^"]*)"([^>]*>)!i';

		if ( ! preg_match( $pattern, $content ) ) {
			return $content;
		}

		$content = preg_replace_callback(
			$pattern,
			function ( $matches ) use ( $allowed_values, $disallowed_values ) {
				$before       = $matches[1];
				$target_value = $matches[2];
				$after        = $matches[3];

				$new_target_value = $target_value;

				if ( $allowed_values === 'none' ) {
					$new_target_value = '';
				} elseif ( $allowed_values !== 'all' ) {
					$new_target_value = in_array( $new_target_value, $allowed_values, true )
						? $new_target_value
						: '';
				}

				if ( $disallowed_values === 'all' ) {
					$new_target_value = '';
				} elseif ( $disallowed_values !== 'none' ) {
					$new_target_value = in_array( $new_target_value, $disallowed_values, true )
						? ''
						: $new_target_value;
				}

				$target_attr = ( $new_target_value !== '' ) ? ' target="' . $new_target_value . '"' : '';

				return $before . $target_attr . $after;
			},
			$content
		);

		return $content;
	}
}

if ( isset( $GLOBALS['stdata467'] ) && $GLOBALS['stdata467'] === 'yes' ) {
	if ( ! function_exists( 'st_target_blank_remove' ) ) {
		function st_target_blank_remove( $the_content ) {
			$cache_key = 'st_target_blank_remove_' . hash( 'sha256', serialize( func_get_args() ) );
			$cache     = wp_cache_get( $cache_key );

			if ( $cache !== false ) {
				return $cache;
			}

			$the_content = _st_remove_target_attr( $the_content, 'all', array( '_blank' ) );

			wp_cache_set( $cache_key, $the_content );

			return $the_content;
		}

		add_filter( 'the_content', 'st_target_blank_remove', 9999 );
	}
}

if ( isset( $GLOBALS['stdata8'] ) && $GLOBALS['stdata8'] === 'yes' ) {
	if ( ! function_exists( 'st_noopener_noreferrer_remove' ) ) {
		function st_noopener_noreferrer_remove( $the_content ) {
			$cache_key = 'st_noopener_noreferrer_remove_' . hash( 'sha256', serialize( func_get_args() ) );
			$cache     = wp_cache_get( $cache_key );

			if ( $cache !== false ) {
				return $cache;
			}

			$pattern = '!(<a\s+[^>]*?)\srel\s*=\s*"([^"]*?(?:noopener|noreferrer)[^"]*?)"([^>]*>)!i';
			
			if ( ! preg_match( $pattern, $the_content ) ) {
				return $the_content;
			}
			
			$the_content = preg_replace_callback(
				$pattern,
				function ( $matches ) {
					$before        = $matches[1];
					$rel_value     = $matches[2];
					$after         = $matches[3];
					$rel_values    = array_reduce(
						preg_split( '/\s+/', $rel_value ),
						function ( $rel_values, $rel_value ) {
							$rel_value = trim( $rel_value );
							
							if ( ! in_array( $rel_value, array( 'noopener', 'noreferrer' ), true ) ) {
								$rel_values[] = $rel_value;
							}
							
							return $rel_values;
						},
						array()
					);
					
					$new_rel_value = implode( ' ', $rel_values );
					$rel_attr      = ( $new_rel_value !== '' ) ? ' rel="' . $new_rel_value . '"' : '';
					
					return $before . $rel_attr . $after;
				},
				$the_content
			);

			wp_cache_set( $cache_key, $the_content );

			return $the_content;
		}

		add_filter( 'the_content', 'st_noopener_noreferrer_remove', 9999 );
	}
}

if ( ! function_exists( 'st_user_meta' ) ) {
	function st_user_meta($wb)
		{
		$wb['twitter'] = 'twitter（URL）';
		$wb['facebook'] = 'facebook（URL）';
		$wb['instagram'] = 'instagram（URL）';
		$wb['youtube'] = 'youtube（URL）';
		$wb['amazon'] = 'amazon（URL）';
		$wb['feed_url'] = 'feed（URL）';
		$wb['form_url'] = 'form（URL）';
		return $wb;
	}
}
add_filter('user_contactmethods', 'st_user_meta', 10, 1);

if ( isset($GLOBALS['stdata404']) && $GLOBALS['stdata404'] === 'yes' ) {
	remove_filter('pre_user_description', 'wp_filter_kses');
}

if ( ! function_exists( 'st_get_html_class' ) ) {
	function st_get_html_class( $class = '' ) {
		$classes   = array();

		$direction = trim( get_option( 'st-data236', '' ) );

		if ( $direction === 'right' ) {
			$classes[] = 's-navi-right';
		}

		$st_sticky_menu     = get_theme_mod( 'st_sticky_menu', '' );
		$header_bar_classes = array( '' => '', 'fixed' => 'header-bar-fixable', '1' => 'header-bar-trackable' );

		if ( in_array( $st_sticky_menu, array_keys( $header_bar_classes ), true ) ) {
			$classes[] = $header_bar_classes[ $st_sticky_menu ];
		}

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$_class = preg_split( '#\s+#', $class );
				$class  = ( $_class !== false ) ? $_class : array();
			}

			$classes = array_merge( $classes, $class );
		} else {
			$class = array();
		}

		$classes = array_map( 'esc_attr', $classes );
		$classes = apply_filters( 'theme_html_class', $classes, $class );

		return array_unique( $classes );
	}
}

if ( ! function_exists( 'st_html_class' ) ) {
	function st_html_class( $class = '' ) {
		echo 'class="' . implode( ' ', st_get_html_class( $class ) ) . '"';
	}
}

if ( isset($GLOBALS['stdata393']) && $GLOBALS['stdata393'] === 'yes' ) {
	if ( !function_exists( 'customize_tinymce_settings' ) ) {
		function customize_tinymce_settings($mceInit){

			$mceInit['table_resize_bars'] = false;
			$mceInit['object_resizing'] = 'img';

			$invalid_styles = array(
				'table' => 'width',
				'tr'    => 'width',
				'th'    => 'width',
				'td'    => 'width',
			);
			$mceInit['invalid_styles'] = wp_json_encode( $invalid_styles );

		return $mceInit;
		}
	add_filter('tiny_mce_before_init', 'customize_tinymce_settings', 0);
	}
}

if ( ! function_exists( 'st_get_kanren_posts_query' ) ) {
	function st_get_kanren_posts_query( $post, $args = array() ) {
		$post = get_post( $post );

		$posts_per_page = trim( get_option( 'st-data56', '' ) );    // 関連記事数
		$posts_per_page = ( $posts_per_page !== '' ) ? (int) $posts_per_page : 5;

		$load_more_enabled = ( trim( get_option( 'st-data421', '' ) ) === 'yes' );    // もっと読む（無限スクロール）を使用する
		$orderby           = $load_more_enabled ? 'date' : 'rand';

		$categories   = get_the_category( $post->ID );
		$category_ids = wp_list_pluck( $categories, 'term_id' );

		$args     = wp_parse_args( $args );
		$defaults = array(
			'posts_per_page'      => $posts_per_page,
			'ignore_sticky_posts' => true,
			'post__not_in'        => array( $post->ID ),
			'category__in'        => $category_ids,
			'orderby'             => $orderby,
		);

		$args = array_merge( $defaults, $args );

		return new WP_Query( $args );
	}
}

if ( ! function_exists( 'st_get_the_kanren_posts' ) ) {
	function st_get_the_kanren_posts( $post = null, $query_args = array(), $template_vars = array() ) {
		$post = get_post( $post );

		$card_design       = ( trim( get_option( 'st-data322' ) ) === 'yes' );    // 投稿記事下の関連記事一覧をカードデザインにする;
		$disable_thumbnail = ( trim( get_option( 'st-data5', '' ) ) === 'yes' );    // 一覧のサムネイルを表示しない

		$related_posts_query = st_get_kanren_posts_query( $post, $query_args );

		$default_vars = [
			'_post' => $post,
			'query' => $related_posts_query,
		];

		$template_vars = array_merge( $default_vars, $template_vars );

		ob_start();

		if ( $card_design && ! amp_is_amp() ) {    // カードデザイン
			st_get_template_part( 'kanren-card-list', null, $template_vars );
		} elseif ( $disable_thumbnail ) {    // サムネイルなし
			st_get_template_part( 'kanren-thumbnail-off', null, $template_vars );
		} else {    // サムネイルあり
			st_get_template_part( 'kanren-thumbnail-on', null, $template_vars );
		}

		return (string) ob_get_clean();
	}
}

if ( ! function_exists( 'st_the_kanren_posts' ) ) {
	function st_the_kanren_posts( $post = null, $query_args = array(), $template_vars = array() ) {
		echo st_get_the_kanren_posts( $post, $query_args, $template_vars );
	}
}

if ( ! function_exists( '_st_load_more_get_kanren_posts_options' ) ) {
	function _st_load_more_get_kanren_posts_options( $post, WP_Query $query ) {
		$post  = get_post( $post );
		$paged = max( 1, absint( $query->get( 'paged', '1' ) ) );
		$paged = min( $paged + 1, $query->max_num_pages );

		$options = array(
			'action'  => 'st_load_more_get_kanren_posts',
			'payload' => array(
				'post_id' => $post->ID,
				'page'    => $paged,
			),
		);

		return $options;
	}
}

if ( ! function_exists( '_st_load_more_get_kanren_posts' ) ) {
	function _st_load_more_get_kanren_posts() {
		if ( ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) || strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) !== 'xmlhttprequest' ) {
			wp_die( - 1, 403 );
		}

		if ( ! wp_doing_ajax() ) {
			wp_die( - 1, 403 );
		}

		$data = array();

		try {
			$action  = (string) filter_input( INPUT_GET, 'action' );
			$payload = filter_input( INPUT_GET, 'payload', FILTER_DEFAULT, FILTER_FORCE_ARRAY ) ?: array();

			$payload = filter_var_array(
				$payload,
				array(
					'post_id' => FILTER_DEFAULT,
					'page'    => FILTER_DEFAULT,
				)
			);

			$args = array( 'paged' => (int) $payload['page'] );

			if ( is_user_logged_in() ) {
				$args['post_status'] = array( 'publish', 'private' );
			} else {
				$args['post_status'] = array( 'publish' );
			}

			$query     = st_get_kanren_posts_query( $payload['post_id'], $args );
			$next_page = (int) $payload['page'] + 1;
			$has_next  = _st_query_has_next_page( $query );

			$data = array(
				'has_next' => $has_next,
				'html'     => st_get_the_kanren_posts(
					$payload['post_id'],
					$args
				),
				'options'  => array(),
			);

			if ( $has_next ) {
				$data['options'] = array(
					'action'  => $action,
					'payload' => array(
						'post_id' => $payload['post_id'],
						'page'    => $next_page,
					),
				);
			}
		} catch ( Exception $e ) {
			wp_send_json_error( 'error', 500 );
		}

		wp_send_json_success( $data, 200 );
	}
}

if ( trim( get_option( 'st-data36', '' ) ) !== 'yes' && trim( get_option( 'st-data421', '' ) ) === 'yes' ) {
	add_action( 'wp_ajax_st_load_more_get_kanren_posts', '_st_load_more_get_kanren_posts' );
	add_action( 'wp_ajax_nopriv_st_load_more_get_kanren_posts', '_st_load_more_get_kanren_posts' );
}

if ( ! function_exists( 'st_add_title_header_side_menu' ) ) {
	function st_add_title_header_side_menu($item_output, $item, $depth, $args){
		if ( $args->theme_location === 'primary-menu-side' ) {
			return preg_replace('/(<a.*?>[^<]*?)</', '$1' . "<span>{$item->attr_title}</span><", $item_output);
		}

		return $item_output;
	}
}
add_filter('walker_nav_menu_start_el', 'st_add_title_header_side_menu', 10, 4);

if ( ! function_exists( 'st_gutenberg_list' ) ) {
	function st_gutenberg_list( $allowed_block_types ) {
		$allowed_block_types = array(
			'core/paragraph',           // 段落
			'core/heading',             // 見出し
			'core/image',               // 画像
			'core/freeform',            // クラシック
			'core/html',                // カスタムHTML
			'core/block',               // 再利用ブロック
			'st-blocks/flexbox',        // STINGER: バナー風ボックス
			'st-blocks/memo',           // STINGER: メモ
			'st-blocks/midashi-box',    // STINGER: 見出し付きフリーボックス
			'st-blocks/my-box',         // STINGER: マイボックス
			'st-blocks/my-button',      // STINGER: カスタムボタン
			'st-blocks/st-kaiwa',       // STINGER: 会話ふきだし
			'tadv/classic-paragraph'    // TinyMCE Advanced: Classic Paragraph
		);
		
		$settings = array(
			'st-data453' => 'core/quote',       // 引用
			'st-data454' => 'core/list',        // リスト
			'st-data455' => 'core/code',        // ソースコード
			'st-data456' => 'core/columns',     // カラム
			'st-data457' => 'core/button',      // ボタン
			'st-data458' => 'core/shortcode',   // ショートコード
			'st-data459' => 'core/cover',       // カバー
		);

		foreach ( $settings as $option_key => $block_name ) {
			if ( trim( get_option( $option_key, '' ) ) !== '' ) {
				$allowed_block_types[] = $block_name;
			}
		}

		return $allowed_block_types;
	}

	if ( trim( $GLOBALS['stdata452'] ) !== '' ) {
		add_filter( 'allowed_block_types', 'st_gutenberg_list' );
	}
}

$stplus = '';
if (locate_template('/st-plus.php') !== '') {
require_once locate_template('/st-plus.php');
}
