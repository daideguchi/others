<?php
//サイドメニューがカスタムメニューで設定されている場合
$guidemaplink_defaults = array(
	'theme_location'  => 'guidemap-menu2',
	'container'       => 'div',
	'container_class' => 'st-link-guide',
	'menu_class'      => 'st-link-guide-menu',
	'depth'           => 3,
);
//サイドメニューがカスタムメニューで設定されていない場合はグローバルと同じ
$defaults = array(
	'theme_location' => 'primary-menu',
	'container'       => 'div',
	'container_class' => 'st-link-guide',
	'menu_class'      => 'st-link-guide-menu',
	'depth'           => 3,
);

if ( has_nav_menu( 'guidemap-menu2' ) ) :
	wp_nav_menu( $guidemaplink_defaults ); 	
else :
	wp_nav_menu( $defaults ); 
endif;