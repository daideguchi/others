</div><!-- /contentw -->
<footer>
<div id="footer">
<div id="footer-in">
<?php get_template_part( 'st-footer-link' ); //フッターリンク ?>

<?php if ( is_active_sidebar( 11 ) ) { //フッターウィジェットがある場合 ?>
	<?php if ( is_active_sidebar( 30 ) ) { //フッターウィジェット3列目がある場合 ?>
		<div class="footer-wbox clearfix">
			<div class="footer-r footer-column3 clearfix">
				<div class="footer-r-2">
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 11 ) ) : else : //フッターウィジェット ?>
					<?php endif; ?>
				</div>
				<div class="footer-r-3">
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 30 ) ) : else : //フッターウィジェット3列目 ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="footer-l">
				<?php get_template_part( 'st-footer-content' ); //フッターのメインコンテンツ ?>
			</div>
		</div>
	<?php }else{ //フッターウィジェット3列目がない場合 ?>
		<div class="footer-wbox clearfix">
			<div class="footer-r">
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 11 ) ) : else : //フッターウィジェット ?>
				<?php endif; ?>
			</div>
			<div class="footer-l">
				<?php get_template_part( 'st-footer-content' ); //フッターのメインコンテンツ ?>
			</div>
		</div>
	<?php } ?>
<?php }else{ ?>
	<?php get_template_part( 'st-footer-content' ); //フッターのメインコンテンツ ?>
<?php } ?>
</div>

</div>
</footer>
</div>
<!-- /#wrapperin -->
</div>
<!-- /#wrapper -->
</div><!-- /#st-ami -->
<?php if( (!st_is_mobile()) && (trim($GLOBALS['stdata110']) !== '') && (trim($GLOBALS['stdata111']) !== '') ): //動画用ID ?>
	</div>
<?php endif; ?>
<?php if ( st_is_mobile() && is_active_sidebar( 18 ) ) { ?>
	<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 18 ) ) : else : //スマホ用フッター固定広告ウィジェット ?>
	<?php endif; ?>
<?php } ?>
<?php wp_footer(); ?>
<?php get_template_part( 'st-smartfooter-menu' ); //スマホ用フッターメニュー ?>
</body></html>
