<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

global $mp_subscriptions;

//
// MANAGING H1
//

$h1 =  __( 'Manage Subscriptions', 'MailPress' );

//
// MANAGING SUBSCRIPTIONS
//

$email	= MP_WP_User::get_email();
$mp_user	= MP_User::get( MP_User::get_id_by_email( $email ) );
$active 	= ( 'active' == $mp_user->status ) ? true : false;

if ( isset( MP_AdminPage::$pst_['formname'] ) && ( 'sync_wordpress_user_subscriptions' == MP_AdminPage::$pst_['formname'] ) )
{
	if ( $mp_user->name != MP_AdminPage::$pst_['mp_user_name'] )
	{
		MP_User::update_name( $mp_user->id, MP_AdminPage::$pst_['mp_user_name'] );
		$mp_user->name = stripslashes( MP_AdminPage::$pst_['mp_user_name'] );
	}

	if ( class_exists( 'MailPress_comment' ) )					MailPress_comment::update_checklist( $mp_user->id );
	if ( class_exists( 'MailPress_newsletter' ) )  if ( $active ) 	MailPress_newsletter::update_checklist( $mp_user->id );
	if ( class_exists( 'MailPress_mailinglist' ) ) if ( $active ) 	MailPress_mailinglist::update_checklist( $mp_user->id );

	$message = __( 'Subscriptions saved', 'MailPress' );
}

$checklist_comments = $checklist_mailinglists = $checklist_newsletters = false;
if ( class_exists( 'MailPress_comment' ) )					$checklist_comments     = MailPress_comment::get_checklist( $mp_user->id );
if ( class_exists( 'MailPress_newsletter' ) )  if ( $active ) 	$checklist_newsletters  = MailPress_newsletter::get_checklist( $mp_user->id );
if ( class_exists( 'MailPress_mailinglist' ) ) if ( $active )	$checklist_mailinglists = MailPress_mailinglist::get_checklist( $mp_user->id );
?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>
	<form id="posts-filter" method="post">

		<input type="hidden" name="page" value="<?php echo MailPress_page_subscriptions; ?>" />
		<input type="hidden" name="formname" value="sync_wordpress_user_subscriptions" />

		<table class="form-table">
			<tr>
				<th><?php _e( 'Email', 'MailPress' ); ?></th>
				<td>
					<input type="text" value="<?php echo $mp_user->email; ?>" disabled="disabled"/>
				</td>
			</tr>
			<tr>
				<th><?php _e( 'Name', 'MailPress' ); ?></th>
				<td>
					<input type="text" name="mp_user_name" value="<?php echo esc_attr( $mp_user->name ); ?>" class="regular-text" />
				</td>
			</tr>
<?php if ( $checklist_comments ) : $ok = true; ?>
			<tr>
				<th><?php _e( 'Comments' ); ?></th>
				<td>
					<?php echo $checklist_comments; ?>
				</td>
			</tr>
<?php endif; ?> 	
<?php if ( $checklist_newsletters ) : $ok = true; ?>
			<tr>
				<th><?php _e( 'Newsletters', 'MailPress' ); ?></th>
				<td>
					<?php echo $checklist_newsletters; ?>
				</td>
			</tr>
<?php endif; ?> 	
<?php if ( $checklist_mailinglists ) : $ok = true; ?>
			<tr>
				<th><?php _e( 'Mailing lists', 'MailPress' ); ?></th>
				<td>
					<?php echo $checklist_mailinglists; ?>
				</td>
			</tr>
<?php endif; ?>
		</table>
<?php if ( isset( $ok ) ) : ?> 
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php  _e( 'Save', 'MailPress' ); ?>" />
		</p>
<?php else : ?> 
		<p>
<?php 
		if ( $active ) 	_e( 'Nothing to subscribe for ...', 'MailPress' );
		else			_e( 'Your email has been deactivated, ask the administrator ...', 'MailPress' );
?>
		</p>
<?php endif; ?> 
	</form>
</div>