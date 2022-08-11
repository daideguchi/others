<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms();

//
// MANAGING H1
//

$h1 = __( 'Autoresponders', 'MailPress' );

//
// MANAGING MESSAGE
//

$messages[1] = __( 'Autoresponder added.', 'MailPress' );
$messages[2] = __( 'Autoresponder updated.', 'MailPress' );
$messages[3] = __( 'Autoresponder deleted.', 'MailPress' );
$messages[4] = __( 'Autoresponders deleted.', 'MailPress' );
$messages[91] = __( 'Autoresponder not added.', 'MailPress' );
$messages[92] = __( 'Autoresponder not updated.', 'MailPress' );

if ( isset( MP_AdminPage::$get_['message'] ) )
{
	$message = $messages[MP_AdminPage::$get_['message']];
	$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'message' ), $_SERVER['REQUEST_URI'] );
}

//
// MANAGING BULK ACTIONS
//

$bulk_actions[''] 		= __( 'Bulk Actions' );
$bulk_actions['delete']	= __( 'Delete', 'MailPress' );

//
// MANAGING CONTENT
//

$mp_autoresponder_registered_events = MP_Autoresponder_events::get_all();

global $action;
wp_reset_vars( array( 'action' ) );
if ( 'edit' == $action ) 
{
	$action = 'edited';
	$cancel = '<input type="submit" name="cancel" class="button" value="' . esc_attr( __( 'Cancel', 'MailPress' ) ) . '" />';

	$id = ( int ) MP_AdminPage::$get_['id'];
	$autoresponder = MP_Autoresponder::get( $id );

	$h3 = __( 'Edit Autoresponder', 'MailPress' );
	$hb3= __( 'Update' );
	$hbclass = '-primary';

	$disabled = '';
		
	$hidden =  '<input type="hidden" name="id"   value="' . $id . '" />';
	$hidden .= '<input type="hidden" name="name" value="' . esc_attr( $autoresponder->name ) . '"/>';
	
	$_mails = MP_Autoresponder::get_term_objects( $id );
}
else 
{
	$action = MP_AdminPage::add_form_id;
	$cancel = '';

	$autoresponder = new stdClass();

	$h3 = $hb3 = __( 'Add Autoresponder', 'MailPress' );
	$hbclass = '';

	$disabled = '';
	$hidden = '';

	$_mails = false;
}

//
// MANAGING LIST
//

$url_parms['paged'] = $url_parms['paged'] ?? 1;
$_per_page = MP_AdminPage::get_per_page();

$total = ( isset( $url_parms['s'] ) ) ? count( MP_Autoresponder::get_all( array( 'hide_empty' => 0, 'search' => $url_parms['s'] ) ) ) : wp_count_terms( MP_AdminPage::taxonomy );

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
						<tbody id="<?php echo MP_AdminPage::list_id; ?>" class="list:<?php echo MP_AdminPage::tr_prefix_id; ?> autoresponders">
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
			</div>
		</div><!-- /col-right -->
		<div id="col-left">
			<div class="col-wrap">
				<div class="form-wrap">
					<h3><?php echo esc_html( $h3 ); ?></h3>
					<div id="ajax-response"></div>
					<form name="<?php echo $action; ?>"  id="<?php echo $action; ?>"  method="post" class="<?php echo $action; ?>:<?php echo MP_AdminPage::list_id; ?>: validate">

						<input type="hidden" name="action"   value="<?php echo $action; ?>" />
						<input type="hidden" name="formname" value="autoresponder_form" />
						<?php echo $hidden; ?>
						<?php wp_nonce_field( 'update-' . MP_AdminPage::tr_prefix_id ); ?>

						<div class="form-field form-required nopm">
							<label for="autoresponder_name"><?php _e( 'Name', 'MailPress' ); ?></label>
							<input type="text" name="name" id="autoresponder_name" size="40" aria-required="true"<?php echo $disabled; ?> value="<?php if ( isset( $autoresponder->name ) ) echo esc_attr( $autoresponder->name ); ?>" />
							<p><?php _e( 'The name is used to identify the autoresponder almost everywhere.', 'MailPress' ); ?></p>
						</div>
						<div class="form-field nopm">
							<label for="autoresponder_slug"><?php _e( 'Slug', 'MailPress' ) ?></label>
							<input type="text" name="slug" id="autoresponder_slug" size="40" value="<?php if ( isset( $autoresponder->slug ) ) echo esc_attr( $autoresponder->slug ); ?>" />
							<p><?php _e( 'The &#8220;slug&#8221; is a unique id for the autoresponder (not so friendly !).', 'MailPress' ); ?></p>
						</div>
						<div class="form-field nopm">
							<label for="autoresponder_description"><?php _e( 'Description', 'MailPress' ) ?></label>
							<input type="text" name="description[desc]" id="autoresponder_description" size="40" value="<?php if ( isset( $autoresponder->description ) ) echo htmlentities( stripslashes( $autoresponder->description['desc'] ),ENT_QUOTES ); ?>" />
							<p><?php _e( 'The description is not prominent by default.', 'MailPress' ); ?></p>
						</div>
						<div class="form-field nopm">
							<label for="autoresponder_active"><?php _e( 'Active', 'MailPress' ) ?></label>
							<input type="checkbox" name="description[active]" class="wa" id="autoresponder_active"<?php checked( isset( $autoresponder->description['active'] ) ); ?> />
							<p><?php _e( "If unchecked during a certain period of time, All mails that should have been sent on time will be cancelled. Following mails (if any) will be lost as well.", 'MailPress' ); ?></p>
						</div>
						<div class="form-field nopm">
							<label for="autoresponder_event"><?php _e( 'Event', 'MailPress' ) ?></label>
							<select name="description[event]" id="autoresponder_event">
