<?php if ( !( function_exists( 'current_user_can' ) && current_user_can( 'MailPress_manage_forms' ) ) ) die( 'Access denied' ); ?>
<!DOCTYPE html>
<?php include( 'header.php' ); ?>
	</head>
	<body id="media-upload">
		<div id="wpwrap">
<?php
	if ( function_exists( 'apply_shortcodes' ) ) /* since WordPress 5.4 */
		echo apply_shortcodes( "[mailpress_form id='" . $form->id . "']" );
	else
		echo do_shortcode( "[mailpress_form id='" . $form->id . "']" );
?>
		</div>
	</body>
</html>