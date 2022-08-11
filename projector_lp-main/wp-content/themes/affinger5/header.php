<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="i7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> <?php st_html_class(); ?>>
	<!--<![endif]-->
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
		<meta charset="<?php bloginfo( 'charset' ); ?>" >
		<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,viewport-fit=cover">
		<meta name="format-detection" content="telephone=no" >

		<?php if ( ( is_front_page() || is_home() ) && !is_paged() ): ?>
			<meta name="robots" content="index,follow">
		<?php elseif ( is_search() or is_404() ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( !is_category() && !is_tag() && is_archive() ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( is_paged() ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( is_attachment() ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( ! is_front_page() && trim($GLOBALS["stdata9"]) !== '' &&  ($GLOBALS["stdata9"]) == $post->ID ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( is_category() && trim($GLOBALS["stdata15"]) !== ''): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( is_tag() && trim($GLOBALS["stdata420"]) !== ''): ?>
			<meta name="robots" content="noindex,follow">
		<?php endif; ?>

		<link rel="alternate" type="application/rss+xml" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" >
		<!--[if lt IE 9]>
		<script src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/js/html5shiv.js"></script>
		<![endif]-->
		<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
		<?php wp_head(); ?>
		<?php get_template_part( 'analyticstracking' ); //アナリティクスコード ?>
		<?php get_template_part( 'st-ogp' ); //OGP設定 ?>
		<?php get_template_part( 'st-richjs' ); //効果追加 ?>
		<?php get_template_part( 'a-header-code' ); //ヘッダーに挿入するコード ?>
	</head>
	<body <?php body_class(); ?> >
	<?php if( (!st_is_mobile()) && (trim($GLOBALS['stdata110']) !== '') && (trim($GLOBALS['stdata111']) !== '') ): //動画用ID ?>
		<div id="st-player">
	<?php endif; ?>
			<div id="st-ami">
				<div id="wrapper" class="<?php st_wrap_class(); ?>">
				<div id="wrapper-in">
					<header id="<?php st_head_class(); ?>">
						<div id="headbox-bg">
							<div class="clearfix" id="headbox">
								<?php get_template_part( 'st-accordion-menu' ); //アコーディオンメニュー ?>
									<div id="header-l">
										<?php get_template_part( 'st-header-logo' ); //サイト名とディスクリプション ?>
									</div><!-- /#header-l -->
								<div id="header-r" class="smanone">
									<?php if ( has_nav_menu( 'primary-menu-side' ) && isset($GLOBALS['stdata428']) && $GLOBALS['stdata428'] === 'yes' ):
										get_template_part( 'st-footer-link-design' ); //ヘッダー用メニュー（横列）
									else:
										if ( isset($GLOBALS['stdata43']) && $GLOBALS['stdata43'] === 'yes' ) :
											get_template_part( 'st-footer-link' ); //フッターリンク
											get_template_part( 'st-header-widget' ); //電話番号とヘッダー用ウィジェット
										else:
											get_template_part( 'st-header-widget' ); //電話番号とヘッダー用ウィジェット
										endif;
									endif; ?>
								</div><!-- /#header-r -->
							</div><!-- /#headbox-bg -->
						</div><!-- /#headbox clearfix -->

						<?php if( is_single() or is_page() ){ //一括挿入ウィジェットの表示確認
							$postID = $wp_query->post->ID;
							$ikkatuwidgetset = get_post_meta( $postID, 'ikkatuwidget_set', true );
						}else{
							$ikkatuwidgetset = '';
						} 
						?>

						<?php if (( is_active_sidebar( 31 ) ) && ( trim( $ikkatuwidgetset ) === '' )) : //ヘッダー画像エリア上ウィジェットが設定されている場合 ?>
							<div id="st-header-top-widgets-box">
								<div class="st-content-width">
									<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 31 ) ) : else : // ヘッダー画像上 ?>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( has_nav_menu( 'primary-menu-side' ) && isset($GLOBALS['stdata469']) && $GLOBALS['stdata469'] === 'yes' && wp_is_mobile() ): ?>
							<div id="st-mobile-link-design">
								<?php get_template_part( 'st-footer-link-design' ); //モバイル用ヘッダー用メニュー（横列） ?>
							</div>
						<?php endif; ?>

						<?php if ( $GLOBALS['stdata250'] !== 'bottom' && wp_is_mobile() && ( isset($GLOBALS['stdata154']) && $GLOBALS['stdata154'] === 'yes' ) ) {
							get_template_part( 'st-smartmiddle-menu' ); //ミドルリンク上
						} ?>

					<?php if ( $GLOBALS['stdata266'] === 'yes' ): // 記事スライドショーが有効の場合 ?>
						<?php get_template_part( 'st-header-slider' ); ?>
					<?php else: ?>
						<?php get_template_part( 'st-header-image' ); //カスタムヘッダー画像 ?>
					<?php endif; ?>

					<?php if ( ( isset($GLOBALS['stdata250']) && $GLOBALS['stdata250'] === 'bottom' ) && wp_is_mobile() && ( isset($GLOBALS['stdata154']) && $GLOBALS['stdata154'] === 'yes' ) ) {
						get_template_part( 'st-smartmiddle-menu' ); //ミドルリンク下
					} ?>

					</header>

					<?php get_template_part( 'st-header-cardlink' ); //ヘッダーカードリンク ?>

					<div id="content-w">

					<?php get_template_part( 'st-ad-smart-head' ); //スマホ上の広告 ?>

					<?php if ( is_active_sidebar( 28 ) ) : //ウィジェットが設定されている場合?>
						<div id="st-header-under-widgets-box">
							<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 28 ) ) : else : // ヘッダー画像下 ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php get_template_part( 'st-header-post-data' ); //記事ごとのヘッダーデザイン ?>

						<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-170192187-2">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-170192187-2');
</script>
