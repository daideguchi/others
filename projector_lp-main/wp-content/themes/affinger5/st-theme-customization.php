<?php
if ( isset( $GLOBALS['stdata261']) && $GLOBALS['stdata261'] === 'biz' ){ //ビジネス
	if ( locate_template( 'st-theme-get-preset-theme-mod-overrides_biz.php' ) !== '' ) {
		require_once locate_template( 'st-theme-get-preset-theme-mod-overrides_biz.php' );
	}
}elseif ( isset( $GLOBALS['stdata261']) && $GLOBALS['stdata261'] === 'flat' ){ // フラット
 	if ( locate_template( 'st-theme-get-preset-theme-mod-overrides_flat.php' ) !== '' ) {
		require_once locate_template( 'st-theme-get-preset-theme-mod-overrides_flat.php' );
	}
}elseif ( isset( $GLOBALS['stdata261']) && $GLOBALS['stdata261'] === 'cute' ){ // キュート
 	if ( locate_template( 'st-theme-get-preset-theme-mod-overrides_cute.php' ) !== '' ) {
		require_once locate_template( 'st-theme-get-preset-theme-mod-overrides_cute.php' );
	}
}elseif ( isset( $GLOBALS['stdata261']) && $GLOBALS['stdata261'] === 'blog' ){ // ブログ
 	if ( locate_template( 'st-theme-get-preset-theme-mod-overrides_blog.php' ) !== '' ) {
		require_once locate_template( 'st-theme-get-preset-theme-mod-overrides_blog.php' );
	}
}elseif ( isset( $GLOBALS['stdata261']) && $GLOBALS['stdata261'] === 'reset' ){ // リセット
 	if ( locate_template( 'st-theme-get-preset-theme-mod-overrides_reset.php' ) !== '' ) {
		require_once locate_template( 'st-theme-get-preset-theme-mod-overrides_reset.php' );
	}
}else{ // デフォルト（横グラデーション）
 	if ( locate_template( 'st-theme-get-preset-theme-mod-overrides.php' ) !== '' ) {
		require_once locate_template( 'st-theme-get-preset-theme-mod-overrides.php' );
	}
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'St_Customize_Button_Control' ) ) {
	class St_Customize_Button_Control extends WP_Customize_Control {
		public $type         = 'button';

		public $button_label = 'ボタン';

		public $class        = 'button-primary button';

		public function render_content() {
			?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>

				<button id="<?php echo esc_attr( $this->id ); ?>" type="button" name="<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $this->class ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->input_attrs(); ?>>
					<?php echo esc_html( $this->button_label ); ?>
				</button>
			</label>
			<?php
		}

		public function enqueue() {
			wp_enqueue_script(
				'st-customizer-reset',
				get_template_directory_uri() . '/js/customizer-reset.js',
				array( 'jquery' ),
				false,
				true
			);

			wp_localize_script(
				'st-customizer-reset',
				'ST_CUSTOMIZER_RESET',
				array(
					'nonce' => wp_create_nonce( 'st_customizer_reset' ),
				)
			);
		}
	}
}

if ( !function_exists( 'st_is_customizer_enabled' ) ) {
	function st_is_customizer_enabled() {
		return true;
	}
}

if ( !function_exists( 'st_get_preset_name' ) ) {
	function st_get_preset_name() {
		return get_option( 'st-data68', '' );
	}
}

if ( !function_exists( 'st_should_output_style_element' ) ) {
	function st_should_output_style_element() {
		return ( get_option( 'st-data90', '' ) === 'yes' );
	}
}

if ( !function_exists( 'st_get_kantan_setting' ) ) {
	function st_get_kantan_setting() {
		return get_theme_mod( 'st_theme_setting', '' );
	}
}

if ( !function_exists( 'st_get_entrytitle_designsetting' ) ) {
	function st_get_entrytitle_designsetting() {
		return get_theme_mod( 'st_entrytitle_designsetting', '' );
	}
}

if ( !function_exists( 'st_get_h2_designsetting' ) ) {
	function st_get_h2_designsetting() {
		return get_theme_mod( 'st_h2_designsetting', 'centerlinedesign' );
	}
}

if ( !function_exists( 'st_get_h3_designsetting' ) ) {
	function st_get_h3_designsetting() {
		return get_theme_mod( 'st_h3_designsetting', '' );
	}
}

if ( !function_exists( 'st_get_widgets_title_designsetting' ) ) {
	function st_get_widgets_title_designsetting() {
		return get_theme_mod( 'st_widgets_title_designsetting', '' );
	}
}

if ( !function_exists( 'st_get_previous_kantan_setting' ) ) {
	function st_get_previous_kantan_setting() {
		return get_theme_mod( '_st_current_theme_setting', st_get_kantan_setting() );
	}
}

if ( !function_exists( 'st_get_preset_colors' ) ) {
	function st_get_preset_colors( $preset_name = null ) {
		switch ( true ) {
			// 赤 (エレガント)
			case ( $preset_name === 'red' ):
				$basecolor   = '#a61919';  //一番濃い色
				$maincolor   = '#c81e1e';  //少し薄い色
				$subcolor    = '#fce9e9';  //とても薄い色
				$accentcolor = $basecolor; //アクセント
				$textcolor   = '#ffffff';     //テキスト

				break;

			// 青 (ビジネス)
			case ( $preset_name === 'blue' ):
				$basecolor   = '#039BE5';  //一番濃い色
				$maincolor   = '#13b0fc';  //少し薄い色
				$subcolor    = '#f4fbff';  //とても薄い色
				$accentcolor = $basecolor; //アクセント
				$textcolor   = '#ffffff';     //テキスト

				break;

			// 緑 (ナチュラル)
			case ( $preset_name === 'green' ):
				$basecolor   = '#7CB342';  //一番濃い色
				$maincolor   = '#8fc25a';  //少し薄い色
				$subcolor    = '#f0f7e9';  //とても薄い色
				$accentcolor = $basecolor; //アクセント
				$textcolor   = '#ffffff';     //テキスト

				break;

			// オレンジ (元気)
			case ( $preset_name === 'orange' ):
				$basecolor   = '#febe31';  //一番濃い色
				$maincolor   = '#fed271';  //少し薄い色
				$subcolor    = '#fffde7';  //とても薄い色
				$accentcolor = $basecolor; //アクセント
				$textcolor   = '#ffffff';     //テキスト

				break;

			// ピンク (可愛い)
			case ( $preset_name === 'pink' ):
				$basecolor   = '#ff6893';  //一番濃い色
				$maincolor   = '#ff9bb7';  //少し薄い色
				$subcolor    = '#fff1f5';  //とても薄い色
				$accentcolor = $basecolor; //アクセント
				$textcolor   = '#ffffff';     //テキスト

				break;

			// グレー (ダーク)
			case ( $preset_name === 'glay' ):
				$basecolor   = '#212121';  //一番濃い色
				$maincolor   = '#424242';  //少し薄い色
				$subcolor    = '#FAFAFA';  //とても薄い色
				$accentcolor = $basecolor; //アクセント
				$textcolor   = '#ffffff';     //テキスト

				break;
				
			// 赤 (やさしい)
			case ( $preset_name === 'red_y' ):
                $basecolor   = '#ef5350';  //一番濃い色
                $maincolor   = '#e57373';  //少し薄い色
                $subcolor    = '#ffebee';  //とても薄い色
                $accentcolor = $basecolor; //アクセント
                $textcolor   = '#ffffff';     //テキスト

				break;

			// 青 (やさしい)
			case ( $preset_name === 'blue_y' ):
                $basecolor   = '#29B6F6';  //一番濃い色
                $maincolor   = '#4FC3F7';  //少し薄い色
                $subcolor    = '#edf6fb';  //とても薄い色
                $accentcolor = $basecolor; //アクセント
                $textcolor   = '#ffffff';     //テキスト

				break;

			// 緑 (やさしい)
			case ( $preset_name === 'green_y' ):
                $basecolor   = '#C0D860';  //一番濃い色
                $maincolor   = '#c8dd74';  //少し薄い色
                $subcolor    = '#fafcf2';  //とても薄い色
                $accentcolor = $basecolor; //アクセント
                $textcolor   = '#ffffff';     //テキスト

				break;

			// オレンジ (やさしい)
			case ( $preset_name === 'orange_y' ):
                $basecolor   = '#FFD54F';  //一番濃い色
                $maincolor   = '#FFE082';  //少し薄い色
                $subcolor    = '#fdf9eb';  //とても薄い色
                $accentcolor = $basecolor; //アクセント
                $textcolor   = '#ffffff';     //テキスト

				break;

			// ピンク (やさしい)
			case ( $preset_name === 'pink_y' ):
                $basecolor   = '#e398d2';  //一番濃い色
                $maincolor   = '#e8acdb';  //少し薄い色
                $subcolor    = '#f9e8f5';  //とても薄い色
                $accentcolor = $basecolor; //アクセント
                $textcolor   = '#ffffff';     //テキスト

				break;

			// グレー (やさしい)
			case ( $preset_name === 'glay_y' ):
                $basecolor   = '#90A4AE';  //一番濃い色
                $maincolor   = '#B0BEC5';  //少し薄い色
                $subcolor    = '#FAFAFA';  //とても薄い色
                $accentcolor = $basecolor; //アクセント
                $textcolor   = '#FFFFFF';     //テキスト

				break;

			// デフォルト
			default:
				$basecolor   = '#e3e3e3'; //一番濃い色
				$maincolor   = '#f0f0f0'; //少し薄い色
				$subcolor    = '#fafafa'; //とても薄い色
				$accentcolor = ''; //アクセント
				$textcolor   = '#0f0f0f'; //テキスト

				break;
		}

		return array(
			'basecolor'   => $basecolor,
			'maincolor'   => $maincolor,
			'subcolor'    => $subcolor,
			'accentcolor' => $accentcolor,
			'textcolor'   => $textcolor,
		);
	}
}

if ( !function_exists( 'st_get_kantan_colors' ) ) {
	function st_get_kantan_colors() {
		return array(
			'keycolor'  => get_theme_mod( 'st_key_patterncolor', '' ),
			'maincolor' => get_theme_mod( 'st_main_patterncolor', '' ),
			'subcolor'  => get_theme_mod( 'st_sub_patterncolor', '' ),
			'textcolor' => get_theme_mod( 'st_text_patterncolor', '' ),
		);
	}
}

if ( !function_exists( 'st_get_plain_theme_mod_defaults' ) ) {
	function st_get_plain_theme_mod_defaults() {
		return array(

			'st_header_footer_logo' => '', //ヘッダーロゴをフッターにも
			'st_mobile_logo_on' => '', //モバイル用ロゴ（タイトル）を使用する
			'st_mobile_logo_size' => '', //モバイル用ロゴ画像サイズ調整
			'st_mobile_logo_center' => '', //モバイル用ロゴ（又はタイトル）をセンター寄せ
			'st_mobile_sitename'     => '',    //モバイル用タイトル使用時のテキスト色
			'st_area'               => '', //記事エリアを広げる

			'st_top_bordercolor' => '',    //サイト上部にボーダー
			'st_line100'         => '',    //サイト上部ボーダーを100%に
			'st_line_height'     => '', //サイト上部ボーダーの高さ

			'st_headbox_bgcolor_t'   => '',    //ヘッダーの背景色上部
			'st_headbox_bgcolor'     => '',    //ヘッダーの背景色下部
			'st_wrapper_bgcolor'     => '',    //Wrapperの背景色
			'st_header100'           => '',    //ヘッダーの背景画像の幅100%
			'st_header_image_side'   => 'center', //ヘッダーの背景画像の横位置
			'st_header_image_top'    => 'center', //ヘッダーの背景画像の縦位置
			'st_header_image_repeat' => '',    //ヘッダーの背景画像の繰り返し
			'st_header_gradient'            => '',        //グラデーションを横向きにする

			'st_headerunder_bgcolor'      => '',    //ヘッダー以下の背景色
			'st_headerunder_image_side'   => 'center', //ヘッダー以下の背景画像の横位置
			'st_headerunder_image_top'    => 'center', //ヘッダー以下の背景画像の縦位置
			'st_headerunder_image_repeat' => '',    //ヘッダー以下の背景画像の繰り返し

			'st_headerbg_image_side'       => 'center', //headerの背景画像の横位置
			'st_headerbg_image_top'        => 'center', //headerの背景画像の縦位置
			'st_headerbg_image_repeat'     => '',    //headerの背景画像の繰り返し
			'st_headerbg_image_flex'       => '',    //headerの背景画像のレスポンシブ化

			'st_menu_logocolor' => '', //サイトタイトル及びディスクリプション色

			'st_menu_maincolor'                 => '',        //記事エリア背景色
			'st_menu_main_bordercolor'          => '',        //記事エリアボーダー色
			'st_main_opacity'                   => '',        //記事エリア背景の透過
			'st_entry_content_bg_image_side'    => 'center',  //記事エリア背景画像の横位置
			'st_entry_content_bg_image_top'     => 'center',  //記事エリア背景画像の縦位置
			'st_entry_content_bg_image_repeat'  => '',        //記事エリア背景画像の繰り返し
			'st_entry_content_bg_image_flex'    => '',        //背景画像を幅100%のレスポンシブにする

			'st_footer_bg_text_color' => '',       //フッターテキスト色
			'st_footer_bg_color_t'    => '',       //フッター背景色上部
			'st_footer_bg_color'      => '',       //フッター背景色下部
			'st_footer100'            => '',       //フッター背景幅100%
			'st_footer_image_side'    => 'center', //フッターの背景画像の横位置
			'st_footer_image_top'     => 'center', //フッターの背景画像の縦位置
			'st_footer_image_repeat'  => '',       //フッターの背景画像の繰り返し
			'st_footerbg_image_flex'  => '',       //背景画像を幅100%のレスポンシブにする
			'st_footer_gradient'            => '',        //グラデーションを横向きにする

			//一括カラー
			'st_main_textcolor'      => '', //記事の文字色
			'st_main_textcolor_sub'      => '', //範囲を広げる（記事タイトル・抜粋など）
			'st_side_textcolor'      => '', //サイドバーの文字色
			'st_link_textcolor'      => '', //記事のリンク色
			'st_link_hovertextcolor' => '', //記事のリンクマウスオーバー色
			'st_link_hoveropacity'   => '', //記事のリンクマウスオーバー時の透明度

			//ヘッダー
			'st_headerwidget_bgcolor'   => '',        //ヘッダーウィジェットの背景色
			'st_headerwidget_textcolor' => '', //ヘッダーウィジェットのテキスト色
			'st_header_tel_color'       => '', //ヘッダーの電話番号とリンク色

			//投稿及び固定記事
			'st_kuzu_color' => '#616161', //投稿日時・ぱんくず・タグ

			//記事タイトル
			'st_entrytitle_color'           => '', //記事タイトルのテキスト色
			'st_entrytitle_bgcolor'         => '',        //記事タイトルの背景色
			'st_entrytitle_bgcolor_t'       => '',        //記事タイトルの背景色上部
			'st_entrytitleborder_color'       => '',        //記事タイトルのボーダー色
			'st_entrytitleborder_undercolor'  => '', //記事タイトルのボーダー色（2色アンダーライン）
			'st_entrytitle_border_tb'         => '',        //記事タイトルのボーダー上下のみ
			'st_entrytitle_border_tb_sub'         => '',    //記事タイトルのボーダー上を太く下をサブカラーに
			'st_entrytitle_border_tb_dot'         => '',    //記事タイトルのボーダー上をドットに
			'st_entrytitle_designsetting'     => '',        //記事タイトルデザインの変更
			'st_entrytitle_bgimg_side'        => 'left',  //記事タイトルの背景画像の横位置
			'st_entrytitle_bgimg_top'         => 'center',  //記事タイトルの背景画像の縦位置
			'st_entrytitle_bgimg_repeat'      => '',        //記事タイトルの背景画像の繰り返し
			'st_entrytitle_bgimg_leftpadding' => '',        //記事タイトルの背景画像の左の余白
			'st_entrytitle_bgimg_tupadding'   => '',        //記事タイトルの背景画像の上下の余白
			'st_entrytitle_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_entrytitle_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_entrytitle_gradient'            => '',        //グラデーションを横向きにする
			'st_entrytitle_text_center'            => '',        //テキストをセンタリング
			'st_entrytitle_design_wide'            => '',        //デザインを幅一杯にする

			//h2タグ
			'st_h2_color'           => '', //h2のテキスト色
			'st_h2_bgcolor'         => '',        //h2の背景色
			'st_h2_bgcolor_t'       => '',        //h2の背景色上部
			'st_h2border_color'       => '',        //h2のボーダー色
			'st_h2border_undercolor'  => '', //h2のボーダー色（2色アンダーライン）
			'st_h2_border_tb'         => '',        //h2のボーダー上下のみ
			'st_h2_border_tb_sub'         => '',    //h2のボーダー上を太く下をサブカラーに
			'st_h2_border_tb_dot'         => '',    //h2のボーダー上をドットに
			'st_h2_designsetting'     => '',        //h2デザインの変更
			'st_h2_bgimg_side'        => 'left',  //h2の背景画像の横位置
			'st_h2_bgimg_top'         => 'center',  //h2の背景画像の縦位置
			'st_h2_bgimg_repeat'      => '',        //h2の背景画像の繰り返し
			'st_h2_bgimg_leftpadding' => 20,        //h2の背景画像の左の余白
			'st_h2_bgimg_tupadding'   => 10,        //h2の背景画像の上下の余白
			'st_h2_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h2_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h2_gradient'            => '',        //グラデーションを横向きにする
			'st_h2_text_center'            => '',        //テキストをセンタリング
			'st_h2_design_wide'            => '',        //デザインを幅一杯にする

			//h3タグ
			'st_h3_color'          => '', //h3のテキスト色
			'st_h3_bgcolor'        => '',        //h3の背景色
			'st_h3_bgcolor_t'      => '',        //h3の背景色上部
			'st_h3border_color'       => '',        //h3のボーダー色
			'st_h3border_undercolor'  => '', //h3のボーダー色（2色アンダーライン）
			'st_h3_border_tb'         => '',        //h3のボーダー上下のみ
			'st_h3_border_tb_sub'         => '',    //h3のボーダー上を太く下をサブカラーに
			'st_h3_border_tb_dot'         => '',    //h3のボーダー上をドットに
			'st_h3_designsetting'     => '',        //h3デザインの変更
			'st_h3_bgimg_side'        => 'left',  //h3の背景画像の横位置
			'st_h3_bgimg_top'         => 'center',  //h3の背景画像の縦位置
			'st_h3_bgimg_repeat'      => '',        //h3の背景画像の繰り返し
			'st_h3_bgimg_leftpadding' => 20,        //h3の背景画像の左の余白
			'st_h3_bgimg_tupadding'   => 10,        //h3の背景画像の上下の余白
			'st_h3_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h3_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h3_gradient'            => '',        //グラデーションを横向きにする
			'st_h3_text_center'            => '',        //テキストをセンタリング
			'st_h3_design_wide'            => '',        //デザインを幅一杯にする

			//h4タグ
			'st_h4_textcolor'    => '', //h4の文字色
			'st_h4bordercolor'   => '',        //h4のボーダー色
			'st_h4bgcolor'       => '',        //h4の背景色
			'st_h4_design'            => '',         //h4の左ボーダー
			'st_h4_top_border'        => '',        //h4の上ボーダー
			'st_h4_bottom_border'     => '',        //h4の下ボーダー
			'st_h4_bgimg_side'        => 'left',  //h4の背景画像の横位置
			'st_h4_bgimg_top'         => 'center',  //h4の背景画像の縦位置
			'st_h4_bgimg_repeat'      => '',        //h4の背景画像の繰り返し
			'st_h4_bgimg_leftpadding' => 20,        //h4の背景画像の左の余白
			'st_h4_bgimg_tupadding'   => 10,        //h4の背景画像の上下の余白
			'st_h4hukidasi_design'    => '',        //h4デザインをふきだしに変更
			'st_h4_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h4_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h4_husen_shadow'            => '',        //ふせん風の影をつける

			//h4（まとめ）タグ
			'st_h4_matome_textcolor'    => '', //h4（まとめ）の文字色
			'st_h4_matome_bordercolor'   => '',        //h4（まとめ）のボーダー色
			'st_h4_matome_bgcolor'       => '',        //h4（まとめ）の背景色
			'st_h4_matome_design'            => '',        //h4（まとめ）デザインの変更
			'st_h4_matome_top_border'        => '',        //h4（まとめ）の上ボーダー
			'st_h4_matome_bottom_border'     => '',        //h4（まとめ）の下ボーダー
			'st_h4_matome_bgimg_side'        => 'left',  //h4（まとめ）の背景画像の横位置
			'st_h4_matome_bgimg_top'         => 'center',  //h4（まとめ）の背景画像の縦位置
			'st_h4_matome_bgimg_repeat'      => '',        //h4（まとめ）の背景画像の繰り返し
			'st_h4_matome_bgimg_leftpadding' => 20,        //h4（まとめ）の背景画像の左の余白
			'st_h4_matome_bgimg_tupadding'   => 10,        //h4（まとめ）の背景画像の上下の余白
			'st_h4_matome_hukidasi_design'    => '',        //h4（まとめ）デザインをふきだしに変更
			'st_h4_matome_bg_radius'    => '',        //背景や吹き出しの角を丸くする
			'st_h4_matome_no_css'    => '',        //カスタマイザーのCSSを無効化

			//h5タグ
			'st_h5_textcolor'    => '', //h5の文字色
			'st_h5bordercolor'   => '',        //h5のボーダー色
			'st_h5bgcolor'       => '',        //h5の背景色
			'st_h5_design'            => '',        //h5デザインの変更
			'st_h5_top_border'        => '',        //h5の上ボーダー
			'st_h5_bottom_border'     => '',        //h5の下ボーダー
			'st_h5_bgimg_side'        => 'left',  //h5の背景画像の横位置
			'st_h5_bgimg_top'         => 'center',  //h5の背景画像の縦位置
			'st_h5_bgimg_repeat'      => '',        //h5の背景画像の繰り返し
			'st_h5_bgimg_leftpadding' => 20,        //h5の背景画像の左の余白
			'st_h5_bgimg_tupadding'   => 10,        //h5の背景画像の上下の余白
			'st_h5hukidasi_design'    => '',        //h5デザインをふきだしに変更
			'st_h5_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h5_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h5_husen_shadow'            => '',        //ふせん風の影をつける

			'st_blockquote_color' => '#f3f3f3', //引用部分の背景色

			'st_separator_color'   => '', //NEW ENTRYのテキスト色
			'st_separator_bgcolor' => '', //NEW ENTRYの背景色

			'st_catbg_color'   => '', //カテゴリの背景色
			'st_cattext_color' => '', //カテゴリのテキスト色
			'st_cattext_radius' => '', //角を丸くする

			//お知らせ
			'st_news_datecolor'            => '', //お知らせ日付のテキスト色
			'st_news_text_color'           => '', //お知らせのテキストと下線色
			'st_menu_newsbarcolor_t'       => '',        //お知らせの背景色上
			'st_menu_newsbarcolor'         => '',        //お知らせの背景色下
			'st_menu_newsbar_border_color' => '',        //お知らせのボーダー色
			'st_menu_newsbartextcolor'     => '', //お知らせのテキスト色
			'st_menu_newsbgcolor'          => '',        //お知らせの全体背景色

			//メニュー
			'st_menu_navbar_topunder_color' => '',        //メニューの上下ボーダー色
			'st_menu_navbar_side_color'     => '',        //メニューの左右ボーダー色
			'st_menu_navbar_right_color'    => '',        //メニューの右ボーダー色
			'st_menu_navbarcolor'           => '',        //メニューの背景色下
			'st_menu_navbarcolor_t'         => '',        //メニューの背景色上
			'st_menu_navbartextcolor'       => '', //PCメニューテキスト色
			'st_menu_bold'                  => '',        //第一階層メニューを太字にする
			'st_menu100'                    => '',        //PCメニュー100%
			'st_menu_center'                    => '',        //メニューをセンター寄せにする
			'st_menu_padding'               => '',        //PCメニューの上下に隙間
			'st_navbarcolor_gradient'            => '',        //グラデーションを横向きにする

			'st_headermenu_bgimg_side'   => 'center', //ヘッダーメニューの背景画像の横位置
			'st_headermenu_bgimg_top'    => 'center', //ヘッダーメニューの背景画像の縦位置
			'st_headermenu_bgimg_repeat' => '',       //ヘッダーメニューの背景画像の繰り返し

			'st_sidemenu_bgimg_side'        => 'center', //サイドメニュー第一階層の背景画像の横位置
			'st_sidemenu_bgimg_top'         => 'center', //サイドメニュー第一階層の背景画像の縦位置
			'st_sidemenu_bgimg_repeat'      => '',       //サイドメニュー第一階層の背景画像の繰り返し
			'st_sidemenu_bgimg_leftpadding' => 15,       //サイドメニュー第一階層の背景画像の左の余白
			'st_sidemenu_bgimg_tupadding'   => 8,        //サイドメニュー第一階層の背景画像の上下の余白

			'st_sidebg_bgimg_side'   => 'center', //サイドメニューの背景画像の横位置
			'st_sidebg_bgimg_top'    => 'center', //サイドメニューの背景画像の縦位置
			'st_sidebg_bgimg_repeat' => '',       //サイドメニューの背景画像の繰り返し

			'st_header_top_bgcolor'      => '', //ヘッダー画像上の背景色
			'st_header_top_bgcolor_g'    => '', //ヘッダー画像上の背景色（右）
			'st_header_top_textcolor'    => '', //ヘッダー画像上のテキスト色

			'st_header_card_bgcolor'    => '',      //ヘッダーカードの背景色
			'st_header_card_image_side'    => '',   //ヘッダーカードの背景画像の横位置
			'st_header_card_image_top'    => '',    //ヘッダーカードの背景画像の縦位置
			'st_header_card_image_repeat'    => '', //ヘッダーカードの背景画像を繰り返さない
			'st_header_card_image_flex'    => '',   //ヘッダーカード背景画像を幅100%のレスポンシブにする

			'st_headerimg100'             => '',    //ヘッダー画像100%
			'st_header_height'           => '',    //ヘッダー画像エリアの高さ
			'st_header_height_sp'           => '',    //ヘッダー画像エリアの高さ（599px以下）
			'st_header_bgcolor'           => '',    //ヘッダー画像の背景色
			'st_topgabg_image_side'       => 'center', //ヘッダー画像の背景画像の横位置
			'st_topgabg_image_top'        => 'center', //ヘッダー画像の背景画像の縦位置
			'st_topgabg_image_repeat'     => '',    //ヘッダー画像の背景画像の繰り返し
			'st_topgabg_image_flex'       => '',    //ヘッダー画像の背景画像のレスポンシブ化
			'st_topgabg_image_fix'        => '',    //パララックス効果
			'st_topgabg_image_sumahoonly' => '',    //ヘッダー画像の背景画像をスマホとタブレットのみに

			'st_menu_navbar_undercolor' => '', //PCドロップダウン下層メニュー背景

			//サイドメニューウィジェット
			'st_menu_side_widgets_topunder_color' => '',        //サイドメニューウィジェットのボーダー色
			'st_menu_side_widgetscolor'           => '',        //サイドメニューウィジェットの背景色下
			'st_menu_side_widgetscolor_t'         => '',        //サイドメニューウィジェットの背景色上
			'st_menu_side_widgetstextcolor'       => '', //サイドメニューウィジェットテキスト色
			'st_menu_icon'            => '', //メニュー第一階層のWebアイコン
			'st_undermenu_icon'       => '', //メニュー第二階層のWebアイコン
			'st_menu_icon_color'      => '', //メニュー第一階層のWebアイコンカラー
			'st_undermenu_icon_color' => '', //メニュー第二階層のWebアイコンカラー
			'st_sidemenu_fontsize'    => '', //第一階層メニューの文字サイズを大きくする
			'st_sidemenu_accordion'   => '', //第二階層以下をスライドメニューにする
			'st_sidemenu_gradient'            => '',        //グラデーションを横向きにする

			'st_side_bgcolor' => '', //サイドバーウィジェットエリアの背景色

			'st_menu_pagelist_childtextcolor'         => '', //サイドメニュー下層のテキスト色
			'st_menu_pagelist_bgcolor'                => '',        //サイドメニュー下層の背景色
			'st_menu_pagelist_childtext_border_color' => '',        //サイドメニュー下層の下線色

			//ウィジェットタイトル
			'st_widgets_title_color'          => '', //ウィジェットタイトルのテキスト色
			'st_widgets_title_bgcolor'        => '',        //ウィジェットタイトルの背景色
			'st_widgets_title_bgcolor_t'      => '',        //ウィジェットタイトルの背景色上部
			'st_widgets_titleborder_color'       => '',        //ウィジェットタイトルのボーダー色
			'st_widgets_titleborder_undercolor'  => '', //ウィジェットタイトルのボーダー色（2色アンダーライン）
			'st_widgets_title_designsetting'     => '',        //ウィジェットタイトルデザインの変更
			'st_widgets_title_bgimg_side'        => 'left',  //ウィジェットタイトルの背景画像の横位置
			'st_widgets_title_bgimg_top'         => 'center',  //ウィジェットタイトルの背景画像の縦位置
			'st_widgets_title_bgimg_repeat'      => '',        //ウィジェットタイトルの背景画像の繰り返し
			'st_widgets_title_bgimg_leftpadding' => 10,       //ウィジェットタイトルの背景画像の左の余白
			'st_widgets_title_bgimg_tupadding'   => 7,       //ウィジェットタイトルの背景画像の上下の余白
			'st_widgets_title_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			
			'st_tagcloud_color'       => '', //タグクラウドテキスト色
			'st_tagcloud_bordercolor'       => '', //タグクラウドボーダー色
			'st_tagcloud_bgcolor'       => '', //タグクラウド背景色
			'st_rss_color'            => '', //RSSボタン

			'st_sns_btn'     => '', //SNSボタン背景
			'st_sns_btntext' => '', //SNSボタンテキスト

			'st_formbtn_textcolor'   => '', //ウィジェット問合せフォームのテキスト色
			'st_formbtn_bordercolor' => '',        //ウィジェット問合せフォームのボーダー色
			'st_formbtn_bgcolor_t'   => '',        //ウィジェット問合せフォームの背景色上部
			'st_formbtn_bgcolor'     => '', //ウィジェット問合せフォームの背景色
			'st_formbtn_radius'      => '',        //ウィジェット問合せフォームの角を丸くする

			'st_formbtn2_textcolor'   => '', //ウィジェットオリジナルボタンのテキスト色
			'st_formbtn2_bordercolor' => '',        //ウィジェットオリジナルボタンのボーダー色
			'st_formbtn2_bgcolor_t'   => '',        //ウィジェットオリジナルボタンの背景色
			'st_formbtn2_bgcolor'     => '', //ウィジェットオリジナルボタンの背景色
			'st_formbtn2_radius'      => '',        //ウィジェットオリジナルボタンの角を丸くする

			'st_contactform7btn_textcolor' => '', //コンタクトフォーム7の送信ボタンテキスト色
			'st_contactform7btn_bgcolor'   => '',  //コンタクトフォーム7の送信ボタンの背景色

			//任意記事
			'st_menu_osusumemidasitextcolor' => '', //任意記事の見出しテキスト色
			'st_menu_osusumemidasicolor'     => '', //任意記事の見出し背景色
			'st_menu_osusumemidasinocolor'   => '', //任意記事のナンバー色
			'st_menu_osusumemidasinobgcolor' => '', //任意記事のナンバー背景色
			'st_menu_popbox_color'           => '', //任意記事の背景色
			'st_menu_popbox_textcolor'       => '',        //任意記事のテキスト色
			'st_nohidden'                    => '',        //任意記事のナンバー削除
			
			//こんな方におすすめ
			'st_blackboard_textcolor'   => '', //枠線とタイトル下線
			'st_blackboard_bordercolor' => '', //ulリストの下線
			'st_blackboard_bgcolor'     => '', //背景色
			'st_blackboard_mokuzicolor'   => '', //タイトル色
			'st_blackboard_title_bgcolor'   => '', //タイトル背景色
			'st_blackboard_list3_fontweight'   => '', //タイトル下線を非表示
			'st_blackboard_underbordercolor'   => '', //ulリストのチェックアイコン
			'st_blackboard_webicon'   => 'f0f6', //Webアイコン（Font Awesome）

			//フリーボックスウィジェット
			'st_freebox_tittle_textcolor' => '', //フリーボックスウィジェットの見出しテキスト色
			'st_freebox_tittle_color'     => '', //フリーボックスウィジェットの見出背景色
			'st_freebox_color'            => '', //フリーボックスウィジェットの背景色
			'st_freebox_textcolor'        => '',        //フリーボックスウィジェットのテキスト色

			//メモボックス
			'st_memobox_color' => '', //文字・ボーダー色
			//スライドボックス
			'st_slidebox_color' => '', //背景色

			//スマートフォンサイズ
			'st_menu_sumartmenutextcolor' => '', //スマホメニュー文字色
			'st_menu_sumartmenubordercolor' => '', //スマホメニューボーダー
			'st_menu_sumart_bg_color'     => '', //スマホメニュー背景色
			'st_menu_smartbar_bg_color_t'     => '', //スマホメニューバー背景色（グラデーション上部）
			'st_menu_smartbar_bg_image_side'   => 'center', //スマホメニューバー背景画像の横位置
			'st_menu_smartbar_bg_image_top'    => 'center', //スマホメニューバー背景画像の縦位置
			'st_menu_smartbar_bg_image_repeat' => '',    //スマホメニューバー背景画像の繰り返し
			'st_menu_smartbar_bg_color'     => '', //スマホメニューOPアイコン背景色
			'st_menu_sumartbar_bg_color'  => '',        //スマホメニューバーエリア内背景色
			'st_menu_sumartcolor'         => '', //スマホwebアイコン
			'st_menu_faicon'              => '',        //メニューのWebアイコンを非表示
			'st_sticky_menu'              => '',        //スマホメニューfix
			'st_slidemenubg_image_side'   => 'center', //スライドメニューの背景画像の横位置
			'st_slidemenubg_image_top'    => 'center', //スライドメニューの背景画像の縦位置
			'st_slidemenubg_image_repeat' => '',       //スライドメニューの背景画像の繰り返し
			'st_slidemenubg_image_flex' => '',       //スライドメニューの背景画像を幅100%のレスポンシブにする
			
			//スマホミドルメニュー
			'st_middle_sumartmenutextcolor' => '', //文字色
			'st_middle_sumartmenubordercolor' => '', //ボーダー
			'st_middle_sumart_bg_color'     => '', //背景色
			'st_middle_sumart_bg_color_t'     => '', //背景色（グラデーション上部※向きはヘッダーエリア連動）
			'st_middle_sumartmenu_space'     => '', //周りに余白

			'st_menu_sumart_st_bg_color'  => '', //追加スマホメニュー背景色
			'st_menu_sumart_st_color'     => '', //追加スマホwebアイコン色
			'st_menu_sumart_st2_bg_color' => '', //追加スマホメニュー背景色2
			'st_menu_sumart_st2_color'    => '', //追加スマホwebアイコン色2
			'st_menu_sumart_footermenu_text_color'    => '', //スマホフッターメニューテキスト色
			'st_menu_sumart_footermenu_bg_color'    => '', //スマホフッターメニュー背景色

			//ガイドメニュー
			'st_guidemenu_bg_color'     => '', //背景色（第一階層）
			'st_guidemenu_radius'       => '', //角を丸くする
			'st_guidemenutextcolor'     => '', //テキスト色（第一階層）
			'st_guidemenutextcolor2'    => '', //テキスト色（第二階層以下）
			'st_guide_bg_color'         => '', //背景色（記事内用タグのみ）

			//Webアイコン
			'st_webicon_question'    => '', //はてな
			'st_webicon_check'       => '', //チェック
			'st_webicon_checkbox'       => '', //チェックボックス
			'st_webicon_checkbox_square'       => '', //チェックボックス（枠）
			'st_webicon_checkbox_size'       => '150', //チェックボックス（サイズ）
			'st_webicon_exclamation' => '', //エクステンション
			'st_webicon_memo'        => '', //メモ
			'st_webicon_user'        => '', //人物
			'st_webicon_oukan'        => '', //王冠
			'st_webicon_bigginer'        => '', // 初心者マーク

			//サイト管理者紹介
			'st_author_basecolor'          => '',   //「サイト管理者紹介」のボーダーカラー
			'st_author_bg_color'           => '',   //「サイト管理者紹介」の背景カラー

			'st_author_profile'            => '',   //「プロフィールカード」に変更
			'st_author_bg_color_profile'   => '',   //「プロフィールカード」の背景カラー
			'st_author_basecolor_profile'  => '',   //「プロフィールカード」のボーダーカラー
			'st_author_text_color_profile' => '',   //「プロフィールカード」のテキストカラー
			'st_author_profile_shadow'     => '',   //「プロフィールカード」影をつける
			'st_author_profile_avatar_shadow'     => '',   //「プロフィールカード」アバター画像に影をつける

			'st_author_profile_btn_url'    => '',   //「プロフィールカード」のボタンURL
			'st_author_profile_btn_text'   => '',   //「プロフィールカード」のボタンテキスト
			'st_author_profile_btn_text_color'    => '',   //「プロフィールカード」のボタンテキストカラー
			'st_author_profile_btn_top'    => '',   //「プロフィールカード」のボタン上部
			'st_author_profile_btn_bottom' => '',   //「プロフィールカード」のボタン下部
			'st_author_profile_btn_shadow' => '',   //「プロフィールカード」のボタン影

			//一覧のサムネイル画像の枠線
			'st_thumbnail_bordercolor' => '',   //一覧のサムネイル画像の枠線
			//記事一覧の区切りボーダー
			'st_kanren_bordercolor' => '',   // ボーダーカラー
			'st_kanren_border_dashed' => '',   // 破線にするー
			//ページャーとPREV NEXTリンク
			'st_pagination_bordercolor' => '',   // カラー

			//ページトップボタン
			'st_pagetop_up'            => '',   //TOPに戻るボタンの配置を上にする
			'st_pagetop_circle'        => '', //ページトップボタンを丸くする
			'st_pagetop_bgcolor'       => '',     //背景色
			'st_pagetop_img_right'     => '',     //right（px）
			'st_pagetop_img_bottom'    => '',     //bottom（px）
			'st_pagetop_hidden'        => '',     //ページトップボタンを非表示

			//TOC
			'st_toc_textcolor'   => '', //文字色
			'st_toc_text2color'   => '', //文字色2
			'st_toc_bordercolor' => '', //ボーダー色
			'st_toc_bgcolor'     => '', //背景色
			'st_toc_mokuzicolor'   => '', //目次色
			'st_toc_list1_left'   => '', //第1リンクを左寄せにする
			'st_toc_list1_icon'   => '', //第1リンクのアイコン非表示
			'st_toc_list2_icon'   => '', //第2リンクのアイコン非表示
			'st_toc_list3_fontweight'   => '', //第2リンク太字
			'st_toc_list3_icon'   => '', //第3リンク以降のアイコン非表示
			'st_toc_underbordercolor'   => '', //下線と第4リストアイコン
			'st_toc_webicon'   => 'f0f6', //目次アイコン（Font Awesome）
			'st_toc_radius'   => '', //背景を角丸にする
			'st_toc_paper_style' => '', //ペーパー風デザインを適用する
			'st_toc_only_toc_fontweight' => '', //第1階層のみの場合のリンクを太字にする
			'st_toc_border_width' => '', //ボーダーの太さ（px）

			//マル数字のカラー
			'st_maruno_textcolor'   => '', //ナンバー色
			'st_maruno_nobgcolor'   => '', //ナンバー背景色
			'st_maruno_bordercolor' => '', //囲いボーダー色
			'st_maruno_bgcolor'     => '', //囲い背景色
			'st_maruno_radius'     => '', //背景色の角を丸くする

			//マルチェックのカラー
			'st_maruck_textcolor'   => '', //ナンバー色
			'st_maruck_nobgcolor'   => '', //ナンバー背景色
			'st_maruck_bordercolor' => '', //囲いボーダー色
			'st_maruck_bgcolor'     => '', //囲い背景
			'st_maruck_radius'     => '', //背景色の角を丸くする

			//ブログカード
			'st_card_border_color'   => '', //枠線
			'st_card_border_size'   => '', //枠線のカラー
			'st_card_label_bgcolor' => '', //ラベル背景色
			'st_card_label_textcolor'     => '', //ラベルテキスト色
			'st_card_label_designsetting' => '', //ラベルデザイン
			
			//ステップ
			'st_step_bgcolor' => '', //ステップ数の背景色
			'st_step_color'     => '', //ステップ数の色
			'st_step_text_color'     => '', //テキスト色
			'st_step_text_bgcolor' => '', //テキストの背景色
			'st_step_text_border_color'   => '', //ボーダー色
			'st_step_radius'   => '', //角を丸くする

			//テーブルのカラー
			'st_table_bordercolor'  => '', //表のボーダー色
			'st_table_cell_bgcolor' => '', //偶数行のセルの色
			'st_table_td_bgcolor'   => '', //縦一列目の背景色
			'st_table_td_textcolor' => '', //縦一列目の文字色
			'st_table_td_bold'      => '', //縦一列目の太字
			'st_table_tr_bgcolor'   => '', //横一列目の背景色
			'st_table_tr_textcolor' => '', //横一列目の文字色
			'st_table_tr_bold'      => '', //横一列目の太字

			//会話ふきだし
			'st_kaiwa_bgcolor'        => '', //会話統一ふきだし背景色
			'st_kaiwa2_bgcolor'       => '', //会話2ふきだし背景色
			'st_kaiwa3_bgcolor'       => '', //会話3ふきだし背景色
			'st_kaiwa4_bgcolor'       => '', //会話4ふきだし背景色
			'st_kaiwa5_bgcolor'       => '', //会話5ふきだし背景色
			'st_kaiwa6_bgcolor'       => '', //会話6ふきだし背景色
			'st_kaiwa7_bgcolor'       => '', //会話7ふきだし背景色
			'st_kaiwa8_bgcolor'       => '', //会話8ふきだし背景色
			'st_kaiwa_no_border'      => '', //ボーダーなし
			'st_kaiwa_borderradius'   => '', //ふきだしを角丸にしない
			'st_kaiwa_change_border'  => '', //ふきだしのカラーをボーダー（2px）に変更
			'st_kaiwa_change_border_bgcolor'  => '', //ふきだしのカラーをボーダー（2px）に変更した時の背景色

		);
	}
}

