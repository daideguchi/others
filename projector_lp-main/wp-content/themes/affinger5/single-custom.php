<?php
/**
 *カスタム投稿用です
 *β版なので自己責任でご利用下さい
 */
$st_is_ex    = st_is_ver_ex();
$st_is_ex_af = st_is_ver_ex_af();
?>

<?php get_header(); ?>

<div id="content" class="clearfix">
	<div id="contentInner">
		<main>
			<article>
				<?php $classes = array( 'post', 'st-custom' ); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>

					<?php
					$post_id            = get_queried_object_id();
					$show_ikkatu_widget = false;
					$show_post_info     = ( get_post_meta( $post_id, 'post_data_updatewidget_set', true ) === 'yes' );    // ヘッダーに記事データ挿入

					if ( is_single() || is_page() ) {
						$show_ikkatu_widget = ( get_post_meta( $post_id, 'ikkatuwidget_set', true ) !== 'yes' );    // 一括挿入ウィジェットの表示確認

						if ( trim( $GLOBALS['stdata423'] ) !== '' ) {    // 「記事ごとのヘッダーデザイン」一括設定が有効
							$show_post_info = true;
						}
					}
					?>

					<?php if ( ! $show_post_info && ( trim( $GLOBALS['stdata423'] ) === '' && trim( $GLOBALS['stdata217'] ) === '' ) ): ?>
						<?php get_template_part( 'st-eyecatch' );    // アイキャッチ画像を挿入 ?>
					<?php endif; ?>

					<?php if ( $show_ikkatu_widget && is_active_sidebar( 16 ) ): ?>
						<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
							<?php dynamic_sidebar( 16 );    // 投稿ページ上一括ウィジェット ?>
						<?php endif; ?>
					<?php endif; ?>

					<!--ぱんくず -->
					<div id="breadcrumb"<?php if ( $show_post_info ): ?> class="st-post-data-breadcrumb"<?php endif; ?>>
						<ol itemscope itemtype="http://schema.org/BreadcrumbList">
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a href="<?php echo esc_url( home_url() ); ?>" itemprop="item">
									<span itemprop="name"><?php echo esc_html( $GLOBALS['stdata141'] ); ?></span>
								</a>
								&gt;
								<meta itemprop="position" content="1"/>
							</li>
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a href="<?php echo get_post_type_archive_link( $post_type ); ?>" itemprop="item">
									<span itemprop="name"><?php echo esc_html( get_post_type_object( get_post_type() )->label ); ?></span>
								</a>
								&gt;
								<meta itemprop="position" content="2"/>
							</li>
						</ol>

						<?php if ( $show_post_info ):    // ヘッダーに記事データ挿入時はhetry用に出力 ?>
							<h1 class="entry-title st-css-no"><?php if ( $st_is_ex ): st_the_title(); else: the_title(); endif;    // タイトル ?></h1>
						<?php endif; ?>
					</div>
					<!--/ ぱんくず -->

					<!--ループ開始 -->
					<?php if (have_posts()): ?>
					<?php while (have_posts()): the_post(); ?>

					<?php if ( ! $show_post_info ): // 記事情報を表示が無効 ?>
						<p class="st-catgroup">
							<?php $taxonomy = '';    // 分類で設定したタクソノミー名称 ?>
							<?php echo get_the_term_list( $post->ID, $taxonomy ); ?>
						</p>

						<h1 class="entry-title"><?php if ( $st_is_ex ): st_the_title(); else: the_title(); endif;    // タイトル ?></h1>

						<?php get_template_part( 'itiran-date-singular' );    // 投稿日 ?>
					<?php else:    // ヘッダーに記事データ挿入時はhetry用に出力 但しdisplay:none ?>
						<div style="display:none;"><?php get_template_part( 'itiran-date-singular' );    // 投稿日 ?></div>
					<?php endif; ?>

					<div class="mainbox">
						<div id="nocopy" <?php st_text_copyck(); ?>><!-- コピー禁止エリアここから -->
							<?php if ( ! $show_post_info && ( trim( $GLOBALS['stdata423'] ) === '' && trim( $GLOBALS['stdata217'] ) !== '' ) ): ?>
								<?php get_template_part( 'st-eyecatch-under' ); ?>
							<?php endif;    // アイキャッチ画像を挿入 ?>

							<div class="entry-content">
								<?php st_the_content( array( 'single', 'custom', 'main' ) );    // 本文 ?>
							</div>
						</div><!-- コピー禁止エリアここまで -->

						<?php get_template_part( 'st-kai-page' );    // 改ページ ?>
						<?php get_template_part( 'st-ad-on' );    // 広告 ?>

						<?php if ( $show_ikkatu_widget && is_active_sidebar( 5 ) ): ?>
							<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
								<?php dynamic_sidebar( 5 );    // 投稿ページ一括ウィジェット ?>
							<?php endif; ?>
						<?php endif; ?>

					</div><!-- .mainboxここまで -->

					<?php if ( isset( $GLOBALS['stplus'] ) && $GLOBALS['stplus'] === 'yes' ): ?>
						<?php get_template_part( 'st-rank' );    // ランキング ?>
					<?php endif; ?>

					<?php get_template_part( 'sns' );    // ソーシャルボタン読み込み ?>
					<?php get_template_part( 'popular-thumbnail' );    // 任意のエントリ ?>

					<aside>
						<?php st_author();    // 著者リンク ?>

						<?php endwhile; ?>
						<?php else: ?>
							<p>記事がありません</p>
						<?php endif; ?>
						<!--ループ終了-->

						<?php if ( $GLOBALS['stdata6'] === '' ):    // コメント ?>
							<?php if ( comments_open() || get_comments_number() ): ?>
								<?php comments_template(); ?>
							<?php endif; ?>
						<?php endif; ?>

						<!--新着記事-->
						<h4 class="point"><span class="point-in">新着一覧</span></h4>
						<?php get_template_part( 'custompost-itiran' ); ?>

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
	<?php get_sidebar(); ?>
</div>
<!--/#content -->
<?php get_footer(); ?>
