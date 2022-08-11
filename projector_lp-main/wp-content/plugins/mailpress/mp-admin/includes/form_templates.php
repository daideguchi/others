<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$form_templates = new MP_Form_templates();
$templates 	= $form_templates->get_all();
$template 		= MP_AdminPage::$get_['template'] ?? reset( $templates );

$advanced_path = 'advanced/' . get_current_blog_id() . '/forms';
$root  = MP_UPL_ABSPATH . $advanced_path;
$root  = apply_filters( 'MailPress_advanced_forms_root', $root );
$root .= '/templates';
$template_file = "$root/$template.xml";

if ( !is_file( $template_file ) ) wp_die( sprintf( '<p>%s</p>', __( 'No such file exists! Double check the name and try again.' ) ) );

$file_status = is_writeable( $template_file );

$content = file_get_contents( $template_file );
$content = htmlspecialchars( $content );
$codepress_lang = 'html';

//
// MANAGING H1
//

$h1 = __( 'Edit Form templates', 'MailPress' );

//
// MANAGING MESSAGE
//

$messages[1] = __( 'File edited successfully.', 'MailPress' );
$messages[2] = __( 'Could not save to file.',   'MailPress' );
$messages[3] = __( 'Could not save to file, xml errors',   'MailPress' );
if ( isset( MP_AdminPage::$get_['message'] ) ) $message = $messages[MP_AdminPage::$get_['message']];

?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>
	<br class="clear" />
	<div class="fileedit-sub">
		<div class="alignleft">
			<big>
<?php echo ( $file_status ) ? sprintf( __( 'Editing <strong>%s</strong>', 'MailPress' ), $template ) : sprintf( __( 'Browsing <strong>%s</strong>', 'MailPress' ), $template ); ?>
			</big>
		</div>
		<div class="alignright">
			<form method="post">
				<strong>
					<label for="plugin">
						<?php _e( 'Select template to edit:', 'MailPress' ); ?> 
					</label>
				</strong>
				<input type="hidden" name="action" value="toedit" />
				<select name="template" id="plugin">
<?php MP_AdminPage::select_option( $templates, $template ); ?>
				</select>
				<input type="submit" name="Submit" class="button" value="<?php echo esc_attr( __( 'Select' ) ) ?>" />
			</form>
		</div>
		<br class="clear" />
	</div>
	<form name="Template" id="Template" method="post">

		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="template" value="<?php echo $template; ?>" />
		<?php wp_nonce_field( 'edit-mp-template_' . $template ) ?>

		<div class="template">
			<textarea name="newcontent" id="newcontent" tabindex="1" class="hidden" rows="30" cols="100"><?php echo $content ?></textarea>
		</div>
<?php if ( $file_status ) : ?>
		<p class="submit"><input type="submit" name="submit" id="submit_xml" class="button-primary" tabindex="2" value="<?php echo esc_attr( __( 'Update File' ) ); ?>" /></p>
<?php else : ?>
		<p><em><?php _e( 'You need to make this file writable before you can save your changes. See <a href="http://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.' ); ?></em></p>
<?php endif; ?>
	</form>
<br class="clear" />
</div>