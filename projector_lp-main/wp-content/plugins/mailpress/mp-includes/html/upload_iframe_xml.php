<!DOCTYPE html>
<?php
new MP_WP_Emojis_off();
include( 'header.php' );
do_action( 'admin_print_scripts' );
?>
	</head>
	<body style="display:none;">
		<pre><?php echo $xml; ?></pre>
<?php do_action( 'admin_print_footer_scripts' ); ?>
	</body>
</html>