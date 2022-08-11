<?php
/*
Template Name:カスタム投稿一覧用
*/
$st_is_ex    = st_is_ver_ex();
$st_is_ex_af = st_is_ver_ex_af();
?>

<?php
// カスタム投稿一覧を表示したい固定ページで当テンプレートを選択して下さい
get_header(); ?>

<div id="content" class="clearfix">
	<div id="contentInner">
		<main>
			<article>
				<div id="st-page">

					<?php get_template_part( 'st-eyecatch' );    // アイキャッチ画像を挿入 ?>

					<?php if ( ! is_front_page() ): ?>
						<!--ぱんくず -->
						<div id="breadcrumb">
							<ol itemscope itemtype="http://schema.org/BreadcrumbList">
								<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a href="<?php echo home_url(); ?>" itemprop="item">
										<span itemprop="name"><?php echo esc_html( $GLOBALS['stdata141'] ); ?></span>
									</a>
									&gt;
									<meta itemprop="position" content="1"/>
								</li>
								<?php $i = 2; ?>
								<?php foreach ( array_reverse( get_post_ancestors( $post->ID ) ) as $parid ): ?>
									<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
										<a href="<?php echo get_page_link( $parid ); ?>"
										   title="<?php echo get_the_title(); ?>" itemprop="item">
											<span itemprop="name"><?php echo get_page( $parid )->post_title; ?></span>
										</a>
										&gt;
										<meta itemprop="position" content="<?php echo $i; ?>"/>
									</li>
									<?php $i ++; ?>
								<?php endforeach; ?>
							</ol>
						</div>
						<!--/ ぱんくず -->

					<?php else:    // フロントページの場合 ?>
						<div class="nowhits <?php st_noheader_class(); ?>">
							<?php get_template_part( 'popular-thumbnail' );    // 任意のエントリ ?>
						</div>

						<?php if ( is_active_sidebar( 12 ) ): ?>
							<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
								<?php dynamic_sidebar( 12 );    // トップ上部のウィジェット ?>
							<?php endif; ?>
						<?php endif; ?>

						<?php get_template_part( 'news-st' );    // お知らせ ?>
					<?php endif; ?>

					<!--ループ開始 -->
					<?php if ( have_posts() ): ?>
						<?php while ( have_posts() ): the_post(); ?>
							<h1 class="entry-title"><?php if ( $st_is_ex ): st_the_title(); else: the_title(); endif;    // タイトル ?></h1>

							<div class="mainbox">
								<?php if ( ! is_paged() ): ?>
									<div id="nocopy" <?php st_text_copyck(); ?>><!-- コピー禁止エリアここから -->
										<div class="entry-content">
											<?php st_the_content( array( 'page', 'main' ) );    // 本文 ?>
										</div>
									</div><!-- コピー禁止エリアここまで -->
								<?php endif; ?>

								<?php get_template_part( 'custompost-itiran-navi' );    // カスタム投稿一覧 ?>
								<?php get_template_part( 'st-pagenavi' );    // ページナビ読み込み ?>

								<?php get_template_part( 'st-ad-on' );    // 広告 ?>
								<?php get_template_part( 'st-kai-page' );    // 改ページ ?>

								<?php if ( is_active_sidebar( 6 ) ): ?>
									<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
										<?php dynamic_sidebar( 6 );    // 固定ページ一括ウィジェット ?>
									<?php endif; ?>
								<?php endif; ?>
							</div>

							<?php if ( isset( $GLOBALS['stplus'] ) && $GLOBALS['stplus'] === 'yes' ): ?>
								<?php get_template_part( 'st-rank' );    // ランキング ?>
							<?php endif; ?>

							<?php if ( isset( $GLOBALS['stdata69'] ) && $GLOBALS['stdata69'] === 'yes' ): ?>
								<?php get_template_part( 'sns' );    // ソーシャルボタン読み込み ?>
							<?php endif; ?>

							<?php // 任意のエントリ ?>
							<?php if ( ( ! is_front_page() && is_page() ) && ( isset( $GLOBALS['stdata41'] ) && $GLOBALS['stdata41'] === 'yes' ) ):    // 固定記事の場合 ?>
								<?php if ( isset( $GLOBALS['stdata5'] ) && $GLOBALS['stdata5'] === 'yes' ): ?>
									<?php get_template_part( 'popular-thumbnail-off' ); ?>
								<?php else: ?>
									<?php get_template_part( 'popular-thumbnail-on' ); ?>
								<?php endif; ?>
							<?php elseif ( ( is_home() || is_front_page() ) && ( isset( $GLOBALS['stdata59'] ) && $GLOBALS['stdata59'] === 'yes' ) ):    // トップ記事の場合 ?>
								<?php if ( isset( $GLOBALS['stdata5'] ) && $GLOBALS['stdata5'] === 'yes' ): ?>
									<?php get_template_part( 'popular-thumbnail-off' ); ?>
								<?php else: ?>
									<?php get_template_part( 'popular-thumbnail-on' ); ?>
								<?php endif; ?>
							<?php endif; ?>

						<?php endwhile; ?>
					<?php else: ?>
						<p>記事がありません</p>
					<?php endif; ?>
					<!--ループ終了 -->

					<?php if ( $GLOBALS['stdata6'] === '' ):    // コメント ?>
						<?php if ( comments_open() || get_comments_number() ): ?>
							<?php comments_template(); ?>
						<?php endif; ?>
					<?php endif; ?>

				</div>
				<!--/post-->

			</article>
		</main>
	</div>
	<!-- /#contentInner -->
	<?php get_sidebar(); ?>
</div>
<!--/#content -->
<?php get_footer(); ?>
