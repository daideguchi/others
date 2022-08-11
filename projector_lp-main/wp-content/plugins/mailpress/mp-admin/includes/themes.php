<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$url_parms = MP_AdminPage::get_url_parms();

//
// MANAGING H1
//

$h1 = __( 'MailPress Themes', 'MailPress' ); 

//
// MANAGING LIST
//

$th = MP_AdminPage::get_list( array() );

$themes = $th->themes;

//
// MANAGING MESSAGE / CHECKBOX RESULTS
//

switch (true)
{
	case ( ! $th->validate_current_theme() ) :
		$message = __( 'The active MailPress theme is broken.  Reverting to the default MailPress theme.', 'MailPress' );
	break;
        case ( isset( MP_AdminPage::$get_['activated'] ) ) :
		$message = __( 'New MailPress theme activated.', 'MailPress' );
	break;
}

?>
<div class="wrap">
	<h1 class="wp-heading-inline">
		<?php echo esc_html( $h1 ); ?>
		<span class="title-count theme-count">
			<?php echo count( $themes ); ?>
		</span>
	</h1>
	<hr class="wp-header-end">

<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>

	<div class="theme-browser rendered">
		<div class="themes wp-clearfix">
<?php

if ( $themes ) 
{
	$active = true;
	foreach( $themes as $theme )
	{
		echo MP_AdminPage::get_row( $theme, $active );
		$active = false;
	}
}
?>
		</div>
	</div>
<?php
// List broken themes, if any.
$broken_themes = $th->get_broken_themes();
if ( count( $broken_themes ) ) 
{
?>
	<h2><?php _e( 'Broken Themes' ); ?></h2>
	<p><?php _e( 'The following themes are installed but incomplete.  Themes must have a stylesheet and a template.' ); ?></p>

	<table class="wp-list-table widefat fixed striped theme" width="100%">
		<thead>
			<tr>
				<th><?php _e( 'Folder', 'MailPress' ); ?></th>
				<th><?php _e( 'Name', 'MailPress' ); ?></th>
				<th><?php _e( 'Description', 'MailPress' ); ?></th>
			</tr>
		</thead>
<?php
	$class = '';
	foreach ( $broken_themes as $theme ) 
	{
		$class = ( ' class="alternate"' == $class ) ? '' : ' class="alternate"';
?>
		<tbody>
			<tr<?php echo $class;?>>
				 <td><?php echo $theme['Folder'];?></td>
				 <td><?php echo $theme['Title'];?></td>
				 <td><?php echo $theme['Description'];?></td>
			</tr>
		</tbody>
<?php
	}
?>
	</table>
<?php
}
?>
</div>