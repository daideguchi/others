<?php
/**
 * Fixed Bottom Menu
 *
 * @package    Fixed Bottom Menu
 * @subpackage Fixed Bottom Menu Main function
/*
	Copyright (c) 2019- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

$fixedbottommenu = new FixedBottomMenu();

/** ==================================================
 * Main Functions
 */
class FixedBottomMenu {

	/** ==================================================
	 * Settings
	 *
	 * @var $fixedbottommenu_settings  fixedbottommenu_settings.
	 */
	private $fixedbottommenu_settings;

	/** ==================================================
	 * Columun
	 *
	 * @var $column  column.
	 */
	private $column;

	/** ==================================================
	 * Construct
	 *
	 * @since 1.00
	 */
	public function __construct() {

		$this->fixedbottommenu_settings = get_option( 'fixedbottommenu_settings' );
		$this->column = get_option( 'fixedbottommenu_settings_col', 5 );

		add_action( 'wp_enqueue_scripts', array( $this, 'load_icons' ) );
		if ( get_option( 'fixedbottommenu_settings_old' ) ) {
			add_action( 'wp_footer', array( $this, 'load_localize_styles_old' ) );
			add_action( 'wp_footer', array( $this, 'bottom_menu_old' ) );
		} else {
			add_action( 'wp_footer', array( $this, 'load_localize_styles' ) );
			add_action( 'wp_footer', array( $this, 'bottom_menu' ) );
		}

		add_action( 'wp_head', array( $this, 'safe_area' ) );

	}

