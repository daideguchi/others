<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

if ( isset( MP_AdminPage::$get_['mp_import'] ) )
{
	$importers = MP_Import_importers::get_all();

	$importer = MP_AdminPage::$get_['mp_import'];

	// Allow plugins to define importers as well
	if ( !is_callable( $importers[$importer][2] ) )
	{
		$_file = MP_ABSPATH . "mp-includes/class/options/import/importers/$importer.php";
		if ( !is_file( $_file ) ) wp_die( __( 'Cannot load importer.', 'MailPress' ) );
		include( $_file );
	}

	define( 'MP_IMPORTING', true );

	call_user_func( $importers[$importer][2] );

	return;
}

//
// MANAGING H1
//

$h1 = __( 'Import/Export', 'MailPress' );

//
// MANAGING LIST
//

$items = MP_AdminPage::get_list(); 
?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?> 
	</h1>
<?php
if ( $items )
{
?>
		<p>
			<?php _e( 'If you have emails in another system, MailPress can import those into this blog.', 'MailPress' ); ?>
			
			<?php _e( 'MailPress can also export your MP users from this blog.', 'MailPress' ); ?>
			
			<?php _e( 'To get started, choose a system to import/export from below:', 'MailPress' ); ?>
		</p>
		<table class="wp-list-table widefat fixed striped importers">
			<tbody>
<?php 	foreach ( $items as $id => $data ) { echo MP_AdminPage::get_row( $id, $data ); } ?>
			</tbody>
		</table>
<?php
} 
else 
{
?>
		<p><?php _e( 'No importers/exporters available.', 'MailPress' ); ?></p>
<?php
}
?>
</div>