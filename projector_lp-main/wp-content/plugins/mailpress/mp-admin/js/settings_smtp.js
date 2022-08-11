// settings_smtp

jQuery(document).ready( function(){ 
		jQuery('#connection_smtp_auth').change( function() {
			jQuery('#POP3').toggle();
		});
});
