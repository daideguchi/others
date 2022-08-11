<?php
/**
 * ショートコードで読み込むアドセンス
 */

global $wp_query;
if( is_single() or is_page() && !is_front_page() ){
	$postID = $wp_query->post->ID;
	$koukoku_set = get_post_meta( $postID, 'koukoku_set', true );
	if ( isset( $koukoku_set ) && $koukoku_set === 'yes' ){ //広告非表示の場合 ?>

	<?php }else{ ?>

		<p style="color:#666;margin-bottom:5px;">スポンサーリンク</p>
		<div class="middle-ad">
			<?php if ( st_is_mobile() ) { //スマートフォンの時は300pxサイズを ?>
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 4 ) ) : else : ?>
				<?php endif; ?>
			<?php } else {  //PCの時は336pxサイズを ?>
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 3 ) ) : else : ?>
				<?php endif; ?>
			<?php }?>
		</div>

        
	<?php } ?>

<?php }else{ //投稿と固定ページ以外 ?>

	<p style="color:#666;margin-bottom:5px;">スポンサーリンク</p>
	<div class="middle-ad">
		<?php if ( st_is_mobile() ) { //スマートフォンの時は300pxサイズを ?>
			<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 4 ) ) : else : ?>
			<?php endif; ?>
		<?php } else {  //PCの時は336pxサイズを ?>
			<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 3 ) ) : else : ?>
			<?php endif; ?>
		<?php }?>
	</div>

<?php }