<?php
$hide_excerpt           = trim( get_option( 'st-data221', '' ) );
$show_excerpt_on_mobile = trim( get_option( 'st-data279', '' ) );
?>

<?php // おすすめ記事の抜粋 ?>
<?php
if ( ( ! st_is_mobile() && $hide_excerpt === '' ) || ( st_is_mobile() && $show_excerpt_on_mobile !== '' ) ): //モバイル以外の場合のみ表示 ?>
	<div class="smanone st-excerpt">
		<?php the_excerpt(); //抜粋文 ?>
	</div>
<?php endif; ?>
