<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

global $title, $mp_mail;
?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $title ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>
	<table class="wp-list-table widefat fixed striped zyxw">
		<thead>
			<tr>
<?php MP_AdminPage::columns_list(); ?>
			</tr>
		</thead>
		<tbody id="the-mail-list">
<?php echo MP_AdminPage::get_row( MP_AdminPage::$get_['id'], array(), false, true ); ?>
		</tbody>
	</table>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<div id="postbox-container-1" class="postbox-container">
<?php do_meta_boxes( MP_AdminPage::screen, 'normal', $mp_mail ); ?>
			</div>
			<div id="postbox-container-2" class="postbox-container">
<?php do_meta_boxes( MP_AdminPage::screen, 'side', $mp_mail ); ?>
			</div>
			<div id="postbox-container-3" class="postbox-container">
<?php do_meta_boxes( MP_AdminPage::screen, 'column3', $mp_mail ); ?>
			</div>
			<div id="postbox-container-4" class="postbox-container">
<?php do_meta_boxes( MP_AdminPage::screen, 'column4', $mp_mail ); ?>
			</div>
		</div>
		<form method="post" class="hidden">

			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order',  'meta-box-order-nonce', false );  ?>

		</form>
	</div><!-- dashboard-widgets-wrap -->
</div>