if (!function_exists( 'st_get_menuonly_theme_mod_overrides' )) {
	function st_get_menuonly_theme_mod_overrides() {
		extract( st_get_kantan_colors(), EXTR_OVERWRITE );

		return array(
			'st_menu_navbar_topunder_color' => $keycolor,  //メニューの上下ボーダー色
			'st_menu_navbar_side_color'     => $keycolor,  //メニューの左右ボーダー色
			'st_menu_navbar_right_color'    => $maincolor, //メニューの右ボーダー色
			'st_menu_navbarcolor'           => $keycolor,  //メニューの背景色下
			'st_menu_navbarcolor_t'         => $maincolor, //メニューの背景色上

			'st_menu_navbartextcolor' => $textcolor, //PCメニューテキスト色

			'st_menu_pagelist_childtextcolor'         => $keycolor,  //サイドメニュー下層のテキスト色
			'st_menu_pagelist_bgcolor'                => $subcolor,  //サイドメニュー下層の背景色
			'st_menu_pagelist_childtext_border_color' => $maincolor, //サイドメニュー下層の下線色
		);
	}
}

if (!function_exists( 'st_get_zentai_theme_mod_overrides' )) {
	function st_get_zentai_theme_mod_overrides() {
		extract( st_get_kantan_colors(), EXTR_OVERWRITE );

		$menuonly_overrides = st_get_menuonly_theme_mod_overrides();
		$zentai_overrides   = array(

			'st_header_footer_logo' => '', //ヘッダーロゴをフッターにも
			'st_mobile_logo_on' => '', //モバイル用ロゴ（タイトル）を使用する
			'st_mobile_logo_size' => '', //モバイル用ロゴ画像サイズ調整
			'st_mobile_logo_center' => '', //モバイル用ロゴ（又はタイトル）をセンター寄せ
			'st_mobile_sitename'     => $textcolor,    //モバイル用タイトル使用時のテキスト色
			'st_area'               => '', //記事エリアを広げる

			'st_top_bordercolor' => '',    //サイト上部にボーダー
			'st_line100'         => '',    //サイト上部ボーダーを100%に
			'st_line_height'     => '5px', //サイト上部ボーダーの高さ

			'st_headbox_bgcolor_t'   => $keycolor,    //ヘッダーの背景色上部
			'st_headbox_bgcolor'     => $keycolor,    //ヘッダーの背景色下部
			'st_wrapper_bgcolor'     => '',    //Wrapperの背景色
			'st_header100'           => 'yes',    //ヘッダーの背景画像の幅100%
			'st_header_image_side'   => 'center', //ヘッダーの背景画像の横位置
			'st_header_image_top'    => 'center', //ヘッダーの背景画像の縦位置
			'st_header_image_repeat' => '',    //ヘッダーの背景画像の繰り返し
			'st_header_gradient'            => '',        //グラデーションを横向きにする

			'st_headerunder_bgcolor'      => '',    //ヘッダー以下の背景色
			'st_headerunder_image_side'   => 'center', //ヘッダー以下の背景画像の横位置
			'st_headerunder_image_top'    => 'center', //ヘッダー以下の背景画像の縦位置
			'st_headerunder_image_repeat' => '',    //ヘッダー以下の背景画像の繰り返し

			'st_menu_logocolor' => $textcolor, //サイトタイトル及びディスクリプション色

			'st_menu_maincolor'                 => '#ffffff', //記事エリア背景色
			'st_menu_main_bordercolor'          => '',        //記事エリアボーダー色
			'st_main_opacity'                   => '',        //記事エリア背景の透過
			'st_entry_content_bg_image_side'    => 'center',  //記事エリア背景画像の横位置
			'st_entry_content_bg_image_top'     => 'center',  //記事エリア背景画像の縦位置
			'st_entry_content_bg_image_repeat'  => '',        //記事エリア背景画像の繰り返し
			'st_entry_content_bg_image_flex'    => '',        //背景画像を幅100%のレスポンシブにする

			'st_footer_bg_text_color' => $textcolor,       //フッターテキスト色
			'st_footer_bg_color_t'    => $keycolor,       //フッター背景色上部
			'st_footer_bg_color'      => $keycolor,       //フッター背景色下部
			'st_footer100'            => 'yes',       //フッター背景幅100%
			'st_footer_image_side'    => 'center', //フッターの背景画像の横位置
			'st_footer_image_top'     => 'center', //フッターの背景画像の縦位置
			'st_footer_image_repeat'  => '',       //フッターの背景画像の繰り返し
			'st_footer_gradient'            => '',        //グラデーションを横向きにする
			'st_footerbg_image_flex'  => 'yes',       //背景画像を幅100%のレスポンシブにする

			//一括カラー
			'st_main_textcolor'      => '', //記事の文字色
			'st_main_textcolor_sub'      => '', //範囲を広げる（記事タイトル・抜粋など）
			'st_side_textcolor'      => '', //サイドバーの文字色
			'st_link_textcolor'      => '', //記事のリンク色
			'st_link_hovertextcolor' => '', //記事のリンクマウスオーバー色
			'st_link_hoveropacity'   => '', //記事のリンクマウスオーバー時の透明度

			//ヘッダー
			'st_headerwidget_bgcolor'   => $subcolor, //ヘッダーウィジェットの背景色
			'st_headerwidget_textcolor' => '', //ヘッダーウィジェットのテキスト色
			'st_header_tel_color'       => $textcolor, //ヘッダーの電話番号とリンク色

			//記事タイトル
			'st_entrytitle_color'           => '', //記事タイトルのテキスト色
			'st_entrytitle_bgcolor'         => '',        //記事タイトルの背景色
			'st_entrytitle_bgcolor_t'       => '',        //記事タイトルの背景色上部
			'st_entrytitleborder_color'       => '',        //記事タイトルのボーダー色
			'st_entrytitleborder_undercolor'  => '', //記事タイトルのボーダー色（2色アンダーライン）
			'st_entrytitle_border_tb'         => '',        //記事タイトルのボーダー上下のみ
			'st_entrytitle_border_tb_sub'         => '',    //記事タイトルのボーダー上を太く下をサブカラーに
			'st_entrytitle_border_tb_dot'         => '',    //記事タイトルのボーダー上をドットに
			'st_entrytitle_designsetting'     => '',        //記事タイトルデザインの変更hukidasidesign（吹き出しデザイン）linedesign（囲み&左ラインデザイン）underlinedesign（2色アンダーライン）gradient_underlinedesign（グラデーションアンダーライン）centerlinedesign（センターラインに変更）dotdesign（囲みドットデザイン）stripe_design（ストライプデザイン）underdotdesign（下線ドットデザイン）
			'st_entrytitle_bgimg_side'        => 'left',  //記事タイトルの背景画像の横位置
			'st_entrytitle_bgimg_top'         => 'center',  //記事タイトルの背景画像の縦位置
			'st_entrytitle_bgimg_repeat'      => '',        //記事タイトルの背景画像の繰り返し
			'st_entrytitle_bgimg_leftpadding' => '',        //記事タイトルの背景画像の左の余白
			'st_entrytitle_bgimg_tupadding'   => '',        //記事タイトルの背景画像の上下の余白
			'st_entrytitle_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_entrytitle_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_entrytitle_gradient'            => '',        //グラデーションを横向きにする
			'st_entrytitle_text_center'            => '',        //テキストをセンタリング
			'st_entrytitle_design_wide'            => '',        //デザインを幅一杯にする

			//h2タグ
			'st_h2_color'          => '', //h2のテキスト色
			'st_h2_bgcolor'        => '', //h2の背景色
			'st_h2_bgcolor_t'      => '', //h2の背景色上部
			'st_h2border_color'       => $keycolor, //h2のボーダー色
			'st_h2border_undercolor'  => '',  //h2のボーダー色（2色アンダーライン）
			'st_h2_border_tb'         => '',        //h2のボーダー上下のみ
			'st_h2_border_tb_sub'         => '',    //h2のボーダー上を太く下をサブカラーに
			'st_h2_border_tb_dot'         => '',    //h2のボーダー上をドットに
			'st_h2_designsetting'     => 'leftlinedesign', //h2デザインの変更hukidasidesign（吹き出しデザイン）linedesign（囲み&左ラインデザイン）underlinedesign（2色アンダーライン）gradient_underlinedesign（グラデーションアンダーライン）centerlinedesign（センターラインに変更）dotdesign（囲みドットデザイン）stripe_design（ストライプデザイン）underdotdesign（下線ドットデザイン）
			'st_h2_bgimg_side'        => 'left',   //h2の背景画像の横位置
			'st_h2_bgimg_top'         => 'center',   //h2の背景画像の縦位置
			'st_h2_bgimg_repeat'      => '',         //h2の背景画像の繰り返し
			'st_h2_bgimg_leftpadding' => '',         //h2の背景画像の左の余白
			'st_h2_bgimg_tupadding'   => 15,         //h2の背景画像の上下の余白
			'st_h2_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h2_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h2_gradient'            => '',        //グラデーションを横向きにする
			'st_h2_text_center'            => '',        //テキストをセンタリング
			'st_h2_design_wide'            => 'yes',        //デザインを幅一杯にする

			//h3タグ
			'st_h3_color'           => $textcolor, //h3のテキスト色
			'st_h3_bgcolor'         => $keycolor,  //h3の背景色
			'st_h3_bgcolor_t'       => $keycolor,  //h3の背景色上部
			'st_h3border_color'       => '', //h3のボーダー色
			'st_h3border_undercolor'  => '',  //h3のボーダー色（2色アンダーライン）
			'st_h3_border_tb'         => '',       //h3のボーダー上下のみ
			'st_h3_border_tb_sub'         => '',    //h3のボーダー上を太く下をサブカラーに
			'st_h3_border_tb_dot'         => '',    //h3のボーダー上をドットに
			'st_h3_designsetting'     => 'hukidasidesign',        //h3デザインの変更hukidasidesign（吹き出しデザイン）linedesign（囲み&左ラインデザイン）underlinedesign（2色アンダーライン）gradient_underlinedesign（グラデーションアンダーライン）centerlinedesign（センターラインに変更）dotdesign（囲みドットデザイン）stripe_design（ストライプデザイン）underdotdesign（下線ドットデザイン）
			'st_h3_bgimg_side'        => 'left',  //h3の背景画像の横位置
			'st_h3_bgimg_top'         => 'center',  //h3の背景画像の縦位置
			'st_h3_bgimg_repeat'      => '',        //h3の背景画像の繰り返し
			'st_h3_bgimg_leftpadding' => 20,        //h3の背景画像の左の余白
			'st_h3_bgimg_tupadding'   => 10,        //h3の背景画像の上下の余白
			'st_h3_bg_radius'         => 'yes',        //背景や吹き出しの角を丸くする
			'st_h3_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h3_gradient'            => '',        //グラデーションを横向きにする
			'st_h3_text_center'            => '',        //テキストをセンタリング
			'st_h3_design_wide'            => '',        //デザインを幅一杯にする

			//h4タグ
			'st_h4_textcolor'    => '', //h4の文字色
			'st_h4bordercolor'   => $maincolor,         //h4のボーダー色
			'st_h4bgcolor'       => $subcolor,  //h4の背景色
			'st_h4_design'            => '',         //h4の左ボーダー
			'st_h4_top_border'        => '',         //h4の上ボーダー
			'st_h4_bottom_border'     => '',         //h4の下ボーダー
			'st_h4_bgimg_side'        => 'left',   //h4の背景画像の横位置
			'st_h4_bgimg_top'         => 'center',   //h4の背景画像の縦位置
			'st_h4_bgimg_repeat'      => '',         //h4の背景画像の繰り返し
			'st_h4_bgimg_leftpadding' => 20,         //h4の背景画像の左の余白
			'st_h4_bgimg_tupadding'   => 10,         //h4の背景画像の上下の余白
			'st_h4hukidasi_design'    => '',        //h4デザインをふきだしに変更
			'st_h4_bg_radius'         => 'yes',        //背景や吹き出しの角を丸くする
			'st_h4_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h4_husen_shadow'            => '',        //ふせん風の影をつける

			//h4（まとめ）タグ
			'st_h4_matome_textcolor'    => $textcolor, //h4（まとめ）の文字色
			'st_h4_matome_bordercolor'   => '',        //h4（まとめ）のボーダー色
			'st_h4_matome_bgcolor'       => $keycolor,        //h4（まとめ）の背景色
			'st_h4_matome_design'            => '',        //h4（まとめ）デザインの変更
			'st_h4_matome_top_border'        => '',        //h4（まとめ）の上ボーダー
			'st_h4_matome_bottom_border'     => '',        //h4（まとめ）の下ボーダー
			'st_h4_matome_bgimg_side'        => 'center',  //h4（まとめ）の背景画像の横位置
			'st_h4_matome_bgimg_top'         => 'center',  //h4（まとめ）の背景画像の縦位置
			'st_h4_matome_bgimg_repeat'      => '',        //h4（まとめ）の背景画像の繰り返し
			'st_h4_matome_bgimg_leftpadding' => 20,        //h4（まとめ）の背景画像の左の余白
			'st_h4_matome_bgimg_tupadding'   => 10,        //h4（まとめ）の背景画像の上下の余白
			'st_h4_matome_hukidasi_design'    => 'yes',        //h4（まとめ）デザインをふきだしに変更
			'st_h4_matome_bg_radius'    => 'yes',        //背景や吹き出しの角を丸くする
			'st_h4_matome_no_css'    => '',        //カスタマイザーのCSSを無効化

			//h5タグ
			'st_h5_textcolor'    => '', //h5の文字色
			'st_h5bordercolor'   => $subcolor,        //h5のボーダー色
			'st_h5bgcolor'       => '',  //h5の背景色
			'st_h5_design'            => 'yes',         //h5デザイン左ボーダーを付ける
			'st_h5_top_border'        => '',         //h5の上ボーダー
			'st_h5_bottom_border'     => '',         //h5の下ボーダー
			'st_h5_bgimg_side'        => 'center',   //h5の背景画像の横位置
			'st_h5_bgimg_top'         => 'center',   //h5の背景画像の縦位置
			'st_h5_bgimg_repeat'      => '',         //h5の背景画像の繰り返し
			'st_h5_bgimg_leftpadding' => '15',         //h5の背景画像の左の余白
			'st_h5_bgimg_tupadding'   => '7',         //h5の背景画像の上下の余白
			'st_h5hukidasi_design'    => '',        //h5デザインをふきだしに変更
			'st_h5_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h5_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h5_husen_shadow'            => '',        //ふせん風の影をつける

			'st_blockquote_color' => $subcolor, //引用部分の背景色

			'st_separator_color'   => $textcolor, //NEW ENTRYのテキスト色
			'st_separator_bgcolor' => $keycolor, //NEW ENTRYの背景色

			'st_catbg_color'   => $keycolor, //カテゴリの背景色
			'st_cattext_color' => '#ffffff', //カテゴリのテキスト色
			'st_cattext_radius' => 'yes', //角を丸くする

			//お知らせ
			'st_news_datecolor'            => $keycolor, //お知らせ日付のテキスト色
			'st_news_text_color'           => '#000000',  //お知らせのテキストと下線色
			'st_menu_newsbarcolor_t'       => $keycolor, //お知らせの背景色上
			'st_menu_newsbarcolor'         => $keycolor, //お知らせの背景色下
			'st_menu_newsbar_border_color' => $keycolor, //お知らせのボーダー色
			'st_menu_newsbartextcolor'     => $textcolor, //お知らせのテキスト色
			'st_menu_newsbgcolor'          => '',         //お知らせの全体背景色

			//メニュー
			'st_menu_navbar_topunder_color' => $maincolor, //メニューの上下ボーダー色
			'st_menu_navbar_side_color'     => '', //メニューの左右ボーダー色
			'st_menu_navbar_right_color'    => $maincolor, //メニューの右ボーダー色
			'st_menu_navbarcolor'           => $keycolor, //メニューの背景色下
			'st_menu_navbarcolor_t'         => $keycolor, //メニューの背景色上
			'st_menu_navbar_undercolor'         => $maincolor, //下層ドロップダウンメニュー背景色
			'st_menu_navbartextcolor'       => $textcolor, //PCメニューテキスト色
			'st_menu_bold'                  => '',         //第一階層メニューを太字にする
			'st_menu100'                    => 'yes',         //PCメニュー100%
			'st_menu_padding'               => '',         //PCメニューの上下に隙間(top10,bottom10)
			'st_navbarcolor_gradient'            => '',        //グラデーションを横向きにする

			'st_headermenu_bgimg_side'   => 'center', //ヘッダーメニューの背景画像の横位置
			'st_headermenu_bgimg_top'    => 'center', //ヘッダーメニューの背景画像の縦位置
			'st_headermenu_bgimg_repeat' => '',       //ヘッダーメニューの背景画像の繰り返し

			'st_sidemenu_bgimg_side'        => 'center', //サイドメニュー第一階層の背景画像の横位置
			'st_sidemenu_bgimg_top'         => 'center', //サイドメニュー第一階層の背景画像の縦位置
			'st_sidemenu_bgimg_repeat'      => '',       //サイドメニュー第一階層の背景画像の繰り返し
			'st_sidemenu_bgimg_leftpadding' => 15,       //サイドメニュー第一階層の背景画像の左の余白
			'st_sidemenu_bgimg_tupadding'   => 8,        //サイドメニュー第一階層の背景画像の上下の余白

			'st_header_top_bgcolor'      => '', //ヘッダー画像上の背景色
			'st_header_top_bgcolor_g'    => '', //ヘッダー画像上の背景色（右）
			'st_header_top_textcolor'    => '', //ヘッダー画像上のテキスト色

			'st_header_card_bgcolor'    => '',      //ヘッダーカードの背景色
			'st_header_card_image_side'    => '',   //ヘッダーカードの背景画像の横位置
			'st_header_card_image_top'    => '',    //ヘッダーカードの背景画像の縦位置
			'st_header_card_image_repeat'    => '', //ヘッダーカードの背景画像を繰り返さない
			'st_header_card_image_flex'    => '',   //ヘッダーカード背景画像を幅100%のレスポンシブにする

			'st_sidebg_bgimg_side'   => 'center', //サイドメニューの背景画像の横位置
			'st_sidebg_bgimg_top'    => 'center', //サイドメニューの背景画像の縦位置
			'st_sidebg_bgimg_repeat' => '',       //サイドメニューの背景画像の繰り返し

			'st_headerimg100'             => '',    //ヘッダー画像100%
			'st_header_bgcolor'           => '',    //ヘッダー画像の背景色
			'st_topgabg_image_side'       => 'center', //ヘッダー画像の背景画像の横位置
			'st_topgabg_image_top'        => 'center', //ヘッダー画像の背景画像の縦位置
			'st_topgabg_image_repeat'     => '',    //ヘッダー画像の背景画像の繰り返し
			'st_topgabg_image_flex'       => '',    //ヘッダー画像の背景画像のレスポンシブ化
			'st_topgabg_image_fix'        => '',    //パララックス効果
			'st_topgabg_image_sumahoonly' => '',    //ヘッダー画像の背景画像をスマホとタブレットのみに

			//サイドメニューウィジェット
			'st_menu_side_widgets_topunder_color' => $maincolor,        //サイドメニューウィジェットのボーダー色
			'st_menu_side_widgetscolor'           => $keycolor,        //サイドメニューウィジェットの背景色下
			'st_menu_side_widgetscolor_t'         => $keycolor,        //サイドメニューウィジェットの背景色上
			'st_menu_side_widgetstextcolor'       => $textcolor, //サイドメニューウィジェットテキスト色
			'st_menu_icon'              => 'f138', //メニュー第一階層のWebアイコン
			'st_undermenu_icon'         => 'f105', //メニュー第二階層のWebアイコン
			'st_menu_icon_color'        => '', //メニュー第一階層のWebアイコンカラー
			'st_undermenu_icon_color'   => '', //メニュー第二階層のWebアイコンカラー
			'st_sidemenu_fontsize'      => 'yes', //第一階層メニューの文字サイズを大きくする
			'st_sidemenu_accordion'   => '', //第二階層以下をスライドメニューにする
			'st_sidemenu_gradient'            => '',        //グラデーションを横向きにする

			'st_side_bgcolor' => '', //サイドバーウィジェットエリアの背景色

			'st_menu_pagelist_childtextcolor'         => $keycolor, //サイドメニュー下層のテキスト色
			'st_menu_pagelist_bgcolor'                => $subcolor,  //サイドメニュー下層の背景色
			'st_menu_pagelist_childtext_border_color' => $maincolor, //サイドメニュー下層の下線色

			//ウィジェットタイトル
			'st_widgets_title_color'          => $keycolor, //ウィジェットタイトルのテキスト色
			'st_widgets_title_bgcolor'        => '',       //ウィジェットタイトルの背景色
			'st_widgets_title_bgcolor_t'      => '',        //ウィジェットタイトルの背景色上部
			'st_widgets_titleborder_color'       => $keycolor,        //ウィジェットタイトルのボーダー色
			'st_widgets_titleborder_undercolor'  => $keycolor, //ウィジェットタイトルのボーダー色（2色アンダーライン）
			'st_widgets_title_designsetting'     => 'leftlinedesign', //ウィジェットタイトルデザインの変更hukidasidesign（吹き出しデザイン）linedesign（囲み&左ラインデザイン）underlinedesign（2色アンダーライン）dotdesign（囲みドットデザイン）stripe_design（ストライプデザイン）
			'st_widgets_title_bgimg_side'        => 'left',  //ウィジェットタイトルの背景画像の横位置
			'st_widgets_title_bgimg_top'         => 'center',  //ウィジェットタイトルの背景画像の縦位置
			'st_widgets_title_bgimg_repeat'      => '',        //ウィジェットタイトルの背景画像の繰り返し
			'st_widgets_title_bgimg_leftpadding' => 15,       //ウィジェットタイトルの背景画像の左の余白
			'st_widgets_title_bgimg_tupadding'   => 5,       //ウィジェットタイトルの背景画像の上下の余白
			'st_widgets_title_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			
			'st_tagcloud_color'       => $keycolor, //タグクラウド色
			'st_tagcloud_bordercolor' => $keycolor, //タグクラウドボーダー色
			'st_rss_color'            => $keycolor, //RSSボタン

			'st_sns_btn'     => '', //SNSボタン背景
			'st_sns_btntext' => '', //SNSボタンテキスト

			'st_formbtn_textcolor'   => $textcolor, //ウィジェット問合せフォームのテキスト色
			'st_formbtn_bordercolor' => '',         //ウィジェット問合せフォームのボーダー色
			'st_formbtn_bgcolor_t'   => '',         //ウィジェット問合せフォームの背景色上部
			'st_formbtn_bgcolor'     => $keycolor, //ウィジェット問合せフォームの背景色
			'st_formbtn_radius'      => 'yes',         //ウィジェット問合せフォームの角を丸くする

			'st_formbtn2_textcolor'   => $textcolor, //ウィジェッオリジナルボタンのテキスト色
			'st_formbtn2_bordercolor' => '',         //ウィジェットオリジナルボタンのボーダー色
			'st_formbtn2_bgcolor_t'   => '',         //ウィジェッオリジナルボタンの背景色
			'st_formbtn2_bgcolor'     => $keycolor, //ウィジェッオリジナルボタンの背景色
			'st_formbtn2_radius'      => 'yes',         //ウィジェッオリジナルボタンの角を丸くする

			'st_contactform7btn_textcolor' => $textcolor, //コンタクトフォーム7の送信ボタンテキスト色
			'st_contactform7btn_bgcolor'   => $keycolor, //コンタクトフォーム7の送信ボタンの背景色

			//任意記事
			'st_menu_osusumemidasitextcolor' => $textcolor,   //任意記事の見出しテキスト色
			'st_menu_osusumemidasicolor'     => $keycolor, //任意記事の見出し背景色
			'st_menu_osusumemidasinocolor'   => $textcolor,   //任意記事のナンバー色
			'st_menu_osusumemidasinobgcolor' => $keycolor, //任意記事のナンバー背景色
			'st_menu_popbox_color'           => $subcolor,    //任意記事の背景色
			'st_menu_popbox_textcolor'       => '',           //任意記事のテキスト色
			'st_nohidden'                    => '',           //任意記事のナンバー削除
			
			//こんな方におすすめ
			'st_blackboard_textcolor'   => '', //枠線とタイトル下線
			'st_blackboard_bordercolor' => '', //ulリストの下線
			'st_blackboard_bgcolor'     => '', //背景色
			'st_blackboard_mokuzicolor'   => '', //タイトル色
			'st_blackboard_title_bgcolor'   => '', //タイトル背景色
			'st_blackboard_list3_fontweight'   => '', //タイトル下線を非表示
			'st_blackboard_underbordercolor'   => '', //ulリストのチェックアイコン
			'st_blackboard_webicon'   => 'f0f6', //Webアイコン（Font Awesome）

			//フリーボックスウィジェット
			'st_freebox_tittle_textcolor' => $textcolor,   //フリーボックスウィジェットの見出しテキスト色
			'st_freebox_tittle_color'     => $keycolor, //フリーボックスウィジェットの見出背景色
			'st_freebox_color'            => $subcolor,    //フリーボックスウィジェットの背景色
			'st_freebox_textcolor'        => '',           //フリーボックスウィジェットのテキスト色

			//メモボックス
			'st_memobox_color' => '', //文字・ボーダー色
			//スライドボックス
			'st_slidebox_color' => '', //背景色

			//スマートフォンサイズ
			'st_menu_sumartmenutextcolor' => $textcolor, //スマホメニュー文字色
			'st_menu_sumartmenubordercolor' => $maincolor, //スマホメニューボーダー
			'st_menu_sumart_bg_color'     => '', //スマホメニュー背景色
			'st_menu_smartbar_bg_color_t'     => '', //スマホメニューバー背景色（グラデーション上部）
			'st_menu_smartbar_bg_image_side'   => 'center', //スマホメニューバー背景画像の横位置
			'st_menu_smartbar_bg_image_top'    => 'center', //スマホメニューバー背景画像の縦位置
			'st_menu_smartbar_bg_image_repeat' => '',    //スマホメニューバー背景画像の繰り返し
			'st_menu_smartbar_bg_color'     => '', //スマホメニューOPアイコン背景色
			'st_menu_sumartbar_bg_color'  => $keycolor,       //スマホメニューバーエリア内背景色
			'st_menu_sumartcolor'         => $textcolor, //スマホwebアイコン
			'st_menu_faicon'              => '',        //メニューのWebアイコンを非表示
			'st_sticky_menu'              => '1',        //スマホメニューfix

			'st_menu_sumart_st_bg_color'  => $maincolor, //追加スマホメニュー背景色
			'st_menu_sumart_st_color'     => $textcolor, //追加スマホwebアイコン色
			'st_menu_sumart_st2_bg_color' => $maincolor, //追加スマホメニュー背景色2
			'st_menu_sumart_st2_color'    => $textcolor, //追加スマホwebアイコン色2
			'st_menu_sumart_footermenu_text_color'    => $textcolor, //スマホフッターメニューテキスト色
			'st_menu_sumart_footermenu_bg_color'    => $maincolor, //スマホフッターメニュー背景色

			//ガイドメニュー
			'st_guidemenu_bg_color'     => $keycolor, //背景色（第一階層）
			'st_guidemenu_radius'       => 'yes', //角を丸くする
			'st_guidemenutextcolor'     => $textcolor, //テキスト色（第一階層）
			'st_guidemenutextcolor2'    => '', //テキスト色（第二階層以下）
			'st_guide_bg_color'         => $subcolor, //背景色（記事内用タグのみ）

			//スマホミドルメニュー
			'st_middle_sumartmenutextcolor' => $textcolor, //文字色
			'st_middle_sumartmenubordercolor' => $maincolor, //ボーダー
			'st_middle_sumart_bg_color'     => $keycolor, //背景色
			'st_middle_sumart_bg_color_t'     => $keycolor, //背景色（グラデーション上部※向きはヘッダーエリア連動）

			//Webアイコン
			'st_webicon_question'    => '#64B5F6', //はてな
			'st_webicon_check'       => '#FFA726', //チェック
			'st_webicon_exclamation' => '#f44336', //エクステンション
			'st_webicon_memo'        => '#29B6F6', //メモ
			'st_webicon_user'        => '#4FC3F7', //人物
			'st_webicon_oukan'        => '#9E9D24', //王冠
			'st_webicon_bigginer'        => '#4CAF50', // 初心者マーク

			//一覧のサムネイル画像の枠線
			'st_thumbnail_bordercolor' => '',   //一覧のサムネイル画像の枠線

			//サイト管理者紹介
			'st_author_basecolor' => $keycolor,   //「サイト管理者紹介」の基本カラー
			'st_author_bg_color' => $subcolor,   //「サイト管理者紹介」の背景カラー
			'st_author_basecolor_profile'  => '#f3f3f3',   //「プロフィールカード」のボーダーカラー

			//ページトップボタン
			'st_pagetop_up'            => '',   //TOPに戻るボタンの配置を上にする
			'st_pagetop_circle'        => 'yes', //ページトップボタンを丸くする
			'st_pagetop_bgcolor'       => $keycolor,     //背景色
			'st_pagetop_img_right'     => '',     //right（px）
			'st_pagetop_img_bottom'    => '',     //bottom（px）
			'st_pagetop_hidden'        => '',     //ページトップボタンを非表示

			//TOC
			'st_toc_textcolor'   => '', //文字色
			'st_toc_text2color'   => '', //文字色2
			'st_toc_bordercolor' => '#f3f3f3', //ボーダー色
			'st_toc_bgcolor'     => '', //背景色
			'st_toc_mokuzicolor'   => '', //目次色
			'st_toc_list1_left'   => '', //第1リンクをセンター寄せにする
			'st_toc_list1_icon'   => '', //第1リンクのアイコン非表示
			'st_toc_list2_icon'   => '', //第2リンクのアイコン非表示
			'st_toc_list3_fontweight'   => '', //第2リンク太字
			'st_toc_list3_icon'   => '', //第3リンク以降のアイコン非表示
			'st_toc_underbordercolor'   => '', //下線と第4リストアイコン
			'st_toc_webicon'   => 'f0f6', //目次アイコン（Font Awesome））
			'st_toc_radius'   => '', //背景を角丸にする
			'st_toc_paper_style' => '', //ペーパー風デザインを適用する
			'st_toc_only_toc_fontweight' => 'yes', //第1階層のみの場合のリンクを太字にする
			'st_toc_border_width' => '5', //ボーダーの太さ（px）

			//マル数字のカラー
			'st_maruno_textcolor'   => $textcolor, //ナンバー色
			'st_maruno_nobgcolor'   => $keycolor, //ナンバー背景色
			'st_maruno_bordercolor' => '', //囲いボーダー色
			'st_maruno_bgcolor'     => $subcolor, //囲い背景色
			'st_maruno_radius'     => 'yes', //背景色の角を丸くする

			//マルチェックのカラー
			'st_maruck_textcolor'   => $textcolor, //ナンバー色
			'st_maruck_nobgcolor'   => $keycolor, //ナンバー背景色
			'st_maruck_bordercolor' => '', //囲いボーダー色
			'st_maruck_bgcolor'     => $subcolor, //囲い背景
			'st_maruck_radius'     => 'yes', //背景色の角を丸くする

			//テーブルのカラー
			'st_table_bordercolor'  => '', //表のボーダー色
			'st_table_cell_bgcolor' => '', //偶数行のセルの色
			'st_table_td_bgcolor'   => '', //縦一列目の背景色
			'st_table_td_textcolor' => '', //縦一列目の文字色
			'st_table_td_bold'      => '', //縦一列目の太字
			'st_table_tr_bgcolor'   => '', //横一列目の背景色
			'st_table_tr_textcolor' => '', //横一列目の文字色
			'st_table_tr_bold'      => '', //横一列目の太字

			//会話ふきだし
			'st_kaiwa_bgcolor'        => $subcolor, //会話統一ふきだし背景色
			'st_kaiwa2_bgcolor'       => '', //会話2ふきだし背景色
			'st_kaiwa3_bgcolor'       => '', //会話3ふきだし背景色
			'st_kaiwa4_bgcolor'       => '', //会話4ふきだし背景色
			'st_kaiwa5_bgcolor'       => '', //会話5ふきだし背景色
			'st_kaiwa6_bgcolor'       => '', //会話6ふきだし背景色
			'st_kaiwa7_bgcolor'       => '', //会話7ふきだし背景色
			'st_kaiwa8_bgcolor'       => '', //会話8ふきだし背景色
			'st_kaiwa_no_border'      => '', //ボーダーなし
			'st_kaiwa_borderradius'   => '', //ふきだしを角丸にしない
			'st_kaiwa_change_border'  => '', //ふきだしのカラーをボーダー（2px）に変更
			'st_kaiwa_change_border_bgcolor'  => '', //ふきだしのカラーをボーダー（2px）に変更した時の背景色

			//ステップ
			'st_step_bgcolor'             => $keycolor, //ステップ数の背景色
			'st_step_color'               => $textcolor, //ステップ数の色
			'st_step_text_color'          => '', //テキスト色
			'st_step_text_bgcolor'        => '', //テキストの背景色
			'st_step_text_border_color'   => $keycolor, //ボーダー色
			'st_step_radius'              => 'yes', //角を丸くする
			
		);

		return array_merge($menuonly_overrides, $zentai_overrides);
	}
}

