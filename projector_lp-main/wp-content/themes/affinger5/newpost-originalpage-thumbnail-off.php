<div class="kanren">
	<?php
	if ( trim( $GLOBALS["stdata93"] ) !== '' ) {
		$newentrypost_no = $GLOBALS["stdata93"];
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
			if( (is_active_sidebar( 26 ) && (trim($st_infeed) !== '')) && ($st_infeed_count % $st_infeed === 0) ){ ?>
				<div class="st-infeed-adunit">
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 26 ) ) : else : ?>
					<?php endif; ?>
				</div>
			<?php
			}
			$st_infeed_count ++;
			?>
		<div class="no-thumbitiran">
			<?php if ( trim( $GLOBALS['stdata465']) === '' ) : get_template_part( 'st-single-category' ); endif; //カテゴリー ?>
			<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				<?php get_template_part( 'itiran-date-tag' ); //投稿日 ?>

				<?php get_template_part( 'st-excerpt' ); //抜粋 ?>
				<?php if ( isset( $GLOBALS['stdata465']) && $GLOBALS['stdata465'] === 'yes' ) :
					echo '<div class="st-catgroup-under">';
					get_template_part( 'st-single-category' ); //カテゴリー
					echo '</div>';
				endif; //カテゴリー ?>
		</div>

		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	<?php else: ?>
		<p>新しい記事はありません</p>
	<?php endif; ?>
</div>
