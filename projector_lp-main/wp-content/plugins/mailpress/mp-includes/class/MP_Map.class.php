<?php
global $mp_general;
if ( !isset( $mp_general['map_provider'] ) ) $mp_general['map_provider'] = 'o';

$file = MP_ABSPATH . 'mp-includes/class/options/map/MP_Map_' . $mp_general['map_provider'] . '.class.php';
require_once( $file );


