;(function (window, document, $, undefined) {
	'use strict';

	function onReady() {
		var $input;

		$input = $('[data-wp-color-picker]');

		$input.removeAttr('required max min maxlength pattern')
			.wpColorPicker();

		$('.wp-picker-holder').css({position: 'absolute', zIndex: 999});
		$('.wp-color-result').css({verticalAlign: 'middle'});
	}

	$(onReady);
}(window, window.document, jQuery));
