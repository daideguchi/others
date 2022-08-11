<?php
$tag_post_ids       = array_map( 'intval', explode( ',', $atts['id'] ) );
$tag_post_ids_count = count( $tag_post_ids );
?>

<?php if ( $tag_post_ids_count > 0 ):     ?>

	<?php if ( $atts['label'] !== '' ):    ?>
		<h3 class="rankh3"><span class="rankh3-in"><?php echo esc_html( $atts['label'] ); ?></span></h3>
	<?php endif; ?>

	<?php if ( $atts['name'] !== '' ):     ?>
		<div class="rank-guide"><?php echo esc_html( $atts['name'] ); ?></div>
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

		<div class="rankid<?php echo esc_attr($rank); ?>">
			<?php if (st_tag_plugin_has_raw_html($tag_post)):  ?>
				<?php st_tag_plugin_the_tag($raw_html, $tag_post, st_tag_plugin_get_tag_type_slug('raw'), $source);  ?>
				<?php st_tag_plugin_the_beacon($tag_post, st_tag_plugin_get_tag_type_slug('raw'));  ?>
			<?php elseif (!st_tag_plugin_has_nothing($tag_post) || $description_2 !== ''):  ?>
				<div class="rankst-box post">

					<?php if ($heading !== ''):  ?>
						<h4 class="rankh4"><?php echo esc_html($heading); ?><br><?php echo $star_html; ?></h4>
					<?php endif; ?>

					<?php if (st_tag_plugin_has_banner($tag_post)):  ?>
						<div class="clearfix rankst">
							<div class="rankst-l">
								<?php st_tag_plugin_the_tag($banner_html, $tag_post, st_tag_plugin_get_tag_type_slug('banner'), $source); ?>
							</div>
							<?php if ($description !== ''):   ?>
								<div class="rankst-r">
									<div class="rankst-cont"><?php echo $description; ?></div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ($description_2 !== ''): ?>
						<div class="rankst-contb"><?php echo $description_2; ?></div>
					<?php endif; ?>

					<?php if (st_tag_plugin_has_text_link($tag_post) && st_tag_plugin_has_detail_link($tag_post)): ?>
						<div class="clearfix rankst">
							<div class="rankstlink-l">
								<p><?php st_tag_plugin_the_tag($detail_link_html, $tag_post, st_tag_plugin_get_tag_type_slug('raw'), $source);  ?></p>
							</div>
							<div class="rankstlink-r">
								<p><?php st_tag_plugin_the_tag($text_link_html, $tag_post, st_tag_plugin_get_tag_type_slug('text'), $source);  ?></p>
							</div>
						</div>
					<?php elseif (st_tag_plugin_has_text_link($tag_post)): ?>
						<div class="clearfix rankst">
							<div class="rankstlink-a">
								<p><?php st_tag_plugin_the_tag($text_link_html, $tag_post, st_tag_plugin_get_tag_type_slug('text'), $source); ?></p>
							</div>
						</div>
					<?php elseif (st_tag_plugin_has_detail_link($tag_post)): ?>
						<div class="clearfix rankst">
							<div class="rankstlink-b">
								<p><?php st_tag_plugin_the_tag($detail_link_html, $tag_post, st_tag_plugin_get_tag_type_slug('raw'), $source); ?></p>
							</div>
						</div>
					<?php endif; ?>

					<?php if (!st_tag_plugin_has_nothing($tag_post)): ?>
						<?php st_tag_plugin_the_beacon($tag_post, st_tag_plugin_get_the_tag_type($tag_post)); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

	<?php endfor; ?>

<?php else: ?>
<?php endif; ?>
