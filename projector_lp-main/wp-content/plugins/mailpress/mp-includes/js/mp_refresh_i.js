var mp_refresh = {
	reg     	: new RegExp("(%i%)", "g"),
	message 	: '',

	div : '<div id="mailpress-refresh-counter-wrap"></div>',
	button : '<button type="button" id="mailpress-refresh-link" class="button show-settings mp_refresh">%i%</button>',
	span : '<span id="mp_refresh_chrono">%i%</span>',

	slide		: 2,
	slideTime	: 2,
	lastScroll 	: 10000000,
	newScroll 	: 0,

	init  : function() {

	// adding form in Screen Options 
		adminMpRefreshL10n.option = adminMpRefreshL10n.option.replace(/\&gt;/g,'>').replace(/\&lt;/g,'<');
		if (jQuery('div#tab-panel-autorefresh')) jQuery('div#tab-panel-autorefresh').append(adminMpRefreshL10n.option);
		else 					 jQuery('#screen-options-wrap').append(adminMpRefreshL10n.option);

	// adding button
		jQuery('#screen-meta-links').append(mp_refresh.div);
		mp_refresh.message = mp_refresh.button.replace(mp_refresh.reg, adminMpRefreshL10n.message.replace(mp_refresh.reg, mp_refresh.span ));
		//mp_refresh.message = mp_refresh.button.replace(mp_refresh.reg, adminMpRefreshL10n.message.replace(mp_refresh.reg, "%i%"));

	// checked checkbox
		if (jQuery('#MP_Refresh').is(':checked')) mp_refresh.start();
	// onchange checkbox
		jQuery('#MP_Refresh').change( function() { (jQuery('#MP_Refresh').is(':checked')) ? mp_refresh.start() : mp_refresh.stop(); } );
	// onclick message
		jQuery('div#mailpress-refresh-counter-wrap').click( function() { mp_refresh.stop(); } );

	// onload iframe
		jQuery('iframe#' + adminMpRefreshL10n.iframe).load(function() { mp_refresh.scrolldown(); } );
	// onresize window
		mp_refresh.resize(15);
		jQuery(window).resize( function() { mp_refresh.resize(15); } );
	},

	get_time : function() {
		var time = jQuery('input#MP_Refresh_every').val();
		time     = (isNaN(time)) ? adminMpRefreshL10n.every : time;
		time 	 = (adminMpRefreshL10n.every > time) ? adminMpRefreshL10n.every : time;
		jQuery('input#MP_Refresh_every').val(time);
		return time;
	},

	start : function() {
		var message = mp_refresh.message.replace(mp_refresh.reg, mp_refresh.get_time());
		mp_refresh.display(message);

		jQuery.schedule({	id	: 'mp_refresh.update',
					time	: 1000, 
					func	: mp_refresh.update,
					repeat  : true, 
					protect : true
		});
	},

	stop : function() {
		jQuery.cancel( 'mp_refresh.update' );
		jQuery('#MP_Refresh').attr('checked',false);
		mp_refresh.display('');
	},

	update : function() {
		var time = jQuery('span#mp_refresh_chrono').html();
		if (isNaN(time)) return;
		time--;
		var message = mp_refresh.message.replace(mp_refresh.reg, time);
		mp_refresh.display(message);

		if (time == (mp_refresh.get_time() -1))
		{
			//# ajax
			jQuery.ajax({
				data: {z:0},
				beforeSend: null,
				type: "POST",
				url: adminMpRefreshL10n.url,
				success: null
			});
		}
		if (time > 0) return;
		mp_refresh.refresh();
	},

	display : function(message) {
		jQuery('div#mailpress-refresh-counter-wrap').html(message);
	},

	refresh : function() {
		jQuery('iframe#mp').attr('src', adminMpRefreshL10n.src);
		jQuery('span#mp_refresh_chrono').html(mp_refresh.get_time());
	},

	scrolldown : function() {
		var h_viewport = jQuery('iframe#' + adminMpRefreshL10n.iframe).innerHeight();
		var h_iframe   = window[adminMpRefreshL10n.iframe].document.body.scrollHeight;
		mp_refresh.newScroll = h_iframe - h_viewport + 100;
		window[adminMpRefreshL10n.iframe].scrollTo(0, (mp_refresh.lastScroll));
		jQuery.schedule({ id	: 'mp_refresh.slideUp',
					time	: mp_refresh.slideTime,
					func 	: mp_refresh.slideUp,
					repeat: true, 
					protect: true
		});
	},

	slideUp : function() {
		mp_refresh.lastScroll = mp_refresh.lastScroll + mp_refresh.slide;
		window[adminMpRefreshL10n.iframe].scrollTo(0, (mp_refresh.lastScroll));
		if (mp_refresh.lastScroll >= mp_refresh.newScroll)
		{
			jQuery.cancel( 'mp_refresh.slideUp' );
			mp_refresh.lastScroll = mp_refresh.newScroll;
		}
	},

	resize : function(h) {
		var i = document.getElementById(adminMpRefreshL10n.iframe);
		i.style.height = (document.documentElement.clientHeight - i.offsetTop) - h +"px";
		mp_refresh.scrolldown();
	}
};
jQuery(document).ready( function(){ mp_refresh.init(); } );