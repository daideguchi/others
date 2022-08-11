<?php if ( isset($GLOBALS["stdata92"]) && $GLOBALS["stdata92"] === 'yes' ) {
	if ( trim( stripslashes( $GLOBALS["stdata66"] ) ) !== '' ) {
		$new_entryname = st_esc_html_i( stripslashes( $GLOBALS["stdata66"] ) );
	} else {
		$new_entryname = 'NEW ENTRY';		
	}

	if(trim($GLOBALS['stdata99']) !== ''){ //カテゴリ指定のある場合
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) { //サムネイルの有無
			echo '<p class="n-entry-t"><span class="n-entry">'.$new_entryname.'</span></p>';
			get_template_part( 'newpost-originalpage-thumbnail-off' ); 
		}else{
			echo '<p class="n-entry-t"><span class="n-entry">'.$new_entryname.'</span></p>';
			get_template_part( 'newpost-originalpage-thumbnail-on' ); 
		}
	}else{
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
			echo '<p class="n-entry-t"><span class="n-entry">'.$new_entryname.'</span></p>';
			get_template_part( 'newpost-page-thumbnail-off' ); 
		}else{
			echo '<p class="n-entry-t"><span class="n-entry">'.$new_entryname.'</span></p>';
			get_template_part( 'newpost-page-thumbnail-on' ); 
		}
	}
}
?>
