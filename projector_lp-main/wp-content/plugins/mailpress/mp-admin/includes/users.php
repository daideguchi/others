<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

do_action( 'MailPress_users_addon_update' );

$url_parms = MP_AdminPage::get_url_parms( array( 'status', 's', 'paged', 'author', 'mailinglist', 'newsletter', 'startwith' ) );

//
// MANAGING H1
//

$h1 = __( 'Users', 'MailPress' );
$subtitle = '';

if ( isset( $url_parms['startwith'] ) ) 
{
	$subtitle .= ' ' . sprintf( __( 'starting with &#8220;%s&#8221;', 'MailPress' ), $url_parms['startwith'] );
}
if ( isset( $url_parms['newsletter'] ) && !empty( $url_parms['newsletter'] ) ) 
{
	$newsletter = MP_Newsletter::get( $url_parms['newsletter'] );
	$subtitle .= ' ' . sprintf( __( 'in &#8220;%s&#8221;', 'MailPress' ), esc_html( $newsletter['descriptions']['admin'] ) );
}
if ( isset( $url_parms['mailinglist'] ) && !empty( $url_parms['mailinglist'] ) ) 
{
	$mailinglist = MP_Mailinglist::get( $url_parms['mailinglist'] );
	$subtitle .= ' ' . sprintf( __( 'in &#8220;%s&#8221;', 'MailPress' ), esc_html( $mailinglist->name ) );
}
if ( isset( $url_parms['author'] ) ) 
{
	$author_user = get_userdata( $url_parms['author'] );
	$subtitle .= ' ' . sprintf( __( 'by %s' ), esc_html( $author_user->display_name ) );
}

//
// MANAGING MESSAGE / CHECKBOX RESULTS
//

$results = array(	'activated'	=> 	array( 	's' => __( '%s subscriber activated', 'MailPress' ),  
										'p' => __( '%s subscribers activated', 'MailPress' )
								),
				'deactivated'	=>	array( 	's' => __( '%s subscriber deactivated', 'MailPress' ),
										'p' => __( '%s subscribers deactivated', 'MailPress' )
								),
				'unbounced'	=> 	array( 	's' => __( '%s subscriber unbounced', 'MailPress' ),
										'p' => __( '%s subscribers unbounced', 'MailPress' )
								),
				'deleted'		=> 	array( 	's' => __( '%s subscriber deleted', 'MailPress' ),
										'p' => __( '%s subscribers deleted', 'MailPress' )
								),
				'geolocated'	=> 	array( 	's' => __( '%s subscriber geolocated', 'MailPress' ), 
										'p' => __( '%s subscribers geolocated', 'MailPress' )
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
if ( isset( $url_parms['status'] ) )
{
	switch( $url_parms['status'] )
	{
		case 'waiting' :
			$bulk_actions['activate']  = __( 'Activate', 'MailPress' );
		break;
		case 'unsubscribed' :
			$bulk_actions['deactivate']= __( 'Deactivate', 'MailPress' );
		break;
		case 'active' :
			$bulk_actions['deactivate']= __( 'Deactivate', 'MailPress' );
		break;
		case 'bounced' :
			$bulk_actions['unbounce']  = __( 'Unbounce', 'MailPress' );
		break;
	}
}
if ( current_user_can( 'MailPress_delete_users' ) ) $bulk_actions['delete'] = __( 'Delete', 'MailPress' );

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
		<!-- <a id="new_mp_user" href="" class="add-new-h2"><?php echo esc_html( __( 'Add New', 'MailPress' ) ); ?></a> -->
<?php if ( isset( $url_parms['s'] ) ) printf( '<span class="subtitle">' . __( 'Search results for &#8220;%s&#8221;' ) . '</span>', esc_attr( $url_parms['s'] ) ); ?>
<?php if ( !empty( $subtitle ) )      echo    '<span class="subtitle">' . $subtitle . '</span>'; ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>

	<ul class="subsubsub"><?php echo $subsubsub_urls; ?></ul>

	<form id="posts-filter" method="get">
		<input type="hidden" name="page" value="<?php echo MP_AdminPage::screen; ?>" />
<?php MP_AdminPage::post_url_parms( $url_parms, array( 'mode', 'status', 'author', 'mailinglist', 'newsletter' ) ); ?>

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
			<div class="alignleft actions">
<?php do_action( 'MailPress_users_restrict',$url_parms ); ?>
				<input type="submit" id="restrict" class="button-secondary" value="<?php echo esc_attr( __( 'Filter', 'MailPress' ) ); ?>" />
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
			<tbody id="the-user-list" class="list:user">
<?php foreach ( $items as $item ) { echo MP_AdminPage::get_row( $item->id, $url_parms ); } ?>
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

	<form id="get-extra-users" method="post" class="hidden add:the-extra-user-list:">
<?php MP_AdminPage::post_url_parms( ( array ) $url_parms ); ?>
<?php wp_nonce_field( 'add-user', '_ajax_nonce', false ); ?>
	</form>

	<div id="ajax-response"></div>

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
<?php do_action( 'MailPress_users_addon',$url_parms ); ?>
</div>