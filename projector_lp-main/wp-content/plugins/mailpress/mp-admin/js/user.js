// user

var mp_user = {

	init : function() {
		// close postboxes that should be closed
		jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');

		// postboxes
		postboxes.add_postbox_toggles(MP_AdminPageL10n.screen);

		// custom fields
		new mp_customfields();

		// mailinglist tabs
		jQuery('#user-tabs').tabs();

		// ip info
		new mp_map(meta_box_IP_info);
	}
}
jQuery(document).ready( function() { mp_user.init(); });