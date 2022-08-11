<?php
if ( !function_exists( 'st_get_preset_theme_mod_overrides' ) ) {

	function st_get_preset_theme_mod_overrides( $preset_name ) {

		extract( st_get_preset_colors( $preset_name ), EXTR_OVERWRITE );

		return array(

			'st_header_footer_logo' => '', //ヘッダーロゴをフッターにも
			'st_mobile_logo_on' => '', //モバイル用ロゴ（タイトル）を使用する
			'st_mobile_logo_size' => '', //モバイル用ロゴ画像サイズ調整
			'st_mobile_logo_center' => '', //モバイル用ロゴ（又はタイトル）をセンター寄せ
			'st_mobile_sitename'     => $textcolor,    //モバイル用タイトル使用時のテキスト色
			'st_area'               => '', //記事エリアを広げる

			'st_top_bordercolor' => '',    //サイト上部にボーダー
			'st_line100'         => '',    //サイト上部ボーダーを100%に
			'st_line_height'     => '5px', //サイト上部ボーダーの高さ

			'st_headbox_bgcolor_t'   => $basecolor,    //ヘッダーの背景色上部
			'st_headbox_bgcolor'     => $maincolor,    //ヘッダーの背景色下部
			'st_wrapper_bgcolor'     => '',    //Wrapperの背景色
			'st_header100'           => 'yes',    //ヘッダーの背景画像の幅100%
			'st_header_image_side'   => 'center', //ヘッダーの背景画像の横位置
			'st_header_image_top'    => 'center', //ヘッダーの背景画像の縦位置
			'st_header_image_repeat' => '',    //ヘッダーの背景画像の繰り返し
			'st_header_gradient'            => 'yes',        //グラデーションを横向きにする

			'st_headerunder_bgcolor'      => '',    //ヘッダー以下の背景色
			'st_headerunder_image_side'   => 'center', //ヘッダー以下の背景画像の横位置
			'st_headerunder_image_top'    => 'center', //ヘッダー以下の背景画像の縦位置
			'st_headerunder_image_repeat' => '',    //ヘッダー以下の背景画像の繰り返し

			'st_menu_logocolor' => $textcolor, //サイトタイトル及びディスクリプション色

			'st_menu_maincolor'        => '#ffffff', //コンテンツ背景色
			'st_menu_main_bordercolor' => '',        //コンテンツボーダー色
			'st_main_opacity'          => '',        //メインコンテンツ背景の透過

			'st_footer_bg_text_color' => $textcolor,       //フッターテキスト色
			'st_footer_bg_color_t'    => $maincolor,       //フッター背景色上部
			'st_footer_bg_color'      => $basecolor,       //フッター背景色下部
			'st_footer100'            => 'yes',       //フッター背景幅100%
			'st_footer_image_side'    => 'center', //フッターの背景画像の横位置
			'st_footer_image_top'     => 'center', //フッターの背景画像の縦位置
			'st_footer_image_repeat'  => '',       //フッターの背景画像の繰り返し
			'st_footer_gradient'            => 'yes',        //グラデーションを横向きにする

			//一括カラー
			'st_main_textcolor'      => '', //記事の文字色
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
			'st_h2_color'           => $basecolor, //h2のテキスト色
			'st_h2_bgcolor'         => $basecolor,  //h2の背景色
			'st_h2_bgcolor_t'       => $subcolor,  //h2の背景色上部
			'st_h2border_color'       => $basecolor, //h2のボーダー色
			'st_h2border_undercolor'  => $subcolor,  //h2のボーダー色（2色アンダーライン）
			'st_h2_border_tb_sub'         => '',    //h2のボーダー上を太く下をサブカラーに
			'st_h2_border_tb_dot'         => '',    //h2のボーダー上をドットに
			'st_h2_designsetting'     => 'centerlinedesign',        //h2デザインの変更hukidasidesign（吹き出しデザイン）linedesign（囲み&左ラインデザイン）underlinedesign（2色アンダーライン）gradient_underlinedesign（グラデーションアンダーライン）centerlinedesign（センターラインに変更）dotdesign（囲みドットデザイン）stripe_design（ストライプデザイン）underdotdesign（下線ドットデザイン）
			'st_h2_bgimg_side'        => 'left',   //h2の背景画像の横位置
			'st_h2_bgimg_top'         => 'center',   //h2の背景画像の縦位置
			'st_h2_bgimg_repeat'      => '',         //h2の背景画像の繰り返し
			'st_h2_bgimg_leftpadding' => 0,         //h2の背景画像の左の余白
			'st_h2_bgimg_tupadding'   => 10,         //h2の背景画像の上下の余白
			'st_h2_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h2_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h2_gradient'            => '',        //グラデーションを横向きにする
			'st_h2_text_center'            => 'yes',        //テキストをセンタリング
			'st_h2_design_wide'            => '',        //デザインを幅一杯にする

			//h3タグ
			'st_h3_color'          => $textcolor, //h3のテキスト色
			'st_h3_bgcolor'        => $basecolor, //h3の背景色
			'st_h3_bgcolor_t'      => $basecolor, //h3の背景色上部
			'st_h3border_color'       => $basecolor, //h3のボーダー色
			'st_h3border_undercolor'  => $maincolor,  //h3のボーダー色（2色アンダーライン）
			'st_h3_border_tb'         => '',       //h3のボーダー上下のみ
			'st_h3_border_tb_sub'         => '',    //h3のボーダー上を太く下をサブカラーに
			'st_h3_border_tb_dot'         => '',    //h3のボーダー上をドットに
			'st_h3_designsetting'     => 'hukidasidesign',        //h3デザインの変更hukidasidesign（吹き出しデザイン）linedesign（囲み&左ラインデザイン）underlinedesign（2色アンダーライン）gradient_underlinedesign（グラデーションアンダーライン）centerlinedesign（センターラインに変更）dotdesign（囲みドットデザイン）stripe_design（ストライプデザイン）underdotdesign（下線ドットデザイン）
			'st_h3_bgimg_side'        => 'left',  //h3の背景画像の横位置
			'st_h3_bgimg_top'         => 'center',  //h3の背景画像の縦位置
			'st_h3_bgimg_repeat'      => '',        //h3の背景画像の繰り返し
			'st_h3_bgimg_leftpadding' => 0,        //h3の背景画像の左の余白
			'st_h3_bgimg_tupadding'   => 10,        //h3の背景画像の上下の余白
			'st_h3_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h3_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h3_gradient'            => '',        //グラデーションを横向きにする
			'st_h3_text_center'            => 'yes',        //テキストをセンタリング
			'st_h3_design_wide'            => '',        //デザインを幅一杯にする

			//h4タグ
			'st_h4_textcolor'    => $basecolor, //h4の文字色
			'st_h4bordercolor'   => $basecolor,         //h4のボーダー色
			'st_h4bgcolor'       => $subcolor,  //h4の背景色
			'st_h4_design'            => 'yes',         //h4の左ボーダー
			'st_h4_top_border'        => '',         //h4の上ボーダー
			'st_h4_bottom_border'     => '',         //h4の下ボーダー
			'st_h4_bgimg_side'        => 'left',   //h4の背景画像の横位置
			'st_h4_bgimg_top'         => 'center',   //h4の背景画像の縦位置
			'st_h4_bgimg_repeat'      => '',         //h4の背景画像の繰り返し
			'st_h4_bgimg_leftpadding' => 20,         //h4の背景画像の左の余白
			'st_h4_bgimg_tupadding'   => 10,         //h4の背景画像の上下の余白
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
			'st_h4_matome_bgimg_side'        => 'center',  //h4（まとめ）の背景画像の横位置
			'st_h4_matome_bgimg_top'         => 'center',  //h4（まとめ）の背景画像の縦位置
			'st_h4_matome_bgimg_repeat'      => '',        //h4（まとめ）の背景画像の繰り返し
			'st_h4_matome_bgimg_leftpadding' => 20,        //h4（まとめ）の背景画像の左の余白
			'st_h4_matome_bgimg_tupadding'   => 10,        //h4（まとめ）の背景画像の上下の余白
			'st_h4_matome_hukidasi_design'    => '',        //h4（まとめ）デザインをふきだしに変更
			'st_h4_matome_bg_radius'    => '',        //背景や吹き出しの角を丸くする
			'st_h4_matome_no_css'    => '',        //カスタマイザーのCSSを無効化

			//h5タグ
			'st_h5_textcolor'    => $basecolor, //h5の文字色
			'st_h5bordercolor'   => $maincolor,         //h5のボーダー色
			'st_h5bgcolor'       => $subcolor,  //h5の背景色
			'st_h5_design'            => '',         //h5デザインの変更
			'st_h5_top_border'        => '',         //h5の上ボーダー
			'st_h5_bottom_border'     => 'yes',         //h5の下ボーダー
			'st_h5_bgimg_side'        => 'center',   //h5の背景画像の横位置
			'st_h5_bgimg_top'         => 'center',   //h5の背景画像の縦位置
			'st_h5_bgimg_repeat'      => '',         //h5の背景画像の繰り返し
			'st_h5_bgimg_leftpadding' => '20',         //h5の背景画像の左の余白
			'st_h5_bgimg_tupadding'   => 10,         //h5の背景画像の上下の余白
			'st_h5hukidasi_design'    => '',        //h5デザインをふきだしに変更
			'st_h5_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			'st_h5_no_css'            => '',        //カスタマイザーのCSSを無効化
			'st_h5_husen_shadow'            => '',        //ふせん風の影をつける

			'st_blockquote_color' => '#f3f3f3', //引用部分の背景色

			'st_separator_color'   => $textcolor, //NEW ENTRYのテキスト色
			'st_separator_bgcolor' => $basecolor, //NEW ENTRYの背景色

			'st_catbg_color'   => $basecolor, //カテゴリの背景色
			'st_cattext_color' => '#ffffff', //カテゴリのテキスト色

			//お知らせ
			'st_news_datecolor'            => $basecolor, //お知らせ日付のテキスト色
			'st_news_text_color'           => '#000000',  //お知らせのテキストと下線色
			'st_menu_newsbarcolor_t'       => $basecolor, //お知らせの背景色上
			'st_menu_newsbarcolor'         => $basecolor, //お知らせの背景色下
			'st_menu_newsbar_border_color' => $basecolor, //お知らせのボーダー色
			'st_menu_newsbartextcolor'     => $textcolor, //お知らせのテキスト色
			'st_menu_newsbgcolor'          => '',         //お知らせの全体背景色

			//メニュー
			'st_menu_navbar_topunder_color' => $maincolor, //メニューの上下ボーダー色
			'st_menu_navbar_side_color'     => $basecolor, //メニューの左右ボーダー色
			'st_menu_navbar_right_color'    => $maincolor, //メニューの右ボーダー色
			'st_menu_navbarcolor'           => $basecolor, //メニューの背景色下
			'st_menu_navbarcolor_t'         => $maincolor, //メニューの背景色上
			'st_menu_navbar_undercolor'         => $maincolor, //下層ドロップダウンメニュー背景色
			'st_menu_navbartextcolor'       => $textcolor, //PCメニューテキスト色
			'st_menu_bold'                  => '',         //第一階層メニューを太字にする
			'st_menu100'                    => 'yes',         //PCメニュー100%
			'st_menu_padding'               => '',         //PCメニューの上下に隙間(top10,bottom10)
			'st_navbarcolor_gradient'            => 'yes',        //グラデーションを横向きにする

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

			'st_headerimg100'             => '',    //ヘッダー画像100%
			'st_header_bgcolor'           => '',    //ヘッダー画像の背景色
			'st_topgabg_image_side'       => 'center', //ヘッダー画像の背景画像の横位置
			'st_topgabg_image_top'        => 'center', //ヘッダー画像の背景画像の縦位置
			'st_topgabg_image_repeat'     => '',    //ヘッダー画像の背景画像の繰り返し
			'st_topgabg_image_flex'       => '',    //ヘッダー画像の背景画像のレスポンシブ化
			'st_topgabg_image_sumahoonly' => '',    //ヘッダー画像の背景画像をスマホとタブレットのみに

			//サイドメニューウィジェット
			'st_menu_side_widgets_topunder_color' => '',        //サイドメニューウィジェットのボーダー色
			'st_menu_side_widgetscolor'           => $basecolor,        //サイドメニューウィジェットの背景色下
			'st_menu_side_widgetscolor_t'         => $maincolor,        //サイドメニューウィジェットの背景色上
			'st_menu_side_widgetstextcolor'       => '', //サイドメニューウィジェットテキスト色
			'st_menu_icon'              => 'f138', //メニュー第一階層のWebアイコン
			'st_undermenu_icon'         => 'f105', //メニュー第二階層のWebアイコン
			'st_menu_icon_color'        => '', //メニュー第一階層のWebアイコンカラー
			'st_undermenu_icon_color'   => '', //メニュー第二階層のWebアイコンカラー
			'st_sidemenu_fontsize'      => '', //第一階層メニューの文字サイズを大きくする
			'st_sidemenu_accordion'   => '', //第二階層以下をスライドメニューにする
			'st_sidemenu_gradient'            => 'yes',        //グラデーションを横向きにする

			'st_side_bgcolor' => '', //サイドバーウィジェットエリアの背景色

			'st_menu_pagelist_childtextcolor'         => $basecolor, //サイドメニュー下層のテキスト色
			'st_menu_pagelist_bgcolor'                => $subcolor,  //サイドメニュー下層の背景色
			'st_menu_pagelist_childtext_border_color' => $maincolor, //サイドメニュー下層の下線色

			//ウィジェットタイトル
			'st_widgets_title_color'          => $basecolor, //ウィジェットタイトルのテキスト色
			'st_widgets_title_bgcolor'        => '',        //ウィジェットタイトルの背景色
			'st_widgets_title_bgcolor_t'      => '',        //ウィジェットタイトルの背景色上部
			'st_widgets_titleborder_color'       => $basecolor,        //ウィジェットタイトルのボーダー色
			'st_widgets_titleborder_undercolor'  => $maincolor, //ウィジェットタイトルのボーダー色（2色アンダーライン）
			'st_widgets_title_designsetting'     => 'gradient_underlinedesign',        //ウィジェットタイトルデザインの変更hukidasidesign（吹き出しデザイン）linedesign（囲み&左ラインデザイン）underlinedesign（2色アンダーライン）dotdesign（囲みドットデザイン）stripe_design（ストライプデザイン）
			'st_widgets_title_bgimg_side'        => 'left',  //ウィジェットタイトルの背景画像の横位置
			'st_widgets_title_bgimg_top'         => 'center',  //ウィジェットタイトルの背景画像の縦位置
			'st_widgets_title_bgimg_repeat'      => '',        //ウィジェットタイトルの背景画像の繰り返し
			'st_widgets_title_bgimg_leftpadding' => 10,       //ウィジェットタイトルの背景画像の左の余白
			'st_widgets_title_bgimg_tupadding'   => 7,       //ウィジェットタイトルの背景画像の上下の余白
			'st_widgets_title_bg_radius'         => '',        //背景や吹き出しの角を丸くする
			
			'st_tagcloud_color'       => $basecolor, //タグクラウド色
			'st_tagcloud_bordercolor' => $basecolor, //タグクラウドボーダー色
			'st_rss_color'            => $basecolor, //RSSボタン

			'st_sns_btn'     => '', //SNSボタン背景
			'st_sns_btntext' => '', //SNSボタンテキスト

			'st_formbtn_textcolor'   => $textcolor, //ウィジェット問合せフォームのテキスト色
			'st_formbtn_bordercolor' => '',         //ウィジェット問合せフォームのボーダー色
			'st_formbtn_bgcolor_t'   => '',         //ウィジェット問合せフォームの背景色上部
			'st_formbtn_bgcolor'     => $basecolor, //ウィジェット問合せフォームの背景色
			'st_formbtn_radius'      => 'yes',         //ウィジェット問合せフォームの角を丸くする

			'st_formbtn2_textcolor'   => $textcolor, //ウィジェッオリジナルボタンのテキスト色
			'st_formbtn2_bordercolor' => '',         //ウィジェットオリジナルボタンのボーダー色
			'st_formbtn2_bgcolor_t'   => '',         //ウィジェッオリジナルボタンの背景色
			'st_formbtn2_bgcolor'     => $basecolor, //ウィジェッオリジナルボタンの背景色
			'st_formbtn2_radius'      => 'yes',         //ウィジェッオリジナルボタンの角を丸くする

			'st_contactform7btn_textcolor' => $textcolor, //コンタクトフォーム7の送信ボタンテキスト色
			'st_contactform7btn_bgcolor'   => $basecolor, //コンタクトフォーム7の送信ボタンの背景色

			//任意記事
			'st_menu_osusumemidasitextcolor' => $textcolor,   //任意記事の見出しテキスト色
			'st_menu_osusumemidasicolor'     => $basecolor, //任意記事の見出し背景色
			'st_menu_osusumemidasinocolor'   => $textcolor,   //任意記事のナンバー色
			'st_menu_osusumemidasinobgcolor' => $basecolor, //任意記事のナンバー背景色
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
			'st_freebox_tittle_color'     => $basecolor, //フリーボックスウィジェットの見出背景色
			'st_freebox_color'            => $subcolor,    //フリーボックスウィジェットの背景色
			'st_freebox_textcolor'        => '',           //フリーボックスウィジェットのテキスト色

			//メモボックス
			'st_memobox_color' => '', //文字・ボーダー色
			//スライドボックス
			'st_slidebox_color' => '', //背景色

			//スマートフォンサイズ
			'st_menu_sumartmenutextcolor' => '', //スマホメニュー文字色
			'st_menu_sumartmenubordercolor' => $maincolor, //スマホメニューボーダー
			'st_menu_sumart_bg_color'     => '', //スマホメニュー背景色
			'st_menu_smartbar_bg_color_t'     => '', //スマホメニューバー背景色（グラデーション上部）
			'st_menu_smartbar_bg_color'     => '', //スマホメニューOPアイコン背景色
			'st_menu_sumartbar_bg_color'  => $subcolor,       //スマホメニューバーエリア内背景色
			'st_menu_sumartcolor'         => $textcolor, //スマホwebアイコン
			'st_menu_faicon'              => '',        //メニューのWebアイコンを非表示
			'st_sticky_menu'              => '',        //スマホメニューfix

			'st_menu_sumart_st_bg_color'  => $maincolor, //追加スマホメニュー背景色
			'st_menu_sumart_st_color'     => $textcolor, //追加スマホwebアイコン色
			'st_menu_sumart_st2_bg_color' => $maincolor, //追加スマホメニュー背景色2
			'st_menu_sumart_st2_color'    => $textcolor, //追加スマホwebアイコン色2
			'st_menu_sumart_footermenu_text_color'    => $textcolor, //スマホフッターメニューテキスト色
			'st_menu_sumart_footermenu_bg_color'    => $maincolor, //スマホフッターメニュー背景色
			
			//スマホミドルメニュー
			'st_middle_sumartmenutextcolor' => $textcolor, //文字色
			'st_middle_sumartmenubordercolor' => '', //ボーダー
			'st_middle_sumart_bg_color'     => $basecolor, //背景色
			'st_middle_sumart_bg_color_t'     => $maincolor, //背景色（グラデーション上部※向きはヘッダーエリア連動）

			//Webアイコン
			'st_webicon_question'    => '', //はてな
			'st_webicon_check'       => '', //チェック
			'st_webicon_exclamation' => '#f44336', //エクステンション
			'st_webicon_memo'        => '', //メモ
			'st_webicon_user'        => '', //人物

			//一覧のサムネイル画像の枠線
			'st_thumbnail_bordercolor' => '',   //一覧のサムネイル画像の枠線

			//サイト管理者紹介
			'st_author_basecolor' => $basecolor,   //「サイト管理者紹介」の基本カラー
			'st_author_bg_color' => $subcolor,   //「サイト管理者紹介」の背景カラー

			//ページトップボタン
			'st_pagetop_up'          => '',   //TOPに戻るボタンの配置を上にする
			'st_pagetop_circle'      => 'yes', //ページトップボタンを丸くする
			'st_pagetop_bgcolor'     => $basecolor,     //背景色

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
			'st_toc_webicon'   => 'f0f6', //目次アイコン（Font Awesome））
			'st_toc_radius'   => '', //背景を角丸にする
			'st_toc_paper_style' => '', //ペーパー風デザインを適用する

			//マル数字のカラー
			'st_maruno_textcolor'   => $textcolor, //ナンバー色
			'st_maruno_nobgcolor'   => $basecolor, //ナンバー背景色
			'st_maruno_bordercolor' => '', //囲いボーダー色
			'st_maruno_bgcolor'     => '', //囲い背景色
			'st_maruno_radius'     => '', //背景色の角を丸くする

			//マルチェックのカラー
			'st_maruck_textcolor'   => $textcolor, //ナンバー色
			'st_maruck_nobgcolor'   => $basecolor, //ナンバー背景色
			'st_maruck_bordercolor' => '', //囲いボーダー色
			'st_maruck_bgcolor'     => '', //囲い背景
			'st_maruck_radius'     => '', //背景色の角を丸くする

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
			'st_kaiwa_bgcolor'  => $subcolor, //会話統一ふきだし背景色
			'st_kaiwa2_bgcolor'  => '', //会話2ふきだし背景色
			'st_kaiwa3_bgcolor'  => '', //会話3ふきだし背景色
			'st_kaiwa4_bgcolor'  => '', //会話4ふきだし背景色
			'st_kaiwa5_bgcolor'  => '', //会話5ふきだし背景色
			'st_kaiwa6_bgcolor'  => '', //会話6ふきだし背景色
			'st_kaiwa7_bgcolor'  => '', //会話7ふきだし背景色
			'st_kaiwa8_bgcolor'  => '', //会話8ふきだし背景色

			//ステップ
			'st_step_bgcolor'             => $basecolor, //ステップ数の背景色
			'st_step_color'               => $textcolor, //ステップ数の色
			'st_step_text_color'          => '', //テキスト色
			'st_step_text_bgcolor'        => '', //テキストの背景色
			'st_step_text_border_color'   => $basecolor, //ボーダー色
			'st_step_radius'              => 'yes', //角を丸くする

			//サイト管理者
			'st_author_profile'           => 'yes', //プロフィールカードに変更
			'st_author_profile_shadow'    => 'yes', //影をつける（プロフィールカード）

		);
	}
}