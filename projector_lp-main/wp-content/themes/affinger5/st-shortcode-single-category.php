<?php
$show_category_on_listing = (bool) trim( get_option( 'st-data125', '' ) ); // 記事一覧にカテゴリ表示
?>

<?php if ( $show_category_on_listing ): // カテゴリ表示 ?>
	<?php
	$categories = get_the_category();
	$separator  = ' ';
	$output     = '';
	?>

	<p class="st-catgroup itiran-category">
		<?php
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="'
				           . esc_attr( sprintf( 'View all posts in %s', $category->name ) )
				           . '" rel="category tag"><span class="catname st-catid' . esc_attr( $category->cat_ID ) . '">' . esc_html( $category->cat_name ) . '</span></a>' . $separator;
			}

			echo trim( $output, $separator );
		}
		?>
	</p>
<?php endif; ?>
