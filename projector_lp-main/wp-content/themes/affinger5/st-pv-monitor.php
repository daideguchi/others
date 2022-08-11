<?php
use St\Plugin\AffiliateManager\Tracker\Query\QueryTypeIds;

$plugin_meta = $container['pv_monitor.plugin.meta'];

$rankingDefinitions = [
	[
		'title'   => '本日',
		'ranking' => $daily_ranking,
	],
	[
		'title'   => '週間',
		'ranking' => $weekly_ranking,
	],
	[
		'title'   => '月間',
		'ranking' => $monthly_ranking,
	],
];

$pvm_classes = [];

$pvm_classes[] = $show_pv ? 'has-pv' : '';

$pvm_classes     = array_filter( $pvm_classes );
$pvm_class_value = ( count( $pvm_classes ) > 0 ) ? ( ' ' . implode( ' ', $pvm_classes ) ) : '';
?>

<div class="st-pvm<?php echo esc_attr( $pvm_class_value ); ?>" data-st-pvm>

	<div class="st-pvm-nav">
		<ul class="st-pvm-nav-list">
			<?php $index = 0; ?>
			<?php foreach ( $rankingDefinitions as $rankingDefinition ): ?>
				<?php if ( $rankingDefinition['ranking'] ): ?>
					<?php
					$index ++;
					$nav_data_attr = ( $index === 1 ) ? ' data-st-pvm-is-active' : '';
					?>

					<li class="st-pvm-nav-item" data-st-pvm-nav="<?php echo esc_attr( $index ); ?>"<?php echo $nav_data_attr; ?>>
						<?php echo esc_html( $rankingDefinition['title'] ); ?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="st-pvm-rankings">
		<?php $index = 0; ?>
		<?php foreach ( $rankingDefinitions as $rankingDefinition ): ?>
			<?php
			$ranking = $rankingDefinition['ranking'];
			?>

			<?php if ( $ranking ): ?>
				<?php
				$index ++;
				$ranking_data_attr = ( $index === 1 ) ? ' data-st-pvm-is-active' : '';
				?>

				<div class="st-pvm-ranking" data-st-pvm-id="<?php echo esc_attr( $index ); ?>"<?php echo $ranking_data_attr; ?>>
					<div class="st-pvm-ranking-body">

						<?php if ( $ranking->hasItems() ): $item_index = 0; ?>
							<ol class="st-pvm-ranking-list">

								<?php foreach ( $ranking->getItems() as $rank => $item ): $item_index ++; ?>

									<?php
									$query = $item->getQuery();

									$query_type_id = $query->getType()->getId();

									$queried_id = $query->getQueriedId();

									$source = $item->getSource();

									$singular_query_type_ids = [
										QueryTypeIds::SINGLE,
										QueryTypeIds::PAGE,
										QueryTypeIds::SINGULAR,
									];

									$is_singular = in_array( $query_type_id, $singular_query_type_ids, true );

									$tax_archive_query_type_ids = [
										QueryTypeIds::TAXONOMY,
										QueryTypeIds::CATEGORY,
										QueryTypeIds::TAG,
									];

									$is_tax_archive = in_array( $query_type_id, $tax_archive_query_type_ids, true );

									$post_thumbnail = '<img src="' . get_template_directory_uri() . '/images/no-img.png" width="300" height="300" alt="no image" title="no image">';

									$excerpt = '';

									if ( $is_singular ) {
										$_post = get_post( $queried_id );

										$globals = [
											'post'      => isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null,
											'page'      => isset( $GLOBALS['page'] ) ? $GLOBALS['page'] : null,
											'pages'     => isset( $GLOBALS['pages'] ) ? $GLOBALS['pages'] : null,
											'more'      => isset( $GLOBALS['more'] ) ? $GLOBALS['more'] : null,
											'multipage' => isset( $GLOBALS['multipage'] ) ? $GLOBALS['multipage'] : null,
										];

										$GLOBALS['post']      = $_post;
										$GLOBALS['page']      = 1;
										$GLOBALS['pages']     = [
											preg_replace( '/<!--more(.*?)?-->/', '', $_post->post_content ),
										];
										$GLOBALS['more']      = false;
										$GLOBALS['multipage'] = false;

										ob_start();
										get_template_part( 'st-excerpt-side' );
										$excerpt = ob_get_clean();

										if ( has_post_thumbnail() ) {
											ob_start();
											get_template_part( 'st-thumbnail' );
											$post_thumbnail = ob_get_clean();
										}

										$GLOBALS['post']      = $globals['post'];
										$GLOBALS['page']      = $globals['page'];
										$GLOBALS['pages']     = $globals['pages'];
										$GLOBALS['more']      = $globals['more'];
										$GLOBALS['multipage'] = $globals['multipage'];
									} elseif ( $is_tax_archive ) {

										$excerpt        = strip_tags( do_shortcode( term_description( $queried_id ) ) );
										$excerpt_length = apply_filters( 'excerpt_length', 55 );
										$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
										$excerpt        = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
										$excerpt        = '<div class="smanone st-excerpt"><p>' . $excerpt . '</p></div>';
									}

									$has_excerpt = ( trim( $excerpt ) !== '' );

									$item_classes = [
										'st-pvm-ranking-item-' . $item_index,
									];

									$item_classes[] = $has_excerpt ? 'has-excerpt' : '';

									$item_classes     = array_filter( $item_classes );
									$item_class_value = ( count( $item_classes ) > 0 )
										? ( ' ' . implode( ' ', $item_classes ) )
										: '';
									?>

									<li class="st-pvm-ranking-item<?php echo esc_attr( $item_class_value ); ?>">
										<a class="st-pvm-ranking-item-image"
										   href="<?php echo esc_url( $source->getUrl() ); ?>">
											<?php echo $post_thumbnail;  ?>
										</a>

										<div class="st-pvm-ranking-item-body">
											<p class="st-pvm-ranking-item-h">
												<a class="st-pvm-ranking-item-title"
												   href="<?php echo esc_url( $source->getUrl() ); ?>">
													<?php echo esc_html( $source->getTitle() ); ?>
												</a>

												<?php if ( $show_pv ): ?>
													<span class="st-pvm-ranking-item-pv"><!--
													 --><span
															class="st-pvm-ranking-item-pv-number"><?php echo esc_html( number_format( $item->getPv() ) ); ?></span><!--
													 --><span class="st-pvm-ranking-item-pv-unit">PV</span><!--
												  --></span>
												<?php endif; ?>
											</p>

											<?php if ( $has_excerpt ): ?>
												<div class="st-pvm-ranking-item-excerpt">
													<?php echo $excerpt; ?>
												</div>
											<?php endif; ?>
										</div>

									</li>

								<?php endforeach; ?>

							</ol>

						<?php else: ?>
							<p class="st-pvm-ranking-no-result">計測データがありません。</p>
						<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
