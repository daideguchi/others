;(function (window, document, $, undefined) {
	'use strict';

	$(function () {
		var $tabs     = $('[data-st-tabs]');
		var $navItems = $tabs.find('[data-st-tabs-nav-item]');

		$tabs.tabs();

		$('[data-st-tabs-nav-item] a').on('click', function () {
			var $form = $('[data-st-tabs-form]');
			var hash  = $(this).attr('href');

			if (!$form.length) {
				return;
			}

			$form.attr('action', hash);
		});

		$('[data-st-tabs-contents] a[href^="#"]').on('click', function (event) {
			var hash = $(this).attr('href');
			var $target;

			if (!$(hash).length) {
				return;
			}

			$target = $navItems.filter(':has(a[href="' + hash + '"])');

			if (!$target.length) {
				return;
			}

			event.preventDefault();
			event.stopPropagation();

			$tabs.tabs('option', 'active', $navItems.index($target));
		});
	});
}(window, window.document, jQuery));
