<?php if ( is_front_page() || $GLOBALS["stdata13"] === '' ) { //下層ページのサイドバーの新着記事一覧を非表示にする
	if ( trim( stripslashes( $GLOBALS["stdata66"] ) ) !== '' ) {
		$new_entryname = st_esc_html_i( stripslashes( $GLOBALS["stdata66"] ) );
	} else {
		$new_entryname = '';		
	}

	if(trim($GLOBALS['stdata99']) !== ''){ //カテゴリ指定のある場合
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) { //サムネイルの有無
			if(trim($new_entryname) !== ''):
				echo '<h4 class="menu_underh2">'.$new_entryname.'</h4>';
			endif;
			get_template_part( 'newpost-original-thumbnail-off' ); 
		}else{
			if(trim($new_entryname) !== ''):
				echo '<h4 class="menu_underh2">'.$new_entryname.'</h4>';
			endif;
			get_template_part( 'newpost-original-thumbnail-on' ); 
		}
	}else{
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
			if(trim($new_entryname) !== ''):
				echo '<h4 class="menu_underh2">'.$new_entryname.'</h4>';
			endif;
			get_template_part( 'newpost-thumbnail-off' ); 
		}else{
			if(trim($new_entryname) !== ''):
				echo '<h4 class="menu_underh2">'.$new_entryname.'</h4>';
			endif;
			get_template_part( 'newpost-thumbnail-on' ); 
		}
	}
}
?>
