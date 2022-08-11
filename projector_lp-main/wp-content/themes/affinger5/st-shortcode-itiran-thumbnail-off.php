<?php
$st_is_ex = st_is_ver_ex();
$in_feed_ad_cycle = (int) trim( get_option( 'st-data214', '' ) );
$show_in_feed_ad = false;

$hide_excerpt_on_pc       = (bool) trim( get_option( 'st-data202', '' ) );
$show_category_on_listing = (bool) trim( get_option( 'st-data125', '' ) );

$amp = amp_is_amp() ? 'amp' : null;
?>
<?php if ( $post_group_query->have_posts() ): ?>
	<div class="kanren shortcode-kanren">
		<?php while ( $post_group_query->have_posts() ): $post_group_query->the_post(); ?>
			<?php if ( $show_in_feed_ad ): ?>
				<?php if ( ( $post_group_query->current_post + 1 ) % $in_feed_ad_cycle === 0 && is_active_sidebar( 26 ) && ! amp_is_amp() ): ?>
					<div class="st-infeed-adunit">
						<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 26 ) ): else: ?><?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<div class="no-thumbitiran">
				<?php if ( trim( $GLOBALS['stdata465']) === '' ) : st_get_template_part( 'st-shortcode-single-category', $amp ); endif; //カテゴリー ?>

				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<div class="blog_info <?php st_hidden_class(); ?>">
						<p>
							<?php if( $st_is_ex ):
								$postID = $post_group_query->post->ID;
								$updatewidgetset = get_post_meta( $postID, 'updatewidget_set', true );
							else:
								$updatewidgetset = '';
							endif;

							if ( trim ( $updatewidgetset ) === '' && ( get_the_date() != get_the_modified_date() ) ) : ?>
								<i class="fa fa-refresh"></i><?php the_modified_date( 'Y/n/j' ); ?>
							<?php else: ?>
								<i class="fa fa-clock-o"></i><?php the_time( 'Y/n/j' ); ?>
							<?php endif; ?>
								&nbsp;<span class="pcone"><?php the_tags( '<i class="fa fa-tags"></i>&nbsp;', ', ' ); ?></span>
						</p>
				</div>

				<?php get_template_part( 'st-excerpt' );    //抜粋 ?>
				<?php if ( isset( $GLOBALS['stdata465']) && $GLOBALS['stdata465'] === 'yes' ) :
					echo '<div class="st-catgroup-under">';
					st_get_template_part( 'st-shortcode-single-category', $amp ); //カテゴリー
					echo '</div>';
				endif; //カテゴリー ?>
			</div>

		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
<?php else: ?>
<?php endif; ?>
