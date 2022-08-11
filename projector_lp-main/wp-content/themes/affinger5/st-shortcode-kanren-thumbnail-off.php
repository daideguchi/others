<?php
$in_feed_ad_cycle = (int) trim( get_option( 'st-data216', '' ) ); 
$show_in_feed_ad = false;

$hide_excerpt_on_pc = (bool) trim( get_option( 'st-data202', '' ) );

$amp = amp_is_amp() ? 'amp' : null;
?>

<?php if ( $cat_group_query->have_posts() ): ?>
	<div class="kanren shortcode-kanren">
		<?php while ( $cat_group_query->have_posts() ): $cat_group_query->the_post(); ?>
			<?php if ( $show_in_feed_ad ): ?>
				<?php if ( ( $cat_group_query->current_post + 1 ) % $in_feed_ad_cycle === 0 && is_active_sidebar( 26 ) && ! amp_is_amp() ): ?>
					<div class="st-infeed-adunit">
						<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 26 ) ): else: ?><?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<div class="no-thumbitiran">
				<?php if ( trim( $GLOBALS['stdata465']) === '' ) : st_get_template_part( 'st-shortcode-single-category', $amp ); endif; //カテゴリー ?>

				<h5 class="kanren-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

				<?php get_template_part( 'st-excerpt' );    //抜粋 ?>

				<?php if ( isset( $GLOBALS['stdata465']) && $GLOBALS['stdata465'] === 'yes' ) :
					echo '<div class="st-catgroup-under">';
					st_get_template_part( 'st-shortcode-single-category', $amp ); //カテゴリー
					echo '</div>';
				endif; //カテゴリー ?>
			</div>

		<?php endwhile; ?>
	</div>
<?php else: ?>
<?php endif; ?>