<?php MP_AdminPage::select_option( $mp_autoresponder_registered_events, $autoresponder->description['event'] ?? false ); ?>
							</select>
						</div>
						<div id="autoresponder_events_specs">
<?php foreach ( $mp_autoresponder_registered_events as $key => $event ) : ?>
							<div id="autoresponder_<?php echo $key; ?>_settings" class="autoresponder_settings <?php if ( !isset( $autoresponder->description['event'] ) || $key != $autoresponder->description['event'] ) echo " hidden"; ?>">
<?php do_action( "MailPress_autoresponder_{$key}_settings_form", ( isset( $autoresponder->description['settings'] ) ) ? $autoresponder->description['settings'] : 0 ); ?>
							</div>
<?php endforeach; ?>
						</div>
<?php if ( $_mails ) : ?>
						<div class="form-field nopm">
							<label><?php _e( 'Mails', 'MailPress' ) ?></label>
							<table class="wp-list-table widefat fixed striped autoresponder" id="autoresponder_mails">
								<thead>
									<tr>
										<th><?php _e( 'mail', 'MailPress' ); ?></th>
										<th><?php _e( 'subject', 'MailPress' ); ?></th>
										<th><?php _e( 'y/m/w/d/h', 'MailPress' ); ?></th>
									</tr>
								</thead>
								<tbody>
<?php 	foreach( $_mails as $_mail ) 
		{ 
			$id   = $_mail['mail_id'];
			$mail = MP_Mail::get( $id );
			$subject_display = htmlspecialchars( $mail->subject,ENT_QUOTES );
			if ( strlen( $subject_display ) > 40 )	$subject_display = mb_substr( $subject_display, 0, 39, get_option( 'blog_charset' ) ) . '...';
			if ( '' == $mail->subject )  			$subject_display = $mail->subject = htmlspecialchars( __( '(no subject)', 'MailPress' ),ENT_QUOTES );

			$edit_url    	= esc_url( MailPress_edit . "&id=$id" );
			$actions['edit']    = '<a href="' . $edit_url . '" title="' . esc_attr( sprintf( __( 'Edit &#8220;%1$s&#8221;', 'MailPress' ) , $subject_display ) ) . '">' . $_mail['mail_id'] . '</a>';

			$args = array( 'id' => $id, 'action' => 'mp_ajax', 'mp_action' => 'iview', 'TB_iframe' => 'true' );
			$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );
			$actions['view'] = '<a href="' . $view_url . '" class="thickbox thickbox-preview" title="' . esc_attr( sprintf( __( 'View &#8220;%1$s&#8221;', 'MailPress' ) , $subject_display ) ) . '">' . $subject_display . '</a>';
?>
									<tr>
										<td>
											<?php echo $actions['edit']; ?>
										</td>
										<td>
											<?php echo $actions['view']; ?>
										</td>
										<td>
											<?php unset( $_mail['schedule']['date'] ); echo implode( '/', $_mail['schedule'] ); ?>
										</td>
									</tr>
<?php 	} ?>
								</tbody>
							</table>
							<p></p>
						</div>
<?php endif; ?>
						<p class="submit">
							<input type="submit" name="submit" id="autoresponder_submit" class="button<?php echo $hbclass; ?>" value="<?php echo $hb3; ?>" />
							<?php echo $cancel; ?>
						</p>
					</form>
				</div>
			</div>
		</div><!-- /col-left -->
	</div><!-- /col-container -->
</div><!-- /wrap -->