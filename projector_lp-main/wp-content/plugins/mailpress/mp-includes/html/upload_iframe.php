<?php
new MP_WP_Emojis_off();
include( 'header.php' );
do_action( 'admin_print_scripts' );
do_action( 'admin_print_styles' );
?>
	</head>
	<body style="margin:0;padding:0;overflow:hidden;background:transparent;">
		<form id="upload_form_<?php echo $id; ?>" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="POST" enctype="multipart/form-data" style="margin:0;padding:0;overflow:hidden;cursor:default;">
			<input type="hidden" name="action" 		value="mp_ajax" />
			<input type="hidden" name="mp_action" 	value="html_mail_attachment" />
			<input type="hidden" name="draft_id" 		value="<?php echo $draft_id; ?>" />
			<input type="hidden" name="id" 			value="<?php echo $id; ?>" />
			<input type="hidden" name="max_file_size" 	value="<?php echo $bytes; ?>" />
			<label class="mp_fileupload_file" id="mp_fileupload_file">
				<input type="file" name="async-upload" id="mp_fileupload_file_<?php echo $id; ?>" />
			</label>
			<input type="submit" id="upload_iframe_submit_<?php echo $id; ?>" style="display:none;cursor:default;" />
		</form>
<?php do_action( 'admin_print_footer_scripts' ); ?>
	</body>
</html>