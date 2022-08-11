;(function (window, document, $, wp, ST_CUSTOMIZER_RESET, undefined) {
	'use strict';

	function onReady() {
		var $button = $('#st_customizer_reset');

		$button.on('click', function (event) {
			event.preventDefault();
			event.stopPropagation();

			var isConfirmed = confirm('カスタマイザーの設定を初期化します。');

			if (!isConfirmed) {
				return;
			}

			$button.prop('disabled', true);

			var data = {
				wp_customize: 'on',
				action: 'st_customizer_reset',
				nonce: ST_CUSTOMIZER_RESET.nonce
			};

			$.post(ajaxurl, data)
				.done(function () {
					wp.customize.state('saved').set(true);

					location.reload();
				})
				.fail(function () {
					$button.prop('disabled', false);
				});
		});
	}

	wp.customize.bind('ready', onReady);
}(window, window.document, jQuery, wp, ST_CUSTOMIZER_RESET));
