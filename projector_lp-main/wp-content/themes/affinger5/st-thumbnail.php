<?php
if ( amp_is_amp() ): // AMP
	the_post_thumbnail( array( 100, 100 ) );
elseif( isset($GLOBALS['stdata403']) && $GLOBALS['stdata403'] === 'maru' ): //サムネイルをマルに設定
	the_post_thumbnail( 'st_thumb150' );
elseif( isset($GLOBALS['stdata403']) && $GLOBALS['stdata403'] === 'original' ): //サムネイルをオリジナルに設定
	the_post_thumbnail( 'thumbnail' );
elseif( isset($GLOBALS['stdata403']) && $GLOBALS['stdata403'] === 'full' ): //サムネイルをフルサイズに設定
	the_post_thumbnail( 'full' );
else:
	the_post_thumbnail( 'st_thumb150' ); //サムネイルを正方形に設定
endif;
