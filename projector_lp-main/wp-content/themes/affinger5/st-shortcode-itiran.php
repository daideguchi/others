<?php

$hide_thumbnail = (bool) trim( get_option( 'st-data5', '' ) );

$vars = array(
	'post_group_query' => $post_group_query,
	'is_rank'          => $is_rank,
);

$amp = amp_is_amp() ? 'amp' : null;

if ( $hide_thumbnail ) {
	st_get_template_part( 'st-shortcode-itiran-thumbnail-off', $amp, $vars );
} else {
	st_get_template_part( 'st-shortcode-itiran-thumbnail-on', $amp, $vars );
}
