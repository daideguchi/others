// forms

var mp_forms = {

	control : function() {
		var err = jQuery('div#div_form_toemail').hasClass('form-invalid');

		if (!mp_forms.is_email(jQuery('#form_toemail').val()))
		{
			jQuery('div#div_form_toemail').addClass('form-invalid');
			jQuery("#form_settings").tabs( 'select' , 4 );
		}
		else jQuery('div#div_form_toemail').removeClass('form-invalid');
	},

	is_empty : function(t) { return (t.length == 0); },
//	is_email : function(m) { var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/; return pattern.test(m); },
	is_email : function(m) {
		var _r;
		var data = { action: "mp_ajax", mp_action: "email", email: m }; 
		jQuery.ajax({ 
			data: data, type: "POST", 
			async: false, 
			url: ajaxurl, 
			success: function(r) { _r = r;} 
		}); 
		return (_r==1); 
	},

	init : function() {
		//
		jQuery("#mp_help").tabs();
		jQuery("#form_settings").tabs({
			activate : function( event, ui){
				jQuery("[href='#mp_help_tab_" + ui.newPanel.attr('data-tab') + "']").click();
			}
		});
		// 
		jQuery('#recipient_theme').change( function() {
			var a = jQuery(this); 
			jQuery('.recipient_template').hide(); 
			jQuery( '#recipient_' + a.val()).show();
		 });
		// 
		jQuery('#visitor_theme').change( function() {
			var a = jQuery(this); 
			jQuery('.visitor_template').hide(); 
			jQuery( '#visitor_' + a.val()).show();
		 });
		// conf
		jQuery('#visitor_subscription').change( function() {
			var a = jQuery(this);
			if ('0' == a.val()) jQuery( '.visitor_subscription_selected').hide();
			else jQuery( '.visitor_subscription_selected').show();
		 });
		jQuery('#visitor_mail').change( function() {
			var a = jQuery(this);
			if ('0' == a.val()) jQuery( '.visitor_mail_selected').hide();
			else jQuery( '.visitor_mail_selected').show();
		 });
		// control form
		jQuery('form#add').submit( function() {
			mp_forms.control();
		});
	}
}
jQuery(document).ready(function(){ mp_forms.init(); });