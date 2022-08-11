<?php //カテゴリ表示
	if ( isset($GLOBALS['stdata125']) && $GLOBALS['stdata125'] === 'yes' ) :

		$categories = get_the_category();
		$separator = ' ';
		$output = ''; ?>

		<span class="st-catgroup itiran-category news-st-category">
		<?php
		if ( $categories ) {
			foreach( $categories as $category ) {
				$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' 
				. esc_attr( sprintf( "View all posts in %s", $category->name ) ) 
				. '" rel="category tag"><span class="catname st-catid' . $category->cat_ID . '">' . $category->cat_name . '</span></a>' . $separator;
			}
		echo trim( $output, $separator );
		} ?>
		</span>

<?php endif; ?>