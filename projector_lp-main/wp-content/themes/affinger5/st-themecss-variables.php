<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$st_header_image             = get_option( 'st_header_image', '' );            //ヘッダーエリアの背景画像
$st_headerbg_image           = get_option( 'st_headerbg_image', '' );          //headerの背景画像
$st_headerunder_image        = get_option( 'st_headerunder_image', '' );       //ヘッダー以下の背景画像
$st_footer_image             = get_option( 'st_footer_image', '' );            //フッターの背景画像
$st_slidemenubg_image        = get_option( 'st_slidemenubg_image', '' );       //スライドメニューの背景画像
$st_entry_content_bg_image   = get_option( 'st_entry_content_bg_image', '' );  //記事エリアの背景画像
$st_header_card_image        = get_option( 'st_header_card_image', '' );       //ヘッダー画像エリア下の背景画像
$st_menu_smartbar_bg_image   = get_option( 'st_menu_smartbar_bg_image', '' );  //スマホメニューバーの背景画像

//記事タイトル
$st_entrytitle_bgimg = get_option( 'st_entrytitle_bgimg', '' ); //記事タイトルの背景画像
$st_h2_bgimg         = get_option( 'st_h2_bgimg', '' );         //h2の背景画像
$st_h3_bgimg         = get_option( 'st_h3_bgimg', '' );         //h3の背景画像
$st_h4_bgimg         = get_option( 'st_h4_bgimg', '' );         //h4の背景画像
$st_h5_bgimg         = get_option( 'st_h5_bgimg', '' );         //h5の背景画像
$st_h4_matome_bgimg  = get_option( 'st_h4_matome_bgimg', '' );  //まとめの背景画像
$st_widgets_title_bgimg  = get_option( 'st_widgets_title_bgimg', '' );  //ウィジェットタイトルの背景画像

//メニュー
$st_headermenu_bgimg = get_option( 'st_headermenu_bgimg', '' ); //ヘッダーメニューの背景画像
$st_sidemenu_bgimg   = get_option( 'st_sidemenu_bgimg', '' );   //サイドメニュー第一階層の背景画像
$st_sidebg_bgimg     = get_option( 'st_sidebg_bgimg', '' );     //サイドメニューの背景画像
$st_topgabg_image    = get_option( 'st_topgabg_image', '' );    //ヘッダー画像の背景画

//プロフィール
$st_author_profile_header      = get_option( 'st_author_profile_header', '' );       //サイドメニューの背景画像
$st_author_profile_avatar      = get_option( 'st_author_profile_avatar', '' );        //ヘッダー画像の背景画
$st_author_profile_btn_url     = get_option( 'st_author_profile_btn_url', '' );     //「プロフィールカード」のURL
$st_author_profile_btn_text    = get_option( 'st_author_profile_btn_text', '' );    //「プロフィールカード」のボタンテキスト

$st_theme_kantan_setting = st_get_kantan_setting();
$_defaults               = st_get_theme_mod_defaults( $st_theme_kantan_setting );
$_overrides              = array();
$_maps                   = st_get_var_theme_mod_maps();

switch ( true ) {
	case ( $st_theme_kantan_setting === 'zentai' ):
		$_overrides = st_get_zentai_theme_mod_overrides();

		break;

	case ( $st_theme_kantan_setting === 'menuonly' ):
		$_overrides = st_get_menuonly_theme_mod_overrides();

		break;

	case ( $st_theme_kantan_setting === 'defaultcolor' ):

	case ( $st_theme_kantan_setting === '' ):
		if ( is_customize_preview() ) {
			$_overrides = st_create_default_theme_mod_diff($_defaults);
		}

		break;

	default:

		break;
}

extract( st_create_theme_mod_var_array( $_defaults, $_maps, $_overrides ), EXTR_OVERWRITE );
