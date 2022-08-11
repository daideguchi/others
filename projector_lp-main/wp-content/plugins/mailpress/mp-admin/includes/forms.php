<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms( array( 's', 'paged', 'id' ) );

//
// MANAGING H1
//

$h1 = __( 'Forms', 'MailPress' );

//
// MANAGING MESSAGE
//

$messages[1] = __( 'Form added.', 'MailPress' );
$messages[2] = __( 'Form updated.', 'MailPress' );
$messages[3] = __( 'Form deleted.', 'MailPress' );
$messages[4] = __( 'Forms deleted.', 'MailPress' );
$messages[91] = __( 'Form not added.', 'MailPress' );
$messages[92] = __( 'Form not updated.', 'MailPress' );

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

global $action;
wp_reset_vars( array( 'action' ) );
if ( 'edit' == $action )
{
	$action = 'edited';
	$cancel = '<input type="submit" class="button" name="cancel" value="' . esc_attr( __( 'Cancel', 'MailPress' ) ) . '" />';

	$id = ( int ) $url_parms['id'];
	$form = MP_Form::get( $id );

	$h3 = sprintf( __( 'Edit Form # %1$s', 'MailPress' ), $id );
	$hb3= __( 'Update' );
	$hbclass = '-primary';
}
else
{
	$action = MP_AdminPage::add_form_id;
	$cancel = '';

	$form = new stdClass();

	$h3 = $hb3 = __( 'Add Form', 'MailPress' );
	$hbclass = '';
}

// Form settings tab

$tabs = array( 'attributes' => __( 'Attributes', 'MailPress' ), 'options' => __( 'Options', 'MailPress' ), 'messages' => __( 'Messages', 'MailPress' ), 'visitor' => __( 'Visitor', 'MailPress' ), 'recipient' => __( 'Recipient', 'MailPress' ) );
if ( isset( MP_AdminPage::$get_['action'] ) && ( 'edit' == MP_AdminPage::$get_['action'] ) ) $tabs['html'] = __( 'Html', 'MailPress' ); 

// Form templates

$form_templates = new MP_Form_templates();
$xform_template = $form_templates->get_all();

// Subscribing visitor actions

$xvisitor_subscriptions['0'] = __( 'no', 'MailPress' );
$xvisitor_subscriptions['1'] = __( 'not active', 'MailPress' );
$xvisitor_subscriptions['2'] = __( 'to be confirmed', 'MailPress' );
$xvisitor_subscriptions['3'] = __( 'active', 'MailPress' );

$xvisitor_mail['0'] = __( 'no', 'MailPress' );
$xvisitor_mail['1'] = __( 'to be confirmed', 'MailPress' );
$xvisitor_mail['2'] = __( 'yes', 'MailPress' );

// Mail themes and templates

$th = new MP_Themes();
$themes = $th->themes; 

foreach( $themes as $key => $theme )
{
	if ( 'plaintext' == $theme['Stylesheet'] ) unset( $themes[$key] );
	if ( '_' == $theme['Stylesheet'][0] )     unset( $themes[$key] );
}

if ( !isset( $form->settings['recipient']['theme'] ) ) $form->settings['recipient']['theme'] = $themes[$th->current_theme]['Stylesheet'];
if ( !isset( $form->settings['visitor'  ]['theme'] ) ) $form->settings['visitor'  ]['theme'] = $themes[$th->current_theme]['Stylesheet'];

$xtheme = $xtemplates = array();
foreach ( $themes as $theme )
{
	if ( 'plaintext' == $theme['Stylesheet'] ) continue;
	if ( '_'         == $theme['Stylesheet'][0] ) continue;

	$xtheme[$theme['Stylesheet']] = $theme['Stylesheet'];
	if ( !$templates = $th->get_page_templates( $theme['Stylesheet'] ) ) $templates = $th->get_page_templates( $theme['Stylesheet'], true );

	$xtemplates[$theme['Stylesheet']] = array();
	foreach ( $templates as $key => $value )
	{
		if ( strpos( $key, 'form' ) !== 0 ) continue;
		$xtemplates[$theme['Stylesheet']][$key] = $key;
	}
	if ( !empty( $xtemplates[$theme['Stylesheet']] ) ) ksort( $xtemplates[$theme['Stylesheet']] );

	array_unshift( $xtemplates[$theme['Stylesheet']], __( 'none', 'MailPress' ) );
}

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
					<table class="wp-list-table widefat fixed striped zyxw">
						<thead>
							<tr>
<?php MP_AdminPage::columns_list(); ?>
							</tr>
						</thead>
						<tbody id="<?php echo MP_AdminPage::list_id; ?>" class="list:<?php echo MP_AdminPage::tr_prefix_id; ?>">
<?php if ( $items ) : ?>
<?php foreach ( $items as $item ) { echo MP_AdminPage::get_row( $item->id, $url_parms ); } ?>
<?php endif; ?>
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

						<input type="hidden" name="action" value="<?php echo $action; ?>" />
