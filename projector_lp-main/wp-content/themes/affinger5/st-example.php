<?php
// 状態
if ( ! function_exists( '_st_example_get_default_states' ) ) {
	function _st_example_get_default_states() {
		return array(
			'post' => false,
			'page' => false,
		);
	}
}

if ( ! function_exists( '_st_example_get_states' ) ) {
	function _st_example_get_states() {
		$states = get_option( 'st_example_posts', array() );

		return array_merge( _st_example_get_default_states(), $states );
	}
}

if ( ! function_exists( '_st_example_update_states' ) ) {
	function _st_example_update_states( $states ) {
		$states = array_merge( _st_example_get_default_states(), $states );

		return update_option( 'st_example_posts', $states );
	}
}

// コンテンツ
if ( ! function_exists( '_st_example_get_post_content' ) ) {
	function _st_example_get_post_content() {
		// 投稿の内容 (HTML)
		return <<<'HTML'
<p>テーマで用意されているスタイルやショートコードによるタグなどの<span class="huto">デザイン確認用ページ</span>です。</p>
<h2 id="rei">スタイル</h2>
<h3>テキスト</h3>
<p>これは<span class="huto">太字</span>です。</p>
<p>これは<span class="hutoaka">赤字</span>です。</p>
<p>これは<span class="oomozi">大文字</span>です。</p>
<p class="komozi">これは小文字です</p>
<p><span class="dotline">これはドット線です。</span></p>
<p class="st-share"><a href="#">これは参照リンクです</a></p>
<p><span class="sankou">参考</span>これは参考マークです（例：参考という文字を記入してから使用）</p>
<p><span class="st-hisu">必須</span>これは必須マークです（例：必須という文字を記入してから使用）</p>
<p>これは<del>打消し</del>です。</p>
<p>これは<code>code</code>などに使用します</p>
<h3>アニメーション</h3>
<p><span class="fa faa-wrench animated st-animate">(^ _ ^)45°揺れ</span></p>
<p><span class="fa faa-ring animated st-animate">(^ _ ^)ベル揺れ</span></p>
<p><span class="fa faa-horizontal animated st-animate">(^ _ ^)横揺れ</span></p>
<p><span class="fa faa-vertical animated st-animate">(^ _ ^)縦揺れ</span></p>
<p class="fa faa-flash animated st-animate">(^ _ ^)点滅</p>
<p><span class="fa faa-bounce animated st-animate">(^ _ ^)バウンド</span></p>
<p class="fa faa-spin animated st-animate">(^ _ ^)回転</p>
<p><span class="fa faa-float animated st-animate">(^ _ ^)ふわふわ</span></p>
<p><span class="fa faa-pulse animated st-animate">(^ _ ^)大小</span></p>
<p><span class="fa faa-shake animated st-animate">(^ _ ^)シェイク</span></p>
<p><span class="st-shake st-animate">(^ _ ^)シェイク（強）</span></p>
<p><span class="fa faa-tada animated st-animate">(^ _ ^)拡大（ゆれ）</span></p>
<p><span class="fa faa-passing animated st-animate">(^ _ ^)過ぎる</span></p>
<p><span class="fa faa-passing-reverse animated st-animate">(^ _ ^)戻る</span></p>
<p><span class="fa faa-burst animated st-animate">(^ _ ^)バースト</span></p>
<h3>アイコン</h3>
<p>アイコンマークは「カスタマイザー」の「オプション」で<span class="huto">カラーを設定できます</span>。※通常エディタ上では表示されません</p>
<p><span class="hatenamark2 on-color">これは「はてな」マークです</span></p>
<p><span class="attentionmark2 on-color">これは「注意」マークです</span></p>
<p><span class="usermark2 on-color">これは「人物」マークです</span></p>
<p><span class="checkmark2 on-color">これは「チェック」マークです</span></p>
<p><span class="memomark2 on-color">これは「メモ」マークです</span></p>
<p><span class="oukanmark on-color">これは「王冠」マークです</span></p>
<p><span class="bigginermark on-color">これは「初心者」マークです</span></p>
<h3>見出し</h3>
<h4>キャッチコピー</h4>
<h5><span class="st-h-copy">こんな風にキャッチコピー</span>見出しタグのテキストなど</h5>
<h5>見出しタグのテキストなど<span class="st-h-copy">こんな風にキャッチコピー</span></h5>
<h4>記事タイトル</h4>
<p>記事タイトル、h2〜h5風はPタグに見出しタグと同じデザインを設定します</p>
<h4>まとめ</h4>
<h4>カウント</h4>
<p>カウントは設定したテキストや見出し（hタグ）などに<span class="huto">自動で番号を振付け</span>ます。手動で番号を付けるよりも簡易であるのはもちろん、テキスト自体ではなくCSSで数字を付与するため目次などにも反映されないなどのメリットがあります。</p>
<p>クイックボタンの「CT」でも付与できます。</p>
<p><span class="st-count">これはダミーのテキストです</span></p>
<p><span class="st-count">これはダミーのテキストです</span></p>
<p><span class="st-count">これはダミーのテキストです</span></p>
<h4 class="st-matome">これは「まとめ」用の見出しです</h4>
<p>通常の見出しタグとは別に<span class="huto">「まとめ」用のデザイン</span>をカスタマイザーの「各テキストとhタグ（見出し）」で設定できます</p>
<h4>ランキング(AFFINGER又はEX版のみ）</h4>
<h4 class="rankh4 rankno-1">ランキング1位</h4>
<h4 class="rankh4 rankno-2">ランキング2位</h4>
<h4 class="rankh4 rankno-3">ランキング3位</h4>
<h4 class="rankh4 rankno-4">ランキング4位以下</h4>
<h4>マーカー</h4>
<p>これは<span class="ymarker">黄マーカー</span>です。</p>
<p>これは<span class="ymarker-s">黄マーカー（細）</span>です。</p>
<p>これは<span class="rmarker">赤マーカー</span>です。</p>
<p>これは<span class="rmarker-s">赤マーカー（細）</span>です。</p>
<p>これは<span class="bmarker">青マーカー</span>です。</p>
<p>これは<span class="bmarker-s">青マーカー（細）</span>です。</p>
<p>これは<span class="gmarker">鼠マーカー</span>です。</p>
<p>これは<span class="gmarker-s">鼠マーカー（細）</span>です。</p>
<h3>写真</h3>
<h4>写真枠</h4>
<p>写真に「枠線」を付与します。境界が曖昧な写真などにとくに有効です（クイックボタン「写真枠」でも使用できます）</p>
<p><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" /></p>
<h5>キャプションあり</h5>

[caption id="" align="alignnone" width="1280"]<img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" alt="" width="1280" height="960" /> キャプションを追加できます[/caption]

<h4>ポラロイド風</h4>
<p>写真をポラロイド風にデザインします</p>
<div class="st-photohu"><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" /></div>
<div class="st-photohu">
[caption id="" align="alignnone" width="1280"]<img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" alt="" width="1280" height="960" /> <a href="https://uploader.xzy.pw/upload">リンク付きのキャプション</a>[/caption]
</div>
<h3>ボックス</h3>
<div class="yellowbox">
<p>黄色ボックスです</p>
</div>
<div class="redbox">
<p>薄赤ボックスです</p>
</div>
<div class="graybox">
<p>グレーボックスです</p>
</div>
<div class="inyoumodoki">
<p>引用風のボックスです</p>
</div>
<h4>ワイド</h4>
<p>幅一杯の背景を設定するEX限定デザインです</p>
<div class="st-wide-background">
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
</div>
<div class="st-wide-background-left">
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
</div>
<div class="st-wide-background-right">
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
</div>
<p>ショートコードタグでは背景色や画像も設定できます</p>
<p>[st-wide-background myclass="" backgroud_image="" bgcolor="#FFF9C4" align=""]</p>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<p>[/st-wide-background]</p>
<p>[st-wide-background myclass="" backgroud_image="" bgcolor="#F8BBD0" align="l"]</p>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<p>[/st-wide-background]</p>
<p>[st-wide-background myclass="" backgroud_image="" bgcolor="#B3E5FC" align="r"]</p>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<p>[/st-wide-background]</p>
<h3>リスト</h3>
<h4>ドット下線（リスト）</h4>
<div class="st-list-border">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>マル（リスト）</h4>
<div class="st-list-circle">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>マル+ドット下線（リスト）</h4>
<div class="st-list-circle st-list-border">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>簡易チェック（リスト）</h4>
<div class="st-list-check">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>簡易チェック+ドット下線（リスト）</h4>
<div class="st-list-check st-list-border">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>チェックボックス（番号なしリスト）</h4>
<p>ulタグの<span class="huto">番号なしリスト</span>を囲むとチェックボックス風のデザインになります。</p>
<div class="st-square-checkbox st-square-checkbox-nobox">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>チェックリスト（番号なしリスト）</h4>
<p>ulタグの<span class="huto">番号なしリスト</span>を囲むとチェック風のデザインになります。「テキストモード」でするか、「チェック（ulタグ）」を適応してから「番号なしリスト」を適応すると便利です。</p>
<p class="komozi">※カスタマイザーの「オプション」でカラー変更が可能です</p>
<div class="maruck">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>ナンバリング（番号付きリスト）</h4>
<p>olタグの<span class="huto">番号付きリスト</span>を囲むとチェック風のデザインになります。「テキストモード」でするか、「ナンバリング（olタグ）」を適応してから「番号付きリスト」を適応すると便利です。</p>
<p>※カスタマイザーの「オプション」でカラー変更が可能です</p>
<div class="maruno">
<ol>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ol>
</div>
<h4>ナンバリング四角（リスト）</h4>
<div class="st-list-no">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h4>ナンバリング四角+ドット下線（リスト）</h4>
<div class="st-list-no st-list-border">
<ul>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
	<li>これはダミーのリストです</li>
</ul>
</div>
<h3>レイアウト</h3>
<h4>回り込み解除</h4>
<p><code>&lt;div class="clearfix"&gt; &lt;/div&gt;</code>で囲み、<code>float</code>を解除します</p>
<h4>センター寄せ</h4>
<div class="center"><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" width="50%" /></div>
<p>要素をセンター寄せにします。</p>
<h4>下に余白</h4>
<div style="padding-bottom: 10px;"><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" width="50%" /></div>
<p>要素の下に「10px」の余白を付けます</p>
<h4>カードスタイル</h4>
<p>※記事ID2で設定されています（ない場合は適宜変更して下さい）</p>
<p>ブログカードに別のデザインを設定します（全サイズで縦型）</p>
<div class="st-cardstyle">
<p>[st-card id=2 label="" name="" bgcolor="" color="" readmore="on"]</p>
</div>
<h4>カードスタイルB</h4>
<p>ブログカードに別のデザインを設定します（PC、タブレット閲覧時のみ縦型）</p>
<div class="st-cardstyleb">
<p>[st-card id=2 label="" name="" bgcolor="" color="" readmore="on"]</p>
</div>
<h4>ランキングボックス(AFFINGER又はEX版のみ）</h4>
<p>「ランキング一覧背景色」と同じスペースを設定します</p>
<h4>width100%リセット</h4>
<p><code>max-width: initial; display: inline;</code>を設定して<code>max-width</code>をリセットします。</p>
<h4>imgインラインボックス</h4>
<p><code>display: inline;</code>を指定します。</p>
<h3>テーブル</h3>
<p>テーブル（表の作成）には「<a href="https://ja.wordpress.org/plugins/tinymce-advanced/">TinyMCE Advanced</a>」プラグインが便利です。</p>
<h4>横スクロール</h4>
<p>スマートフォン閲覧時など横幅がはみ出る場合にtableタグを&lt;div class="scroll-box"&gt;&lt;/div&gt;で囲むことで<span class="huto">横スクロールに対応</span>させます。</p>
<div class="scroll-box">
<table style="border-collapse: collapse;" border="1">
<tbody>
<tr>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
</tr>
<tr>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
</tr>
</tbody>
</table>
</div>
<h4>中央配置</h4>
<p>table内のテキストを<span class="huto">上下左右の中央</span>に配置します。</p>
<div class="st-centertable">
<table style="border-collapse: collapse;" border="1">
<tbody>
<tr>
<td>テキスト</td>
<td>テキスト</td>
<td>テキスト</td>
<td>テキスト</td>
</tr>
<tr>
<td>テキスト</td>
<td>テキスト</td>
<td>テキスト</td>
<td>テキスト</td>
</tr>
</tbody>
</table>
</div>
<h4>装飾なし</h4>
<p>テーマで用意されたデフォルトデザインを<span class="huto">解除</span>します。</p>
<div class="notab">
<table style="border-collapse: collapse;" border="1">
<tbody>
<tr>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
</tr>
<tr>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
<td>これはダミーのテキストです</td>
</tr>
</tbody>
</table>
</div>
<p class="komozi">※設定が上手くできない（tableタグを囲めない）場合は<span class="huto">「テキストモード」</span>での作業をお勧めします</p>
<h2>タグ</h2>
<h3>デザイン</h3>
<h4>クリップメモ</h4>
<p>ショートコードで作成するデザインです。以下はデフォルトで用意されているデザインですが、<span class="huto">自分でカスタマイズ</span>することも可能です。</p>
<p>[st-cmemo fontawesome="fa-file-text-o" iconcolor="#919191" bgcolor="#fafafa" color="#000000" iconsize="100"]（メモ）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-external-link" iconcolor="#BDBDBD" bgcolor="#fafafa" color="#757575" iconsize="100"]（外部リンク）ダミーテキストです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-bookmark" iconcolor="#BDBDBD" bgcolor="#fafafa" color="#757575" iconsize="100"]（ブックマーク）ダミーテキストです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-bullhorn" iconcolor="#FFEB3B" bgcolor="#FFFDE7" color="#000000" iconsize="100"]（おしらせ）ダミーテキストです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-question-circle" iconcolor="#4FC3F7" bgcolor="#E1F5FE" color="#000000" iconsize="100"]（はてな）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-comments" iconcolor="#F48FB1" bgcolor="#FCE4EC" color="#000000" iconsize="100"]（コメント）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-code" iconcolor="#919191" bgcolor="#fafafa" color="#000000" iconsize="150"]（コード）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-lightbulb-o" iconcolor="#FFA726" bgcolor="#FFF3E0" color="#000000" iconsize="100"]（ポイント）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-user" iconcolor="#4FC3F7" bgcolor="#E1F5FE" color="#000000" iconsize="150"]（ユーザー）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="st-svg-bigginer_l" iconcolor="#9CCC65" bgcolor="#F1F8E9" color="#000000" iconsize="100"]（初心者）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-exclamation-circle" iconcolor="#919191" bgcolor="#fafafa" color="#000000" iconsize="100"]（注意文グレー）これはダミーです[/st-cmemo]</p>
<p>[st-cmemo fontawesome="fa-exclamation-circle" iconcolor="#ef5350" bgcolor="#ffebee" color="#000000" iconsize="100"]（注意文）これはダミーです[/st-cmemo]</p>
<h4>ミニふきだし</h4>
<p>ショートコードで作成するデザインです。以下はデフォルトで用意されているデザインですが、<span class="huto">自分でカスタマイズ</span>することも可能です。</p>
<p>[st-minihukidashi bgcolor="#f3f3f3" color="#000000" margin="0 0 20px 0"]（基本）これはダミーです[/st-minihukidashi]</p>
<p>[st-minihukidashi bgcolor="#FFB74D" color="#fff" margin="0 0 20px 0"]（オレンジ）これはダミーです[/st-minihukidashi]</p>
<p>[st-minihukidashi bgcolor="#F48FB1" color="#fff" margin="0 0 20px 0"]（ピンク）これはダミーです[/st-minihukidashi]</p>
<p>[st-minihukidashi bgcolor="#4FC3F7" color="#fff" margin="0 0 20px 0"]（ブルー）これはダミーです[/st-minihukidashi]</p>
<p>[st-minihukidashi bgcolor="#7CB342" color="#fff" margin="0 0 20px 0"]（グリーン）これはダミーです[/st-minihukidashi]</p>
<p>[st-minihukidashi bgcolor="#f44336" color="#fff" margin="0 0 20px 0"]（レッド）これはダミーです[/st-minihukidashi]</p>
<h4>複合</h4>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#FFC107" color="#fff" margin="0 0 0 -6px"]自由なメモ[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-file-text-o" iconcolor="#FFC107" bgcolor="#FFFDE7" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#3F51B5" color="#fff" margin="0 0 0 -6px"]ココがポイント[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-hand-o-right" iconcolor="#3F51B5" bgcolor="#E8EAF6" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#3F51B5" color="#fff" margin="0 0 0 -6px"]ココがおすすめ[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-thumbs-o-up" iconcolor="#3F51B5" bgcolor="#E8EAF6" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#3F51B5" color="#fff" margin="0 0 0 -6px"]ココがダメ[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-thumbs-o-down" iconcolor="#3F51B5" bgcolor="#E8EAF6" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#ef5350" color="#fff" margin="0 0 0 -6px"]ココに注意[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-exclamation-circle" iconcolor="#ef5350" bgcolor="#ffebee" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#66BB6A" color="#fff" margin="0 0 0 -8px"]さらに詳しく[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-search" iconcolor="#66BB6A" bgcolor="#E8F5E9" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#F06292" color="#fff" margin="0 0 0 -9px"]◯才女性[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-user" iconcolor="#F06292" bgcolor="#FCE4EC" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<div class="st-editor-margin" style="margin-bottom: -5px;">[st-minihukidashi fontawesome="" fontsize="80" fontweight="" bgcolor="#42A5F5" color="#fff" margin="0 0 0 -9px"]◯才男性[/st-minihukidashi]</div>
<p>[st-cmemo fontawesome="fa-user" iconcolor="#42A5F5" bgcolor="#E3F2FD" color="#000000" iconsize="200"]</p>
<p>これはダミーです</p>
<p>[/st-cmemo]</p>
<h4>複合（アイコンなし）</h4>
<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-file-text-o" fontsize="90" fontweight="bold" bgcolor="#FFC107" color="#fff" margin="0 0 0 0"]自由なメモ[/st-minihukidashi]</div>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#FFFDE7" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-hand-o-right" fontsize="90" fontweight="bold" bgcolor="#3F51B5" color="#fff" margin="0 0 0 0"]ココがポイント[/st-minihukidashi]</div>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8EAF6" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-circle-o" fontsize="90" fontweight="bold" bgcolor="#3F51B5" color="#fff" margin="0 0 0 0"]ココがおすすめ[/st-minihukidashi]</div>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8EAF6" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-times" fontsize="90" fontweight="bold" bgcolor="#3F51B5" color="#fff" margin="0 0 0 0"]ココがダメ[/st-minihukidashi]</div>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8EAF6" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-exclamation-circle" fontsize="90" fontweight="bold" bgcolor="#ef5350" color="#fff" margin="0 0 0 0"]ココに注意[/st-minihukidashi]</div>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#ffebee" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-search" fontsize="90" fontweight="bold" bgcolor="#66BB6A" color="#fff" margin="0 0 0 0"]もっと詳しく[/st-minihukidashi]</div>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E8F5E9" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<div class="st-editor-margin" style="margin-bottom: -20px;">[st-minihukidashi fontawesome="fa-question-circle" fontsize="90" fontweight="bold" bgcolor="#03A9F4" color="#fff" margin="0 0 0 0"]つまづきポイント[/st-minihukidashi]</div>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="" bgcolor="#E1F5FE" borderwidth="0" borderradius="5" titleweight="bold" fontsize=""]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<h4>まるもじ（小）</h4>
<p>丸い背景の文字を作成します。見出しタグの前などに使用するとポイントになりお薦めです。以下はデフォルトで用意されているデザインですが、<span class="huto">自分でカスタマイズ</span>することも可能です。</p>
<p>[st-marumozi fontawesome="" bgcolor="#f3f3f3" color="#000000" radius="30" margin="0 10px 10px 0"]（基本）これはダミーです[/st-marumozi]</p>
<p>[st-marumozi fontawesome="" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 10px 0"]（オレンジ）これはダミーです[/st-marumozi]</p>
<p>[st-marumozi fontawesome="" bgcolor="#F48FB1" color="#fff" radius="30" margin="0 10px 10px 0"]（ピンク）これはダミーです[/st-marumozi]</p>
<p>[st-marumozi fontawesome="" bgcolor="#4FC3F7" color="#fff" radius="30" margin="0 10px 10px 0"]（ブルー）これはダミーです[/st-marumozi]</p>
<p>[st-marumozi fontawesome="fa-exclamation-circle" bgcolor="#ffebee" color="#ef5350" radius="30" margin="0 10px 10px 0"]（うすい注意）これはダミーです[/st-marumozi]</p>
<p>[st-marumozi fontawesome="fa-exclamation-circle" bgcolor="#ef5350" color="#fff" radius="30" margin="0 10px 10px 0"]（注意）これはダミーです[/st-marumozi]</p>
<h4>[st-marumozi fontawesome="" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 0 0"]ポイント[/st-marumozi]これは見出しに使用したサンプル</h4>
<h4>まるもじ（大）</h4>
<p>丸い背景の大きめの文字を作成します。以下はデフォルトで用意されているデザインですが、<span class="huto">自分でカスタマイズ</span>することも可能です。</p>
<p>[st-marumozi-big fontawesome="" bgcolor="#f3f3f3" color="#000000" radius="30" margin="0 10px 10px 0"]基本：これはダミーです[/st-marumozi-big]</p>
<p>[st-marumozi-big fontawesome="" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 10px 0"]（オレンジ）これはダミーです[/st-marumozi-big]</p>
<p>[st-marumozi-big fontawesome="" bgcolor="#F48FB1" color="#fff" radius="30" margin="0 10px 10px 0"]（ピンク）これはダミーです[/st-marumozi-big]</p>
<p>[st-marumozi-big fontawesome="" bgcolor="#4FC3F7" color="#fff" radius="30" margin="0 10px 10px 0"]（ブルー）これはダミーです[/st-marumozi-big]</p>
<p>[st-marumozi-big fontawesome="fa-question-circle" bgcolor="#4FC3F7" color="#fff" radius="30" margin="0 10px 10px 0"]（はてな）これはダミーです[/st-marumozi-big]</p>
<p>[st-marumozi-big fontawesome="fa-check-circle" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 10px 0"]（チェック）これはダミーです[/st-marumozi-big]</p>
<p>[st-marumozi-big fontawesome="fa-check-circle" bgcolor="#FFB74D" color="#fff" radius="30" margin="0 10px 10px 0"]（うすい注意）これはダミーです[/st-marumozi-big]</p>
<p>[st-marumozi-big fontawesome="fa-exclamation-circle" bgcolor="#ef5350" color="#fff" radius="30" margin="0 10px 0 0"]（注意）これはダミーです[/st-marumozi-big]</p>
<h4>カスタムフォント</h4>
<p>カスタムフォントはショートコードでフォントをカスタマイズできます</p>
<p>[st-designfont myclass="" fontawesome="" fontsize="150" fontweight="bold" color="#000" textshadow="" webfont="" margin="0 0 20px 0"]これはダミーです[/st-designfont]</p>
<p>[st-designfont myclass="" fontawesome="" fontsize="150" fontweight="bold" color="#fff" textshadow="#424242" webfont="on" margin="0 0 20px 0"]これはダミーです[/st-designfont]</p>
<h4>ステップ</h4>
<p>「購入の流れ」など<span class="huto">ステップを使用したい場合のデザイン</span>に便利です。カラーなどがカスタマイザーの「オプション」で変更できます</p>
<p>[st-step step_no="1"]お湯を入れる[/st-step]</p>
<p>これはダミーのテキストです</p>
<p>[st-step step_no="2"]3分待つ[/st-step]</p>
<p>これはダミーのテキストです</p>
<p>[st-step step_no="3"]完成です[/st-step]</p>
<p>これはダミーのテキストです</p>
<h4>ポイント</h4>
<p>[st-point fontsize="" fontweight="bold" bordercolor=""]これはダミーのテキストです[/st-point]</p>
<h4>ラベル</h4>
<p>[st-label label="おすすめ" bgcolor="#FBC02D" color="#FFFFFF"]</p>
<p><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" /></p>
<p>[/st-label]</p>
<p>PC（960px以上）Tab（955px〜600px）のレスポンシブ表示となります</p>
<p class="komozi">※コンテンツ内容は「バナーショートコード」で作成しています</p>
<h4>流れる文字</h4>
<div class="st-marquee">
<p>これはダミーですこれはダミーですこれはダミーですこれはダミーですこれはダミーですこれはダミーですこれはダミーですこれはダミーですこれはダミーですこれはダミーです</p>
</div>
<h4>バナー風ボックス</h4>
<p><a href="//affinger5.com/manual/post-5813/">バナー風デザインを作成するショートコード</a></p>
<p>flexボックスを使用した様々なデザインを作成できます。背景画像を指定することで<span class="huto">バナーのようなボタン</span>を作成することも可能です。</p>
<p>[st-flexbox url="" fontawesome="" title="タイトル" width="" height="" color="#fff" fontsize="200" radius="0" shadow="#424242" bordercolor="#ccc" borderwidth="1" bgcolor="#ccc" backgroud_image="" blur="on" left="" margin_bottom="10"]</p>
<p>これはダミーのテキストです</p>
<p>[/st-flexbox]</p>
<h5>サンプル例</h5>
<p>[st-flexbox url="" fontawesome="fa-info-circle" title="詳しい御案内はこちら" height="" color="#fff" fontsize="150" radius="0" shadow="#424242" bordercolor="#ccc" borderwidth="1" bgcolor="" backgroud_image="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" blur="on" left="" margin_bottom="10"]<span style="color: #ffffff;">料金プランやサービスについて</span>[/st-flexbox] [st-flexbox url="" fontawesome="" title="泣ける！<br />
漫画ランキング" width="280" height="250" color="#fff" fontsize="200" radius="5" shadow="#424242" bordercolor="#ccc" borderwidth="1" bgcolor="" backgroud_image="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" blur="" left="" margin_bottom="10"]<span style="color: #ffffff;">本屋さんが選んだ泣けるマンガランキング1位は？</span>[st-mybutton url="#" title="今すぐCHECK" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFD54F" bgcolor_top="#ffdb69" bordercolor="#FFEB3B" borderwidth="1" borderradius="5" fontsize="90" fontweight="bold" width="80" fontawesome_after="fa-angle-right" shadow="#FFB300" ref="on"][/st-flexbox]</p>
<h4>マイボックス</h4>
<p>様々なボックスデザインを作成します。以下はデフォルトで用意されているデザインですが、<span class="huto">自分でカスタマイズ</span>することも可能です。</p>
<p>[st-mybox title="ポイント" fontawesome="fa-check-circle" color="#757575" bordercolor="#BDBDBD" bgcolor="#ffffff" borderwidth="2" borderradius="5" titleweight="bold"]</p>
<p>（基本）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="#ccc" bgcolor="#ffffff" borderwidth="2" borderradius="2" titleweight="bold"]</p>
<p>（しかく枠のみ）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="#BDBDBD" bgcolor="#f3f3f3" borderwidth="0" borderradius="5" titleweight="bold"]</p>
<p>（まるみ）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="参考" fontawesome="fa-file-text-o" color="#757575" bordercolor="" bgcolor="#fafafa" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]</p>
<p>（参考）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="関連" fontawesome="fa-file-text-o" color="#757575" bordercolor="" bgcolor="#fafafa" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]</p>
<p>（関連）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#757575" bordercolor="" bgcolor="#fafafa" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]</p>
<p>（メモ）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="ポイント" fontawesome="fa-check-circle" color="#FFD54F" bordercolor="#FFD54F" bgcolor="#FFFDE7" borderwidth="2" borderradius="5" titleweight="bold"]</p>
<p>（ポイント）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="注意ポイント" fontawesome="fa-exclamation-circle" color="#ef5350" bordercolor="#ef9a9a" bgcolor="#ffebee" borderwidth="2" borderradius="5" titleweight="bold"]</p>
<p>（注意ポイント）これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="はてな" fontawesome="fa-question-circle" color="#03A9F4" bordercolor="#B3E5FC" bgcolor="#E1F5FE" borderwidth="2" borderradius="5" titleweight="bold"]</p>
<p>（はてな）これはダミーです</p>
<p>[/st-mybox]</p>
<h4>マイボックス（+CSSクラス）</h4>
<p>見出し部分を中に変更したデザインです</p>
<p>[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#727272" bordercolor="#ff0000" bgcolor="#FAFAFA" borderwidth="0" borderradius="5" titleweight="bold" title_bordercolor="" fontsize="" myclass="st-mybox-class st-title-under" margin="25px 0 25px 0"]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="メモ" fontawesome="fa-file-text-o" color="#727272" bordercolor="#ff0000" bgcolor="#FAFAFA" borderwidth="0" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under" margin="25px 0 25px 0"]</p>
<p>これはダミーです</p>
<p>[/st-mybox]</p>
<p>[st-mybox title="必要なモノ" fontawesome="fa-file-text-o" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-border st-list-circle" margin="25px 0 25px 0"]</p>
<ul>
	<li>ダミーテキスト</li>
	<li>ダミーテキスト</li>
	<li>ダミーテキスト</li>
</ul>
<p>[/st-mybox]</p>
<p>[st-mybox title="チェックリスト" fontawesome="fa-file-text-o" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-border st-list-check" margin="25px 0 25px 0"]</p>
<ul>
	<li>ダミーテキスト</li>
	<li>ダミーテキスト</li>
	<li>ダミーテキスト</li>
</ul>
<p>[/st-mybox]</p>
<p>[st-mybox title="簡単な流れ" fontawesome="fa-list-ol" color="#757575" bordercolor="#f3f3f3" bgcolor="" borderwidth="3" borderradius="5" titleweight="bold" title_bordercolor="#757575" fontsize="" myclass="st-mybox-class st-title-under st-list-no st-list-border" margin="25px 0 25px 0"]</p>
<ul>
	<li>ダミーテキスト</li>
	<li>ダミーテキスト</li>
	<li>ダミーテキスト</li>
</ul>
<p>[/st-mybox]</p>
<h4>見出し付きフリーボックス</h4>
<p>[st-midasibox title="見出し（全角15文字）" fontawesome="" bordercolor="" color="" bgcolor="" borderwidth="" borderradius="" titleweight="bold"]</p>
<p>これはダミーのテキストです</p>
<p>[/st-midasibox]</p>
<p>[st-midasibox-intitle title="見出し（全角15文字）" fontawesome="" bordercolor="" color="" bgcolor="" borderwidth="" borderradius="" titleweight="bold"]</p>
<p>これはタイトル幅を100%にしたデザインです</p>
<p>[/st-midasibox-intitle]</p>
<h4>メモボックス</h4>
<div class="st-memobox2">
<p class="st-memobox-title">メモ</p>
<p>ここに本文を記述</p>
</div>
<h4>スライドボックス</h4>
<p>[st-slidebox text="+ クリックして下さい" bgcolor="" color="#1a1a1a" margin_bottom="20"]</p>
<p>クリックで開かれる内容です</p>
<p>[/st-slidebox]</p>
<h4>チェックボックス（番号なしリスト）</h4>
<p>[st-square-checkbox bgcolor="" bordercolor="" fontweight="" borderwidth="3"]</p>
<div>
<ul>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ul>
</div>
<p>[/st-square-checkbox]</p>
<h4>こんな方におすすめ（v）</h4>
<p>サイトで効果の高い「こんな方におすすめ」リストも簡単に作成できます。カスタマイザーの「オプション」でカラー変更も可能です。</p>
<div class="st-blackboard">
<p class="st-blackboard-title-box"><span class="st-blackboard-title">こんな方におすすめ</span></p>
<ul class="st-blackboard-list st-no-ck-off">
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ul>
</div>
<p><code>&lt;ul class="st-blackboard-list st-no-ck-off"&gt;</code>の<code>st-no-ck-off</code>を<code>st-no-ck</code>とすることでアイコンを消せます</p>
<div class="st-blackboard">
<p class="st-blackboard-title-box"><span class="st-blackboard-title">本日のメニュー</span></p>
<ul class="st-blackboard-list st-no-ck">
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ul>
</div>
<p>「番号付きリスト（olタグ）」にも対応</p>
<div class="st-blackboard">
<p class="st-blackboard-title-box"><span class="st-blackboard-title">今日のやることリスト</span></p>
<ol class="st-blackboard-list st-no-ck-off">
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ol>
</div>
<h4>こんな方におすすめ[v]</h4>
<div class="st-blackboard square-checkbox">
<p class="st-blackboard-title-box"><span class="st-blackboard-title">こんな方におすすめ</span></p>
<ul class="st-blackboard-list st-no-ck-off">
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ul>
</div>
<h4>ガイドマップメニュー</h4>
<div class="st-link-guide st-link-guide-post">
<ul class="st-link-guide-menu">
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ul>
</div>
<h3>カスタムボタン</h3>
<p>自由なボタンを作成します。幅や色、アイコンなどボタンごとに自由なカスタマイズが可能です。</p>
<h4>ノーマル</h4>
<h5>基本</h5>
<p>[st-mybutton url="#" title="ボタン" rel="" fontawesome="" target="" color="#000000" bgcolor="#FFF" bgcolor_top="" bordercolor="#CCC" borderwidth="3" borderradius="0" fontsize="" fontweight="" width="100" fontawesome_after="" shadow="" ref=""]</p>
<h5>詳しくはコチラ（オレンジ）</h5>
<p>[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFD54F" bgcolor_top="#ffdb69" bordercolor="#FFEB3B" borderwidth="1" borderradius="5" fontsize="" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#FFB300" ref="on"]</p>
<h5>詳しくはコチラ（レッド）</h5>
<p>[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#e53935" bgcolor_top="#f44336" bordercolor="#e57373" borderwidth="1" borderradius="5" fontsize="bold" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#c62828" ref="on"]</p>
<h5>詳しくはコチラ（グリーン）</h5>
<p>[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#43A047" bgcolor_top="#66BB6A" bordercolor="#81C784" borderwidth="1" borderradius="5" fontsize="bold" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#388E3C" ref="on"]</p>
<h5>詳しくはコチラ（ブルー）</h5>
<p>[st-mybutton url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#039BE5" bgcolor_top="#29B6F6" bordercolor="#4FC3F7" borderwidth="1" borderradius="5" fontsize="bold" fontweight="bold" width="" fontawesome_after="fa-angle-right" shadow="#039BE5" ref="on"]</p>
<h5>お問合せ</h5>
<p>[st-mybutton url="#" title="お問合せ" rel="" fontawesome="fa-envelope" target="" color="#fff" bgcolor="#03A9F4" bgcolor_top="#14b4fc" bordercolor="#039BE5" borderwidth="1" borderradius="5" fontsize="" fontweight="" width="90" fontawesome_after="" shadow="#039BE5" ref="on"]</p>
<h5>もっと詳しく（オレンジ）</h5>
<p>[st-mybutton url="#" title="もっと詳しく" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFD54F" bgcolor_top="#ffdb69" bordercolor="#FFEB3B" borderwidth="1" borderradius="30" fontsize="85" fontweight="" width="90" fontawesome_after="fa-angle-right" shadow="" ref="on"]</p>
<h5>もっと詳しく（ピンク）</h5>
<p>[st-mybutton url="#" title="もっと詳しく" rel="" fontawesome="" target="" color="#fff" bgcolor="#F48FB1" bgcolor_top="#f6a6c1" bordercolor="#F48FB1" borderwidth="1" borderradius="30" fontsize="85" fontweight="" width="90" fontawesome_after="fa-angle-right" shadow="" ref="on"]</p>
<h5>もっと詳しく（ブルー）</h5>
<p>[st-mybutton url="#" title="もっと詳しく" rel="" fontawesome="" target="" color="#fff" bgcolor="#4FC3F7" bgcolor_top="#67cbf8" bordercolor="#4FC3F7" borderwidth="1" borderradius="30" fontsize="85" fontweight="" width="90" fontawesome_after="fa-angle-right" shadow="" ref="on"]</p>
<h5>人気ランキング</h5>
<p>[st-mybutton url="#" title="人気ランキング" rel="" fontawesome="st-svg-oukan" target="" color="#fff" bgcolor="#FBC02D" bgcolor_top="#fbc846" bordercolor="#FBC02D" borderwidth="1" borderradius="5" fontsize="110" fontweight="bold" width="90" fontawesome_after="" shadow="" ref="on"]</p>
<h5>ランキングはコチラ(AFFINGER又はEX版のみ）</h5>
<p>[st-mybutton class="" url="#ranking" title="ランキングはコチラ" rel="" fontawesome="fa-angle-double-down" target="" color="#1a1a1a" bgcolor="#fdef4e" bgcolor_top="" bordercolor="#fceb1c" borderwidth="1" borderradius="" fontsize="95" fontweight="" width="" fontawesome_after="" shadow="" ref=""]</p>
<h4>ミニ</h4>
<h5>基本</h5>
<p>[st-mybutton-mini url="#" title="ボタン" rel="" fontawesome="" target="" color="#000000" bgcolor="#f3f3f3" bgcolor_top="" borderradius="3" fontsize="" fontweight="" fontawesome_after="" shadow="#BDBDBD" ref=""]</p>
<h5>詳しくはコチラ（オレンジ）</h5>
<p>[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="" color="#fff" bgcolor="#FFB74D" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#FFB300" ref=""]</p>
<h5>詳しくはコチラ（レッド）</h5>
<p>[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#ef5350" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#f44336" ref=""]</p>
<h5>詳しくはコチラ（グリーン）</h5>
<p>[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#9CCC65" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#8BC34A" ref=""]</p>
<h5>詳しくはコチラ（ブルー）</h5>
<p>[st-mybutton-mini url="#" title="詳しくはコチラ" rel="" fontawesome="" target="_blank" color="#fff" bgcolor="#4FC3F7" bgcolor_top="" borderradius="5" fontsize="" fontweight="" fontawesome_after="fa-angle-right" shadow="#03A9F4" ref=""]</p>
<h4>MCボタン(AFFINGER又はEX版のみ）</h4>
<p>[st-mcbutton url="#" title="今すぐ申し込む" rel="" fontawesome="" target="" color="#fff" bgcolor="#e53935" bgcolor_top="#f44336" bordercolor="#e57373" borderwidth="1" borderradius="5" fontweight="bold" fontsize="120" width="90" fontawesome_after="fa-chevron-right" shadow="#c62828" ref="on" mcbox_bg="#fafafa" mcbox_color="" mcbox_title="太字のテキスト"]※マイクロコピーを書いてみよう[/st-mcbutton]</p>
<h3>会話ふきだし</h3>
<p>「会話ふきだし」は最大8つまで設定でき、1クリックで呼び出すことが可能です</p>
<p>[st-kaiwa1]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa1]</p>
<p>[st-kaiwa2 r]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa2]</p>
<p>[st-kaiwa3]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa3]</p>
<p>[st-kaiwa4 r]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa4]</p>
<p>[st-kaiwa5]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa5]</p>
<p>[st-kaiwa6 r]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa6]</p>
<p>[st-kaiwa7]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa7]</p>
<p>[st-kaiwa8 r]これはダミーのテキストですこれはダミーのテキストです[/st-kaiwa8]</p>
<h4>ランキング見出し(AFFINGER又はEX版のみ）</h4>
<p>[st-rank rankno="1" bgcolor="" color="#000" bordercolor="#ccc" radius="" star="5"]ランキング1位[/st-rank]</p>
<p>[st-rank rankno="2" bgcolor="" color="#000" bordercolor="#ccc" radius="" star="4"]ランキング2位[/st-rank]</p>
<p>[st-rank rankno="3" bgcolor="" color="#000" bordercolor="#ccc" radius="" star="3"]ランキング3位[/st-rank]</p>
<p>[st-rank rankno="4" bgcolor="" color="#000" bordercolor="#ccc" radius="" star="2"]ランキング4位以下[/st-rank]</p>
<h3>レイアウト</h3>
<h4>PCとTab3分割</h4>
<div class="clearfix responbox33">
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_1b7545ca_5651624e6b.jpg" width="100%" /></p>
</div>
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_33114736_3731587338.jpg" width="100%" /></p>
</div>
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_4f347301_57706e626c.jpg" width="100%" /></p>
</div>
</div>
<h4>PCとTab左右40：60%</h4>
<div class="clearfix responbox">
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_1b7545ca_5651624e6b.jpg" width="100%" /></p>
</div>
<div class="rbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_4f347301_57706e626c.jpg" width="100%" /></p>
</div>
</div>
<h4>PCとTab左右50%</h4>
<div class="clearfix responbox50">
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_1b7545ca_5651624e6b.jpg" width="100%" /></p>
</div>
<div class="rbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_4f347301_57706e626c.jpg" width="100%" /></p>
</div>
</div>
<h4>PCとTab左右30：70%</h4>
<div class="clearfix responbox30 smart30">
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_1b7545ca_5651624e6b.jpg" width="100%" /></p>
</div>
<div class="rbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_4f347301_57706e626c.jpg" width="100%" /></p>
</div>
</div>
<h4>全サイズ左右50%</h4>
<div class="clearfix responbox50 smart50">
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_1b7545ca_5651624e6b.jpg" width="100%" /></p>
</div>
<div class="rbox">
<p><img src="https://uploader.xzy.pw/upload/20180628141353_4f347301_57706e626c.jpg" width="100%" /></p>
</div>
</div>
<h4>均等横並び</h4>
<div class="kintou">
<ul>
	<li><img src="https://uploader.xzy.pw/upload/20180628141353_1b7545ca_5651624e6b.jpg" width="100%" /></li>
	<li><img src="https://uploader.xzy.pw/upload/20180628141353_33114736_3731587338.jpg" width="100%" /></li>
	<li><img src="https://uploader.xzy.pw/upload/20180628141353_33114736_3731587338.jpg" width="100%" /></li>
</ul>
</div>
<h4>Div</h4>
<p>任意のクラスを設定するdivを作成します</p>
<h4>マージン</h4>
<p>マージンをつける用のボックスを作成します</p>
<h4>タブ(AFFINGER又はEX版のみ）</h4>
<p>[st-tab-content memo="全体を包むボックスです"][st-input-tab text="タブ1" bgcolor="#fff" color="#1a1a1a" fontweight="" width="45" value="1" checked="checked"][st-input-tab text="タブ2" bgcolor="#fff" color="#1a1a1a" fontweight="" width="45" value="2" checked=""][st-tab-main bgcolor="" bordercolor="" value="1"]</p>
<div style="padding: 20px; background: #fafafa;">
<p>タブ1のコンテンツ</p>
</div>
<p>[/st-tab-main][st-tab-main bgcolor="" bordercolor="" value="2"]</p>
<div style="padding: 20px; background: #fafafa;">
<p>タブ2のコンテンツ</p>
</div>
<p>[/st-tab-main][/st-tab-content]</p>
<h3>その他パーツ</h3>
<h4>スター</h4>
<p>[star5]</p>
<p>[star45]</p>
<p>[star4]</p>
<p>[star35]</p>
<p>[star3]</p>
<p>[star2]</p>
<p>[star1]</p>
<h4>年月（EX版のみ）</h4>
<p>[st-date]</p>
<h4>画像付きコメント(AFFINGER又はEX版のみ）</h4>
<p>[st-user-comment-box title="タイトル" user_text="◯代男性" color="" star="5"]<img class="alignnone size-st_kaiwa_image wp-image-6206" src="https://files-uploader.xzy.pw/upload/20190301193148_5966774258.jpg" alt="" width="60" height="60" />[/st-user-comment-box]</p>
<p>これはダミーのテキストです</p>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="#f3f3f3" bgcolor="#f3f3f3" borderwidth="0" borderradius="5" titleweight="bold" fontsize="" myclass="st-mybox-class" margin="25px 0 25px 0"]</p>
<p>[st-user-comment-box title="タイトル" user_text="◯代男性" color="" star="4"]<img class="alignnone size-st_kaiwa_image wp-image-6206" src="https://files-uploader.xzy.pw/upload/20190301193148_5966774258.jpg" alt="" width="60" height="60" />[/st-user-comment-box]</p>
<p>これはダミーのテキストです</p>
<p>[/st-mybox]</p>
<h4>アドセンス</h4>
<p>ウィジェット<span class="huto">「広告・Googleアドセンスのスマホ用300px」</span>で設定した内容を挿入します</p>
<h4>オリジナルショートコード</h4>
<p>ウィジェット<span class="huto">「オリジナルのショートコード作成ウィジェット」</span>で設定した内容を挿入します</p>
<h4>YouTube</h4>
<p>YouTube動画の貼り付けは直接URLを貼り付ける方法と、IDを指定して「サムネイル画像」リンクとして表示する方法があります。</p>
<h5>URL貼り付け</h5>
<p>https://www.youtube.com/watch?v=2MNL2mU8pBE</p>
<p>自動で<span class="huto">レスポンシブな動画</span>として表示されます。</p>
<h5>IDによるサムネイルリンク</h5>
<p>[youtube id=2MNL2mU8pBE]</p>
<p>サムネイルリンクとして表示することで<span class="huto">複数でも表示が遅くなるのを軽減</span>できます。クリックするとYouTubeに飛んでしまうのが欠点です。</p>
<h4>三角（下矢印）</h4>
<p>カラーを変更できる三角矢印のショートコードです。</p>
<p>[st-under-t color="#000"]</p>
<h4>スクロールナビ(AFFINGER又はEX版のみ）</h4>
<div id="st_listnavi_wrapper">
<ul class="st-sc-listnavi-box">
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
	<li class="st-sc-listnavi"><a href="#">ダミーリンク</a></li>
</ul>
</div>
<h3>記事一覧</h3>
<p>任意の記事の一覧の記事中の好きな位置に表示できます（EX版ではスライドショーにすることも可能）</p>
<h3>カテゴリ一覧</h3>
<p>任意のカテゴリの一覧を所定内であれば好きな位置に表示できます。表示する記事数やカテゴリの除外、閲覧サイズによる列数の指定（3~1）などが可能です。</p>
<p>[st-catgroup cat="0" page="5" order="desc" orderby="id" child="on" slide="off" slides_to_show="3,3,2" slide_date="" slide_more="ReadMore"]</p>
<h4>カテゴリ一覧スライドショー</h4>
<p>上記の一覧を簡易にスライドショーに変えることが可能です。</p>
<p>[st-catgroup cat="0" page="5" order="desc" orderby="id" child="on" slide="on" slides_to_show="3,3,2" slide_date="" slide_more="ReadMore"]</p>
<h3>ショートコード補助</h3>
<h4>Webアイコン</h4>
<p>ショートコードに挿入するためのWebアイコンです（アイコンが直接表示されるわけではございません。ショートコードの引数に使用して下さい）</p>
<h4>アニメーション（クラス）</h4>
<p>ショートコードに挿入するためのCSS用のクラスです（ショートコードの引数に使用して下さい）</p>
<h4>HTMLカラーモード</h4>
<p>ショートコードに挿入するHTMLカラーコードです（カラーが直接表示されるわけではございません。ショートコードの引数に使用して下さい）</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#e53935" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#e53935</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#f44336" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#f44336</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#ffebee" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#ffebee</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#039BE5" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#03A9F4</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#03A9F4" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#03A9F4</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#E1F5FE" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#E1F5FE</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#43A047" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#43A047</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#4CAF50" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#4CAF50</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#E8F5E9" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#E8F5E9</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#FFC107" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#FFC107</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#FFF3E0" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#FFF3E0</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#212121" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#212121</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#424242" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#424242</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#FAFAFA" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#FAFAFA</p>
<p>[/st-flexbox]</p>
<p>[st-flexbox url="" fontawesome="" title="" width="" height="" color="#fff" fontsize="200" radius="0" shadow="" bordercolor="" borderwidth="0" bgcolor="#FFFDE7" backgroud_image="" blur="on" left="" margin_bottom="0"]</p>
<p>#FFFDE7</p>
<p>[/st-flexbox]</p>
<h2>クイックボタン</h2>
<p>エディタの上に表示されているボタンです。クリックするだけでデザインが適応されるので使用頻度の高いものなどを設定しています。</p>
<h4>太字</h4>
<p>選択したテキストに<span class="huto">太字</span>を適応します。テキスト全体の場合は「スタイル」の「太字」をご利用下さい</p>
<h4>太赤</h4>
<p>選択したテキストに<span class="hutoaka">太赤字</span>を適応します。テキスト全体の場合は「スタイル」の「太字」をご利用下さい</p>
<h4>黄細マ</h4>
<p>選択したテキストに<span class="ymarker-s">黄マーカー（細）</span>を適応します</p>
<h4>CT</h4>
<p>選択したテキストや見出しに自動カウントを設定します</p>
<h4>写真枠</h4>
<p>写真に枠線をつけます</p>
<h4>角丸背景</h4>
<p>[st-mybox title="" fontawesome="" color="#757575" bordercolor="#f3f3f3" bgcolor="#f3f3f3" borderwidth="0" borderradius="5" titleweight="bold"]</p>
<p>角丸のマイボックスを設定します。</p>
<p>[/st-mybox]</p>
<h4>ボタンA</h4>
<div class="rankstlink-r2">
<p><a href="#">ボタンA</a></p>
</div>
<p>HTMLでボタンデザインAを挿入します（AFFINGERの場合「ランキング管理」＞「CSS」でカラーを変更できます）</p>
<h4>ボタンB</h4>
<div class="rankstlink-l2">
<p><a href="#">ボタンB</a></p>
</div>
<p>HTMLでボタンデザインBを挿入します（AFFINGERの場合「ランキング管理」＞「CSS」でカラーを変更できます）</p>
<h4>カード</h4>
<p>記事IDを設定することで<span class="huto">内部リンクをブログカード化</span>します</p>
<p>[st-card id=2 label="" name="" bgcolor="" color="" readmore="on"]</p>
HTML;
	}
}

/**
 * 固定ページ
 */

if ( ! function_exists( '_st_example_get_page_content' ) ) {
	function _st_example_get_page_content() {
		// 固定ページの内容 (HTML)
		return <<<'HTML'
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h2>これはh2タグの見出しです</h2>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h3><span class="st-h-copy">こんなキャッチコピーも</span>これはh3タグの見出しです</h3>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h4>これはh4タグの見出しです</h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h4>これはh4タグの見出しです</h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h5>これはh5タグの見出しです</h5>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h5>これはh5タグの見出しです</h5>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h2>これはh2タグの見出しです<span class="st-h-copy">下にキャッコピー</span></h2>
<h3>これはh3タグの見出しです</h3>
<p><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" /></p>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<blockquote>
<p>これは抜粋のダミーですこれは抜粋のダミーですこれは抜粋のダミーですこれは抜粋のダミーです</p>
</blockquote>
<h3>これはh3タグの見出しです</h3>
<h4>これはh4タグの見出しです</h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<div class="scroll-box">
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 25%;">ダミーのテキスト</td>
<td style="width: 25%;">ダミーのテキスト</td>
<td style="width: 25%;">ダミーのテキスト</td>
<td style="width: 25%;">ダミーのテキスト</td>
</tr>
<tr>
<td style="width: 25%;">ダミーのテキスト</td>
<td style="width: 25%;">ダミーのテキスト</td>
<td style="width: 25%;">ダミーのテキスト</td>
<td style="width: 25%;">ダミーのテキスト</td>
</tr>
</tbody>
</table>
</div>
<h5>これはh5タグの見出しです</h5>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h5>これはh5タグの見出しです</h5>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h4>これはh4タグの見出しです</h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h5>これはh5タグの見出しです</h5>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h5>これはh5タグの見出しです</h5>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h2>これはh2タグの見出しです</h2>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h3>これはh3タグの見出しです</h3>
<div class="clearfix responbox50 smart50">
<div class="lbox">
<p><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" /></p>
</div>
<div class="rbox">
<p><img src="https://uploader.xzy.pw/upload/20180627174715_85e84826_447237556d.jpg" /></p>
</div>
</div>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<ul>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ul>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<ol>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ol>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h3>これはh3タグの見出しです</h3>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<div class="maruck">
<ul>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ul>
</div>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<div class="maruno">
<ol>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
	<li>これはダミーのテキストです</li>
</ol>
</div>
<h4><span class="st-count">これはh4タグに「カウント」を設定しています</span></h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h4><span class="st-count">これはh4タグに「カウント」を設定しています</span></h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h4><span class="st-count">これはh4タグに「カウント」を設定しています</span></h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
<h4 class="st-matome">これは「まとめ用」の見出しです</h4>
<p>これはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストですこれはダミーのテキストです</p>
HTML;
	}
}

// 生成
if ( ! function_exists( '_st_example_create_post' ) ) {
	function _st_example_create_post() {
		// 投稿の属性
		$postattr = array(
			'post_content' => _st_example_get_post_content(),
			'post_title'   => '記事作成パーツ確認用ダミーページ',    // タイトル
			'post_status'  => 'draft',    // 公状態 (draft = 下書き, publish = 公開, private = 非公開)
			'post_name'    => 'st-example-post',    // スラッグ
		);

		$post_id = wp_insert_post( $postattr );

		return ( $post_id !== 0 );
	}
}

if ( ! function_exists( '_st_example_create_page' ) ) {
	function _st_example_create_page() {
		// 固定ページの属性
		$postattr = array(
			'post_content' => _st_example_get_page_content(),
			'post_title'   => '基本文の見やすさチェック用ダミーページ',    // タイトル
			'post_status'  => 'draft',    // 公状態 (draft = 下書き, publish = 公開, private = 非公開)
			'post_type'    => 'page',
			'post_name'    => 'st-example-page',    // スラッグ
		);

		$post_id = wp_insert_post( $postattr );

		return ( $post_id !== 0 );
	}
}

if ( ! function_exists( '_st_example_create_posts' ) ) {
	function _st_example_create_posts() {
		$states = _st_example_get_states();

		// 作成済み
		if ( $states['post'] && $states['page'] ) {
			return;
		}

		// 投稿
		if ( ! $states['post'] ) {
			$states['post'] = _st_example_create_post();
		}

		// 固定ページ
		if ( ! $states['page'] ) {
			$states['page'] = _st_example_create_page();
		}

		_st_example_update_states( $states );
	}
}

if ( ! function_exists( '_st_example_upgrader_post_install' ) ) {
	function _st_example_upgrader_post_install( $response, $hook_extra, $result ) {
		$type             = isset( $hook_extra['type'] ) ? $hook_extra['type'] : '';    // インストール/ファイルアップロード時
		$theme            = isset( $hook_extra['theme'] ) ? $hook_extra['theme'] : '';    // アップデート時
		$destination_name = isset( $result['destination_name'] ) ? $result['destination_name'] : '';

		/** @var WP_Theme $current_theme */
		$current_theme    = wp_get_theme();
		$current_template = $current_theme->get_template();
		$is_target        = ( $type === 'theme' && $destination_name === $current_template ) ||    // インストール/ファイルアップロード時
		                    ( $theme === $current_template );    // アップデート時

		if ( ! $is_target ) {
			return;
		}

		_st_example_create_posts();
	}
}

add_action( 'after_switch_theme', '_st_example_create_posts' );
add_filter( 'upgrader_post_install', '_st_example_upgrader_post_install', 10, 3 );
