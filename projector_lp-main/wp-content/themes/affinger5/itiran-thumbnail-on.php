<?php
	if(trim($GLOBALS['stdata214']) !== ''):
		$st_infeed = $GLOBALS['stdata214'];
	else:
		$st_infeed = '';
	endif;
	$st_infeed_count = 1;
?>
<div class="kanren <?php st_marugazou_class(); //サムネイルを丸くする ?>">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
		<dl class="clearfix">
			<dt><a href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
						<?php get_template_part( 'st-thumbnail' ); //アイキャッチ画像 ?>
					<?php else: // サムネイルを持っていないときの処理 ?>
						<?php if(trim($GLOBALS['stdata97']) !== ''){ ?>
							<img src="<?php echo esc_url( ($GLOBALS['stdata97']) ); ?>" alt="no image" title="no image" width="100" height="100" />
						<?php }else{ ?>
							<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
						<?php } ?>
					<?php endif; ?>
				</a></dt>
			<dd>
				<?php if ( trim( $GLOBALS['stdata465']) === '' ) : get_template_part( 'st-single-category' ); endif; //カテゴリー ?>
				<h3><a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a></h3>

				<?php get_template_part( 'itiran-date-tag' ); //投稿日 ?>

				<?php get_template_part( 'st-excerpt' ); //抜粋 ?>
				<?php if ( isset( $GLOBALS['stdata465']) && $GLOBALS['stdata465'] === 'yes' ) :
					echo '<div class="st-catgroup-under">';
					get_template_part( 'st-single-category' ); //カテゴリー
					echo '</div>';
				endif; //カテゴリー ?>
			</dd>
		</dl>
	<?php endwhile;
	else: ?>

	<?php endif; ?>
</div>