<?php MP_AdminPage::post_url_parms( $url_parms, array( 's', 'paged', 'id' ) ); ?>
						<?php wp_nonce_field( 'update-' . MP_AdminPage::tr_prefix_id ); ?>

						<div class="form-field form-required nopm">
							<label for="form_label"><?php _e( 'Label', 'MailPress' ); ?></label>
							<input type="text" name="label" id="form_label" size="40" aria-required="true" value="<?php if ( isset( $form->label ) ) echo esc_attr( $form->label ); ?>" />
							<p>&#160;</p>
						</div>
						<div class="form-field nopm">
							<span class="fr">
								<span class="description"><small><?php _e( 'template', 'MailPress' ); ?></small></span>
								<select name="template" id="f_template" class="mr14">
<?php MP_AdminPage::select_option( $xform_template, $form->template ?? 'default' ); ?>
								</select>
							</span>
							<label for="form_description" class="di"><?php _e( 'Description', 'MailPress' ); ?></label>
							<input type="text" name="description" id="form_description" size="40" value="<?php if ( isset( $form->description ) ) echo esc_attr( $form->description ); ?>" />
							<p><small><?php _e( 'The description can be use to give further explanations', 'MailPress' ); ?></small></p>
						</div>
						<div id="form_settings" class="form field form_settings mt18">
							<ul>
<?php
	foreach( $tabs as $tab_type => $tab )
	{
		echo '<li><a href="#settings_tab_' . $tab_type . '"><span>' . $tab . '</span></a></li>' . "\n";
	}
?>
							</ul>
							<div class="clear">
