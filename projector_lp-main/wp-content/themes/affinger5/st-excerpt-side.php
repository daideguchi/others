<?php
// サイドに表示される抜粋
if( ( !st_is_mobile() && trim( $GLOBALS['stdata222'] ) !== '' ) || ( st_is_mobile() && trim( $GLOBALS['stdata279'] ) !== '' ) )://モバイル以外の場合のみ表示 ?>
	<div class="smanone st-excerpt">
		<?php the_excerpt(); //抜粋文 ?>
	</div>
<?php endif; ?>
