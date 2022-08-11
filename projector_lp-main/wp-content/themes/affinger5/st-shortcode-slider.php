<?php
$st_is_ex = st_is_ver_ex();
if ( ! function_exists( '_st_kanren_slider_create_options' ) ) {
	function _st_kanren_slider_create_options( $slides_to_show, $slide_center ) {
		return array(
			'slidesToShow' => $slides_to_show[0],
			'responsive'   => array(
				array(
					'breakpoint' => 960,
					'settings'   => array(
						'slidesToShow' => $slides_to_show[1],
					),
				),
				array(
					'breakpoint' => 560,
					'settings'   => array(
						'slidesToShow' => $slides_to_show[2],
						'centerMode'   => $slide_center,
					),
				),
			),
		);
	}
}

if ( ! function_exists( '_st_kanren_slider_get_options' ) ) {
	function _st_kanren_slider_get_options( $options = array() ) {
		$defaults = array(
			'slidesToShow'   => 3,
			'adaptiveHeight' => true,
			'autoplay'       => true,
			'dots'           => true,
			'responsive'     => array(),
			'centerMode'     => false,
		);

		$options = array_replace_recursive( $defaults, $options );

		usort(
			$options['responsive'],
			function ( $a, $b ) {
				if ( $a['breakpoint'] === $b['breakpoint'] ) {
					return 0;
				}

				return ( $a['breakpoint'] < $b['breakpoint'] ) ? 1 : - 1;
			}
		);

		$options['responsive'] = array_reduce(
			$options['responsive'],
			function ( $responsive, $current ) use ( $options ) {
				static $MAX_SLIDES_TO_SHOW = 3;

				$count                   = count( $responsive );
				$previous_slides_to_show = ( $count > 0 ) ? $responsive[ $count - 1 ]['settings']['slidesToShow'] : $options['slidesToShow'];
				$previous_slides_to_show = min( max( $previous_slides_to_show, 1 ), $MAX_SLIDES_TO_SHOW );
				$slides_to_show          = min( $current['settings']['slidesToShow'], $MAX_SLIDES_TO_SHOW );

				if ( $slides_to_show > $previous_slides_to_show ) {
					$current['settings']['slidesToShow'] = $previous_slides_to_show;
				}

				$responsive[] = $current;

				return $responsive;
			},
			array()
		);

		return $options;
	}
}

$is_rank          = ( isset( $is_rank ) && $is_rank );
$show_category    = ( isset( $show_category ) && $show_category );
$is_fullsize      = ( $fullsize_type !== '' );
$is_fullsize_card = ( $fullsize_type === 'card' );
$is_fullsize_text = ( $fullsize_type === 'text' );

$options = _st_kanren_slider_get_options( _st_kanren_slider_create_options( $slides_to_show, $slide_center ) );
$slick   = json_encode( $options, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );

$show_published_date = ( get_option( 'st-data140', '' ) === 'yes' );
$excerpt_class       = ! $is_fullsize ? ' has-excerpt' : '';
$date_class          = $slide_date ? ' has-date' : '';
$more_class          = ( $slide_more !== '' ) ? ' has-more' : '';
$rank_class          = $is_rank ? ' is-ranking' : '';
$center_mode_class   = $slide_center ? ' is-center-mode' : '';
$fullsize_class      = $is_fullsize ? ' is-fullsize' : '';
$fullsize_card_class = $is_fullsize_card ? ' is-fullsize-card' : '';
$fullsize_text_class = $is_fullsize_text ? ' is-fullsize-text' : '';
$class               = $excerpt_class . $date_class . $more_class . $rank_class . $center_mode_class .
                       $fullsize_class . $fullsize_card_class . $fullsize_text_class;
?>

<?php if ( $slide_query->have_posts() ): ?>
	<div class="slider post-slider content-post-slider<?php echo esc_attr( $class ); ?>"
	     data-slick="<?php echo esc_attr( $slick ); ?>">
		<?php while ( $slide_query->have_posts() ): $slide_query->the_post(); ?>
			<div class="slider-item post-slide">
				<div class="post-slide-image">
					<?php if ( $is_rank ): $rank = $slide_query->current_post + 1; ?>
						<span
							class="post-slide-rank post-slide-rank-<?php echo esc_attr( $rank ); ?>"><?php echo esc_html( $rank ); ?></span>
					<?php endif; ?>

					<a href="<?php the_permalink(); ?>">
						<?php echo _st_get_the_responsive_post_thumbnail( $slides_to_show, null, ! $is_fullsize ); ?>
					</a>

					<?php if ( $show_category ): ?>
						<?php st_get_template_part( 'st-shortcode-single-category' ); // カテゴリー ?>
					<?php endif; ?>

					<?php if ( $slide_date ): ?>

						<?php if( $st_is_ex ):
							$postID = $slide_query->post->ID;
							$updatewidgetset = get_post_meta( $postID, 'updatewidget_set', true );
						else:
							$updatewidgetset = '';
						endif;

						if ( trim ( $updatewidgetset ) === '' && ( get_the_date() != get_the_modified_date() ) ) : ?>
							<p class="post-slide-date"><i class="fa fa-refresh"></i><?php the_modified_date( 'Y/n/j' ); ?></p>
						<?php else: ?>
							<p class="post-slide-date"><i class="fa fa-clock-o"></i><?php the_time( 'Y/n/j' ); ?></p>
						<?php endif; ?>

					<?php endif; ?>

				</div>
				<?php if ( ! $is_fullsize_card ): ?>
					<div class="post-slide-body">
						<div class="post-slide-text">
							<p class="post-slide-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>

							<?php if ( ! $is_fullsize_text ): ?>
							<div class="post-slide-excerpt">
								<?php st_the_excerpt( null, 255 ); //抜粋文 ?>
							</div>
							<?php endif; ?>
						</div>

						<?php if ( ! $is_fullsize_text && $slide_more !== '' ): ?>
							<p class="post-slide-more">
								<a href="<?php the_permalink(); ?>"><?php echo esc_html( $slide_more ); ?></a>
							</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
<?php else: ?>
<?php endif; ?>
