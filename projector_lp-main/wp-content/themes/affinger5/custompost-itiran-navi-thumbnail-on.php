<div class="kanren <?php st_marugazou_class(); //サムネイルを丸くする ?>">
	<?php
	if ( trim( $GLOBALS["stdata106"] ) !== '' ) {
		$custompost_name = $GLOBALS["stdata106"];
	} else {
		$custompost_name = '';
	}
	if ( trim( $GLOBALS["stdata107"] ) !== '' ) {
		$custompost_no = $GLOBALS["stdata107"];
	} else {
		$custompost_no = 20;
	}
	$args = array(
		'posts_per_page' => $custompost_no,
		'post_type' => $custompost_name, /* 表示する投稿タイプを指定 */
		'paged' => get_query_var( 'paged' ),/* ページネーションする場合は必須 */
	);
	$query = new WP_Query( $args );
	?>
	<?php if ( $query->have_posts() ): ?>
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
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
					<?php get_template_part( 'itiran-date' ); //投稿日 ?>
					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

					<?php get_template_part( 'st-excerpt' ); //抜粋 ?>

				</dd>
			</dl>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	<?php else: ?>
		<p>新しい記事はありません</p>
	<?php endif; ?>
	<?php get_template_part( 'st-pagenavi' ); //ページナビ読み込み ?>
</div>
