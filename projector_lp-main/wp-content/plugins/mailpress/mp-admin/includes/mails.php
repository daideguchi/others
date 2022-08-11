<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms();

//
// MANAGING H1
//

$h1 = __( 'Mails', 'MailPress' );
$subtitle = '';

if ( isset( $url_parms['author'] ) ) 
{
	$author_user = get_userdata( $url_parms['author'] );
	$subtitle .= ' ' . sprintf( __( 'by %s' ), esc_html( $author_user->display_name ) );
}

//
// MANAGING MESSAGE / CHECKBOX RESULTS
//

$results = array( 	'deleted'	=> 	array( 	's' => __( '%s mail deleted', 'MailPress' ), 
									'p' => __( '%s mails deleted', 'MailPress' ) 
							),
				'sent'	=> 	array( 	's' => __( '%s mail sent', 'MailPress' ),
									'p' => __( '%s mails sent', 'MailPress' )
							),
				'notsent'	=> 	array( 	's' => __( '%s mail NOT sent', 'MailPress' ),
									'p' => __( '%s mails NOT sent', 'MailPress' )
							),
				'archived'	=> 	array( 	's' => __( '%s mail archived', 'MailPress' ),
									'p' => __( '%s mails archived', 'MailPress' )
							),
				'unarchived'=> 	array( 	's' => __( '%s mail unarchived', 'MailPress' ),
									'p' => __( '%s mails unarchived', 'MailPress' )
							),
				'paused'	=> 	array( 	's' => __( '%s mail paused', 'MailPress' ),
									'p' => __( '%s mails paused', 'MailPress' )
							),
				'restartd'	=> 	array( 	's' => __( '%s mail restarted', 'MailPress' ),
									'p' => __( '%s mails restarted', 'MailPress' )
							),
				'saved'	=> 	array( 	's' => __( 'Mail saved', 'MailPress' ),
									'p' => __( 'Mail saved', 'MailPress' )
							),
 );

foreach ( $results as $k => $v )
{
	if ( isset( MP_AdminPage::$get_[$k] ) && ( MP_AdminPage::$get_[$k] !== false ) )
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
// MANAGING DETAIL/LIST URL
//

if ( isset( $url_parms['mode'] ) ) $wmode = $url_parms['mode'];
$url_parms['mode'] = 'detail';
$detail_url = esc_url( MP_AdminPage::url( MailPress_mails, $url_parms ) );
$url_parms['mode'] = 'list';
$list_url = esc_url( MP_AdminPage::url( MailPress_mails, $url_parms ) );
if ( isset( $wmode ) ) $url_parms['mode'] = $wmode; 

//
// MANAGING BULK ACTIONS
//

$bulk_actions[''] = __( 'Bulk Actions' );
if ( isset( $url_parms['status'] ) )
{
	switch( $url_parms['status'] )
	{
		case 'draft' :
			$bulk_actions['send']		= __( 'Send', 'MailPress' );
		break;
		case 'sent' :
			$bulk_actions['archive']	= __( 'Archive', 'MailPress' );
		break;
		case 'archived' :
			$bulk_actions['unarchive']	= __( 'Unarchive', 'MailPress' );
		break;
	}
}
if ( current_user_can( 'MailPress_delete_mails' ) ) $bulk_actions['delete']  	= __( 'Delete', 'MailPress' );

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
		<a href="<?php echo MailPress_write; ?>" class="add-new-h2"><?php echo esc_html( __( 'Add New', 'MailPress' ) ); ?></a> 
<?php if ( isset( $url_parms['s'] ) ) printf( '<span class="subtitle">' . __( 'Search results for &#8220;%s&#8221;' ) . '</span>', esc_attr( $url_parms['s'] ) ); ?>
<?php if ( !empty( $subtitle ) )      echo    '<span class="subtitle">' . $subtitle . '</span>'; ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>

	<ul class="subsubsub"><?php echo $subsubsub_urls; ?></ul>

	<form id="posts-filter" method="get">

		<input type="hidden" name="page" value="<?php echo MP_AdminPage::screen; ?>" />
<?php MP_AdminPage::post_url_parms( $url_parms, array( 'mode', 'status' ) ); ?>

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
<!--
			<div class="view-switch">
				<a href="<?php echo $list_url;   ?>"><img id="view-switch-list"    height="20" width="20" <?php if ( 'list'   == $url_parms['mode'] ) echo 'class="current"' ?> alt="<?php echo esc_attr( __( 'List View', 'MailPress' ) );  ?>"  title="<?php esc_attr( __( 'List View', 'MailPress' ) );   ?>" src="../wp-includes/images/blank.gif" /></a>
				<a href="<?php echo $detail_url; ?>"><img id="view-switch-excerpt" height="20" width="20" <?php if ( 'detail' == $url_parms['mode'] ) echo 'class="current"' ?> alt="<?php echo esc_attr( __( 'Detail View', 'MailPress' ) ); ?>" title="<?php esc_attr( __( 'Detail View', 'MailPress' ) ); ?>" src="../wp-includes/images/blank.gif" /></a>
			</div>
-->
			<br class="clear" />
		</div>
		<div class="clear"></div>

		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
<?php MP_AdminPage::columns_list(); ?>
				</tr>
			</thead>
			<tbody id="the-mail-list" class="list:mail">
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

	<form id="get-extra-mails" method="post" class="hidden add:the-extra-mail-list:">

<?php MP_AdminPage::post_url_parms( ( array ) $url_parms ); ?>
<?php wp_nonce_field( 'add-mail', '_ajax_nonce', false ); ?>

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
</div>