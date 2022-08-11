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
		<?php if ( $atts['show_text_input'] ): ?>
			<div class="cs-text">
				<input class="cs-text-input s" type="search" placeholder="検索するテキストを入力"
				       name="<?= esc_attr( st_cs_get_query_var_name( 'keyword' ) ); ?>"
				       value="<?php the_search_query(); ?>">
				<input class="cs-text-button searchsubmit" type="image"
				       src="<?php echo get_template_directory_uri(); ?>/images/search.png" alt="検索">
			</div>
		<?php else: ?>
			<input type="hidden" name="<?= esc_attr( st_cs_get_query_var_name( 'keyword' ) ); ?>" value="">
		<?php endif; ?>

		<div class="cs-order">
			<?php foreach ( st_cs_get_order_by_values() as $label => $value ): ?>
				<div class="cs-order-item">
					<label class="cs-order-label">
						<input class="cs-order-radio" type="radio" name="<?= esc_attr( st_cs_get_query_var_name( 'order_by' ) ); ?>"
						       value="<?= esc_attr( $value ); ?>"<?php checked( $value, $search_query->order_by() ); ?>>
						<?= esc_html( $label ); ?>
					</label>
				</div>
			<?php endforeach; ?>

			<button class="cs-order-button" type="submit">並べ替え</button>
		</div>

		<input type="hidden" name="<?= st_cs_get_query_var_name( 'custom_search' ) ?>" value="1">

		<?php if ( ! $atts['show_text_input'] && $search_query->has_keyword() ): ?>
			<input type="hidden" name="<?= esc_attr( st_cs_get_query_var_name( 'keyword' ) ); ?>"
			       value="<?php the_search_query(); ?>">
		<?php endif; ?>

		<?php if ( $search_query->has_categories() ): ?>
			<?php foreach ( $search_query->categories() as $category_id ): ?>
				<input type="hidden"
				       name="<?= esc_attr( st_cs_get_query_var_name( 'categories' ) ); ?>[]"
				       value="<?= esc_attr( $category_id ) ?>">
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ( $search_query->has_tags() ): ?>
			<?php foreach ( $search_query->tags() as $tag_id ): ?>
				<input type="hidden"
				       name="<?= esc_attr( st_cs_get_query_var_name( 'tags' ) ); ?>[]"
				       value="<?= esc_attr( $tag_id ) ?>">
			<?php endforeach; ?>
		<?php endif; ?>
	</form>
</div>
