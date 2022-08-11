<div class="kanren <?php st_marugazou_class(); //サムネイルを丸くする ?>">
	<?php
	if ( trim( $GLOBALS["stdata67"] ) !== '' ) {
		$newentrypost_no = $GLOBALS["stdata67"];
	} else {
		$newentrypost_no = 5;
	}

	if ( trim( $GLOBALS["stdata99"] ) !== '' ) {
		$category_ID = esc_attr( $GLOBALS["stdata99"] );
	} else {
		$category_ID = 0 ;
	}

	$args = array(
		'posts_per_page' => $newentrypost_no,
		'cat' => array($category_ID)
	);
	if(trim($GLOBALS['stdata215']) !== ''):
		$st_infeed = $GLOBALS['stdata215'];
	else:
		$st_infeed = '';
	endif;
	$st_infeed_count = 1;
	$st_query = new WP_Query( $args );
	?>
	<?php if ( $st_query->have_posts() ): ?>
		<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
			<?php //インフィード広告
			if( !is_404() && (is_active_sidebar( 26 ) && (trim($st_infeed) !== '')) && ($st_infeed_count % $st_infeed === 0) ){ ?>
				<div class="st-infeed-adunit">
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 26 ) ) : else : ?>
					<?php endif; ?>
				</div>
			<?php
			}
			$st_infeed_count ++;
			?>
			<dl class="clearfix">
				<dt><a href="<?php the_permalink() ?>">
						<?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
							<?php get_template_part( 'st-thumbnail' ); //アイキャッチ画像 ?>
						<?php else: // サムネイルを持っていないときの処理 ?>
							<?php if( trim($GLOBALS['stdata97']) !== '' ){ ?>
								<img src="<?php echo esc_url( ($GLOBALS['stdata97']) ); ?>" alt="no image" title="no image" width="100" height="100" />
							<?php }else{ ?>
								<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
							<?php } ?>
						<?php endif; ?>
					</a></dt>
				<dd>
					<?php if ( trim( $GLOBALS['stdata465']) === '' ) : get_template_part( 'st-single-category' ); endif; //カテゴリー ?>
					<h5 class="kanren-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<?php get_template_part( 'itiran-date' ); //投稿日 ?>
					<?php get_template_part( 'st-excerpt-side' ); //サイド抜粋 ?>
					<?php if ( isset( $GLOBALS['stdata465']) && $GLOBALS['stdata465'] === 'yes' ) :
						echo '<div class="st-catgroup-under">';
						get_template_part( 'st-single-category' ); //カテゴリー
						echo '</div>';
					endif; //カテゴリー ?>
				</dd>
			</dl>
		<?php endwhile; ?>
	<?php else: ?>
		<p>新しい記事はありません</p>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>