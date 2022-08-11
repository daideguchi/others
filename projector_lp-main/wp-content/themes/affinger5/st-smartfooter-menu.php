<?php 
//スマホ用フッター追尾メニュー
if( wp_is_mobile() && ( trim($GLOBALS['stdata143']) === 'yes') ):
	$footer_set_menu = array(
		'container' => 'nav',
		'container_class' => 'st-footer-ul',
		'theme_location' => 'smartphone-footermenu',
		'depth'           => 1,
	);
	$footer_none_menu = array(
		'container' => 'nav',
		'container_class' => 'st-footer-ul',
		'depth'           => 1,
	);

	if ( has_nav_menu( 'smartphone-footermenu' ) ) : //メニューセットあり ?>
		<div id="st-footermenubox">
				<?php wp_nav_menu( $footer_set_menu ); ?>
		</div>
	<?php else : //メニューセットなし ?>
		<div id="st-footermenubox">
			<?php wp_nav_menu( $footer_none_menu ); ?>
		</div>
	<?php endif;

else:

	//ページトップへ戻る
	if( get_theme_mod( 'st_pagetop_hidden' ) ): else: //ページトップへのボタンを表示しない ?>
		<?php if ( get_option( 'st_pagetop_img' ) ): //ロゴ画像がある時 ?>
			<div id="page-top" class="page-top-img"><a href="#wrapper"><img src="<?php echo esc_url( get_option( 'st_pagetop_img' ) ); ?>" data-st-lazy-load="false"></a></div>
		<?php else: //ロゴ画像が無い時 ?>
			<div id="page-top"><a href="#wrapper" class="fa fa-angle-up"></a></div>
		<?php endif;
	endif;

endif;
