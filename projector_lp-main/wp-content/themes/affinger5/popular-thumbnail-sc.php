<?php 
if ( isset($GLOBALS['stdata39']) && $GLOBALS['stdata39'] === 'yes' ) {
	if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
		get_template_part( 'popular-side-thumbnail-off' ); 
	}else{
		get_template_part( 'popular-side-thumbnail-on' ); 
	}
}
?>