<?php
	$i = 0;
	foreach( $tabs as $tab_type => $tab ) 
	{
		$i++;
		echo '								<div id="settings_tab_' . $tab_type . '" class="ui-tabs settings_form_tabs settings_' . $tab_type . '" data-tab="' . $i . '">' . "\n";
		switch ( $tab_type )
		{
			case 'attributes' : 
?>
									<span class="description"><small>class="</small></span><input type="text" name="settings[attributes][class]" id="form_attribute_class" size="40" class="w80" value="<?php if ( isset( $form->settings['attributes']['class'] ) ) echo esc_attr( $form->settings['attributes']['class'] ); ?>" /><span class="description"><small>"</small></span><br />
									<span class="description"><small>style="</small></span><input type="text" name="settings[attributes][style]" id="form_attribute_style" size="40" class="w80" value="<?php if ( isset( $form->settings['attributes']['style'] ) ) echo esc_attr( $form->settings['attributes']['style'] ); ?>" /><span class="description"><small>"</small></span><br />
									<input type="text" name="settings[attributes][misc]" id="form_attribute_misc" size="40" class="w98" value="<?php if ( isset( $form->settings['attributes']['misc'] ) ) echo esc_attr( $form->settings['attributes']['misc'] ); ?>" /><br />
									<span class="description"><i><?php _e( "other attributes except 'name' & 'action'", 'MailPress' ); ?></i></span>
<?php
			break;
			case 'options'    : 
?>
									<input type="checkbox" value="1" name="settings[options][reset]" id="form_option_reset" class="wa"<?php checked( '1', ( ( isset( $form->settings['options']['reset'] ) ) ? 1 : 0 ) ); ?> />
									<label for="form_option_reset" class="di"><small><?php _e( 'Reset after submission', 'MailPress' ); ?></small></label>
<?php
			break;
			case 'messages'    : 
?>
									<label for="f_message_ok"><small><?php _e( 'When processing form is successful', 'MailPress' ); ?></small></label>
									<input type="text" name="settings[message][ok]" id="f_message_ok" size="40" class="w98" value="<?php if ( isset( $form->settings['message']['ok'] ) ) echo esc_attr( $form->settings['message']['ok'] ); ?>" />
									<label for="f_message_ko"><small><?php _e( 'When processing form has failed', 'MailPress' ); ?></small></label>
									<input type="text" name="settings[message][ko]" id="f_message_ko" size="40" class="w98" value="<?php if ( isset( $form->settings['message']['ko'] ) ) echo esc_attr( $form->settings['message']['ko'] ); ?>" />
<?php
			break;

			case 'recipient'    : 
?>
									<div id="div_form_toemail">
										<label for="form_toemail"><small><?php _e( 'Email', 'MailPress' ); ?></small></label>
										<input type="text" name="settings[recipient][toemail]" id="form_toemail" size="40" class="wa form-required" aria-required="true" value="<?php if ( isset( $form->settings['recipient']['toemail'] ) ) echo $form->settings['recipient']['toemail']; ?>" />
									</div>
									<label for="form_toname"><small><?php _e( 'Name', 'MailPress' ); ?></small></label>
									<input type="text" id="form_toname" name="settings[recipient][toname]" size="40" class="wa" value="<?php if ( isset( $form->settings['recipient']['toname'] ) ) echo esc_attr( $form->settings['recipient']['toname'] ); ?>" />
									<label for="recipient_theme"><small><?php _e( 'Mail Theme/Template', 'MailPress' ); ?></small></label>
									<select name="settings[recipient][theme]" id="recipient_theme">
<?php MP_AdminPage::select_option( $xtheme, $form->settings['recipient']['theme'] ?? false ); ?>
									</select>
<?php 
foreach ( $xtemplates as $key => $xtemplate )
{
$xx = '0';
if ( isset( $form->settings['recipient']['template'] ) && $key == $form->settings['recipient']['theme'] ) $xx = $form->settings['recipient']['template'];
?>
									<select name="settings[recipient][th][<?php echo $key; ?>][tm]" id="recipient_<?php echo $key; ?>" class="<?php if ( $key != $form->settings['recipient']['theme'] ) echo 'mask ';?>recipient_template">
<?php MP_AdminPage::select_option( $xtemplate, $xx );?>
									</select>
<?php
}
			break;
			case 'visitor'    : 
?>
									<label for="visitor_subscription"><small><?php _e( 'Subscription option', 'MailPress' ); ?></small></label>
									<select name="settings[visitor][subscription]" id="visitor_subscription">
<?php MP_AdminPage::select_option( $xvisitor_subscriptions, $form->settings['visitor']['subscription'] ?? 0 ); ?>
									</select>
									<small><?php _e( 'Becomes a subscriber', 'MailPress' ); ?></small>
									<div class="<?php echo ( isset( $form->settings['visitor']['subscription'] ) && ( $form->settings['visitor']['subscription'] != '0' ) ) ? '' : 'mask '; ?>visitor_subscription_selected nopmb">
<?php do_action( 'MailPress_form_visitor_subscription', $form ?? false ); ?>
									</div>
									<label for="visitor_mail"><small><?php _e( 'Mail option', 'MailPress' ); ?></small></label>
									<select name="settings[visitor][mail]" id="visitor_mail">
<?php MP_AdminPage::select_option( $xvisitor_mail, $form->settings['visitor']['mail'] ?? 0 ); ?>
									</select>
									<small><?php _e( 'Receives a copy', 'MailPress' ); ?></small>
									<div class="<?php echo ( isset( $form->settings['visitor']['mail'] ) && ( $form->settings['visitor']['mail'] != '0' ) ) ? '' : 'mask '; ?>visitor_mail_selected nopmb">
										<label for="visitor_theme"><small><?php _e( 'Mail Theme/Template', 'MailPress' ); ?></small></label>
										<select name="settings[visitor][theme]" id="visitor_theme">
<?php MP_AdminPage::select_option( $xtheme, $form->settings['visitor']['theme'] ?? false ); ?>
										</select>
<?php 
foreach ( $xtemplates as $key => $xtemplate )
{
$xx = '0';
if ( isset( $form->settings['visitor']['template'] ) && $key == $form->settings['visitor']['theme'] ) $xx = $form->settings['visitor']['template'];
?>
										<select name="settings[visitor][th][<?php echo $key; ?>][tm]" id="visitor_<?php echo $key; ?>" class="<?php if ( $key != $form->settings['visitor']['theme'] ) echo 'mask ';?>visitor_template">
<?php MP_AdminPage::select_option( $xtemplate, $xx );?>
										</select>
<?php
}
?>
									</div>
<?php
			break;
			case 'html'       : 
				$html = $form_templates->get_form_template( $form->template );
				if ( !$html ) $html = '{{form}}';

				$search = $replace = array();
				$search[] = '{{label}}'; 	$replace[] = $form->label;
				$search[] = '{{description}}'; 	$replace[] = $form->description;
				$search[] = '{{form}}'; 	$replace[] = sprintf( '%1$s<!-- %2$s --></form>', MP_Form::get_tag( $form ), __( 'form content', 'MailPress' ) );
				$search[] = '{{message}}'; 	$replace[] = sprintf ( '<!-- %1$s -->', __( 'ok/ko message', 'MailPress' ) );
				$html = str_replace( $search, $replace, $html );
?>
									<div class="filter-img bkgndc bd1sc html">
										<?php echo htmlspecialchars( $html, ENT_QUOTES ); ?>
									</div>
									<p><small><?php printf( __( 'Template : %1$s', 'MailPress' ), $form->template ); ?></small></p>
<?php
			break;
		}
		echo "								</div>\n";
	}
?>									
							</div>
						</div>
						<p class="m15-0">
							<input type="submit" name="submit" id="form_submit" class="button<?php echo $hbclass; ?>" value="<?php echo $hb3; ?>" />
							<?php echo $cancel; ?>
						</p>
					</form>
				</div>
			</div>
		</div><!-- /col-left -->
	</div><!-- /col-container -->
</div><!-- /wrap -->