<!--ここにgoogleアドセンスコードを貼ると規約違反になるので注意して下さい-->
<?php if ( is_active_sidebar( 2 ) ) { ?>
	<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 2 ) ) : else : ?>
	<?php endif; ?>
<?php } ?>