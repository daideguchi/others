<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms();

//
// MANAGING H1
//

$h1 = __( 'MailPress Add-ons', 'MailPress' );

//
// MANAGING MESSAGE / CHECKBOX RESULTS
//

$results = array(	'activated'	=> 	array( 	's' => __( '%s add-on activated', 'MailPress' ),
										'p' => __( '%s add-ons activated', 'MailPress' )
								),
				'deactivated'	=> 	array( 	's' => __( '%s add-on deactivated', 'MailPress' ),
										'p' => __( '%s add-ons deactivated', 'MailPress' )
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

$bulk_actions[''] = __( 'Bulk Actions' );
$context = ( isset( $url_parms['status'] ) ) ? $url_parms['status'] : false;
if ( 'active' != $context )
{
//	$bulk_actions['activate']   = __( 'Activate' );
}
if ( 'inactive' != $context )
{
	$bulk_actions['deactivate'] = __( 'Deactivate' );
}

//
// MANAGING LIST
//

list( $items, $subsubsub_urls ) = MP_AdminPage::get_list( array( 'url_parms' => $url_parms ) );

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
<?php MP_AdminPage::post_url_parms( $url_parms, array( 'status' ) ); ?>

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
<?php	 MP_AdminPage::get_bulk_actions( $bulk_actions ); ?>
			</div>
			<br class="clear" />
		</div>
		<div class="clear"></div>

		<table class="wp-list-table widefat striped plugins">
			<thead>
				<tr>
<?php MP_AdminPage::columns_list(); ?>
				</tr>
			</thead>
			<tbody class="addons">
<?php foreach ( $items as $item ) echo MP_AdminPage::get_row( $item, $url_parms ); ?>
			</tbody>
			<tfoot>
				<tr>
<?php MP_AdminPage::columns_list( false ); ?>
				</tr>
			</tfoot>
		</table>
		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">
<?php	 MP_AdminPage::get_bulk_actions( $bulk_actions, 'action2' ); ?>
			</div>
			<br class="clear" />
		</div>
	</form>
<?php
}
else
{
?>
	</form>
	<div class="clear"></div>
	<p>
		<?php _e( 'No results found.', 'MailPress' ) ?>
	</p>
<?php
}
?>
</div>