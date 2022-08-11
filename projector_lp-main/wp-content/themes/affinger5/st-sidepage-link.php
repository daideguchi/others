<?php
//サイドメニューがカスタムメニューで設定されている場合
$sidedefaults = array(
	'theme_location'  => 'sidepage-menu',
	'container'       => 'div',
	'container_class' => 'st-pagelists',
	'menu_class'      => '',
	'depth'           => 3,
);
//サイドメニューがカスタムメニューで設定されていない場合はグローバルと同じ
$defaults = array(
	'theme_location' => 'primary-menu',
	'container'       => 'div',
	'container_class' => 'st-pagelists',
	'menu_class'      => '',
	'depth'           => 3,
);

if ( has_nav_menu( 'sidepage-menu' ) ) :
	wp_nav_menu( $sidedefaults ); 	
else :
	wp_nav_menu( $defaults ); 
endif;