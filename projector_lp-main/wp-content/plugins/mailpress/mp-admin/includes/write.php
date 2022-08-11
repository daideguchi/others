<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

global $draft; 

$url_parms 	= MP_AdminPage::get_url_parms();

//
// MANAGING RESULTS
//

if ( isset( MP_AdminPage::$get_['id'] ) )
{
	$draft 	= MP_Mail::get( MP_AdminPage::$get_['id'] );
	$rev_ids 	= MP_Mail_revision::get( $draft->id );
}

$autosave	= true;
$notice 	= false;

//
// MANAGING H1
//

$h1 		= __( 'Add New Mail', 'MailPress' );

$hidden  	= '<input type="hidden" name="id" id="mail_id" value="0" />';
$list_url 	= MP_AdminPage::url( MailPress_mails, $url_parms );

if ( isset( $draft ) )
{
	$h1			= sprintf( __( 'Edit Draft # %1$s', 'MailPress' ), $draft->id );
	$hidden		= '<input type="hidden" name="id" id="mail_id" value="' . $draft->id . '" />';
	$delete_url	= esc_url( add_query_arg( array( 'action' => 'delete', 'id' => $draft->id ), MailPress_write ) );

	$last_user		= get_userdata( $draft->created_user_id );
	$lastedited	= sprintf( __( 'Last edited by %1$s on %2$s at %3$s', 'MailPress' ), $last_user->display_name, mysql2date( get_option( 'date_format' ), $draft->created ), mysql2date( get_option( 'time_format' ), $draft->created ) );

/* revisions */
	if ( is_array( $rev_ids ) )
	{
		foreach ( $rev_ids as $rev_user => $rev_id )
		{
			global $current_user ;
			if ( $current_user->ID == $rev_user )
			{
				$revision = MP_Mail::get( $rev_id );
				break;
			}
			else
			{
				$x = MP_Mail::get( $rev_id );
				if ( $x )
				{
					if ( $x->created > $revision->created )
					{
						$revision = $x;
						$revision->not_this_user = true;
					}
				}
			}
		}
	}

	if ( isset( $revision ) )
	{
		if ( $revision->created > $draft->created )
		{
			$autosave_data = MP_Mail_revision::autosave_data();

			foreach ( $autosave_data as $k => $v )
			{
				if ( wp_text_diff( $revision->$k, $draft->$k ) ) 
				{
					$autosave = false;

					$notice = sprintf( __( 'There is an autosave of this mail that is more recent than the version below.  <a href="%s">View the autosave</a>.', 'MailPress' ), esc_url( MailPress_revision . "&id=$draft->id&revision=$revision->id" ) );
					break;
				}
			}
		}
	}
	else
	{
		$revision = new stdClass();
		$revision->id = '0';
	}

	if ( ( isset( $revision->not_this_user ) ) && ( $revision->not_this_user ) ) $revision->id = '0';

	$hidden .= '<input type="hidden" name="revision" id="mail_revision" value="' . $revision->id . '" />';
/* end of revisions */

/* lock */

	if ( $last = MP_Mail_lock::check( $draft->id ) )
	{
		$lock_user 	= get_userdata( $last );
		$lock_user_name = $lock_user ? $lock_user->display_name : __( 'Somebody' );
		$lock = sprintf( __( 'Warning: %s is currently editing this mail' ), esc_html( $lock_user_name ) );
	}
	else
	{
		MP_Mail_lock::set( $draft->id );
	}
/* end of lock */
}
else
{
	$draft = new stdClass();
	if ( isset( MP_AdminPage::$get_['toemail'] ) ) $draft->toemail = MP_AdminPage::$get_['toemail'];
}

$draft->_scheduled = ( !isset( $draft->sent ) || '0000-00-00 00:00:00' == $draft->sent ) ? false : true;

$HTTP_REFERER = filter_input( INPUT_SERVER, 'HTTP_REFERER' );
if ( isset( $HTTP_REFERER ) )
	$hidden .= '<input type="hidden" name="referredby" value="' . esc_url( $HTTP_REFERER ) . '" />';

// what else ?
	do_action( 'MailPress_update_meta_boxes_write' );

// messages
$class = 'fromto';
$message = $view_url = ''; $err = 0;

if ( isset( $draft->id ) )
{
	$args = array( 'id' => $draft->id, 'action' => 'mp_ajax', 'mp_action' => 'iview', 'TB_iframe' => 'true' );
	$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );
}