if ( !function_exists( 'st_create_default_theme_mod_diff' ) ) {
	function st_create_default_theme_mod_diff( $theme_mod_defaults ) {
		$theme_mod_diff    = array();
		$previous_defaults = st_get_theme_mod_defaults( st_get_previous_kantan_setting() );

		foreach ($theme_mod_defaults as $theme_mod_name => $theme_mod_value) {
			if (!array_key_exists($theme_mod_name, $previous_defaults)) {
				$theme_mod_diff[$theme_mod_name] = $theme_mod_value;

				continue;
			}

			$current_theme_mod = get_theme_mod($theme_mod_name, $previous_defaults[$theme_mod_name]);

            if ($current_theme_mod === $previous_defaults[$theme_mod_name]) {
				$theme_mod_diff[$theme_mod_name] = $theme_mod_value;

				continue;
			}
		}

		return $theme_mod_diff;
	}
}

if ( !function_exists( 'st_get_var_theme_mod_maps' ) ) {
	function st_get_var_theme_mod_maps() {
		return array(

			'st_header_footer_logo' => 'st_header_footer_logo', //ヘッダーロゴをフッターにも
			'st_mobile_logo_on' => 'st_mobile_logo_on', //モバイル用ロゴ（タイトル）を使用する
			'st_mobile_logo_size' => 'st_mobile_logo_size', //モバイル用ロゴ画像サイズ調整
			'st_mobile_logo_center' => 'st_mobile_logo_center', //モバイル用ロゴ（又はタイトル）をセンター寄せ
			'st_mobile_sitename' => 'st_mobile_sitename', //モバイル用タイトル使用時のテキスト色
			'st_area'               => 'st_area',               //記事エリアを広げる

			'st_top_bordercolor' => 'st_top_bordercolor', //サイト上部にボーダー
			'st_line100'         => 'st_line100',         //サイト上部ボーダーを100%に
			'st_line_height'     => 'st_line_height',     //サイト上部ボーダーの高さ

			'st_headbox_bgcolor_t'   => 'st_headbox_bgcolor_t',   //ヘッダーの背景色上部
			'st_headbox_bgcolor'     => 'st_headbox_bgcolor',     //ヘッダーの背景色下部
			'st_wrapper_bgcolor'     => 'st_wrapper_bgcolor',     //Wrapperの背景色
			'st_header100'           => 'st_header100',           //ヘッダーの背景画像の幅100%
			'st_header_image_side'   => 'st_header_image_side',   //ヘッダーの背景画像の横位置
			'st_header_image_top'    => 'st_header_image_top',    //ヘッダーの背景画像の縦位置
			'st_header_image_repeat' => 'st_header_image_repeat', //ヘッダーの背景画像の繰り返し
			'st_header_gradient'            => 'st_header_gradient',        //グラデーションを横向きにする

			'st_headerunder_bgcolor'      => 'st_headerunder_bgcolor',      //ヘッダー以下の背景色
			'st_headerunder_image_side'   => 'st_headerunder_image_side',   //ヘッダー以下の背景画像の横位置
			'st_headerunder_image_top'    => 'st_headerunder_image_top',    //ヘッダー以下の背景画像の縦位置
			'st_headerunder_image_repeat' => 'st_headerunder_image_repeat', //ヘッダー以下の背景画像の繰り返し

			'st_headerbg_image_side'       => 'st_headerbg_image_side', //headerの背景画像の横位置
			'st_headerbg_image_top'        => 'st_headerbg_image_top', //headerの背景画像の縦位置
			'st_headerbg_image_repeat'     => 'st_headerbg_image_repeat',    //headerの背景画像の繰り返し
			'st_headerbg_image_flex'       => 'st_headerbg_image_flex',    //headerの背景画像のレスポンシブ化

			'menu_logocolor' => 'st_menu_logocolor', //サイトタイトル及びディスクリプション色

			'menu_maincolor'                    => 'st_menu_maincolor',                     //記事エリア背景色
			'menu_main_bordercolor'             => 'st_menu_main_bordercolor',              //記事エリアボーダー色
			'st_main_opacity'                   => 'st_main_opacity',                       //記事エリア背景の透過
			'st_entry_content_bg_image_side'    => 'st_entry_content_bg_image_side',        //記事エリア背景画像の横位置
			'st_entry_content_bg_image_top'     => 'st_entry_content_bg_image_top',         //記事エリア背景画像の縦位置
			'st_entry_content_bg_image_repeat'  => 'st_entry_content_bg_image_repeat',      //記事エリア背景画像の繰り返し
			'st_entry_content_bg_image_flex'    => 'st_entry_content_bg_image_flex',        //背景画像を幅100%のレスポンシブにする

			'st_footer_bg_text_color' => 'st_footer_bg_text_color', //フッターテキスト色
			'st_footer_bg_color_t'    => 'st_footer_bg_color_t',    //フッター背景色上部
			'st_footer_bg_color'      => 'st_footer_bg_color',      //フッター背景色下部
			'st_footer100'            => 'st_footer100',            //フッター背景幅100%
			'st_footer_image_side'    => 'st_footer_image_side',    //フッターの背景画像の横位置
			'st_footer_image_top'     => 'st_footer_image_top',     //フッターの背景画像の縦位置
			'st_footer_image_repeat'  => 'st_footer_image_repeat',  //フッターの背景画像の繰り返し
			'st_footerbg_image_flex'  => 'st_footerbg_image_flex',       //背景画像を幅100%のレスポンシブにする
			'st_footer_gradient'            => 'st_footer_gradient',        //グラデーションを横向きにする

			//一括カラー
			'st_main_textcolor'      => 'st_main_textcolor',      //記事の文字色
			'st_main_textcolor_sub'      => 'st_main_textcolor_sub', //範囲を広げる（記事タイトル・抜粋など）
			'st_side_textcolor'      => 'st_side_textcolor',      //サイドバーの文字色
			'st_link_textcolor'      => 'st_link_textcolor',      //記事のリンク色
			'st_link_hovertextcolor' => 'st_link_hovertextcolor', //記事のリンクマウスオーバー色
			'st_link_hoveropacity'   => 'st_link_hoveropacity',   //記事のリンクマウスオーバー時の透明度

			//ヘッダー
			'menu_st_headerwidget_bgcolor'   => 'st_headerwidget_bgcolor',   //ヘッダーウィジェットの背景色
			'menu_st_headerwidget_textcolor' => 'st_headerwidget_textcolor', //ヘッダーウィジェットのテキスト色
			'menu_st_header_tel_color'       => 'st_header_tel_color',       //ヘッダーの電話番号とリンク色

			//投稿及び固定記事
			'st_kuzu_color' => 'st_kuzu_color', //投稿日時・ぱんくず・タグ

			//記事タイトル
			'st_entrytitle_color'              => 'st_entrytitle_color',           //記事タイトルのテキスト色
			'st_entrytitle_bgcolor'            => 'st_entrytitle_bgcolor',         //記事タイトルの背景色
			'st_entrytitle_bgcolor_t'          => 'st_entrytitle_bgcolor_t',       //記事タイトルの背景色上部
			'st_entrytitleborder_color'       => 'st_entrytitleborder_color',       //記事タイトルのボーダー色
			'st_entrytitleborder_undercolor'  => 'st_entrytitleborder_undercolor',  //記事タイトルのボーダー色（2色アンダーライン）
			'st_entrytitle_border_tb'         => 'st_entrytitle_border_tb',         //記事タイトルのボーダー上下のみ
			'st_entrytitle_border_tb_sub'         => 'st_entrytitle_border_tb_sub',    //記事タイトルのボーダー上を太く下をサブカラーに
			'st_entrytitle_designsetting'     => 'st_entrytitle_designsetting',     //記事タイトルデザインの変更
			'st_entrytitle_bgimg_side'        => 'st_entrytitle_bgimg_side',        //記事タイトルの背景画像の横位置
			'st_entrytitle_bgimg_top'         => 'st_entrytitle_bgimg_top',         //記事タイトルの背景画像の縦位置
			'st_entrytitle_bgimg_repeat'      => 'st_entrytitle_bgimg_repeat',      //記事タイトルの背景画像の繰り返し
			'st_entrytitle_bgimg_leftpadding' => 'st_entrytitle_bgimg_leftpadding', //記事タイトルの背景画像の左の余白
			'st_entrytitle_bgimg_tupadding'   => 'st_entrytitle_bgimg_tupadding',   //記事タイトルの背景画像の上下の余白
			'st_entrytitle_bg_radius'         => 'st_entrytitle_bg_radius',        //背景や吹き出しの角を丸くする
			'st_entrytitle_no_css'            => 'st_entrytitle_no_css',        //カスタマイザーのCSSを無効化
			'st_entrytitle_gradient'            => 'st_entrytitle_gradient',        //グラデーションを横向きにする
			'st_entrytitle_text_center'            => 'st_entrytitle_text_center',        //テキストをセンタリング
			'st_entrytitle_design_wide'            => 'st_entrytitle_design_wide',        //デザインを幅一杯にする

			//h2タグ
			'st_h2_color'              => 'st_h2_color',           //h2のテキスト色
			'st_h2_bgcolor'            => 'st_h2_bgcolor',         //h2の背景色
			'st_h2_bgcolor_t'          => 'st_h2_bgcolor_t',       //h2の背景色上部
			'st_h2border_color'       => 'st_h2border_color',       //h2のボーダー色
			'st_h2border_undercolor'  => 'st_h2border_undercolor',  //h2のボーダー色（2色アンダーライン）
			'st_h2_border_tb'         => 'st_h2_border_tb',         //h2のボーダー上下のみ
			'st_h2_border_tb_sub'         => 'st_h2_border_tb_sub',    //h2のボーダー上を太く下をサブカラーに
			'st_h2_designsetting'     => 'st_h2_designsetting',     //h2デザインの変更
			'st_h2_bgimg_side'        => 'st_h2_bgimg_side',        //h2の背景画像の横位置
			'st_h2_bgimg_top'         => 'st_h2_bgimg_top',         //h2の背景画像の縦位置
			'st_h2_bgimg_repeat'      => 'st_h2_bgimg_repeat',      //h2の背景画像の繰り返し
			'st_h2_bgimg_leftpadding' => 'st_h2_bgimg_leftpadding', //h2の背景画像の左の余白
			'st_h2_bgimg_tupadding'   => 'st_h2_bgimg_tupadding',   //h2の背景画像の上下の余白
			'st_h2_bg_radius'         => 'st_h2_bg_radius',        //背景や吹き出しの角を丸くする
			'st_h2_no_css'            => 'st_h2_no_css',        //カスタマイザーのCSSを無効化
			'st_h2_gradient'            => 'st_h2_gradient',        //グラデーションを横向きにする
			'st_h2_text_center'            => 'st_h2_text_center',        //テキストをセンタリング
			'st_h2_design_wide'            => 'st_h2_design_wide',        //デザインを幅一杯にする

			//h3タグ
			'st_h3_color'              => 'st_h3_color',           //h3のテキスト色
			'st_h3_bgcolor'            => 'st_h3_bgcolor',         //h3の背景色
			'st_h3_bgcolor_t'          => 'st_h3_bgcolor_t',       //h3の背景色上部
			'st_h3border_color'       => 'st_h3border_color',       //h3のボーダー色
			'st_h3border_undercolor'  => 'st_h3border_undercolor',  //h3のボーダー色（2色アンダーライン）
			'st_h3_border_tb'         => 'st_h3_border_tb',         //h3のボーダー上下のみ
			'st_h3_border_tb_sub'         => 'st_h3_border_tb_sub',    //h3のボーダー上を太く下をサブカラーに
			'st_h3_designsetting'     => 'st_h3_designsetting',     //h3デザインの変更
			'st_h3_bgimg_side'        => 'st_h3_bgimg_side',        //h3の背景画像の横位置
			'st_h3_bgimg_top'         => 'st_h3_bgimg_top',         //h3の背景画像の縦位置
			'st_h3_bgimg_repeat'      => 'st_h3_bgimg_repeat',      //h3の背景画像の繰り返し
			'st_h3_bgimg_leftpadding' => 'st_h3_bgimg_leftpadding', //h3の背景画像の左の余白
			'st_h3_bgimg_tupadding'   => 'st_h3_bgimg_tupadding',   //h3の背景画像の上下の余白
			'st_h3_bg_radius'         => 'st_h3_bg_radius',        //背景や吹き出しの角を丸くする
			'st_h3_no_css'            => 'st_h3_no_css',        //カスタマイザーのCSSを無効化
			'st_h3_gradient'            => 'st_h3_gradient',        //グラデーションを横向きにする
			'st_h3_text_center'            => 'st_h3_text_center',        //テキストをセンタリング
			'st_h3_design_wide'            => 'st_h3_design_wide',        //デザインを幅一杯にする

			//h4タグ
			'st_h4_textcolor'    => 'st_h4_textcolor',    //h4の文字色
			'st_h4bordercolor'   => 'st_h4bordercolor',   //h4のボーダー色
			'st_h4bgcolor'          => 'st_h4bgcolor',       //h4の背景色
			'st_h4_design'            => 'st_h4_design',            //h4デザインの変更
			'st_h4_top_border'        => 'st_h4_top_border',        //h4の上ボーダー
			'st_h4_bottom_border'     => 'st_h4_bottom_border',     //h4の下ボーダー
			'st_h4_bgimg_side'        => 'st_h4_bgimg_side',        //h4の背景画像の横位置
			'st_h4_bgimg_top'         => 'st_h4_bgimg_top',         //h4の背景画像の縦位置
			'st_h4_bgimg_repeat'      => 'st_h4_bgimg_repeat',      //h4の背景画像の繰り返し
			'st_h4_bgimg_leftpadding' => 'st_h4_bgimg_leftpadding', //h4の背景画像の左の余白
			'st_h4_bgimg_tupadding'   => 'st_h4_bgimg_tupadding',   //h4の背景画像の上下の余白
			'st_h4hukidasi_design'    => 'st_h4hukidasi_design',        //h4デザインをふきだしに変更
			'st_h4_bg_radius'         => 'st_h4_bg_radius',        //背景や吹き出しの角を丸くする
			'st_h4_no_css'            => 'st_h4_no_css',        //カスタマイザーのCSSを無効化
			'st_h4_husen_shadow'            => 'st_h4_husen_shadow',        //ふせん風の影をつける

			//h4（まとめ）タグ
			'st_h4_matome_textcolor'    => 'st_h4_matome_textcolor',    //h4の文字色
			'st_h4_matome_bordercolor'   => 'st_h4_matome_bordercolor',   //h4のボーダー色
			'st_h4_matome_bgcolor'          => 'st_h4_matome_bgcolor',       //h4の背景色
			'st_h4_matome_design'            => 'st_h4_matome_design',            //h4デザインの変更
			'st_h4_matome_top_border'        => 'st_h4_matome_top_border',        //h4の上ボーダー
			'st_h4_matome_bottom_border'     => 'st_h4_matome_bottom_border',     //h4の下ボーダー
			'st_h4_matome_bgimg_side'        => 'st_h4_matome_bgimg_side',        //h4の背景画像の横位置
			'st_h4_matome_bgimg_top'         => 'st_h4_matome_bgimg_top',         //h4の背景画像の縦位置
			'st_h4_matome_bgimg_repeat'      => 'st_h4_matome_bgimg_repeat',      //h4の背景画像の繰り返し
			'st_h4_matome_bgimg_leftpadding' => 'st_h4_matome_bgimg_leftpadding', //h4の背景画像の左の余白
			'st_h4_matome_bgimg_tupadding'   => 'st_h4_matome_bgimg_tupadding',   //h4の背景画像の上下の余白
			'st_h4_matome_hukidasi_design'    => 'st_h4_matome_hukidasi_design',        //h4デザインをふきだしに変更
			'st_h4_matome_bg_radius'         => 'st_h4_matome_bg_radius',        //背景や吹き出しの角を丸くする
			'st_h4_matome_no_css'            => 'st_h4_matome_no_css',        //カスタマイザーのCSSを無効化

			//h5タグ
			'st_h5_textcolor'    => 'st_h5_textcolor',    //h5の文字色
			'st_h5bordercolor'   => 'st_h5bordercolor',   //h5のボーダー色
			'st_h5bgcolor'          => 'st_h5bgcolor',       //h5の背景色
			'st_h5_design'            => 'st_h5_design',            //h5デザインの変更
			'st_h5_top_border'        => 'st_h5_top_border',        //h5の上ボーダー
			'st_h5_bottom_border'     => 'st_h5_bottom_border',     //h5の下ボーダー
			'st_h5_bgimg_side'        => 'st_h5_bgimg_side',        //h5の背景画像の横位置
			'st_h5_bgimg_top'         => 'st_h5_bgimg_top',         //h5の背景画像の縦位置
			'st_h5_bgimg_repeat'      => 'st_h5_bgimg_repeat',      //h5の背景画像の繰り返し
			'st_h5_bgimg_leftpadding' => 'st_h5_bgimg_leftpadding', //h5の背景画像の左の余白
			'st_h5_bgimg_tupadding'   => 'st_h5_bgimg_tupadding',   //h5の背景画像の上下の余白
			'st_h5hukidasi_design'    => 'st_h5hukidasi_design',        //h5デザインをふきだしに変更
			'st_h5_bg_radius'         => 'st_h5_bg_radius',        //背景や吹き出しの角を丸くする
			'st_h5_no_css'            => 'st_h5_no_css',        //カスタマイザーのCSSを無効化
			'st_h5_husen_shadow'            => 'st_h5_husen_shadow',        //ふせん風の影をつける

			'st_blockquote_color' => 'st_blockquote_color', //引用部分の背景色

			'menu_separator_color'   => 'st_separator_color',   //NEW ENTRYのテキスト色
			'menu_separator_bgcolor' => 'st_separator_bgcolor', //NEW ENTRYの背景色

			'st_catbg_color'   => 'st_catbg_color',   //カテゴリの背景色
			'st_cattext_color' => 'st_cattext_color', //カテゴリのテキスト色
			'st_cattext_radius' => 'st_cattext_radius', //角を丸くする

			//お知らせ
			'menu_news_datecolor'     => 'st_news_datecolor',            //お知らせ日付のテキスト色
			'menu_news_text_color'    => 'st_news_text_color',           //お知らせのテキストと下線色
			'menu_newsbarcolor_t'     => 'st_menu_newsbarcolor_t',       //お知らせの背景色上
			'menu_newsbarcolor'       => 'st_menu_newsbarcolor',         //お知らせの背景色下
			'menu_newsbarbordercolor' => 'st_menu_newsbar_border_color', //お知らせのボーダー色
			'menu_newsbartextcolor'   => 'st_menu_newsbartextcolor',     //お知らせのテキスト色
			'st_menu_newsbgcolor'     => 'st_menu_newsbgcolor',          //お知らせの全体背景色

			//メニュー
			'menu_navbar_topunder_color' => 'st_menu_navbar_topunder_color', //メニューの上下ボーダー色
			'menu_navbar_side_color'     => 'st_menu_navbar_side_color',     //メニューの左右ボーダー色
			'menu_navbar_right_color'    => 'st_menu_navbar_right_color',    //メニューの右ボーダー色
			'menu_navbarcolor'           => 'st_menu_navbarcolor',           //メニューの背景色下
			'menu_navbarcolor_t'         => 'st_menu_navbarcolor_t',         //メニューの背景色上
			'menu_navbartextcolor'       => 'st_menu_navbartextcolor',       //PCメニューテキスト色
			'st_menu_bold'               => 'st_menu_bold',                  //第一階層メニューを太字にする
			'st_menu100'                 => 'st_menu100',                    //PCメニュー100%
			'st_menu_center'             => 'st_menu_center',        //メニューをセンター寄せにする
			'st_menu_padding'            => 'st_menu_padding',               //PCメニューの上下に隙間
			'st_navbarcolor_gradient'    => 'st_navbarcolor_gradient',        //グラデーションを横向きにする

			'st_headermenu_bgimg_side'   => 'st_headermenu_bgimg_side',   //ヘッダーメニューの背景画像の横位置
			'st_headermenu_bgimg_top'    => 'st_headermenu_bgimg_top',    //ヘッダーメニューの背景画像の縦位置
			'st_headermenu_bgimg_repeat' => 'st_headermenu_bgimg_repeat', //ヘッダーメニューの背景画像の繰り返し

			'st_sidemenu_bgimg_side'        => 'st_sidemenu_bgimg_side',        //サイドメニュー第一階層の背景画像の横位置
			'st_sidemenu_bgimg_top'         => 'st_sidemenu_bgimg_top',         //サイドメニュー第一階層の背景画像の縦位置
			'st_sidemenu_bgimg_repeat'      => 'st_sidemenu_bgimg_repeat',      //サイドメニュー第一階層の背景画像の繰り返し
			'st_sidemenu_bgimg_leftpadding' => 'st_sidemenu_bgimg_leftpadding', //サイドメニュー第一階層の背景画像の左の余白
			'st_sidemenu_bgimg_tupadding'   => 'st_sidemenu_bgimg_tupadding',   //サイドメニュー第一階層の背景画像の上下の余白

			'st_sidebg_bgimg_side'   => 'st_sidebg_bgimg_side',   //サイドメニューの背景画像の横位置
			'st_sidebg_bgimg_top'    => 'st_sidebg_bgimg_top',    //サイドメニューの背景画像の縦位置
			'st_sidebg_bgimg_repeat' => 'st_sidebg_bgimg_repeat', //サイドメニューの背景画像の繰り返し

			'st_header_top_bgcolor'      => 'st_header_top_bgcolor', //ヘッダー画像上の背景色
			'st_header_top_bgcolor_g'    => 'st_header_top_bgcolor_g', //ヘッダー画像上の背景色（右）
			'st_header_top_textcolor'    => 'st_header_top_textcolor', //ヘッダー画像上のテキスト色

			'st_header_card_bgcolor'       => 'st_header_card_bgcolor',      //ヘッダーカードの背景色
			'st_header_card_image_side'    => 'st_header_card_image_side',   //ヘッダーカードの背景画像の横位置
			'st_header_card_image_top'     => 'st_header_card_image_top',    //ヘッダーカードの背景画像の縦位置
			'st_header_card_image_repeat'  => 'st_header_card_image_repeat', //ヘッダーカードの背景画像を繰り返さない
			'st_header_card_image_flex'    => 'st_header_card_image_flex',   //ヘッダーカード背景画像を幅100%のレスポンシブにする

			'st_headerimg100'             => 'st_headerimg100',             //ヘッダー画像100%
			'st_header_height'           => 'st_header_height',    //ヘッダー画像エリアの高さ
			'st_header_height_sp'           => 'st_header_height_sp',    //ヘッダー画像エリアの高さ（599px以下）
			'st_header_bgcolor'           => 'st_header_bgcolor',           //ヘッダー画像の背景色
			'st_topgabg_image_side'       => 'st_topgabg_image_side',       //ヘッダー画像の背景画像の横位置
			'st_topgabg_image_top'        => 'st_topgabg_image_top',        //ヘッダー画像の背景画像の縦位置
			'st_topgabg_image_repeat'     => 'st_topgabg_image_repeat',     //ヘッダー画像の背景画像の繰り返し
			'st_topgabg_image_flex'       => 'st_topgabg_image_flex',       //ヘッダー画像の背景画像のレスポンシブ化
			'st_topgabg_image_fix'        => 'st_topgabg_image_fix',    //パララックス効果
			'st_topgabg_image_sumahoonly' => 'st_topgabg_image_sumahoonly', //ヘッダー画像の背景画像をスマホとタブレットのみに

			'menu_navbar_undercolor'  => 'st_menu_navbar_undercolor', //PCドロップダウン下層メニュー背景

			//サイドメニューウィジェット
			'st_menu_side_widgets_topunder_color' => 'st_menu_side_widgets_topunder_color',        //サイドメニューウィジェットのボーダー色
			'st_menu_side_widgetscolor'           => 'st_menu_side_widgetscolor',        //サイドメニューウィジェットの背景色下
			'st_menu_side_widgetscolor_t'         => 'st_menu_side_widgetscolor_t',        //サイドメニューウィジェットの背景色上
			'st_menu_side_widgetstextcolor'       => 'st_menu_side_widgetstextcolor', //サイドメニューウィジェットテキスト色
			'st_menu_icon'            => 'st_menu_icon',            //メニュー第一階層のWebアイコン
			'st_undermenu_icon'       => 'st_undermenu_icon',       //メニュー第二階層のWebアイコン
			'st_menu_icon_color'      => 'st_menu_icon_color',      //メニュー第一階層のWebアイコンカラー
			'st_undermenu_icon_color' => 'st_undermenu_icon_color', //メニュー第二階層のWebアイコンカラー
			'st_sidemenu_fontsize'    => 'st_sidemenu_fontsize',    //第一階層メニューの文字サイズを大きくする
			'st_sidemenu_accordion'   => 'st_sidemenu_accordion',   //第二階層以下をスライドメニューにする
			'st_sidemenu_gradient'            => 'st_sidemenu_gradient',        //グラデーションを横向きにする

			'st_side_bgcolor' => 'st_side_bgcolor', //サイドバーウィジェットエリアの背景色

			'menu_pagelist_childtextcolor'         => 'st_menu_pagelist_childtextcolor',         //サイドメニュー下層のテキスト色
			'menu_pagelist_bgcolor'                => 'st_menu_pagelist_bgcolor',                //サイドメニュー下層の背景色
			'menu_pagelist_childtext_border_color' => 'st_menu_pagelist_childtext_border_color', //サイドメニュー下層の下線色

			//ウィジェットタイトル
			'st_widgets_title_color'          => 'st_widgets_title_color', //ウィジェットタイトルのテキスト色
			'st_widgets_title_bgcolor'        => 'st_widgets_title_bgcolor',        //ウィジェットタイトルの背景色
			'st_widgets_title_bgcolor_t'      => 'st_widgets_title_bgcolor_t',        //ウィジェットタイトルの背景色上部
			'st_widgets_titleborder_color'       => 'st_widgets_titleborder_color',        //ウィジェットタイトルのボーダー色
			'st_widgets_titleborder_undercolor'  => 'st_widgets_titleborder_undercolor', //ウィジェットタイトルのボーダー色（2色アンダーライン）
			'st_widgets_title_designsetting'     => 'st_widgets_title_designsetting',        //ウィジェットタイトルデザインの変更
			'st_widgets_title_bgimg_side'        => 'st_widgets_title_bgimg_side',  //ウィジェットタイトルの背景画像の横位置
			'st_widgets_title_bgimg_top'         => 'st_widgets_title_bgimg_top',  //ウィジェットタイトルの背景画像の縦位置
			'st_widgets_title_bgimg_repeat'      => 'st_widgets_title_bgimg_repeat',        //ウィジェットタイトルの背景画像の繰り返し
			'st_widgets_title_bgimg_leftpadding' => 'st_widgets_title_bgimg_leftpadding',       //ウィジェットタイトルの背景画像の左の余白
			'st_widgets_title_bgimg_tupadding'   => 'st_widgets_title_bgimg_tupadding',       //ウィジェットタイトルの背景画像の上下の余白
			'st_widgets_title_bg_radius'         => 'st_widgets_title_bg_radius',        //背景や吹き出しの角を丸くする
			
			'st_tagcloud_color'        => 'st_tagcloud_color', //タグクラウドテキスト色
			'st_tagcloud_bordercolor'  => 'st_tagcloud_bordercolor', //タグクラウドボーダー色
			'st_tagcloud_bgcolor'      => 'st_tagcloud_bgcolor', //タグクラウド背景色
			'menu_rsscolor'            => 'st_rss_color',            //RSSボタン

			'st_sns_btn'     => 'st_sns_btn',     //SNSボタン背景
			'st_sns_btntext' => 'st_sns_btntext', //SNSボタンテキスト

			'st_formbtn_textcolor'   => 'st_formbtn_textcolor',   //ウィジェット問合せフォームのテキスト色
			'st_formbtn_bordercolor' => 'st_formbtn_bordercolor', //ウィジェット問合せフォームのボーダー色
			'st_formbtn_bgcolor_t'   => 'st_formbtn_bgcolor_t',   //ウィジェット問合せフォームの背景色上部
			'st_formbtn_bgcolor'     => 'st_formbtn_bgcolor',     //ウィジェット問合せフォームの背景色
			'st_formbtn_radius'      => 'st_formbtn_radius',      //ウィジェット問合せフォームの角を丸くする

			'st_formbtn2_textcolor'   => 'st_formbtn2_textcolor',   //ウィジェッオリジナルボタンのテキスト色
			'st_formbtn2_bordercolor' => 'st_formbtn2_bordercolor', //ウィジェットオリジナルボタンのボーダー色
			'st_formbtn2_bgcolor_t'   => 'st_formbtn2_bgcolor_t',   //ウィジェッオリジナルボタンの背景色
			'st_formbtn2_bgcolor'     => 'st_formbtn2_bgcolor',     //ウィジェッオリジナルボタンの背景色
			'st_formbtn2_radius'      => 'st_formbtn2_radius',      //ウィジェッオリジナルボタンの角を丸くする

			'st_contactform7btn_textcolor' => 'st_contactform7btn_textcolor', //コンタクトフォーム7の送信ボタンテキスト色
			'st_contactform7btn_bgcolor'   => 'st_contactform7btn_bgcolor',   //コンタクトフォーム7の送信ボタンの背景色

			//任意記事
			'menu_osusumemidasitextcolor' => 'st_menu_osusumemidasitextcolor', //任意記事の見出しテキスト色
			'menu_osusumemidasicolor'     => 'st_menu_osusumemidasicolor',     //任意記事の見出し背景色
			'menu_osusumemidasinocolor'   => 'st_menu_osusumemidasinocolor',   //任意記事のナンバー色
			'menu_osusumemidasinobgcolor' => 'st_menu_osusumemidasinobgcolor', //任意記事のナンバー背景色
			'menu_popbox_color'           => 'st_menu_popbox_color',           //任意記事の背景色
			'menu_popbox_textcolor'       => 'st_menu_popbox_textcolor',       //任意記事のテキスト色
			'st_nohidden'                 => 'st_nohidden',                    //任意記事のナンバー削除
			
			//こんな方におすすめ
			'st_blackboard_textcolor'   => 'st_blackboard_textcolor', //枠線とタイトル下線
			'st_blackboard_bordercolor' => 'st_blackboard_bordercolor', //ulリストの下線
			'st_blackboard_bgcolor'     => 'st_blackboard_bgcolor',     //背景色
			'st_blackboard_mokuzicolor'   => 'st_blackboard_mokuzicolor', //タイトル色
			'st_blackboard_title_bgcolor'   => 'st_blackboard_title_bgcolor', //タイトル背景色
			'st_blackboard_list3_fontweight'   => 'st_blackboard_list3_fontweight', //タイトル下線を非表示
			'st_blackboard_underbordercolor'   => 'st_blackboard_underbordercolor', //ulリストのチェックアイコン
			'st_blackboard_webicon'   => 'st_blackboard_webicon', //Webアイコン（Font Awesome）

			//フリーボックスウィジェット
			'freebox_tittle_textcolor' => 'st_freebox_tittle_textcolor', //フリーボックスウィジェットの見出しテキスト色
			'freebox_tittle_color'     => 'st_freebox_tittle_color',     //フリーボックスウィジェットの見出背景色
			'freebox_color'            => 'st_freebox_color',            //フリーボックスウィジェットの背景色
			'freebox_textcolor'        => 'st_freebox_textcolor',        //フリーボックスウィジェットのテキスト色

			//メモボックス
			'st_memobox_color' => 'st_memobox_color', //文字・ボーダー色
			//スライドボックス
			'st_slidebox_color' => 'st_slidebox_color', //背景色

			//スマートフォンサイズ
			'menu_sumartmenutextcolor' => 'st_menu_sumartmenutextcolor', //スマホメニュー文字色
			'st_menu_sumartmenubordercolor' => 'st_menu_sumartmenubordercolor', //スマホメニューボーダー
			'st_menu_smartbar_bg_color'     => 'st_menu_smartbar_bg_color',     //スマホメニュー背景色
			'st_menu_smartbar_bg_color_t'     => 'st_menu_smartbar_bg_color_t', //スマホメニューバー背景色（グラデーション上部）
			'st_menu_smartbar_bg_image_side'   => 'st_menu_smartbar_bg_image_side', //スマホメニューバー背景画像の横位置
			'st_menu_smartbar_bg_image_top'    => 'st_menu_smartbar_bg_image_top', //スマホメニューバー背景画像の縦位置
			'st_menu_smartbar_bg_image_repeat' => 'st_menu_smartbar_bg_image_repeat',    //スマホメニューバー背景画像の繰り返し
			'menu_sumart_bg_color'     => 'st_menu_sumart_bg_color',     //スマホメニューOPアイコン背景色
			'menu_sumartbar_bg_color'  => 'st_menu_sumartbar_bg_color',  //スマホメニューバーエリア内背景色
			'menu_sumartcolor'         => 'st_menu_sumartcolor',         //スマホwebアイコン
			'st_menu_faicon'              => 'st_menu_faicon',        //メニューのWebアイコンを非表示
			'st_sticky_menu'           => 'st_sticky_menu',              //スマホメニューfix
 			'st_slidemenubg_image_side'   => 'st_slidemenubg_image_side', //スライドメニューの背景画像の横位置
			'st_slidemenubg_image_top'    => 'st_slidemenubg_image_top', //スライドメニューの背景画像の縦位置
			'st_slidemenubg_image_repeat' => 'st_slidemenubg_image_repeat',       //スライドメニューの背景画像の繰り返し
			'st_slidemenubg_image_flex' => 'st_slidemenubg_image_flex',       //スライドメニューの背景画像を幅100%のレスポンシブにする
			
			//スマホミドルメニュー
			'st_middle_sumartmenutextcolor' => 'st_middle_sumartmenutextcolor', //文字色
			'st_middle_sumartmenubordercolor' => 'st_middle_sumartmenubordercolor', //ボーダー
			'st_middle_sumart_bg_color'     => 'st_middle_sumart_bg_color', //背景色
			'st_middle_sumart_bg_color_t'     => 'st_middle_sumart_bg_color_t', //背景色（上部）
			'st_middle_sumartmenu_space'     => 'st_middle_sumartmenu_space', //周りに余白

			'menu_sumart_st_bg_color'  => 'st_menu_sumart_st_bg_color',  //追加スマホメニュー背景色
			'menu_sumart_st_color'     => 'st_menu_sumart_st_color',     //追加スマホwebアイコン色
			'menu_sumart_st2_bg_color' => 'st_menu_sumart_st2_bg_color', //追加スマホメニュー背景色2
			'menu_sumart_st2_color'    => 'st_menu_sumart_st2_color',    //追加スマホwebアイコン色2
			'st_menu_sumart_footermenu_text_color'    => 'st_menu_sumart_footermenu_text_color', //スマホフッターメニューテキスト色
			'st_menu_sumart_footermenu_bg_color'    => 'st_menu_sumart_footermenu_bg_color', //スマホフッターメニュー背景色

			//ガイドメニュー
			'st_guidemenu_bg_color'     => 'st_guidemenu_bg_color', //背景色（第一階層）
			'st_guidemenu_radius'       => 'st_guidemenu_radius', //角を丸くする
			'st_guidemenutextcolor'     => 'st_guidemenutextcolor', //テキスト色（第一階層）
			'st_guidemenutextcolor2'    => 'st_guidemenutextcolor2', //テキスト色（第二階層以下）
			'st_guide_bg_color'         => 'st_guide_bg_color', //背景色（記事内用タグのみ）

			//Webアイコン
			'st_webicon_question'    => 'st_webicon_question',    //はてな
			'st_webicon_check'       => 'st_webicon_check',       //チェック
			'st_webicon_checkbox'    => 'st_webicon_checkbox', //チェックボックス
			'st_webicon_checkbox_square' => 'st_webicon_checkbox_square', //チェックボックス（枠）
			'st_webicon_checkbox_size'       => 'st_webicon_checkbox_size', //チェックボックス（サイズ）
			'st_webicon_exclamation' => 'st_webicon_exclamation', //エクステンション
			'st_webicon_memo'        => 'st_webicon_memo',        //メモ
			'st_webicon_user'        => 'st_webicon_user',        //人物
			'st_webicon_oukan'       => 'st_webicon_oukan', //王冠
			'st_webicon_bigginer'    => 'st_webicon_bigginer', // 初心者マーク

			//サイト管理者紹介
			'st_author_basecolor'          => 'st_author_basecolor',   //「サイト管理者紹介」の基本カラー
			'st_author_bg_color'           => 'st_author_bg_color',   //「サイト管理者紹介」の背景カラー

			'st_author_profile'            => 'st_author_profile',   //「プロフィールカード」に変更
			'st_author_bg_color_profile'   => 'st_author_bg_color_profile',   //「プロフィールカード」の背景カラー
			'st_author_basecolor_profile'  => 'st_author_basecolor_profile',   //「プロフィールカード」のボーダーカラー
			'st_author_text_color_profile' => 'st_author_text_color_profile',   //「プロフィールカード」のテキストカラー
			'st_author_profile_shadow'     => 'st_author_profile_shadow',   //「プロフィールカード」影をつける
			'st_author_profile_avatar_shadow'     => 'st_author_profile_avatar_shadow',   //「プロフィールカード」アバター画像に影をつける

			'st_author_profile_btn_url'    => 'st_author_profile_btn_url',   //「プロフィールカード」のボタンURL
			'st_author_profile_btn_text'   => 'st_author_profile_btn_text',   //「プロフィールカード」のボタンテキスト
			'st_author_profile_btn_text_color'    => 'st_author_profile_btn_text_color',   //「プロフィールカード」のボタンテキストカラー
			'st_author_profile_btn_top'    => 'st_author_profile_btn_top',   //「プロフィールカード」のボタン上部
			'st_author_profile_btn_bottom' => 'st_author_profile_btn_bottom',   //「プロフィールカード」のボタン下部
			'st_author_profile_btn_shadow' => 'st_author_profile_btn_shadow',   //「プロフィールカード」のボタン影

			//一覧のサムネイル画像の枠線
			'st_thumbnail_bordercolor'        => 'st_thumbnail_bordercolor',   //一覧のサムネイル画像の枠線
			//記事一覧の区切りボーダー
			'st_kanren_bordercolor' => 'st_kanren_bordercolor',   // ボーダーカラー
			'st_kanren_border_dashed' => 'st_kanren_border_dashed',   // 破線にするー
			//ページャーとPREV NEXTリンク
			'st_pagination_bordercolor' => 'st_pagination_bordercolor',   // カラー

			//ページトップボタン
			'st_pagetop_up'          => 'st_pagetop_up',   //TOPに戻るボタンの配置を上にする
			'st_pagetop_circle'      => 'st_pagetop_circle', //ページトップボタンを丸くする
			'st_pagetop_bgcolor'     => 'st_pagetop_bgcolor',     //背景色
			'st_pagetop_img_right'   => 'st_pagetop_img_right',     //right（px）
			'st_pagetop_img_bottom'  => 'st_pagetop_img_bottom',     //bottom（px）
			'st_pagetop_hidden'      => 'st_pagetop_hidden',     //ページトップボタンを非表示

			//TOC
			'st_toc_textcolor'   => 'st_toc_textcolor',   //文字色
			'st_toc_text2color'   => 'st_toc_text2color', //文字色2
			'st_toc_bordercolor' => 'st_toc_bordercolor', //ボーダー色
			'st_toc_bgcolor'     => 'st_toc_bgcolor',     //背景色
			'st_toc_mokuzicolor'   => 'st_toc_mokuzicolor', //目次色
			'st_toc_list1_left'   => 'st_toc_list1_left', //第1リンクを左寄せにする
			'st_toc_list1_icon'   => 'st_toc_list1_icon', //第1リンクのアイコン非表示
			'st_toc_list2_icon'   => 'st_toc_list2_icon', //第1リンクのアイコン非表示
			'st_toc_list3_fontweight'   => 'st_toc_list3_fontweight', //第2リンク太字
			'st_toc_list3_icon'   => 'st_toc_list3_icon', //第3リンク以降のアイコン非表示
			'st_toc_underbordercolor'   => 'st_toc_underbordercolor', //下線と第4リストアイコン
			'st_toc_webicon'   => 'st_toc_webicon', //Webアイコン（Font Awesome）
			'st_toc_radius'   => 'st_toc_radius', //背景を角丸にする
			'st_toc_paper_style' => 'st_toc_paper_style', //ペーパー風デザインを適用する
			'st_toc_only_toc_fontweight' => 'st_toc_only_toc_fontweight', //第1階層のみの場合のリンクを太字にする
			'st_toc_border_width' => 'st_toc_border_width', //ボーダーの太さ（px）

			//マル数字のカラー
			'st_maruno_textcolor'   => 'st_maruno_textcolor',   //ナンバー色
			'st_maruno_nobgcolor'   => 'st_maruno_nobgcolor',   //ナンバー背景色
			'st_maruno_bordercolor' => 'st_maruno_bordercolor', //囲いボーダー色
			'st_maruno_bgcolor'     => 'st_maruno_bgcolor',     //囲い背景色
			'st_maruno_radius'     => 'st_maruno_radius',     //背景色の角を丸くする

			//マルチェックのカラー
			'st_maruck_textcolor'   => 'st_maruck_textcolor',   //ナンバー色
			'st_maruck_nobgcolor'   => 'st_maruck_nobgcolor',   //ナンバー背景色
			'st_maruck_bordercolor' => 'st_maruck_bordercolor', //囲いボーダー色
			'st_maruck_bgcolor'     => 'st_maruck_bgcolor',     //囲い背景色
			'st_maruck_radius'     => 'st_maruck_radius',     //背景色の角を丸くする

			//ブログカード
			'st_card_border_color'        => 'st_card_border_color', //枠線
			'st_card_border_size'         => 'st_card_border_size', //枠線のカラー
			'st_card_label_bgcolor'       => 'st_card_label_bgcolor', //ラベル背景色
			'st_card_label_textcolor'     => 'st_card_label_textcolor', //ラベルテキスト色
			'st_card_label_designsetting' => 'st_card_label_designsetting', //ラベルデザイン
			
			//ステップ
			'st_step_bgcolor' => 'st_step_bgcolor', //ステップ数の背景色
			'st_step_color'     => 'st_step_color', //ステップ数の色
			'st_step_text_color'     => 'st_step_text_color', //テキスト色
			'st_step_text_bgcolor' => 'st_step_text_bgcolor', //テキストの背景色
			'st_step_text_border_color'   => 'st_step_text_border_color', //ボーダー色
			'st_step_radius'   => 'st_step_radius', //角を丸くする

			//テーブルのカラー
			'st_table_bordercolor'  => 'st_table_bordercolor',  //表のボーダー色
			'st_table_cell_bgcolor' => 'st_table_cell_bgcolor', //偶数行のセルの色
			'st_table_td_bgcolor'   => 'st_table_td_bgcolor',   //縦一列目の背景色
			'st_table_td_textcolor' => 'st_table_td_textcolor', //縦一列目の文字色
			'st_table_td_bold'      => 'st_table_td_bold',      //縦一列目の太字
			'st_table_tr_bgcolor'   => 'st_table_tr_bgcolor',   //横一列目の背景色
			'st_table_tr_textcolor' => 'st_table_tr_textcolor', //横一列目の文字色
			'st_table_tr_bold'      => 'st_table_tr_bold',      //横一列目の太字

			//会話ふきだし
			'st_kaiwa_bgcolor'        => 'st_kaiwa_bgcolor', //会話統一ふきだし背景色
			'st_kaiwa2_bgcolor'       => 'st_kaiwa2_bgcolor', //会話2ふきだし背景色
			'st_kaiwa3_bgcolor'       => 'st_kaiwa3_bgcolor', //会話3ふきだし背景色
			'st_kaiwa4_bgcolor'       => 'st_kaiwa4_bgcolor', //会話4ふきだし背景色
			'st_kaiwa5_bgcolor'       => 'st_kaiwa5_bgcolor', //会話5ふきだし背景色
			'st_kaiwa6_bgcolor'       => 'st_kaiwa6_bgcolor', //会話6ふきだし背景色
			'st_kaiwa7_bgcolor'       => 'st_kaiwa7_bgcolor', //会話7ふきだし背景色
			'st_kaiwa8_bgcolor'       => 'st_kaiwa8_bgcolor', //会話8ふきだし背景色
			'st_kaiwa_no_border'      => 'st_kaiwa_no_border', //ボーダーなし
			'st_kaiwa_borderradius'   => 'st_kaiwa_borderradius', //ふきだしを角丸にしない
			'st_kaiwa_change_border'  => 'st_kaiwa_change_border', //ふきだしのカラーをボーダー（2px）に変更
			'st_kaiwa_change_border_bgcolor'  => 'st_kaiwa_change_border_bgcolor', //ふきだしのカラーをボーダー（2px）に変更した時の背景色
		);
	}
}