	/** ==================================================
	 * Menu
	 *
	 * @since 1.02
	 */
	public function bottom_menu() {

		$icon_type = $this->icon_filters();

		$this->column = apply_filters( 'fbm_column', $this->column );

		?>
		<div id="fixed-bottom-menu">
			<div class="fixed-bottom-menu-container">
				<?php
				for ( $i = 1; $i <= $this->column; $i++ ) {
					$column_value = $this->colmun_filters( $i, $icon_type );
					?>
					<div class="fixed-bottom-menu-item">
						<a href="<?php echo esc_url( $column_value['url'] ); ?>">
						<?php
						if ( 'dash' === $column_value['icon_type'] ) {
							?>
							<span class="dashicons dashicons-<?php echo esc_attr( $column_value['icon'] ); ?>"></span>
							<?php
						} else {
							do_action( 'fbm_icon_view', $column_value['icon'], $column_value['icon_type'] );
						}
						?>
						<br>
						<span class="fixed-bottom-menu-text"><?php echo esc_html( $column_value['text'] ); ?></span>
						</a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php

	}

	/** ==================================================
	 * Load Localize Style
	 *
	 * @since 1.02
	 */
	public function load_localize_styles() {

		wp_enqueue_style( 'fixed-bottom-menu', plugin_dir_url( __DIR__ ) . 'css/fixedbottommenu.css', array(), '1.00' );

		list( $fontsize, $backcolor, $color, $overcolor, $minwidth, $zindex, $height, $height_a, $padding_top_a, $footer_class ) = $this->option_filters();

		$this->column = apply_filters( 'fbm_column', $this->column );

		$css = '#fixed-bottom-menu{ line-height: ' . $height . 'rem; z-index: ' . $zindex . '; }';
		$css .= '.fixed-bottom-menu-text{ font-size:' . $fontsize . 'px; }';
		$css .= '.fixed-bottom-menu-container { background-color: ' . $backcolor . '; }';
		$css .= '.fixed-bottom-menu-item { -webkit-flex-basis: ' . 100 / $this->column . '%; -ms-flex-preferred-size: ' . 100 / $this->column . '%; flex-basis: ' . 100 / $this->column . '%; }';
		$css .= '.fixed-bottom-menu-item a { color: ' . $color . '; padding-top: ' . $padding_top_a . 'rem; line-height: ' . $height_a . 'rem; }';
		$css .= '.fixed-bottom-menu-item a:hover { color: ' . $overcolor . '; }';
		$css .= '@media( min-width: ' . $minwidth . 'px ) { #fixed-bottom-menu{ display: none; } }';
		if ( ! empty( $footer_class ) ) {
			$css .= '.' . $footer_class . '{margin-bottom: ' . $height . 'rem;}';
		}

		$hide = false;
		$hide = apply_filters( 'fbm_hide', $hide );
		if ( $hide ) {
			$css .= '#fixed-bottom-menu{ display: none !important; }';
		}

		wp_add_inline_style( 'fixed-bottom-menu', $css );

	}

	/** ==================================================
	 * Menu old
	 *
	 * @since 1.00
	 */
	public function bottom_menu_old() {

		$icon_type = $this->icon_filters();

		$this->column = apply_filters( 'fbm_column', $this->column );

		?>
		<ul class="fixed-bottom-menu">
			<?php
			for ( $i = 1; $i <= $this->column; $i++ ) {
				$column_value = $this->colmun_filters( $i, $icon_type );
				?>
				<li>
					<a href="<?php echo esc_url( $column_value['url'] ); ?>">
					<?php
					if ( 'dash' === $column_value['icon_type'] ) {
						?>
						<span class="dashicons dashicons-<?php echo esc_attr( $column_value['icon'] ); ?>"></span>
						<?php
					} else {
						do_action( 'fbm_icon_view', $column_value['icon'], $column_value['icon_type'] );
					}
					?>
					<br>
					<span class="fixed-bottom-menu-text"><?php echo esc_html( $column_value['text'] ); ?></span>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<?php

	}

	/** ==================================================
	 * Load Localize Style old
	 *
	 * @since 1.00
	 */
	public function load_localize_styles_old() {

		wp_enqueue_style( 'fixed-bottom-menu', plugin_dir_url( __DIR__ ) . 'css/fixedbottommenu_old.css', array(), '1.00' );

		list( $fontsize, $backcolor, $color, $overcolor, $minwidth, $zindex, $height, $height_a, $padding_top_a, $footer_class ) = $this->option_filters();

		$this->column = apply_filters( 'fbm_column', $this->column );

		$css = '.fixed-bottom-menu-text{ font-size:' . $fontsize . 'px; }';
		$css .= 'ul.fixed-bottom-menu { background-color: ' . $backcolor . '; height: ' . $height . 'px; z-index: ' . $zindex . '; }';
		$css .= 'ul.fixed-bottom-menu li { width: ' . 100 / $this->column . '%; }';
		$css .= '.fixed-bottom-menu li a { color: ' . $color . '; padding-top: ' . $padding_top_a . 'px; line-height: ' . $height_a . 'px; }';
		$css .= '.fixed-bottom-menu li a:hover { color: ' . $overcolor . '; }';
		$css .= '@media( min-width: ' . $minwidth . 'px ) { .fixed-bottom-menu{ display: none; } }';
		if ( ! empty( $footer_class ) ) {
			$css .= '.' . $footer_class . '{margin-bottom: ' . $height . 'px;}';
		}

		$hide = false;
		$hide = apply_filters( 'fbm_hide', $hide );
		if ( $hide ) {
			$css .= '.fixed-bottom-menu{ display: none !important; }';
		}

		wp_add_inline_style( 'fixed-bottom-menu', $css );

	}

	/** ==================================================
	 * Column filters
	 *
	 * @since 1.24
	 */
	private function icon_filters() {

		$icon_type = 'dash';
		if ( function_exists( 'fixed_bottom_menu_add_on_icon_load_textdomain' ) ) {
			if ( get_option( 'fixedbottommenu_add_on_icon_settings' ) ) {
				$addonicon = get_option( 'fixedbottommenu_add_on_icon_settings' );
				$icon_type = $addonicon['type'];
			}
		}

		$icon_type = apply_filters( 'fbm_icon_type', $icon_type );

		return $icon_type;

	}

	/** ==================================================
	 * Column filters
	 *
	 * @param int    $i  column count.
	 * @param string $icon_type  icon_type.
	 * @since 1.19
	 */
	private function colmun_filters( $i, $icon_type ) {

		$column_value = array();
		$column_value['url'] = $this->fixedbottommenu_settings[ 'url' . $i ];

		$icon_type = apply_filters( 'fbm_column_icon_type_' . $i, $icon_type );
		$column_value['icon_type'] = $icon_type;

		$column_value['icon'] = $this->fixedbottommenu_settings[ 'dash' . $i ];
		if ( 'dash' <> $icon_type ) {
			if ( function_exists( 'fixed_bottom_menu_add_on_icon_load_textdomain' ) ) {
				if ( get_option( 'fixedbottommenu_add_on_icon_settings' ) ) {
					$addonicon = get_option( 'fixedbottommenu_add_on_icon_settings' );
					$column_value['icon'] = $addonicon[ $icon_type ][ 'icon' . $i ];
				}
			}
		}
		$column_value['text'] = $this->fixedbottommenu_settings[ 'text' . $i ];

		$column_value = apply_filters( 'fbm_column_value_' . $i, $column_value );

		return $column_value;

	}

	/** ==================================================
	 * Option filters
	 *
	 * @since 1.17
	 */
	private function option_filters() {

		$fontsize  = $this->fixedbottommenu_settings['font_size'];
		$fontsize  = apply_filters( 'fbm_fontsize', $fontsize );
		$backcolor = $this->fixedbottommenu_settings['back_color'];
		$backcolor = apply_filters( 'fbm_backcolor', $backcolor );
		$color     = $this->fixedbottommenu_settings['color'];
		$color     = apply_filters( 'fbm_color', $color );
		$overcolor = $this->fixedbottommenu_settings['over_color'];
		$overcolor = apply_filters( 'fbm_overcolor', $overcolor );
		$minwidth  = $this->fixedbottommenu_settings['min_width'];
		$minwidth  = apply_filters( 'fbm_minwidth', $minwidth );
		$zindex    = $this->fixedbottommenu_settings['zindex'];
		$zindex    = apply_filters( 'fbm_zindex', $zindex );
		if ( ! get_option( 'fixedbottommenu_settings_old' ) ) {
			$height        = $this->fixedbottommenu_settings['line_height'];
			$height_a      = $this->fixedbottommenu_settings['line_height_a'];
			$padding_top_a = $this->fixedbottommenu_settings['padding_top_a'];
		} else {
			$height        = $this->fixedbottommenu_settings['line_height_old'];
			$height_a      = $this->fixedbottommenu_settings['line_height_a_old'];
			$padding_top_a = $this->fixedbottommenu_settings['padding_top_a_old'];
		}
		$height        = apply_filters( 'fbm_height', $height );
		$height_a      = apply_filters( 'fbm_height_a', $height_a );
		$padding_top_a = apply_filters( 'fbm_padding_top_a', $padding_top_a );
		$footer_class  = $this->fixedbottommenu_settings['footer_class'];
		$footer_class  = apply_filters( 'fbm_footer_class', $footer_class );

		return array( $fontsize, $backcolor, $color, $overcolor, $minwidth, $zindex, $height, $height_a, $padding_top_a, $footer_class );

	}

	/** ==================================================
	 * Icon style
	 *
	 * @since 1.00
	 */
	public function load_icons() {

		wp_enqueue_style( 'dashicons' );
		do_action( 'fbm_icon_enqueue_style' );

	}

	/** ==================================================
	 * Meta tag for Viewport
	 *
	 * @since 1.16
	 */
	public function safe_area() {

		$insert = '<meta name="viewport" content="initial-scale=1, viewport-fit=cover">' . "\n";
		$allowed_insert_html = array(
			'meta'  => array(
				'name' => array(),
				'content' => array(
					'initial-scale' => array(),
					'viewport-fit'  => array(),
				),
			),
		);
		echo wp_kses( $insert, $allowed_insert_html );

	}

}


