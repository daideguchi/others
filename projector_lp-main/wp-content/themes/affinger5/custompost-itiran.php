<?php
if( trim($GLOBALS['stdata106']) !== ''):
	if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
		get_template_part( 'custompost-itiran-thumbnail-off' ); 
	}else{
		get_template_part( 'custompost-itiran-thumbnail-on' ); 
	}
endif;