if ( !function_exists( 'st_create_theme_mod_var_array' ) ) {
	function st_create_theme_mod_var_array( $theme_mod_defaults, $maps, $theme_mod_overrides = array() ) {
		$vars = array();

		foreach ( $maps as $var_name => $theme_mod_name ) {
			$in_defaults  = array_key_exists( $theme_mod_name, $theme_mod_defaults );
			$in_overrides = array_key_exists( $theme_mod_name, $theme_mod_overrides );

			if ( !$in_defaults && !$in_overrides ) {
				continue;
			}

			if ($in_overrides) {
				$vars[$var_name] = $theme_mod_overrides[$theme_mod_name];

				continue;
			}

			$vars[$var_name] = get_theme_mod( $theme_mod_name, $theme_mod_defaults[$theme_mod_name] );
		}

		return $vars;
	}
}

if ( !function_exists( 'st_get_theme_mod_defaults' ) ) {
	function st_get_theme_mod_defaults($kantan_setting = null) {
		$kantan_setting = ( $kantan_setting !== null ) ? $kantan_setting : st_get_kantan_setting();
		$defaults       = st_get_plain_theme_mod_defaults();

		if ( !st_is_customizer_enabled() ) {
			return $defaults;
		}

		$preset_overrides = st_get_preset_theme_mod_overrides( st_get_preset_name() );
		$defaults         = array_merge( $defaults, $preset_overrides);

		switch (true) {
			case ($kantan_setting === 'defaultcolor'):
				$defaults = array_merge($defaults, st_get_zentai_theme_mod_overrides());

				break;

			default:
				break;
		}

		return $defaults;
	}
}

if ( ! function_exists( '_st_customize_setting' ) ) {
	function _st_customize_settings( $settings = null ) {
		static $store = [];

		if ( $settings === null ) {
			return $store;
		}

		$store = $settings;
	}
}

if (!function_exists('_st_customization_add_color_controls')) {
	function _st_customization_add_color_controls(
		WP_Customize_Manager $wp_customize,
		$section,
		$priority = 10,
		$label = ''
	) {
		static $id = 1;

		if ( $id === 1 ) {
			$preset_colors  = st_get_preset_colors( st_get_preset_name() );

			extract( $preset_colors, EXTR_OVERWRITE );

			$wp_customize->add_setting( 'st_key_patterncolor',
				array(
					'default'              => $basecolor,
					'sanitize_callback'    => 'sanitize_hex_color',
					'sanitize_js_callback' => 'maybe_hash_hex_color',
				) );

			$wp_customize->add_setting( 'st_main_patterncolor',
				array(
					'default'              => $maincolor,
					'sanitize_callback'    => 'sanitize_hex_color',
					'sanitize_js_callback' => 'maybe_hash_hex_color',
				) );

			$wp_customize->add_setting( 'st_sub_patterncolor',
				array(
					'default'              => $subcolor,
					'sanitize_callback'    => 'sanitize_hex_color',
					'sanitize_js_callback' => 'maybe_hash_hex_color',
				) );

			$wp_customize->add_setting( 'st_text_patterncolor',
				array(
					'default'              => $textcolor,
					'sanitize_callback'    => 'sanitize_hex_color',
					'sanitize_js_callback' => 'maybe_hash_hex_color',
				) );
		}

		$suffix   = '_' . $id;
		$priority = 0;

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'st_key_patterncolor' . $suffix,
			array(
				'label'       => __( $label, 'default' ),
				'section'     => $section,
				'description' => 'キーカラー（推奨：一番濃い色）',
				'settings'    => 'st_key_patterncolor',
				'priority'    => $priority,
			)
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'st_main_patterncolor' . $suffix,
			array(
				'label'       => __( '', 'default' ),
				'section'     => $section,
				'description' => 'メインカラー（推奨：少し薄い色）',
				'settings'    => 'st_main_patterncolor',
				'priority'    => $priority,
			)
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'st_sub_patterncolor' . $suffix,
			array(
				'label'       => __( '', 'default' ),
				'section'     => $section,
				'description' => 'サブカラー（推奨：とても薄い色）',
				'settings'    => 'st_sub_patterncolor',
				'priority'    => $priority,
			)
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'st_text_patterncolor' . $suffix,
			array(
				'label'       => __( '', 'default' ),
				'section'     => $section,
				'description' => 'テキスト（一部）',
				'settings'    => 'st_text_patterncolor',
				'priority'    => $priority,
			)
		) );

		$id ++;
	}
}

