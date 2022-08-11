<?php
if( ( !st_is_mobile() && trim( $GLOBALS['stdata202'] ) === '' ) || ( st_is_mobile() && trim( $GLOBALS['stdata279'] ) !== '' ) )://モバイル以外かつPC閲覧時も記事一覧（トップ・アーカイブ・関連記事）の抜粋を非表示にするにチェックがない又はモバイルかつモバイルでも抜粋表示にチェックがある場合に表示 ?>
	<div class="st-excerpt smanone">
		<?php the_excerpt(); //抜粋文 ?>
	</div>
<?php endif; ?>
