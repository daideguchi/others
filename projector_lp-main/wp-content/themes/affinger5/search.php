<?php get_header(); ?>

<div id="content" class="clearfix">
	<div id="contentInner">
		<main>
			<article>
				<div class="post post-search">
					<h1 class="entry-title"> <!--検索結果数-->
						<?php if ( function_exists( 'st_cs_get_search_query' ) ): ?>
							<?php echo esc_html( st_cs_get_search_query( null, '', 'の検索結果', '検索結果', ' - ', '・' ) ); ?>
							<?php echo $wp_query->found_posts; ?> 件
						<?php else: ?>
							<?php $criteria = ( $s !== '' ) ? $s . 'の' : ''; ?>
							<?php echo esc_html( $criteria ); ?>検索結果 <?php echo $wp_query->found_posts; ?> 件
						<?php endif; ?>
					</h1>
					<!--検索結果数終わり-->
					<?php if ( function_exists( 'st_cs_is_search' ) && st_cs_is_search() ): ?>
						<div class="st-custom-search-result-box"><?php echo do_shortcode( '[st-custom-search show_text_input="" template="result"]' ); ?></div>
					<?php else: ?>
						<?php get_template_part( 'searchform' ); //検索フォーム ?>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 32 ) ) { ?>
						<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 32 ) ) : else : //検索結果ページ（上部）に表示ウィジェット ?>
						<?php endif; ?>
					<?php } ?>
				</div>
					<?php get_template_part( 'itiran' ); //投稿一覧読み込み ?>
					<?php get_template_part( 'st-pagenavi' ); //ページナビ読み込み ?>
			
					<?php if ( is_active_sidebar( 33 ) ) { ?>
						<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 33 ) ) : else : //検索結果ページ（下部）に表示ウィジェット ?>
						<?php endif; ?>
					<?php } ?>

			</article>
		</main>
	</div>
	<!-- /#contentInner -->
	<?php get_sidebar(); ?>
</div>
<!--/#content -->
<?php get_footer(); ?>
