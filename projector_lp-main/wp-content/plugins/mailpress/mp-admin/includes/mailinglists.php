<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms();

//
// MANAGING H1
//

$h1 = __( 'Mailing lists', 'MailPress' ); 

//
// MANAGING MESSAGE
//

$messages[1] = __( 'Mailinglist added.', 'MailPress' );
$messages[2] = __( 'Mailinglist updated.', 'MailPress' );
$messages[3] = __( 'Mailinglist deleted.', 'MailPress' );
$messages[4] = __( 'Mailinglists deleted.', 'MailPress' );
$messages[91] = __( 'Mailinglist not added.', 'MailPress' );
$messages[92] = __( 'Mailinglist not updated.', 'MailPress' );

if ( isset( MP_AdminPage::$get_['message'] ) )
{
	$message = $messages[MP_AdminPage::$get_['message']];
	$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'message' ), $_SERVER['REQUEST_URI'] );
}

//
// MANAGING BULK ACTIONS
//

$bulk_actions['']		= __( 'Bulk Actions' );
$bulk_actions['delete']	= __( 'Delete', 'MailPress' );

//
// MANAGING CONTENT
//

global $action;
wp_reset_vars( array( 'action' ) );
if ( 'edit' == $action ) 
{
	$action = 'edited';
	$cancel = '<input type="submit" name="cancel" class="button" value="' . esc_attr( __( 'Cancel', 'MailPress' ) ) . '" />';

	$id = ( int ) MP_AdminPage::$get_['id'];
	$mailinglist = MP_Mailinglist::get( $id, OBJECT, 'edit' );

	$h3 = __( 'Edit Mailing List', 'MailPress' );
	$hb3= __( 'Update' );
	$hbclass = '-primary';

	$disabled = '';

	$hidden =  '<input type="hidden" name="id"   value="' . $id . '" />';
	$hidden .= '<input type="hidden" name="name" value="' . esc_attr( $mailinglist->name ) . '" />';
}
else 
{
	$action = MP_AdminPage::add_form_id;
	$cancel = '';

	$mailinglist = new stdClass();

	$h3 = $hb3 = __( 'Add Mailing List', 'MailPress' );
	$hbclass = '';

	$disabled = '';
	$hidden = '';
}

//
// MANAGING LIST
//

$url_parms['paged'] = $url_parms['paged'] ?? 1;
$_per_page = MP_AdminPage::get_per_page();

$total = ( isset( $url_parms['s'] ) ) ? count( MP_Mailinglist::get_all( array( 'hide_empty' => 0, 'search' => $url_parms['s'] ) ) ) : wp_count_terms( MP_AdminPage::taxonomy );

?>
<div class="wrap nosubsub">
	<h1>
		<?php echo esc_html( $h1 ); ?> 
<?php if ( isset( $url_parms['s'] ) ) printf( '<span class="subtitle">' . __( 'Search results for &#8220;%s&#8221;' ) . '</span>', esc_attr( $url_parms['s'] ) ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message, ( MP_AdminPage::$get_['message'] < 90 ) ); ?>
	<form class="search-form topmargin" method="get">

		<input type="hidden" name="page" value="<?php echo MP_AdminPage::screen; ?>" />

		<p class="search-box">
			<input type="text" name="s" class="search-input" value="<?php if ( isset( $url_parms['s'] ) ) echo esc_attr( $url_parms['s'] ); ?>" />
			<input type="submit" class="button" value="<?php _e( 'Search', 'MailPress' ); ?>" />
		</p>

	</form>
	<br class="clear" />
	<div id="col-container">
		<div id="col-right">
			<div class="col-wrap">
				<form id="posts-filter" method="get">

					<input type="hidden" name="page" value="<?php echo MP_AdminPage::screen; ?>" />

					<div class="tablenav top">
<?php MP_AdminPage::pagination( $total ); ?>
						<div class="alignleft actions bulkactions">
<?php	MP_AdminPage::get_bulk_actions( $bulk_actions ); ?>
						</div>
						<br class="clear" />
					</div>
					<div class="clear"></div>
					<table class="wp-list-table widefat fixed striped <?php echo MP_AdminPage::tr_prefix_id; ?>">
						<thead>
							<tr>
