<?php	
if(trim($GLOBALS['stdata99']) !== ''){ //カテゴリ指定のある場合
	if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) { //サムネイルの有無
		get_template_part( 'newpost-original-thumbnail-off' ); 
	}else{
		get_template_part( 'newpost-original-thumbnail-on' ); 
	}
}else{
	if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
		get_template_part( 'newpost-thumbnail-off' ); 
	}else{
		get_template_part( 'newpost-thumbnail-on' ); 
	}
}
