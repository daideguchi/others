// tracking

var mp_tracking = {

	init : function() {
		// close postboxes that should be closed
		jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');

		// postboxes
		postboxes.add_postbox_toggles(MP_AdminPageL10n.screen);

		// map
		new mp_map(t006);
	}
}
jQuery(document).ready( function() { mp_tracking.init(); });