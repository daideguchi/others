<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

global $wpdb, $mp_general, $mp_subscriptions;

//
// MANAGING H1
//

$h1 = __( 'MailPress Settings', 'MailPress' );

//
// MANAGING TABS
//

$divs = array();

$_tabs = MP_AdminPage::get_tabs();

$tab_active = $mp_general['tab'] ?? 'general';

if ( isset( MP_AdminPage::$pst_['_tab'] ) )
{
	$no_error = true;
	$message = false;

	$mp_general['tab'] = $tab_active = MP_AdminPage::$pst_['_tab'];

	update_option( MailPress::option_name_general, $mp_general );

	$file = 'settings/' . MP_AdminPage::$pst_['_tab'] . '/update.php';
	include( $file );

	if ( !empty( MP_AdminPage::$err_mess ) ) 
	{
		foreach( MP_AdminPage::$err_mess as $message ) break;
		$no_error = false;
	}
}
else
{
	$parms = MP_AdminPage::get_url_parms( array( 'tab' ) );
	if ( !empty( $parms ) && isset( $parms['tab'] ) )
	{
		$tab_active = $parms['tab'];
	}
}
?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message, $no_error ); ?>
	<div id="settings-tabs">
		<ul>
<?php 
	$i = $i_tab = 0;
	foreach( $_tabs as $_tab => $desc )
	{
		if ( $tab_active == $_tab ) $i_tab = $i;
		echo "\t\t\t" . '<li class="mp_tab"><a href="#fragment-' . $_tab . '" title="' . esc_attr( $desc ) . '"><span class="button-secondary">' . $desc . '</span></a></li>' . "\n";
		$i++;
	}
	wp_localize_script( MailPress_page_settings, 'MP_AdminPage_var', array( 'the_tab' => $i_tab, 'the_tab_name' => $tab_active ) );
?>
		</ul>
<?php
	foreach( $_tabs as $_tab => $desc )
	{
?>
		<div class="fragments" id="fragment-<?php echo $_tab; ?>" data-tab="<?php echo $_tab; ?>">
<?php 
		$file = 'settings/' . $_tab . '/form.php';
		include( $file );
?>
		</div>
<?php
	}
?>
	</div>
</div>