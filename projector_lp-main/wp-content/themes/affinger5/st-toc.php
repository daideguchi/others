<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'st_toc_do_shortcode' ) ) {
	function st_toc_do_shortcode( $content ) {
		global $shortcode_tags;

		if ( empty( $shortcode_tags ) || ! is_array( $shortcode_tags ) ) {
			return $content;
		}

		$tagnames     = array( 'toc', 'no_toc' );
		$tag_is_found = false;

		foreach ( $tagnames as $tagname ) {
			if ( strpos( $content, '[' . $tagname . ']' ) !== false ) {
				$tag_is_found = true;
			}
		}

		if ( ! $tag_is_found ) {
			return $content;
		}

		$content = do_shortcodes_in_html_tags( $content, false, $tagnames );

		$pattern = get_shortcode_regex( $tagnames );
		$content = preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $content );

		return $content;
	}
}

if ( ! function_exists( 'st_toc_the_content' ) ) {
	function st_toc_the_content( $content ) {
		$tic = $GLOBALS['tic'];

		$content = st_toc_do_shortcode( $content );
		$content = $tic->the_content( $content );

		return $content;
	}
}

if ( ! function_exists( 'st_toc_init' ) ) {
	function st_toc_init() {

		$tic = $GLOBALS['tic'];

		remove_filter( 'the_content', array( $tic, 'the_content' ), 100 );
		add_filter( 'the_content', 'st_toc_the_content', 10 );
	}
}

if ( isset( $GLOBALS['tic'] ) && class_exists( 'toc' ) ) {
	add_action( 'init', 'st_toc_init' );
}

if ( ! function_exists( 'st_toc_is_enabled' ) ) {

	function st_is_st_toc_enabled() {
		return isset( $GLOBALS['st_toc'] );
	}
}

if ( ! function_exists( 'st_toc_wrapper_html' ) ) {

	function st_toc_wrapper_html( $html, $settings ) {

		if ( get_theme_mod( 'st_toc_paper_style' ) ) {
			return <<<HTML
<div class="mokuzi-paper">
	<div class="kasane-paper page3">
		<div class="kasane-paper page2">
			<div class="kasane-paper page1">
				<div class="kasane-paper page">
					<div class="kasane-paper nakami" data-st-toc-wrapper></div>
				</div>
			</div>
		</div>
	</div>
</div>
HTML;
		}

		return $html;
	}
}

add_filter( 'st_toc_wrapper_html', 'st_toc_wrapper_html', 10, 2 );

if ( ! function_exists( 'st_toc_should_show_toc_for_front_page' ) ) {

	function st_toc_should_show_toc_for_front_page() {
		$post = get_post( (int) get_option( 'st-data9', '' ) );

		if ( ! $post ) {
			return false;
		}

		if ( ! function_exists( 'st_toc_has_toc_shortcode' ) ) {
			return true;
		}

		$post_content = get_the_content( $post );

		return st_toc_has_toc_shortcode( $post_content );
	}
}

if ( ! function_exists( 'st_toc_overrides_condition' ) ) {

	function st_toc_overrides_condition( $overrides = false ) {

		if ( is_front_page() || is_home() || is_category() ) {
			return true;
		}

		return $overrides;
	}
}

add_filter( 'st_toc_overrides_condition', 'st_toc_overrides_condition' );

