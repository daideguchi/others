<?php

$hide_thumbnail = (bool) trim( get_option( 'st-data5', '' ) );

$vars = array(
	'cat_group_query' => $cat_group_query,
);

$amp = amp_is_amp() ? 'amp' : null;
?>

<?php if ( false ): ?>
	<h4 class='point'><span class='point-in'><?php echo esc_html( $kanren_title ); ?></span></h4>
<?php endif; ?>

<?php
if ( $hide_thumbnail ) {
	st_get_template_part( 'st-shortcode-kanren-thumbnail-off', $amp, $vars );
} else {
	st_get_template_part( 'st-shortcode-kanren-thumbnail-on', $amp, $vars );
}
