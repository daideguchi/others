<?php
/**
 * カテゴリーアイキャッチ
 */

$the_cat_id   = get_queried_object_id();
$thumbnail_id = (int) st_get_term_meta( $the_cat_id, 'thumbnail_id' );
$is_under     = (bool) st_get_term_meta( $the_cat_id, 'thumbnail_under' );
$is_wide      = (bool) st_get_term_meta( $the_cat_id, 'thumbnail_wide' );
$show_caption = (bool) get_option( 'st-data75', '' ); // アイキャッチのキャプションをクレジットとして写真上に表示する


$attachment  = get_post( $thumbnail_id );
$caption     = trim( $attachment->post_excerpt );
$has_caption = $attachment && ( $caption !== '' );

$classes = array(
	( ! $is_under || ( $is_under && $is_wide ) ) ? 'st-eyecatch' : '',
	$is_under ? ' st-eyecatch-under' : '',
);

$class = implode( ' ', $classes );
?>

<?php if ( st_has_term_thumbnail() ): // サムネイル ?>
	<div class="<?php echo esc_attr( $class ); ?>">
		<?php st_the_term_thumbnail( 'full' ); ?>

		<?php if ( $show_caption && $has_caption ): ?>
			<p class="eyecatch-copyurl">
				<i class="fa fa-camera-retro" aria-hidden="true"></i><?php echo $caption; ?>
			</p>
		<?php endif; ?>
	</div>
<?php endif; ?>
