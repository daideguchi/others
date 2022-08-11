<?php
if ( trim( $GLOBALS["stdata9"] ) !== '' ) { //記事挿入がある場合
	$topin_id = $GLOBALS["stdata9"]; //記事ID
	if(get_post($topin_id)){
		$topin_type = get_post($topin_id)->post_type; //記事のタイプ
	}else{
		$topin_type = '';
	}
}else{
	$topin_id = '';
	$topin_type = '';
}


if( ( trim( $topin_id ) !== '' ) && ( $topin_type === 'page' )){ //固定記事の挿入IDがあり固定記事に存在する場合
?>

<div class="post st-topin">
			
	<?php //アイキャッチ画像
		$topin_query = new WP_Query( 'post_type=page&p=' . $topin_id );
		$postID = $topin_query->post->ID;
		$eyecatchset = get_post_meta( $postID, 'eyecatch_set', true );

		if ( get_post_thumbnail_id( $postID ) && (( isset($GLOBALS['stdata53']) && $GLOBALS['stdata53'] === 'yes' ) || ( isset( $eyecatchset ) && $eyecatchset === 'yes' ))) { ?>
			<div class="st-eyecatch"><?php echo get_the_post_thumbnail( $topin_query->post->ID,'full' ); ?>

	<?php //クレジット表示
	$stcopyurl = get_post_meta( $postID, 'st_copyurl', true );
	$stcopyright = get_post_meta( $postID, 'st_copyright', true );

	if( trim( $stcopyright ) !== '' ) { ?>
		<p class="eyecatch-copyurl"><i class="fa fa-copyright" aria-hidden="true"></i><?php echo esc_url( get_home_url()); ?></p>
	<?php
	} elseif( trim( $stcopyurl ) !== '' ) { ?>
		<p class="eyecatch-copyurl"><i class="fa fa-camera-retro" aria-hidden="true"></i><?php echo stripslashes( $stcopyurl ); ?></p>
	<?php 
	}elseif((!empty(get_post(get_post_thumbnail_id($postID))->post_excerpt)) && (trim($GLOBALS['stdata75']) !== '' && $GLOBALS['stdata75'] === 'yes')){ //キャプションがあり且つ表示にチェックが入っている場合 ?>
		<p class="eyecatch-copyurl"><i class="fa fa-camera-retro" aria-hidden="true"></i><?php echo get_post(get_post_thumbnail_id($postID))->post_excerpt;?></p>
	<?php 
	}else{
	}
	?>

			</div>

	<?php } //アイキャッチ画像を挿入ここまで

		if(!is_front_page() && is_home()){ //投稿ページ設定によるフロント
		}else{
			if ( get_post_thumbnail_id( $postID ) && (( isset($GLOBALS['stdata53']) && $GLOBALS['stdata53'] === 'yes' ) || ( isset( $eyecatchset ) && $eyecatchset === 'yes' ))) { //アイキャッチ画像がある場合 ?>
				<div class="nowhits-eye"><?php get_template_part( 'popular-thumbnail' ); //任意のエントリ ?></div>
			<?php }else{ //アイキャッチがない場合 ?>
				<div class="nowhits <?php st_noheader_class(); ?>"><?php get_template_part( 'popular-thumbnail' ); //任意のエントリ ?></div>
			<?php } ?>

			<?php if ( is_front_page() && is_active_sidebar( 12 ) ) { ?>
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 12 ) ) : else : //トップ上部のウィジェット ?>
					<?php endif; ?>
			<?php } ?>

			<?php get_template_part( 'news-st' ); //お知らせ ?>
		<?php } ?>

		<?php //固定記事挿入
		if ( $topin_query->have_posts() ) : while ( $topin_query->have_posts() ) : $topin_query->the_post();
			st_the_content( 'topin' );
		endwhile;
			wp_reset_postdata();
		endif; ?>
</div>
<?php 
} else {

}
?>
