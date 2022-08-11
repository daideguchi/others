<?php
// 投稿の関連記事を非表示
$hide_related_posts_on_single = ( trim( get_option( 'st-data36', '' ) ) === 'yes' );

// 関連記事を表示しない
if ( is_single() ) {
	$hide_related_postss = get_post_meta( get_queried_object_id(), 'kanrenwidget_set', true );
	$hide_related_postss = ( $hide_related_postss === 'yes' );
} else {
	$hide_related_postss = false;
}
?>

<?php if ( ! $hide_related_posts_on_single && ! $hide_related_postss ): ?>
	<?php
	// 関連記事一覧の見出し
	$related_posts_title = trim( stripslashes( get_option( 'st-data63', '' ) ) );
	$related_posts_title = ( $related_posts_title !== '' ) ? st_esc_html_i( $related_posts_title ) : '関連記事';
	?>

	<h4 class="point"><span class="point-in"><?php echo $related_posts_title; ?></span></h4>

	<?php st_the_kanren_posts( get_queried_object_id() ); ?>
<?php else: ?>
	<?php // テーマ管理又は投稿管理で非表示の場合 ?>
<?php endif; ?>
