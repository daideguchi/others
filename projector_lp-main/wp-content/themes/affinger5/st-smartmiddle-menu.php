<?php 
//スマホ用ミドルメニュー

	$middle_set_menu = array(
		'container' => 'nav',
		'container_class' => 'st-middle-menu',
		'theme_location' => 'smartphone-middlemenu',
		'depth'           => 1,
	);
	$middle_none_menu = array(
		'container' => 'nav',
		'container_class' => 'st-middle-menu',
		'theme_location' => 'smartphone-menu',
		'depth'           => 1,
	);

	if ( has_nav_menu( 'smartphone-middlemenu' ) ) : //メニューセットあり ?>
			<?php wp_nav_menu( $middle_set_menu ); ?>
	<?php else : //メニューセットなし ?>
			<?php wp_nav_menu( $middle_none_menu ); ?>
	<?php endif;

