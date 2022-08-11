<?php
/**
 * 記事スライドショー
 */

// スライドショーの設定
$transition      = get_option( 'st-data267', 'fade' );
$speed_ms        = (int) get_option( 'st-data268', 5000 );
$cat_ids         = get_option( 'st-data269', '' );
$hide_categories = ( get_option( 'st-data270', '' ) === 'yes' );
$hide_date       = ( get_option( 'st-data271', '' ) === 'yes' );
$is_wide         = ( get_option( 'st-data272', '' ) === 'yes' );
$is_overlaid     = ( get_option( 'st-data273', '' ) === 'yes' );

// Slick の設定
$options = array(
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'adaptiveHeight' => true,
	'autoplay'       => true,
	'dots'           => false,
	'autoplaySpeed'  => $speed_ms,
	'fade'           => ( $transition === 'fade' ),
	'rtl'            => ( $transition === 'ltr' ),
);
$slick   = json_encode( $options, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );

// 属性
$dir_attr          = ( $transition === 'ltr' ) ? ' dir="rtl"' : '';
$dir_attr_opposite = ( $transition === 'ltr' ) ? ' dir="ltr"' : '';
$transition_class  = ' is-' . $transition;
$cat_class         = $hide_categories ? '' : ' has-cat';
$date_class        = $hide_date ? '' : ' has-date';
$wide_class        = $is_wide ? ' is-wide' : '';
$overlay_class     = $is_overlaid ? ' is-overlaid' : '';
$class             = $transition_class . $cat_class . $date_class . $wide_class . $overlay_class;

// クエリ
list( $including_ids, $excluding_ids ) = _st_parse_cat_id_string( $cat_ids );

$cat_posts_query = new WP_Query( array(
	'post_type'           => 'post',
	'category__in'        => $including_ids,
	'category__not_in'    => $excluding_ids,
	'orderby'             => 'date',
	'order'               => 'DESC',
	'posts_per_page'      => 10, /* 表示件数 */
	'ignore_sticky_posts' => true,
) );

// クラス
$show_published_date = ( get_option( 'st-data140', '' ) === 'yes' ); // 更新日がある場合も投稿日を表示する

// ヘッダーの設定
$show_on_all_pages  = ( get_option( 'st-data18', '' ) === 'yes' ); // 下層ページにもヘッダー画像を表示する
$hide_on_mobile     = ( get_option( 'st-data71', '' ) === 'yes' ); // スマホ・タブレット閲覧時は非表示にする
$hide_header_images = ( get_option( 'st-data76', '' ) === 'yes' ); // ヘッダー画像を全て非表示にする

// ナビゲーションの設定
$nav_position = get_option( 'st-data35', '' ); // PC 用グローバルメニュー
$show_nav     = ( ! st_is_mobile() && $nav_position !== 'kesu' ); // ナビゲーションを表示

// 表示
$show_slider = ( ! $hide_header_images && ( is_home() || is_front_page() || $show_on_all_pages ) && ( ! st_is_mobile() || ! $hide_on_mobile ) ); // スライダーを表示
$show_header = ( $show_nav || $show_slider ); // ヘッダー (#gazou-wide) を表示
?>

<?php if ( $show_header ): ?>
	<div id="gazou-wide">
		<?php if ( $nav_position === '' ): // メニューを上に設定している場合 ?>
			<?php get_template_part( 'st-header-menu' ); // カスタムヘッダーメニュー  ?>
		<?php endif; ?>

		<?php if ( $show_slider ): ?>
			<?php if ( $cat_posts_query->have_posts() ): ?>
				<div id="st-headerbox">
					<div id="st-header">
						<div class="header-post-slider-container">
							<div class="slider post-slider header-post-slider has-excerpt<?php echo esc_attr( $class ); ?>"
								 data-slick="<?php echo esc_attr( $slick ); ?>"<?php echo $dir_attr; ?>>
								<?php
								$default_thumbnail = trim( get_option( 'st-data97', '' ) ); // デフォルトのサムネイル画像
								$no_img            = get_template_directory_uri() . '/images/no-img.png'; // No Image
								$size              = 1060; // サイズ
								?>

								<?php while ( $cat_posts_query->have_posts() ): $cat_posts_query->the_post(); ?>
									<?php // サムネイル
									$image_class = '';

									if ( has_post_thumbnail() ) {
										$post_thumbnail = get_the_post_thumbnail( null, 'full' );
										$image_class    = ' has-image';
									} elseif ( $default_thumbnail !== '' ) {
										$post_thumbnail = sprintf(
											'<img src="%s" alt="no image" title="no image" width="%s" height="%s">',
											esc_url( $default_thumbnail ),
											$size,
											$size
										);
									} else {
										$post_thumbnail = sprintf(
											'<img src="%s" alt="no image" title="no image" width="%s" height="%s">',
											esc_url( $no_img ),
											$size,
											$size
										);
									}
									?>

									<div class="slider-item post-slide<?php echo esc_attr( $image_class ); ?>"<?php echo $dir_attr_opposite; ?>>
										<div class="post-slide-image">
											<a href="<?php the_permalink(); ?>"><?php echo $post_thumbnail; ?></a>
										</div>
										<div class="post-slide-body">
											<div class="post-slide-body-content">
												<div class="post-slide-text">
													<?php if ( ! $hide_categories ): ?>
														<?php
														$categories = get_the_category();
														$links      = array();
														?>

														<p class="st-catgroup itiran-category">
															<?php
															foreach ( $categories as $category ) {
																$links[] = '<a href="' . get_category_link( $category->term_id ) . '" title="'
																		   . esc_attr( sprintf( 'View all posts in %s', $category->name ) )
																		   . '" rel="category tag"><span class="catname st-catid' . esc_attr( $category->cat_ID ) . '">' . esc_html( $category->cat_name ) . '</span></a>';
															}

															echo implode( ' ', $links );
															?>
														</p>
													<?php endif; ?>

													<p class="post-slide-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>

													<?php if ( ! $hide_date ): ?>
														<?php if ( ! $show_published_date && get_the_date() !== get_the_modified_date() ): // 更新がある場合 ?>
															<p class="post-slide-date"><i class="fa fa-refresh"></i><?php the_modified_date( 'Y/n/j' ); ?></p>
														<?php else: ?>
															<p class="post-slide-date"><i class="fa fa-clock-o"></i><?php the_time( 'Y/n/j' ); ?></p>
														<?php endif; ?>
													<?php endif; ?>

													<div class="post-slide-excerpt">
														<?php st_the_excerpt( null, 255 ); // 抜粋文 ?>
													</div>
												</div>

												<p class="post-slide-more">
													<a href="<?php the_permalink(); ?>">ReadMore</a>
												</p>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $nav_position === 'bottom' ): // メニューを上に設定している場合 ?>
			<?php get_template_part( 'st-header-menu' ); // カスタムヘッダーメニュー  ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
