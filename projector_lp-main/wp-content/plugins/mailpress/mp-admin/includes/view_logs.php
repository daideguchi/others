<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms();

//
// MANAGING H1
//

$h1 = __( 'Logs', 'MailPress' );

//
// MANAGING MESSAGE / CHECKBOX RESULTS
//

$results = array(	'deleted'	=> 	array( 	's' => __( '%s file deleted', 'MailPress' ), 
									'p' => __( '%s files deleted', 'MailPress' ) 
							),
);

foreach ( $results as $k => $v )
{
	if ( isset( MP_AdminPage::$get_[$k] ) && MP_AdminPage::$get_[$k] )
	{
		if ( !isset( $message ) ) 
		{
			$message = '';
		}
		$message .= sprintf( _n( $v['s'], $v['p'], MP_AdminPage::$get_[$k] ), MP_AdminPage::$get_[$k] );
		$message .=  '<br />';
	}
}

//
// MANAGING BULK ACTIONS
//

$bulk_actions['']		= __( 'Bulk Actions' );
$bulk_actions['delete']	= __( 'Delete', 'MailPress' );

//
// MANAGING LIST
//

$url_parms['paged'] = $url_parms['paged'] ?? 1;
$_per_page = MP_AdminPage::get_per_page();

do
{
	$start = ( $url_parms['paged'] - 1 ) * $_per_page;
	list( $items, $total, $subsubsub_urls ) = MP_AdminPage::get_list( array( 'start' => $start, '_per_page' => $_per_page, 'url_parms' => $url_parms ) );
	$url_parms['paged']--;
} while ( $total <= $start );
$url_parms['paged']++;

?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?> 
<?php if ( isset( $url_parms['s'] ) ) printf( '<span class="subtitle">' . __( 'Search results for &#8220;%s&#8221;' ) . '</span>', esc_attr( $url_parms['s'] ) ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>

	<ul class="subsubsub"><?php echo $subsubsub_urls; ?></ul>

	<form id="posts-filter" method="get">

		<input type="hidden" name="page" value="<?php echo MP_AdminPage::screen; ?>" />

		<p class="search-box">
			<input type="text" name="s" class="search-input" value="<?php if ( isset( $url_parms['s'] ) ) echo esc_attr( $url_parms['s'] ); ?>" />
			<input type="submit" class="button" value="<?php _e( 'Search', 'MailPress' ); ?>" />
		</p>
<?php
if ( $items )
{
?>
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
			<tbody id="the-file-list" class="list:file">
<?php	foreach ( $items as $item ) echo MP_AdminPage::get_row( $item, $url_parms ); ?>
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

	<form id="get-extra-files" method="post" class="hidden add:the-extra-file-list:">

<?php  MP_AdminPage::post_url_parms( ( array ) $url_parms ); ?>
<?php wp_nonce_field( 'add-file', '_ajax_nonce', false ); ?>

	</form>

	<div id="ajax-response"></div>
<?php
}
else
{
?>
	</form>
	<p>
		<?php ( is_dir( '../' . MP_AdminPage::get_path() ) ) ? _e( 'No logs available', 'MailPress' ) : printf( __( 'Wrong path : %s', 'MailPress' ), '../' . MP_AdminPage::get_path() ); ?>
	</p>
<?php
}
?>
</div>