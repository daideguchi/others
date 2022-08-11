<?php 
if ( is_archive() || is_search() || ( is_home() && $GLOBALS["stdata44"] === '' )) {
	if( is_front_page() || is_home() ){
		if(trim($GLOBALS['stdata99']) !== ''){
			if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
				get_template_part( 'itiran-original-thumbnail-off' ); 
			}else{
				get_template_part( 'itiran-original-thumbnail-on' ); 
			}
		}else{
			if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
				get_template_part( 'itiran-thumbnail-off' ); 
			}else{
				get_template_part( 'itiran-thumbnail-on' ); 
			}
		}
	}else{
		if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
			get_template_part( 'itiran-thumbnail-off' ); 
		}else{
			get_template_part( 'itiran-thumbnail-on' ); 
		}
	}
}