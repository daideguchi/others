<?php if ( trim( $GLOBALS["stdata42"] ) !== '' ) {
	$st_tel_no = esc_html( $GLOBALS["stdata42"] );
?>
<p class="head-telno"><a href="tel:<?php echo "$st_tel_no"; ?>"><i class="fa fa-mobile"></i>&nbsp;<?php echo "$st_tel_no"; ?></a></p>
<?php } ?>

<?php if ( is_active_sidebar( 8 ) ) { ?>
	<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 8 ) ) : else : //ヘッダー用ウィジェット ?>
	<?php endif; ?>
<?php } ?>