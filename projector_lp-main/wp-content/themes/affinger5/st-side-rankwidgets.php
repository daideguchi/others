<?php
$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
$title = apply_filters( 'widget_title', $title, $instance, $wp_widget->id_base );

$tag_post_ids = isset( $instance['tag_post_ids'] ) ? $instance['tag_post_ids'] : '';
$tag_post_ids = array_map( 'intval', explode( ',', $tag_post_ids ) );

$tag_post_ids_count = count( $tag_post_ids );
?>

<?php if ( $tag_post_ids_count > 0 ):  ?>

	<div class="st_side_rankwidgets">
		<?php if ( $title ) : ?>
			<p class="rankh3 rankwidgets-title"><?php echo $title; ?></p>
		<?php endif; ?>

		<?php for ( $i = 0, $rank = 0; $i < $tag_post_ids_count; $i ++ ): ?>
			<?php
			$tag_post = get_post( $tag_post_ids[ $i ] ); 

			if ( ! $tag_post ) { 
				continue;
			}

			$rank ++;

			$heading   = st_tag_plugin_get_the_heading( $tag_post ); 
			$star_html = st_tag_plugin_get_the_star_html( $tag_post ); 

			$description   = st_tag_plugin_get_the_description( $tag_post ); 
			$description_2 = st_tag_plugin_get_the_description_2( $tag_post );

			$banner_html    = st_tag_plugin_get_the_raw_banner_html( $tag_post ); 
			$text_link_html = st_tag_plugin_get_the_raw_text_link_html( $tag_post );
			$detail_link_html = st_tag_plugin_get_the_raw_detail_link_html( $tag_post );

			$raw_html = st_tag_plugin_get_the_raw_raw_html( $tag_post );

			$is_wysiwyg_editor_disabled = st_tag_plugin_is_wysiwyg_editor_disabled( $tag_post );

			$source = st_tag_plugin_get_the_source();
			?>

			<div class="st_rankside st_rankside<?php echo esc_attr($rank); ?> clearfix">
				<?php if (st_tag_plugin_has_raw_html($tag_post)):  ?>
					<?php st_tag_plugin_the_tag($raw_html, $tag_post, st_tag_plugin_get_tag_type_slug('raw'), $source); ?>
					<?php st_tag_plugin_the_beacon($tag_post, st_tag_plugin_get_tag_type_slug('raw')); ?>
				<?php elseif (!st_tag_plugin_has_nothing($tag_post) || $description_2 !== ''): ?>
					<div class="rankst-box post">
				
						<?php if (st_tag_plugin_has_banner($tag_post)): ?>
						<div class="rankwidgets-poprank">
							<span class="rankwidgets-no rankwidgets-side-rank<?php echo esc_attr($rank); ?>"><?php echo esc_html($rank); ?></span>
							<?php st_tag_plugin_the_tag($banner_html, $tag_post, st_tag_plugin_get_tag_type_slug('banner'), $source); ?>
						</div>
						<div class="st_rankside_r">
						<?php else: ?>
							<div class="st_rankside_all">
						<?php endif; ?>
						
							<?php if (st_tag_plugin_has_text_link($tag_post)): ?>
								<p class="rankwidgets-item"><?php st_tag_plugin_the_tag($text_link_html, $tag_post, st_tag_plugin_get_tag_type_slug('text'), $source); ?>
									<?php if ($star_html !== ''): ?>
										<br/><?php echo $star_html; ?>
									<?php endif; ?>
								</p>
							<?php endif; ?>

							<?php if ($description !== ''): ?>
								<div class="rankwidgets-cont"><?php echo $description; ?>
									<?php if (st_tag_plugin_has_detail_link($tag_post)): ?>
										<span><?php st_tag_plugin_the_tag($detail_link_html, $tag_post, st_tag_plugin_get_tag_type_slug('raw'), $source); ?></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						
							<?php if (!st_tag_plugin_has_nothing($tag_post)): ?>
								<?php st_tag_plugin_the_beacon($tag_post, st_tag_plugin_get_the_tag_type($tag_post)); ?>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

		<?php endfor; ?>

	</div>

<?php else: ?>
<?php endif; ?>
