<?php
if ( ! function_exists( '_st_plugin_support_get_container' ) ) {
	function _st_plugin_support_get_container( $id ) {
		return isset( $GLOBALS[ $id ] ) ? $GLOBALS[ $id ] : null;
	}
}

if ( ! function_exists( '_st_plugin_support_get' ) ) {
	function _st_plugin_support_get( $constant, $id ) {
		if ( ! defined( $constant ) ) {
			return null;
		}

		$container_id = constant( $constant );
		$container    = _st_plugin_support_get_container( $container_id );

		if ( $container === null || ! isset( $container[ $id ] ) ) {
			return null;
		}

		return $container[ $id ];
	}
}

if ( ! function_exists( '_st_plugin_support_is_enabled' ) ) {
	function _st_plugin_support_is_enabled( $constant, $value = null) {
		if ( ! defined( $constant ) ) {
			return false;
		}

		$id        = constant( $constant );
		$container = _st_plugin_support_get_container( $id );

		if ( $container === null || ! isset( $container['plugin_meta'] ) ) {
			return false;
		}

		if ( $value !== null ) {
			$plugin_meta = $container['plugin_meta'];

			return ( $plugin_meta->get_slug() === $value );
		}

		return true;
	}
}

if ( ! function_exists( '_st_plugin_support_version_compare' ) ) {
	function _st_plugin_support_version_compare( $constant, $version, $operator = null ) {
		if ( ! defined( $constant ) ) {
			return false;
		}

		$version_1 = strtolower( constant( $constant ) );
		$version_2 = strtolower( $version );

		return version_compare( $version_1, $version_2, $operator );
	}
}

add_action(
	'after_setup_theme',
	function () {
		if ( _st_plugin_support_is_enabled( 'ST_TEMPLATE_MANAGER' ) &&
		     _st_plugin_support_is_enabled( 'ST_REPLACE_META_BOX' ) &&
		     _st_plugin_support_version_compare( 'ST_REPLACE_META_BOX_API_VERSION', '1.1.0', '==' ) ) {
			$post_types = _st_plugin_support_get( 'ST_TEMPLATE_MANAGER', 'post_types');

			if (defined('ST_REPLACE_META_BOX_API_PREFIX') && isset($post_types['template'])) {
				$post_type = $post_types['template']->get_meta()->get_name();

				add_filter(
					ST_REPLACE_META_BOX_API_PREFIX . '_post_types',
					function ( array $post_types = array() ) use ( $post_type ) {
						$post_types[] = $post_type;

						return $post_types;
					}
				);
			}
		}

		if ( _st_plugin_support_is_enabled( 'ST_CARD_EX', 'st-card-ex' ) &&
		     _st_plugin_support_version_compare( 'ST_CARD_EX_API_VERSION', '1.1.0', '==' ) &&
		     function_exists( 'St\Plugin\CardEx\boot' ) ) {
			St\Plugin\CardEx\boot();
		}

		if ( _st_plugin_support_is_enabled( 'ST_LAZY_LOAD', 'st-lazy-load' ) &&
		     _st_plugin_support_version_compare( 'ST_LAZY_LOAD_API_VERSION', '1.1.0', '>=' ) &&
		     function_exists( 'St\Plugin\Lazy_Load\run' ) ) {
			St\Plugin\Lazy_Load\run();
		}

		if ( _st_plugin_support_is_enabled( 'ST_TEMPLATE_MANAGER', 'st-template-manager' ) &&
		     function_exists( 'St\Plugin\Template_Manager\run' ) ) {
			St\Plugin\Template_Manager\run();
		}

		if ( _st_plugin_support_is_enabled( 'ST_EXPORT_META_BOX', 'st-export-meta-box' ) &&
		     function_exists( 'St\Plugin\Export_Meta_Box\boot' ) ) {
			St\Plugin\Export_Meta_Box\boot();
		}

		if ( _st_plugin_support_is_enabled( 'ST_REPLACE_META_BOX', 'st-replace-meta-box' ) ) {
			if ( isset( $GLOBALS[ ST_REPLACE_META_BOX ]['plugin'] ) ) {
				$GLOBALS[ ST_REPLACE_META_BOX ]['plugin']->boot();
			}
		}

		if ( _st_plugin_support_is_enabled( 'ST_CUSTOM_SEARCH', 'st-custom-search' ) &&
		     function_exists( 'St\Plugin\Custom_Search\run' ) ) {
			St\Plugin\Custom_Search\run();
		}

		if ( _st_plugin_support_is_enabled( 'ST_MULTI_INSTALLER', 'st-multi-installer' ) &&
		     function_exists( 'St\Plugin\Multi_Installer\run' ) ) {
			St\Plugin\Multi_Installer\run();
		}

		if ( _st_plugin_support_is_enabled( 'ST_BLOCKS', 'st-blocks' ) &&
		     function_exists( 'St\Plugin\Blocks\run' ) ) {
			St\Plugin\Blocks\run();

			if ( defined( 'ST_KAIWA' ) && defined( 'ST_KAIWA_API_SLUG' ) ) {
				add_filter(
					'st_block_editor_style_dependencies',
					function ( array $deps ) {
						$deps[] = ST_KAIWA_API_SLUG . '-block-editor-style';

						return $deps;
					}
				);
			}
		}
	}
);

