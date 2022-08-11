// settings_newsletter


var mp_settings_newsletter = {



	newsletters : jQuery('.newsletter'),

	select : function() {

		var html = '';
		var select = jQuery("#comment_newsletter_subscription_default");
		var valeur = select.val();

		for (var i in mp_settings_newsletter.newsletters)

		{

			var _this = mp_settings_newsletter.newsletters[i];
			if (_this.checked)
			{
				curr = _this.getAttribute('newsletter');
				desc = _this.getAttribute('newsletter_description');
				attr = ( valeur == curr ) ? ' selected="selected"' : '';



				html+= '<option value="' + curr + '"' + attr + '>' + desc + '</option>';

			}
		}

		var original_color = select.css('border-left-color');
		select.html(html);
	},

	init : function() {
		mp_settings_newsletter.newsletters.change(function(){
			if (!this.checked) jQuery('#default_'+this.id).removeAttr('checked');
			jQuery('#span_default_'+this.id).toggle();

			mp_settings_newsletter.select();

		});

	}

};




jQuery(document).ready( function() { mp_settings_newsletter.init(); });