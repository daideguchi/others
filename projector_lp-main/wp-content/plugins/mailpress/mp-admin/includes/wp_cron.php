<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms();

//
// MANAGING H1
//

$h1 = __( 'Wp_cron', 'MailPress' );

//
// MANAGING MESSAGE
//

$messages[1] = __( 'Cron added.', 'MailPress' );
$messages[2] = __( 'Cron updated.', 'MailPress' );
$messages[3] = __( 'Cron deleted.', 'MailPress' );
$messages[4] = __( 'Crons deleted.', 'MailPress' );
$messages[5] = __( 'Cron executed.', 'MailPress' );
$messages[91] = __( 'Cron NOT added.', 'MailPress' );
$messages[92] = __( 'Cron NOT updated.', 'MailPress' );
$messages[95] = __( 'Cron NOT executed.', 'MailPress' );

if ( isset( MP_AdminPage::$get_['message'] ) )
{
	$message = $messages[MP_AdminPage::$get_['message']];
	$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'message' ), $_SERVER['REQUEST_URI'] );
}

//
// MANAGING CONTENT
//

global $action;
wp_reset_vars( array( 'action' ) );
if ( 'edit' == $action ) 
{
	$action = 'edited';
	$cancel = '<input type="submit" class="button" name="cancel" value="' . __( 'Cancel', 'MailPress' ) . '" />';

	$id = MP_AdminPage::$get_['id'];
	$sig = MP_AdminPage::$get_['sig'];
	$next_run = MP_AdminPage::$get_['next_run'];
	$wpcron = MP_AdminPage::get( $id, $sig, $next_run );

	$h3 = __( 'Edit cron', 'MailPress' );

	$hidden = '<input type="hidden" name="id" value="' . $id . '::' . $sig . '::' . $next_run . '" />';

	$flipflops = array( 2, 1 );
}
else 
{
	$action = MP_AdminPage::add_form_id;
	$cancel = '';

	$wpcron = array();

	$h3 = __( 'Add cron', 'MailPress' );

	$hidden = '';
	$flipflops = array( 1, 2 );
}

//
// MANAGING BULK ACTIONS
//

$bulk_actions[''] = __( 'Bulk Actions' );
$bulk_actions['delete'] = __( 'Delete', 'MailPress' );

//
// MANAGING LIST
//

$url_parms['paged'] = $url_parms['paged'] ?? 1;
$_per_page = MP_AdminPage::get_per_page();

do
{
	$start = ( $url_parms['paged'] - 1 ) * $_per_page;
	list( $items, $total ) = MP_AdminPage::get_list( array( 'start' => $start, '_per_page' => $_per_page, 'url_parms' => $url_parms ) );
	$url_parms['paged']--;
} while ( $total <= $start );
$url_parms['paged']++;

?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message, ( MP_AdminPage::$get_['message'] < 90 ) ); ?>
	<br class="clear" />
<?php
foreach ( $flipflops as $flipflop )
{
	switch( $flipflop )
	{
		case 1 :
?>
	<form id="posts-filter" method="get">

		<input type="hidden" name="page" value="<?php echo MP_AdminPage::screen; ?>" />

		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
<?php	MP_AdminPage::get_bulk_actions( $bulk_actions ); ?>
			</div>

<?php MP_AdminPage::pagination( $total ); ?>

			<br class="clear" />
		</div>
		<div class="clear"></div>

		<table class="wp-list-table widefat fixed striped zyxw">
			<thead>
				<tr>
<?php MP_AdminPage::columns_list(); ?>
				  </tr>
			</thead>
			<tbody id="<?php echo MP_AdminPage::list_id; ?>" class="list:<?php echo MP_AdminPage::tr_prefix_id; ?>">
<?php	foreach ( $items as $item ) { echo MP_AdminPage::get_row( $item, $url_parms ); } ?>
			</tbody>
			<tfoot>
				<tr>
<?php MP_AdminPage::columns_list( false ); ?>
				</tr>
			</tfoot>
		</table>
		<div class="tablenav bottom">
<?php MP_AdminPage::pagination( $total, 'bottom' ); ?>
			<div class="alignleft actions bulkactions">
<?php	MP_AdminPage::get_bulk_actions( $bulk_actions, 'action2' ); ?>
			</div>
			<br class="clear" />
		</div>
	</form>
<?php
		break;
		case 2 :
?>
	<form name="<?php echo $action; ?>" id="<?php echo $action; ?>" method="post" class="<?php echo $action; ?>:<?php echo MP_AdminPage::list_id; ?>: validate">
		<table class="wp-list-table widefat fixed striped zyxw">
			<thead>
				<tr>
<?php
	foreach ( array( 'name' => __( 'Hook name', 'MailPress' ), 'next' => __( 'Next&#160;run',  'MailPress' ), 'rec' => __( 'Recurrence','MailPress' ), 'args' => __( 'Arguments', 'MailPress' ) ) as $key => $display_name ) 
	{
		$display_name = ( 'next' != $key ) ? $display_name : '<abbr title="' . esc_attr( __( 'e.g., "now", "tomorrow", "+2 days", or "06/04/08 15:27:09"', 'MailPress' ) ) 	. '">' . $display_name . '</abbr>';
		$display_name = ( 'args' != $key ) ? $display_name : '<abbr title="' . esc_attr( __( 'JSON encoded string', 'MailPress' ) )								. '">' . $display_name . '</abbr>';
		echo "<th>$display_name</th>";
	} 
?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
<input type="text" name="name" id="wpcron_name" size="40" value="<?php if ( isset( $wpcron['hookname'] ) ) echo esc_attr( $wpcron['hookname'] ); ?>" />
					</td>
					<td>
<input type="text" name="next_run" id="wpcron_next_run" size="40" value="<?php if ( isset( $wpcron['next_run'] ) ) echo date( 'Y/m/d H:i:s', $wpcron['next_run'] ); else echo "now"; ?>" />
					</td>
					<td>
<select name="schedule" id="wpcron_schedule">
	<?php MP_AdminPage::select_option( MP_AdminPage::get_schedules(), $wpcron['schedule'] ?? '_oneoff' ); ?>
</select>
					</td>
					<td>
<input type="text" name="args" id="wpcron_args" size="40" value="<?php if ( isset( $wpcron['args'] ) ) echo htmlentities( json_encode( $wpcron['args'] ) ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		<div class="tablenav bottom">
			<div class="alignright actions">
				<input type="submit" name="submit" id="wpcron_submit" class="button" value="<?php echo $h3; ?>" />
				<?php echo $cancel; ?>
				<input type="hidden" name="action"   value="<?php echo $action; ?>" />
				<input type="hidden" name="formname" value="wp_cron_form" />
				<?php echo $hidden; ?>
				<?php wp_nonce_field( 'update-' . MP_AdminPage::tr_prefix_id ); ?>
			</div>
			<br class="clear" />
		</div>
		<br class="clear" />
	</form>
<?php
		break;
	}
}
?>
</div>