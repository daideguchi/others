<?php //スマホ上の広告エリア
if(st_is_mobile()) { //PC以外

	global $wp_query;
	if( is_single() or is_page() && !is_front_page() ){
		$postID = $wp_query->post->ID;
		$koukoku_set = get_post_meta( $postID, 'koukoku_set', true );

		if ( isset( $koukoku_set ) && $koukoku_set === 'yes' ){ //広告非表示の場合

		}else{
			if( is_single() || ( is_page() && ( trim($GLOBALS['stdata100']) !== '') ) ){ //固定ページの表示の有無
				if ( is_active_sidebar( 20 ) ) {	
					if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 20 ) ) : else : //アドセンス
					endif;
				}
			}
		}

	}else{ //投稿と固定ページ以外

			if ( is_active_sidebar( 20 ) ) {	
				if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 20 ) ) : else : //アドセンス
				endif;
			}

	}
}