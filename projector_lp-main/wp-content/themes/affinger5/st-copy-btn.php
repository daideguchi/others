<?php // この記事タイトルとURLをコピー

if ( is_front_page() ): // TOP

		$url        = get_home_url();

		if ( trim( $GLOBALS["stdata95"] ) === '' ) {
			if ( trim( $GLOBALS['stdata33'] ) !== '' ) {
				$title = $GLOBALS['stdata33'];
			} else {
				$title = st_get_document_title();
			}
		} else {
			$title = wp_get_document_title();
		}

		$title        = html_entity_decode( $title, ENT_QUOTES, get_bloginfo( 'charset' ) ); ?>

		<!--URLコピーボタン-->
		<div class="st-copyurl-btn">
			<a href="#" rel="nofollow" data-st-copy-text="<?php echo esc_attr( $title . ' / ' . $url ); ?>"><i class="fa fa-clipboard"></i>この記事タイトルとURLをコピー</a>
		</div>

<?php elseif ( !is_front_page() && ( is_single() || is_page() ) ): // 投稿・固定

	$url          = get_permalink();
	$title        = get_the_title();
	$title        = str_replace( '&', '&#038;', $title );                                   // 1. 文字参照の & をエンコードして保護する
	$title        = html_entity_decode( $title, ENT_QUOTES, get_bloginfo( 'charset' ) );    // 2. 文字参照をデコード
	$title        = preg_replace( '#</?[a-zA-Z][a-zA-Z0-9]*?>|<![^>]*>#', '', $title );     // 3. HTML タグを削除
	$title        = html_entity_decode( $title, ENT_QUOTES, get_bloginfo( 'charset' ) );    // 4. 文字参照を元に戻す
	?>
		<!--URLコピーボタン-->
		<div class="st-copyurl-btn">
		<a href="#" rel="nofollow" data-st-copy-text="<?php echo esc_attr( $title . ' / ' . $url ); ?>"><i class="fa fa-clipboard"></i>この記事タイトルとURLをコピー</a>
		</div>

<?php elseif ( is_archive() ): // カテゴリー

	$the_term   = get_queried_object(); //現在のターム ID を取得
	$url        = get_term_link( $the_term, $the_term->taxonomy );
	$url_encode = rawurlencode( $url );
	$term_meta  = st_get_term_meta( $the_term );

	if ( st_is_ver_ex() ) : // EX
		if ( trim( $term_meta['title'] ) !== '' ) {
			$title        = $term_meta['title'];
		} else {
			$title        = single_term_title( '', false );
		}
	else: // EX以外
		if ( trim( $term_meta['st_cattitle'] ) !== '' ) {
			$title        = $term_meta['st_cattitle'];
		} else {
			$title        = single_term_title( '', false );
		}
	endif; ?>

		<!--URLコピーボタン-->
		<div class="st-copyurl-btn">
			<a href="#" rel="nofollow" data-st-copy-text="<?php echo esc_attr( $title . ' / ' . $url ); ?>"><i class="fa fa-clipboard"></i>この記事タイトルとURLをコピー</a>
		</div>

<?php else:

endif;

