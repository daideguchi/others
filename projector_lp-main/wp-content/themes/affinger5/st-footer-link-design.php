<?php
if ( has_nav_menu( 'primary-menu-side' ) ) : //メニューセットあり
	$defaults = array(
		'theme_location'  => 'primary-menu-side',
		'container'       => 'div',
		'container_class' => 'footermenubox st-menu-side-box clearfix ',
		'menu_class'      => 'footermenust st-menu-side',
		'depth'           => 1,
	);
	wp_nav_menu( $defaults );
endif;
?>