if ( get_theme_mod( 'st_sticky_menu', '' ) === 'fixed' ) {
	add_filter(
		'st_toc_fixed_element_selector',
		function ( $selector ) {
			return '#s-navi dl.acordion';
		}
	);
}

add_filter(
	'st_export_meta_box_download_filename',
	function ( $filename ) {

		return '%datetime_Y%_%datetime_m%%datetime_d%_%datetime_H%_%datetime_i%_%post_title%_%site_name%.txt';
	}
);

add_action(
	'st_template_manager_wp_head',
	function () {
		get_template_part( 'st-richjs' );

		$width = (int) get_option('stdata-128', '1060') - 320;

		echo <<<HTML
<style>
.st-template-manager-preview-view {
	box-sizing: border-box;
	display: block;
	margin: auto;
	padding: 20px 15px;
}

@media only screen and (min-width: 600px) {
	.st-template-manager-preview-view {
		padding: 20px 30px;
	}
}

@media only screen and (min-width: 960px) {
	.st-template-manager-preview-view {
		padding: 30px 50px;
		max-width: {$width}px;
	}
}
</style>
HTML;
	}
);

add_filter('st_cs_enqueue_shortcode_styles', '__return_false');

/** Gutenberg 用ブロックプラグイン */
add_filter(
	'st_blocks_st_kaiwa_shortcode_data_1',
	function ( array $data ) {
		$get_option_value = function ( $option_name ) {
			$value = trim( (string) get_option( $option_name, '' ) );

			return ( $value !== '' ) ? $value : null;
		};

		return [
			'st-kaiwa1' => [
				'tagName'      => 'st-kaiwa1',
				'label'        => '会話風アイコン 1',
				'classes'      => [ 'kaiwaicon1' ],
				'iconName'     => $get_option_value( 'st-data134' ),
				'iconImageUrl' => $get_option_value( 'st-data131' ),
			],
			'st-kaiwa2' => [
				'tagName'      => 'st-kaiwa2',
				'label'        => '会話風アイコン 2',
				'classes'      => [ 'kaiwaicon2' ],
				'iconName'     => $get_option_value( 'st-data135' ),
				'iconImageUrl' => $get_option_value( 'st-data132' ),
			],
			'st-kaiwa3' => [
				'tagName'      => 'st-kaiwa3',
				'label'        => '会話風アイコン 3',
				'classes'      => [ 'kaiwaicon3' ],
				'iconName'     => $get_option_value( 'st-data136' ),
				'iconImageUrl' => $get_option_value( 'st-data133' ),
			],
			'st-kaiwa4' => [
				'tagName'      => 'st-kaiwa4',
				'label'        => '会話風アイコン 4',
				'classes'      => [ 'kaiwaicon4' ],
				'iconName'     => $get_option_value( 'st-data145' ),
				'iconImageUrl' => $get_option_value( 'st-data144' ),
			],
			'st-kaiwa5' => [
				'tagName'      => 'st-kaiwa5',
				'label'        => '会話風アイコン 5',
				'classes'      => [ 'kaiwaicon5' ],
				'iconName'     => $get_option_value( 'st-data147' ),
				'iconImageUrl' => $get_option_value( 'st-data146' ),
			],
			'st-kaiwa6' => [
				'tagName'      => 'st-kaiwa6',
				'label'        => '会話風アイコン 6',
				'classes'      => [ 'kaiwaicon6' ],
				'iconName'     => $get_option_value( 'st-data149' ),
				'iconImageUrl' => $get_option_value( 'st-data148' ),
			],
			'st-kaiwa7' => [
				'tagName'      => 'st-kaiwa7',
				'label'        => '会話風アイコン 7',
				'classes'      => [ 'kaiwaicon7' ],
				'iconName'     => $get_option_value( 'st-data151' ),
				'iconImageUrl' => $get_option_value( 'st-data150' ),
			],
			'st-kaiwa8' => [
				'tagName'      => 'st-kaiwa8',
				'label'        => '会話風アイコン 8',
				'classes'      => [ 'kaiwaicon8' ],
				'iconName'     => $get_option_value( 'st-data153' ),
				'iconImageUrl' => $get_option_value( 'st-data152' ),
			],
		];
	}
);
