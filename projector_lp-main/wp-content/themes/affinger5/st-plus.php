<?php
// 直接アクセスを禁止
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
$stplus = 'yes';

if (locate_template('st-af-kanri.php') !== '') {
require_once locate_template('st-af-kanri.php');
}

if (locate_template('st-af-kanri-wysiwyg.php') !== '') {
require_once locate_template('st-af-kanri-wysiwyg.php');
}
