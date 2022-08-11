<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$f = MP_AdminPage::$get_['id'];
$view_url 	= MP_AdminPage::get_url() . '/' . $f;

//
// MANAGING H1
//

$h1 = sprintf( __( 'Log : %1$s', 'MailPress' ), $f );

?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>
	<div><p>&#160;</p></div>
	<iframe id="mp" name="mp" src="<?php echo $view_url; ?>" ></iframe>
</div>