if ( isset( MP_AdminPage::$get_['sched'] ) ) 	{$err += 0; if ( !empty( $message ) ) $message .= '<br />'; $message .= sprintf( __( 'Mail scheduled for: <strong>%1$s</strong>. <a class="thickbox thickbox-preview" href="%2$s">Preview mail</a>',  'MailPress' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $draft->sent ) ), $view_url );}
if ( isset( MP_AdminPage::$get_['saved'] ) ) 	{$err += 0; if ( !empty( $message ) ) $message .= '<br />'; $message .= __( 'Mail saved', 'MailPress' ); }
if ( isset( MP_AdminPage::$get_['notsent'] ) ){$err += 1; if ( !empty( $message ) ) $message .= '<br />'; $message .= __( 'Mail NOT sent', 'MailPress' ); }
if ( isset( MP_AdminPage::$get_['nomail'] ) )	{$err += 1; if ( !empty( $message ) ) $message .= '<br />'; $message .= __( 'Please, enter a valid email',  'MailPress' ); $class = "TO"; }
if ( isset( MP_AdminPage::$get_['nodest'] ) )	{$err += 1; if ( !empty( $message ) ) $message .= '<br />'; $message .= __( 'Mail NOT sent, no recipient',  'MailPress' ); $class = "TO"; }
if ( isset( $lock ) )			{$err += 1; if ( !empty( $message ) ) $message .= '<br />'; $message .= $lock; }
if ( $notice )				{$err += 1; if ( !empty( $message ) ) $message .= '<br />'; $message .= $notice; } 	
if ( isset( MP_AdminPage::$get_['sent'] ) ) 	{$err += 0; if ( !empty( $message ) ) $message .= '<br />'; $message .= sprintf( _n( __( '%s mail sent', 'MailPress' ), __( '%s mails sent', 'MailPress' ), MP_AdminPage::$get_['sent'] ), MP_AdminPage::$get_['sent'] ); }
if ( isset( MP_AdminPage::$get_['revision'] )){$err += 0; if ( !empty( $message ) ) $message .= '<br />'; $message .= sprintf( __( 'Mail restored to revision from %s', 'MailPress' ), MP_Mail_revision::title(  MP_Mail::get( ( int ) MP_AdminPage::$get_['revision'] ), false ) ); }
$mp_general	= get_option( MailPress::option_name_general );

// from
if ( empty( $draft->fromemail ) )
{
	$draft->fromemail = apply_filters( 'MailPress_write_fromemail', $mp_general['fromemail'] );
	$draft->fromname  = apply_filters( 'MailPress_write_fromname',  $mp_general['fromname'] ); 
}

// to 
if ( isset( $draft->toemail ) )
{
	if ( !MailPress::is_email( $draft->toemail ) )
	{
		$draft->to_list = $draft->toemail;
		$draft->toemail = $draft->toname = '';
	}
	else
	{
		$draft->toname  = ( isset( $draft->toname ) ) ? esc_attr( $draft->toname ) : '';
	}
}
else
	$draft->toemail = $draft->toname = '';

// or to
$draft_dest = MP_User::get_mailinglists();

// mail formats
$mail_format = ( isset( $draft->id ) ) ? MP_Mail_meta::get( $draft->id, '_MailPress_format' ) : 'standard';

$all_mail_formats =  array( 
						'standard' => array ( 
							'description' 	=> __( 'Add a title and use the editor to compose your mail.', 'MailPress' ),
							'part'		=> __( 'Html', 'MailPress' )
						 ),
						'plaintext' => array ( 
							'description' => __( 'Type plaintext part of mail or generate it automatically using Synchronize button.', 'MailPress' ),
							'part'		=> __( 'Plaintext', 'MailPress' )
						 )
				 );

$mail_format_options = '';

foreach( $all_mail_formats as $slug => $attr ) { 
	$mf_class= ''; 
	if ( $mail_format == $slug ) { $mf_class = 'class="active"'; $mf_tip = sprintf( __( '%s Part', 'MailPress' ), $attr['part'] ); }

	$url	= esc_url( add_query_arg( 'format', $slug, MailPress_write ) );
	$mail_format_options .= '<a ' . $mf_class . ' href="' . $url . '" data-description="' . esc_attr( $attr['description'] ) . '" data-mp-format="' . esc_attr( $slug ) . '" title="' . esc_attr( sprintf( __( '%s Part', 'MailPress' ), $attr['part'] ) ) . '"><div class="' . $slug . '"></div></a>';
}

?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?>
	</h1>
<?php if ( $message ) MP_AdminPage::message( $message, ( $err ) ? false : true ); ?>

	<form id="writeform" name="writeform" method="post">

		<input type="hidden" name="action" 	value="draft" />
<?php echo $hidden; ?>
		<input type="hidden" name="user_ID" 	value="<?php echo MP_WP_User::get_id(); ?>" />
		<?php wp_nonce_field( 'closedpostboxes', 	'closedpostboxesnonce', 	false ); ?>
