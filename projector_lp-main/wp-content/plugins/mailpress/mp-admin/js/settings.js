// settings

var mp_settings = {
	
	init : function() {
		jQuery('#settings-tabs').tabs({
			active : MP_AdminPage_var.the_tab,

			create : function( event, ui){
				jQuery("[href='#tab-panel-" + MP_AdminPage_var.the_tab_name + "']").click();
			},


			activate : function( event, ui){
				jQuery("[href='#tab-panel-" + ui.newPanel.attr('data-tab') + "']").click();
			}
		});

		//general
		jQuery('.subscription_mngt').change( function() {
			var a = jQuery(this); 
			switch (a.val())
			{
				case 'ajax' :
					jQuery('.mngt_id').hide();
				break;
				default :
					jQuery('.toggle').hide();
					jQuery('.' + a.val()).show();
					jQuery('.mngt_id').show();
				break;
			}
		}); 

		// maps
		jQuery('#general_map_provider').change( function() {
			var a = jQuery(this);
			jQuery('.map_providers').hide();
			jQuery('#map_provider_'+a.val()).show();
		});

		var map_fields = { b: {0 : 'b_key'}, g: {0 : 'g_key'}, h: {0 : 'h_id', 1: 'h_code'}, m: {0 : 'm_token'} };

		for (var m in map_fields) {

			for (var mm in map_fields[m]) {
				var z = (mm != 0) ? m+'_'+mm : m;
				mp_settings.maps_css(z, map_fields[m][mm]);
			}

		}


		// test
		jQuery('#test_theme').change( function() {
			var a = jQuery(this); 
			jQuery('.template').hide(); 
			jQuery( '#' + a.val()).show();
		 });

		// mp_cron
		jQuery( 'table.mp_cron' ).each(function(){
			var _this = this;
			jQuery('input', _this).click( function() {
				jQuery('.mp_cron_toggle', _this).fadeToggle();
			});
		});

	},

	maps_css : function(m, id) {

		var m_id  = '#'+id;
		var m_txt = '#'+m+'_prompt_text';

		if ( jQuery(m_id).val() == '' )
			jQuery(m_id).siblings(m_txt).css('visibility', '');
		jQuery(m_txt).click(function(){
			jQuery(this).css('visibility', 'hidden').siblings(m_id).focus();
		});
		jQuery(m_id).blur( function() {
			if (this.value == '') jQuery(this).siblings(m_txt).css('visibility', '');
		}).focus(function(){
			jQuery(this).siblings(m_txt).css('visibility', 'hidden');
		}).keydown(function(e){
			jQuery(this).siblings(m_txt).css('visibility', 'hidden');
			jQuery(this).unbind(e);
		});
	}
}
jQuery(document).ready(function(){ mp_settings.init(); });