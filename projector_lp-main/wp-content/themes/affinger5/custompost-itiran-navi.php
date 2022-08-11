<?php
if( trim($GLOBALS['stdata106']) !== ''):
	if ( isset($GLOBALS['stdata5']) && $GLOBALS['stdata5'] === 'yes' ) {
		get_template_part( 'custompost-itiran-navi-thumbnail-off' ); 
	}else{
		get_template_part( 'custompost-itiran-navi-thumbnail-on' ); 
	}
endif;