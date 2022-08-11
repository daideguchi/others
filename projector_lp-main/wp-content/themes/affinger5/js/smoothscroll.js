;(function (window, document, $, undefined) {
	'use strict';

	function calculateAdjustment() {
		var adjustment = 16;
		var $adminBar  = $('#wpadminbar');
		var $headerBar = $('#s-navi dl.acordion');
		var $html      = $('html');

		if ($adminBar.length && $adminBar.css('position') === 'fixed') {
			adjustment += $adminBar.outerHeight();
		}

		if ($html.hasClass('header-bar-fixable')) {
			adjustment += $headerBar.height();
		}

		return adjustment;
	}

	function initialize() {
		$('a[href^="#"]').click(function (event) {
			var $a      = $(this);
			var href    = $a.attr('href');
			var $target = $(href === '#' || href === '' ? 'html' : href);
			var speed   = 400;
			var position;

			if (!$target.length) {
				return;
			}

			// 目次プラグイン
			if (typeof ST_TOC !== 'undefined') {
				var toggleAttr = 'data-' + ST_TOC.VARS.plugin_meta.slug + '-toggle';
				var attr       = $a.attr(toggleAttr);

				// 表示/非表示
				if (typeof attr !== 'undefined' && attr !== false) {
					return;
				}

				// 目次
				if (href === ST_TOC.VARS.plugin_meta.slug + '-h') {
					return;
				}
			}

			position = $target.offset().top - calculateAdjustment();

			event.preventDefault();
			event.stopPropagation();

			$('html, body').animate({scrollTop: position}, speed, 'swing');
		});
	}

	$(function () {
		initialize();
	});
}(window, window.document, jQuery));
