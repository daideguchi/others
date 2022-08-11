<?php
/**
 * 記事ごとのヘッダーデザイン
 *
 */
$st_is_ex    = st_is_ver_ex();
$st_is_ex_af = st_is_ver_ex_af();
?>

<?php if ( ! is_front_page() && ( is_single() || is_page() ) ): ?>
	<?php
	$post_id = get_queried_object_id();

	if ( trim( $GLOBALS['stdata423'] ) === 'yes' ) {
		$show_post_info = true;
		$post_header_bg = 'thumbnail_dark';
	} else {
		$show_post_info = ( get_post_meta( $post_id, 'post_data_updatewidget_set', true ) === 'yes' );
		$post_header_bg = get_post_meta( $post_id, 'st_post_header_under_bg', true );
	};

	if ( st_is_mobile() ) {
		$st_topgabg_image_fix_set = '';
	} else {
		$st_topgabg_image_fix_set = get_theme_mod( 'st_topgabg_image_fix', '' );
	};

	$st_topgabg_image_url = get_option( 'st_topgabg_image', '' );

	if ( has_post_thumbnail() ) {
		$thumbnail_url = get_the_post_thumbnail_url( $post_id, 'full' );
	} elseif ( $st_topgabg_image_url ) {
		$thumbnail_url = $st_topgabg_image_url;
	} else {
		$thumbnail_url = '';
	};

	if ( $st_topgabg_image_fix_set ) {
		$st_topgabg_image_fix_css = '';
	} else {
		$st_topgabg_image_fix_css = '';
	};

	if ( $post_header_bg === 'thumbnail' && $thumbnail_url ) {
		$post_header_bg_css   = 'background:url("' . $thumbnail_url . '");background-size:cover;background-position: center center;' . $st_topgabg_image_fix_css;
		$post_header_bg_class = '';
	} elseif ( $post_header_bg === 'thumbnail_dark' && $thumbnail_url ) {
		$post_header_bg_css   = 'background:url("' . $thumbnail_url . '");background-size:cover;background-position: center center;' . $st_topgabg_image_fix_css;
		$post_header_bg_class = 'st-dark';
	} else {
		$post_header_bg_css   = '';
		$post_header_bg_class = '';
	};
	?>

	<?php if ( $show_post_info ): ?>
		<div id="st-header-post-under-box" class="st-header-post-data <?php echo esc_attr( $post_header_bg_class ); ?>"
		     style="<?php echo esc_attr( $post_header_bg_css ); ?>">
			<div class="st-content-width st-dark-cover">

				<?php if ( ! isset( $GLOBALS['stdata60'] ) || $GLOBALS['stdata60'] !== 'yes' ): ?>
					<?php
					$categories = get_the_category();
					$separator  = ' ';
					$output     = '';
					?>

					<p class="st-catgroup">
						<?php
						if ( $categories ) {
							foreach ( $categories as $category ) {
								$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="'
								           . esc_attr( sprintf( "View all posts in %s", $category->name ) )
								           . '" rel="category tag"><span class="catname st-catid' . $category->cat_ID . '">' . $category->cat_name . '</span></a>' . $separator;
							}

							echo trim( $output, $separator );
						}
						?>
					</p>

				<?php endif; ?>

				<p class="entry-title heder-post-data-title"><?php if ( $st_is_ex ): st_the_title(); else: the_title(); endif; ?></p>

				<?php get_template_part( 'itiran-date-singular' ); ?>
			</div>
		</div>
	<?php else: ?>
		<div id="st-header-post-under-box" class="st-header-post-no-data <?php echo $post_header_bg_class; ?>"
		     style="<?php echo esc_attr( $post_header_bg_css ); ?>">
			<div class="st-dark-cover">
				<?php st_post_header_under_code(); ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
