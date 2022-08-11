<?php // 記事下1つめの広告
global $wp_query;
if( is_single() or is_page() && !is_front_page() ){ //投稿と固定ページ以外
	$postID = $wp_query->post->ID;
	$koukoku_set = get_post_meta( $postID, 'koukoku_set', true );
	if ( isset( $koukoku_set ) && $koukoku_set === 'yes' ){ //広告非表示の場合 ?>

	<?php }else{ ?>

		<?php if ( st_is_mobile() ) { //スマートフォンの時は300pxサイズを ?>
			<?php if ( is_active_sidebar( 4 ) && !is_404() ) { ?>
				<div class="st-h-ad">
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 4 ) ) : else : ?>
					<?php endif; ?>
				</div>
			<?php } ?>
		<?php } else {  //PCの時は336pxサイズを	?>
			<?php if ( is_active_sidebar( 3 ) && !is_404() ) { ?>
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 3 ) ) : else : ?>
				<?php endif; ?>
			<?php } ?>
		<?php } ?>
        
	<?php } ?>

<?php }else{ //投稿と固定ページ以外 ?>

		<?php if ( st_is_mobile() ) { //スマートフォンの時は300pxサイズを ?>
			<?php if ( is_active_sidebar( 4 ) && !is_404() ) { ?>
				<div class="st-h-ad">
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 4 ) ) : else : ?>
					<?php endif; ?>
				</div>
			<?php } ?>
		<?php } else {  //PCの時は336pxサイズを	?>
			<?php if ( is_active_sidebar( 3 ) && !is_404() ) { ?>
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 3 ) ) : else : ?>
				<?php endif; ?>
			<?php } ?>
		<?php } ?>

<?php }