if ( ! function_exists( 'st_toc_overridden_result' ) ) {

	function st_toc_overridden_result( $result = null ) {


		$new_result            = false;
		$show_on_front         = ( get_option( 'show_on_front' ) === 'page' );

		$page_id_on_front     = (int) get_option( 'page_on_front' );
		$is_page_on_front_set = ( $show_on_front && $page_id_on_front > 0 );
		$page_on_front        = get_post( $page_id_on_front );

		$page_id_for_posts     = (int) get_option( 'page_for_posts' );
		$is_page_for_posts_set = ( $show_on_front && $page_id_for_posts > 0 );
		$page_for_posts        = get_post( $page_id_for_posts );

		$theme_front_page_id     = (int) get_option( 'st-data9', '' );
		$is_theme_front_page_set = ( $theme_front_page_id > 0 );
		$theme_front_page        = get_post( $theme_front_page_id );

		$front_content        = trim( get_option( 'st-data89', '' ) );
		$is_front_content_set = ( $front_content !== '' );

		$function_exists = function_exists( 'st_toc_has_toc_shortcode' );

		switch ( true ) {

			case ( is_front_page() && $show_on_front && $is_page_on_front_set ):
				$new_result = $function_exists && st_toc_has_toc_shortcode( $page_on_front->post_content ) ? $page_on_front : false;

				break;

			case is_home():
				if ( $is_theme_front_page_set ) {

					$new_result = $function_exists && st_toc_has_toc_shortcode( $theme_front_page->post_content ) ? $theme_front_page : false;

					if ( $new_result === false && $is_front_content_set ) {

						$new_result = $function_exists && st_toc_has_toc_shortcode( $front_content ) ? $theme_front_page : false;
					}
				} elseif ( $is_front_content_set ) {

					$new_result = $function_exists && st_toc_has_toc_shortcode( $front_content ) ? null : false;
				} elseif ( $is_page_for_posts_set && ! is_paged() ) {

				}

				break;

			case is_category():
				$category_id = get_queried_object_id();
				$description = get_term_field( 'description', $category_id );

				$new_result = $function_exists && st_toc_has_toc_shortcode( $description ) ? null : false;

				break;

			default:
				break;
		}

		return $new_result;
	}
}

add_filter( 'st_toc_overridden_result', 'st_toc_overridden_result' );

if ( ! function_exists( 'st_toc_get_exposed_settings' ) ) {

	function st_toc_get_exposed_settings( $settings, $post ) {

		$content_selectors = explode( ',', $settings['content_selector'] );

		if ( is_home() ) {
			$theme_front_page_id     = (int) get_option( 'st-data9', '' );
			$is_theme_front_page_set = ( $theme_front_page_id > 0 );
			$theme_front_page        = get_post( $theme_front_page_id );

			$front_content        = trim( get_option( 'st-data89', '' ) );
			$is_front_content_set = ( $front_content !== '' );

			$function_exists = function_exists( 'st_toc_has_toc_shortcode' );

			if ( $is_theme_front_page_set && $function_exists && st_toc_has_toc_shortcode( $theme_front_page->post_content ) ) {
				$content_selectors[] = 'body.blog .home-post .st-topin';
			}

			if ( $is_front_content_set && $function_exists && st_toc_has_toc_shortcode( $front_content ) ) {
				$content_selectors[] = 'body.blog .home-post .st-topcontent';
			}
		} elseif ( is_category() ) {
			$content_selectors[] = 'body.category main > article > .post .entry-content';
		}

		$content_selectors            = array_unique( $content_selectors );
		$settings['content_selector'] = implode( ', ', $content_selectors );

		$rejected_selectors = $settings['rejected_selectors'];

		foreach ( $rejected_selectors as $level => $selectors ) {
			$_rejected_selectors = $rejected_selectors[ $level ];

			$_rejected_selectors[] = '.kanren h5.kanren-t';
			$_rejected_selectors[] = '.kanren h3';
			$_rejected_selectors[] = '.pop-box h5';


			$rejected_selectors[ $level ] = array_unique( $_rejected_selectors );
		}

		$settings['rejected_selectors'] = $rejected_selectors;

		return $settings;
	}
}

add_filter( 'st_toc_exposed_settings', 'st_toc_get_exposed_settings', 10, 2 );

if ( ! function_exists( 'st_toc_get_ignored_selector_before_heading' ) ) {
	function st_toc_get_ignored_selector_before_heading( $selector ) {
		$selectors = explode( ',', $selector );

		$selectors[] = '.st-h-ad';

		return implode( ',', array_filter( $selectors ) );
	}
}

add_filter( 'st_toc_ignored_selector_before_heading', 'st_toc_get_ignored_selector_before_heading' );

if ( ! function_exists( 'st_toc_back_class' ) ) {
	function st_toc_back_class( $classes ) {
		if ( get_theme_mod( 'st_pagetop_up' ) ) {
			$classes[] = 'is-top';
		}

		if ( get_theme_mod( 'st_pagetop_circle' ) ) {
			$classes[] = 'is-rounded';
		}

		return $classes;
	}
}

add_filter( 'st_toc_back_class', 'st_toc_back_class' );
