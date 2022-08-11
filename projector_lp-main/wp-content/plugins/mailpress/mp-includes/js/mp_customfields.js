// custom fields

function mp_customfields()
{
	this.init = function() {

		jQuery('#the-list').wpList({	
			addAfter: function( xml, s ) {
				jQuery('table#list-table').show();
			}, 
			addBefore: function( s ) {
				s.data += '&' + MP_CustomFieldsL10n.object_id + '=' + jQuery( '#' + MP_CustomFieldsL10n.object_id ).val(); 
				return s;
			}
		});
	}

	this.init();
}