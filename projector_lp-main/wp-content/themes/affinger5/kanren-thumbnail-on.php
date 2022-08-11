<?php

$query   = isset( $query ) ? $query : $GLOBALS['wp_query'];
$classes = isset( $classes ) ? $classes : array();

$uuid = wp_generate_uuid4();

$in_feed_ad_per = max( 0, (int) trim( get_option( 'st-data216', '0' ) ) );

$show_in_feed_ad = ( ! amp_is_amp() && is_active_sidebar( 26 ) );
$show_in_feed_ad = ( $show_in_feed_ad && $in_feed_ad_per > 0 );
$postID = get_the_ID();
$koukoku_set = get_post_meta( $postID, 'koukoku_set', true );
if ( isset( $koukoku_set ) && $koukoku_set === 'yes' ):
	$show_in_feed_ad = '';
endif;

$wpp_view_limit = trim( get_option( 'st-data223', '' ) );
$wpp_view_limit = ( $wpp_view_limit !== '' ) ? (int) $wpp_view_limit : 9999;

$wpp_view_limit_label = trim( get_option( 'st-data224', '' ) );
$wpp_view_limit_label = ( $wpp_view_limit_label !== '' ) ? $wpp_view_limit_label : '殿堂';

$show_wpp_view_count = ( trim( get_option( 'st-data227', '' ) ) === 'yes' );

$default_thumbnail_url = trim( get_option( 'st-data97', '' ) );

$load_more_enabled     = ( trim( get_option( 'st-data421', '' ) ) === 'yes' );
$load_more_loading_img = get_theme_file_uri( 'images/st_loading.gif' );

$default_classes = array(
	'kanren',
	st_get_marugazou_class(),    // サムネイルを丸くする
);

$classes = array_unique( array_filter( array_merge( $default_classes, $classes ) ) );
$class   = implode( ' ', $classes );
?>

<div class="<?php echo esc_attr( $class ); ?>" data-st-load-more-content
     data-st-load-more-id="<?php echo esc_attr( $uuid ); ?>">
	<?php if ( $query->have_posts() ): $offset = _st_query_calculate_offset( $query ); ?>
		<?php while ( $query->have_posts() ): $query->the_post(); ?>
			<?php if ( $show_in_feed_ad && ( ( $offset + $query->current_post + 1 ) % $in_feed_ad_per === 0 ) ): ?>
				<div class="st-infeed-adunit">
					<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
						<?php dynamic_sidebar( 26 ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<dl class="clearfix">
				<dt><a href="<?php the_permalink() ?>">
						<?php if ( has_post_thumbnail() ):    // サムネイルを持っているときの処理 ?>

							<?php if ( function_exists( 'wpp_get_views' ) && $show_wpp_view_count && ! amp_is_amp() ): ?>
								<div class="st-wppviews-label">
									<div class="st-wppviews-text">
										<?php if ( wpp_get_views( get_the_ID() ) > $wpp_view_limit ): ?>
											<span
												class="wpp-views-limit"><?php echo esc_html( $wpp_view_limit_label ); ?></span>
										<?php else: ?>
											<span class="wpp-views"><?php echo wpp_get_views( get_the_ID() ); ?><span
													class="wpp-text">view</span></span>
										<?php endif; ?>
									</div>

									<?php get_template_part( 'st-thumbnail' );    // アイキャッチ画像
									?>
								</div>

							<?php else: ?>
								<?php get_template_part( 'st-thumbnail' );    // アイキャッチ画像 ?>
							<?php endif; ?>

						<?php else:    // サムネイルを持っていないときの処理 ?>

							<?php if ( function_exists( 'wpp_get_views' ) && $show_wpp_view_count && ! amp_is_amp() ): ?>
								<div class="st-wppviews-label">
									<div class="st-wppviews-text">
										<?php if ( wpp_get_views( get_the_ID() ) > $wpp_view_limit ): ?>
											<span
												class="wpp-views-limit"><?php echo esc_html( $wpp_view_limit_label ); ?></span>
										<?php else: ?>
											<span class="wpp-views"><?php echo wpp_get_views( get_the_ID() ); ?><span
													class="wpp-text">view</span></span>
										<?php endif; ?>
									</div>

									<?php if ( $default_thumbnail_url !== '' ): ?>
										<img src="<?php echo esc_url( $default_thumbnail_url ); ?>" alt="no image"
										     title="no image" width="100" height="100"/>
									<?php else: ?>
										<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png"
										     alt="no image" title="no image" width="100" height="100"/>
									<?php endif; ?>
								</div>

							<?php else: ?>

								<?php if ( $default_thumbnail_url !== '' ): ?>
									<img src="<?php echo esc_url( $default_thumbnail_url ); ?>" alt="no image"
									     title="no image" width="100" height="100"/>
								<?php else: ?>
									<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png"
									     alt="no image" title="no image" width="100" height="100"/>
								<?php endif; ?>

							<?php endif; ?>

						<?php endif;    // サムネイルを持っていないときの処理ここまで ?>
					</a></dt>
				<dd>
					<?php if ( trim( $GLOBALS['stdata465']) === '' ) : get_template_part( 'st-single-category' ); endif; //カテゴリー ?>

					<h5 class="kanren-t">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h5>

					<?php get_template_part( 'st-excerpt' );    //抜粋 ?>
					<?php if ( isset( $GLOBALS['stdata465']) && $GLOBALS['stdata465'] === 'yes' ) :
						echo '<div class="st-catgroup-under">';
						get_template_part( 'st-single-category' ); //カテゴリー
						echo '</div>';
					endif; //カテゴリー ?>
				</dd>
			</dl>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	<?php else: ?>
		<p>関連記事はありませんでした</p>
	<?php endif; ?>
</div>

<?php if ( !amp_is_amp() && $load_more_enabled && _st_query_has_next_page( $query ) ): ?>
	<?php $options = wp_json_encode( _st_load_more_get_kanren_posts_options( $_post, $query ) ); ?>
	<div class="load-more-action kanren-load-more-action">
		<button class="load-more-btn" data-st-load-more="<?php echo esc_attr( $options ); ?>"
		        data-st-load-more-controls="<?php echo esc_attr( $uuid ); ?>"
		        data-st-load-more-loading-img="<?php echo esc_attr( $load_more_loading_img ); ?>">もっと読む
		</button>
	</div>
<?php endif; ?>