function st_customize_register( $wp_customize ) {
	$kantan_setting = st_get_previous_kantan_setting();
	$defaults       = st_get_theme_mod_defaults( $kantan_setting );
	$preset_colors  = st_get_preset_colors( st_get_preset_name() );

	extract( $preset_colors, EXTR_OVERWRITE );

	$default_settings = $wp_customize->settings();

	$wp_customize->add_section( 'st_logo_image',
		array(
			'title'    => 'ロゴ画像',
			'priority' => 10,
			'description' => 'ロゴ画像 / フッター用 / モバイル用（スマホ閲覧時のロゴ及びサイト名をメニューに並べます）',
		) );

	$wp_customize->add_setting( 'st_logo_image',
		array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'logo_Image',
		array(
			'label'    => 'ロゴ画像',
			'section'  => 'st_logo_image',
			'settings' => 'st_logo_image',
		)
	) );

	$wp_customize->add_setting( 'st_footer_logo',
		array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'footer_logo',
		array(
			'label'       => '',
			'section'     => 'st_logo_image',
			'description' => 'フッターロゴ画像',
			'settings'    => 'st_footer_logo',
		)
	) );

	$wp_customize->add_setting( 'st_header_footer_logo',
		array(
			'default'           => $defaults['st_header_footer_logo'],
			'sanitize_callback' => 'sanitize_checkbox',
		) );
	$wp_customize->add_control( 'st_header_footer_logo',
		array(
			'section'     => 'st_logo_image',
			'settings'    => 'st_header_footer_logo',
			'label'       => 'ヘッダーロゴ画像を使用する',
			'description' => '',
			'type'        => 'checkbox',
		) );

	$wp_customize->add_setting( 'st_mobile_logo',
		array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'mobile_logo',
		array(
			'label'       => 'モバイル用ロゴ画像',
			'section'     => 'st_logo_image',
			'description' => '',
			'settings'    => 'st_mobile_logo',
		)
	) );

		$wp_customize->add_setting( 'st_mobile_sitename',
			array(
				'default'              => $defaults['st_mobile_sitename'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_mobile_sitename', array(
			'label'       => __( '', 'default' ),
			'description' => 'モバイル用タイトル使用時のテキスト色',
			'section'     => 'st_logo_image',

			'settings' => 'st_mobile_sitename',
		) ) );
	
	$wp_customize->add_setting( 'st_mobile_logo_on',
		array(
			'default'           => $defaults['st_mobile_logo_on'],
			'sanitize_callback' => 'sanitize_checkbox',
		) );
	$wp_customize->add_control( 'st_mobile_logo_on',
		array(
			'section'     => 'st_logo_image',
			'settings'    => 'st_mobile_logo_on',
			'label'       => 'モバイル用ロゴ（又はタイトル）を使用する',
			'description' => '※スマホ閲覧時のロゴ及びサイト名をメニューに並べます <br/>※通常のタイトル・キャプション・スマホ追加メニューは表示されなくなります（注：トップではサイトタイトルがh1タグに変更）',
			'type'        => 'checkbox',
		) );
	
	$wp_customize->add_setting( 'st_mobile_logo_size',
		array(
			'default'           => $defaults['st_mobile_logo_size'],
			'sanitize_callback' => 'sanitize_checkbox',
		) );
	$wp_customize->add_control( 'st_mobile_logo_size',
		array(
			'section'     => 'st_logo_image',
			'settings'    => 'st_mobile_logo_size',
			'label'       => 'モバイル用ロゴ画像サイズ調整',
			'description' => '※少し大きく表示されます',
			'type'        => 'checkbox',
		) );
	
	$wp_customize->add_setting( 'st_mobile_logo_center',
		array(
			'default'           => $defaults['st_mobile_logo_center'],
			'sanitize_callback' => 'sanitize_checkbox',
		) );
	$wp_customize->add_control( 'st_mobile_logo_center',
		array(
			'section'     => 'st_logo_image',
			'settings'    => 'st_mobile_logo_center',
			'label'       => 'モバイル用ロゴ（又はタイトル）をセンター寄せ',
			'description' => '',
			'type'        => 'checkbox',
		) );

	/*-------------------------------------------------------
	ヘッダー画像
	-------------------------------------------------------*/
	$wp_customize->add_section( 'header_image',
		array(
			'title'    => 'ヘッダー画像',
			'priority' => 20,
			'description' => 'ヘッダー画像 / ヘッダー画像エリア（高さ・背景色・背景画像）',
		) );

	if ( st_is_customizer_enabled() ) {
		// _st_customization_add_color_controls( $wp_customize, 'header_image' );
	}

		/*ヘッダー画像100%*/
		$wp_customize->add_setting( 'st_headerimg100',
			array(
				'default'           => $defaults['st_headerimg100'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_headerimg100',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_headerimg100',
				'label'       => 'ヘッダー画像の横幅を100%にする（※背景画像は見えなくなります）',
				'description' => '',
				'type'        => 'checkbox',
			) );

	/*モバイル用ヘッダー画像*/
	$wp_customize->add_setting( 'st_mobile_header',
		array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'mobile_header',
		array(
			'label'       => '',
			'section'     => 'header_image',
			'description' => 'モバイル用ヘッダー画像',
			'settings'    => 'st_mobile_header',
		)
	) );

	if ( st_is_customizer_enabled() ) {

		//ヘッダー画像エリア
		$wp_customize->add_setting( 'st_header_height',
			array(
				'default'           => $defaults['st_header_height'],
				'sanitize_callback' => 'sanitize_int',
			) );
		$wp_customize->add_control( 'st_header_height_c',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_header_height',
				'label'       => __( 'ヘッダー画像エリア', 'default' ),
				'description' => 'ヘッダー画像エリア最低の高さ（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_header_height_sp',
			array(
				'default'           => $defaults['st_header_height_sp'],
				'sanitize_callback' => 'sanitize_int',
			) );
		$wp_customize->add_control( 'st_header_height_sp_c',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_header_height_sp',
				'label'       => '',
				'description' => 'スマホ用（599px以下）※高さを分ける場合',
				'type'        => 'option',
			) );

		//ヘッダーエリア背景色
		$wp_customize->add_setting( 'st_header_bgcolor',
			array(
				'default'              => $defaults['st_header_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_header_bgcolor', array(
			'label'       => '',
			'description' => 'ヘッダー画像エリアの背景色',
			'section'     => 'header_image',
			'settings' => 'st_header_bgcolor',
		) ) );

		//ヘッダー画像エリア背景画像

		$wp_customize->add_setting( 'st_topgabg_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'topga_Image',
			array(
				'label'       => '',
				'section'     => 'header_image',
				'description' => 'ヘッダー画像の後ろに配置する背景画像です（ヘッダー画像にpngなど透過性のある素材を利用すると重ねることが出来ます）',
				'settings'    => 'st_topgabg_image',
			)
		) );

		$wp_customize->add_setting( 'st_topgabg_image_side',
			array(
				'default'           => $defaults['st_topgabg_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_topgabg_image_side',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_topgabg_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_topgabg_image_top',
			array(
				'default'           => $defaults['st_topgabg_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_topgabg_image_top',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_topgabg_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_topgabg_image_repeat',
			array(
				'default'           => $defaults['st_topgabg_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_topgabg_image_repeat',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_topgabg_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_topgabg_image_flex',
			array(
				'default'           => $defaults['st_topgabg_image_flex'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_topgabg_image_flex',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_topgabg_image_flex',
				'label'       => '背景画像を幅100%のレスポンシブにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_topgabg_image_fix',
			array(
				'default'           => $defaults['st_topgabg_image_fix'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_topgabg_image_fix',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_topgabg_image_fix',
				'label'       => 'パララックス（視差効果）風にする ※PCのみ',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_topgabg_image_sumahoonly',
			array(
				'default'           => $defaults['st_topgabg_image_sumahoonly'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_topgabg_image_sumahoonly',
			array(
				'section'     => 'header_image',
				'settings'    => 'st_topgabg_image_sumahoonly',
				'label'       => '背景画像をスマホ・タブレットのみにする',
				'description' => '',
				'type'        => 'checkbox',
			) );
	}
	/*-------------------------------------------------------
		基本エリア設定
	-------------------------------------------------------*/
	if ( st_is_customizer_enabled() ) { // カスタマイザー有効化の有無

		$wp_customize->add_panel( 'st_panel_base_area', // 大パネル
			array(
				'title'       => __( '基本エリア設定', 'default' ),
				'description' => '',
				'priority'    => 81,
			) );

		$wp_customize->add_section('color_controls', array( // カラー
    		'title' => 'カラーパレット',
    		'panel' => 'st_panel_base_area',
  		));
		_st_customization_add_color_controls( $wp_customize, 'color_controls' );

		$wp_customize->add_section('colors', array( // 中パネル
			'title' => '背景色',
			'panel' => 'st_panel_base_area',
		));

		//wrapperサイト全体背景

		$wp_customize->add_setting( 'st_wrapper_bgcolor',
			array(
				'default'              => $defaults['st_wrapper_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_wrapper_bgcolor', array(
			'label'       => __( 'サイト背景色', 'default' ),
			'description' => 'サイト全体を包括する背景色です※色を設定すると幅のMAX値は1100pxになります',
			'section'     => 'colors',
			'settings' => 'st_wrapper_bgcolor',
		) ) );

		//ヘッダーエリア
		$wp_customize->add_section('st_panel_header_area', array( // 中パネル
			'title' => 'ヘッダーエリア',
			'description' => 'サイトのタイトルなどが表示される一番上のエリアです',
			'panel' => 'st_panel_base_area',
		));

		//サイト上部にラインを入れる
		$wp_customize->add_setting( 'st_top_bordercolor',
			array(
				'default'              => $defaults['st_top_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_top_bordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'サイト上部にライン',
			'section'     => 'st_panel_header_area',
			'settings'    => 'st_top_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_line_height',
			array(
				'default'           => $defaults['st_line_height'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_line_height',
			array(
				'section'     => 'st_panel_header_area',
				'settings'    => 'st_line_height',
				'label'       => '',
				'description' => 'ラインの高さ（px）',
				'type'        => 'radio',
				'choices'     => array(
					'1px' => __( '1px', 'default' ),
					'5px' => __( '5px', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_line100',
			array(
				'default'           => $defaults['st_line100'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_line100',
			array(
				'section'     => 'st_panel_header_area',
				'settings'    => 'st_line100',
				'label'       => 'ラインの横幅を100%にする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_headbox_bgcolor',
			array(
				'default'              => $defaults['st_headbox_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_headbox_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_header_area',
			'settings' => 'st_headbox_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_headbox_bgcolor_t',
			array(
				'default'              => $defaults['st_headbox_bgcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_headbox_bgcolor_t', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色（グラデーション上部）',
			'section'     => 'st_panel_header_area',

			'settings' => 'st_headbox_bgcolor_t',
		) ) );

		$wp_customize->add_setting( 'st_header100',
			array(
				'default'           => $defaults['st_header100'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_header100',
			array(
				'section'     => 'st_panel_header_area',
				'settings'    => 'st_header100',
				'label'       => 'ヘッダー背景の横幅を100%にする',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
	
			$wp_customize->add_setting( 'st_header_gradient',
			array(
				'default'           => $defaults['st_header_gradient'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_header_gradient',
			array(
				'section'     => 'st_panel_header_area',
				'settings'    => 'st_header_gradient',
				'label'       => 'グラデーションを横向きにする',
				'description' => '',
				'type'        => 'checkbox',
			) );
			

		//ヘッダーエリア背景画像

		$wp_customize->add_setting( 'st_header_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'head_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_header_area',
				'description' => 'ヘッダーエリア背景画像',
				'settings'    => 'st_header_image',
			)
		) );

		$wp_customize->add_setting( 'st_header_image_side',
			array(
				'default'           => $defaults['st_header_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_header_image_side',
			array(
				'section'     => 'st_panel_header_area',
				'settings'    => 'st_header_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_header_image_top',
			array(
				'default'           => $defaults['st_header_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_header_image_top',
			array(
				'section'     => 'st_panel_header_area',
				'settings'    => 'st_header_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_header_image_repeat',
			array(
				'default'           => $defaults['st_header_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_header_image_repeat',
			array(
				'section'     => 'st_panel_header_area',
				'settings'    => 'st_header_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//タイトル色

		$wp_customize->add_setting( 'st_menu_logocolor',
			array(
				'default'              => $defaults['st_menu_logocolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_logocolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'サイトタイトルとキャッチフレーズの文字色',
			'section'     => 'st_panel_header_area',
			'settings'    => 'st_menu_logocolor',
		) ) );


		/*ヘッダーウィジェットの背景色*/
		$wp_customize->add_setting( 'st_headerwidget_bgcolor',
			array(
				'default'              => $defaults['st_headerwidget_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_headerwidget_bgcolor', array(
			'label'       => __( 'ヘッダー右（フッター）ウィジェット背景色', 'default' ),
			'section'     => 'st_panel_header_area',
			'description' => '',
			'settings'    => 'st_headerwidget_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_headerwidget_textcolor',
			array(
				'default'              => $defaults['st_headerwidget_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_headerwidget_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_header_area',
			'description' => 'ヘッダーウィジェット文字色',
			'settings'    => 'st_headerwidget_textcolor',
		) ) );

		/*電話番号とヘッダーリンク*/

		$wp_customize->add_setting( 'st_header_tel_color',
			array(
				'default'              => $defaults['st_header_tel_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_header_tel_color', array(
			'label'       => __( '電話番号とヘッダーリンク', 'default' ),
			'section'     => 'st_panel_header_area',
			'description' => '',
			'settings'    => 'st_header_tel_color',
		) ) );

		//ヘッダーエリア上
		$wp_customize->add_section('st_panel_header_area_top', array( // 中パネル
			'title' => 'ヘッダー画像エリア上ウィジェット',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_header_top_bgcolor',
			array(
				'default'              => $defaults['st_header_top_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_header_top_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ヘッダーエリア上の背景色',
			'section'     => 'st_panel_header_area_top',
			'settings' => 'st_header_top_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_header_top_bgcolor_g',
			array(
				'default'              => $defaults['st_header_top_bgcolor_g'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_header_top_bgcolor_g', array(
			'label'       => __( '', 'default' ),
			'description' => 'ヘッダーエリア上の背景色（右）',
			'section'     => 'st_panel_header_area_top',
			'settings' => 'st_header_top_bgcolor_g',
		) ) );

		$wp_customize->add_setting( 'st_header_top_textcolor',
			array(
				'default'              => $defaults['st_header_top_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_header_top_textcolor', array(
			'label'       => '',
			'description' => 'ヘッダーエリア上の文字色',
			'section'     => 'st_panel_header_area_top',
			'settings' => 'st_header_top_textcolor',
		) ) );

		//ヘッダーカードエリア
		$wp_customize->add_section('st_panel_header_card_area', array( // 中パネル
			'title' => 'ヘッダーカードエリア',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_header_card_bgcolor',
			array(
				'default'              => $defaults['st_header_card_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_header_card_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '',
			'section'     => 'st_panel_header_card_area',
			'settings' => 'st_header_card_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_header_card_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'header_card_Image',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_header_card_area',
				'description' => '',
				'settings'    => 'st_header_card_image',
			)
		) );

		$wp_customize->add_setting( 'st_header_card_image_side',
			array(
				'default'           => $defaults['st_header_card_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_header_card_image_side',
			array(
				'section'     => 'st_panel_header_card_area',
				'settings'    => 'st_header_card_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_header_card_image_top',
			array(
				'default'           => $defaults['st_header_card_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_header_card_image_top',
			array(
				'section'     => 'st_panel_header_card_area',
				'settings'    => 'st_header_card_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_header_card_image_repeat',
			array(
				'default'           => $defaults['st_header_card_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_header_card_image_repeat',
			array(
				'section'     => 'st_panel_header_card_area',
				'settings'    => 'st_header_card_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_header_card_image_flex',
			array(
				'default'           => $defaults['st_header_card_image_flex'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_header_card_image_flex',
			array(
				'section'     => 'st_panel_header_card_area',
				'settings'    => 'st_header_card_image_flex',
				'label'       => '背景画像を幅100%のレスポンシブにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//header背景画像
		$wp_customize->add_section('st_panel_header', array( // 中パネル
			'title' => 'headerエリア',
			'description' => 'header（ヘッダー+メニュー+ヘッダー画像エリア）全体に配置する背景画像です',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_headerbg_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'header_Image',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_header',
				'description' => '',
				'settings'    => 'st_headerbg_image',
			)
		) );

		$wp_customize->add_setting( 'st_headerbg_image_side',
			array(
				'default'           => $defaults['st_headerbg_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_headerbg_image_side',
			array(
				'section'     => 'st_panel_header',
				'settings'    => 'st_headerbg_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_headerbg_image_top',
			array(
				'default'           => $defaults['st_headerbg_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_headerbg_image_top',
			array(
				'section'     => 'st_panel_header',
				'settings'    => 'st_headerbg_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_headerbg_image_repeat',
			array(
				'default'           => $defaults['st_headerbg_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_headerbg_image_repeat',
			array(
				'section'     => 'st_panel_header',
				'settings'    => 'st_headerbg_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_headerbg_image_flex',
			array(
				'default'           => $defaults['st_headerbg_image_flex'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_headerbg_image_flex',
			array(
				'section'     => 'st_panel_header',
				'settings'    => 'st_headerbg_image_flex',
				'label'       => '背景画像を幅100%のレスポンシブにする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		//ヘッダー以下の背景色
		$wp_customize->add_section('st_panel_header_area_under', array( // 中パネル
			'title' => 'header以下のエリア',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_headerunder_bgcolor',
			array(
				'default'              => $defaults['st_headerunder_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_headerunder_bgcolor', array(
			'label'       => __( '背景色', 'default' ),
			'description' => '',
			'section'     => 'st_panel_header_area_under',

			'settings' => 'st_headerunder_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_headerunder_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'headerunder_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_header_area_under',
				'description' => '背景画像',
				'settings'    => 'st_headerunder_image',
			)
		) );

		$wp_customize->add_setting( 'st_headerunder_image_side',
			array(
				'default'           => $defaults['st_headerunder_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_headerunder_image_side',
			array(
				'section'     => 'st_panel_header_area_under',
				'settings'    => 'st_headerunder_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_headerunder_image_top',
			array(
				'default'           => $defaults['st_headerunder_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_headerunder_image_top',
			array(
				'section'     => 'st_panel_header_area_under',
				'settings'    => 'st_headerunder_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_headerunder_image_repeat',
			array(
				'default'           => $defaults['st_headerunder_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_headerunder_image_repeat',
			array(
				'section'     => 'st_panel_header_area_under',
				'settings'    => 'st_headerunder_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//記事背景
		$wp_customize->add_section('st_panel_post_area', array( // 中パネル
			'title' => 'mainエリア（記事）',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_menu_maincolor',
			array(
				'default'              => $defaults['st_menu_maincolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_maincolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_post_area',

			'settings' => 'st_menu_maincolor',
		) ) );

		//記事背景の透過

		$wp_customize->add_setting( 'st_main_opacity',
			array(
				'default'           => $defaults['st_main_opacity'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_main_opacity',
			array(
				'section'     => 'st_panel_post_area',
				'settings'    => 'st_main_opacity',
				'label'       => '',
				'description' => '背景色透過※PC閲覧時（白色になります）',
				'type'        => 'select',
				'choices'     => array(
					''   => __( '透過しない', 'default' ),
					'20' => __( '20%', 'default' ),
					'50' => __( '50%', 'default' ),
					'80' => __( '80%', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_menu_main_bordercolor',
			array(
				'default'              => $defaults['st_menu_main_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_main_bordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => '周りのボーダー',
			'section'     => 'st_panel_post_area',
			'settings'    => 'st_menu_main_bordercolor',
		) ) );

		/*記事エリアの幅*/
		$wp_customize->add_setting( 'st_area',
			array(
				'default'           => $defaults['st_area'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_area',
			array(
				'section'     => 'st_panel_post_area',
				'settings'    => 'st_area',
				'label'       => 'PC時の記事エリアの幅を広げる（640→700px）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//記事エリア背景画像

		$wp_customize->add_setting( 'st_entry_content_bg_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'entry_content_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_post_area',
				'description' => '※背景色は無視されます',
				'settings'    => 'st_entry_content_bg_image',
			)
		) );

		$wp_customize->add_setting( 'st_entry_content_bg_image_side',
			array(
				'default'           => $defaults['st_entry_content_bg_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_entry_content_bg_image_side',
			array(
				'section'     => 'st_panel_post_area',
				'settings'    => 'st_entry_content_bg_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_entry_content_bg_image_top',
			array(
				'default'           => $defaults['st_entry_content_bg_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_entry_content_bg_image_top',
			array(
				'section'     => 'st_panel_post_area',
				'settings'    => 'st_entry_content_bg_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_entry_content_bg_image_repeat',
			array(
				'default'           => $defaults['st_entry_content_bg_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entry_content_bg_image_repeat',
			array(
				'section'     => 'st_panel_post_area',
				'settings'    => 'st_entry_content_bg_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_entry_content_bg_image_flex',
			array(
				'default'           => $defaults['st_entry_content_bg_image_flex'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entry_content_bg_image_flex',
			array(
				'section'     => 'st_panel_post_area',
				'settings'    => 'st_entry_content_bg_image_flex',
				'label'       => '背景画像を幅100%のレスポンシブにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*サイドバー*/
		$wp_customize->add_section('st_panel_sidebar', array( // 中パネル
			'title' => 'サイドバー',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_side_textcolor',
			array(
				'default'              => $defaults['st_side_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_side_textcolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'サイドの文字色（一部カラーの強制変更）',
			'section'     => 'st_panel_sidebar',
			'settings'    => 'st_side_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_side_bgcolor',
			array(
				'default'              => $defaults['st_side_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_side_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'サイドバーウィジェットエリアの背景色',
			'section'     => 'st_panel_sidebar',
			'settings' => 'st_side_bgcolor',
		) ) );

		/*フッターエリア*/
		$wp_customize->add_section('st_panel_footer_area', array( // 中パネル
			'title' => 'フッターエリア',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_footer_bg_text_color',
			array(
				'default'              => $defaults['st_footer_bg_text_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_footer_bg_text_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_footer_area',
			'description' => 'フッター文字色',
			'settings'    => 'st_footer_bg_text_color',
		) ) );

		$wp_customize->add_setting( 'st_footer_bg_color',
			array(
				'default'              => $defaults['st_footer_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_footer_bg_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_footer_area',
			'description' => '背景色',
			'settings'    => 'st_footer_bg_color',
		) ) );

		$wp_customize->add_setting( 'st_footer_bg_color_t',
			array(
				'default'              => $defaults['st_footer_bg_color_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_footer_bg_color_t', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_footer_area',
			'description' => '背景色（グラデーション上部）',
			'settings'    => 'st_footer_bg_color_t',
		) ) );

		$wp_customize->add_setting( 'st_footer100',
			array(
				'default'           => $defaults['st_footer100'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_footer100',
			array(
				'section'     => 'st_panel_footer_area',
				'settings'    => 'st_footer100',
				'label'       => 'フッターの背景色を100%にする',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
		$wp_customize->add_setting( 'st_footer_gradient',
			array(
				'default'           => $defaults['st_footer_gradient'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_footer_gradient',
			array(
				'section'     => 'st_panel_footer_area',
				'settings'    => 'st_footer_gradient',
				'label'       => 'グラデーションを横向きにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_footer_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'footer_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_footer_area',
				'description' => 'フッター画像',
				'settings'    => 'st_footer_image',
			)
		) );

		$wp_customize->add_setting( 'st_footer_image_side',
			array(
				'default'           => $defaults['st_footer_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_footer_image_side',
			array(
				'section'     => 'st_panel_footer_area',
				'settings'    => 'st_footer_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_footer_image_top',
			array(
				'default'           => $defaults['st_footer_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_footer_image_top',
			array(
				'section'     => 'st_panel_footer_area',
				'settings'    => 'st_footer_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_footer_image_repeat',
			array(
				'default'           => $defaults['st_footer_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_footer_image_repeat',
			array(
				'section'     => 'st_panel_footer_area',
				'settings'    => 'st_footer_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_footerbg_image_flex',
			array(
				'default'           => $defaults['st_footerbg_image_flex'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_footerbg_image_flex',
			array(
				'section'     => 'st_panel_footer_area',
				'settings'    => 'st_footerbg_image_flex',
				'label'       => '背景画像を幅100%のレスポンシブにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*記事一覧の区切りボーダー*/
		$wp_customize->add_section('st_panel_post_border', array( // 中パネル
			'title' => '記事一覧の区切りボーダー',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_kanren_bordercolor',
			array(
				'default'              => $defaults['st_kanren_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kanren_bordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダーカラー',
			'section'     => 'st_panel_post_border',
			'settings'    => 'st_kanren_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_kanren_border_dashed',
			array(
				'default'           => $defaults['st_kanren_border_dashed'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_kanren_border_dashed',
			array(
				'section'     => 'st_panel_post_border',
				'settings'    => 'st_kanren_border_dashed',
				'label'       => '破線にする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*ページャーとPREV NEXTリンク*/
		$wp_customize->add_section('st_panel_pagination', array( // 中パネル
			'title' => 'ページャーとPREV NEXTリンク',
			'panel' => 'st_panel_base_area',
		));

		$wp_customize->add_setting( 'st_pagination_bordercolor',
			array(
				'default'              => $defaults['st_pagination_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_pagination_bordercolor', array(
			'label'       => __( 'ページャーとPREV NEXTリンク', 'default' ),
			'description' => 'カラー',
			'section'     => 'st_panel_pagination',
			'settings'    => 'st_pagination_bordercolor',
		) ) );


		/*-------------------------------------------------------
		メニュー
		-------------------------------------------------------*/

		$wp_customize->add_panel( 'st_panel_stmenus',
			array(
				'title'       => __( '[+] メニューのカラー設定', 'default' ),
				'priority'    => 101,
			) );

		$wp_customize->add_section('color_controls_stmenus', array( // カラー
    		'title' => 'カラーパレット',
    		'panel' => 'st_panel_stmenus',
  		));
		_st_customization_add_color_controls( $wp_customize, 'color_controls_stmenus' );

		$wp_customize->add_section('st_panel_header_menu', array( // 中パネル
			'title' => 'PCヘッダーメニュー',
			'description' => '600px以上で表示されるメニューです。位置は「テーマ管理」＞「メニュー」で変更できます。予め「メニュー設定」にて「ヘッダー用メニュー」を設定してください。',
			'panel' => 'st_panel_stmenus',
		));

		$wp_customize->add_setting( 'st_menu_navbarcolor',
			array(
				'default'              => $defaults['st_menu_navbarcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_navbarcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_header_menu',
			'description' => '背景色',
			'settings'    => 'st_menu_navbarcolor',
		) ) );

		$wp_customize->add_setting( 'st_menu_navbarcolor_t',
			array(
				'default'              => $defaults['st_menu_navbarcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_navbarcolor_t', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_header_menu',
			'description' => '背景色（グラデーション上部）',
			'settings'    => 'st_menu_navbarcolor_t',
		) ) );

		$wp_customize->add_setting( 'st_menu_navbar_topunder_color',
			array(
				'default'              => $defaults['st_menu_navbar_topunder_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_navbar_topunder_color',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_header_menu',
				'description' => 'ボーダー上下色',
				'settings'    => 'st_menu_navbar_topunder_color',
			) ) );

		$wp_customize->add_setting( 'st_menu_navbar_side_color',
			array(
				'default'              => $defaults['st_menu_navbar_side_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_navbar_side_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_header_menu',
			'description' => 'ボーダー左右色',
			'settings'    => 'st_menu_navbar_side_color',
		) ) );

		$wp_customize->add_setting( 'st_menu_navbar_right_color',
			array(
				'default'              => $defaults['st_menu_navbar_right_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_navbar_right_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_header_menu',
			'description' => 'ボーダー右色',
			'settings'    => 'st_menu_navbar_right_color',
		) ) );

		$wp_customize->add_setting( 'st_menu_navbartextcolor',
			array(
				'default'              => $defaults['st_menu_navbartextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_navbartextcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_header_menu',
			'settings'    => 'st_menu_navbartextcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_navbarcolor_gradient',
			array(
				'default'           => $defaults['st_navbarcolor_gradient'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_navbarcolor_gradient',
			array(
				'section'     => 'st_panel_header_menu',
				'settings'    => 'st_navbarcolor_gradient',
				'label'       => 'グラデーションを横向きにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_menu_bold',
			array(
				'default'           => $defaults['st_menu_bold'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_menu_bold',
			array(
				'section'     => 'st_panel_header_menu',
				'settings'    => 'st_menu_bold',
				'label'       => '第一階層メニューを太字にする（サイドメニュー連動）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_menu_center',
			array(
				'default'           => $defaults['st_menu_center'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_menu_center',
			array(
				'section'     => 'st_panel_header_menu',
				'settings'    => 'st_menu_center',
				'label'       => 'メニューをセンター寄せにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_menu100',
			array(
				'default'           => $defaults['st_menu100'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_menu100',
			array(
				'section'     => 'st_panel_header_menu',
				'settings'    => 'st_menu100',
				'label'       => 'メニューの横幅を100%にする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//メニューのパディング

		$wp_customize->add_setting( 'st_menu_padding',
			array(
				'default'           => $defaults['st_menu_padding'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_menu_padding',
			array(
				'section'     => 'st_panel_stmenus',
				'section'     => 'st_panel_header_menu',
				'label'       => '',
				'description' => 'メニューの上下に隙間を作る',
				'type'        => 'select',
				'choices'     => array(
					''         => __( '設定しない', 'default' ),
					'top10'    => __( '上に10pxの隙間', 'default' ),
					'bottom10' => __( '下に10pxの隙間', 'default' ),
				),
			) );

		//ドロップダウンメニュー背景

		$wp_customize->add_setting( 'st_menu_navbar_undercolor',
			array(
				'default'              => $defaults['st_menu_navbar_undercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_navbar_undercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_header_menu',
			'description' => '下層ドロップダウンメニュー背景色',
			'settings'    => 'st_menu_navbar_undercolor',
		) ) );

		//背景画像

		$wp_customize->add_setting( 'st_headermenu_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'headermenu_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_header_menu',
				'description' => '背景画像',
				'settings'    => 'st_headermenu_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_headermenu_bgimg_side',
			array(
				'default'           => $defaults['st_headermenu_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_headermenu_bgimg_side',
			array(
				'section'     => 'st_panel_header_menu',
				'settings'    => 'st_headermenu_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_headermenu_bgimg_top',
			array(
				'default'           => $defaults['st_headermenu_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_headermenu_bgimg_top',
			array(
				'section'     => 'st_panel_header_menu',
				'settings'    => 'st_headermenu_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_headermenu_bgimg_repeat',
			array(
				'default'           => $defaults['st_headermenu_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_headermenu_bgimg_repeat',
			array(
				'section'     => 'st_panel_header_menu',
				'settings'    => 'st_headermenu_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//固定ページサイドメニュー
		$wp_customize->add_section('st_panel_side_menu_widgets', array( // 中パネル
			'title' => 'サイドメニューウィジェット',
			'description' => 'ウィジェットにて「01_STINGERサイドバーメニュー」を挿入して表示されるメニューです。予め「メニュー」にて「サイド用メニュー」を設定してください。',
			'panel' => 'st_panel_stmenus',
		));

		$wp_customize->add_setting( 'st_menu_side_widgetscolor',
			array(
				'default'              => $defaults['st_menu_side_widgetscolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_side_widgetscolor', array(
			'label'       => __( 'サイドメニューウィジェット', 'default' ),
			'section'     => 'st_panel_side_menu_widgets',
			'description' => '背景色',
			'settings'    => 'st_menu_side_widgetscolor',
		) ) );

		$wp_customize->add_setting( 'st_menu_side_widgetscolor_t',
			array(
				'default'              => $defaults['st_menu_side_widgetscolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_side_widgetscolor_t', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_side_menu_widgets',
			'description' => '背景色（グラデーション上部）',
			'settings'    => 'st_menu_side_widgetscolor_t',
		) ) );

		$wp_customize->add_setting( 'st_menu_side_widgets_topunder_color',
			array(
				'default'              => $defaults['st_menu_side_widgets_topunder_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_side_widgets_topunder_color',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_side_menu_widgets',
				'description' => 'ボーダー色',
				'settings'    => 'st_menu_side_widgets_topunder_color',
			) ) );

		$wp_customize->add_setting( 'st_menu_side_widgetstextcolor',
			array(
				'default'              => $defaults['st_menu_side_widgetstextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_side_widgetstextcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_side_menu_widgets',
			'settings'    => 'st_menu_side_widgetstextcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_sidemenu_gradient',
			array(
				'default'           => $defaults['st_sidemenu_gradient'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_sidemenu_gradient',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_gradient',
				'label'       => 'グラデーションを横向きにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//Webアイコン

		$wp_customize->add_setting( 'st_menu_icon',
			array(
				'default'           => $defaults['st_menu_icon'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_menu_icon',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_menu_icon',
				'label'       => __( '', 'default' ),
				'description' => '第一階層Webアイコン',
				'type'        => 'select',
				'choices'     => array(
					''     => __( '設定しない', 'default' ),
					'f054' => __( '矢印1', 'default' ),
					'f105' => __( '矢印2', 'default' ),
					'f138' => __( '矢印3', 'default' ),
					'f0a9' => __( '矢印4', 'default' ),
					'f0da' => __( '矢印5', 'default' ),
					'f152' => __( '矢印6', 'default' ),
					'f18e' => __( '矢印7', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_menu_icon_color',
			array(
				'default'              => $defaults['st_menu_icon_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_icon_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'アイコン色',
			'section'     => 'st_panel_side_menu_widgets',
			'settings'    => 'st_menu_icon_color',
		) ) );

		$wp_customize->add_setting( 'st_undermenu_icon',
			array(
				'default'           => $defaults['st_undermenu_icon'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_undermenu_icon',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_undermenu_icon',
				'label'       => '',
				'description' => '第二階層以下Webアイコン',
				'type'        => 'select',
				'choices'     => array(
					''     => __( '設定しない', 'default' ),
					'f054' => __( '矢印1', 'default' ),
					'f105' => __( '矢印2', 'default' ),
					'f138' => __( '矢印3', 'default' ),
					'f0a9' => __( '矢印4', 'default' ),
					'f0da' => __( '矢印5', 'default' ),
					'f152' => __( '矢印6', 'default' ),
					'f18e' => __( '矢印7', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_undermenu_icon_color',
			array(
				'default'              => $defaults['st_undermenu_icon_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_undermenu_icon_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'アイコン色',
			'section'     => 'st_panel_side_menu_widgets',
			'settings'    => 'st_undermenu_icon_color',
		) ) );

		//背景画像

		$wp_customize->add_setting( 'st_sidemenu_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'sidemenu_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_side_menu_widgets',
				'description' => '第一階層背景画像',
				'settings'    => 'st_sidemenu_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_sidemenu_bgimg_side',
			array(
				'default'           => $defaults['st_sidemenu_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_sidemenu_bgimg_side',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_sidemenu_bgimg_top',
			array(
				'default'           => $defaults['st_sidemenu_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_sidemenu_bgimg_top',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_sidemenu_bgimg_repeat',
			array(
				'default'           => $defaults['st_sidemenu_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_sidemenu_bgimg_repeat',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_sidemenu_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_sidemenu_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_sidemenu_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_sidemenu_bgimg_tupadding',
			array(
				'default'           => $defaults['st_sidemenu_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_sidemenu_tupadding_c',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_sidemenu_fontsize',
			array(
				'default'           => $defaults['st_sidemenu_fontsize'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_sidemenu_fontsize',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_fontsize',
				'label'       => '第一階層メニューの文字サイズを大きくする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//第二階層以下
		$wp_customize->add_setting( 'st_sidemenu_accordion',
			array(
				'default'           => $defaults['st_sidemenu_accordion'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_sidemenu_accordion',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidemenu_accordion',
				'label'       => '第二階層以下をスライドメニューにする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_menu_pagelist_childtextcolor',
			array(
				'default'              => $defaults['st_menu_pagelist_childtextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_pagelist_childtextcolor',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_side_menu_widgets',
				'description' => '第二階層の文字色',
				'settings'    => 'st_menu_pagelist_childtextcolor',
			) ) );

		$wp_customize->add_setting( 'st_menu_pagelist_childtext_border_color',
			array(
				'default'              => $defaults['st_menu_pagelist_childtext_border_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_pagelist_childtext_border_color',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_side_menu_widgets',
				'description' => '第二階層の下線色',
				'settings'    => 'st_menu_pagelist_childtext_border_color',
			) ) );

		$wp_customize->add_setting( 'st_menu_pagelist_bgcolor',
			array(
				'default'              => $defaults['st_menu_pagelist_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_pagelist_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_side_menu_widgets',
			'settings'    => 'st_menu_pagelist_bgcolor',
		) ) );

		//背景画像

		$wp_customize->add_setting( 'st_sidebg_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'sidebg_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_side_menu_widgets',
				'description' => 'サイドメニュー全体の背景画像',
				'settings'    => 'st_sidebg_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_sidebg_bgimg_side',
			array(
				'default'           => $defaults['st_sidebg_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_sidebg_bgimg_side',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidebg_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_sidebg_bgimg_top',
			array(
				'default'           => $defaults['st_sidebg_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_sidebg_bgimg_top',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidebg_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_sidebg_bgimg_repeat',
			array(
				'default'           => $defaults['st_sidebg_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_sidebg_bgimg_repeat',
			array(
				'section'     => 'st_panel_side_menu_widgets',
				'settings'    => 'st_sidebg_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//スマホ基本色
		$wp_customize->add_section('st_panel_sp_menu_slide', array( // 中パネル
			'title' => 'スマホスライドメニュー',
			'description' => '599px以下にて表示されるスライドメニューです。',
			'panel' => 'st_panel_stmenus',
		));

		$wp_customize->add_setting( 'st_menu_sumart_bg_color',
			array(
				'default'              => $defaults['st_menu_sumart_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumart_bg_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'スライドメニューボタン背景色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumart_bg_color',
		) ) );


		$wp_customize->add_setting( 'st_menu_sumartcolor',
			array(
				'default'              => $defaults['st_menu_sumartcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumartcolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'スライドメニューアイコン色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumartcolor',
		) ) );

		$wp_customize->add_setting( 'st_menu_smartbar_bg_color',
			array(
				'default'              => $defaults['st_menu_smartbar_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_smartbar_bg_color', array(
			'label'       => __( '' ),
			'description' => 'スライドメニューバー背景色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_smartbar_bg_color',
		) ) );
		
		$wp_customize->add_setting( 'st_menu_smartbar_bg_color_t',
			array(
				'default'              => $defaults['st_menu_smartbar_bg_color_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_smartbar_bg_color_t', array(
			'label'       => __( '' ),
			'description' => 'スライドメニューバー背景色（グラデーション上部※向きはヘッダーエリア連動）',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_smartbar_bg_color_t',
		) ) );

		//スライドメニューバー背景画像

		$wp_customize->add_setting( 'st_menu_smartbar_bg_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'sp_menubar_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_sp_menu_slide',
				'description' => 'スライドメニューバー背景画像',
				'settings'    => 'st_menu_smartbar_bg_image',
			)
		) );

		$wp_customize->add_setting( 'st_menu_smartbar_bg_image_side',
			array(
				'default'           => $defaults['st_menu_smartbar_bg_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_menu_smartbar_bg_image_side',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_menu_smartbar_bg_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_menu_smartbar_bg_image_top',
			array(
				'default'           => $defaults['st_menu_smartbar_bg_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_menu_smartbar_bg_image_top',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_menu_smartbar_bg_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_menu_smartbar_bg_image_repeat',
			array(
				'default'           => $defaults['st_menu_smartbar_bg_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_menu_smartbar_bg_image_repeat',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_menu_smartbar_bg_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//スマホメニュー文字色

		$wp_customize->add_setting( 'st_menu_sumartmenutextcolor',
			array(
				'default'              => $defaults['st_menu_sumartmenutextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumartmenutextcolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'スライドメニュー内のテキストリンク色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumartmenutextcolor',
		) ) );

		$wp_customize->add_setting( 'st_menu_sumartmenubordercolor',
			array(
				'default'              => $defaults['st_menu_sumartmenubordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumartmenubordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'スライドメニュー内リンクのボーダー色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumartmenubordercolor',
		) ) );
		
		$wp_customize->add_setting( 'st_menu_sumartbar_bg_color',
			array(
				'default'              => $defaults['st_menu_sumartbar_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumartbar_bg_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'スライドメニュー内背景色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumartbar_bg_color',
		) ) );

		//スライドメニュー内背景画像

		$wp_customize->add_setting( 'st_slidemenubg_image',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'slidemenu_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_sp_menu_slide',
				'description' => 'スライドメニュー内に配置する背景画像です',
				'settings'    => 'st_slidemenubg_image',
			)
		) );

		$wp_customize->add_setting( 'st_slidemenubg_image_side',
			array(
				'default'           => $defaults['st_slidemenubg_image_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_slidemenubg_image_side',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_slidemenubg_image_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_slidemenubg_image_top',
			array(
				'default'           => $defaults['st_slidemenubg_image_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_slidemenubg_image_top',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_slidemenubg_image_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_slidemenubg_image_repeat',
			array(
				'default'           => $defaults['st_slidemenubg_image_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_slidemenubg_image_repeat',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_slidemenubg_image_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_slidemenubg_image_flex',
			array(
				'default'           => $defaults['st_slidemenubg_image_flex'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_slidemenubg_image_flex',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_slidemenubg_image_flex',
				'label'       => '背景画像を幅100%のレスポンシブにする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_menu_faicon',
			array(
				'default'           => $defaults['st_menu_faicon'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_menu_faicon',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_menu_faicon',
				'label'       => 'メニューのWebアイコンを非表示',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*スライドメニューのfix*/
		$wp_customize->add_setting( 'st_sticky_menu',
			array(
				'default'           => $defaults['st_sticky_menu'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_sticky_menu',
			array(
				'section'     => 'st_panel_sp_menu_slide',
				'settings'    => 'st_sticky_menu',
				'label'       => '表示パターン',
				'description' => '',
				'type'        => 'radio',
				'choices'     => array(
					''      => '通常',
					'fixed' => '固定',
					'1'     => 'スクロール追尾',
				),
			) );

		/*追加メニュー1*/
		$wp_customize->add_setting( 'st_menu_sumart_st_color',
			array(
				'default'              => $defaults['st_menu_sumart_st_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumart_st_color', array(
			'label'       => __( 'スマホ追加メニュー', 'default' ),
			'description' => 'メニューアイコン色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumart_st_color',
		) ) );

		$wp_customize->add_setting( 'st_menu_sumart_st_bg_color',
			array(
				'default'              => $defaults['st_menu_sumart_st_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumart_st_bg_color', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumart_st_bg_color',
		) ) );

		/*追加メニュー2*/
		$wp_customize->add_setting( 'st_menu_sumart_st2_color',
			array(
				'default'              => $defaults['st_menu_sumart_st2_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumart_st2_color', array(
			'label'       => __( 'スマホ追加メニュー2', 'default' ),
			'description' => 'メニューアイコン色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumart_st2_color',
		) ) );

		$wp_customize->add_setting( 'st_menu_sumart_st2_bg_color',
			array(
				'default'              => $defaults['st_menu_sumart_st2_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumart_st2_bg_color', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_sp_menu_slide',
			'settings'    => 'st_menu_sumart_st2_bg_color',
		) ) );
		
		/*スマホミドルメニュー*/
		$wp_customize->add_section('st_panel_sp_menu_middle', array( // 中パネル
			'title' => 'スマホミドル / 横列メニュー',
			'description' => '※PHPによる分岐の為、カスタマイザーでは表示されません',
			'panel' => 'st_panel_stmenus',
		));

		$wp_customize->add_setting( 'st_middle_sumartmenutextcolor',
			array(
				'default'              => $defaults['st_middle_sumartmenutextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_middle_sumartmenutextcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_sp_menu_middle',
			'settings'    => 'st_middle_sumartmenutextcolor',
		) ) );

		$wp_customize->add_setting( 'st_middle_sumart_bg_color',
			array(
				'default'              => $defaults['st_middle_sumart_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_middle_sumart_bg_color', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_sp_menu_middle',
			'settings'    => 'st_middle_sumart_bg_color',
		) ) );
		
		$wp_customize->add_setting( 'st_middle_sumart_bg_color_t',
			array(
				'default'              => $defaults['st_middle_sumart_bg_color_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_middle_sumart_bg_color_t', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色（グラデーション上部※向きはヘッダーエリア連動）',
			'section'     => 'st_panel_sp_menu_middle',
			'settings'    => 'st_middle_sumart_bg_color_t',
		) ) );
		
		$wp_customize->add_setting( 'st_middle_sumartmenubordercolor',
			array(
				'default'              => $defaults['st_middle_sumartmenubordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_middle_sumartmenubordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色（ミドルのみ）',
			'section'     => 'st_panel_sp_menu_middle',
			'settings'    => 'st_middle_sumartmenubordercolor',
		) ) );

		$wp_customize->add_setting( 'st_middle_sumartmenu_space',
			array(
				'default'           => $defaults['st_middle_sumartmenu_space'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_middle_sumartmenu_space',
			array(
				'section'     => 'st_panel_sp_menu_middle',
				'settings'    => 'st_middle_sumartmenu_space',
				'label'       => '周りに余白（ミドルのみ）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*スマホフッターメニュー*/
		$wp_customize->add_section('st_panel_sp_menu_footer', array( // 中パネル
			'title' => 'スマホフッターメニュー',
			'description' => '※PHPによる分岐の為、カスタマイザーでは表示されません',
			'panel' => 'st_panel_stmenus',
		));

		$wp_customize->add_setting( 'st_menu_sumart_footermenu_text_color',
			array(
				'default'              => $defaults['st_menu_sumart_footermenu_text_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumart_footermenu_text_color', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_sp_menu_footer',
			'settings'    => 'st_menu_sumart_footermenu_text_color',
		) ) );

		$wp_customize->add_setting( 'st_menu_sumart_footermenu_bg_color',
			array(
				'default'              => $defaults['st_menu_sumart_footermenu_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_sumart_footermenu_bg_color', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_sp_menu_footer',
			'settings'    => 'st_menu_sumart_footermenu_bg_color',
		) ) );

		if ( st_is_ver_ex_af() ):
		/*ガイドメニュー*/
		$wp_customize->add_section('st_panel_menu_guide', array( // 中パネル
			'title' => 'ガイドメニュー',
			'panel' => 'st_panel_stmenus',
		));

		$wp_customize->add_setting( 'st_guidemenu_bg_color',
			array(
				'default'              => $defaults['st_guidemenu_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_guidemenu_bg_color', array(
			'label'       => __( 'ガイドメニュー', 'default' ),
			'description' => '背景色（第一階層）',
			'section'     => 'st_panel_menu_guide',
			'settings'    => 'st_guidemenu_bg_color',
		) ) );

		$wp_customize->add_setting( 'st_guidemenu_radius',
			array(
				'default'           => $defaults['st_guidemenu_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_guidemenu_radius',
			array(
				'section'     => 'st_panel_menu_guide',
				'settings'    => 'st_guidemenu_radius',
				'label'       => '角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_guidemenutextcolor',
			array(
				'default'              => $defaults['st_guidemenutextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_guidemenutextcolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'テキスト色（第一階層）',
			'section'     => 'st_panel_menu_guide',
			'settings'    => 'st_guidemenutextcolor',
		) ) );

		$wp_customize->add_setting( 'st_guidemenutextcolor2',
			array(
				'default'              => $defaults['st_guidemenutextcolor2'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_guidemenutextcolor2', array(
			'label'       => __( '', 'default' ),
			'description' => 'テキスト色（第二階層以下）',
			'section'     => 'st_panel_menu_guide',
			'settings'    => 'st_guidemenutextcolor2',
		) ) );

		$wp_customize->add_setting( 'st_guide_bg_color',
			array(
				'default'              => $defaults['st_guide_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_guide_bg_color', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色（記事内用タグのみ）',
			'section'     => 'st_panel_menu_guide',
			'settings'    => 'st_guide_bg_color',
		) ) );
		endif;

		/*-------------------------------------------------------
		各見出し
		-------------------------------------------------------*/

		$wp_customize->add_panel( 'st_panel_tagcolors',
			array(
				'title'       => __( '[+] 各テキストとhタグ（見出し）', 'default' ),
				'priority'    => 101,
			) );

		$wp_customize->add_section('color_controls_tagcolors', array( // カラー
    		'title' => 'カラーパレット',
    		'panel' => 'st_panel_tagcolors',
  		));
		_st_customization_add_color_controls( $wp_customize, 'color_controls_tagcolors' );

		$wp_customize->add_section('st_panel_entrytitle', array( // 中パネル
			'title' => '記事タイトル',
			'panel' => 'st_panel_tagcolors',
		));

		/*記事タイトル*/

		$wp_customize->add_setting( 'st_entrytitle_color',
			array(
				'default'              => $defaults['st_entrytitle_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_entrytitle_color', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_entrytitle',
			'settings'    => 'st_entrytitle_color',
		) ) );

		$wp_customize->add_setting( 'st_entrytitle_bgcolor',
			array(
				'default'              => $defaults['st_entrytitle_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_entrytitle_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_entrytitle',
			'settings'    => 'st_entrytitle_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_entrytitle_bgcolor_t',
			array(
				'default'              => $defaults['st_entrytitle_bgcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_entrytitle_bgcolor_t', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色（グラデーション上部）',
			'section'     => 'st_panel_entrytitle',
			'settings'    => 'st_entrytitle_bgcolor_t',
		) ) );

		$wp_customize->add_setting( 'st_entrytitleborder_color',
			array(
				'default'              => $defaults['st_entrytitleborder_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_entrytitleborder_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_entrytitle',
			'settings'    => 'st_entrytitleborder_color',
		) ) );

		$wp_customize->add_setting( 'st_entrytitleborder_undercolor',
			array(
				'default'              => $defaults['st_entrytitleborder_undercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_entrytitleborder_undercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色（サブ）',
			'section'     => 'st_panel_entrytitle',
			'settings'    => 'st_entrytitleborder_undercolor',
		) ) );

		$wp_customize->add_setting( 'st_entrytitle_border_tb',
			array(
				'default'           => $defaults['st_entrytitle_border_tb'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_border_tb',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_border_tb',
				'label'       => ' ボーダーを上下のみにする ',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_entrytitle_border_tb_sub',
			array(
				'default'           => $defaults['st_entrytitle_border_tb_sub'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_border_tb_sub',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_border_tb_sub',
				'label'       => 'ボーダー上を太くする（下をサブカラーに）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		if ( st_is_ver_ex() ):
			$wp_customize->add_setting( 'st_entrytitle_designsetting',
				array(
					'default'           => $defaults['st_entrytitle_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_entrytitle_designsetting',
				array(
					'section'     => 'st_panel_entrytitle',
					'settings'    => 'st_entrytitle_designsetting',
					'label'       => '',
					'description' => 'タイトルの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'hukidasidesign_under'       => __( '吹き出し下線デザインに変更', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
		else:
			$wp_customize->add_setting( 'st_entrytitle_designsetting',
				array(
					'default'           => $defaults['st_entrytitle_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_entrytitle_designsetting',
				array(
					'section'     => 'st_panel_entrytitle',
					'settings'    => 'st_entrytitle_designsetting',
					'label'       => '',
					'description' => 'タイトルの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
		endif;

		$wp_customize->add_setting( 'st_entrytitle_text_center',
			array(
				'default'           => $defaults['st_entrytitle_text_center'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_text_center',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_text_center',
				'label'       => 'テキストを中央寄せ',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
		$wp_customize->add_setting( 'st_entrytitle_design_wide',
			array(
				'default'           => $defaults['st_entrytitle_design_wide'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_design_wide',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_design_wide',
				'label'       => 'デザインを幅一杯に',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_entrytitle_bg_radius',
			array(
				'default'           => $defaults['st_entrytitle_bg_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_bg_radius',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_bg_radius',
				'label'       => '背景や吹き出しの角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
		$wp_customize->add_setting( 'st_entrytitle_gradient',
			array(
				'default'           => $defaults['st_entrytitle_gradient'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_gradient',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_gradient',
				'label'       => 'グラデーションを横向きにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//背景画像

		$wp_customize->add_setting( 'st_entrytitle_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'entrytitle_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_entrytitle',
				'description' => '背景画像',
				'settings'    => 'st_entrytitle_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_entrytitle_bgimg_side',
			array(
				'default'           => $defaults['st_entrytitle_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_entrytitle_bgimg_side',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_entrytitle_bgimg_top',
			array(
				'default'           => $defaults['st_entrytitle_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_entrytitle_bgimg_top',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_entrytitle_bgimg_repeat',
			array(
				'default'           => $defaults['st_entrytitle_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_bgimg_repeat',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_entrytitle_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_entrytitle_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_entrytitle_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_entrytitle_bgimg_tupadding',
			array(
				'default'           => $defaults['st_entrytitle_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_entrytitle_tupadding_c',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_entrytitle_no_css',
			array(
				'default'           => $defaults['st_entrytitle_no_css'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_entrytitle_no_css',
			array(
				'section'     => 'st_panel_entrytitle',
				'settings'    => 'st_entrytitle_no_css',
				'label'       => 'カスタマイザーのCSSを無効化',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*h2タグ*/
		$wp_customize->add_section('st_panel_h2', array( // 中パネル
			'title' => 'H2タグ',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_h2_color',
			array(
				'default'              => $defaults['st_h2_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h2_color', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_h2',
			'settings'    => 'st_h2_color',
		) ) );

		$wp_customize->add_setting( 'st_h2_bgcolor',
			array(
				'default'              => $defaults['st_h2_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h2_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_h2',
			'settings'    => 'st_h2_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_h2_bgcolor_t',
			array(
				'default'              => $defaults['st_h2_bgcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h2_bgcolor_t', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色（グラデーション上部）',
			'section'     => 'st_panel_h2',
			'settings'    => 'st_h2_bgcolor_t',
		) ) );

		$wp_customize->add_setting( 'st_h2border_color',
			array(
				'default'              => $defaults['st_h2border_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h2border_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_h2',
			'settings'    => 'st_h2border_color',
		) ) );

		$wp_customize->add_setting( 'st_h2border_undercolor',
			array(
				'default'              => $defaults['st_h2border_undercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h2border_undercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色（サブ）',
			'section'     => 'st_panel_h2',
			'settings'    => 'st_h2border_undercolor',
		) ) );

		$wp_customize->add_setting( 'st_h2_border_tb',
			array(
				'default'           => $defaults['st_h2_border_tb'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_border_tb',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_border_tb',
				'label'       => ' ボーダーを上下のみにする ',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_h2_border_tb_sub',
			array(
				'default'           => $defaults['st_h2_border_tb_sub'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_border_tb_sub',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_border_tb_sub',
				'label'       => 'ボーダー上を太くする（下をサブカラーに）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		if ( st_is_ver_ex() ):
			$wp_customize->add_setting( 'st_h2_designsetting',
				array(
					'default'           => $defaults['st_h2_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_h2_designsetting',
				array(
					'section'     => 'st_panel_h2',
					'settings'    => 'st_h2_designsetting',
					'label'       => '',
					'description' => 'h2タグの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'hukidasidesign_under'       => __( '吹き出し下線デザインに変更', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						'checkboxdesign'       => __( 'チェックボックスデザインに変更', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
		elseif ( st_is_ver_af() ):
			$wp_customize->add_setting( 'st_h2_designsetting',
				array(
					'default'           => $defaults['st_h2_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_h2_designsetting',
				array(
					'section'     => 'st_panel_h2',
					'settings'    => 'st_h2_designsetting',
					'label'       => '',
					'description' => 'h2タグの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						'checkboxdesign'       => __( 'チェックボックスデザインに変更', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
		else:
			$wp_customize->add_setting( 'st_h2_designsetting',
				array(
					'default'           => $defaults['st_h2_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_h2_designsetting',
				array(
					'section'     => 'st_panel_h2',
					'settings'    => 'st_h2_designsetting',
					'label'       => '',
					'description' => 'h2タグの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
			endif;

		$wp_customize->add_setting( 'st_h2_text_center',
			array(
				'default'           => $defaults['st_h2_text_center'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_text_center',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_text_center',
				'label'       => 'テキストを中央寄せ',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
		$wp_customize->add_setting( 'st_h2_design_wide',
			array(
				'default'           => $defaults['st_h2_design_wide'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_design_wide',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_design_wide',
				'label'       => 'デザインを幅一杯に',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h2_bg_radius',
			array(
				'default'           => $defaults['st_h2_bg_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_bg_radius',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_bg_radius',
				'label'       => '背景や吹き出しの角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
		$wp_customize->add_setting( 'st_h2_gradient',
			array(
				'default'           => $defaults['st_h2_gradient'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_gradient',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_gradient',
				'label'       => 'グラデーションを横向きにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//背景画像

		$wp_customize->add_setting( 'st_h2_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'h2_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_h2',
				'description' => '背景画像',
				'settings'    => 'st_h2_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_h2_bgimg_side',
			array(
				'default'           => $defaults['st_h2_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h2_bgimg_side',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h2_bgimg_top',
			array(
				'default'           => $defaults['st_h2_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h2_bgimg_top',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h2_bgimg_repeat',
			array(
				'default'           => $defaults['st_h2_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_bgimg_repeat',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h2_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_h2_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h2_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h2_bgimg_tupadding',
			array(
				'default'           => $defaults['st_h2_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h2_tupadding_c',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h2_no_css',
			array(
				'default'           => $defaults['st_h2_no_css'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h2_no_css',
			array(
				'section'     => 'st_panel_h2',
				'settings'    => 'st_h2_no_css',
				'label'       => 'カスタマイザーのCSSを無効化',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*h3タグ*/
		$wp_customize->add_section('st_panel_h3', array( // 中パネル
			'title' => 'H3タグ',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_h3_color',
			array(
				'default'              => $defaults['st_h3_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h3_color', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_h3',
			'settings'    => 'st_h3_color',
		) ) );

		$wp_customize->add_setting( 'st_h3_bgcolor',
			array(
				'default'              => $defaults['st_h3_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h3_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_h3',
			'settings'    => 'st_h3_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_h3_bgcolor_t',
			array(
				'default'              => $defaults['st_h3_bgcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h3_bgcolor_t', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色（グラデーション上部）',
			'section'     => 'st_panel_h3',
			'settings'    => 'st_h3_bgcolor_t',
		) ) );

		$wp_customize->add_setting( 'st_h3border_color',
			array(
				'default'              => $defaults['st_h3border_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h3border_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_h3',
			'settings'    => 'st_h3border_color',
		) ) );

		$wp_customize->add_setting( 'st_h3border_undercolor',
			array(
				'default'              => $defaults['st_h3border_undercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h3border_undercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色（サブ）',
			'section'     => 'st_panel_h3',
			'settings'    => 'st_h3border_undercolor',
		) ) );

		$wp_customize->add_setting( 'st_h3_border_tb',
			array(
				'default'           => $defaults['st_h3_border_tb'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_border_tb',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_border_tb',
				'label'       => ' ボーダーを上下のみにする ',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_h3_border_tb_sub',
			array(
				'default'           => $defaults['st_h3_border_tb_sub'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_border_tb_sub',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_border_tb_sub',
				'label'       => ' ボーダー上を太くする（下をサブカラーに） ',
				'description' => '',
				'type'        => 'checkbox',
			) );

		if ( st_is_ver_ex() ):
			$wp_customize->add_setting( 'st_h3_designsetting',
				array(
					'default'           => $defaults['st_h3_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_h3_designsetting',
				array(
					'section'     => 'st_panel_h3',
					'settings'    => 'st_h3_designsetting',
					'label'       => '',
					'description' => 'h3タグの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'hukidasidesign_under'       => __( '吹き出し下線デザインに変更', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						'checkboxdesign'       => __( 'チェックボックスデザインに変更', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
		elseif ( st_is_ver_af() ):
			$wp_customize->add_setting( 'st_h3_designsetting',
				array(
					'default'           => $defaults['st_h3_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_h3_designsetting',
				array(
					'section'     => 'st_panel_h3',
					'settings'    => 'st_h3_designsetting',
					'label'       => '',
					'description' => 'h3タグの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						'checkboxdesign'       => __( 'チェックボックスデザインに変更', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
		else:
			$wp_customize->add_setting( 'st_h3_designsetting',
				array(
					'default'           => $defaults['st_h3_designsetting'],
					'sanitize_callback' => 'st_sanitize_choices',
				) );
			$wp_customize->add_control( 'st_h3_designsetting',
				array(
					'section'     => 'st_panel_h3',
					'settings'    => 'st_h3_designsetting',
					'label'       => '',
					'description' => 'h3タグの基本スタイル',
					'type'        => 'radio',
					'choices'     => array(
						'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
						'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
						'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
						'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
						'centerlinedesign'     => __( 'センターラインに変更（※要ボーダー色）', '' ),
						'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
						'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
						'underdotdesign' => __( '破線アンダーラインに変更（※要ボーダー色）', '' ),
						'leftlinedesign'     => __( '左ラインデザインに変更（※要ボーダー色）', '' ),
						''             => __( 'なし', 'default' ),
					),
				) );
		endif;

		$wp_customize->add_setting( 'st_h3_text_center',
			array(
				'default'           => $defaults['st_h3_text_center'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_text_center',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_text_center',
				'label'       => 'テキストを中央寄せ',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
		$wp_customize->add_setting( 'st_h3_design_wide',
			array(
				'default'           => $defaults['st_h3_design_wide'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_design_wide',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_design_wide',
				'label'       => 'デザインを幅一杯に',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h3_bg_radius',
			array(
				'default'           => $defaults['st_h3_bg_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_bg_radius',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_bg_radius',
				'label'       => '背景や吹き出しの角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );
			
		$wp_customize->add_setting( 'st_h3_gradient',
			array(
				'default'           => $defaults['st_h3_gradient'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_gradient',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_gradient',
				'label'       => 'グラデーションを横向きにする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//背景画像

		$wp_customize->add_setting( 'st_h3_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'h3_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_h3',
				'description' => '背景画像',
				'settings'    => 'st_h3_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_h3_bgimg_side',
			array(
				'default'           => $defaults['st_h3_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h3_bgimg_side',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h3_bgimg_top',
			array(
				'default'           => $defaults['st_h3_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h3_bgimg_top',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h3_bgimg_repeat',
			array(
				'default'           => $defaults['st_h3_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_bgimg_repeat',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h3_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_h3_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h3_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h3_bgimg_tupadding',
			array(
				'default'           => $defaults['st_h3_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h3_tupadding_c',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h3_no_css',
			array(
				'default'           => $defaults['st_h3_no_css'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h3_no_css',
			array(
				'section'     => 'st_panel_h3',
				'settings'    => 'st_h3_no_css',
				'label'       => 'カスタマイザーのCSSを無効化',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*h4タグ*/
		$wp_customize->add_section('st_panel_h4', array( // 中パネル
			'title' => 'H4タグ',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_h4_textcolor',
			array(
				'default'              => $defaults['st_h4_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h4_textcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_h4',
			'settings'    => 'st_h4_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_h4bordercolor',
			array(
				'default'              => $defaults['st_h4bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h4bordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_h4',
			'settings'    => 'st_h4bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_h4bgcolor',
			array(
				'default'              => $defaults['st_h4bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h4bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_h4',
			'settings'    => 'st_h4bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_h4_design',
			array(
				'default'           => $defaults['st_h4_design'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_design_c',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_design',
				'label'       => '左ボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_top_border',
			array(
				'default'           => $defaults['st_h4_top_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_top_border_c',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_top_border',
				'label'       => '上にボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_bottom_border',
			array(
				'default'           => $defaults['st_h4_bottom_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_bottom_border_c',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_bottom_border',
				'label'       => '下にボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4hukidasi_design',
			array(
				'default'           => $defaults['st_h4hukidasi_design'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h4hukidasi_design',
			array(
			'section'     => 'st_panel_h4',
			'settings'    => 'st_h4hukidasi_design',
			'label'       => '',
			'description' => 'h4タグのスタイル指定',
			'type'        => 'radio',
			'choices'     => array(
				'hukidasidesign'             => __( '吹き出しデザインに変更（※要背景色）', 'default' ),
				'dogears'       => __( '耳折れデザインに変更（※要背景色）', '' ),
				''             => __( 'なし', 'default' ),
			),
		) );

		$wp_customize->add_setting( 'st_h4_bg_radius',
			array(
				'default'           => $defaults['st_h4_bg_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_bg_radius',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_bg_radius',
				'label'       => '背景や吹き出しの角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_h4_husen_shadow',
			array(
				'default'           => $defaults['st_h4_husen_shadow'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_husen_shadow_c',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_husen_shadow',
				'label'       => 'ふせん風の影をつける（※要背景色）',

				'description' => '',
				'type'        => 'checkbox',
			) );

		//背景画像

		$wp_customize->add_setting( 'st_h4_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'h4_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_h4',
				'description' => '背景画像',
				'settings'    => 'st_h4_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_h4_bgimg_side',
			array(
				'default'           => $defaults['st_h4_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h4_bgimg_side',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h4_bgimg_top',
			array(
				'default'           => $defaults['st_h4_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h4_bgimg_top',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h4_bgimg_repeat',
			array(
				'default'           => $defaults['st_h4_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_bgimg_repeat',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_h4_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h4_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h4_bgimg_tupadding',
			array(
				'default'           => $defaults['st_h4_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h4_tupadding_c',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h4_no_css',
			array(
				'default'           => $defaults['st_h4_no_css'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_no_css',
			array(
				'section'     => 'st_panel_h4',
				'settings'    => 'st_h4_no_css',
				'label'       => 'カスタマイザーのCSSを無効化',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*h5タグ*/
		$wp_customize->add_section('st_panel_h5', array( // 中パネル
			'title' => 'H5タグ',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_h5_textcolor',
			array(
				'default'              => $defaults['st_h5_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h5_textcolor', array(
			'label'       => __( 'H5タグ', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_h5',
			'settings'    => 'st_h5_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_h5bordercolor',
			array(
				'default'              => $defaults['st_h5bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h5bordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_h5',
			'settings'    => 'st_h5bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_h5bgcolor',
			array(
				'default'              => $defaults['st_h5bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h5bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_h5',
			'settings'    => 'st_h5bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_h5_design',
			array(
				'default'           => $defaults['st_h5_design'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h5_design_c',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_design',
				'label'       => '左ボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h5_top_border',
			array(
				'default'           => $defaults['st_h5_top_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h5_top_border_c',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_top_border',
				'label'       => '上にボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h5_bottom_border',
			array(
				'default'           => $defaults['st_h5_bottom_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h5_bottom_border_c',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_bottom_border',
				'label'       => '下にボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h5hukidasi_design',
			array(
				'default'           => $defaults['st_h5hukidasi_design'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h5hukidasi_design',
			array(
			'section'     => 'st_panel_h5',
			'settings'    => 'st_h5hukidasi_design',
			'label'       => '',
			'description' => 'h5タグのスタイル指定',
			'type'        => 'radio',
			'choices'     => array(
				'hukidasidesign'             => __( '吹き出しデザインに変更（※要背景色）', 'default' ),
				'dogears'       => __( '耳折れデザインに変更（※要背景色）', '' ),
				''             => __( 'なし', 'default' ),
			),
		) );

		$wp_customize->add_setting( 'st_h5_bg_radius',
			array(
				'default'           => $defaults['st_h5_bg_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h5_bg_radius',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_bg_radius',
				'label'       => '背景や吹き出しの角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_h5_husen_shadow',
			array(
				'default'           => $defaults['st_h5_husen_shadow'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h5_husen_shadow_c',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_husen_shadow',
				'label'       => 'ふせん風の影をつける（※要背景色）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//背景画像

		$wp_customize->add_setting( 'st_h5_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'h5_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_h5',
				'description' => '背景画像',
				'settings'    => 'st_h5_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_h5_bgimg_side',
			array(
				'default'           => $defaults['st_h5_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h5_bgimg_side',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h5_bgimg_top',
			array(
				'default'           => $defaults['st_h5_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h5_bgimg_top',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h5_bgimg_repeat',
			array(
				'default'           => $defaults['st_h5_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h5_bgimg_repeat',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h5_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_h5_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h5_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h5_bgimg_tupadding',
			array(
				'default'           => $defaults['st_h5_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h5_tupadding_c',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h5_no_css',
			array(
				'default'           => $defaults['st_h5_no_css'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h5_no_css',
			array(
				'section'     => 'st_panel_h5',
				'settings'    => 'st_h5_no_css',
				'label'       => 'カスタマイザーのCSSを無効化',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*h4（まとめ）タグ*/
		$wp_customize->add_section('st_panel_h4_matome', array( // 中パネル
			'title' => 'まとめタグ',
			'panel' => 'st_panel_tagcolors',
		));


		$wp_customize->add_setting( 'st_h4_matome_textcolor',
			array(
				'default'              => $defaults['st_h4_matome_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h4_matome_textcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_h4_matome',
			'settings'    => 'st_h4_matome_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_h4_matome_bordercolor',
			array(
				'default'              => $defaults['st_h4_matome_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h4_matome_bordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_h4_matome',
			'settings'    => 'st_h4_matome_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_h4_matome_bgcolor',
			array(
				'default'              => $defaults['st_h4_matome_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_h4_matome_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_h4_matome',
			'settings'    => 'st_h4_matome_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_h4_matome_design',
			array(
				'default'           => $defaults['st_h4_matome_design'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_matome_design_c',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_design',
				'label'       => '左ボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_matome_top_border',
			array(
				'default'           => $defaults['st_h4_matome_top_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_matome_top_border_c',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_top_border',
				'label'       => '上にボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_matome_bottom_border',
			array(
				'default'           => $defaults['st_h4_matome_bottom_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_matome_bottom_border_c',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_bottom_border',
				'label'       => '下にボーダーを付ける',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_matome_hukidasi_design',
			array(
				'default'           => $defaults['st_h4_matome_hukidasi_design'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_matome_hukidasi_design',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_hukidasi_design',
				'label'       => '吹き出しデザインに変更（※要背景色）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_matome_bg_radius',
			array(
				'default'           => $defaults['st_h4_matome_bg_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_matome_bg_radius',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_bg_radius',
				'label'       => '背景や吹き出しの角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//背景画像

		$wp_customize->add_setting( 'st_h4_matome_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',


				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'h4_matome_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_h4_matome',
				'description' => '背景画像',
				'settings'    => 'st_h4_matome_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_h4_matome_bgimg_side',
			array(
				'default'           => $defaults['st_h4_matome_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h4_matome_bgimg_side',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h4_matome_bgimg_top',
			array(
				'default'           => $defaults['st_h4_matome_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_h4_matome_bgimg_top',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_h4_matome_bgimg_repeat',
			array(
				'default'           => $defaults['st_h4_matome_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_matome_bgimg_repeat',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_h4_matome_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_h4_matome_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h4_matome_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h4_matome_bgimg_tupadding',
			array(
				'default'           => $defaults['st_h4_matome_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_h4_matome_tupadding_c',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_h4_matome_no_css',
			array(
				'default'           => $defaults['st_h4_matome_no_css'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_h4_matome_no_css',
			array(
				'section'     => 'st_panel_h4_matome',
				'settings'    => 'st_h4_matome_no_css',
				'label'       => 'カスタマイザーのCSSを無効化',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*ウィジェットタイトル（サイドバー）*/
		$wp_customize->add_section('st_panel_widgets_title', array( // 中パネル
			'title' => 'ウィジェットタイトル（サイドバー）',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_widgets_title_color',
			array(
				'default'              => $defaults['st_widgets_title_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_widgets_title_color', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_widgets_title',
			'settings'    => 'st_widgets_title_color',
		) ) );


		$wp_customize->add_setting( 'st_widgets_title_bgcolor',
			array(
				'default'              => $defaults['st_widgets_title_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_widgets_title_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_widgets_title',
			'settings'    => 'st_widgets_title_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_widgets_title_bgcolor_t',
			array(
				'default'              => $defaults['st_widgets_title_bgcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_widgets_title_bgcolor_t', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色（グラデーション上部）',
			'section'     => 'st_panel_widgets_title',
			'settings'    => 'st_widgets_title_bgcolor_t',
		) ) );

		$wp_customize->add_setting( 'st_widgets_titleborder_color',
			array(
				'default'              => $defaults['st_widgets_titleborder_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_widgets_titleborder_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_widgets_title',
			'settings'    => 'st_widgets_titleborder_color',
		) ) );

		$wp_customize->add_setting( 'st_widgets_titleborder_undercolor',
			array(
				'default'              => $defaults['st_widgets_titleborder_undercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_widgets_titleborder_undercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色（サブ）',
			'section'     => 'st_panel_widgets_title',
			'settings'    => 'st_widgets_titleborder_undercolor',
		) ) );


		$wp_customize->add_setting( 'st_widgets_title_designsetting',
			array(
				'default'           => $defaults['st_widgets_title_designsetting'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_widgets_title_designsetting',
			array(
				'section'     => 'st_panel_widgets_title',
				'settings'    => 'st_widgets_title_designsetting',
				'label'       => '',
				'description' => 'ウィジェットタイトルの基本スタイル',
				'type'        => 'radio',
				'choices'     => array(
					'hukidasidesign'       => __( '吹き出しデザインに変更（※要背景色）', '' ),
					'leftlinedesign' => __( '左ラインに変更（※要ボーダー色）', '' ),
					'linedesign'     => __( '囲み&左ラインデザインに変更（※要ボーダー色）', '' ),
					'underlinedesign'     => __( '2色アンダーラインに変更（※要ボーダー色）', '' ),
					'gradient_underlinedesign'     => __( 'グラデーションアンダーラインに変更（※要ボーダー色）', '' ),
					'dotdesign' => __( '囲みドットデザインに変更（※要ボーダー色）', '' ),
					'stripe_design' => __( 'ストライプデザインに変更（※要背景色）', '' ),
					''             => __( 'なし', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_widgets_title_bg_radius',
			array(
				'default'           => $defaults['st_widgets_title_bg_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_widgets_title_bg_radius',
			array(
				'section'     => 'st_panel_widgets_title',
				'settings'    => 'st_widgets_title_bg_radius',
				'label'       => '背景や吹き出しの角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		//背景画像

		$wp_customize->add_setting( 'st_widgets_title_bgimg',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'widgets_title_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_widgets_title',
				'description' => '背景画像',
				'settings'    => 'st_widgets_title_bgimg',
			)
		) );

		$wp_customize->add_setting( 'st_widgets_title_bgimg_side',
			array(
				'default'           => $defaults['st_widgets_title_bgimg_side'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_widgets_title_bgimg_side',
			array(
				'section'     => 'st_panel_widgets_title',
				'settings'    => 'st_widgets_title_bgimg_side',
				'label'       => '',
				'description' => '背景画像の横位置',
				'type'        => 'radio',
				'choices'     => array(
					'left'   => __( '左', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'right'  => __( '右', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_widgets_title_bgimg_top',
			array(
				'default'           => $defaults['st_widgets_title_bgimg_top'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_widgets_title_bgimg_top',
			array(
				'section'     => 'st_panel_widgets_title',
				'settings'    => 'st_widgets_title_bgimg_top',
				'label'       => '',
				'description' => '背景画像の縦位置',
				'type'        => 'radio',
				'choices'     => array(
					'top'    => __( '上', 'default' ),
					'center' => __( '真ん中', 'default' ),
					'bottom' => __( '下', 'default' ),
				),
			) );

		$wp_customize->add_setting( 'st_widgets_title_bgimg_repeat',
			array(
				'default'           => $defaults['st_widgets_title_bgimg_repeat'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_widgets_title_bgimg_repeat',
			array(
				'section'     => 'st_panel_widgets_title',
				'settings'    => 'st_widgets_title_bgimg_repeat',
				'label'       => '背景画像を繰り返さない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_widgets_title_bgimg_leftpadding',
			array(
				'default'           => $defaults['st_widgets_title_bgimg_leftpadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_widgets_title_bgimg_leftpadding_c',
			array(
				'section'     => 'st_panel_widgets_title',
				'settings'    => 'st_widgets_title_bgimg_leftpadding',
				'label'       => '',
				'description' => '左の余白（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_widgets_title_bgimg_tupadding',
			array(
				'default'           => $defaults['st_widgets_title_bgimg_tupadding'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_widgets_title_tupadding_c',
			array(
				'section'     => 'st_panel_widgets_title',
				'settings'    => 'st_widgets_title_bgimg_tupadding',
				'label'       => '',
				'description' => '上下の余白（px）',
				'type'        => 'option',
			) );


		/*カテゴリ*/
		$wp_customize->add_section('st_panel_catlink', array( // 中パネル
			'title' => 'カテゴリ',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_catbg_color',
			array(
				'default'              => $defaults['st_catbg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_catbg_color', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_catlink',
			'settings'    => 'st_catbg_color',
		) ) );

		$wp_customize->add_setting( 'st_cattext_color',
			array(
				'default'              => $defaults['st_cattext_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_cattext_color', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_catlink',
			'settings'    => 'st_cattext_color',
		) ) );

		$wp_customize->add_setting( 'st_cattext_radius',
			array(
				'default'           => $defaults['st_cattext_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_cattext_radius',
			array(
				'section'     => 'st_panel_catlink',
				'settings'    => 'st_cattext_radius',
				'label'       => '角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*投稿日時・ぱんくず・タグ*/
		$wp_customize->add_section('st_panel_kuzu', array( // 中パネル
			'title' => '投稿日時・ぱんくず・タグ',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_kuzu_color',
			array(
				'default'              => $defaults['st_kuzu_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kuzu_color', array(
			'label'       => __( '投稿日時・ぱんくず・タグ', 'default' ),
			'description' => 'テキスト色',
			'section'     => 'st_panel_kuzu',
			'settings'    => 'st_kuzu_color',
		) ) );

		/*引用*/
		$wp_customize->add_section('st_panel_blockquote', array( // 中パネル
			'title' => '引用部分の背景色',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_blockquote_color',
			array(
				'default'              => $defaults['st_blockquote_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_blockquote_color', array(
			'label'    => __( '', 'default' ),
			'section'  => 'st_panel_blockquote',
			'settings' => 'st_blockquote_color',
		) ) );

		/*NEW及び関連記事*/
		$wp_customize->add_section('st_panel_new_entry', array( // 中パネル
			'title' => 'NEW ENTRY & 関連記事',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_separator_bgcolor',
			array(
				'default'              => $defaults['st_separator_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_separator_bgcolor', array(
			'label'       => __( 'NEW ENTRY & 関連記事', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_new_entry',
			'settings'    => 'st_separator_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_separator_color',
			array(
				'default'              => $defaults['st_separator_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_separator_color', array(
			'label'       => __( '', 'default' ),
			'description' => '文字色',
			'section'     => 'st_panel_new_entry',
			'settings'    => 'st_separator_color',
		) ) );

		/*タグクラウド*/
		$wp_customize->add_section('st_panel_tagcloud', array( // 中パネル
			'title' => 'タグクラウド',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_tagcloud_color',
			array(
				'default'              => $defaults['st_tagcloud_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_tagcloud_color', array(
			'label'       => __( '', 'default' ),
			'description' => 'テキスト色',
			'section'     => 'st_panel_tagcloud',
			'settings'    => 'st_tagcloud_color',
		) ) );

		$wp_customize->add_setting( 'st_tagcloud_bordercolor',
			array(
				'default'              => $defaults['st_tagcloud_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_tagcloud_bordercolor', array(
			'label'       => __( '', 'default' ),
			'description' => 'ボーダー色',
			'section'     => 'st_panel_tagcloud',
			'settings'    => 'st_tagcloud_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_tagcloud_bgcolor',
			array(
				'default'              => $defaults['st_tagcloud_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_tagcloud_bgcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '背景色',
			'section'     => 'st_panel_tagcloud',
			'settings'    => 'st_tagcloud_bgcolor',
		) ) );

		/*記事内テキスト*/
		$wp_customize->add_section('st_panel_main_textcolor', array( // 中パネル
			'title' => 'テキスト色一括変更',
			'panel' => 'st_panel_tagcolors',
		));

		$wp_customize->add_setting( 'st_main_textcolor',
			array(
				'default'              => $defaults['st_main_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_main_textcolor', array(
			'label'       => __( '', 'default' ),
			'description' => '記事内のテキストなど※一括変更は注意して御利用下さい（白背景に白文字が適応されると読めなくなります）',
			'section'     => 'st_panel_main_textcolor',
			'settings'    => 'st_main_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_main_textcolor_sub',
			array(
				'default'           => $defaults['st_main_textcolor_sub'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_main_textcolor_sub',
			array(
				'section'     => 'st_panel_main_textcolor',
				'settings'    => 'st_main_textcolor_sub',
				'label'       => '範囲を広げる（記事タイトル・抜粋など）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*記事内リンク色*/

		$wp_customize->add_setting( 'st_link_textcolor',
			array(
				'default'              => $defaults['st_link_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_link_textcolor', array(
			'label'       => __( '記事内リンク色', 'default' ),
			'description' => '',
			'section'     => 'st_panel_main_textcolor',
			'settings'    => 'st_link_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_link_hovertextcolor',
			array(
				'default'              => $defaults['st_link_hovertextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_link_hovertextcolor', array(
			'label'       => __( '全てのリンクテキスト', 'default' ),
			'description' => 'マウスオーバー色',
			'section'     => 'st_panel_main_textcolor',
			'settings'    => 'st_link_hovertextcolor',
		) ) );

		$wp_customize->add_setting( 'st_link_hoveropacity',
			array(
				'default'           => $defaults['st_link_hoveropacity'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_link_hoveropacity',
			array(
				'section'     => 'st_panel_main_textcolor',
				'settings'    => 'st_link_hoveropacity',
				'label'       => 'マウスオーバー時に透明度を下げる',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*-------------------------------------------------------
		オプションカラー
		-------------------------------------------------------*/

		$wp_customize->add_panel( 'st_panel_optioncolors',
			array(
				'title'       => __( '[+] オプションカラー', 'default' ),
				'priority'    => 102,
			) );

		$wp_customize->add_section('color_controls_optioncolors', array( // カラー
    		'title' => 'カラーパレット',
    		'panel' => 'st_panel_optioncolors',
  		));
		_st_customization_add_color_controls( $wp_customize, 'color_controls_optioncolors' );

		/*記事内のWebアイコン*/
		$wp_customize->add_section('st_panel_webicon', array( // 中パネル
			'title' => '記事内のWebアイコン',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_webicon_question',
			array(
				'default'              => $defaults['st_webicon_question'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_question', array(
			'label'       => __( '', 'default' ),
			'description' => '[？] はてなマーク',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_question',
		) ) );

		$wp_customize->add_setting( 'st_webicon_check',
			array(
				'default'              => $defaults['st_webicon_check'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_check', array(
			'label'       => __( '', 'default' ),
			'description' => '(v) チェックマーク',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_check',
		) ) );

		$wp_customize->add_setting( 'st_webicon_exclamation',
			array(
				'default'              => $defaults['st_webicon_exclamation'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_exclamation', array(
			'label'       => __( '', 'default' ),
			'description' => '[！] エクステンションマーク',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_exclamation',
		) ) );

		$wp_customize->add_setting( 'st_webicon_memo',
			array(
				'default'              => $defaults['st_webicon_memo'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_memo', array(
			'label'       => __( '', 'default' ),
			'description' => 'メモマーク',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_memo',
		) ) );

		$wp_customize->add_setting( 'st_webicon_user',
			array(
				'default'              => $defaults['st_webicon_user'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_user', array(
			'label'       => __( '', 'default' ),
			'description' => '人物マーク',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_user',
		) ) );

		$wp_customize->add_setting( 'st_webicon_oukan',
			array(
				'default'              => $defaults['st_webicon_oukan'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_oukan', array(
			'label'       => __( '', 'default' ),
			'description' => '王冠マーク',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_oukan',
		) ) );

		$wp_customize->add_setting( 'st_webicon_bigginer',
			array(
				'default'              => $defaults['st_webicon_bigginer'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_bigginer', array(
			'label'       => __( '', 'default' ),
			'description' => '初心者マーク',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_bigginer',
		) ) );

		$wp_customize->add_setting( 'st_webicon_checkbox',
			array(
				'default'              => $defaults['st_webicon_checkbox'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_checkbox', array(
			'label'       => __( '', 'default' ),
			'description' => '[v] チェックボックス',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_checkbox',
		) ) );

		$wp_customize->add_setting( 'st_webicon_checkbox_square',
			array(
				'default'              => $defaults['st_webicon_checkbox_square'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_webicon_checkbox_square', array(
			'label'       => __( '', 'default' ),
			'description' => '[v] チェックボックス（枠）',
			'section'     => 'st_panel_webicon',
			'settings'    => 'st_webicon_checkbox_square',
		) ) );

		$wp_customize->add_setting( 'st_webicon_checkbox_size',
			array(
				'default'           => $defaults['st_webicon_checkbox_size'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_webicon_checkbox_size_c',
			array(
				'section'     => 'st_panel_webicon',
				'settings'    => 'st_webicon_checkbox_size',
				'label'       => '',
				'description' => '[v] チェックボックスサイズ（%）※微調整用',
				'type'        => 'option',
			) );

		/*マル数字のカラー*/
		$wp_customize->add_section('st_panel_maruno', array( // 中パネル
			'title' => '数字リストのカラー',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_maruno_textcolor',
			array(
				'default'              => $defaults['st_maruno_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruno_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruno',
			'description' => 'ナンバー色',
			'settings'    => 'st_maruno_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_maruno_nobgcolor',
			array(
				'default'              => $defaults['st_maruno_nobgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruno_nobgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruno',
			'description' => 'ナンバー背景色',
			'settings'    => 'st_maruno_nobgcolor',
		) ) );

		$wp_customize->add_setting( 'st_maruno_bordercolor',
			array(
				'default'              => $defaults['st_maruno_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruno_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruno',
			'description' => '囲いボーダー色',
			'settings'    => 'st_maruno_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_maruno_bgcolor',
			array(
				'default'              => $defaults['st_maruno_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruno_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruno',
			'description' => '囲い背景色',
			'settings'    => 'st_maruno_bgcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_maruno_radius',
			array(
				'default'           => $defaults['st_maruno_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_maruno_radius',
			array(
				'section'     => 'st_panel_maruno',
				'settings'    => 'st_maruno_radius',
				'label'       => '背景色の角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*マルチェックのカラー*/
		$wp_customize->add_section('st_panel_maruck', array( // 中パネル
			'title' => 'チェックリスト',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_maruck_textcolor',
			array(
				'default'              => $defaults['st_maruck_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruck_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruck',
			'description' => 'チェック色',
			'settings'    => 'st_maruck_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_maruck_nobgcolor',
			array(
				'default'              => $defaults['st_maruck_nobgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruck_nobgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruck',
			'description' => 'チェック背景色',
			'settings'    => 'st_maruck_nobgcolor',
		) ) );

		$wp_customize->add_setting( 'st_maruck_bordercolor',
			array(
				'default'              => $defaults['st_maruck_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruck_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruck',
			'description' => '囲いボーダー色',
			'settings'    => 'st_maruck_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_maruck_bgcolor',
			array(
				'default'              => $defaults['st_maruck_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_maruck_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_maruck',
			'description' => '囲い背景色',
			'settings'    => 'st_maruck_bgcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_maruck_radius',
			array(
				'default'           => $defaults['st_maruck_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_maruck_radius',
			array(
				'section'     => 'st_panel_maruck',
				'settings'    => 'st_maruck_radius',
				'label'       => '背景色の角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		/* ステップ */
		$wp_customize->add_section('st_panel_step', array( // 中パネル
			'title' => 'ステップ / ポイント',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_step_bgcolor',
			array(
				'default'              => $defaults['st_step_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_step_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_step',
			'description' => 'ステップ数・ポイントの背景色',
			'settings'    => 'st_step_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_step_color',
			array(
				'default'              => $defaults['st_step_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_step_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_step',
			'description' => 'ステップ数・ポイントの色',
			'settings'    => 'st_step_color',
		) ) );
        
        $wp_customize->add_setting( 'st_step_text_color',
			array(
				'default'              => $defaults['st_step_text_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_step_text_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_step',
			'description' => 'テキスト色',
			'settings'    => 'st_step_text_color',
		) ) );
		
        $wp_customize->add_setting( 'st_step_text_bgcolor',
			array(
				'default'              => $defaults['st_step_text_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_step_text_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_step',
			'description' => 'テキストの背景色',
			'settings'    => 'st_step_text_bgcolor',
		) ) );
        
        $wp_customize->add_setting( 'st_step_text_border_color',
			array(
				'default'              => $defaults['st_step_text_border_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_step_text_border_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_step',
			'description' => 'ボーダー色',
			'settings'    => 'st_step_text_border_color',
		) ) );
        
		$wp_customize->add_setting( 'st_step_radius',
			array(
				'default'           => $defaults['st_step_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_step_radius',
			array(
				'section'     => 'st_panel_step',
				'settings'    => 'st_step_radius',
				'label'       => '角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*ブログカード*/
		$wp_customize->add_section('st_panel_blogcard', array( // 中パネル
			'title' => 'ブログカード / ラベル',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_card_border_color',
			array(
				'default'              => $defaults['st_card_border_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_card_border_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blogcard',
			'description' => '枠線',
			'settings'    => 'st_card_border_color',
		) ) );

		$wp_customize->add_setting( 'st_card_border_size',
			array(
				'default'           => $defaults['st_card_border_size'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_card_border_size',
			array(
				'section'     => 'st_panel_blogcard',
				'settings'    => 'st_card_border_size',
				'label'       => '枠線を太くする（3px）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_card_label_bgcolor',
			array(
				'default'              => $defaults['st_card_label_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_card_label_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blogcard',
			'description' => 'ラベル背景色',
			'settings'    => 'st_card_label_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_card_label_textcolor',
			array(
				'default'              => $defaults['st_card_label_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_card_label_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blogcard',
			'description' => 'ラベルテキスト色（EXのみ）',
			'settings'    => 'st_card_label_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_card_label_designsetting',
			array(
				'default'           => $defaults['st_card_label_designsetting'],
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_card_label_designsetting',
			array(
				'section'     => 'st_panel_blogcard',
				'settings'    => 'st_card_label_designsetting',
				'label'       => '',
				'description' => 'ラベルデザイン',
				'type'        => 'radio',
				'choices'     => array(
					'ribondesign' => __( 'リボンデザイン', '' ),
					''               => __( 'デフォルト（たすき掛け）', 'default' ),
				),
			) );

		/*-------------------------
		テーブルカラー
		--------------------------*/
		$wp_customize->add_section('st_panel_table', array( // 中パネル
			'title' => 'table（表）',
			'panel' => 'st_panel_optioncolors',
		));

		/*テーブル全体*/

		$wp_customize->add_setting( 'st_table_bordercolor',
			array(
				'default'              => $defaults['st_table_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_table_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_table',
			'description' => '表のボーダー色',
			'settings'    => 'st_table_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_table_cell_bgcolor',
			array(
				'default'              => $defaults['st_table_cell_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_table_cell_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_table',
			'description' => '偶数行のセルの色',
			'settings'    => 'st_table_cell_bgcolor',
		) ) );

		/*縦一列目*/

		$wp_customize->add_setting( 'st_table_td_bgcolor',
			array(
				'default'              => $defaults['st_table_td_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_table_td_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_table',
			'description' => '縦一列目の背景色',
			'settings'    => 'st_table_td_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_table_td_textcolor',
			array(
				'default'              => $defaults['st_table_td_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_table_td_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_table',
			'description' => '縦一列目の文字色',
			'settings'    => 'st_table_td_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_table_td_bold',
			array(
				'default'           => $defaults['st_table_td_bold'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_table_td_bold',
			array(
				'section'     => 'st_panel_table',
				'settings'    => 'st_table_td_bold',
				'label'       => '縦一列目を太字にする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*横一列目*/

		$wp_customize->add_setting( 'st_table_tr_bgcolor',
			array(
				'default'              => $defaults['st_table_tr_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_table_tr_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_table',
			'description' => '横一列目（tr）及びヘッダセル（th）の背景色',
			'settings'    => 'st_table_tr_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_table_tr_textcolor',
			array(
				'default'              => $defaults['st_table_tr_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_table_tr_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_table',
			'description' => '横一列目（tr）及びヘッダセル（th）の文字色',
			'settings'    => 'st_table_tr_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_table_tr_bold',
			array(
				'default'           => $defaults['st_table_tr_bold'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_table_tr_bold',
			array(
				'section'     => 'st_panel_table',
				'settings'    => 'st_table_tr_bold',
				'label'       => '横一列目（tr）及びヘッダセル（th）を太字にする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*RSS（購読する）ボタン*/
		$wp_customize->add_section('st_panel_rss_button', array( // 中パネル
			'title' => 'RSSボタン',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_rss_color',
			array(
				'default'              => $defaults['st_rss_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_rss_color', array(
			'label'    => __( '', 'default' ),
			'section'  => 'st_panel_rss_button',
			'settings' => 'st_rss_color',
		) ) );

		/*SNSボタン*/
		$wp_customize->add_section('st_panel_sns_button', array( // 中パネル
			'title' => 'SNSボタン',
			'description' => '※一括反映',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_sns_btn',
			array(
				'default'              => $defaults['st_sns_btn'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_sns_btn', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_sns_button',
			'description' => 'ボタン背景色',
			'settings'    => 'st_sns_btn',
		) ) );

		$wp_customize->add_setting( 'st_sns_btntext',
			array(
				'default'              => $defaults['st_sns_btntext'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_sns_btntext', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_sns_button',
			'description' => 'アイコンと文字色',
			'settings'    => 'st_sns_btntext',
		) ) );

		//お知らせ
		$wp_customize->add_section('st_panel_news', array( // 中パネル
			'title' => 'お知らせ',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_menu_newsbarcolor_t',
			array(
				'default'              => $defaults['st_menu_newsbarcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_newsbarcolor_t', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_news',
			'description' => '見出し背景色上部（※上下共に設定）',
			'settings'    => 'st_menu_newsbarcolor_t',
		) ) );

		$wp_customize->add_setting( 'st_menu_newsbarcolor',
			array(
				'default'              => $defaults['st_menu_newsbarcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_newsbarcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_news',
			'description' => '見出し背景色下部',
			'settings'    => 'st_menu_newsbarcolor',
		) ) );

		$wp_customize->add_setting( 'st_menu_newsbar_border_color',
			array(
				'default'              => $defaults['st_menu_newsbar_border_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_newsbar_border_color',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_news',
				'description' => '見出しボーダー色',
				'settings'    => 'st_menu_newsbar_border_color',
			) ) );

		$wp_customize->add_setting( 'st_menu_newsbartextcolor',
			array(
				'default'              => $defaults['st_menu_newsbartextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_newsbartextcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_news',
			'description' => '見出し文字色',
			'settings'    => 'st_menu_newsbartextcolor',
		) ) );

		$wp_customize->add_setting( 'st_menu_newsbgcolor',
			array(
				'default'              => $defaults['st_menu_newsbgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_newsbgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_news',
			'description' => '全体背景色',
			'settings'    => 'st_menu_newsbgcolor',
		) ) );

		/*日付の文字色*/

		$wp_customize->add_setting( 'st_news_datecolor',
			array(
				'default'              => $defaults['st_news_datecolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_news_datecolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_news',
			'description' => '日付の文字と下線色',
			'settings'    => 'st_news_datecolor',
		) ) );

		/*文字と下線色*/

		$wp_customize->add_setting( 'st_news_text_color',
			array(
				'default'              => $defaults['st_news_text_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_news_text_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_news',
			'description' => 'お知らせ文字',
			'settings'    => 'st_news_text_color',
		) ) );

		/*任意お薦め記事*/
		$wp_customize->add_section('st_panel_popular_post', array( // 中パネル
			'title' => 'おすすめ記事',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_menu_osusumemidasitextcolor',
			array(
				'default'              => $defaults['st_menu_osusumemidasitextcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_osusumemidasitextcolor',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_popular_post',
				'description' => '見出し文字色',
				'settings'    => 'st_menu_osusumemidasitextcolor',
			) ) );

		$wp_customize->add_setting( 'st_menu_osusumemidasicolor',
			array(
				'default'              => $defaults['st_menu_osusumemidasicolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_osusumemidasicolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_popular_post',
			'description' => '見出し背景色',
			'settings'    => 'st_menu_osusumemidasicolor',
		) ) );

		$wp_customize->add_setting( 'st_menu_popbox_color',
			array(
				'default'              => $defaults['st_menu_popbox_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_popbox_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_popular_post',
			'description' => 'コンテンツ背景色',
			'settings'    => 'st_menu_popbox_color',
		) ) );

		$wp_customize->add_setting( 'st_menu_popbox_textcolor',
			array(
				'default'              => $defaults['st_menu_popbox_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_menu_popbox_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_popular_post',
			'description' => '文字色',
			'settings'    => 'st_menu_popbox_textcolor',
		) ) );

		/*任意お薦め記事No*/

		$wp_customize->add_setting( 'st_menu_osusumemidasinocolor',
			array(
				'default'              => $defaults['st_menu_osusumemidasinocolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_osusumemidasinocolor',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_popular_post',
				'description' => 'ナンバー（view）色',
				'settings'    => 'st_menu_osusumemidasinocolor',
			) ) );

		$wp_customize->add_setting( 'st_menu_osusumemidasinobgcolor',
			array(
				'default'              => $defaults['st_menu_osusumemidasinobgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_menu_osusumemidasinobgcolor',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_popular_post',
				'description' => 'ナンバー（view）背景色',
				'settings'    => 'st_menu_osusumemidasinobgcolor',
			) ) );

		$wp_customize->add_setting( 'st_nohidden',
			array(
				'default'           => $defaults['st_nohidden'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_nohidden',
			array(
				'section'     => 'st_panel_popular_post',
				'settings'    => 'st_nohidden',
				'label'       => 'ナンバーを非表示',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/* こんな方におすすめ */
		$wp_customize->add_section('st_panel_blackboard_mokuzicolor', array( // 中パネル
			'title' => 'こんな方におすすめ',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_blackboard_mokuzicolor',
			array(
				'default'              => $defaults['st_blackboard_mokuzicolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_blackboard_mokuzicolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blackboard_mokuzicolor',
			'description' => 'タイトル色',
			'settings'    => 'st_blackboard_mokuzicolor',
		) ) );
		
		$wp_customize->add_setting( 'st_blackboard_title_bgcolor',
			array(
				'default'              => $defaults['st_blackboard_title_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_blackboard_title_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blackboard_mokuzicolor',
			'description' => 'タイトル背景色',
			'settings'    => 'st_blackboard_title_bgcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_blackboard_textcolor',
			array(
				'default'              => $defaults['st_blackboard_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_blackboard_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blackboard_mokuzicolor',
			'description' => '枠線とタイトル下線',
			'settings'    => 'st_blackboard_textcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_blackboard_underbordercolor',
			array(
				'default'              => $defaults['st_blackboard_underbordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_blackboard_underbordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blackboard_mokuzicolor',
			'description' => 'ulリストのチェックアイコン',
			'settings'    => 'st_blackboard_underbordercolor',
		) ) );

		$wp_customize->add_setting( 'st_blackboard_bordercolor',
			array(
				'default'              => $defaults['st_blackboard_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_blackboard_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blackboard_mokuzicolor',
			'description' => 'ulリストの下線',
			'settings'    => 'st_blackboard_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_blackboard_bgcolor',
			array(
				'default'              => $defaults['st_blackboard_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_blackboard_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_blackboard_mokuzicolor',
			'description' => '背景色',
			'settings'    => 'st_blackboard_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_blackboard_list3_fontweight',
			array(
				'default'           => $defaults['st_blackboard_list3_fontweight'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_blackboard_list3_fontweight',
			array(
				'section'     => 'st_panel_blackboard_mokuzicolor',
				'settings'    => 'st_blackboard_list3_fontweight',
				'label'       => 'タイトル下線を非表示',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_blackboard_webicon',
			array(
				'default'           => $defaults['st_blackboard_webicon'],
				'sanitize_callback' => 'sanitize_text_field',

			) );
		$wp_customize->add_control( 'st_blackboard_webicon',
			array(
				'section'     => 'st_panel_blackboard_mokuzicolor',
				'settings'    => 'st_blackboard_webicon',
				'label'       => __( '', 'default' ),
				'description' => 'Webアイコン（Font Awesome）',
				'type'        => 'option',
			) );

		/*フリーボックスウィジェット*/
		$wp_customize->add_section('st_panel_freebox_widgets', array( // 中パネル
			'title' => 'フリーボックスウィジェット',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_freebox_tittle_textcolor',
			array(
				'default'              => $defaults['st_freebox_tittle_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_freebox_tittle_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_freebox_widgets',
			'description' => '見出し文字色',
			'settings'    => 'st_freebox_tittle_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_freebox_tittle_color',
			array(
				'default'              => $defaults['st_freebox_tittle_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_freebox_tittle_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_freebox_widgets',
			'description' => '見出し背景色',
			'settings'    => 'st_freebox_tittle_color',
		) ) );

		$wp_customize->add_setting( 'st_freebox_color',
			array(
				'default'              => $defaults['st_freebox_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_freebox_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_freebox_widgets',
			'description' => 'コンテンツ背景色',
			'settings'    => 'st_freebox_color',
		) ) );

		$wp_customize->add_setting( 'st_freebox_textcolor',
			array(
				'default'              => $defaults['st_freebox_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_freebox_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_freebox_widgets',
			'description' => '文字色',
			'settings'    => 'st_freebox_textcolor',
		) ) );

		/*メモボックス*/
		$wp_customize->add_section('st_panel_memobox', array( // 中パネル
			'title' => 'メモボックス',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_memobox_color',
			array(
				'default'              => $defaults['st_memobox_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_memobox_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_memobox',
			'description' => '文字・ボーダー色',
			'settings'    => 'st_memobox_color',
		) ) );

		/*スライドボックス*/
		$wp_customize->add_section('st_panel_slidebox', array( // 中パネル
			'title' => 'スライドボックス',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_slidebox_color',
			array(
				'default'              => $defaults['st_slidebox_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_slidebox_color', array(
			'label'       => __( 'スライドボックス', 'default' ),
			'section'     => 'st_panel_slidebox',
			'description' => '背景色',
			'settings'    => 'st_slidebox_color',
		) ) );

		/*ウィジェット問合せフォームボタン*/
		$wp_customize->add_section('st_panel_widgets_form_btn', array( // 中パネル
			'title' => 'ウィジェット問合せフォームボタン',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_formbtn_textcolor',
			array(
				'default'              => $defaults['st_formbtn_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_widgets_form_btn',
			'description' => '文字色',
			'settings'    => 'st_formbtn_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_formbtn_bordercolor',
			array(
				'default'              => $defaults['st_formbtn_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_widgets_form_btn',
			'description' => 'ボーダー色',
			'settings'    => 'st_formbtn_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_formbtn_radius',
			array(
				'default'           => $defaults['st_formbtn_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_formbtn_radius',
			array(
				'section'     => 'st_panel_widgets_form_btn',
				'settings'    => 'st_formbtn_radius',
				'label'       => '角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_formbtn_bgcolor',
			array(
				'default'              => $defaults['st_formbtn_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_widgets_form_btn',
			'description' => '背景色',
			'settings'    => 'st_formbtn_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_formbtn_bgcolor_t',
			array(
				'default'              => $defaults['st_formbtn_bgcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn_bgcolor_t', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_widgets_form_btn',
			'description' => '背景色上部',
			'settings'    => 'st_formbtn_bgcolor_t',
		) ) );

		/*オリジナルウィジェットボタン*/
		$wp_customize->add_section('st_panel_original_widgets_btn', array( // 中パネル
			'title' => 'おすすめ記事',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_formbtn2_textcolor',
			array(
				'default'              => $defaults['st_formbtn2_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn2_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_original_widgets_btn',
			'description' => '文字色',
			'settings'    => 'st_formbtn2_textcolor',
		) ) );

		$wp_customize->add_setting( 'st_formbtn2_bordercolor',
			array(
				'default'              => $defaults['st_formbtn2_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn2_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_original_widgets_btn',
			'description' => 'ボーダー色',
			'settings'    => 'st_formbtn2_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_formbtn2_radius',
			array(
				'default'           => $defaults['st_formbtn2_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_formbtn2_radius',
			array(
				'section'     => 'st_panel_original_widgets_btn',
				'settings'    => 'st_formbtn2_radius',
				'label'       => '角を丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_formbtn2_bgcolor',
			array(
				'default'              => $defaults['st_formbtn2_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn2_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_original_widgets_btn',
			'description' => '背景色',
			'settings'    => 'st_formbtn2_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_formbtn2_bgcolor_t',
			array(
				'default'              => $defaults['st_formbtn2_bgcolor_t'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_formbtn2_bgcolor_t', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_original_widgets_btn',
			'description' => '背景色上部',
			'settings'    => 'st_formbtn2_bgcolor_t',
		) ) );

		/*会話風ふきだしのカラー*/
		$wp_customize->add_section('st_panel_kaiwa', array( // 中パネル
			'title' => '会話風ふきだし',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_kaiwa_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '全体又は会話1の背景色',
			'settings'    => 'st_kaiwa_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_kaiwa2_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa2_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa2_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '会話2の背景色',
			'settings'    => 'st_kaiwa2_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_kaiwa3_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa3_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa3_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '会話3の背景色',
			'settings'    => 'st_kaiwa3_bgcolor',
		) ) );
		$wp_customize->add_setting( 'st_kaiwa4_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa4_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa4_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '会話4の背景色',
			'settings'    => 'st_kaiwa4_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_kaiwa5_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa5_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa5_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '会話5の背景色',
			'settings'    => 'st_kaiwa5_bgcolor',
		) ) );		$wp_customize->add_setting( 'st_kaiwa6_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa6_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa6_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '会話6の背景色',
			'settings'    => 'st_kaiwa6_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_kaiwa7_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa7_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa7_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '会話7の背景色',
			'settings'    => 'st_kaiwa7_bgcolor',
		) ) );
				$wp_customize->add_setting( 'st_kaiwa8_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa8_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa8_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => '会話8の背景色',
			'settings'    => 'st_kaiwa8_bgcolor',
		) ) );

		$wp_customize->add_setting( 'st_kaiwa_no_border',
			array(
				'default'           => $defaults['st_kaiwa_no_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_kaiwa_no_border',
			array(
				'section'     => 'st_panel_kaiwa',
				'settings'    => 'st_kaiwa_no_border',
				'label'       => 'アイコンの枠線を消す',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_kaiwa_borderradius',
			array(
				'default'           => $defaults['st_kaiwa_borderradius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_kaiwa_borderradius',
			array(
				'section'     => 'st_panel_kaiwa',
				'settings'    => 'st_kaiwa_borderradius',
				'label'       => 'ふきだしを角丸にしない',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_kaiwa_change_border',
			array(
				'default'           => $defaults['st_kaiwa_change_border'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_kaiwa_change_border',
			array(
				'section'     => 'st_panel_kaiwa',
				'settings'    => 'st_kaiwa_change_border',
				'label'       => 'ボーダーデザインタイプ（2px）に変更',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_kaiwa_change_border_bgcolor',
			array(
				'default'              => $defaults['st_kaiwa_change_border_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_kaiwa_change_border_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_kaiwa',
			'description' => 'ボーダーデザインタイプ（2px）時の背景色※一括',
			'settings'    => 'st_kaiwa_change_border_bgcolor',
		) ) );

		/*目次プラグイン（TOC+）のカラー*/
		$wp_customize->add_section('st_panel_toc_sugoi', array( // 中パネル
			'title' => '目次プラグイン（すごいもくじ）',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_toc_mokuzicolor',
			array(
				'default'              => $defaults['st_toc_mokuzicolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_toc_mokuzicolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_toc_sugoi',
			'description' => '目次色',
			'settings'    => 'st_toc_mokuzicolor',
		) ) );
		
		$wp_customize->add_setting( 'st_toc_textcolor',
			array(
				'default'              => $defaults['st_toc_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_toc_textcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_toc_sugoi',
			'description' => '第1リンク文字色',
			'settings'    => 'st_toc_textcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_toc_text2color',
			array(
				'default'              => $defaults['st_toc_text2color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_toc_text2color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_toc_sugoi',
			'description' => '第2リンク以降の文字色',
			'settings'    => 'st_toc_text2color',
		) ) );
		
		$wp_customize->add_setting( 'st_toc_underbordercolor',
			array(
				'default'              => $defaults['st_toc_underbordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_toc_underbordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_toc_sugoi',
			'description' => '下線と第3リストアイコン',
			'settings'    => 'st_toc_underbordercolor',
		) ) );

		$wp_customize->add_setting( 'st_toc_bordercolor',
			array(
				'default'              => $defaults['st_toc_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_toc_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_toc_sugoi',
			'description' => 'ボーダー色',
			'settings'    => 'st_toc_bordercolor',
		) ) );

		$wp_customize->add_setting( 'st_toc_border_width',
			array(
				'default'           => $defaults['st_toc_border_width'],
				'sanitize_callback' => 'sanitize_int',

			) );
		$wp_customize->add_control( 'st_toc_border_width_c',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_border_width',
				'label'       => '',
				'description' => 'ボーダーの太さ（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_toc_bgcolor',
			array(
				'default'              => $defaults['st_toc_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_toc_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_toc_sugoi',
			'description' => '背景色',
			'settings'    => 'st_toc_bgcolor',
		) ) );
		
		$wp_customize->add_setting( 'st_toc_radius',
			array(
				'default'           => $defaults['st_toc_radius'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_toc_radius',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_radius',
				'label'       => '背景を角丸にする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_toc_list1_left',
			array(
				'default'           => $defaults['st_toc_list1_left'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_toc_list1_left',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_list1_left',
				'label'       => '第1リンクをセンター寄せにする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_toc_list1_icon',
			array(
				'default'           => $defaults['st_toc_list1_icon'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_toc_list1_icon',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_list1_icon',
				'label'       => '第1リンクのアイコン非表示',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_toc_list2_icon',
			array(
				'default'           => $defaults['st_toc_list2_icon'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_toc_list2_icon',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_list2_icon',
				'label'       => '第2リンクの数字を非表示',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_toc_list3_fontweight',
			array(
				'default'           => $defaults['st_toc_list3_fontweight'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_toc_list3_fontweight',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_list3_fontweight',
				'label'       => '第2リンクを太字にする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_toc_list3_icon',
			array(
				'default'           => $defaults['st_toc_list3_icon'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_toc_list3_icon',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_list3_icon',
				'label'       => '第3リンク以降のアイコンを非表示にして並列',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		$wp_customize->add_setting( 'st_toc_webicon',
			array(
				'default'           => $defaults['st_toc_webicon'],
				'sanitize_callback' => 'sanitize_text_field',

			) );
		$wp_customize->add_control( 'st_toc_webicon',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_webicon',
				'label'       => __( '', 'default' ),
				'description' => '目次アイコン（Font Awesome ※Unicode）',
				'type'        => 'option',
			) );

		// 第1階層のみ
		$wp_customize->add_setting( 'st_toc_only_toc_fontweight',
			array(
				'default'           => $defaults['st_toc_only_toc_fontweight'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_toc_only_toc_fontweight',
			array(
				'section'     => 'st_panel_toc_sugoi',
				'settings'    => 'st_toc_only_toc_fontweight',
				'label'       => '第1階層のみの場合のリンクを太字にする',
				'description' => '',
				'type'        => 'checkbox',
			) );
		
		// 目次プラグイン
		if ( st_is_st_toc_enabled() ) {
			$wp_customize->add_setting( 'st_toc_paper_style',
				array(
					'default'           => $defaults['st_toc_paper_style'],
					'sanitize_callback' => 'sanitize_checkbox',
				) );
			$wp_customize->add_control( 'st_toc_paper_style',
				array(
					'section'     => 'st_panel_toc_sugoi',
					'settings'    => 'st_toc_paper_style',
					'label'       => 'ペーパー風デザインを適用する（※position:stickyは使用できなくなります）',
					'description' => '',
					'type'        => 'checkbox',
				) );
		}

		/*コンタクトフォーム7送信ボタン*/
		$wp_customize->add_section('st_panel_contactform7btn', array( // 中パネル
			'title' => 'コンタクトフォーム7送信ボタン',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_contactform7btn_textcolor',
			array(
				'default'              => $defaults['st_contactform7btn_textcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'st_contactform7btn_textcolor',
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_contactform7btn',
				'description' => '文字色',
				'settings'    => 'st_contactform7btn_textcolor',
			) ) );

		$wp_customize->add_setting( 'st_contactform7btn_bgcolor',
			array(
				'default'              => $defaults['st_contactform7btn_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_contactform7btn_bgcolor', 
			array(
				'label'       => __( '', 'default' ),
				'section'     => 'st_panel_contactform7btn',
				'description' => '背景色',
				'settings'    => 'st_contactform7btn_bgcolor',
			) ) );

		/*サイト管理者紹介*/
		$wp_customize->add_section('st_panel_author_profile', array( // 中パネル
			'title' => 'サイト管理者紹介',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_author_basecolor',
			array(
				'default'              => $defaults['st_author_basecolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_basecolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => 'ボーダー色',
			'settings'    => 'st_author_basecolor',
		) ) );
		
		$wp_customize->add_setting( 'st_author_bg_color',
			array(
				'default'              => $defaults['st_author_bg_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_bg_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => '背景色',
			'settings'    => 'st_author_bg_color',
		) ) );

		$wp_customize->add_setting( 'st_author_profile',
			array(
				'default'           => $defaults['st_author_profile'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_author_profile',
			array(
				'section'     => 'st_panel_author_profile',
				'settings'    => 'st_author_profile',
				'label'       => 'プロフィールカードに変更',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_author_profile_header',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'st_author_profile_header_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_author_profile',
				'description' => 'ヘッダー画像（プロフィールカード）',
				'settings'    => 'st_author_profile_header',
			)
		) );

		$wp_customize->add_setting( 'st_author_profile_avatar',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'st_author_profile_avatar_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_author_profile',
				'description' => 'アバター画像（プロフィールカード）※150px以上の正方形の画像推奨',
				'settings'    => 'st_author_profile_avatar',
			)
		) );

		$wp_customize->add_setting( 'st_author_profile_avatar_shadow',
			array(
				'default'           => $defaults['st_author_profile_avatar_shadow'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_author_profile_avatar_shadow',
			array(
				'section'     => 'st_panel_author_profile',
				'settings'    => 'st_author_profile_avatar_shadow',
				'label'       => 'アバター画像に影をつける（プロフィールカード）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_author_basecolor_profile',
			array(
				'default'              => $defaults['st_author_basecolor_profile'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_basecolor_profile', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => 'ボーダー色（プロフィールカード）',
			'settings'    => 'st_author_basecolor_profile',
		) ) );
		
		$wp_customize->add_setting( 'st_author_bg_color_profile',
			array(
				'default'              => $defaults['st_author_bg_color_profile'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_bg_color_profile', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => '背景色（プロフィールカード）',
			'settings'    => 'st_author_bg_color_profile',
		) ) );

		$wp_customize->add_setting( 'st_author_text_color_profile',
			array(
				'default'              => $defaults['st_author_text_color_profile'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_text_color_profile', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => 'テキスト色（プロフィールカード）',
			'settings'    => 'st_author_text_color_profile',
		) ) );

		$wp_customize->add_setting( 'st_author_profile_shadow',
			array(
				'default'           => $defaults['st_author_profile_shadow'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_author_profile_shadow',
			array(
				'section'     => 'st_panel_author_profile',
				'settings'    => 'st_author_profile_shadow',
				'label'       => '影をつける（プロフィールカード）',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_setting( 'st_author_profile_btn_url',
			array(
				'default'           => $defaults['st_author_profile_btn_url'],
				'sanitize_callback' => 'esc_url_raw',
			) );
		$wp_customize->add_control( 'st_author_profile_btn_url_c',
			array(
				'section'     => 'st_panel_author_profile',
				'settings'    => 'st_author_profile_btn_url',
				'label'       => __( '', 'default' ),
				'description' => 'ボタンURL（例：http://example.com）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_author_profile_btn_text',
			array(
				'default'           => $defaults['st_author_profile_btn_text'],
				'sanitize_callback' => 'sanitize_text_field',
			) );
		$wp_customize->add_control( 'st_author_profile_btn_text_c',
			array(
				'section'     => 'st_panel_author_profile',
				'settings'    => 'st_author_profile_btn_text',
				'label'       => __( '', 'default' ),
				'description' => 'ボタンテキスト',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_author_profile_btn_text_color',
			array(
				'default'              => $defaults['st_author_profile_btn_text_color'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_profile_btn_text_color', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => 'ボタンテキスト色（プロフィールカード）',
			'settings'    => 'st_author_profile_btn_text_color',
		) ) );

		$wp_customize->add_setting( 'st_author_profile_btn_top',
			array(
				'default'              => $defaults['st_author_profile_btn_top'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_profile_btn_top', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => 'ボタン上部背景色（プロフィールカード）',
			'settings'    => 'st_author_profile_btn_top',
		) ) );

		$wp_customize->add_setting( 'st_author_profile_btn_bottom',
			array(
				'default'              => $defaults['st_author_profile_btn_bottom'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_profile_btn_bottom', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => 'ボタン下部背景色（プロフィールカード）',
			'settings'    => 'st_author_profile_btn_bottom',
		) ) );

		$wp_customize->add_setting( 'st_author_profile_btn_shadow',
			array(
				'default'              => $defaults['st_author_profile_btn_shadow'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_author_profile_btn_shadow', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_author_profile',
			'description' => 'ボタン影色（プロフィールカード）',
			'settings'    => 'st_author_profile_btn_shadow',
		) ) );

		/*一覧サムネイル画像の枠線*/
		$wp_customize->add_section('st_panel_thumbnail', array( // 中パネル
			'title' => 'サムネイル画像',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_thumbnail_bordercolor',
			array(
				'default'              => $defaults['st_thumbnail_bordercolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_thumbnail_bordercolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_thumbnail',
			'description' => '一覧のサムネイル画像の枠線',
			'settings'    => 'st_thumbnail_bordercolor',
		) ) );

		/*ページトップボタン*/
		$wp_customize->add_section('st_panel_pagetop', array( // 中パネル
			'title' => 'TOPに戻るボタン',
			'panel' => 'st_panel_optioncolors',
		));

		$wp_customize->add_setting( 'st_pagetop_img',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'pagetop_Image',
			array(
				'label'       => '',
				'section'     => 'st_panel_pagetop',
				'description' => '',
				'settings'    => 'st_pagetop_img',
			)
		) );

		$wp_customize->add_setting( 'st_pagetop_img_right',
			array(
				'default'           => $defaults['st_pagetop_img_right'],
				'sanitize_callback' => 'sanitize_int',
			) );
		$wp_customize->add_control( 'st_pagetop_img_right_c',
			array(
				'section'     => 'st_panel_pagetop',
				'settings'    => 'st_pagetop_img_right',
				'label'       => '',
				'description' => 'right（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_pagetop_img_bottom',
			array(
				'default'           => $defaults['st_pagetop_img_bottom'],
				'sanitize_callback' => 'sanitize_int',
			) );
		$wp_customize->add_control( 'st_pagetop_img_bottom_c',
			array(
				'section'     => 'st_panel_pagetop',
				'settings'    => 'st_pagetop_img_bottom',
				'label'       => '',
				'description' => 'bottom（px）',
				'type'        => 'option',
			) );

		$wp_customize->add_setting( 'st_pagetop_bgcolor',
			array(
				'default'              => $defaults['st_pagetop_bgcolor'],
				'sanitize_callback'    => 'sanitize_hex_color',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'st_pagetop_bgcolor', array(
			'label'       => __( '', 'default' ),
			'section'     => 'st_panel_pagetop',
			'description' => '背景色',
			'settings'    => 'st_pagetop_bgcolor',
		) ) );

		/*ページトップボタンの位置*/
		$wp_customize->add_setting( 'st_pagetop_up',
			array(
				'default'           => $defaults['st_pagetop_up'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_pagetop_up',
			array(
				'label'       => 'TOPに戻るボタンの配置を上にする（モバイルアンカー広告使用時用）',
				'section'     => 'st_panel_pagetop',
				'settings'    => 'st_pagetop_up',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*ページトップボタンを丸くする*/
		$wp_customize->add_setting( 'st_pagetop_circle',
			array(
				'default'           => $defaults['st_pagetop_circle'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_pagetop_circle',
			array(
				'section'     => 'st_panel_pagetop',
				'settings'    => 'st_pagetop_circle',
				'label'       => 'ページトップボタンを丸くする',
				'description' => '',
				'type'        => 'checkbox',
			) );

		/*ページトップボタンを非表示*/
		$wp_customize->add_setting( 'st_pagetop_hidden',
			array(
				'default'           => $defaults['st_pagetop_hidden'],
				'sanitize_callback' => 'sanitize_checkbox',
			) );
		$wp_customize->add_control( 'st_pagetop_hidden',
			array(
				'section'     => 'st_panel_pagetop',
				'settings'    => 'st_pagetop_hidden',
				'label'       => 'ページトップボタンを非表示',
				'description' => '',
				'type'        => 'checkbox',
			) );

		$wp_customize->add_section( 'stpattern',
			array(
				'title'       => __( '全体カラー設定', 'default' ),
				'description' => '全体の配色（及びカラーパレット）を設定します<br/>※編集後、「公開」ボタンをクリックしたあとブラウザを更新して下さい（反映されない場合は①違うカラーを選択して再度選択②キャッシュ削除をお試しください）',
				'priority'    => 0,
			) );

		_st_customization_add_color_controls( $wp_customize, 'stpattern', '' );

		$wp_customize->add_setting( 'st_theme_setting',
			array(
				'default'           => '',
				'sanitize_callback' => 'st_sanitize_choices',
			) );
		$wp_customize->add_control( 'st_theme_setting',
			array(
				'section'     => 'stpattern',
				'settings'    => 'st_theme_setting',
				'label'       => '簡単設定を使用する',
				'description' => '「（3）初期値」として利用するには一度、「（1）全体的に反映」を選択して「公開」ボタンをクリックしたあと「（3）初期値として設定」を選択して「公開」ボタンをクリック及びブラウザを更新してください',
				'type'        => 'radio',
				'choices'     => array(
					'zentai'       => __( '(1)全体的に反映：有効化すると「デフォルト」表示のカラー変更ができなくなります', 'default' ),
					'menuonly'     => __( '(2)「デフォルト」表示の一部メニューのみに反映', 'default' ),
					'defaultcolor' => __( '(3)初期値として設定：「デフォルト」表示のカラー初期値として登録されます', 'default' ),
					''             => __( '使用しない（管理画面で選択したカラーが初期値になります）', 'default' ),
				),
			) );
		$wp_customize->add_setting( 'st_customizer_reset',
			array(
				'default' => '',
				'sanitize_callback' => '__return_null',
			) );
		$wp_customize->add_control( new St_Customize_Button_Control( $wp_customize, 'st_customizer_reset', array(
			'label'        => 'カスターマイザーをリセットする',
			'section'      => 'stpattern',
			'description'  => 'カラーの初期値をリセットします。<br/>※プレビューにカラーが反映されない場合はキーカラー・メインカラー・サブカラー・テキストの値を削除して下さい）',
			'button_label' => 'リセット',
			'settings'     => 'st_customizer_reset',
		) ) );

		if ( st_is_customizer_enabled() ) {

		}
	}

	$st_settings = [];

	$other_settings = [
		'header_text',
		'site_icon',
		'custom_logo',
		'header_textcolor',
		'background_color',
		'header_video',
		'external_header_video',
		'header_image',
		'header_image_data',
		'background_image',
		'background_image_thumb',
		'background_preset',
		'background_position_x',
		'background_position_y',
		'background_size',
		'background_repeat',
		'background_attachment',
	];

	foreach ( $wp_customize->settings() as $id => $setting ) {
		if ( array_key_exists( $id, $default_settings ) && ! in_array( $id, $other_settings, true ) ) {
			continue;
		}

		$st_settings[] = $setting;
	}

	_st_customize_settings( $st_settings );
}

add_action( 'customize_register', 'st_customize_register' );

add_action( 'customize_register', 'st_headerfooter_logo' );

if (!function_exists('_st_customize_save_after')) {
    function _st_customize_save_after() {
    	set_theme_mod('_st_current_theme_setting', st_get_kantan_setting());
    }
}
add_action('customize_save_after', '_st_customize_save_after');

function st_headerfooter_logo() {
	return get_theme_mod( 'st_header_footer_logo' );
}

function st_mobilelogo_on() {
	return get_theme_mod( 'st_mobile_logo_on' );
}

if ( st_is_customizer_enabled() ) {
	function st_customize_css() {
		require( dirname( __FILE__ ) . '/st-themecss-variables.php' );

		?>
		<style type="text/css">
			<?php include( dirname( __FILE__ ) . '/st-themecss.php' ); ?>
		</style>
		<?php
	}

	function st_enqueue_customize_css() {
		wp_enqueue_style(
			'st-themecss',
			get_template_directory_uri() . '/st-themecss-loader.php',
			array(),
			false,
			'all'
		);
	}

	function st_customize_js() {
		wp_enqueue_script( 'ac-fixmenu', get_template_directory_uri() . '/js/ac-fixmenu.js', array() );
	}

	if ( is_customize_preview() ||
	     st_should_output_style_element()
	) {
		add_action( 'wp_head', 'st_customize_css' );
	} else {
		add_action( 'wp_enqueue_scripts', 'st_enqueue_customize_css', PHP_INT_MAX );
	}

	if ( get_theme_mod( 'st_sticky_menu', '' ) === '1' ) {
		add_action( 'wp_footer', 'st_customize_js' );
	}

	function st_ajax_customizer_reset() {
		global $wp_customize;

		if ( ! $wp_customize->is_preview() ) {
			wp_send_json_error( new WP_Error( 'not_in_preview', 'Not in preview.' ) );
		}

		if ( ! check_ajax_referer( 'st_customizer_reset', 'nonce', false ) ) {
			wp_send_json_error( new WP_Error( 'invalid_nonce', 'Invalid Nonce.' ) );
		}

		foreach ( _st_customize_settings() as $setting ) {
			if ( $setting->type === 'theme_mod' ) {
				remove_theme_mod( $setting->id );
			} elseif ( $setting->type === 'option' ) {
				delete_option( $setting->id );
			}
		}

		$stylesheet = get_stylesheet();
		$headers    = get_posts(
			array(
				'post_type'  => 'attachment',
				'meta_key'   => '_wp_attachment_is_custom_header',
				'meta_value' => $stylesheet,
				'orderby'    => 'none',
				'nopaging'   => true,
			)
		);

		$lastUsedKey = '_wp_attachment_custom_header_last_used_' . $stylesheet;

		foreach ( $headers as $header ) {
			delete_post_meta( $header->ID, $lastUsedKey );
			delete_post_meta( $header->ID, '_wp_attachment_is_custom_header', $stylesheet );
		}

		wp_send_json_success();
	}

	add_action( 'wp_ajax_st_customizer_reset', 'st_ajax_customizer_reset' );
}