<?php if ( $autosave ) : ?>
		<?php wp_nonce_field( 'autosave', 		'autosavenonce', 		false ); ?>
		<?php wp_nonce_field( 'getpreviewlink', 	'getpreviewlinknonce', 	false ); ?>
		<?php wp_nonce_field( 'meta-box-order', 	'meta-box-order-nonce', 	false ); ?>
<?php endif; ?>

		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div id="side-info-column" class="inner-sidebar">
<?php do_meta_boxes( MP_AdminPage::screen, 'side', $draft ); ?>
			</div>

			<div id="post-body">
				<div id="post-body-content">

					<div class="mail-format-options">
						<span class="mail-format-tip"><?php echo $mf_tip; ?></span>
						<?php echo $mail_format_options; ?>
					</div>

					<div id="fromtodiv">
							<table class="wp-list-table widefat fixed striped zyxw">
								<tr>
									<td class="nobo">
										<div class="nobo">
											<select name="to_list" id="to_list"  class="<?php echo $class; ?>">
<?php MP_AdminPage::select_optgroup( $draft_dest, ( isset( $draft->to_list ) ) ? $draft->to_list : '' ) ?>
									</select>
								</div>
								<div id="toemail-toname" class="nobo <?php if ( isset( $draft->to_list ) ) echo ' hidden'; ?>">
									<label for="toemail" id="toemail-prompt-text" class="hide-if-no-js<?php if ( esc_attr( $draft->toemail ) != '' ) echo ' hidden' ; ?>"><?php _e( 'Enter email here', 'MailPress' ); ?></label>
									<input type="text" name="toemail" id="toemail" title="<?php echo esc_attr( __( 'Email', 'MailPress' ) ); ?>" class="<?php echo $class; ?>" value="<?php echo esc_attr( $draft->toemail ); ?>" />
									<label for="toname"  id="toname-prompt-text"  class="hide-if-no-js<?php if ( esc_attr( $draft->toname  ) != '' ) echo ' hidden' ; ?>"><?php _e( 'Enter name here',  'MailPress' ); ?></label>
									<input type="text" name="toname"  id="toname"  title="<?php echo esc_attr( __( 'Name', 'MailPress' ) ); ?>"  class="<?php echo $class; ?>" value="<?php echo esc_attr( $draft->toname ); ?>" />
								</div>
							</td></tr></table>


					</div>
					<div id="titlediv">
						<div id="titlewrap">
							<label for="title" id="title-prompt-text" class="hide-if-no-js<?php echo ( isset( $draft->subject ) ) ? ' hidden' : ''; ?>"><?php _e( 'Enter subject here', 'MailPress' ); ?></label>
							<input type="text" name="subject" id="title" size="30" tabindex="1" autocomplete="off" value="<?php echo ( isset( $draft->subject ) ) ? esc_attr( $draft->subject ) : ''; ?>" />
						</div>
					</div>


					<div class="mail-format-description"></div>
					<div class="mail-formats-fields">
						<input type="hidden" name="mail_format" id="mail_format" value="<?php echo $mail_format; ?>" >
						<div class="<?php if ( 'plaintext' != $mail_format ) echo 'hidden '; ?>field mp-format-plaintext" id="mp-format-plaintext">
							<label for="plaintext"><?php _e( 'Plaintext', 'MailPress' ); ?></label>
							<textarea name="plaintext" id="plaintext" class="widefat"><?php echo ( isset( $draft->plaintext ) ) ? esc_html ( $draft->plaintext ) : ''; ?></textarea>
						</div>
						<div id="div_html2txt" class="hidden">
							<a id="html2txt" class="button hide-if-no-js" onclick="return false;" title="<?php echo esc_attr( __( 'Plaintext from Html', 'MailPress' ) ); ?>" href="#">
								<span class="mp-media-buttons-icon"></span>
								<?php _e( 'Synchronize', 'MailPress' ); ?> 
							</a>
							<img id="html2txt_loading" src="images/wpspin_light.gif" alt="" />
						</div>
					</div>


					<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea edit-form-section">
<?php wp_editor( ( isset( $draft->html ) ) ? $draft->html : '', 'content', array( 'media_buttons' => true, 'tabindex' => 5 ) ); ?>
						<div id="post-status-info">
							<span id="wp-word-count" class="alignleft"></span>
							<span class="alignright">
								<span id="autosave">&#160;</span>
								<span id="last-edit">
<?php if ( isset( $lastedited ) ) : ?>
									<?php echo $lastedited; ?>
<?php	endif; ?>
								</span>
							</span>
							<br class="clear" />
						</div>
					</div>
<?php do_meta_boxes( MP_AdminPage::screen, 'normal', $draft ); ?>
				</div>
			</div>
		</div>
	</form>
</div>
<?php if ( !MP_AdminPage::flash() ) : ?>
	<div id="html-upload-iframes"></div>
<?php endif;