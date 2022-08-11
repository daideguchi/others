// fields

jQuery(document).ready( function() {

	jQuery('.field-type-help').each(function(i, div) {
		jQuery(div).appendTo('#' + div.getAttribute('data-id'));
	});

	jQuery('.field_type_help').tabs();
	jQuery('.field_type_settings').tabs({
		activate : function( event, ui){
			jQuery("[href='#" + ui.newPanel.attr('id').replace('settings', 'help') + "']").click();
		}
	});

	jQuery('.field_type').click( function() {
		var a = jQuery(this); 
		jQuery('.field_type_settings, .field_type_help').hide(); 
		jQuery('#field_type_' + a.val() + '_settings, #field_type_' + a.val() + '_help').show(); 
      } );

	jQuery('.controls').change( function() {
		var a = jQuery('.field_type:checked').val();
		jQuery('#field_type_controls_' + a).hide();
		jQuery('.controls:checked').each( function() {
			var a = jQuery('.field_type:checked').val();
			jQuery('#field_type_controls_' + a).show();
		} );
	} );

} );


//		jQuery('#dashboard-options-link-wrap').appendTo('#screen-meta-links');
