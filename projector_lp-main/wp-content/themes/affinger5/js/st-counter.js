;(function (window, document, $, undefined) {
	'use strict';

	var Counter = (function () {
		/**
		 * @private
		 *
		 * @param {string} id
		 * @param {string} type
		 *
		 * @returns {jQuery}
		 */
		function _get$target(id, type) {
			var $target;

			type = type || Counter.TARGET_TYPES.DATA_ID;

			switch (type) {
				case Counter.TARGET_TYPES.ID:
					$target = $('#' + id).eq(0);

					break;

				case Counter.TARGET_TYPES.DATA_ID:
				default:
					$target = $('[data-st-counter-id="' + id + '"]').eq(0);

					break;
			}

			return $target;
		}

		/**
		 * @private
		 *
		 * @param {function(): *} callback
		 * @param {number} [delay=500]
		 *
		 * @returns {function(): *}
		 */
		function _debounce(callback, delay) {
			var timeoutId;
			var result;

			delay = delay || 500;

			return function () {
				var args    = arguments;
				var context = this;

				if (timeoutId) {
					clearTimeout(timeoutId);
				}

				timeoutId = setTimeout(function () {
					timeoutId = null;

					result = callback.apply(context, args);
				}, delay);

				return result;
			};
		}

		/**
		 * @param {jQuery} $element
		 *
		 * @constructor
		 */
		function Counter($element) {
			var self = this;

			self._$element   = $element;
			self._targetType = null;
			self._targetId   = null;
			self._handlers   = {
				onChange: _debounce(function () {
					self.update();
				}, 100)
			};
		}

		/**
		 * @type {Object.<string, string>}
		 */
		Counter.TARGET_TYPES = {
			DATA_ID: 'data-id',
			ID     : 'id'
		};

		/**
		 * @param {string} text
		 *
		 * @returns {number}
		 */
		Counter.calculateCount = function (text) {
			var byteLength;
			var fullLength = 0;

			if (text.length === 0) {
				return 0;
			}

			byteLength = text.length;

			for (var index = 0; index < byteLength; index++) {
				var high            = text.charCodeAt(index);
				var low             = text.charCodeAt(index + 1);
				var isSurrogatePair = (0xD800 <= high && high <= 0xDBFF) && (0xDC00 <= low && low <= 0xDFFF);

				if (isSurrogatePair) {
					index += 1;
				} else if (high !== 0x000A && high !== 0x000D) {
					fullLength++;
				}
			}

			return fullLength;
		};

		/**
		 * @returns {jQuery}
		 */
		Counter.prototype.get$target = function () {
			return _get$target(this._targetId, this._targetType);
		};

		Counter.prototype.update = function () {
			var text          = this.get$target().val() + '';
			var count         = Counter.calculateCount(text);
			var countSelector = '[data-st-counter-count]';

			this._$element.find(countSelector)
				.addBack()
				.filter(countSelector)
				.text(count);
		};

		Counter.prototype.addEventListeners = function () {
			this.get$target().on('keyup input change', this._handlers.onChange);
		};

		Counter.prototype.removeEventListeners = function () {
			this.get$target().off('keyup input change', this._handlers.onChange);
		};

		Counter.prototype.initialize = function () {
			var targetType = this._$element.attr('data-st-counter-target-type');
			var targetId   = this._$element.attr('data-st-counter-target');
			var $target    = _get$target(targetId, targetType);

			if (!$target.length) {
				return;
			}

			this._targetType = targetType;
			this._targetId   = targetId;

			this.addEventListeners();
			this.update();
		};

		return Counter;
	}());

	function onReady() {
		var counters = [];

		$('[data-st-counter]').each(function (index, element) {
			var counter = new Counter($(element));

			counters.push(counter);

			counter.initialize();
		});
	}

	$(onReady);
}(window, window.document, jQuery));
