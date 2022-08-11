<?php
if ( has_nav_menu( 'secondary-menu' ) ) : //メニューセットあり
	$defaults = array(
		'theme_location'  => 'secondary-menu',
		'container'       => 'div',
		'container_class' => 'footermenubox clearfix ',
		'menu_class'      => 'footermenust',
		'depth'           => 1,
	);
	wp_nav_menu( $defaults );
endif;
?>