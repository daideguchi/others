<?php
$heading          = get_option( 'st-data38', '' );
$post_id_string   = trim( get_option( 'st-data37', '' ) );
$show_views       = trim( get_option( 'st-data228', '' ) );
$view_limit       = get_option( 'st-data223', '' );
$view_limit_label = get_option( 'st-data224', '' );
?>

<div class="kanren pop-box <?php st_marugazou_class(); //サムネイルを丸くする ?>">
	<?php if ( trim( stripslashes( $heading ) ) !== '' ): ?>
		<?php $popname = st_esc_html_i( stripslashes( $heading ) ); ?>
		<p class="p-entry-t"><span class="p-entry"><?php echo $popname; ?></span></p>
	<?php endif; ?>

	<?php
	if ( $post_id_string !== '' ) {
		$popid  = $post_id_string;
		$popids = explode( ',', $popid );
	} else {
		$popids = '';
	}

	$poprank_no = '1';
	?>

	<?php if ( is_array( $popids ) ): ?>
		<?php foreach ( $popids as $popid_no ): ?>
			<?php
			$posts_query = new WP_Query( array(
				'post_type'    => array( 'post', 'page', 'template' ),
				'post__in'     => array_map( 'intval', explode( ',', $popid_no ) ), //指定IDを含む投稿のみ
				'post__not_in' => get_option( 'sticky_posts' ),
			) );
			?>

			<?php while ( $posts_query->have_posts() ): $posts_query->the_post(); ?>

				<dl class="clearfix">
					<dt class="poprank">
						<a href="<?php the_permalink() ?>">
							<?php
							if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>

								<?php if ( $show_views !== '' && function_exists( 'wpp_get_views' ) && ! amp_is_amp() ): ?>
									<?php
									$st_wppview_limit       = ! empty( $view_limit ) ? $view_limit : '9999';
									$st_wppview_limit_label = ! empty( $view_limit_label ) ? $view_limit_label : '殿堂';
									?>
									<div class="st-wppviews-label">
										<div class="st-wppviews-text">
											<?php if ( wpp_get_views( get_the_ID() ) > (int) $st_wppview_limit ): ?>
												<span class="wpp-views-limit"><?php echo esc_html( $st_wppview_limit_label ); ?></span>
											<?php else: ?>
												<span class="wpp-views"><?php echo wpp_get_views( get_the_ID() ); ?><span class="wpp-text">view</span></span>
											<?php endif; ?>
										</div>

										<?php get_template_part( 'st-thumbnail' ); //アイキャッチ画像 ?>
									</div>

								<?php else: ?>
									<?php get_template_part( 'st-thumbnail' ); //アイキャッチ画像 ?>
								<?php endif; ?>

							<?php else: // サムネイルを持っていないときの処理 ?>

								<?php if ( $show_views !== '' && function_exists( 'wpp_get_views' ) && ! amp_is_amp() ): ?>
									<?php
									$st_wppview_limit       = ! empty( $view_limit ) ? $view_limit : '9999';
									$st_wppview_limit_label = ! empty( $view_limit_label ) ? $view_limit_label : '殿堂';
									?>
									<div class="st-wppviews-label">
										<div class="st-wppviews-text">
											<?php if ( wpp_get_views( get_the_ID() ) > (int) $st_wppview_limit ): ?>
												<span class="wpp-views-limit"><?php echo esc_html( $st_wppview_limit_label ); ?></span>
											<?php else: ?>
												<span class="wpp-views"><?php echo wpp_get_views( get_the_ID() ); ?><span class="wpp-text">view</span></span>
											<?php endif; ?>
										</div>

										<?php if ( trim( $GLOBALS['stdata97'] ) !== '' ): ?>
											<img src="<?php echo esc_url( ( $GLOBALS['stdata97'] ) ); ?>" alt="no image" title="no image" width="100" height="100"/>
										<?php else: ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100"/>
										<?php endif; ?>
									</div>

								<?php else: ?>

									<?php if ( trim( $GLOBALS['stdata97'] ) !== '' ): ?>
										<img src="<?php echo esc_url( ( $GLOBALS['stdata97'] ) ); ?>" alt="no image" title="no image" width="100" height="100"/>
									<?php else: ?>
										<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100"/>
									<?php endif; ?>

								<?php endif; ?>

							<?php endif; // サムネイルを持っていないときの処理ここまで ?>
						</a>

						<?php if ( $show_views  !== '' && function_exists( 'wpp_get_views' ) ): ?>
						<?php else: //view表示が無ければランキングを表示 ?>
							<span class="poprank-no"><?php echo $poprank_no; ?></span>
						<?php endif; ?>
					</dt>
					<dd>
						<h5 class="popular-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

						<?php get_template_part( 'st-excerpt-popular' ); //おすすめ記事抜粋 ?>
					</dd>
				</dl>

				<?php $poprank_no ++; ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php endforeach; ?>

	<?php endif; ?>

</div>
