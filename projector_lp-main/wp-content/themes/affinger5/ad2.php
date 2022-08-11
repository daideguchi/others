<?php // 記事下PCの2つめの広告
global $wp_query;
if( is_single() or is_page() && !is_front_page() ){
	$postID = $wp_query->post->ID;
	$koukoku_set = get_post_meta( $postID, 'koukoku_set', true );
	if ( isset( $koukoku_set ) && $koukoku_set === 'yes' ){ //広告非表示の場合 ?>

	<?php }else{ ?>

		<?php if ( is_active_sidebar( 29 ) && !is_404() ) { //投稿と固定と404ページ以外 ?>
			<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 29 ) ) : else : ?>
			<?php endif; ?>
		<?php } ?>
        
	<?php } ?>

<?php }else{ //投稿と固定ページ以外 ?>

	<?php if ( is_active_sidebar( 29 ) && !is_404() ) { ?>
		<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 29 ) ) : else : ?>
		<?php endif; ?>
	<?php } ?>

<?php }
