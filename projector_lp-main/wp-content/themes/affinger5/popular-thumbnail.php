<?php 
	if( ( is_single() ) && ( isset($GLOBALS['stdata40']) && $GLOBALS['stdata40'] === 'yes' ) ){ //投稿記事の場合
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
			get_template_part( 'popular-thumbnail-off' ); 
		}else{
			get_template_part( 'popular-thumbnail-on' ); 
		}
	}elseif( ( !is_front_page() && is_page() ) && ( isset($GLOBALS['stdata41']) && $GLOBALS['stdata41'] === 'yes' ) ){ //固定記事の場合
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
			get_template_part( 'popular-thumbnail-off' ); 
		}else{
			get_template_part( 'popular-thumbnail-on' ); 
		}
	}elseif( ( is_category() ) && ( isset($GLOBALS['stdata119']) && $GLOBALS['stdata119'] === 'yes' ) ){ //カテゴリーの場合
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
			get_template_part( 'popular-thumbnail-off' ); 
		}else{
			get_template_part( 'popular-thumbnail-on' ); 
		}
	}elseif( ( is_home() || is_front_page() ) && ( isset($GLOBALS['stdata54']) && $GLOBALS['stdata54'] === 'yes' ) ){ //トップ記事の場合
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
			get_template_part( 'popular-thumbnail-off' ); 
		}else{
			get_template_part( 'popular-thumbnail-on' ); 
		}
	}
?>