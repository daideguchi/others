<?php
/**
 * @var St\Plugin\Custom_Search\Plugin\Plugin_Meta $plugin_meta
 * @var St\Plugin\Custom_Search\Search\Search_Query $search_query
 * @var array<string, mixed> $atts
 */

$classes = [];

if ( $atts['layout'] !== '' ) {
	$classes[] = 'st-custom-search-box-' . $atts['layout'];
}

if ( $atts['template'] !== '' ) {
	$classes[] = 'st-custom-search-box-tpl-' . $atts['template'];
} else {
	$classes[] = 'st-custom-search-box-tpl-default';
}

$classes[] = 'st-custom-search-box-cat-' . $atts['cat_mode'];

$classes = array_unique( $classes );
$class   = ( count( $classes ) > 0 ) ? ' ' . implode( ' ', $classes ) : '';
?>

<div class="st-custom-search-box<?= esc_attr( $class ); ?>">
	<form class="cs-form" method="get" action="<?= esc_url( st_cs_get_search_url() ); ?>">
		<?php if ( $atts['title'] !== '' ): ?>
			<h4 class="menu_underh2"><?= esc_html( $atts['title'] ); ?></h4>
		<?php endif; ?>

		<?php if ( $atts['show_text_input'] ): ?>
			<div class="cs-text">
				<input class="cs-text-input s" type="search" placeholder="検索するテキストを入力"
				       name="<?= esc_attr( st_cs_get_query_var_name( 'keyword' ) ); ?>"
				       value="<?php the_search_query(); ?>">
			</div>
		<?php else: ?>
			<input type="hidden" name="<?= esc_attr( st_cs_get_query_var_name( 'keyword' ) ); ?>" value="">
		<?php endif; ?>

		<?php if ( $atts['cat_mode'] === 'children' ):    // `children`. ?>
			<?php
			$parent_children = st_cs_get_category_parent_children( [
				'orderby' => 'slug',
				'exclude' => implode( ',', $atts['cat_exclude'] ),
			] );
			?>
			<?php if ( count( $parent_children ) > 0 ): ?>
				<div class="cs-cat cs-term">
					<?php foreach ( $parent_children as $parent_children_item ): ?>
						<?php
						$parent_category  = $parent_children_item['parent'];
						$child_categories = $parent_children_item['children'];
						?>
						<p class="cs-cat-title cs-term-title"><?= esc_html( $parent_category->name ); ?></p>

						<div class="cs-cat-list cs-term-list">
							<?php foreach ( $child_categories as $child_category ): ?>
								<div class="cs-cat-item cs-term-item">
									<label class="cs-cat-label cs-term-label">
										<input class="cs-cat-checkbox cs-term-checkbox" type="checkbox"
										       name="<?= esc_attr( st_cs_get_query_var_name( 'categories' ) ); ?>[]"
										       value="<?= esc_attr( $child_category->term_id ) ?>"
											<?php
											checked( in_array( $child_category->term_id,
												$search_query->categories(),
												true ) );
											?>>
										<span class="cs-cat-name cs-term-name"><?= esc_html( $child_category->name ); ?></span>
									</label>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		<?php else:    // `flat` or others. ?>

			<?php
			$categories = get_categories( [
				'orderby' => 'slug',
				'exclude' => implode( ',', $atts['cat_exclude'] ),
			] );
			?>
			<?php if ( count( $categories ) > 0 ): ?>
				<div class="cs-cat cs-term">
					<div class="cs-cat-list cs-term-list">
						<?php foreach ( $categories as $category ): ?>
							<div class="cs-cat-item cs-term-item">
								<label class="cs-cat-label cs-term-label">
									<input class="cs-cat-checkbox cs-term-checkbox" type="checkbox"
									       name="<?= esc_attr( st_cs_get_query_var_name( 'categories' ) ); ?>[]"
									       value="<?= esc_attr( $category->term_id ) ?>"
										<?php checked( in_array( $category->term_id,
											$search_query->categories(),
											true ) ); ?>>
									<span class="cs-cat-name cs-term-name"><?= esc_html( $category->name ); ?></span>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( $atts['show_tags'] ): ?>
			<?php $tags = get_tags( [
				'orderby' => 'slug',
				'exclude' => implode( ',', $atts['tag_exclude'] ),
			] ) ?>
			<?php if ( count( $tags ) > 0 ): ?>
				<div class="cs-tag cs-term">
					<p class="cs-tag-title cs-term-title"><?= esc_html( $atts['tag_title'] ); ?></p>

					<div class="cs-tag-list cs-term-list">
						<?php foreach ( $tags as $tag ): ?>
							<div class="cs-tag-item cs-term-item">
								<label class="cs-cat-label cs-term-label">
									<input class="cs-tag-checkbox cs-term-checkbox" type="checkbox"
									       name="<?= esc_attr( st_cs_get_query_var_name( 'tags' ) ); ?>[]"
									       value="<?= esc_attr( $tag->term_id ) ?>"
										<?php checked( in_array( $tag->term_id, $search_query->tags(), true ) ); ?>>
									<span class="cs-tag-name cs-term-name"><?= esc_html( $tag->name ); ?></span>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<button class="cs-search-button" type="submit">
			検索
		</button>

		<input type="hidden" name="<?= st_cs_get_query_var_name( 'custom_search' ) ?>" value="1">
	</form>
</div>
