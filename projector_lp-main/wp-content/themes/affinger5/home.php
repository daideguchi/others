<?php get_header(); ?>

<div id="content" class="clearfix">
	<div id="contentInner">
		<main <?php st_text_copyck(); ?>>
			<article>

				<div class="home-post post">

				<?php if (is_paged()): //2ページ目以降は表示しない ?>
				<?php else: ?>

						<?php if ( trim( $GLOBALS["stdata9"] ) !== '' ) { //固定記事挿入していない場合
						}else{ ?>
							<?php if( (isset($GLOBALS['stdata54'])) && ($GLOBALS['stdata54'] === 'yes') ): //トップ記事上部表示にチェックがある場合 ?>
								<div class="nowhits <?php st_noheader_class(); ?>"><?php get_template_part( 'popular-thumbnail' ); //任意のエントリ ?></div>
							<?php endif; ?>

							<?php if ( is_front_page() && is_active_sidebar( 12 ) ) { ?>
								<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 12 ) ) : else : //トップ上部のウィジェット ?>
								<?php endif; ?>
							<?php } ?>
							<?php get_template_part( 'news-st' ); //お知らせ ?>
						<?php }?>

						<div class="entry-content">
							<?php get_template_part( 'st-topin' ); //固定記事挿入 ?>
							<div class="st-topcontent">
								<?php st_the_editor_content( 'st-data89' ); //管理画面の作成コンテンツ ?>
							</div>
						</div>

						<?php if (( is_front_page() && is_active_sidebar( 13 ) ) && (trim($GLOBALS['stdata9']) !== '')||(trim($GLOBALS['stdata89']) !== '') ) { ?>
							<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 13 ) ) : else : //トップ下部のウィジェット ?>
							<?php endif; ?>
						<?php } ?>

						<?php if ( isset($GLOBALS['stplus']) && $GLOBALS['stplus'] === 'yes' ) {
							get_template_part( 'st-rank' ); //ランキング 
						} ?>

						<?php //任意のエントリ
						if( ( is_home() || is_front_page() ) && ( isset($GLOBALS['stdata59']) && $GLOBALS['stdata59'] === 'yes' ) ){ //トップ記事の場合 ?>
						<div style="padding-top:20px;">
							<?php if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
								get_template_part( 'popular-thumbnail-off' ); 
							}else{
								get_template_part( 'popular-thumbnail-on' ); 
							} ?>
						</div>
						<?php }  //任意のエントリここまで ?>

				<?php endif; ?>

				</div>

				<aside>

					<?php //記事一覧
					if( $GLOBALS["stdata44"]  === ''){ //新着一覧非表示で無い場合
						
						if ( !is_paged() && ( ( trim( stripslashes( $GLOBALS["stdata89"] ) ) !== '' ) || ( trim( stripslashes( $GLOBALS["stdata9"] ) ) !== '' ) ) && ( trim( stripslashes( $GLOBALS["stdata66"] ) ) !== '' ) ) {
							$new_entryname = st_esc_html_i( stripslashes( $GLOBALS["stdata66"] ) );
							echo '<p class="n-entry-t"><span class="n-entry">' . $new_entryname . '</span></p>';
						}
						?>
					
						<?php get_template_part( 'itiran' ); ?>
						<?php get_template_part( 'st-pagenavi' ); //ページナビ読み込み ?>
					<?php } ?>
					
				</aside>

					<?php get_template_part( 'sns-top' ); //ソーシャルボタン読み込み ?>

					<?php if (( is_front_page() && is_active_sidebar( 13 ) ) && (trim($GLOBALS['stdata9']) === '') && (trim($GLOBALS['stdata89']) === '') ) { ?>
						<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 13 ) ) : else : //トップ下部のウィジェット ?>
						<?php endif; ?>
					<?php } ?>

			</article>
		</main>
	</div>
	<!-- /#contentInner -->
	<?php get_sidebar(); ?>
</div>
<!-- /#content -->
<?php get_footer(); ?>