<?php MP_AdminPage::columns_list(); ?>
							</tr>
						</thead>
						<tbody id="<?php echo MP_AdminPage::list_id; ?>" class="list:<?php echo MP_AdminPage::tr_prefix_id; ?> mailinglists">
<?php MP_AdminPage::get_list( array( 'start' => $url_parms['paged'], '_per_page' => $_per_page ) ); ?>
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
					<br class="clear" />
				</form>
				<div class="form-wrap">
					<p><?php printf( __( '<strong>Note:</strong><br />Deleting a mailing list does not delete the MailPress users in that mailing list. Instead, MailPress users that were only assigned to the deleted mailing list are set to the mailing list <strong>%s</strong>.', 'MailPress' ), MP_Mailinglist::get_name( get_option( MailPress_mailinglist::option_name_default ) ) ) ?></p>
				</div>
			</div>
		</div><!-- /col-right -->
		<div id="col-left">
			<div class="col-wrap">
				<div class="form-wrap">
					<h3><?php echo esc_html( $h3 ); ?></h3>
					<div id="ajax-response"></div>
					<form name="<?php echo $action; ?>"  id="<?php echo $action; ?>"  method="post" class="<?php echo $action; ?>:<?php echo MP_AdminPage::list_id; ?>: validate">

						<input type="hidden" name="action"   value="<?php echo $action; ?>" />
						<input type="hidden" name="formname" value="mailinglist_form" />
						<?php echo $hidden; ?>
						<?php wp_nonce_field( 'update-' . MP_AdminPage::tr_prefix_id ); ?>

						<div class="form-field form-required nopm">
							<label for="mailinglist_name"><?php _e( 'Name', 'MailPress' ); ?></label>
							<input type="text" name="name" id="mailinglist_name" size="40" aria-required="true" value="<?php if ( isset( $mailinglist->name ) ) echo esc_attr( $mailinglist->name ); ?>"<?php echo $disabled; ?> />
							<p><?php _e( 'The name is used to identify the mailinglist almost everywhere.', 'MailPress' ); ?></p>
						</div>
						<div class="form-field nopm">
							<label for="mailinglist_slug"><?php _e( 'Slug', 'MailPress' ) ?></label>
							<input type="text" name="slug" id="mailinglist_slug" size="40" value="<?php if ( isset( $mailinglist->slug ) ) echo esc_attr( $mailinglist->slug ); ?>" />
							<p><?php _e( 'The &#8220;slug&#8221; is a unique id for the mailing list (not so friendly !).', 'MailPress' ); ?></p>
						</div>
						<div class="form-field nopm">
							<label for="mailinglist_description"><?php _e( 'Description', 'MailPress' ) ?></label>
							<input type="text" name="description" id="mailinglist_description" size="40" value="<?php if ( isset( $mailinglist->description ) ) echo stripslashes( $mailinglist->description ); ?>" />
							<p><?php _e( 'The description is not prominent by default.', 'MailPress' ); ?></p>
						</div>
						<div class="form-field nopm">
							<label for="mailinglist_parent"><?php _e( 'Mailing list Parent', 'MailPress' ) ?></label>
							<?php MP_Mailinglist::dropdown( array( 'hide_empty' => 0, 'htmlname' => 'parent', 'orderby' => 'name', 'htmlid' => 'mailinglist_parent', 'selected' => ( isset( $mailinglist->parent ) ) ? $mailinglist->parent : '', 'exclude' => ( isset( $id ) ) ? $id : '', 'hierarchical' => true, 'show_option_none' => __( 'None', 'MailPress' ) ) ); ?>
							<p><?php _e( "Mailing list can have a hierarchy. You might have a Rock'n roll mailing list, and under that have children mailing lists for Elvis and The Beatles. Totally optional !", 'MailPress' ); ?></p>
						</div>
						<p class="submit">
							<input type="submit" name="submit" id="mailinglist_submit" class="button<?php echo $hbclass; ?>" value="<?php echo $hb3; ?>" />
							<?php echo $cancel; ?>
						</p>
					</form>
				</div>
			</div>
		</div><!-- /col-left -->
	</div><!-- /col-container -->
</div><!-- /wrap -->