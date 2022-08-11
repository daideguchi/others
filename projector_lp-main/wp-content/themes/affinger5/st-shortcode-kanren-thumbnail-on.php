<?php

$in_feed_ad_cycle = (int) trim( get_option( 'st-data216', '' ) );
$show_in_feed_ad = false;

$default_thumbnail   = trim( get_option( 'st-data97', '' ) );
$hide_excerpt_on_pc  = (bool) trim( get_option( 'st-data202', '' ) );

$amp            = amp_is_amp() ? 'amp' : null;
?>

<?php if ( $cat_group_query->have_posts() ): ?>
	<div class="kanren shortcode-kanren <?php st_marugazou_class(); ?>">
		<?php while ( $cat_group_query->have_posts() ): $cat_group_query->the_post(); ?>

			<?php if ( $show_in_feed_ad ): ?>
				<?php if ( ( $cat_group_query->current_post + 1 ) % $in_feed_ad_cycle === 0 && is_active_sidebar( 26 ) && ! amp_is_amp() ): ?>
					<div class="st-infeed-adunit">
						<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 26 ) ): else: ?><?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<dl class="clearfix">
				<dt><a href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
							<?php get_template_part( 'st-thumbnail' ); //アイキャッチ画像 ?>
						<?php else: ?>
							<?php if(trim($GLOBALS['stdata97']) !== ''){ ?>
								<img src="<?php echo esc_url( ($GLOBALS['stdata97']) ); ?>" alt="no image" title="no image" width="100" height="100" />
							<?php }else{ ?>
								<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
							<?php } ?>
						<?php endif;  ?>
					</a></dt>
				<dd>
					<?php if ( trim( $GLOBALS['stdata465']) === '' ) : st_get_template_part( 'st-shortcode-single-category', $amp ); endif; //カテゴリー ?>

					<h5 class="kanren-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

					<?php get_template_part( 'st-excerpt' );    //抜粋 ?>

					<?php if ( isset( $GLOBALS['stdata465']) && $GLOBALS['stdata465'] === 'yes' ) :
						echo '<div class="st-catgroup-under">';
						st_get_template_part( 'st-shortcode-single-category', $amp ); //カテゴリー
						echo '</div>';
					endif; //カテゴリー ?>

				</dd>
			</dl>
		<?php endwhile; ?>
	</div>
<?php else: ?>
<?php endif; ?>
