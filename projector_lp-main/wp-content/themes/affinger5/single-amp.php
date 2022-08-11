<!doctype html>
<html amp <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8">

		<?php if ( trim( $GLOBALS['stdata124'] ) !== '' ): ?>
			<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
		<?php endif; ?>

		<script async src="https://cdn.ampproject.org/v0.js"></script>

		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
		<meta name="format-detection" content="telephone=no">

		<?php if ( is_home() && ! is_paged() ): ?>
			<meta name="robots" content="index,follow">
		<?php elseif ( is_search() || is_404() ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( ! is_category() && is_archive() ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( is_paged() ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( trim( $GLOBALS['stdata9'] ) !== '' && (int) $GLOBALS['stdata9'] === $post->ID ): ?>
			<meta name="robots" content="noindex,follow">
		<?php elseif ( is_category() && trim( $GLOBALS["stdata15"] ) !== '' ): ?>
			<meta name="robots" content="noindex,follow">
		<?php endif; ?>

		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="alternate" type="application/rss+xml" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
		<style amp-custom>
			<?php amp_custom_style(); ?>
		</style>

		<script async custom-element="amp-audio" src="https://cdn.ampproject.org/v0/amp-audio-0.1.js"></script>
		<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
		<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
		<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
		<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>

		<?php amp_get_template_part( 'st-ogp', 'amp' );    // OGP設定 ?>

		<?php amp_wp_head(); ?>
	</head>

	<body <?php body_class(); ?> >
		<div id="st-ami">
			<div id="wrapper" class="<?php st_wrap_class(); ?>">
				<div id="wrapper-in">
					<header id="<?php st_head_class(); ?>">
						<div id="headbox-bg">
							<div class="clearfix" id="headbox">

								<?php // アコーディオンメニュー ?>
								<?php if ( false ):    // [未対応] script 不可, 非 AMP ページ ?>
									<?php amp_get_template_part( 'st-accordion-menu', 'amp' ); ?>
								<?php endif; ?>

								<div id="header-l">
									<?php amp_get_template_part( 'st-header-logo', 'amp' );    // サイト名とディスクリプション ?>
								</div><!-- /#header-l -->
							</div><!-- /#headbox-bg -->
						</div><!-- /#headbox clearfix -->
					</header>

					<div id="content-w">
						<div id="content" class="clearfix">
							<div id="contentInner">

								<main>
									<article>
										<div id="post-<?php the_ID(); ?> st-post" <?php post_class(); ?>>

											<?php if ( trim( $GLOBALS['stdata217'] ) === '' ): ?>
												<?php amp_get_template_part( 'st-eyecatch', 'amp' );    // アイキャッチ画像を挿入 ?>
											<?php endif; ?>

											<!--ぱんくず -->
											<?php if ( false ):    // [未対応] 非 AMP ページ ?>
												<div id="breadcrumb">
													<ol itemscope itemtype="http://schema.org/BreadcrumbList">
														<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
															<a href="<?php echo home_url(); ?>" itemprop="item"><span itemprop="name">HOME</span></a>
															&gt;
															<meta itemprop="position" content="1" />
														</li>
														<?php
														$category = get_the_category();
														$cat_id   = (int) $category[0]->cat_ID;
														$cat_ids  = array( $cat_id );

														while ( ! $cat_id === 0 ) {
															$category  = get_category( $cat_id );
															$cat_id    = $category->parent;
															$cat_ids[] = $cat_id;
														}

														array_pop( $at_ids );

														$cat_ids = array_reverse( $cat_ids );
														$i       = 2;
														?>

														<?php foreach ( $cat_ids as $cat_id ): ?>
															<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
																<a href="<?php echo get_category_link( $cat_id ); ?>" itemprop="item">
																	<span itemprop="name"><?php echo esc_html( get_cat_name( $cat_id ) ); ?></span>
																</a>
																&gt;
																<meta itemprop="position" content="<?php echo $i; ?>"/>
															</li>
															<?php $i ++; ?>
														<?php endforeach; ?>
													</ol>
												</div>
											<?php endif; ?>
											<!--/ ぱんくず -->

											<!--ループ開始 -->
											<?php if ( have_posts() ): ?>
											<?php while ( have_posts() ): the_post(); ?>

											<?php // カテゴリ表示 ?>
											<?php if ( false ):    // [未対応] 非 AMP ページ ?>
												<?php if ( ! isset( $GLOBALS['stdata60'] ) || $GLOBALS['stdata60'] !== 'yes' ): ?>
													<?php
													$categories = get_the_category();
													$separator  = ' ';
													$output     = '';
													?>
													<p class="st-catgroup">
														<?php
														if ( $categories ) {
															foreach ( $categories as $category ) {
																$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="'
																           . esc_attr( sprintf( "View all posts in %s", $category->name ) )
																           . '" rel="category tag"><span class="catname st-catid' . $category->cat_ID . '">' . $category->cat_name . '</span></a>' . $separator;
															}

															echo trim( $output, $separator );
														}
														?>
													</p>
												<?php endif;    // カテゴリ表示ここまで ?>
											<?php endif; ?>

											<h1 class="entry-title"><?php the_title();    // タイトル ?></h1>

											<?php get_template_part( 'itiran-date-singular' );    // 投稿日 ?>

											<?php if ( trim( $GLOBALS['stdata217'] ) !== '' ): ?>
												<?php amp_get_template_part( 'st-eyecatch-under', 'amp' );    // アイキャッチ画像を挿入 ?>
											<?php endif; ?>

											<div class="mainbox">

												<?php if ( amp_is_amp() && trim( $GLOBALS['stdata203'] ) === '' ):    // AMPページが表示されている場合 ?>
													<?php remove_filter( 'post_link', 'amp_post_link', PHP_INT_MAX ); ?>
													<p class="st-defaultlink"><a href="<?php the_permalink(); ?>">完全版を表示する</a></p>
													<?php add_filter( 'post_link', 'amp_post_link', PHP_INT_MAX, 3 ); ?>
												<?php endif; ?>

												<div id="nocopy">
													<div class="entry-content">
														<?php the_content();    // 本文 ?>
													</div>
												</div>

												<?php amp_get_template_part( 'st-kai-page', 'amp' );    // 改ページ ?>
												<?php amp_get_template_part( 'st-ad', 'amp' );    // AMP用広告 ?>

											</div><!-- .mainboxここまで -->

											<?php amp_get_template_part( 'sns', 'amp' );    // AMP用ソーシャルボタン読み込み ?>
											<?php amp_get_template_part( 'popular-thumbnail', 'amp' );    // 任意のエントリ ?>

											<?php if ( false ):    // [未対応] 非 AMP ページ ?>
												<p class="tagst">
													<i class="fa fa-folder-open-o" aria-hidden="true"></i>-<?php the_category( ', ' ) ?>
													<br />
													<?php the_tags( '<i class="fa fa-tags"></i>-', ', ' ); ?>
												</p>
											<?php endif; ?>

											<aside>

												<?php if ( false ):    // [未対応] 非 AMP ページ ?>
													<?php // 著者リンク ?>
													<?php st_author(); ?>
												<?php endif; ?>

												<?php endwhile; ?>
												<?php else: ?>
													<p>記事がありません</p>
												<?php endif; ?>
												<!--ループ終了-->

												<?php // コメント ?>
												<?php if ( false ):    // [未対応] form, script 不可 ?>
													<?php if ( $GLOBALS['stdata6'] === '' ): ?>
														<?php if ( comments_open() || get_comments_number() ): ?>
															<?php comments_template(); ?>
														<?php endif; ?>
													<?php endif; ?>
												<?php endif; ?>

												<!--関連記事-->
												<?php amp_get_template_part( 'kanren', 'amp' ); ?>

												<!--ページナビ-->
												<div class="p-navi clearfix">
													<dl>
														<?php $prev_post = get_previous_post(); ?>
														<?php if ( ! empty( $prev_post ) ): ?>
															<dt>PREV</dt>
															<dd>
																<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo $prev_post->post_title; ?></a>
															</dd>
														<?php endif; ?>

														<?php $next_post = get_next_post(); ?>
														<?php if ( ! empty( $next_post ) ): ?>
															<dt>NEXT</dt>
															<dd>
																<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo $next_post->post_title; ?></a>
															</dd>
														<?php endif; ?>
													</dl>
												</div>
											</aside>

										</div>
										<!--/post-->
									</article>
								</main>
							</div>
							<!-- /#contentInner -->

							<!-- サイドバー -->
							<div id="side">
								<aside>
									<div id="mybox">
										<?php if ( is_active_sidebar( 19 ) ): ?>
											<div class="side-topad">
												<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
													<?php dynamic_sidebar( 19 );    // AMP用サイドバーウィジェット ?>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</div>
								</aside>
							</div>
							<!-- /#side -->

							<!-- サイドバーここまで -->

						</div>
						<!--/#content -->

						<!-- フッター -->
					</div><!-- /contentw -->
					<footer>
						<div id="footer">
							<div id="footer-in">
								<?php amp_get_template_part( 'st-footer-link', 'amp' );    // フッターリンク ?>
								<?php amp_get_template_part( 'st-footer-content', 'amp' );    // フッターのメインコンテンツ ?>
							</div>
							<p class="rcopy">Copyright&copy;<?php bloginfo( 'name' ); ?>,<?php echo date( 'Y' ); ?>	All Rights Reserved.</p>
						</div>
					</footer>

				</div>
				<!-- /#wrapperin -->
			</div>
			<!-- /#wrapper -->
		</div><!-- /#st-ami -->

		<!-- ページトップへ戻る -->
		<?php if ( false ):    // [未対応] script 不可 ?>
			<?php if ( trim( $GLOBALS['stdata109'] ) === '' ): ?>
				<div id="page-top"><a href="#wrapper" class="fa fa-angle-up"></a></div>
			<?php endif; ?>
		<?php endif; ?>
		<!-- ページトップへ戻る　終わり -->

		<!-- AMP用Analyticsコード -->
		<?php if ( trim( $GLOBALS['stdata124'] ) !== '' ): ?>
			<amp-analytics type="googleanalytics" id="analyticsaf">
				<script type="application/json">
				{
					"vars": {
					"account": "UA-<?php echo esc_js( $GLOBALS['stdata124'] ); ?>"
					},
					"triggers": {
						"trackPageview": {
						"on": "visible",
						"request": "pageview"
						}
					}
				}
				</script>
			</amp-analytics>
		<?php endif; ?>
		<!-- AMP用Analyticsコードここまで -->

		<?php amp_wp_footer(); ?>
	</body>
</html>

