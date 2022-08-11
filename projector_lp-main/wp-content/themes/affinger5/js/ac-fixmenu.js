(function (window, document, $, undefined) {
	'use strict';

	var $accordion = $("#s-navi dl.acordion");
	var $accordionTree = $accordion.find('.acordion_tree');
	var stPosition = 0;

	$(window).scroll(function () {
        var acHeight = $accordion.height();
		var currentPosition = $(this).scrollTop();

		if (currentPosition > stPosition) {
			if ($(window).scrollTop() >= 200) {
				$accordion.css('top', (acHeight * -1) + 'px');
			}
		} else {
			$accordion.css('top', 0);
		}

		stPosition = currentPosition;
	});
}(window, window.document, jQuery));
