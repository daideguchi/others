<?php
abstract class MP_WP_privacy_eraser_ extends MP_WP_privacy_
{
	var $type = 'eraser';
	var $erase = array( 'items_removed' => false, 'items_retained' => false, 'messages' => array(), 'done' => true, );
}