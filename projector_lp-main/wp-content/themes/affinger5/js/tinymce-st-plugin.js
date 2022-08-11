;(function (window, document, $, tinymce, ST, undefined) {
	'use strict';

	var Plugin;

	function isSelected(editor) {
		var range = editor.selection.getRng();

		return Math.abs(range.endOffset - range.startOffset) > 0;
	}

	function _wrapAsText(editor, before, after) {
	    return function () {
			var selected = isSelected(editor);
			var content;
			var newConotent;
			var range;
			var afterLength;
			var position;
			var node;

			content     = selected ? editor.selection.getContent({format: 'text'}) : '';
			newConotent = before + content + after;

			editor.execCommand('mceInsertContent', false, newConotent);

			if (selected) {
				return;
			}

			range       = editor.selection.getRng();
			afterLength = after.length - (after.match(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g) || []).length;
			position    = range.endOffset - afterLength;
			node        = range.startContainer;

			range.setStart(node, position);
			range.setEnd(node, position);
			editor.selection.setRng(range);
		};
	}

	function _wrapAsHtml(editor, before, after) {
		return function () {
			var content = '';
			var newContent;

			if (isSelected(editor)) {
				var node = editor.selection.getNode();

				content = editor.selection.getContent();
				content = (content === node.innerHTML) ? node.outerHTML : content;
			}

			newContent = before + content + after;

			editor.execCommand('mceInsertContent', false, newContent);
		};
	}

	function _setAsText(editor, content) {
		return function () {
			editor.execCommand('mceInsertContent', false, content);
		};
	}

	function _setAsHtml(editor, content) {
		return function () {
			editor.selection.setContent(content);
		};
	}

	function createCallbackFactory(editor, func) {
		return function () {
			var args = Array.prototype.slice.call(arguments);

			args.unshift(editor);

			return func.apply(null, args);
		};
	}

	function getListItemDefinition(editor) {
		var setAsHtml  = createCallbackFactory(editor, _setAsHtml);
		var setAsText  = createCallbackFactory(editor, _setAsText);
		var wrapAsHtml = createCallbackFactory(editor, _wrapAsHtml);
		var wrapAsText = createCallbackFactory(editor, _wrapAsText);

		return {
			'st_button_text_parts'     : {
				text    : 'テキストパーツ',
				icon    : 'fa-font',
				menu: {
				'st_button_clipmemo'     : {
					text    : 'クリップメモ',
					icon    : 'fa-paperclip',
					menu: {
						'st_button_clipmemo_default' : {
							text    : 'メモ',
							icon    : false,
							tooltip : 'メモ',
							callback: wrapAsText('[st-cmemo fontawesome="fa-file-text-o" iconcolor="#919191" bgcolor="#fafafa" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_external_link' : {
							text    : '外部リンク',
							icon    : false,
							tooltip : '外部リンク',
							callback: wrapAsText('[st-cmemo fontawesome="fa-external-link" iconcolor="#BDBDBD" bgcolor="#fafafa" color="#757575" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_bookmark' : {
							text    : 'ブックマーク',
							icon    : false,
							tooltip : 'ブックマーク',
							callback: wrapAsText('[st-cmemo fontawesome="fa-bookmark" iconcolor="#BDBDBD" bgcolor="#fafafa" color="#757575" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_info' : {
							text    : 'おしらせ',
							icon    : false,
							tooltip : 'おしらせ',
							callback: wrapAsText('[st-cmemo fontawesome="fa-bullhorn" iconcolor="#FFEB3B" bgcolor="#FFFDE7" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_question' : {
							text    : 'はてな',
							icon    : false,
							tooltip : 'はてな',
							callback: wrapAsText('[st-cmemo fontawesome="fa-question-circle" iconcolor="#4FC3F7" bgcolor="#E1F5FE" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_comment' : {
							text    : 'コメント',
							icon    : false,
							tooltip : 'コメント',
							callback: wrapAsText('[st-cmemo fontawesome="fa-comments" iconcolor="#F48FB1" bgcolor="#FCE4EC" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_code' : {
							text    : 'コード',
							icon    : false,
							tooltip : 'コード',
							callback: wrapAsText('[st-cmemo fontawesome="fa-code" iconcolor="#919191" bgcolor="#fafafa" color="#000000" iconsize="150"]', '[/st-cmemo]')
						},'st_button_clipmemo_point' : {
							text    : 'ポイント',
							icon    : false,
							tooltip : 'ポイント',
							callback: wrapAsText('[st-cmemo fontawesome="fa-lightbulb-o" iconcolor="#FFA726" bgcolor="#FFF3E0" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_user' : {
							text    : 'ユーザー',
							icon    : false,
							tooltip : 'ユーザー',
							callback: wrapAsText('[st-cmemo fontawesome="fa-user" iconcolor="#4FC3F7" bgcolor="#E1F5FE" color="#000000" iconsize="150"]', '[/st-cmemo]')
						},'st_button_clipmemo_bigginer' : {
							text    : '初心者',
							icon    : false,
							tooltip : '初心者',
							callback: wrapAsText('[st-cmemo fontawesome="st-svg-bigginer_l" iconcolor="#9CCC65" bgcolor="#F1F8E9" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_exclamation' : {
							text    : '注意文',
							icon    : false,
							tooltip : '注意文',
							callback: wrapAsText('[st-cmemo fontawesome="fa-exclamation-circle" iconcolor="#ef5350" bgcolor="#ffebee" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_exclamation_gray' : {
							text    : '注意文（グレー）',
							icon    : false,
							tooltip : '注意文（グレー）',
							callback: wrapAsText('[st-cmemo fontawesome="fa-exclamation-circle" iconcolor="#919191" bgcolor="#fafafa" color="#000000" iconsize=""]', '[/st-cmemo]')
						},
						'st_button_clipmemo_guide' : {
							text    : '[?] ガイド※使用不可',
							icon    : false,
							tooltip : '[?] ガイド※使用不可',
							callback: wrapAsText('[st-cmemo fontawesome="Webアイコン" iconcolor="アイコンの色" bgcolor="背景色" color="文字色" iconsize="アイコンサイズ（%）"]ここにテキスト', '[/st-cmemo]')
						},
					},
				},
				'st_button_minihukidashi': {
					text    : 'ミニふきだし',
					icon    : 'fa-commenting',
					menu: {
							'st_button_minihukidashi_default' : {
								text    : '基本',
								icon    : false,
								tooltip : '基本',
								callback: wrapAsText('[st-minihukidashi fontawesome="" fontsize="" fontweight="" bgcolor="#f3f3f3" color="#000000" margin="0 0 20px 0"]', '[/st-minihukidashi]')
							},
							'st_button_minihukidashi_orange' : {
								text    : 'オレンジ',
								icon    : false,
								tooltip : 'オレンジ',
								callback: wrapAsText('[st-minihukidashi fontawesome="" fontsize="" fontweight="" bgcolor="#FFB74D" color="#fff" margin="0 0 20px 0"]', '[/st-minihukidashi]')
							},
							'st_button_minihukidashi_pink' : {
								text    : 'ピンク',
								icon    : false,
								tooltip : 'ピンク',
								callback: wrapAsText('[st-minihukidashi fontawesome="" fontsize="" fontweight="" bgcolor="#F48FB1" color="#fff" margin="0 0 20px 0"]', '[/st-minihukidashi]')
							},
							'st_button_minihukidashi_blue' : {
								text    : 'ブルー',
								icon    : false,
								tooltip : 'ブルー',
								callback: wrapAsText('[st-minihukidashi fontawesome="" fontsize="" fontweight="" bgcolor="#4FC3F7" color="#fff" margin="0 0 20px 0"]', '[/st-minihukidashi]')
							},
							'st_button_minihukidashi_green' : {
								text    : 'グリーン',
								icon    : false,
								tooltip : 'グリーン',
								callback: wrapAsText('[st-minihukidashi fontawesome="" fontsize="" fontweight="" bgcolor="#7CB342" color="#fff" margin="0 0 20px 0"]', '[/st-minihukidashi]')
							},
							'st_button_minihukidashi_red' : {
								text    : 'レッド',
								icon    : false,
								tooltip : 'レッド',
								callback: wrapAsText('[st-minihukidashi fontawesome="" fontsize="" fontweight="" bgcolor="#f44336" color="#fff" margin="0 0 20px 0"]', '[/st-minihukidashi]')
							},
							'st_button_minihukidashi_guide' : {
								text    : '[?] ガイド※使用不可',
								icon    : false,
								tooltip : '[?] ガイド※使用不可',
								callback: wrapAsText('[st-minihukidashi fontawesome="Webアイコン" fontsize="文字サイズ（%）" fontweight="文字の太さ（bold）" bgcolor="背景色" color="文字色" margin="余白（上 右 下 左）"]ここにテキスト', '[/st-minihukidashi]')
							},
						},
					},
					'st_button_clipmemo_composite'     : {
						text    : '複合',
						icon    : 'dashicons-art',
						menu: {
							'st_button_clipmemo_orangememo' : {
								text    : '自由なメモ',
								icon    : false,
								tooltip : '自由なメモ',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#FFC107" color="#fff" margin="0 0 0 -6px"]自由なメモ[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-file-text-o" iconcolor="#FFC107" bgcolor="#FFFDE7" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
							'st_button_clipmemo_kokopoint' : {
								text    : 'ココがポイント',
								icon    : false,
								tooltip : 'ココがポイント',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#3F51B5" color="#fff" margin="0 0 0 -6px"]ココがポイント[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-hand-o-right" iconcolor="#3F51B5" bgcolor="#E8EAF6" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
							'st_button_clipmemo_kokoosusume' : {
								text    : 'ココがおすすめ',
								icon    : false,
								tooltip : 'ココがおすすめ',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#3F51B5" color="#fff" margin="0 0 0 -6px"]ココがおすすめ[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-thumbs-o-up" iconcolor="#3F51B5" bgcolor="#E8EAF6" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
							'st_button_clipmemo_kokodame' : {
								text    : 'ココがダメ',
								icon    : false,
								tooltip : 'ココがダメ',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#3F51B5" color="#fff" margin="0 0 0 -6px"]ココがダメ[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-thumbs-o-down" iconcolor="#3F51B5" bgcolor="#E8EAF6" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
							'st_button_clipmemo_kokochumoku' : {
								text    : 'ココに注意',
								icon    : false,
								tooltip : 'ココに注意',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#ef5350" color="#fff" margin="0 0 0 -6px"]ココに注意[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-exclamation-circle" iconcolor="#ef5350" bgcolor="#ffebee" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
							'st_button_clipmemo_saranikuwasiku' : {
								text    : 'もっと詳しく',
								icon    : false,
								tooltip : 'もっと詳しく',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#66BB6A" color="#fff" margin="0 0 0 -8px"]さらに詳しく[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-search" iconcolor="#66BB6A" bgcolor="#E8F5E9" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
							'st_button_clipmemo_comment_woman' : {
								text    : '女性コメント',
								icon    : false,
								tooltip : '女性コメント',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#F06292" color="#fff" margin="0 0 0 -9px"]◯才女性[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-user" iconcolor="#F06292" bgcolor="#FCE4EC" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
							'st_button_clipmemo_comment_man' : {
								text    : '男性コメント',
								icon    : false,
								tooltip : '男性コメント',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom:-5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#42A5F5" color="#fff" margin="0 0 0 -9px"]◯才男性[/st-minihukidashi]</div>[st-cmemo fontawesome="fa-user" iconcolor="#42A5F5" bgcolor="#E3F2FD" color="#000000" iconsize="200"]', '[/st-cmemo]')
							},
						},
					},
					'st_button_mybox_composite'     : {
						text    : '複合（アイコンなし）',
						icon    : 'dashicons-art',
						menu: {
							'st_button_mybox_orangememo' : {
								text    : '自由なメモ',
								icon    : false,
								tooltip : '自由なメモ',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-file-text-o" fontsize="90" fontweight="bold" bgcolor="#FFC107" color="#fff" margin="0 0 0 0"]自由なメモ[/st-minihukidashi]</div>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#FFFDE7" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]', '[/st-mybox]')
							},
							'st_button_mybox_kokopoint' : {
								text    : 'ココがポイント',
								icon    : false,
								tooltip : 'ココがポイント',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-hand-o-right" fontsize="90" fontweight="bold" bgcolor="#3F51B5" color="#fff" margin="0 0 0 0"]ココがポイント[/st-minihukidashi]</div>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8EAF6" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]', '[/st-mybox]')
							},
							'st_button_mybox_kokoosusume' : {
								text    : 'ココがおすすめ',
								icon    : false,
								tooltip : 'ココがおすすめ',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-circle-o" fontsize="90" fontweight="bold" bgcolor="#3F51B5" color="#fff" margin="0 0 0 0"]ココがおすすめ[/st-minihukidashi]</div>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8EAF6" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]', '[/st-mybox]')
							},
							'st_button_mybox_kokodame' : {
								text    : 'ココがダメ',
								icon    : false,
								tooltip : 'ココがダメ',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-times" fontsize="90" fontweight="bold" bgcolor="#3F51B5" color="#fff" margin="0 0 0 0"]ココがダメ[/st-minihukidashi]</div>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8EAF6" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]', '[/st-mybox]')
							},
							'st_button_mybox_kokochumoku' : {
								text    : 'ココに注意',
								icon    : false,
								tooltip : 'ココに注意',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-exclamation-circle" fontsize="90" fontweight="bold" bgcolor="#ef5350" color="#fff" margin="0 0 0 0"]ココに注意[/st-minihukidashi]</div>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#ffebee" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]', '[/st-mybox]')
							},
							'st_button__mybox_saranikuwasiku' : {
								text    : 'もっと詳しく',
								icon    : false,
								tooltip : 'もっと詳しく',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-search" fontsize="90" fontweight="bold" bgcolor="#66BB6A" color="#fff" margin="0 0 0 0"]もっと詳しく[/st-minihukidashi]</div>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8F5E9" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]', '[/st-mybox]')
							},
							'st_button_mybox_question' : {
								text    : 'はてなマーク',
								icon    : false,
								tooltip : 'はてなマーク',
								callback: wrapAsHtml('<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-question-circle" fontsize="90" fontweight="bold" bgcolor="#03A9F4" color="#fff" margin="0 0 0 0"]つまづきポイント[/st-minihukidashi]</div>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E1F5FE" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]', '[/st-mybox]')
							},
						},
					},
					'st_button_marumozi': {
						text    : 'まるもじ（小）',
						icon    : 'fa-circle-o',
						menu: {
							'st_button_marumozi_default': {
								text    : '基本',
								icon    : false,
								callback: wrapAsText('[st-marumozi fontawesome="" bgcolor="#f3f3f3" color="#000000" radius="30" margin="0 10px 0 0"]', '[/st-marumozi]')
							},
							'st_button_marumozi_orange': {
								text    : 'オレンジ',
								icon    : false,
								callback: wrapAsText('[st-marumozi fontawesome="" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 0 0"]', '[/st-marumozi]')
							},
							'st_button_marumozi_pink': {
								text    : 'ピンク',
								icon    : false,
								callback: wrapAsText('[st-marumozi fontawesome="" bgcolor="#F48FB1" color="#fff" radius="30" margin="0 10px 0 0"]', '[/st-marumozi]')
							},
							'st_button_marumozi_blue': {
								text    : 'ブルー',
								icon    : false,
								callback: wrapAsText('[st-marumozi fontawesome="" bgcolor="#4FC3F7" color="#fff" radius="30" margin="0 10px 0 0"]', '[/st-marumozi]')
							},
							'st_button_marumozi_exclamation': {
								text    : 'うすい注意',
								icon    : false,
								callback: wrapAsText('[st-marumozi fontawesome="fa-exclamation-circle" bgcolor="#ffebee" color="#ef5350" radius="30" margin="0 10px 0 0"]', '[/st-marumozi]')
							},
							'st_button_marumozi_exclamation_b': {
								text    : '注意',
								icon    : false,
								callback: wrapAsText('[st-marumozi fontawesome="fa-exclamation-circle" bgcolor="#ef5350" color="#fff" radius="30" margin="0 10px 0 0"]', '[/st-marumozi]')
							},
							'st_button_marumozi_guide': {
								text    : '[?] ガイド※使用不可',
								icon    : false,
								callback: wrapAsText('[st-marumozi fontawesome="Webアイコン" bgcolor="背景色" color="文字色" radius="角丸（px）" margin="余白（上 右 下 左）"]ここにテキスト', '[/st-marumozi]')
							},
						},
					},
					'st_button_marumozi_big': {
						text    : 'まるもじ（大）',
						icon    : 'fa-circle',
						menu: {
							'st_button_marumozi_big_default': {
								text    : '基本',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="" bgcolor="#f3f3f3" color="#000000" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_orange': {
								text    : 'オレンジ',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_pink': {
								text    : 'ピンク',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="" bgcolor="#F48FB1" color="#fff" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_blue': {
								text    : 'ブルー',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="" bgcolor="#4FC3F7" color="#fff" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_question': {
								text    : 'はてな',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="fa-question-circle" bgcolor="#4FC3F7" color="#fff" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_check': {
								text    : 'チェック',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="fa-check-circle" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_exclamation': {
								text    : 'うすい注意',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="fa-exclamation-circle" bgcolor="#ffebee" color="#ef5350" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_exclamation_b': {
								text    : '注意',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="fa-exclamation-circle" bgcolor="#ef5350" color="#fff" radius="30" margin="0 10px 10px 0"]', '[/st-marumozi-big]')
							},
							'st_button_marumozi_big_guide': {
								text    : '[?] ガイド※使用不可',
								icon    : false,
								callback: wrapAsText('[st-marumozi-big fontawesome="Webアイコン" bgcolor="背景色" color="文字色" radius="角丸（px）" margin="余白（上 右 下 左）"]ここにテキスト', '[/st-marumozi-big]')
							},
						},
					},
					'st_design_font'   : {
						text   : 'カスタムフォント',
						icon   : 'fa-percent',
						callback: wrapAsText('[st-designfont myclass="" fontawesome="" fontsize="150" fontweight="bold" color="#000" textshadow="" webfont="" margin="0 0 20px 0"]', '[/st-designfont]')
					},
					'st_design_font_sirokage'   : {
						text   : 'カスタムフォント（白影）',
						icon   : 'fa-percent',
						callback: wrapAsText('[st-designfont myclass="" fontawesome="" fontsize="150" fontweight="bold" color="#fff" textshadow="#424242" webfont="on" margin="0 0 20px 0"]', '[/st-designfont]')
					},
					'st_button_step'   : {
						text    : 'ステップ',
						icon   : 'fa-list-ol',
						callback: wrapAsText('[st-step step_no="1"]', '[/st-step]')
					},
					'st_button_point'   : {
						text    : 'ポイント',
						icon   : 'fa-product-hunt',
						callback: wrapAsText('[st-point fontsize="" fontweight="bold" bordercolor=""]', '[/st-point]')
					},
					'st_button_label_c': {
						text    : 'ラベル',
						icon   : 'fa-pencil-square',
						callback: wrapAsHtml('[st-label label="おすすめ" bgcolor="#FBC02D" color="#FFFFFF"]<p>', '</p>[/st-label]')
					},
					'st_button_marquee': {
						text    : '流れる文字（marquee風）',
						icon   : 'fa-newspaper-o',
						callback: wrapAsHtml('<div class="st-marquee"><p>', '</p></div>')
					},
				},
			},
			'st_button_boxdesign'        : {
				text    : 'ボックスデザイン',
				icon    : 'fa-inbox',
				menu: {
					'st_button_flex': {
						text    : 'バナー風ボックス',
						icon    : false,
						menu: {
								'st_button_flex_default' : {
									text    : '基本',
									icon    : false,
									tooltip : '基本',
									callback: wrapAsHtml('[st-flexbox url="" rel="nofollow" target="" fontawesome="" title="タイトル" width="" height="" color="#fff" fontsize="200" radius="0" shadow="#424242" bordercolor="#ccc" borderwidth="1" bgcolor="#ccc" backgroud_image="" blur="on" left="" margin_bottom="0"]<p>', '</p>[/st-flexbox]')
								},
								'st_button_flex_no_bgcolor' : {
									text    : '背景なし（高さ400px）',
									icon    : false,
									tooltip : '背景なし（高さ400px）',
									callback: wrapAsHtml('[st-flexbox url="" rel="nofollow" target="" fontawesome="" title="タイトル" width="" height="400" color="#fff" fontsize="200" radius="0" shadow="#424242" bordercolor="" borderwidth="0" bgcolor="" backgroud_image="" blur="" left="" margin_bottom="0"]<p>', '</p>[/st-flexbox]')
								},
								'st_button_flex_left' : {
									text    : '左寄せ',
									icon    : false,
									tooltip : '左寄せ',
									callback: wrapAsHtml('[st-flexbox url="" rel="nofollow" target="" fontawesome="" title="タイトル" width="" height="" color="#fff" fontsize="120" radius="0" shadow="#424242" bordercolor="#ccc" borderwidth="1" bgcolor="#29B6F6" backgroud_image="" blur="" left="on" margin_bottom="0"]<p>', '</p>[/st-flexbox]')
								},
								'st_button_flex_guide' : {
									text    : '[?] ガイド※使用不可',
									icon    : false,
									tooltip : '[?] ガイド※使用不可',
									callback: wrapAsHtml('[st-flexbox url="リンク先URL" rel="nofollow" target="リンクを新しく開く（target）" fontawesome="Webアイコン" title="タイトル" width="幅（%）" height="高さ（px）" color="文字色" fontsize="文字サイズ（%）" radius="角丸（px）" shadow="タイトルの影色" bordercolor="枠線カラー" borderwidth="枠線の太さ（px）" bgcolor="背景色" backgroud_image="背景画像のURL" blur="背景画像のぼかし" left="左寄せ（on）" margin_bottom="下の余白（px）"]<p>ここに自由なテキスト', '</p>[/st-flexbox]')
								},
							},
					},
					'st_button_mybox'        : {
						text    : 'マイボックス',
						icon    : false,
						menu: {
							'st_button_mybox_default' : {
								text    : '基本',
								icon    : false,
								tooltip : '基本',
								callback: wrapAsHtml('[st-mybox title="ポイント" fontawesome="fa-check-circle" color="#757575" bordercolor="#BDBDBD" bgcolor="#ffffff" borderwidth="2" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_square' : {
								text    : 'しかく（枠のみ）',
								icon    : false,
								tooltip : 'しかく（枠のみ）',
								callback: wrapAsHtml('[st-mybox title="" fontawesome="" color="#757575" bordercolor="#ccc" bgcolor="#ffffff" borderwidth="2" borderradius="2" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_circle' : {
								text    : 'まるみ',
								icon    : false,
								tooltip : 'まるみ',
								callback: wrapAsHtml('[st-mybox title="" fontawesome="" color="#757575" bordercolor="#BDBDBD" bgcolor="#f3f3f3" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_sankou' : {
								text    : '参考',
								icon    : false,
								tooltip : '参考',
								callback: wrapAsHtml('[st-mybox title="参考" fontawesome="fa-file-text-o" color="#757575" bordercolor="" bgcolor="#fafafa" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_kanren' : {
								text    : '関連',
								icon    : false,
								tooltip : '関連',
								callback: wrapAsHtml('[st-mybox title="関連" fontawesome="fa-file-text-o" color="#757575" bordercolor="" bgcolor="#fafafa" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_memo' : {
								text    : 'メモ',
								icon    : false,
								tooltip : 'メモ',
								callback: wrapAsHtml('[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#757575" bordercolor="" bgcolor="#fafafa" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_point' : {
								text    : 'ポイント',
								icon    : false,
								tooltip : 'ポイント',
								callback: wrapAsHtml('[st-mybox title="ポイント" fontawesome="fa-check-circle" color="#FFD54F" bordercolor="#FFD54F" bgcolor="#FFFDE7" borderwidth="2" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_exclamation_point' : {
								text    : '注意ポイント',
								icon    : false,
								tooltip : '注意ポイント',
								callback: wrapAsHtml('[st-mybox title="注意ポイント" fontawesome="fa-exclamation-circle" color="#ef5350" bordercolor="#ef9a9a" bgcolor="#ffebee" borderwidth="2" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_exclamation_question' : {
								text    : 'はてな',
								icon    : false,
								tooltip : 'はてな',
								callback: wrapAsHtml('[st-mybox title="はてな" fontawesome="fa-question-circle" color="#03A9F4" bordercolor="#B3E5FC" bgcolor="#E1F5FE" borderwidth="2" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
							},
							'st_button_mybox_guide' : {
								text    : '[?] ガイド※使用不可',
								icon    : false,
								tooltip : '[?] ガイド※使用不可',
								callback: wrapAsHtml('[st-mybox title="見出し" fontawesome="Webアイコン" color="見出し色" bordercolor="枠線カラー" bgcolor="背景色" borderwidth="枠線の太さ（px）" borderradius="角丸（px）" titleweight="見出しの太さ（bold）" fontsize="見出しのフォントサイズ" myclass="オリジナルクラス" margin="マージン"]<p>ここにテキスト', '</p>[/st-mybox]')
							},
						},
					},
					'st_button_mybox_intitle'     : {
						text    : 'マイボックス（+CSSクラス）',
						icon    : false,
						menu: {
							'st_button_mybox_intitle_default' : {
								text    : 'メモ',
								icon    : false,
								tooltip : 'メモ',
								callback: wrapAsText('[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#727272" bordercolor="#ff0000" bgcolor="#FAFAFA" borderwidth="0" borderradius="5" titleweight="bold" title_bordercolor="" fontsize="" myclass="st-mybox-class st-title-under" margin="25px 0 25px 0"]', '[/st-mybox]')
							},
							'st_button_mybox_intitle_memo_titleborder' : {
								text 　 : 'メモ（下線のみ）',
								icon    : false,
								tooltip : 'メモ（下線のみ）',
								callback: wrapAsText('[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#727272" bordercolor="#ff0000" bgcolor="#FAFAFA" borderwidth="0" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under" margin="25px 0 25px 0"]', '[/st-mybox]')
							},
							'st_button_mybox_intitle_memo_border' : {
								text 　 : 'メモ（枠のみ）',
								icon    : false,
								tooltip : 'メモ（枠のみ）',
								callback: wrapAsText('[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#727272" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="" fontsize="" myclass="st-mybox-class st-title-under" margin="25px 0 25px 0"]', '[/st-mybox]')
							},
							'st_button_mybox_intitle_memo_titleborder_border' : {
								text 　 : 'メモ（枠・下線あり）',
								icon    : false,
								tooltip : 'メモ（枠・下線あり）',
								callback: wrapAsText('[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#727272" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under" margin="25px 0 25px 0"]', '[/st-mybox]')
							},
							'st_button_mybox_intitle_attention_titleborder' : {
								text 　 : '注意（下線のみ）',
								icon    : false,
								tooltip : '注意（下線のみ）',
								callback: wrapAsText('[st-mybox title="ここに注意" fontawesome="fa-exclamation-circle" color="#ef5350" bordercolor="#f3f3f3" bgcolor="#ffebee" borderwidth="" borderradius="5" titleweight="bold" title_bordercolor="#ef5350" fontsize="" myclass="st-mybox-class st-title-under" margin="25px 0 25px 0"]', '[/st-mybox]')
							},
							'st_button_mybox_intitle_item' : {
								text 　 : '必要なモノ',
								icon    : false,
								tooltip : '必要なモノ',
								callback: setAsHtml('[st-mybox title="必要なモノ" fontawesome="fa-file-text-o" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-circle" margin="25px 0 25px 0"]<ul><li>ダミーテキスト</li><li>ダミーテキスト</li><li>ダミーテキスト</li></ul>[/st-mybox]')
							},
							'st_button_mybox_intitle_item_dot' : {
								text 　 : '必要なモノ（ドット下線）',
								icon    : false,
								tooltip : '必要なモノ（ドット下線）',
								callback: setAsHtml('[st-mybox title="必要なモノ" fontawesome="fa-file-text-o" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-border st-list-circle" margin="25px 0 25px 0"]<ul><li>ダミーテキスト</li><li>ダミーテキスト</li><li>ダミーテキスト</li></ul>[/st-mybox]')
							},
							'st_button_mybox_intitle_check' : {
								text 　 : 'チェックリスト',
								icon    : false,
								tooltip : 'チェックリスト',
								callback: setAsHtml('[st-mybox title="チェックリスト" fontawesome="fa-file-text-o" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-check" margin="25px 0 25px 0"]<ul><li>ダミーテキスト</li><li>ダミーテキスト</li><li>ダミーテキスト</li></ul>[/st-mybox]')
							},
							'st_button_mybox_intitle_check_dot' : {
								text 　 : 'チェックリスト（ドット下線）',
								icon    : false,
								tooltip : 'チェックリスト（ドット下線）',
								callback: setAsHtml('[st-mybox title="チェックリスト" fontawesome="fa-file-text-o" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-border st-list-check" margin="25px 0 25px 0"]<ul><li>ダミーテキスト</li><li>ダミーテキスト</li><li>ダミーテキスト</li></ul>[/st-mybox]')
							},
							'st_button_mybox_intitle_flow' : {
								text 　 : '簡単な流れ',
								icon    : false,
								tooltip : '簡単な流れ',
								callback: setAsHtml('[st-mybox title="簡単な流れ" fontawesome="fa-list-ol" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-no" margin="25px 0 25px 0"]<ul><li>ダミーテキスト</li><li>ダミーテキスト</li><li>ダミーテキスト</li></ul>[/st-mybox]')
							},
							'st_button_mybox_intitle_flow_dot' : {
								text 　 : '簡単な流れ（ドット下線）',
								icon    : false,
								tooltip : '簡単な流れ（ドット下線）',
								callback: setAsHtml('[st-mybox title="簡単な流れ" fontawesome="fa-list-ol" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-no st-list-border" margin="25px 0 25px 0"]<ul><li>ダミーテキスト</li><li>ダミーテキスト</li><li>ダミーテキスト</li></ul>[/st-mybox]')
							},
						},
					},
					'st_button_freebox_group'      : {
						text    : '見出し付きフリーボックス',
						icon    : false,
						menu	: {
							'st_button_freebox_base'      : {
								text    : '基本',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox title="見出し（全角15文字）" fontawesome="" bordercolor="" color="" bgcolor="" borderwidth="" borderradius="" titleweight="bold"]<p>', '</p>[/st-midasibox]')
							},
							'st_button_freebox_attention'      : {
								text    : '注意',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox title="注意" fontawesome="fa-exclamation-circle faa-flash animated" bordercolor="#f44336" color="" bgcolor="#ffebee" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox]')
							},
							'st_button_freebox_question'      : {
								text    : 'はてな',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox title="はてな" fontawesome="fa-question-circle faa-ring animated" bordercolor="#03A9F4" color="#fff" bgcolor="#E1F5FE" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox]')
							},
							'st_button_freebox_point'      : {
								text    : 'ポイント',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox title="ポイント" fontawesome="fa-check-circle faa-ring animated" bordercolor="#FFC107" color="" bgcolor="#FFFDE7" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox]')
							},
							'st_button_freebox_memo'      : {
								text    : 'メモ',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox title="メモ" fontawesome="fa-file-text-o faa-float animated" bordercolor="#757575" color="" bgcolor="#FAFAFA" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox]')
							},
							'st_button_freebox_base_intitle'      : {
								text    : '基本（タイトル幅100%）',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox-intitle title="見出し（全角15文字）" fontawesome="" bordercolor="" color="" bgcolor="" borderwidth="" borderradius="" titleweight="bold"]<p>', '</p>[/st-midasibox-intitle]')
							},
							'st_button_freebox_attention_intitle'      : {
								text    : '注意（タイトル幅100%）',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox-intitle title="注意" fontawesome="fa-exclamation-circle faa-flash animated" bordercolor="#f44336" color="" bgcolor="#ffebee" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox-intitle]')
							},
							'st_button_freebox_question_intitle'      : {
								text    : 'はてな（タイトル幅100%）',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox-intitle title="はてな" fontawesome="fa-question-circle faa-ring animated" bordercolor="#03A9F4" color="#fff" bgcolor="#E1F5FE" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox-intitle]')
							},
							'st_button_freebox_point_intitle'      : {
								text    : 'ポイント（タイトル幅100%）',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox-intitle title="ポイント" fontawesome="fa-check-circle faa-ring animated" bordercolor="#FFC107" color="" bgcolor="#FFFDE7" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox-intitle]')
							},
							'st_button_freebox_memo_intitle'      : {
								text    : 'メモ（タイトル幅100%）',
								icon    : false,
								callback: wrapAsHtml('[st-midasibox-intitle title="メモ" fontawesome="fa-file-text-o faa-float animated" bordercolor="#757575" color="" bgcolor="#FAFAFA" borderwidth="" borderradius="5" titleweight="bold"]<p>', '</p>[/st-midasibox-intitle]')
							},
						},
					},
					'st_button_memobox'     : {
						text    : 'メモボックス',
						icon    : false,
						callback: wrapAsHtml('<div class="st-memobox2"><p class="st-memobox-title">メモ</p><p>', '</p></div><br/>')
					},
					'st_button_slidebox'     : {
						text    : 'スライドボックス',
						icon    : false,
						callback: wrapAsHtml('[st-slidebox text="+ クリックして下さい" bgcolor="" color="#1a1a1a" margin_bottom="20"]<p>','</p>[/st-slidebox]')
					},
					'st_button_square_checkbox'   : {
						text    : 'チェックボックス（番号なしリスト）',
						icon    : false,
						callback: wrapAsHtml('[st-square-checkbox bgcolor="" bordercolor="" fontweight="" borderwidth="3"]<div>', '</div>[/st-square-checkbox]')
					},
					'st_button_blackboard'   : {
						text    : 'こんな方におすすめ (v)',
						icon    : false,
						callback: setAsHtml('<div class="st-blackboard"><p class="st-blackboard-title-box"><span class="st-blackboard-title">こんな方におすすめ</span></p><ul class="st-blackboard-list st-no-ck-off"><li>これはダミーのテキストです</li><li>これはダミーのテキストです</li></ul></div><br/>')
					},
					'st_button_blackboard_checkbox'   : {
						text    : 'こんな方におすすめ [v]',
						icon    : false,
						callback: setAsHtml('<div class="st-blackboard square-checkbox"><p class="st-blackboard-title-box"><span class="st-blackboard-title">こんな方におすすめ</span></p><ul class="st-blackboard-list st-no-ck-off"><li>これはダミーのテキストです</li><li>これはダミーのテキストです</li></ul></div><br/>')
					},
					'st_button_guidemap'   : {
						text    : 'ガイドマップメニュー',
						icon    : false,
						callback: setAsHtml('<div class="st-link-guide st-link-guide-post"><ul class="st-link-guide-menu"><li><a href="#">ダミーリンク</a></li><li><a href="#">ダミーリンク</a></li><li><a href="#">ダミーリンク</a></li></div><br/>')
					},
					'st_pre'   : {
						text    : 'pre',
						icon    : false,
						callback: wrapAsHtml('[st-pre myclass="" text="html" fontawesome=""]<p>', '</p>[/st-pre]')
					},
					'st_pre_terminal'   : {
						text    : 'pre: terminal',
						icon    : false,
						callback: wrapAsHtml('[st-pre myclass="st-terminal" text="command" fontawesome="fa-terminal"]<p>', '</p>[/st-pre]')
					},
				},
			},
			'st_button_originalbutton_group_c': {
				text    : 'カスタムボタン',
				icon   : 'fa-toggle-on',
				menu: {
				'st_button_originalbutton_c': {
					text    : 'ノーマル',
					icon    : false,
					menu: {
							'st_button_originalbutton_default': {
								text    : '基本',
							icon    : false,
							callback: setAsText('[st-mybutton class="" url="#" title="ボタン" rel="" fontawesome="" target="" color="#000000" bgcolor="#FFF" bgcolor_top="" bordercolor="#CCC" borderwidth="3" borderradius="0" fontsize="" fontweight="" width="100" fontawesome_after="" shadow="" ref=""]')
							},
							'st_button_originalbutton_kuwasiku': {
								text    : '詳しくはコチラ（オレンジ）',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFD54F" bgcolor_top="#ffdb69" bordercolor="#FFEB3B" borderwidth="1" borderradius="5" fontsize="" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#FFB300" ref="on"]')
							},
							'st_button_originalbutton_kuwasiku_red': {
								text    : '詳しくはコチラ（レッド）',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#e53935" bgcolor_top="#f44336" bordercolor="#e57373" borderwidth="1" borderradius="5" fontsize="" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#c62828" ref="on"]')
							},
							'st_button_originalbutton_kuwasiku_green': {
								text    : '詳しくはコチラ（グリーン）',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#43A047" bgcolor_top="#66BB6A" bordercolor="#81C784" borderwidth="1" borderradius="5" fontsize="" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#388E3C" ref="on"]')
							},
							'st_button_originalbutton_kuwasiku_blue': {
								text    : '詳しくはコチラ（ブルー）',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#039BE5" bgcolor_top="#29B6F6" bordercolor="#4FC3F7" borderwidth="1" borderradius="5" fontsize="" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#039BE5" ref="on"]')
							},
							'st_button_originalbutton_contact': {
								text    : 'お問合せ',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="お問合せ" rel="" fontawesome="fa-envelope" target="" color="#fff" bgcolor="#03A9F4" bgcolor_top="#14b4fc" bordercolor="#039BE5" borderwidth="1" borderradius="5" fontsize="" fontweight="" width="90" fontawesome_after="" shadow="#039BE5" ref="on"]')
							},
							'st_button_originalbutton_orange': {
								text    : 'もっと詳しく（オレンジ）',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="もっと詳しく" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFD54F" bgcolor_top="#ffdb69" bordercolor="#FFEB3B" borderwidth="1" borderradius="30" fontsize="85" fontweight="" width="90" fontawesome_after="fa-angle-right" shadow="" ref="on"]')
							},
							'st_button_originalbutton_pink': {
								text    : 'もっと詳しく（ピンク）',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="もっと詳しく" rel="" fontawesome="" target="" color="#fff" bgcolor="#F48FB1" bgcolor_top="#f6a6c1" bordercolor="#F48FB1" borderwidth="1" borderradius="30" fontsize="85" fontweight="" width="90" fontawesome_after="fa-angle-right" shadow="" ref="on"]')
							},
							'st_button_originalbutton_blue': {
								text    : 'もっと詳しく（ブルー）',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="もっと詳しく" rel="" fontawesome="" target="" color="#fff" bgcolor="#4FC3F7" bgcolor_top="#67cbf8" bordercolor="#4FC3F7" borderwidth="1" borderradius="30" fontsize="85" fontweight="" width="90" fontawesome_after="fa-angle-right" shadow="" ref="on"]')
							},
							'st_button_originalbutton_under': {
								text    : '人気ランキング',
							icon    : false,
							callback: setAsText('[st-mybutton url="#" title="人気ランキング" rel="" fontawesome="st-svg-oukan" target="" color="#fff" bgcolor="#FBC02D" bgcolor_top="#fbc846" bordercolor="#FBC02D" borderwidth="1" borderradius="5" fontsize="110" fontweight="bold" width="90" fontawesome_after="" shadow="" ref="on"]')
							},
							'st_button_originalbutton_ranking_under': {
								text    : 'ランキングはコチラ',
							icon    : false,
							callback: setAsText('[st-mybutton class="" url="#ranking" title="ランキングはコチラ" rel="" fontawesome="fa-angle-double-down" target="" color="#1a1a1a" bgcolor="#fdef4e" bgcolor_top="" bordercolor="#fceb1c" borderwidth="1" borderradius="" fontsize="95" fontweight="" width="" fontawesome_after="" shadow="" ref=""]')
							},
							'st_button_originalbutton_guide': {
								text    : '[?] ガイド※使用不可',
							icon    : false,
							callback: setAsText('[st-mybutton class="追加クラス" url="リンク先URL" title="ボタンテキスト" rel="nofollow" fontawesome="Webアイコン（前）" target="リンク先を新しく開く(blank)" color="文字色" bgcolor="背景色（下）" bgcolor_top="背景色（上）" bordercolor="枠線カラー" borderwidth="枠線の太さ（px）" borderradius="角丸（px）" fontsize="文字サイズ（%）" fontweight="文字の太さ（bold）" width="幅（%）" fontawesome_after="Webアイコン（後）" shadow="ボタンの影色" ref="光る演出（on）"]')
							},
						},
					},
					'st_button_originalbutton_mini_c': {
					text    : 'ミニ',
					icon    : false,
					menu: {
							'st_button_originalbutton_mini_default': {
								text    : '基本',
							icon    : false,
							callback: setAsText('[st-mybutton-mini url="#" title="ボタン" rel="" fontawesome="" target="" color="#000000" bgcolor="#f3f3f3" bgcolor_top="" borderradius="3" fontsize="" fontweight="" fontawesome_after="" shadow="#BDBDBD" ref=""]')
							},
							'st_button_originalbutton_mini_kuwasiku': {
								text    : '詳しくはコチラ（オレンジ）',
							icon    : false,
							callback: setAsText('[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFB74D" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#FFB300" ref=""]')
							},
							'st_button_originalbutton_mini_kuwasiku_red': {
								text    : '詳しくはコチラ（レッド）',
							icon    : false,
							callback: setAsText('[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#ef5350" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#f44336" ref=""]')
							},
							'st_button_originalbutton_mini_kuwasiku_green': {
								text    : '詳しくはコチラ（グリーン）',
							icon    : false,
							callback: setAsText('[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#9CCC65" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#8BC34A" ref=""]')
							},
							'st_button_originalbutton_mini_kuwasiku_blue': {
								text    : '詳しくはコチラ（ブルー）',
							icon    : false,
							callback: setAsText('[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#4FC3F7" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#03A9F4" ref=""]')
							},
						},
					},
					'st_button_originalbutton_mc_c': {
					text    : 'MCボタン',
					icon    : false,
					menu: {
							'st_button_originalbutton_mc_orange': {
								text: 'オレンジ',
								icon    : false,
								callback: setAsText('[st-mcbutton url="#" title="今すぐ申し込む" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFD54F" bgcolor_top="#ffdb69" bordercolor="#FFEB3B" borderwidth="1" borderradius="5" fontweight="bold" fontsize="120" width="90" fontawesome_after="fa-chevron-right" shadow="#FFB300" ref="on" mcbox_bg="#fafafa" mcbox_color="" mcbox_title="太字のテキスト"]※マイクロコピーを書いてみよう[/st-mcbutton]')
							},
							'st_button_originalbutton_mc_red': {
								text: 'レッド',
								icon    : false,
								callback: setAsText('[st-mcbutton url="#" title="今すぐ申し込む" rel="" fontawesome="" target="" color="#fff" bgcolor="#e53935" bgcolor_top="#f44336" bordercolor="#e57373" borderwidth="1" borderradius="5" fontweight="bold" fontsize="120" width="90" fontawesome_after="fa-chevron-right" shadow="#c62828" ref="on" mcbox_bg="#fafafa" mcbox_color="" mcbox_title="太字のテキスト"]※マイクロコピーを書いてみよう[/st-mcbutton]')
							},
							'st_button_originalbutton_mc_green': {
								text: 'グリーン',
								icon    : false,
								callback: setAsText('[st-mcbutton url="#" title="今すぐ申し込む" rel="" fontawesome="" target="" color="#fff" bgcolor="#43A047" bgcolor_top="#66BB6A" bordercolor="#81C784" borderwidth="1" borderradius="5" fontweight="bold" fontsize="120" width="90" fontawesome_after="fa-chevron-right" shadow="#388E3C" ref="on" mcbox_bg="#fafafa" mcbox_color="" mcbox_title="太字のテキスト"]※マイクロコピーを書いてみよう[/st-mcbutton]')
							},
							'st_button_originalbutton_mc_blue': {
								text: 'ブルー',
								icon    : false,
								callback: setAsText('[st-mcbutton url="#" title="今すぐ申し込む" rel="" fontawesome="" target="" color="#fff" bgcolor="#039BE5" bgcolor_top="#29B6F6" bordercolor="#4FC3F7" borderwidth="1" borderradius="5" fontweight="bold" fontsize="120" width="90" fontawesome_after="fa-chevron-right" shadow="#039BE5" ref="on" mcbox_bg="#fafafa" mcbox_color="" mcbox_title="太字のテキスト"]※マイクロコピーを書いてみよう[/st-mcbutton]')
							},
						},
					},
					'st_btnlink_main': {
						text    : 'ボタンA',
						icon    : false,
						tooltip : 'ボタンA',
						callback: setAsHtml('<div class="rankstlink-r2"><p><a href="#">ボタンA</a></p></div><br/>')
					},
					'st_btnlink_sub': {
						text    : 'ボタンB',
						icon    : false,
						tooltip : 'ボタンB',
						callback: setAsHtml('<div class="rankstlink-l2"><p><a href="#">ボタンB</a></p></div><br/>')
					},
				},
			},
			'st_kaiwa': {
				text   : '会話ふきだし',
				icon   : 'dashicons-format-chat',
				menu: {
					'st_button_kaiwa_1'  : {
						text    : '会話1（ r]で反対向き）',
						icon    : false,
						callback: wrapAsText('[st-kaiwa1]', '[/st-kaiwa1]')
					},
					'st_button_kaiwa_2'  : {
						text    : '会話2',
						icon    : false,
						callback: wrapAsText('[st-kaiwa2]', '[/st-kaiwa2]')
					},
					'st_button_kaiwa_3'  : {
						text    : '会話3',
						icon    : false,
						callback: wrapAsText('[st-kaiwa3]', '[/st-kaiwa3]')
					},
					'st_button_kaiwa_4'  : {
						text    : '会話4',
						icon    : false,
						callback: wrapAsText('[st-kaiwa4]', '[/st-kaiwa4]')
					},
					'st_button_kaiwa_5'  : {
						text    : '会話5',
						icon    : false,
						callback: wrapAsText('[st-kaiwa5]', '[/st-kaiwa5]')
					},
					'st_button_kaiwa_6'  : {
						text    : '会話6',
						icon    : false,
						callback: wrapAsText('[st-kaiwa6]', '[/st-kaiwa6]')
					},
					'st_button_kaiwa_7'  : {
						text    : '会話7',
						icon    : false,
						callback: wrapAsText('[st-kaiwa7]', '[/st-kaiwa7]')
					},
					'st_button_kaiwa_8'  : {
						text    : '会話8',
						icon    : false,
						callback: wrapAsText('[st-kaiwa8]', '[/st-kaiwa8]')
					}
				}
			},
			'st_button_ranking'   : {
				text    : 'ランキング',
				icon    : 'st-svg-oukan',
				menu: {
						'st_button_ranking_1' : {
							text    : 'ランキング1位（基本）',
							icon    : false,
							tooltip : 'ランキング1位（基本）',
							callback: wrapAsText('[st-rank rankno="1" bgcolor="" color="#000" bordercolor="#ccc" radius="" star=""]', '[/st-rank]')
						},
						'st_button_ranking_2' : {
							text    : 'ランキング2位',
							icon    : false,
							tooltip : 'ランキング2位',
							callback: wrapAsText('[st-rank rankno="2" bgcolor="" color="#000" bordercolor="#ccc" radius="" star=""]', '[/st-rank]')
						},
						'st_button_ranking_3' : {
							text    : 'ランキング3位',
							icon    : false,
							tooltip : 'ランキング3位',
							callback: wrapAsText('[st-rank rankno="3" bgcolor="" color="#000" bordercolor="#ccc" radius="" star=""]', '[/st-rank]')
						},
						'st_button_ranking_4' : {
							text    : 'ランキング4位以下',
							icon    : false,
							tooltip : 'ランキング4位以下',
							callback: wrapAsText('[st-rank rankno="4" bgcolor="" color="#000" bordercolor="#ccc" radius="" star=""]', '[/st-rank]')
						},
						'st_button_ranking_guide' : {
							text    : '[?] ガイド※使用不可',
							icon    : false,
							tooltip : '[?] ガイド※使用不可',
							callback: wrapAsText('[st-rank rankno="ランキング（1～3又は空）" bgcolor="背景色" color="文字色" bordercolor="枠線カラー" radius="角丸（px）" star="スター（5,4,3,2,1）"]ここにテキスト', '[/st-rank]')
						},
						'st_button_st_af_cpt' : {
							text    : 'ID',
							icon    : false,
							tooltip : 'ID',
							callback: wrapAsText('[st_af id="', '"]'),
							enabled : function (definition, definitions) {
								return (typeof ST !== 'undefined' && ST.tag_plugin_enabled);
								}
						},
						'st_button_st_af_slug' : {
							text    : 'Slug',
							icon    : false,
							tooltip : 'Slug',
							callback: wrapAsText('[st_af name="', '"]'),
							enabled : function (definition, definitions) {
								return (typeof ST !== 'undefined' && ST.tag_plugin_enabled);
								}
						},
						'st_button_st_rankgroup' : {
							text    : 'RANK',
							icon    : false,
							tooltip : 'RANK',
							callback: wrapAsText('[st-rankgroup id="', '" label="" name=""]'),
							enabled : function (definition, definitions) {
								return (typeof ST !== 'undefined' && ST.tag_plugin_enabled);
							}
						},
					},
			},
			'st_layout': {
				text   : 'レイアウト',
				icon: 'dashicons-grid-view',
				menu: {
					'st_button_responbox33'  : {
						text    : 'PCとTab3分割',
						icon    : false,
						callback: setAsHtml('<div class="clearfix responbox33"><div class="lbox"><p>左側のコンテンツ33%</p></div><div class="lbox"><p>真ん中のコンテンツ33%</p></div><div class="lbox"><p>右側のコンテンツ33%</p></div></div><br/>')
					},
					'st_button_responbox'    : {
						text    : 'PCとTab左右40:60%',
						icon    : false,
						callback: setAsHtml('<div class="clearfix responbox"><div class="lbox"><p>左側のコンテンツ40%</p></div><div class="rbox"><p>右側のコンテンツ60%</p></div></div><br/>')
					},
					'st_button_responbox50'  : {
						text    : 'PCとTab左右50%',
						icon    : false,
						callback: setAsHtml('<div class="clearfix responbox50"><div class="lbox"><p>左側のコンテンツ50%</p></div><div class="rbox"><p>右側のコンテンツ50%</p></div></div><br/>')
					},
					'st_button_responbox30s' : {
						text    : '全サイズ左右30:70%',
						icon    : false,
						callback: setAsHtml('<div class="clearfix responbox30 smart30"><div class="lbox"><p>左側のコンテンツ30%</p></div><div class="rbox"><p>右側のコンテンツ70%</p></div></div><br/>')
					},
					'st_button_responbox50s' : {
						text    : '全サイズ左右50%',
						icon    : false,
						callback: setAsHtml('<div class="clearfix responbox50 smart50"><div class="lbox"><p>左側のコンテンツ50%</p></div><div class="rbox"><p>右側のコンテンツ50%</p></div></div><br/>')
					},
					'st_button_responboxfree': {
						text    : '全サイズ左右free%',
						icon    : false,
						callback: setAsHtml('<div class="clearfix responboxfree smartfree"><div class="lbox" style="width:50%"><p>左側のコンテンツ%</p></div><div class="rbox" style="width:50%"><p>右側のコンテンツ%</p></div></div><br/>')
					},
					'st_button_kintou'       : {
						text    : '均等横並び',
						icon    : false,
						callback: setAsHtml('<div class="kintou"><ul><li>横並びコンテンツ</li><li>横並びコンテンツ</li><li>横並びコンテンツ</li></ul></div><br/>')
					},
					'st_background_wide'       : {
						text    : '背景ワイド',
						icon    : false,
						callback: wrapAsHtml('[st-wide-background myclass="" backgroud_image="" bgcolor="#fafafa" align=""]<p>', '</p>[/st-wide-background]')
					},
					'st_button_div'       : {
						text    : 'Div',
						icon    : false,
						callback: wrapAsHtml('[st-div class=""]<p>', '</p>[/st-div]')
					},
					'st_button_margin'       : {
						text    : 'マージン',
						icon    : false,
						callback: wrapAsHtml('[st-margin margin="0 0 20px 0"]<p>', '</p>[/st-margin]')
					},
					'st_tab': {
						text   : 'タブ',
						icon: false,
						menu: {
							'st_button_tab2'       : {
								text    : '2つ',
								icon    : false,
								callback: setAsHtml('[st-tab-content memo="全体を包むボックスです"][st-input-tab text="タブ1" bgcolor="#fff" color="#1a1a1a" fontweight="" width="45" value="1" checked="checked"][st-input-tab text="タブ2" bgcolor="#fff" color="#1a1a1a" fontweight="" width="45" value="2" checked=""][st-tab-main bgcolor="" bordercolor="" value="1"]<p>タブ1のコンテンツ</p>[/st-tab-main][st-tab-main bgcolor="" bordercolor="" value="2"]<p>タブ2のコンテンツ</p>[/st-tab-main][/st-tab-content]')
							},
							'st_button_tab3'       : {
								text    : '3つ',
								icon    : false,
								callback: setAsHtml('[st-tab-content memo="全体を包むボックスです"][st-input-tab text="タブ1" bgcolor="#fff" color="#1a1a1a" fontweight="" width="30" value="1" checked="checked"][st-input-tab text="タブ2" bgcolor="#fff" color="#1a1a1a" fontweight="" width="30" value="2" checked=""][st-input-tab text="タブ3" bgcolor="#fff" color="#1a1a1a" fontweight="" width="30" value="3" checked=""][st-tab-main bgcolor="" bordercolor="" value="1"]<p>タブ1のコンテンツ</p>[/st-tab-main][st-tab-main bgcolor="" bordercolor="" value="2"]<p>タブ2のコンテンツ</p>[/st-tab-main][st-tab-main bgcolor="" bordercolor="" value="3"]<p>タブ3のコンテンツ</p>[/st-tab-main][/st-tab-content]')
							},
						},
					},
				},
			},
			'st_shortcode': {
				text   : 'その他パーツ',
				icon: 'dashicons-editor-code',
				menu: {
					'st_googleicon': {
						text   : 'Googleアイコン',
						icon    : false,
						menu: {
							'st_button_googleicon_desktop_mac'  : {
								text    : 'Mac',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="desktop_mac" fontsize="" color=""]')
							},
							'st_button_googleicon_phone_iphone'  : {
								text    : 'iPhone',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="phone_iphone" fontsize="" color=""]')
							},
							'st_button_googleicon_tablet_mac'  : {
								text    : 'tablet',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="tablet_mac" fontsize="" color=""]')
							},
							'st_button_googleicon_timer'  : {
								text    : 'タイマー',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="timer" fontsize="" color=""]')
							},
							'st_button_googleicon_location_on'  : {
								text    : 'MAP',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="location_on" fontsize="" color=""]')
							},
							'st_button_googleicon_directions_bike'  : {
								text    : '自転車',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="directions_bike" fontsize="" color=""]')
							},
							'st_button_googleicon_directions_run'  : {
								text    : '走る',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="directions_run" fontsize="" color=""]')
							},
							'st_button_googleicon_directions_car'  : {
								text    : '車',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="directions_car" fontsize="" color=""]')
							},
							'st_button_googleicon_directions_transit'  : {
								text    : '電車',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="directions_transit" fontsize="" color=""]')
							},
							'st_button_googleicon_subway'  : {
								text    : '地下鉄',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="subway" fontsize="" color=""]')
							},
							'st_button_googleicon_flight'  : {
								text    : '飛行機',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="flight" fontsize="" color=""]')
							},
							'st_button_googleicon_local_parking'  : {
								text    : '駐車場',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="local_parking" fontsize="" color=""]')
							},
							'st_button_googleicon_restaurant'  : {
								text    : 'レストラン',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="restaurant" fontsize="" color=""]')
							},
							'st_button_googleicon_store_mall_directory'  : {
								text    : 'ストア',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="store_mall_directory" fontsize="" color=""]')
							},
							'st_button_googleicon_cake'  : {
								text    : 'ケーキ',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="cake" fontsize="" color=""]')
							},
							'st_button_googleicon_smoking_rooms'  : {
								text    : 'タバコ',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="smoking_rooms" fontsize="" color=""]')
							},
							'st_button_googleicon_arrow_back'  : {
								text    : '矢印（左）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="arrow_back" fontsize="" color=""]')
							},
							'st_button_googleicon_arrow_downward'  : {
								text    : '矢印（下）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="arrow_downward" fontsize="" color=""]')
							},
							'st_button_googleicon_arrow_forward'  : {
								text    : '矢印（右）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="arrow_forward" fontsize="" color=""]')
							},
							'st_button_googleicon_arrow_upward'  : {
								text    : '矢印（上）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="arrow_upward" fontsize="" color=""]')
							},
							'st_button_googleicon_radio_button_unchecked'  : {
								text    : 'マル',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="radio_button_unchecked" fontsize="" color=""]')
							},
							'st_button_googleicon_close'  : {
								text    : 'バツ',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="close" fontsize="" color=""]')
							},
							'st_button_googleicon_mood'  : {
								text    : '顔（笑顔）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="mood" fontsize="" color=""]')
							},
							'st_button_googleicon_mood_bad'  : {
								text    : '顔（悪い）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="mood_bad" fontsize="" color=""]')
							},
							'st_button_googleicon_sentiment_satisfied'  : {
								text    : '顔（満足）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="sentiment_satisfied" fontsize="" color=""]')
							},
							'st_button_googleicon_sentiment_very_dissatisfied'  : {
								text    : '顔（不満）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="sentiment_very_dissatisfied" fontsize="" color=""]')
							},
							'st_button_googleicon_thumb_up_alt'  : {
								text    : '手（Like）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="thumb_up_alt" fontsize="" color=""]')
							},
							'st_button_googleicon_thumb_down_alt'  : {
								text    : '手（Bad）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="thumb_down_alt" fontsize="" color=""]')
							},
							'st_button_googleicon_error'  : {
								text    : '!（error）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="error" fontsize="" color=""]')
							},
							'st_button_googleicon_new_releases'  : {
								text    : '!（new）',
								icon    : false,
								callback: setAsText('[st-google-icon googleicon="new_releases" fontsize="" color=""]')
							},
						},
					},
					'st_button_star'            : {
						text    : 'スター',
						icon    : false,
						menu: {
							'st_button_star_5'            : {
								text    : 'スター（5）',
								icon    : false,
								callback: setAsText('[star5]')
							},
 							'st_button_star_45'            : {
								text    : 'スター（4.5）',
								icon    : false,
								callback: setAsText('[star45]')
							},
							'st_button_star_4'            : {
								text    : 'スター（4）',
								icon    : false,
								callback: setAsText('[star4]')
							},
							'st_button_star_35'            : {
								text    : 'スター（3.5）',
								icon    : false,
								callback: setAsText('[star35]')
							},
							'st_button_star_3'            : {
								text    : 'スター（3）',
								icon    : false,
								callback: setAsText('[star3]')
							},
							'st_button_star_2'            : {
								text    : 'スター（2）',
								icon    : false,
								callback: setAsText('[star2]')
							},
							'st_button_star_1'            : {
								text    : 'スター（1）',
								icon    : false,
								callback: setAsText('[star1]')
							},
						},
					},
					'st_button_user_comment_box'   : {
						text    : '画像付きコメント',
						icon    : false,
						tooltip : '画像付きコメント',
						callback: setAsText('[st-user-comment-box title="タイトル" user_text="◯代男性" color="" star="5"]画像（60×60）[/st-user-comment-box]')
					},
					'st_button_adsense'   : {
						text    : 'アドセンス',
						icon    : false,
						tooltip : 'アドセンス',
						callback: setAsText('[adsense]')
					},
					'st_button_originalsc': {
						text    : 'オリジナルショートコード',
						icon    : false,
						tooltip : 'オリジナルショートコード',
						callback: setAsText('[originalsc]')
					},
					'st_button_youtubeid' : {
						text    : 'YouTube',
						icon    : false,
						tooltip : 'YouTube',
						callback: wrapAsText('[youtube id=', ']')
					},
					'st_button_triangle'             : {
						text    : '三角（下矢印）',
						icon    : false,
						callback: setAsText('[st-under-t color="#000"]')
					},
					'st_button_st_slidelist'          : {
						text    : 'スクロールナビ',
						icon    : false,
						callback: setAsHtml('<div id="st_listnavi_wrapper"><ul class="st-sc-listnavi-box"><li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li><li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li><li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li></ul></div><br/>')
					},
					'st_button_st_toc_custom'          : {
						text    : '目次(カスタム)',
						icon    : false,
						callback: setAsHtml('<div id="st_toc_container" class="only-toc" ><p class="st_toc_title">目次</p><ul class="st_toc_list"><li><a href="#">メニュー1</a></li><li><a href="#">メニュー2</a></li><li><a href="#">メニュー3</a></li></ul></div><br/>')
					},
					'st_button_toc'             : {
						text    : '目次(TOC+)',
						icon    : false,
						callback: setAsText('[toc]')
					},
				},
			},
			'st_button_postgroup_sc' : {
				text    : '記事一覧',
				icon    : 'fa-list',
				menu: {
					'st_button_postgroup' : {
						text    : '記事一覧',
						icon    : false,
						callback: setAsText('[st-postgroup id="" rank=""]')
					},
					'st_button_catgroup' : {
						text    : 'カテゴリ一覧',
						icon    : false,
						callback: setAsText('[st-catgroup cat="0" page="5" order="desc" orderby="id" child="on" slide="off" slides_to_show="3,3,2" slide_date="" slide_more="ReadMore" slide_center="off"]')
					},
					'st_button_catgroup_slide' : {
						text    : 'カテゴリ一覧（スライドショー）',
						icon    : false,
						callback: setAsText('[st-catgroup cat="0" page="5" order="desc" orderby="id" child="on" slide="on" slides_to_show="3,3,1" slide_date="" slide_more="ReadMore" slide_center="on" fullsize_type=""]')
					},
					'st_button_catgroup_slide_img_class' : {
						text    : 'スライドショー画像のみ（※クラス）',
						icon    : false,
						callback: wrapAsHtml('<div class="st-slider-img">','</div>')
					},
					'st_button_osusume' : {
						text    : 'おすすめ記事一覧',
						icon    : false,
						callback: setAsText('[st-osusume]')
					},
				},
			},
			'st_button_bunki' : {
				text    : '条件表示',
				icon    : 'fa-eye',
				menu: {
					'st_button_commentout'          : {
						text    : 'コメントアウト',
						icon    : false,
						callback: wrapAsText('[st-out]', '[/st-out]')
					},
					'st_button_commentout_memo'          : {
						text    : 'エディタ用メモ',
						icon    : false,
						callback: setAsText('[st-comment-out memo="メモ"]')
					},
					'st_button_smanone'         : {
						text    : 'PC閲覧時のみ表示',
						icon    : false,
						callback: wrapAsText('[pc]', '[/pc]')
					},
					'st_button_pcnone'          : {
						text    : 'PC閲覧時のみ非表示',
						icon    : false,
						callback: wrapAsText('[nopc]', '[/nopc]')
					},
					'st_button_amp'          : {
						text    : 'AMPページのみ表示',
						icon    : false,
						callback: wrapAsText('[st-amp]', '[/st-amp]')
					},
					'st_button_no_amp'          : {
						text    : 'AMPページのみ非表示',
						icon    : false,
						callback: wrapAsText('[st-no-amp]', '[/st-no-amp]')
					},
					'st_button_frontonly'          : {
						text    : 'フロントページのみ表示',
						icon    : false,
						callback: wrapAsText('[frontonly]', '[/frontonly]')
					},
					'st_button_nofrontonly'          : {
						text    : 'フロントページのみ非表示',
						icon    : false,
						callback: wrapAsText('[no-frontonly]', '[/no-frontonly]')
					},
					'st_button_catonly'          : {
						text    : '指定したカテゴリーIDのみ非表示',
						icon    : false,
						callback: wrapAsText('[catonly cat="0"]', '[/catonly]')
					},
				},
			},
			'st_shortcode_support': {
				text   : 'ショートコード補助',
				icon   : 'fa-code',
				menu: {
					'st_webicon': {
						text   : 'Webアイコン（クラス）',
						icon    : false,
						menu: {
							'st_button_webicon_file'  : {
								text    : 'メモ',
								icon    : 'fa-file-text-o',
								callback: setAsText('fa-file-text-o')
							},
							'st_button_webicon_check'  : {
								text    : 'チェック (v)',
								icon    : 'fa-check-circle',
								callback: setAsText('fa-check-circle')
							},
							'st_button_webicon_checkbox'  : {
								text    : 'チェック [v]',
								icon    : 'st-svg-checkbox',
								callback: setAsText('st-svg-checkbox')
							},
							'st_button_webicon_exclamation'  : {
								text    : '注意',
								icon    : 'fa-exclamation-circle',
								callback: setAsText('fa-exclamation-circle')
							},
							'st_button_webicon_question'  : {
								text    : 'はてな',
								icon    : 'fa-question-circle',
								callback: setAsText('fa-question-circle')
							},
							'st_button_webicon_search'  : {
								text    : '虫メガネ',
								icon    : 'fa-search',
								callback: setAsText('fa-search')
							},
							'st_button_webicon_search_plus'  : {
								text    : '虫メガネ(+)',
								icon    : 'fa-search-plus',
								callback: setAsText('fa-search-plus')
							},
							'st_button_webicon_chevron_right'  : {
								text    : '矢印右',
								icon    : 'fa-chevron-right',
								callback: setAsText('fa-chevron-right')
							},
							'st_button_webicon_chevron_downn'  : {
								text    : '矢印下',
								icon    : 'fa-chevron-down',
								callback: setAsText('fa-chevron-down')
							},
							'st_button_webicon_chevron_doubleright'  : {
								text    : '矢印右2',
								icon    : 'fa-angle-double-right',
								callback: setAsText('fa-angle-double-right')
							},
							'st_button_webicon_chevron_doubledownn'  : {
								text    : '矢印下2',
								icon    : 'fa-angle-double-down',
								callback: setAsText('fa-angle-double-down')
							},
							'st_button_webicon_heart'  : {
								text    : 'ハート',
								icon    : 'fa-heart',
								callback: setAsText('fa-heart')
							},
							'st_button_webicon_user'  : {
								text    : 'ユーザー',
								icon    : 'fa-user',
								callback: setAsText('fa-user')
							},
							'st_button_webicon_comments'  : {
								text    : 'コメント',
								icon    : 'fa-comments',
								callback: setAsText('fa-comments')
							},
							'st_button_webicon_lightbulb'  : {
								text    : '電球',
								icon    : 'fa-lightbulb-o',
								callback: setAsText('fa-lightbulb-o')
							},
							'st_button_webicon_bullhorn'  : {
								text    : 'おしらせ',
								icon    : 'fa-bullhorn',
								callback: setAsText('fa-bullhorn')
							},
							'st_button_webicon_mail'  : {
								text    : 'メール',
								icon    : 'fa-envelope',
								callback: setAsText('fa-envelope')
							},
							'st_button_webicon_code'  : {
								text    : 'コード',
								icon    : 'fa-code',
								callback: setAsText('fa-code')
							},
							'st_button_webicon_gift'  : {
								text    : 'ギフト',
								icon    : 'fa-gift',
								callback: setAsText('fa-gift')
							},
							'st_button_webicon_diamond'  : {
								text    : 'ダイヤモンド',
								icon    : 'fa-diamond',
								callback: setAsText('fa-diamond')
							},
							'st_button_webicon_download'  : {
								text    : 'ダウンロード',
								icon    : 'fa-download',
								callback: setAsText('fa-download')
							},
							'st_button_webicon_twitter'  : {
								text    : 'Twitter',
								icon    : 'fa-twitter',
								callback: setAsText('fa-twitter')
							},
							'st_button_webicon_facebook'  : {
								text    : 'Facebook',
								icon    : 'fa-facebook-square',
								callback: setAsText('fa-facebook-square')
							},
							'st_button_webicon_youtube'  : {
								text    : 'YouTube',
								icon    : 'fa-youtube-play',
								callback: setAsText('fa-youtube-play')
							},
							'st_button_webicon_amazon'  : {
								text    : 'amazon',
								icon    : 'fa-amazon',
								callback: setAsText('fa-amazon')
							},
							'st_button_webicon_oukan'  : {
								text    : '王冠',
								icon    : 'st-svg-oukan',
								callback: setAsText('st-svg-oukan')
							},
							'st_button_webicon_bigginer'  : {
								text    : '初心者',
								icon    : 'st-svg-bigginer_l',
								callback: setAsText('st-svg-bigginer_l')
							},
						},
					},
					'st_webicon_animation': {
						text   : 'アニメーション（クラス）',
						icon    : false,
						menu: {
							'st_button_webicon_animation_wrench'  : {
								text    : '45°揺れ',
								icon    : false,
								callback: setAsText(' faa-wrench animated')
							},
							'st_button_webicon_animation_ring'  : {
								text    : 'ベル揺れ',
								icon    : false,
								callback: setAsText(' faa-ring animated')
							},
							'st_button_webicon_animation_horizontal'  : {
								text    : '横揺れ',
								icon    : false,
								callback: setAsText(' faa-horizontal animated')
							},
							'st_button_webicon_animation_vertical'  : {
								text    : '縦揺れ',
								icon    : false,
								callback: setAsText(' faa-vertical animated')
							},
							'st_button_webicon_animation_flash'  : {
								text    : '点滅',
								icon    : false,
								callback: setAsText(' faa-flash animated')
							},
							'st_button_webicon_animation_bounce'  : {
								text    : 'バウンド',
								icon    : false,
								callback: setAsText(' faa-bounce animated')
							},
							'st_button_webicon_animation_spin'  : {
								text    : '回転',
								icon    : false,
								callback: setAsText(' faa-spin animated')
							},
							'st_button_webicon_animation_float'  : {
								text    : 'ふわふわ',
								icon    : false,
								callback: setAsText(' faa-float animated')
							},
							'st_button_webicon_animation_pulse'  : {
								text    : '大小',
								icon    : false,
								callback: setAsText(' faa-pulse animated')
							},
							'st_button_webicon_animation_shake'  : {
								text    : 'シェイク',
								icon    : false,
								callback: setAsText(' faa-shake animated')
							},
							'st_button_webicon_animation_shake_big'  : {
								text    : 'シェイク（大）',
								icon    : false,
								callback: setAsText(' st-shake')
							},
							'st_button_webicon_animation_tada'  : {
								text    : '拡大（ゆれ）',
								icon    : false,
								callback: setAsText(' faa-tada animated')
							},
							'st_button_webicon_animation_passing'  : {
								text    : '過ぎる',
								icon    : false,
								callback: setAsText(' faa-passing animated')
							},
							'st_button_webicon_animation_file'  : {
								text    : '戻る',
								icon    : false,
								callback: setAsText(' faa-passing-reverse animated')
							},
							'st_button_webicon_animation_burst'  : {
								text    : 'バースト',
								icon    : false,
								callback: setAsText(' faa-burst animated')
							},
							'st_button_webicon_animation_falling'  : {
								text    : '落ちる',
								icon    : false,
								callback: setAsText(' faa-falling animated')
							},

						}
					},
					'st_htmlcolorcode': {
						text   : 'HTMLカラーコード',
						icon    : false,
						menu: {
							'st_button_htmlcolorcode_white'  : {
								text    : '白（#ffffff）',
								icon    : false,
								callback: setAsText('#ffffff')
							},
							'st_button_htmlcolorcode_red'  : {
								text    : '赤濃（#e53935）',
								icon    : false,
								callback: setAsText('#e53935')
							},
							'st_button_htmlcolorcode_red2'  : {
								text    : '赤（#f44336）',
								icon    : false,
								callback: setAsText('#f44336')
							},
							'st_button_htmlcolorcode_red3'  : {
								text    : '赤薄（#ffebee）',
								icon    : false,
								callback: setAsText('#ffebee')
							},
							'st_button_htmlcolorcode_blue'  : {
								text    : '青濃（#039BE5）',
								icon    : false,
								callback: setAsText('#039BE5')
							},
							'st_button_htmlcolorcode_blue2'  : {
								text    : '青（#03A9F4）',
								icon    : false,
								callback: setAsText('#03A9F4')
							},
							'st_button_htmlcolorcode_blue3'  : {
								text    : '青薄（#E1F5FE）',
								icon    : false,
								callback: setAsText('#E1F5FE')
							},
							'st_button_htmlcolorcode_green'  : {
								text    : '緑濃（#43A047）',
								icon    : false,
								callback: setAsText('#43A047')
							},
							'st_button_htmlcolorcode_green2'  : {
								text    : '緑（#4CAF50）',
								icon    : false,
								callback: setAsText('#4CAF50')
							},
							'st_button_htmlcolorcode_green3'  : {
								text    : '緑薄（#E8F5E9）',
								icon    : false,
								callback: setAsText('#E8F5E9')
							},
							'st_button_htmlcolorcode_orange'  : {
								text    : '橙濃（#FFB300）',
								icon    : false,
								callback: setAsText('#FFB300')
							},
							'st_button_htmlcolorcode_orange2'  : {
								text    : '橙（#FFC107）',
								icon    : false,
								callback: setAsText('#FFC107')
							},
							'st_button_htmlcolorcode_orange3'  : {
								text    : '橙薄（#FFF3E0）',
								icon    : false,
								callback: setAsText('#FFF3E0')
							},
							'st_button_htmlcolorcode_black'  : {
								text    : '黒濃（#212121）',
								icon    : false,
								callback: setAsText('#212121')
							},
							'st_button_htmlcolorcode_black2'  : {
								text    : '黒（#424242）',
								icon    : false,
								callback: setAsText('#424242')
							},
							'st_button_htmlcolorcode_black3'  : {
								text    : '黒薄（#FAFAFA）',
								icon    : false,
								callback: setAsText('#FAFAFA')
							},
							'st_button_htmlcolorcode_yellow'  : {
								text    : '黄薄（#FFFDE7）',
								icon    : false,
								callback: setAsText('#FFFDE7')
							},
						},
					},
					'st_htmlcolorcode_bland': {
						text   : 'HTMLカラーコード（ブランド)',
						icon    : false,
						menu: {
							'st_button_htmlcolorcode_twitter'  : {
								text    : 'Twitter（#40a2f5)',
								icon    : 'fa-twitter',
								callback: setAsText('#40a2f5')
							},
							'st_button_htmlcolorcode_facebook'  : {
								text    : 'Facebook（#415c9d)',
								icon    : 'fa-facebook-square',
								callback: setAsText('#415c9d')
							},
							'st_button_htmlcolorcode_hateb'  : {
								text    : 'hatena（#3290e1)',
								icon    : 'st-svg-hateb',
								callback: setAsText('#3290e1')
							},
							'st_button_htmlcolorcode_wp'  : {
								text    : 'WordPress（#2d88c0)',
								icon    : 'fa-wordpress',
								callback: setAsText('#2d88c0')
							},
							'st_button_htmlcolorcode_amazon'  : {
								text    : 'amazon（#eb9100)',
								icon    : 'fa-amazon',
								callback: setAsText('#eb9100')
							},
							'st_button_htmlcolorcode_line'  : {
								text    : 'LINE（#39b900)',
								icon    : false,
								callback: setAsText('#39b900')
							},
						},
					},
					'st_fixed_phrase': {
						text   : '定型文',
						icon    : false,
						menu: {
							'st_fixed_phrase_banzai'  : {
								text    : '＼ バンザイ ／',
								icon    : false,
								callback: setAsText('＼ バンザイ ／')
							},
							'st_fixed_phrase_kousiki'  : {
								text    : '詳細は公式サイトにて',
								icon    : false,
								callback: setAsText('※時期により内容が異なる場合がございます。詳細は公式サイトにてご確認下さいませ。')
							},
							'st_fixed_phrase_copyright'  : {
								text    : '無断利用禁止',
								icon    : false,
								callback: setAsText('※掲載されている文字、写真、イラスト等は著作権の対象となっています。無断利用を固く禁止しております。')
							},
							'st_fixed_phrase_damy'  : {
								text    : 'ダミーテキスト',
								icon    : false,
								callback: setAsText('これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです')
							},
						},
					},

				}
			}
		};
	}

	function getButtonDefinition(editor) {
		var setAsHtml  = createCallbackFactory(editor, _setAsHtml);
		var setAsText  = createCallbackFactory(editor, _setAsText);
		var wrapAsHtml = createCallbackFactory(editor, _wrapAsHtml);
		var wrapAsText = createCallbackFactory(editor, _wrapAsText);

		return {

			'st_button_huto'   : {
				text    : '太字',
				icon    : false,
				tooltip : '太字',
				callback: wrapAsHtml('<span class="huto">', '</span>')
			},
			'st_button_hutoaka': {
				text    : '太赤',
				icon    : false,
				tooltip : '太赤',
				callback: wrapAsHtml('<span class="hutoaka">', '</span>')
			},
			'st_button_mycolor': {
				text    : '太字',
				icon    : 'fa-user-circle',
				tooltip : '太字',
				callback: wrapAsHtml('<span class="st-mycolor">', '</span>')
			},
			'st_button_mymarker': {
				text    : '細マ',
				icon    : 'fa-user-circle',
				tooltip : '細マ',
				callback: wrapAsHtml('<span class="st-mymarker-s">', '</span>')
			},
			'st_button_ruby': {
				text    : 'ルビ',
				icon    : false,
				tooltip : 'ルビ',
				callback: wrapAsText('<ruby>', '<rt>ふりがな</rt></ruby>')
			},
			'st_button_count': {
				text    : 'CT',
				icon    : false,
				tooltip : 'カウント',
				callback: wrapAsText('<span class="st-count">', '</span>')
			},
			'st_button_photoline': {
				text    : '写真枠',
				icon    : false,
				tooltip : '写真枠',
				callback: wrapAsHtml('<span class="photoline">', '</span>')
			},
			'st_button_kadomaru_bg': {
				text    : 'マイボックス',
				icon    : false,
				tooltip : 'マイボックス',
				callback: wrapAsHtml('[st-mybox title="" fontawesome="" color="#757575" bordercolor="#f3f3f3" bgcolor="#f3f3f3" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]<p>', '</p>[/st-mybox]')
			},
			'st_btnlink_custom_main': {
				text    : 'ボタン',
				icon    : false,
				tooltip : 'ボタン',
				callback: setAsText('[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#e53935" bgcolor_top="#f44336" bordercolor="#e57373" borderwidth="1" borderradius="5" fontsize="" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#c62828" ref="on"]')
			},
			'st_button_blogcard' : {
				text    : 'カード',
				icon    : false,
				tooltip : 'カード',
				callback: wrapAsText('[st-card id=', ' label="" name="" bgcolor="" color="" fontawesome="" readmore="on"]')
			},
			'st_button_st_toc' : {
				text    : '目次',
				icon    : 'fa-bookmark',
				tooltip : '目次',
				callback: setAsHtml('<p>[st_toc]<p>'),
				enabled : function (definition, definitions) {
					return (typeof ST !== 'undefined' && ST.st_toc_enabled);
				}
			}
		};
	}

	function registerButtons(editor, definition) {
		for (var key in definition) {
			if (!Object.prototype.hasOwnProperty.call(definition, key)) {
				continue;
			}

			if (Object.prototype.hasOwnProperty.call(definition[key], 'enabled')) {
				var enabled = ($.isFunction(definition[key].enabled))
					? definition[key].enabled(definition[key], definition)
					: definition[key].enabled;

				if (!enabled) {
					continue;
				}
			}

			editor.addButton(key, {
				type   : 'button',
				text   : definition[key].text,
				icon   : definition[key].icon,
				tooltip: definition[key].tooltip,
				onclick: definition[key].callback
			});
		}
	}

	function generateListBoxValues(definition) {
		var values = [];

		for (var key in definition) {
			if (!Object.prototype.hasOwnProperty.call(definition, key)) {
				continue;
			}

			if (Object.prototype.hasOwnProperty.call(definition[key], 'enabled')) {
				var enabled = ($.isFunction(definition[key].enabled))
					? definition[key].enabled(definition[key], definition)
					: definition[key].enabled;

				if (!enabled) {
					continue;
				}
			}

			if (Object.prototype.hasOwnProperty.call(definition[key], 'menu')) {
				var menu = generateListBoxValues(definition[key].menu);

				values.push({
					text   : definition[key].text,
					icon   : definition[key].icon,
					tooltip: definition[key].tooltip,
					menu   : menu
				});

				continue;
			}

			values.push({
				text   : definition[key].text,
				icon   : definition[key].icon,
				tooltip: definition[key].tooltip,
				value  : key
			});
		}

		return values;
	}

	function registerListItems(editor, definition) {
		editor.addButton('st_listbox_1', {
			type        : 'listbox',
			text        : 'タグ',
			icon        : false,
			values      : generateListBoxValues(definition),
			onPostRender: function () {
				this.value(this.settings.values[0].value);
			},
			onselect    : function (event) {
				var value = (typeof event.control !== 'undefined' && typeof event.control.value === 'function')
					? event.control.value()
					: this.value();

				tinyMCE.execCommand(value, false);
				this.value(null);
			}
		});
	}

	function registerCommands(editor, definition) {
		for (var key in definition) {
			if (!Object.prototype.hasOwnProperty.call(definition, key)) {
				continue;
			}

			if (Object.prototype.hasOwnProperty.call(definition[key], 'enabled')) {
				var enabled = ($.isFunction(definition[key].enabled))
					? definition[key].enabled(definition[key], definition)
					: definition[key].enabled;

				if (!enabled) {
					continue;
				}
			}

			if (Object.prototype.hasOwnProperty.call(definition[key], 'menu')) {
				registerCommands(editor, definition[key].menu);

				continue;
			}

			editor.addCommand(key, definition[key].callback);
		}
	}

	Plugin = {
		init: function (editor, url) {
			var listItems = getListItemDefinition(editor);
			var buttons   = getButtonDefinition(editor);

			registerCommands(editor, listItems);
			registerCommands(editor, buttons);

			registerListItems(editor, listItems);
			registerButtons(editor, buttons);
		}
	};

	tinymce.create('tinymce.plugins.st', Plugin);
	tinymce.PluginManager.add('st_plugin', tinymce.plugins.st);
}(window, window.document, jQuery, tinymce, ST));
