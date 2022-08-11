@chaset "UTF-8";

<?php
/**
 * ブロックエディター用スタイル
 *
 * セレクターの頭に .editor-styles-wrapper をつけて記述する。
 */

$st_is_ex    = st_is_ver_ex();
$st_is_af    = st_is_ver_af();
$st_is_st    = st_is_ver_st();
$st_is_ex_af = st_is_ver_ex_af();

function _st_block_editor_style_scope_root_styles( $component_selector ) {
	?>
	.editor-styles-wrapper <?php echo $component_selector; ?> p {
		margin: 0;
		padding: 0;
	}
	<?php
}
?>

.block-editor-writing-flow {
    height: auto;
}

.editor-styles-wrapper,
.editor-post-title__block .editor-post-title__input {
	font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue,Hiragino Kaku Gothic ProN', 'メイリオ', meiryo, sans-serif !important;
	counter-reset: stcnt;
}

.edit-post-text-editor,
.wp-block {
	<?php if ( isset ( $GLOBALS['stdata433'] ) && $GLOBALS['stdata433'] > 200 ): // 投稿画面の幅
		$wp_block_width = intval( $GLOBALS['stdata433'] ). 'px';
	else:
		$wp_block_width = '100%';
	endif;
	?>
	max-width: <?php echo $wp_block_width; ?>;
	min-width: 200px;
}

.editor-post-title,	/* コードエディター */
.block-editor-block-list__layout {	/* ビジュアルエディター */
	padding-left: 0!important;
	padding-right: 0!important;
}

.edit-post-layout__content {
	padding-left: 46px;
	padding-right: 46px;
}

/* mceボタンのテキスト位置調整 */
.mce-container, .mce-container *, .mce-widget, .mce-widget *, .mce-reset {
	vertical-align: middle!important;
}

/* 記事タイトル */
.editor-post-title {
	/* コードエディター */
	font-size: 2em!important;
	margin-bottom: 20px;
}

.editor-post-title__block .editor-post-title__input {
	/* ビジュアルエディター */
	font-size: 2em!important;
	border-bottom: 1px solid #ebebeb;
	margin-bottom: 20px;
}

<?php if ( isset ( $GLOBALS['stdata431']) && $GLOBALS['stdata431'] === 'yes' ): // ブロック追加ボタンを常に表示 ?>
	/* ブロックを追加ボタン */
	.block-editor-block-list__insertion-point-inserter {
		opacity: 0.7!important;
	}

	.block-editor-block-list__insertion-point-inserter:hover {
		opacity: 1!important;
	}

	.block-editor-block-list__insertion-point-inserter .block-editor-inserter__toggle {
		color: #ebebeb;
	}
<?php endif; ?>

/*--------------------------------
editor-style.css
---------------------------------*/

.editor-styles-wrapper .mce-content-body div {
	padding:10px;
	border:1px #ccc dotted;
	margin-bottom:10px;
}

.editor-styles-wrapper pre {
	background: #fafafa;
	padding: 20px;
	margin-bottom: 20px;
}

/* TinyMCE Advanced調整 */
.mce-toolbar-grp .mce-flow-layout-item {
    display: block;
}

.editor-styles-wrapper .st-animate::before {
	content: '動';
	color: #fff;
	font-size:80%;
	background: #81D4FA;
	font-weight: normal;
	padding:1px 3px;
}

.editor-styles-wrapper .ephox-snooker-resizer-bar {
    margin: 0;
    padding: 0;
}

/* 挿入アイコン2 */
.editor-styles-wrapper .hatenamark2:before {
   	content: "\f059";
  	font-family: FontAwesome;
	margin-right:7px;
}

.editor-styles-wrapper .attentionmark2:before {
   	content: "\f06a";
  	font-family: FontAwesome;
	margin-right:7px;
}

.editor-styles-wrapper .usermark2:before {
   	content: "\f2bd";
  	font-family: FontAwesome;
	margin-right:7px;
}

.editor-styles-wrapper .memomark2:before {
   	content: "\f044";
  	font-family: FontAwesome;
	margin-right:7px;
}

.editor-styles-wrapper .checkmark2:before {
   	content: "\f058";
  	font-family: FontAwesome;
	margin-right:7px;
}

.editor-styles-wrapper .bigginermark:before {
   	content: "\e904";
	font-family: stsvg;
	margin-right:7px;
}

.editor-styles-wrapper .oukanmark:before {
   	content: "\e909";
	font-family: stsvg;
	margin-right:7px;
}

.editor-styles-wrapper .fa-question-circle, 
.editor-styles-wrapper .fa-check-circle, 
.editor-styles-wrapper .fa-exclamation-triangle, 
.editor-styles-wrapper .fa-exclamation-circle, 
.editor-styles-wrapper .fa-pencil-square-o,
.editor-styles-wrapper .fa-user,
.editor-styles-wrapper .st-svg-biggner:before{
	margin-right:7px;
}

/*カウント*/
.editor-styles-wrapper .st-count {
	counter-increment: stcnt;
}

.editor-styles-wrapper .st-count::before {
	content: counter(stcnt)". ";
	font-size:150%;
}

.editor-styles-wrapper .st-count-reset {
	counter-reset: stcnt;
}

/* editor-style用初心者マークカラー */
.editor-styles-wrapper .st-svg-biggner {
 	position:relative;
}
.editor-styles-wrapper .st-svg-biggner:before {
  margin-right:7px;
}

/*スライドボックス*/
.editor-styles-wrapper .st-slidebox-c {
	padding: 10px 20px; 
	background: #f2f2f2;
	margin-bottom:20px;
	border-radius:5px;
}
.editor-styles-wrapper .st-btn-open{
	margin-bottom:10px;
}
.editor-styles-wrapper .st-slidebox{
	padding-top:10px;
}

.editor-styles-wrapper .st-slidebox p:last-child{
	margin-bottom:0;
}

/*メモボックス*/
.editor-styles-wrapper .st-memobox2 {
	position: relative;
    margin: 20px 0;
	padding: 20px 20px 0;
	border: solid 1px #9E9E9E;
	border-radius: 0;
}

.editor-styles-wrapper .st-memobox2 .fa {
	margin-right: 5px;
}

.editor-styles-wrapper .st-memobox2 .st-memobox-title {
	position: absolute;
	display: inline-block;
	top: -8px;
	left: 10px;
	padding: 0 9px;
	line-height: 1;
	background: #FFF;
	color:#000;
	font-weight:normal;
	font-size:90%;
}

.editor-styles-wrapper .st-memobox2 .st-memobox-title:before {
  	content: "\f0f6\00a0";
  	font-family: FontAwesome;
}
/*旧メモボックス*/
.editor-styles-wrapper .st-memobox {
	position: relative;
    margin: 20px 0;
	padding: 20px 20px 0;
	border: solid 2px #9E9E9E;
	border-radius: 8px;
}

.editor-styles-wrapper .st-memobox .fa {
	margin-right: 5px;
}

.editor-styles-wrapper .st-memobox .st-memobox-title {
	position: absolute;
	display: inline-block;
	top: -8px;
	left: 10px;
	padding: 0 9px;
	line-height: 1;
	background: #FFF;
	color:#9E9E9E;
	font-weight:bold;
}

/*参照リンク*/
.editor-styles-wrapper .st-share {
  	background:#fafafa;
	padding:5px;
	border-radius:3px;
	font-size:95%;
	line-height:1.7;
}
.editor-styles-wrapper .st-share:before {
  	content: "\00a0\00a0\f0c1\00a0\00a0\00a0";
  	font-family: FontAwesome;
	color:#9E9E9E;
}

/* こんな方におすすめ */
.editor-styles-wrapper .st-blackboard {
	padding: 10px 20px 0px; 
	border: 3px solid #f3f3f3;
	background: #fff;
  	margin: 30px 0;
  	border-radius:0;
}

.editor-styles-wrapper .st-blackboard-title-box {
	text-align: center; 
	margin-bottom:10px;
}

.editor-styles-wrapper .st-blackboard-title {
	color:#424242;
	display: inline-block;
	border-bottom:2px solid #424242;
	font-weight: bold; 
	text-align: center; 
	padding:10px 10px 5px;
	background:#fff;
}

.editor-styles-wrapper .st-blackboard-title:before {
  	content: "\f0f6\00a0\00a0";
  	font-family: FontAwesome;
}

.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ol.st-blackboard-list:not(.st-css-no){
	padding-left: 20px;
}

.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list:not(.st-css-no) {
	padding-left: 30px;
}

.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list:not(.st-css-no) li,
.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list:not(.st-css-no) li:last-child {
	border-bottom:dotted 1px #ccc;
  	line-height:1.3;
	padding:10px 0;
	margin:0;
	list-style:none;
	text-indent:-1.3em;
	padding-left:1.3em;
}

.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ol.st-blackboard-list:not(.st-css-no) li,
.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ol.st-blackboard-list:not(.st-css-no) li:last-child {
	border-bottom:dotted 1px #ccc;
  	line-height:1.3;
	padding:10px 0;
	margin:0;
}

.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list:not(.st-css-no) li:before {
  	content: "\f058\00a0\00a0";
  	font-family: FontAwesome;
	color:#ff0000;
}

.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list:not(.st-css-no).st-no-ck li,
.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list:not(.st-css-no).st-no-ck li:last-child {
	text-indent:0;
	padding-left:0;
}

.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list.st-no-ck li:before {
  	content: none;
}

/* こんな方におすすめ（チェックボックス） */
.editor-styles-wrapper .st-blackboard.square-checkbox {
	padding:30px 30px 15px;
	box-sizing: border-box;
	margin-bottom:20px;
}

.editor-styles-wrapper .st-blackboard.square-checkbox ul li {
	position:relative;
	display: block;
	line-height: 1.5;
	border-bottom: 1px dashed #ccc;
	margin-bottom: 0.5em;
	padding-top: .25em;
	padding-bottom: 0.75em;
	padding-left: calc(1.5em + 15px);
}

.editor-styles-wrapper .st-blackboard.square-checkbox ul:not(.toc_list):not(.st_toc_list):not(.children) {
	display: block;
	margin-bottom: 0;
	padding:10px 0 0;
}

.editor-styles-wrapper .st-blackboard.square-checkbox ul li:last-child {
	margin-bottom: 15px;
	padding-bottom: 0.75em;
}

.editor-styles-wrapper .st-blackboard.square-checkbox ul.st-blackboard-list:not(.st-css-no) li:before {
	position: absolute;
	top: calc(50% - .95em);
	left: 0;
	content: "\e907";
	font-family: stsvg;
	color:#ff0000;
	z-index:2;
	margin-right:15px;
	text-shadow: -1px -1px 0 rgba(255, 255, 255, 1),1px -1px 0 rgba(255, 255, 255, 1),-1px 1px 0 rgba(255, 255, 255, 1),1px 1px 0 rgba(255, 255, 255, 1);
	font-size:150%;
	line-height:1.5;
}

.editor-styles-wrapper .st-blackboard.square-checkbox ul li:after {
	content: "\e904";
	font-family: stsvg;
	color:#ccc;
	position:absolute;
	z-index:1;
	left:0;
	top: calc(50% - .9em);
	font-size:150%;
	line-height:1.5;
}

/* チェックボックス */
.editor-styles-wrapper .st-square-checkbox:not(.st-square-checkbox-nobox) {
    border: 3px solid #f3f3f3;
	padding:30px 30px 15px;
	box-sizing: border-box;
	margin-bottom:20px;
}

.editor-styles-wrapper .st-square-checkbox.st-square-checkbox-nobox ul li:last-child,
.editor-styles-wrapper .st-square-checkbox.st-square-checkbox-nobox ul li:last-child {
	margin-bottom: 0;
}

.editor-styles-wrapper .st-square-checkbox div {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: inherit;
	line-height: inherit;
}

.editor-styles-wrapper .post ul.is-style-st-square-checkbox:not(.toc_list):not(.st_toc_list):not(.children):not(.slick-dots):not(.st-pvm-nav-list),
.editor-styles-wrapper ul.is-style-st-square-checkbox:not(.toc_list):not(.st_toc_list):not(.children):not(.slick-dots):not(.st-pvm-nav-list),
.editor-styles-wrapper .st-square-checkbox ul:not(.toc_list):not(.st_toc_list):not(.children) {
	margin-bottom: 0;
	padding:0;
}

.editor-styles-wrapper .st-square-checkbox.st-bold ul li {
	font-weight: bold;
}

.editor-styles-wrapper ul.is-style-st-square-checkbox li,
.editor-styles-wrapper .st-square-checkbox ul li {
	position:relative;
	display: block;
	line-height: 1.5;
	border-bottom: 1px dashed #ccc;
	margin-bottom: 0.5em;
	padding-top: .25em;
	padding-bottom: 0.75em;
	padding-left: calc(1.5em + 15px);
}

.editor-styles-wrapper ul.is-style-st-square-checkbox li:last-child,
.editor-styles-wrapper .st-square-checkbox ul li:last-child {
	margin-bottom: 15px;
	padding-bottom: 0.5em;
}

.editor-styles-wrapper ul.is-style-st-square-checkbox li:before,
.editor-styles-wrapper .st-square-checkbox ul li:before {
	position: absolute;
	top: calc(50% - .95em);
	left: 0;
	content: "\e907";
	font-family: stsvg;
	color:#ff0000;
	z-index:2;
	margin-right:15px;
	text-shadow: -1px -1px 0 rgba(255, 255, 255, 1),1px -1px 0 rgba(255, 255, 255, 1),-1px 1px 0 rgba(255, 255, 255, 1),1px 1px 0 rgba(255, 255, 255, 1);
	font-size:150%;
	line-height:1.5;
}

.editor-styles-wrapper ul.is-style-st-square-checkbox li:after,
.editor-styles-wrapper .st-square-checkbox ul li:after {
	content: "\e904";
	font-family: stsvg;
	color:#ccc;
	position:absolute;
	z-index:1;
	left:0;
	top: calc(50% - .9em);
	font-size:150%;
	line-height:1.5;
}

/* カスタムボタン: マイボタン */
.editor-styles-wrapper .st-mybtn {
	box-sizing: border-box;
	margin-left: auto;
	margin-right: auto;
	display: block;
}

.editor-styles-wrapper .st-mybtn:not(.st-mybtn-noborder) {
	border: 1px solid #ccc;
}

.editor-styles-wrapper .st-mybtn a {
	padding: 10px;
	text-align: center;
	box-sizing: border-box;
	display: block;
	width: 100%;
	height: 100%;
	text-decoration: none;
}

.editor-styles-wrapper .st-mybtn .fa:not(.fa-after) {
	margin-right: 10px;
}

.editor-styles-wrapper .st-mybtn .fa.fa-after {
	margin-left: 10px;
}

.editor-styles-wrapper .st-mybtn:hover {
	opacity: 0.6;
}

.editor-styles-wrapper .st-mybtn.st-btn-default {
	width: 100%;
}

.editor-styles-wrapper .st-mybtn.wp-block-st-blocks-my-button {
	color: #ffffff;
	border: 0 solid #757575;
	background-color: #e6514c;
	border-radius: 5px;
	box-shadow: 0 3px 0 #d9251f;
}

.editor-styles-wrapper .st-mybtn.wp-block-st-blocks-my-button a {
	color: #ffffff;
}

/* 光る演出 */
.editor-styles-wrapper .st-reflection-on:not(.no-reflection),
.editor-styles-wrapper .st-mybtn.st-reflection:not(.no-reflection) a {
	position: relative;
	overflow: hidden;
}

.editor-styles-wrapper .st-reflection-on:not(.no-reflection):after,
.editor-styles-wrapper .st-mybtn.st-reflection:not(.no-reflection) a:after {
	content: '';
	height: 100%;
	width: 30px;
	position: absolute;
	top: -180px;
	left: 0;
	background-color: #fff;
	opacity: 0;
	-webkit-transform: rotate(45deg);
	-webkit-animation: reflection 5s ease-in-out infinite;
}

@-webkit-keyframes reflection {
	0% { -webkit-transform: scale(0) rotate(45deg); opacity: 0; }
	80% { -webkit-transform: scale(0) rotate(45deg); opacity: 0.5; }
	81% { -webkit-transform: scale(4) rotate(45deg); opacity: 1; }
	100% { -webkit-transform: scale(50) rotate(45deg); opacity: 0; }
}

/* 目次（カスタム） */
.editor-styles-wrapper #st_toc_container {
	border: 1px solid #fafafa;
	box-sizing: border-box;
	margin: 0 auto 20px;
	padding: 10px 20px;
	text-align: center;
	border-radius: 5px;
}

.editor-styles-wrapper #st_toc_container .st_toc_title {
	text-align:center;
	padding: 5px;
	font-weight:bold;
	position:relative;
 	display: inline-block;
	vertical-align: middle;
	border-bottom: 2px solid #333;
	margin-bottom: 5px;
}

.editor-styles-wrapper #st_toc_container .st_toc_title:before {
  	content: "\f0f6\00a0";
  	font-family: FontAwesome;
}

.editor-styles-wrapper #st_toc_container .st-original-toc li {
	text-align:left;
	font-weight: normal;
	padding: 5px;
	text-indent: 0;
	border-bottom: 1px dotted #ccc;
}

.editor-styles-wrapper #st_toc_container ol.st-original-toc > li {
	list-style: decimal;
}

.editor-styles-wrapper #st_toc_container .st-original-toc li a:before {
  	content: none;
}

.editor-styles-wrapper #st_toc_container .st-original-toc li a {
	text-decoration: none;
	color: #000;
}

.editor-styles-wrapper #st_toc_container .st-original-toc li a:hover {
	opacity: 0.5;
}

/*マイボックスメモ*/
.editor-styles-wrapper .st-mybox {
	position: relative;
	margin: 20px 0;
	padding: 0 20px;
	border: solid 2px #9E9E9E;
	border-radius: 0;
}

.editor-styles-wrapper .wp-block-st-blocks-my-box.st-mybox { /* Gutenberg */
	border-radius: 5px;
}

.editor-styles-wrapper .st-in-mybox {
	padding: 20px 0;
}

.editor-styles-wrapper .st-in-mybox p {
	margin-bottom: 0;
}

.editor-styles-wrapper .st-mybox .fa {
	margin-right: 5px;
}

.editor-styles-wrapper .st-mybox .st-mybox-title {
	position: absolute;
	display: inline-block;
	top: -8px;
	left: 10px;
	padding: 0 10px;
	line-height: 1;
	color:#9E9E9E;
	font-weight:bold;
	margin-bottom:10px;
}

/** 見出しを下に */
.editor-styles-wrapper .st-mybox.st-title-under .st-mybox-title {
    margin: relative;
    display: inline-block;
    padding: 20px 0 0;
    margin-bottom: 10px;
	top: 0;
	left: 0;
	text-shadow: none!important;
}

/** 見出しにボーダー */
.editor-styles-wrapper .st-mybox.st-title-border .st-mybox-title {
    padding-bottom: 10px;
	border-bottom: 2px solid #ccc;
}

.editor-styles-wrapper .st-mybox.st-title-under .st-in-mybox {
    padding: 0 0 20px;
}

/** 見出し下 + 見出しにボーダー */
.editor-styles-wrapper .st-mybox.st-title-border.st-title-under .st-mybox-title {
    padding-bottom: 10px;
	margin-bottom: 20px;
}

/** 見出しにボーダー ※見出し下ではない  */
.editor-styles-wrapper .st-mybox.st-title-border:not(.st-title-under) .st-in-mybox {
    padding-top: 35px;
}

.editor-styles-wrapper .st-mybox.st-title-border:not(.st-title-under) .st-mybox-title {
    padding-left: 10px;
	padding-right: 10px;
	left: 20px;
}

.editor-styles-wrapper .free-inbox {
	padding:10px 15px 10px;
	text-align:left;
}

.editor-styles-wrapper .free-inbox p {
	margin-bottom: 0;
}

/**見出し付ボックス（タイトル幅100%ver）*/
.editor-styles-wrapper .freebox.freebox-intitle,
.editor-styles-wrapper .freebox-intitle {
	border-top:none;
	padding-top: 0;
}

.editor-styles-wrapper .freebox-intitle .p-free {
	margin-bottom: 0;
}

.editor-styles-wrapper .freebox-intitle .p-free:after {
	content: none;
}

.editor-styles-wrapper .freebox-intitle .p-entry-f {
	padding:6px 20px;
	margin:0;
	font-size:15px;
	font-weight:bold;
	background:#FEB20A;
	color:#fff;
	position:relative;
	max-width:100%;
	display: block;
	text-align: center;
	border-bottom-right-radius: 0!important;
}

/*クリップメモ*/
.editor-styles-wrapper .clip-memobox {
	display:table;
	background:#f3f3f3;
	border-radius:3px;
	margin-bottom:20px;
	padding: 10px;
}
.editor-styles-wrapper .clip-fonticon,
.editor-styles-wrapper .clip-memotext{
	display:table-cell;
	vertical-align:middle;
}

.editor-styles-wrapper .clip-fonticon{
	padding: 0 15px 0 10px;
	text-align:center;
}

.editor-styles-wrapper .clip-memotext p{
	margin-bottom:0;
}

.editor-styles-wrapper .clip-memotext {
	padding-left:15px;
	border-left:1px solid #E0E0E0;
	width:100%;
	box-sizing:border-box;
}

/*参照リンク*/
.editor-styles-wrapper .st-share {
  	background:#fafafa;
	padding:5px;
	border-radius:3px;
	font-size:95%;
	line-height:1.7;
}
.editor-styles-wrapper .st-share:before {
  	content: "\00a0\00a0\f0c1\00a0\00a0\00a0";
  	font-family: FontAwesome;
	color:#9E9E9E;
}

/* 記事タイトル */
.editor-styles-wrapper .entry-title, .entry-title {
	font-family: Helvetica , "游ゴシック", "Yu Gothic", sans-serif;
	margin-bottom: 10px;
	font-weight:bold;
}

/*自動アイコン目印*/
.editor-styles-wrapper .hatenamark,.checkmark,.attentionmark,.memomark,.usermark {
	background-color: rgba(135,206,250,0.5);
}

/* clearfix */
.editor-styles-wrapper .clearfix {
	zoom: 1;
}

.editor-styles-wrapper .clearfix:after {
	content: "";
	display: block;
	clear: both;
}

.editor-styles-wrapper .clear {
	clear: both;
}

.editor-styles-wrapper .center {
	text-align: center;
}

/* リンクの色 */
.editor-styles-wrapper a {
	color: #4682b4;
}

/* リンクにマウスオーバーした時の色 */
.editor-styles-wrapper a:hover {
	color: #b22222;
}

/*画像にボーダー*/
.editor-styles-wrapper .is-style-st-photoline img,
.editor-styles-wrapper .photoline img{
	border: solid 1px #ccc;
}

/*写真風*/
.editor-styles-wrapper .is-style-st-photohu,
.editor-styles-wrapper .st-photohu {
	background:#fff;
  	border:1px solid #ccc;
    padding:10px 10px 20px;
    margin-bottom:20px;
    box-shadow: 0 10px 8px -6px #bebebe;
	display: inline-block;
	max-width:100%;
	box-sizing: border-box;
}

.editor-styles-wrapper .st-photohu p.wp-caption-text {
  	margin-bottom:-10px;
}

.editor-styles-wrapper .is-style-st-photohu.wp-block-image figcaption {
  	margin-bottom: 0;
}

.editor-styles-wrapper .st-photohu div img,
.editor-styles-wrapper .is-style-st-photohu, div img {
  margin-bottom:5px;
  border:1px solid #ccc;
}

.editor-styles-wrapper img,
.editor-styles-wrapper video,
.editor-styles-wrapper object {
    max-width: 100%;
    height: auto;
    border: none;
    vertical-align: bottom;
}

.editor-styles-wrapper .inline-img img {
	display: inline;
}

.editor-styles-wrapper iframe {
	max-width: 100%;
}

.editor-styles-wrapper .st-code,
.editor-styles-wrapper code {
	padding:2px;
	background:#f3f3f3;
	margin:2px;
	border-radius:2px;
}

/* iframeのレスポンシブ */
.editor-styles-wrapper .youtube-container {
	position: relative;
	padding-bottom: 56.25%;
	padding-top: 30px;
	height: 0;
	overflow: hidden;
}

.editor-styles-wrapper .youtube-container iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}

/*レスポンシブ用PC左右コンテンツ*/
.editor-styles-wrapper .responbox,
.editor-styles-wrapper .responbox30,
.editor-styles-wrapper .responbox40,
.editor-styles-wrapper .responbox50,
.editor-styles-wrapper .responbox60,
.editor-styles-wrapper .responbox70,
.editor-styles-wrapper .responboxfree {
	padding:10px;
	background:#f3f3f3;
	margin-bottom:20px;
}

.editor-styles-wrapper .responbox .lbox img {
	width:100%;
	box-sizing:border-box;
	margin-bottom:10px;
}

/*--------------------------------
各フォント設定
---------------------------------*/
/* 基本の文字 */
.editor-styles-wrapper div,
.editor-styles-wrapper p {
	font-size: 16px;
	line-height: 25px;
}

/*リスト */
.editor-styles-wrapper .mce-content-body ul {
	list-style-type: disc;
	padding-top: 10px;
	padding-right: 20px;
	padding-bottom: 10px;
	padding-left: 30px;
	margin-bottom: 20px;
}

.editor-styles-wrapper .mce-content-body ol {
	list-style-type: decimal;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 20px;
	padding-left: 30px;
	margin-bottom: 20px;
}

.editor-styles-wrapper .mce-content-body ul li,
.editor-styles-wrapper .mce-content-body ol li {
	font-size: 16px;
	line-height: 27px;
}

/* 中見出し */
.editor-styles-wrapper .h2modoki,
.editor-styles-wrapper h2 {
	position: relative;
	background: #f3f3f3;
	color: #1a1a1a;
	font-size: 20px;
	line-height: 27px;
	margin-bottom: 20px;
	padding-top: 10px;
	padding-right: 20px;
	padding-bottom: 10px;
	padding-left: 20px;
}

.editor-styles-wrapper .h2modoki:after,
.editor-styles-wrapper h2:after {
	content: '';
	position: absolute;
	border-top: 10px solid #f3f3f3;
	border-right: 10px solid transparent;
	border-left: 10px solid transparent;
	bottom: -10px;
	left: 30px;
	border-radius: 2px;
}

.editor-styles-wrapper .h2modoki:before,
.editor-styles-wrapper h2:before {
	content: '';
	position: absolute;
	border-top: 10px solid #f3f3f3;
	border-right: 10px solid transparent;
	border-left: 10px solid transparent;
	bottom: -10px;
	left: 30px;
}

/*小見出し*/

.editor-styles-wrapper .h3modoki,
.editor-styles-wrapper h3 {
	font-size: 18px;
	margin-bottom: 20px;
	margin-top: 10px;
	padding-top: 15px;
	padding-right: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	color: #1a1a1a;
	line-height: 27px;
	background-repeat: no-repeat;
	background-position: left center;
	margin-left: 0px;
	border-bottom: 1px #999999 dotted;
}

.editor-styles-wrapper .h3modoki a,
.editor-styles-wrapper h3 a {
	color: #333;
	text-decoration: none;
}

.editor-styles-wrapper .h4modoki,
.editor-styles-wrapper h4 {
	padding: 10px 15px;
	margin-bottom: 20px;
	background-color: #f3f3f3;
	line-height: 24px;
}

.editor-styles-wrapper .h5modoki,
.editor-styles-wrapper .h6modoki,
.editor-styles-wrapper h5, /* H5 */
.editor-styles-wrapper h6 /* H6 */
 {
	margin-bottom: 20px;
	font-size: 16px;
}

.editor-styles-wrapper .h6modoki,
.editor-styles-wrapper h6 /* H6 */
 {
	font-weight:bold;
	color:#424242;
}

.editor-styles-wrapper .h2modoki,
.editor-styles-wrapper .h3modoki,
.editor-styles-wrapper .h4modoki,
.editor-styles-wrapper .h5modoki,
.editor-styles-wrapper .h6modoki
 {
	font-weight:bold;
}

/* hタグ用 キャッチコピー */
.editor-styles-wrapper .st-h-copy-toc,
.editor-styles-wrapper .st-h-copy {
	display: block!important;
	font-weight: normal!important;
	font-size: 65%;
	line-height: 1.3;
}

/* 引用 */
.editor-styles-wrapper blockquote {
	background-color: #f3f3f3;
	background-image: url(images/quote.png);
	background-repeat: no-repeat;
	background-position: left top;
	padding-top: 50px;
	padding-right: 20px;
	padding-bottom: 20px;
	padding-left: 20px;
	margin-top: 20px;
	margin-right: 0px;
	margin-bottom: 20px;
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #CCC;
}

/* オリジナルスタイルsmartphone */

.editor-styles-wrapper .huto {
	font-weight:bold;
}

.editor-styles-wrapper .hutoaka {
	font-weight:bold;
	color:#ff3333;
}

.editor-styles-wrapper .st-mycolor {
	font-weight:bold;
	color:#FF9800;
}

.editor-styles-wrapper .st-aka {
	color:#ff3333;
}

.editor-styles-wrapper .maru {
	border-radius:5px;
}

.editor-styles-wrapper .noborder {
	border: none;
}

.editor-styles-wrapper .oomozi {
	font-size: 150%;
	line-height: 1.4;
	font-weight: bold;
}

.editor-styles-wrapper p.komozi,
.editor-styles-wrapper .komozi {
	font-size: 80%;
}

.editor-styles-wrapper .st-mymarker-s,
.editor-styles-wrapper .ymarker,
.editor-styles-wrapper .ymarker-s,
.editor-styles-wrapper .gmarker,
.editor-styles-wrapper .gmarker-s,
.editor-styles-wrapper .rmarker,
.editor-styles-wrapper .rmarker-s,
.editor-styles-wrapper .bmarker,
.editor-styles-wrapper .bmarker-s
 {
	font-weight:bold;
}

.editor-styles-wrapper .st-mymarker {
	background:#FFE0B2;
}

.editor-styles-wrapper .st-mymarker-s {
	background:linear-gradient(transparent 70%,#FFF9C4 0%);
}

.editor-styles-wrapper .ymarker {
	background:#FFF9C4;
}

.editor-styles-wrapper .ymarker-s {
	background:linear-gradient(transparent 70%,#FFF9C4 0%);
}

.editor-styles-wrapper .gmarker {
	background:#EEEEEE;
}

.editor-styles-wrapper .gmarker-s {
	background:linear-gradient(transparent 70%,#EEEEEE 0%);
}

.editor-styles-wrapper .rmarker {
	background:#ffcdd2;
}

.editor-styles-wrapper .rmarker-s {
	background:linear-gradient(transparent 70%,#ffcdd2 0%);
}

.editor-styles-wrapper .bmarker {
	background:#E1F5FE;
}

.editor-styles-wrapper .bmarker-s {
	background:linear-gradient(transparent 70%,#E1F5FE 0%);
}

.editor-styles-wrapper .yellowbox {
	padding:20px;
	background-color:#ffffe0;
	margin-bottom:20px;
}

.editor-styles-wrapper .yellowbox:not(.noborder) {
	border:solid 1px #fffacd;
}

.editor-styles-wrapper .redbox {
	margin-bottom: 20px;
	padding: 20px;
	background-color: #ffebee;
}
.editor-styles-wrapper .redbox:not(.noborder) {
	border: solid 1px #ef5350;
}

.editor-styles-wrapper .graybox {
	margin-bottom: 20px;
	padding: 20px;
	background-color: #f3f3f3;
}
.editor-styles-wrapper .graybox:not(.noborder) {
	border: solid 1px #ccc;
}

.editor-styles-wrapper .yellowbox p:last-child,
.editor-styles-wrapper .yellowbox ol:last-child,
.editor-styles-wrapper .yellowbox ul:last-child {
	margin-bottom:0;
	padding-bottom:0;
}

.editor-styles-wrapper .graybox p:last-child,
.editor-styles-wrapper .graybox ol:last-child,
.editor-styles-wrapper .graybox ul:last-child {
	margin-bottom:0;
	padding-bottom:0;
}

.editor-styles-wrapper .redbox p:last-child,
.editor-styles-wrapper .redbox ol:last-child,
.editor-styles-wrapper .redbox ul:last-child {
	margin-bottom:0;
	padding-bottom:0;
}


.editor-styles-wrapper .h2fuu {
	position: relative;
	background: #f3f3f3;
	color: #1a1a1a;
	font-size: 20px;
	line-height: 27px;
	margin-bottom: 20px;
	padding-top: 10px;
	padding-right: 20px;
	padding-bottom: 10px;
	padding-left: 20px;
	font-weight:bold;
}

.editor-styles-wrapper .h2fuu:after {
	content: '';
	position: absolute;
	border-top: 10px solid #f3f3f3;
	border-right: 10px solid transparent;
	border-left: 10px solid transparent;
	bottom: -10px;
	left: 30px;
	border-radius: 2px;
}

.editor-styles-wrapper .h2fuu:before {
	content: '';
	position: absolute;
	border-top: 10px solid #f3f3f3;
	border-right: 10px solid transparent;
	border-left: 10px solid transparent;
	bottom: -10px;
	left: 30px;
}

.editor-styles-wrapper .inyoumodoki {
	background-color: #f3f3f3;
	background-image: url(images/quote.png);
	background-repeat: no-repeat;
	background-position: left top;
	padding-top: 50px;
	padding-right: 20px;
	padding-bottom: 20px;
	padding-left: 20px;
	margin-top: 20px;
	margin-right: 0px;
	margin-bottom: 20px;
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #CCC;
}

.editor-styles-wrapper .inyoumodoki p:last-child,
.editor-styles-wrapper .inyoumodoki ol:last-child,
.editor-styles-wrapper .inyoumodoki ul:last-child {
	margin-bottom:0;
	padding-bottom:0;
}

.editor-styles-wrapper .sankou {
	font-size:70%;
	background-color:#F57C00;
	color:#fff;
	padding:3px 4px;
	margin:0 5px;
	white-space: nowrap;
}

.editor-styles-wrapper .sankou.green {
	background-color:#4CAF50;
}

.editor-styles-wrapper .sankou.blue {
	background-color:#2196F3;
}

.editor-styles-wrapper .st-hisu {
	font-size:70%;
	background-color:#FF0000;
	color:#fff;
	padding:3px 4px;
	margin:0 5px;
	white-space: nowrap;
}

/*ドット線*/
.editor-styles-wrapper .dotline {
	border-bottom:1px dotted #212121;
}

.editor-styles-wrapper .dotliner {
	border-bottom:1px dotted #ff0000;
}

.editor-styles-wrapper .dotline-s {
	border-bottom:1px solid #212121;
}

.editor-styles-wrapper .dotline-sr {
	border-bottom:1px solid #ff0000;
}

<?php if (_st_plugin_support_is_enabled( 'ST_BLOCKS', 'st-blocks' )): ?>
	/*--------------------------------
	会話レイアウト
	---------------------------------*/
	<?php // style.css ?>
	.editor-styles-wrapper .st-kaiwa-box {
		width: 100%;
		height: auto;
		margin-bottom: 20px;
		display:table;
	}

	.editor-styles-wrapper .st-kaiwa-face {
		text-align:center;
		display: table-cell;
		width:60px;
		vertical-align:top;
	}

	.editor-styles-wrapper .st-kaiwa-face img{
		border-radius: 60px;
		border: 1px solid #ccc;
	}

	.editor-styles-wrapper .st-kaiwa-face-name {
		color: #616161;
		font-size:70%;
		line-height:1.5;
		max-width:60px;
	}

	.editor-styles-wrapper .st-kaiwa-area {
		display: table-cell;
		vertical-align:top;
		text-align:left;
	}

	.editor-styles-wrapper .st-kaiwa-hukidashi {
		display: inline-block;
		padding: 15px 20px;
		margin-left: 20px;
		border-radius: 7px;
		position: relative;
		background-color: #f9f9f9;
	}

	.editor-styles-wrapper .st-kaiwa-hukidashi p:last-child {
		margin-bottom:0px;
	}

	.editor-styles-wrapper .st-kaiwa-hukidashi:after {
		content: "";
		position: absolute;
		top: 30px;
		left: -10px;
		margin-top: -10px;
		display: block;
		width: 0px;
		height: 0px;
		border-style: solid;
		border-width: 10px 10px 10px 0;
		border-color: transparent #f9f9f9 transparent transparent;
	}

	/* ふきだし反対 */
	.editor-styles-wrapper .st-kaiwa-face2 {
		text-align:center;
		display: table-cell;
		width:60px;
		vertical-align:top;
	}

	.editor-styles-wrapper .st-kaiwa-face2 img {
		border-radius: 60px;
		border: 1px solid #ccc;
	}

	.editor-styles-wrapper .st-kaiwa-face-name2 {
		color: #616161;
		font-size:70%;
		line-height:1.5;
		max-width:60px;
	}

	.editor-styles-wrapper .st-kaiwa-area2 {
		display: table-cell;
		vertical-align:middle;
		text-align:right;
	}

	.editor-styles-wrapper .st-kaiwa-hukidashi2 {
		display: inline-block;
		padding: 15px 20px;
		margin-right: 20px;
		border-radius: 7px;
		position: relative;
		background-color: #f9f9f9;
		text-align:left;
	}

	.editor-styles-wrapper .st-kaiwa-hukidashi2 p:last-child {
		margin-bottom:0px;
	}

	.editor-styles-wrapper .st-kaiwa-hukidashi2:after {
		content: "";
		position: absolute;
		top: 30px;
		right: -10px;
		margin-top: -10px;
		display: block;
		width: 0px;
		height: 0px;
		border-style: solid;
		border-width: 10px 0 10px 10px;
		border-color: transparent transparent transparent #f9f9f9;
	}

	<?php // st-themecss.php ?>
	<?php if ( isset($GLOBALS['stdata263']) && $GLOBALS['stdata263'] === 'yes' ): // 会話風アイコンを少し動かす ?>
		.editor-styles-wrapper .st-kaiwa-face img {
			animation: animScale 4s infinite ease-out;
			transform-origin: 50% 50%;
			animation-play-state:running;
		}

		.editor-styles-wrapper .st-kaiwa-face2 img {
			animation: animScale 4.5s infinite ease-out;
			transform-origin: 50% 50%;
			animation-play-state:running;
		}

		@keyframes animScale {
			0% { transform: scale(0.8, 0.8); }
			5% { transform: scale(1.1, 1.1); }
			10% { transform: scale(1, 1); }
			15% { transform: scale(1.1, 1.1); }
			20% { transform: scale(1, 1); }
			100% { transform: scale(1, 1); }
		}
	<?php endif; ?>

	<?php if ( $st_kaiwa_borderradius ): ?>
		/* ふきだしを角丸にしない */
		.editor-styles-wrapper .st-kaiwa-hukidashi,
		.editor-styles-wrapper .st-kaiwa-hukidashi2{
			border-radius:0;
		}
	<?php endif; ?>

	<?php
	$_st_kaiwa_settings = array(
		array( 'bgcolor' => $st_kaiwa_bgcolor ),
		array( 'bgcolor' => $st_kaiwa2_bgcolor ),
		array( 'bgcolor' => $st_kaiwa3_bgcolor ),
		array( 'bgcolor' => $st_kaiwa4_bgcolor ),
		array( 'bgcolor' => $st_kaiwa5_bgcolor ),
		array( 'bgcolor' => $st_kaiwa6_bgcolor ),
		array( 'bgcolor' => $st_kaiwa7_bgcolor ),
		array( 'bgcolor' => $st_kaiwa8_bgcolor ),
	);
	?>

	<?php for ($_i = 0; $_i < 8; $_i ++): $_st_kaiwa_setting = $_st_kaiwa_settings[$_i]; ?>
		<?php $_st_kaiwa_icon_class = ($_i !== 0) ? '.kaiwaicon' . ($_i + 1) : ''; ?>
		<?php if ( $_st_kaiwa_setting['bgcolor'] ): ?>
			<?php if ( $st_kaiwa_change_border ): ?>
				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi,
				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi2 {
					border: solid 2px <?php echo $_st_kaiwa_setting['bgcolor']; ?>;
				<?php if ( $st_kaiwa_change_border_bgcolor ): ?>
					background-color: <?php echo $st_kaiwa_change_border_bgcolor; ?>;
				<?php else: ?>
					background-color: transparent;
				<?php endif; ?>
				}

				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi::before {
					content: "";
					position: absolute;
					top: 30px;
					display: block;
					width: 0px;
					height: 0px;
					border-style: solid;
					margin-top: -13px;
					left: -13px;
					border-width: 13px 13px 13px 0;
					border-color: transparent <?php echo $_st_kaiwa_setting['bgcolor']; ?> transparent transparent;
				}

				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi::after {
					left: -10px;
					border-width: 10px 10px 10px 0;
					<?php if ( $st_kaiwa_change_border_bgcolor ): ?>
						border-color: transparent <?php echo $st_kaiwa_change_border_bgcolor; ?> transparent transparent;
					<?php else: ?>
						border-color: transparent #fff transparent transparent;
					<?php endif; ?>
				}

				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi2::before {
					content: "";
					position: absolute;
					top: 30px;
					display: block;
					width: 0px;
					height: 0px;
					border-style: solid;
					margin-top: -13px;
					right: -13px;
					border-width: 13px 0 13px 13px;
					border-color: transparent transparent transparent <?php echo $_st_kaiwa_setting['bgcolor']; ?>;
				}

				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi2::after {
					right: -10px;
					border-width: 10px 0 10px 10px;
					<?php if ( $st_kaiwa_change_border_bgcolor ): ?>
						border-color: transparent transparent transparent <?php echo $st_kaiwa_change_border_bgcolor; ?>;
					<?php else: ?>
						border-color: transparent transparent transparent #fff;
					<?php endif; ?>
				}
			<?php else: ?>
				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi,
				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi2 {
					background-color: <?php echo $_st_kaiwa_setting['bgcolor']; ?>;
				}

				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi:after {
					border-color: transparent <?php echo $_st_kaiwa_setting['bgcolor']; ?> transparent transparent;
				}

				.editor-styles-wrapper <?php echo $_st_kaiwa_icon_class; ?> .st-kaiwa-hukidashi2:after {
					border-color: transparent transparent transparent <?php echo $_st_kaiwa_setting['bgcolor']; ?>;
				}
			<?php endif; ?>
		<?php endif; ?>
	<?php endfor; ?>

	<?php if ( $st_kaiwa_no_border ): ?>
		/*アイコンの枠線を消す*/
		.editor-styles-wrapper .st-kaiwa-box:not(.st-kaiwa) .st-kaiwa-face img,
		.editor-styles-wrapper .st-kaiwa-box:not(.st-kaiwa) .st-kaiwa-face2 img {
			border: none;
		}
	<?php endif; ?>
<?php endif; ?>

/*--------------------------------
エディタ用
---------------------------------*/
/*均等横並び */
.editor-styles-wrapper .kintou ul {
	display:table;
	table-layout: fixed;
	width:100%;
	padding:0;
	margin:0 -5px 20px;
}

.editor-styles-wrapper .kintou ul li {
	display:table-cell;
	vertical-align:middle;
	text-align:center;
	padding:0 5px;
}

.editor-styles-wrapper .kintou ul li {
	background:#E1F5FE;
	border:1px solid #29B6F6;
}


/*テーブル */
.editor-styles-wrapper table {
	box-sizing: border-box;
	border-top: 1px #999 solid;
	border-right: 1px #999 solid;
	margin-bottom: 20px;
	width: 100%;
}

/*For IE*/
@media all and (-ms-high-contrast: active), (-ms-high-contrast: none) {
	.editor-styles-wrapper table {
		table-layout: fixed;
	}
}

.editor-styles-wrapper table tr td {
	padding: 5px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-bottom-style: solid;
	border-left-style: solid;
	border-bottom-color: #999;
	border-left-color: #999;
	font-size: 13px;
	line-height: 18px;
}

.editor-styles-wrapper table th {
	padding: 5px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-bottom-style: solid;
	border-left-style: solid;
	border-bottom-color: #999;
	border-left-color: #999;
	font-size: 13px;
	line-height: 18px;
}

.editor-styles-wrapper table tr td {
	font-size: 13px;
	line-height: 18px;
}

.editor-styles-wrapper table tr:nth-child(even) {
	background-color: rgba(220,220,220,0.2);
}

.editor-styles-wrapper #main table {
	border-top-width: 1px;
	border-right-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-top-color: #999;
	border-right-color: #999;
	color: #333;
}

/*テーブル（装飾なし） */
.editor-styles-wrapper .notab table {
	border:none;
	width: initial; /* 初期状態にリセット */
	max-width: initial; /* 初期状態にリセット */
}

.editor-styles-wrapper .notab table tr td {
	border:none;
	text-align: left;
	vertical-align: top;
}

.editor-styles-wrapper .notab table th {
	border:none;
}

.editor-styles-wrapper .notab table tr:nth-child(even) {
	background-color: transparent;
}


/*スクロール*/
.editor-styles-wrapper .scroll-box {
	overflow-x: auto;
	margin-bottom:10px;
}
.editor-styles-wrapper .scroll-box::-webkit-scrollbar {
      height: 5px;
}

.editor-styles-wrapper .scroll-box::-webkit-scrollbar-track {
      border-radius: 5px;
      background: #f3f3f3;
}
.editor-styles-wrapper .scroll-box::-webkit-scrollbar-thumb {
      border-radius: 5px;
      background: #ccc;
}

/*画像 */
.editor-styles-wrapper img.alignright {
	float: right;
	margin: 0 0 5px 10px;
}

.editor-styles-wrapper img.alignleft {
	float: left;
	margin: 0 10px 5px 0;
}

.editor-styles-wrapper img.aligncenter {
	display: block;
	margin:0 auto 10px;
}

.editor-styles-wrapper img.float-left {
	float: left;
}

.editor-styles-wrapper img.float-right {
	float: right;
}

.editor-styles-wrapper .wp-caption {
	text-align: center;
}

.editor-styles-wrapper .aligncenter {
	clear: both;
	display: block;
	margin:0 auto 10px;
}

.editor-styles-wrapper .ie8 img {
	width: auto;
}

/*マルリスト*/
.editor-styles-wrapper .maruno ol { 
	list-style-type: none;
	counter-reset: st-section;
	margin-left: 10px;
	padding:20px 20px 20px 30px;
}

.editor-styles-wrapper .maruno ol li {
	counter-increment: st-section;
	margin-bottom:5px;
	line-height: 23px;
}

.editor-styles-wrapper .maruno ol li:last-child {
	margin-bottom:0;
}

.editor-styles-wrapper .maruno ol li:before {
	content: counters(st-section,"");
	border-radius: 50%;
	float: left;
	min-width:23px;
	height:23px;
	line-height:23px;
	text-align:center;
	font-size:60%;
	margin-right:10px;
	background: #f3f3f3;
	color:#000;
	margin-left:-3em;
}

/*チェックリスト*/
.editor-styles-wrapper ul.is-style-st-maruck,
.editor-styles-wrapper .maruck {
	margin-bottom: 20px;
}

.editor-styles-wrapper ul.is-style-st-maruck.
.editor-styles-wrapper .maruck ul {
	list-style-type: none;
	margin-left: 10px;
	padding:0 20px 20px 30px;
}

.editor-styles-wrapper ul.is-style-st-maruck li,
.editor-styles-wrapper .maruck ul li {
list-style-type: none;
	list-style-type: none;
	padding-bottom:5px;
	line-height: 23px;
	margin-bottom:7px;
}

.editor-styles-wrapper ul.is-style-st-maruck li:before,
.editor-styles-wrapper .maruck ul li:before {
	content: " \f00c";
	font-family: FontAwesome;
	border-radius: 50%;
	float: left;
	min-width:23px;
	height:23px;
	line-height:23px;
	text-align:center;
	font-size:60%;
	margin-right:10px;
	background: #f3f3f3;
	color:#000;
	margin-left:-3em;
}

/* ボーダーあり */
.editor-styles-wrapper ol.is-style-st-border li,
.editor-styles-wrapper ul.is-style-st-border li,
.editor-styles-wrapper ol.is-style-st-circle-border li,
.editor-styles-wrapper ul.is-style-st-circle-border li,
.editor-styles-wrapper ol.is-style-st-check-border li,
.editor-styles-wrapper ul.is-style-st-check-border li,
.editor-styles-wrapper ol.is-style-st-no-border li,
.editor-styles-wrapper ul.is-style-st-no-border li,
.editor-styles-wrapper .st-list-border ol li,
.editor-styles-wrapper .st-list-border ul li {
	border-bottom: dotted 1px #ccc;
	padding-top: 10px;

}

.editor-styles-wrapper ol.is-style-st-border li:last-child,
.editor-styles-wrapper ul.is-style-st-border li:last-child ,
.editor-styles-wrapper ol.is-style-st-circle-border li:last-child,
.editor-styles-wrapper ul.is-style-st-circle-border li:last-child ,
.editor-styles-wrapper ol.is-style-st-check-border li:last-child,
.editor-styles-wrapper ul.is-style-st-check-border li:last-child ,
.editor-styles-wrapper ol.is-style-st-no-border li:last-child,
.editor-styles-wrapper ul.is-style-st-no-border li:last-child ,
.editor-styles-wrapper .st-list-border ol li:last-child,
.editor-styles-wrapper .st-list-border ul li:last-child {
	padding-bottom: 5px;
}

/* マル */
.editor-styles-wrapper ol.is-style-st-circle,
.editor-styles-wrapper ul.is-style-st-circle,
.editor-styles-wrapper ol.is-style-st-circle-border,
.editor-styles-wrapper ul.is-style-st-circle-border,
.editor-styles-wrapper .st-list-circle ol,
.editor-styles-wrapper .st-list-circle ul {
	padding-left: 0;
	padding-right: 0;
}

.editor-styles-wrapper ol.is-style-st-circle li,
.editor-styles-wrapper ul.is-style-st-circle li,
.editor-styles-wrapper ol.is-style-st-circle-border li,
.editor-styles-wrapper ul.is-style-st-circle-border li,
.editor-styles-wrapper .st-list-circle li{
	position: relative;
	padding-left: 20px;
	list-style: none;
}

.editor-styles-wrapper ol.is-style-st-circle li:before,
.editor-styles-wrapper ul.is-style-st-circle li:before,
.editor-styles-wrapper ol.is-style-st-circle-border li:before,
.editor-styles-wrapper ul.is-style-st-circle-border li:before,
.editor-styles-wrapper .st-list-circle li:before {
	content: "";
	position: absolute;
	top: .5em;
	left: 0;
	width: 10px;
	height: 10px;
	background-color: #ccc;
	border-radius: 50%;
}

.editor-styles-wrapper ol.is-style-st-circle-border li:before,
.editor-styles-wrapper ul.is-style-st-circle-border li:before,
.editor-styles-wrapper .st-list-circle.st-list-border li:before {
	top: calc( .5em + 10px )
}

/* 簡易チェックマーク */
.editor-styles-wrapper ol.is-style-st-check,
.editor-styles-wrapper ul.is-style-st-check,
.editor-styles-wrapper ol.is-style-st-check-border,
.editor-styles-wrapper ul.is-style-st-check-border,
.editor-styles-wrapper .st-list-check ol,
.editor-styles-wrapper .st-list-check ul {
	padding-left: 0;
	padding-right: 0;
}

.editor-styles-wrapper ol.is-style-st-check li,
.editor-styles-wrapper ul.is-style-st-check li,
.editor-styles-wrapper ol.is-style-st-check-border li,
.editor-styles-wrapper ul.is-style-st-check-border li,
.editor-styles-wrapper .st-list-check ol li,
.editor-styles-wrapper .st-list-check ul li{
    position: relative;
    padding-left: 25px;
	list-style: none;
}

.editor-styles-wrapper ol.is-style-st-check li:before,
.editor-styles-wrapper ul.is-style-st-check li:before,
.editor-styles-wrapper ol.is-style-st-check-border li:before,
.editor-styles-wrapper ul.is-style-st-check-border li:before,
.editor-styles-wrapper .st-list-check ol li:before,
.editor-styles-wrapper .st-list-check ul li:before { /* チェック */
    content: "";
    position: absolute;
    top: .6em;
    left: 6px;
    -webkit-transform: rotate(50deg);
    -ms-transform: rotate(50deg);
    transform: rotate(50deg);
    width: 3px;
    height: 7px;
    border-right: 2px solid #ccc;
    border-bottom: 2px solid #ccc;
}

.editor-styles-wrapper ol.is-style-st-check li:after,
.editor-styles-wrapper ul.is-style-st-check li:after,
.editor-styles-wrapper ol.is-style-st-check-border li:after,
.editor-styles-wrapper ul.is-style-st-check-border li:after,
.editor-styles-wrapper .st-list-check ol li:after,
.editor-styles-wrapper .st-list-check ul li:after {
    content: "";
    position: absolute;
    top: .4em;
    left: 0;
    width: 15px;
    height: 15px;
    border: solid 1px #ccc;
    border-radius: 2px;
}

.editor-styles-wrapper ol.is-style-st-check-border li:before,
.editor-styles-wrapper ul.is-style-st-check-border li:before,
.editor-styles-wrapper .st-list-check.st-list-border ul li:before { /* チェック */
	top: calc( 10px + .6em );
}

.editor-styles-wrapper ol.is-style-st-check-border li:after,
.editor-styles-wrapper ul.is-style-st-check-border li:after,
.editor-styles-wrapper .st-list-check.st-list-border ul li:after {
	top: calc( 10px + .4em );
}

.editor-styles-wrapper ol.is-style-st-check li:after:hover,
.editor-styles-wrapper ul.is-style-st-check li:after:hover,
.editor-styles-wrapper ol.is-style-st-check-border li:after:hover,
.editor-styles-wrapper ul.is-style-st-check-border li:after:hover,
.editor-styles-wrapper .st-list-check ul li:after:hover {
    color: #ff0000;
}

/* 四角背景 */
.editor-styles-wrapper ol.is-style-st-no,
.editor-styles-wrapper ul.is-style-st-no,
.editor-styles-wrapper ol.is-style-st-no-border,
.editor-styles-wrapper ul.is-style-st-no-border,
.editor-styles-wrapper .st-list-no ol,
.editor-styles-wrapper .st-list-no ul {
	padding-left: 0;
	padding-right: 0;
}

.editor-styles-wrapper ol.is-style-st-no li,
.editor-styles-wrapper ul.is-style-st-no li,
.editor-styles-wrapper ol.is-style-st-no-border li,
.editor-styles-wrapper ul.is-style-st-no-border li,
.editor-styles-wrapper .st-list-no li{
    display: flex;
    align-items: baseline;
    counter-increment: st-list-count;
	list-style: none;
	position: relative;
	padding-left: 30px;
}

.editor-styles-wrapper ol.is-style-st-no li:before,
.editor-styles-wrapper ul.is-style-st-no li:before,
.editor-styles-wrapper ol.is-style-st-no-border li:before,
.editor-styles-wrapper ul.is-style-st-no-border li:before,
.editor-styles-wrapper .st-list-no li:before {
    content: counter(st-list-count);
    width: 20px;
    height: 20px;
    margin-right: 10px;
    background-color: #ccc;
    font-size: 12px;
    color: #fff;
    line-height: 20px;
    text-align: center;
	position: absolute;
	top: 0.4em;
	left: 0;
}

.editor-styles-wrapper ol.is-style-st-no-border li:before,
.editor-styles-wrapper ul.is-style-st-no-border li:before,
.editor-styles-wrapper .st-list-no.st-list-border ol li:before,
.editor-styles-wrapper .st-list-no.st-list-border ul li:before {
	top: calc( 0.4em + 10px );
}

/*----------------------------------
リンクボタン
-----------------------------------*/

/*詳細ページへのリンクボタンカラー*/
.editor-styles-wrapper .rankstlink-l2 p a,
.editor-styles-wrapper .rankstlink-l p a,
.editor-styles-wrapper .rankstlink-b p a {
	font-family: Helvetica , "游ゴシック", "Yu Gothic", sans-serif;
	background: #f2f2f2;
	color: #000;
}

/*アフィリエイトのリンクボタンカラー*/
.editor-styles-wrapper .rankstlink-r p a,
.editor-styles-wrapper .rankstlink-r2 p a,
.editor-styles-wrapper .rankstlink-a p a {
	font-family: Helvetica , "游ゴシック", "Yu Gothic", sans-serif;
	background-color: #f2f2f2;
	color: #000;
}

/*スター*/

.editor-styles-wrapper .st-star {
	color:#FFB400;
	font-size:15px;
}

/*投稿用詳細ページリンクボタン*/
.editor-styles-wrapper .rankstlink-l2 p a {
	display: block;
	width: 100%;
	text-align: center;
	padding: 10px;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-sizing:border-box;
}

.editor-styles-wrapper .rankstlink-l2 p {
	width: 90%;
	text-align: center;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-shadow: 0 2px 0 #cccccc;
	position:relative;
}

.editor-styles-wrapper .rankstlink-l2 p:hover {
	box-shadow: 0 1px 0 #cccccc;
	top:1px;
}

/*投稿用公式リンク*/
.editor-styles-wrapper .rankstlink-r2 p a {
	display: block;
	width: 100%;
	text-align: center;
	padding: 10px;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-sizing:border-box;
}

.editor-styles-wrapper .rankstlink-r2 p {
	width: 90%;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	box-shadow: 0 2px 0 #cccccc;
	position:relative;
}

.editor-styles-wrapper .rankstlink-r2 p img{
	display:none;
}

.editor-styles-wrapper .rankstlink-r2 p br{
	display:none;
}

/*media Queries タブレットサイズ
----------------------------------------------------*/
@media only screen and (min-width: 414px) {
/*レスポンシブ用PC左右コンテンツ*/

	.editor-styles-wrapper .responboxfree .lbox {
		padding:10px;
		background:#FFF59D;
		float:left;
		padding-right:15px;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responboxfree .rbox {
		padding:10px;
		background:#B2EBF2;
		float:left;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responbox .lbox {
		padding:10px;
		background:#FFF59D;
		float:left;
		padding-right:15px;
		width:40%;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responbox .rbox {
		padding:10px;
		background:#B2EBF2;
		float:left;
		box-sizing:border-box;
		width:60%;
	}

	.editor-styles-wrapper .responbox40 .lbox {
		padding:10px;
		background:#FFF59D;
		float:left;
		padding-right:15px;
		width:40%;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responbox40 .rbox {
		padding:10px;
		background:#B2EBF2;
		float:left;
		box-sizing:border-box;
		width:60%;
	}

	/*30%*/

	.editor-styles-wrapper .responbox30 .lbox {
		padding:10px;
		background:#FFF59D;
		float:left;
		padding-right:15px;
		width:30%;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responbox30 .rbox {
		padding:10px;
		background:#B2EBF2;
		float:left;
		box-sizing:border-box;
		width:70%;
	}

	/*33%*/

	.editor-styles-wrapper .responbox33 .lbox {
		float:left;
		padding:5px;
		width:33.33%;
		box-sizing:border-box;
		background:#FFF59D;
	}

	.editor-styles-wrapper .responbox33 .lbox:nth-child(even) {
		background:#B2EBF2;
	}

	/*50%*/

	.editor-styles-wrapper .responbox50 .lbox {
		padding:10px;
		background:#FFF59D;
		float:left;
		padding-right:15px;
		width:50%;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responbox50 .rbox {
		padding:10px;
		background:#B2EBF2;
		float:left;
		box-sizing:border-box;
		width:50%;
	}

	/*60%*/

	.editor-styles-wrapper .responbox60 .lbox {
		padding:10px;
		background:#FFF59D;
		float:left;
		padding-right:15px;
		width:60%;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responbox60 .rbox {
		padding:10px;
		background:#B2EBF2;
		float:left;
		box-sizing:border-box;
		width:40%;
	}

	/*70%*/

	.editor-styles-wrapper .responbox70 .lbox {
		padding:10px;
		background:#FFF59D;
		float:left;
		padding-right:15px;
		width:30%;
		box-sizing:border-box;
	}

	.editor-styles-wrapper .responbox70 .rbox {
		padding:10px;
		background:#B2EBF2;
		float:right;
		box-sizing:border-box;
		width:70%;
	}

}
/*media Queries PCサイズ
----------------------------------------------------*/
@media only screen and (min-width: 781px) {

	/*--------------------------------
	各フォント設定
	---------------------------------*/
	.editor-styles-wrapper div,
	.editor-styles-wrapper p {
		font-size: 14px;
		line-height: 23px;
	}

	.editor-styles-wrapper ol li,
	.editor-styles-wrapper .mce-content-body ol li,
	.editor-styles-wrapper ul li,
	.editor-styles-wrapper .mce-content-body ul li {
		font-size: 14px;
		line-height: 25px;
	}

	/*中見出し*/
	.editor-styles-wrapper h2 {
		font-size: 20px;
		line-height: 30px;
	}

	.editor-styles-wrapper h2:after {
		bottom: -10px;
		left: 50px;
	}

	.editor-styles-wrapper h2:before {
		bottom: -10px;
		left: 50px;
	}

	/*小見出し*/
	.editor-styles-wrapper h3 {
		font-size: 18px;
		line-height: 25px;
	}

	/*リスト */
	.editor-styles-wrapper ul li {
		font-size: 14px;
		line-height: 27px;
	}

	.editor-styles-wrapper ol li {
		font-size: 14px;
		line-height: 27px;
	}

	/* オリジナルスタイルPC */

	.editor-styles-wrapper .oomozi {
		font-size: 18pt;line-height: 35px;
	}


	.editor-styles-wrapper .yellowbox {
		font-size: 14px;
		line-height: 27px;
		margin-bottom: 20px;
	}


	.editor-styles-wrapper .redbox {
		font-size: 14px;
		line-height: 27px;
		margin-bottom: 20px;
	}

	.editor-styles-wrapper .graybox {
		font-size: 14px;
		line-height: 27px;
		margin-bottom: 20px;
	}

	.editor-styles-wrapper .h2fuu {
		font-size: 20px;
		line-height: 30px;
	}

	.editor-styles-wrapper .h2fuu:after {
		bottom: -10px;
		left: 50px;
	}

	.editor-styles-wrapper .h2fuu:before {
		bottom: -10px;
		left: 50px;
	}

	/*-- ここまで --*/
}

/*--------------------------------
editor-style.css（ここまで）
---------------------------------*/

<?php // Gutenberg 用ブロックプラグイン ?>
<?php if ( _st_plugin_support_is_enabled( 'ST_BLOCKS', 'st-blocks' )): ?>
	<?php // マイカラー ?>
	.editor-styles-wrapper .st-mycolor {
		color: <?php echo $GLOBALS['stdata416']; ?>;
		font-weight: bold;
	}

	<?php // マイマーカー ?>
	.editor-styles-wrapper .st-mymarker-s {
		background: linear-gradient(transparent 70%, <?php echo $GLOBALS['stdata417']; ?> 0%);
		<?php if ( trim( $GLOBALS['stdata418'] ) !== '' ): ?>
			color: <?php echo $GLOBALS['stdata418'] ; ?>;
		<?php endif; ?>
		font-weight: bold;
	}

	<?php // メモ ?>
	<?php _st_block_editor_style_scope_root_styles( '.clip-memobox' ); ?>
	.editor-styles-wrapper .clip-memobox {
		display: table;
		margin-bottom: 20px;
		padding: 10px;
		border-radius: 3px;
		background: #f3f3f3;
	}

	.editor-styles-wrapper .clip-fonticon,
	.editor-styles-wrapper .clip-memotext {
		display: table-cell;
		vertical-align: middle;
	}

	.editor-styles-wrapper .clip-fonticon {
		padding: 0 15px 0 10px;
		text-align: center;
	}

	.editor-styles-wrapper .clip-memotext p {
		margin-bottom: 10px;
	}

	.editor-styles-wrapper .clip-memotext p:last-child {
		margin-bottom: 0;
	}

	.editor-styles-wrapper .clip-memotext {
		box-sizing: border-box;
		padding-left: 15px;
		width: 100%;
		border-left: 1px solid #e0e0e0;
	}

	.editor-styles-wrapper .clip-memotext > * {
		font-size: 95%;
		line-height: 1.7;
	}

	@media (max-width: 599px) {
		.editor-styles-wrapper .clip-memobox .clip-fonticon {
			font-size: 150%;
		}
	}

	<?php //見出し付きフリーボックス ?>
	<?php _st_block_editor_style_scope_root_styles( '.freebox' ); ?>
	.editor-styles-wrapper .freebox {
		position: relative;
		margin-bottom: 20px;
		padding: 10px 0;
		border-top: solid 1px #feb20a;
		background: #f3f3f3;
		font-size: 15px;
		line-height: 25px;
	}

	.editor-styles-wrapper .p-free {
		padding: 0;
	}

	.editor-styles-wrapper .p-free:after {
		display: block;
		margin-bottom: 30px;
		content: "";
	}

	.editor-styles-wrapper .p-entry-f {
		position: absolute;
		top: 0;
		left: 0;
		margin: 0;
		padding: 3px 20px;
		max-width: 80%;
		background: #feb20a;
		color: #fff;
		font-weight: bold;
		font-size: 15px;
	}

	.editor-styles-wrapper .p-entry-f .fa {
		margin-right: 5px;
	}

	.editor-styles-wrapper .free-inbox {
		padding: 10px 15px 10px;
		text-align: left;
	}

	.editor-styles-wrapper .free-inbox p {
		margin-bottom: 10px;
	}

	.editor-styles-wrapper .free-inbox p:last-child {
		margin-bottom: 10px;
	}

	@media (min-width: 600px) {
		.editor-styles-wrapper .freebox {
			font-size: 18px;
			line-height: 28px;
		}
	}

	@media (min-width: 960px) {
		.editor-styles-wrapper .freebox {
			font-size: 14px;
			line-height: 24px;
		}
	}

	<?php // マイボックス ?>
	<?php _st_block_editor_style_scope_root_styles( '.st-mybox' ); ?>
	.editor-styles-wrapper .st-mybox {
		position: relative;
		margin: 25px 0;
		padding: 0 20px;
		border: solid 2px #9e9e9e;
	}

	.editor-styles-wrapper .st-in-mybox {
		padding: 20px 0;
	}

	.editor-styles-wrapper .st-in-mybox p {
		margin-bottom: 10px;
	}

	.editor-styles-wrapper .st-in-mybox p:last-child {
		margin-bottom: 0;
	}

	.editor-styles-wrapper .st-mybox .fa {
		margin-right: 5px;
	}

	.editor-styles-wrapper .st-mybox .st-mybox-title {
		position: absolute;
		top: -8px;
		left: 10px;
		display: inline-block;
		margin-bottom: 10px;
		padding: 0 10px;
		color: #9e9e9e;
		font-weight: bold;
		line-height: 1;
	}

	<?php // バナー風ボックス ?>
	<?php _st_block_editor_style_scope_root_styles( '.st-header-flexwrap' ); ?>
	.editor-styles-wrapper .st-header-flexwrap {
		position: relative;
		z-index: 0;
		display: flex;
		overflow: hidden;
		background-position: 50% 50%;
		background-size: cover;
		justify-content: center;
		align-items: center;
	}

	.editor-styles-wrapper .st-header-flexwrap.st-blur::before {
		position: absolute;
		top: -5px;
		right: -5px;
		bottom: -5px;
		left: -5px;
		z-index: -1;
		background: inherit;
		content: '';
		filter: blur(5px);
		transition: filter 0.3s ease;
	}

	.editor-styles-wrapper .st-header-flexwrap.st-blur:hover::before {
		filter: blur(0);
	}

	.editor-styles-wrapper .st-header-flexbox {
		width: 80%;
		text-align: center;
	}

	.editor-styles-wrapper .st-header-flexbox p:last-child {
		margin-bottom: 0;
	}

	.editor-styles-wrapper .st-header-flextitle {
		margin-bottom: 10px;
		color: #fff;
		font-weight: bold;
		line-height: 1.3;
	}

	.editor-styles-wrapper .st-header-flextitle .fa {
		margin-right: 7px;
	}

	.editor-styles-wrapper .st-header-flexwrap.st-flexbox-center {
		margin-right: auto;
		margin-left: auto;
	}

	.editor-styles-wrapper .st-header-flexwrap.st-flexbox-left {
		display: flex;
		justify-content: flex-start;
	}

	.editor-styles-wrapper .st-header-flexwrap.st-flexbox-left .st-header-flexbox {
		box-sizing: border-box;
		width: 100%;
		text-align: left;
	}
<?php endif;    // Gutenberg 用ブロックプラグイン ?>

<?php // カスタマイザーの反映 ?>
<?php if ( isset ( $GLOBALS["stdata240"] ) && $GLOBALS["stdata240"] === 'yes' ): ?>

	/*こんな方におすすめ*/
	<?php if($st_blackboard_bgcolor){ //背景色 ?>
		.editor-styles-wrapper .st-blackboard {
			background: <?php echo $st_blackboard_bgcolor; ?>;
		}
	<?php } ?>

	<?php if($st_blackboard_underbordercolor){ //ulリストのチェックアイコン ?>
		.editor-styles-wrapper .st-blackboard:not(.square-checkbox) ul.st-blackboard-list:not(.st-css-no) li:before {
			color:<?php echo $st_blackboard_underbordercolor; ?>;
		}
	<?php } ?>

	<?php if($st_blackboard_bordercolor){ //ulリストの下線とテキスト ?>
		.editor-styles-wrapper .st-blackboard ul.st-blackboard-list:not(.st-css-no) li,
		.editor-styles-wrapper .st-blackboard ul.st-blackboard-list:not(.st-css-no) li:last-child {
			border-color:<?php echo $st_blackboard_bordercolor; ?>;
			color:<?php echo $st_blackboard_bordercolor; ?>;
		}
	<?php } ?>

	<?php if($st_blackboard_mokuzicolor){ //タイトル色 ?>
	   .editor-styles-wrapper  .st-blackboard-title {
			color: <?php echo $st_blackboard_mokuzicolor; ?>;
		}
	<?php } ?>

	<?php if($st_blackboard_title_bgcolor){ //タイトル背景色 ?>
		.editor-styles-wrapper .st-blackboard-title {
			background: <?php echo $st_blackboard_title_bgcolor; ?>;
			padding: 10px 15px 5px;
		}
	<?php } ?>

	<?php if($st_blackboard_textcolor){ //枠線 ?>
		.editor-styles-wrapper .st-blackboard,
		.editor-styles-wrapper .st-blackboard-title {
			border-color: <?php echo $st_blackboard_textcolor; ?>;
		}
	<?php } ?>

	<?php if($st_blackboard_list3_fontweight){ //タイトル下線を非表示 ?>
		.editor-styles-wrapper .st-blackboard-title {
			border: none;
		}
	<?php } ?>

	<?php if($st_blackboard_webicon){ //Webアイコン（Font Awesome） ?>
		.editor-styles-wrapper .st-blackboard-title:before {
			content: "<?php echo $st_blackboard_webicon; ?>0a0";
			font-family: FontAwesome;
		}
	<?php } ?>

	/*マル数字olタグ*/
	<?php if($st_maruno_bordercolor){ ?>
		.editor-styles-wrapper .mce-content-body .maruno {
			border:2px solid <?php echo $st_maruno_bordercolor; ?>;
			padding: 20px 20px 20px 30px;
			<?php if($st_maruno_radius){ ?>
				border-radius: 5px;
			<?php } ?>
		}
	<?php } ?>

	<?php if($st_maruno_bgcolor){ ?>
		.editor-styles-wrapper .mce-content-body .maruno {
			background-color:<?php echo $st_maruno_bgcolor; ?>;
			padding: 20px 20px 20px 30px;
			<?php if($st_maruno_radius){ ?>
				border-radius: 5px;
			<?php } ?>
		}
	<?php } ?>

	.editor-styles-wrapper ol.is-style-st-maruno li:before,
	.editor-styles-wrapper .maruno ol li:before {
		<?php if($st_maruno_nobgcolor){ ?>
			background: <?php echo $st_maruno_nobgcolor; ?>;
		<?php } ?>
		<?php if($st_maruno_textcolor){ ?>
			color:<?php echo $st_maruno_textcolor; ?>;
		<?php } ?>
	}

	<?php if( $st_maruno_nobgcolor ){ ?>
		/* 四角背景 */
		.editor-styles-wrapper ol.is-style-st-no li:before,
		.editor-styles-wrapper ul.is-style-st-no li:before,
		.editor-styles-wrapper ol.is-style-st-no-border li:before,
		.editor-styles-wrapper ul.is-style-st-no-border li:before,
		.editor-styles-wrapper .st-list-no:not(.st-css-no) li:before {
			background-color: <?php echo $st_maruno_nobgcolor; ?>;
		}
	<?php } ?>

	/*チェックulタグ*/
	<?php if($st_maruck_bordercolor){ ?>
		.editor-styles-wrapper .mce-content-body .maruck {
			border:2px solid <?php echo $st_maruck_bordercolor; ?>;
			padding: 20px 20px 20px 30px;
			<?php if($st_maruck_radius){ ?>
				border-radius: 5px;
			<?php } ?>
		}
	<?php } ?>

	<?php if($st_maruck_bgcolor){ ?>
		.editor-styles-wrapper .mce-content-body .maruck {
			background-color:<?php echo $st_maruck_bgcolor; ?>;
			padding: 20px 20px 20px 30px;
			<?php if($st_maruck_radius){ ?>
				border-radius: 5px;
			<?php } ?>
		}
	<?php } ?>

	.editor-styles-wrapper ul.is-style-st-maruck li:before,
	.editor-styles-wrapper .maruck ul li:before {
		<?php if($st_maruck_nobgcolor){ ?>
			background: <?php echo $st_maruck_nobgcolor; ?>;
		<?php } ?>
		<?php if($st_maruck_textcolor){ ?>
			color:<?php echo $st_maruck_textcolor; ?>;
		<?php } ?>
	}

	<?php if($st_maruck_nobgcolor){ ?>
		/* マル */
		.editor-styles-wrapper ol.is-style-st-circle li:before,
		.editor-styles-wrapper ol.is-style-st-circle-border li:before,
		.editor-styles-wrapper ul.is-style-st-circle li:before,
		.editor-styles-wrapper ul.is-style-st-circle-border li:before,
		.editor-styles-wrapper .st-list-circle:not(.st-css-no) li:before {
			background-color: <?php echo $st_maruck_nobgcolor; ?>;
		}
	<?php } ?>

	/*Webアイコン*/
	<?php if ( $st_webicon_question ): ?>
		.editor-styles-wrapper .post .hatenamark2.on-color:not(.st-css-no):before,
		.editor-styles-wrapper .post .fa-question-circle:not(.st-css-no) {
			color: <?php echo $st_webicon_question; ?>;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_check ): ?>
		.editor-styles-wrapper .post .checkmark2.on-color:not(.st-css-no):before,
		.editor-styles-wrapper .post .fa-check-circle:not(.st-css-no) {
			color: <?php echo $st_webicon_check; ?>;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_checkbox ): ?>
		.editor-styles-wrapper ol.is-style-st-square-checkbox li:before,
		.editor-styles-wrapper ul.is-style-st-square-checkbox li:before,
		.editor-styles-wrapper .st-blackboard.square-checkbox ul.st-blackboard-list:not(.st-css-no) li:before,
		.editor-styles-wrapper .st-square-checkbox ul li:before {
			color: <?php echo $st_webicon_checkbox; ?>;
		}
		/* 簡易チェックマーク */
		.editor-styles-wrapper ol.is-style-st-check li:before,
		.editor-styles-wrapper ol.is-style-st-check-border li:before,
		.editor-styles-wrapper ul.is-style-st-check li:before,
		.editor-styles-wrapper ul.is-style-st-check-border li:before,
		.editor-styles-wrapper .st-list-check:not(.st-css-no) ol li:before,
		.editor-styles-wrapper .st-list-check:not(.st-css-no) ul li:before {
			border-color: <?php echo $st_webicon_checkbox; ?>;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_checkbox_square ): ?>
		.editor-styles-wrapper ol.is-style-st-square-checkbox li:after,
		.editor-styles-wrapper ul.is-style-st-square-checkbox li:after,
		.editor-styles-wrapper .st-blackboard.square-checkbox ul li:after,
		.editor-styles-wrapper .st-square-checkbox ul li:after {
			color: <?php echo $st_webicon_checkbox_square; ?>;
		}
		/* 簡易チェックマーク */
		.editor-styles-wrapper ol.is-style-st-check li:after,
		.editor-styles-wrapper ol.is-style-st-check-border li:after,
		.editor-styles-wrapper ul.is-style-st-check li:after,
		.editor-styles-wrapper ul.is-style-st-check-border li:after,
		.editor-styles-wrapper .st-list-check:not(.st-css-no) ol li:after,
		.editor-styles-wrapper .st-list-check:not(.st-css-no) ul li:after {
			border-color: <?php echo $st_webicon_checkbox_square; ?>;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_checkbox_size ): ?>
		.editor-styles-wrapper ol.is-style-st-square-checkbox li:before,
		.editor-styles-wrapper ol.is-style-st-square-checkbox li:after,
		.editor-styles-wrapper ol.is-style-st-check li:before,
		.editor-styles-wrapper ol.is-style-st-check-border li:before,
		.editor-styles-wrapper ol.is-style-st-check li:after,
		.editor-styles-wrapper ol.is-style-st-check-border li:after,
		.editor-styles-wrapper ul.is-style-st-square-checkbox li:before,
		.editor-styles-wrapper ul.is-style-st-square-checkbox li:after,
		.editor-styles-wrapper ul.is-style-st-check li:before,
		.editor-styles-wrapper ul.is-style-st-check-border li:before,
		.editor-styles-wrapper ul.is-style-st-check li:after,
		.editor-styles-wrapper ul.is-style-st-check-border li:after,
		.editor-styles-wrapper .st-blackboard.square-checkbox ul.st-blackboard-list:not(.st-css-no) li:before,
		.editor-styles-wrapper .st-blackboard.square-checkbox ul li:after,
		.editor-styles-wrapper .st-square-checkbox ul li:before,
		.editor-styles-wrapper .st-square-checkbox ul li:after {
			font-size: <?php echo $st_webicon_checkbox_size; ?>%;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_exclamation ): ?>
		.editor-styles-wrapper .attentionmark2.on-color:not(.st-css-no):before,
		.editor-styles-wrapper .fa-exclamation-triangle:not(.st-css-no) {
			color: <?php echo $st_webicon_exclamation; ?>;
	}
	<?php endif; ?>

	<?php if ( $st_webicon_memo ): ?>
		.editor-styles-wrapper .memomark2.on-color:not(.st-css-no):before,
		.editor-styles-wrapper .fa-pencil-square-o:not(.st-css-no) {
			color: <?php echo $st_webicon_memo; ?>;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_user ): ?>
		.editor-styles-wrapper .usermark2.on-color:before,
		.editor-styles-wrapper .fa-user:not(.st-css-no) {
			color: <?php echo $st_webicon_user; ?>;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_oukan ): ?>
		.editor-styles-wrapper .oukanmark.on-color:before,
		.editor-styles-wrapper .st-svg-oukan:not(.st-css-no) {
			color: <?php echo $st_webicon_oukan; ?>;
		}
	<?php endif; ?>

	<?php if ( $st_webicon_bigginer ): ?>
		.editor-styles-wrapper .bigginermark.on-color:before,
		.editor-styles-wrapper .st-svg-bigginer_l:not(.st-css-no) {
			color: <?php echo $st_webicon_bigginer; ?>;
		}
	<?php endif; ?>

	/* h2 */

	<?php if($st_h2_no_css): //カスタマイザーのCSSを無効化
	else: ?>

	<?php if ( $st_h2_gradient ): //グラデーションを横向きにする
			$h2_gradient_w = 'left';
			$h2_gradient = 'left';
		else :
			$h2_gradient_w = 'top';
			$h2_gradient = 'bottom';
		endif;
	?>

	<?php if($st_h2_bg_radius){ //h2 ?>
		/* 角丸 */
		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper .h2modoki span,
		.editor-styles-wrapper h2:not(.st-css-no),
		.editor-styles-wrapper h2:not(.st-css-no) span {
			border-radius:5px;
		}
		<?php if ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'leftlinedesign') ): //左ラインのみ ?>
			.editor-styles-wrapper .h2modoki:before,
			.editor-styles-wrapper h2:not(.st-css-no):before {
				border-radius:3px;
			}
		<?php endif; ?>
	<?php } ?>

	<?php if ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'linedesign') ): //左ラインデザイン ?>
		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			position: relative;
			padding: 1em 1em 1em 1.3em;

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>

			border: 1px solid <?php echo $st_h2border_color; ?>;
			<?php if ( $st_h2_color ): ?>
				color: <?php echo $st_h2_color; ?>;
			<?php endif; ?>
			<?php if ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) !== '' ) ): ?>
				/*Other Browser*/
				background: <?php echo $st_h2_bgcolor; ?>;
				/* Android4.1 - 4.3 */
				background: url("<?php echo $st_h2_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h2_gradient_w; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);

				/* IE10+, FF16+, Chrome26+ */
				background: url("<?php echo $st_h2_bgimg; ?>"), linear-gradient(to <?php echo $h2_gradient; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);
			<?php elseif ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
				background-image: url("<?php echo $st_h2_bgimg; ?>");
				background-color: <?php echo $st_h2_bgcolor; ?>;
			<?php else: ?>
				background-color: transparent;
				<?php if( $st_h2_bgimg ): //背景画像がある場合 ?>
					background: url("<?php echo $st_h2_bgimg; ?>");
				<?php else: ?>
					background: none;
				<?php endif; ?>
			<?php endif; ?>
		}

		<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no) {
				background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
				<?php if ( $st_h2_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>
		.editor-styles-wrapper .h2modoki::after,
		.editor-styles-wrapper h2:not(.st-css-no)::after {
			position: absolute;
			top: .5em;
			left: .5em;
			content: '';
			width: 5px;
			height: -webkit-calc(100% - 1em);
			height: calc(100% - 1em);
			<?php if($st_h2border_undercolor){ //ボーダーカラー ?>
				background-color: <?php echo $st_h2border_undercolor; ?>;
			<?php }else{ ?>
				background-color: <?php echo $st_h2border_color; ?>;
			<?php } ?>

		}

	<?php elseif ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'stripe_design') ): //ストライプ ?>
		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			<?php if ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) !== '' ) ): ?>
				background: -webkit-repeating-linear-gradient(45deg, <?php echo $st_h2_bgcolor; ?>, <?php echo $st_h2_bgcolor; ?> 5px, <?php echo $st_h2_bgcolor_t; ?> 5px, <?php echo $st_h2_bgcolor_t; ?> 10px);
				background: repeating-linear-gradient(45deg, <?php echo $st_h2_bgcolor; ?>, <?php echo $st_h2_bgcolor; ?> 5px, <?php echo $st_h2_bgcolor_t; ?> 5px, <?php echo $st_h2_bgcolor_t; ?> 10px);
			<?php elseif ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
				background-image: url("<?php echo $st_h2_bgimg; ?>");
				background-color: <?php echo $st_h2_bgcolor; ?>;
			<?php else: ?>

			<?php endif; ?>

			<?php if ( $st_h2_color ): ?>
				color: <?php echo $st_h2_color; ?>;
			<?php endif; ?>
			<?php if($st_h2border_color){ //ボーダーカラー ?>
						border: 1px solid <?php echo $st_h2border_color; ?>;
			<?php } ?>
			<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>
		}

	<?php elseif ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'gradient_underlinedesign') ): //グラデーションアンダーライン ?>
		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			position: relative;
			padding-left:0;
			padding-bottom: 10px;
			border-top:none;
			<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>
					color: <?php echo $st_h2_color; ?>;
					background-color:transparent;
		}
		.editor-styles-wrapper .h2modoki::after,
		.editor-styles-wrapper h2:not(.st-css-no)::after {
			position: absolute;
			bottom: -3px;
			left: 0;
			z-index: 2;
			content: '';
			width: 100%;
			height: 3px;
			<?php if ( ( trim( $st_h2border_color ) !== '' ) && ( trim( $st_h2border_undercolor ) !== '' ) ): ?>
				/*Other Browser*/
				background: <?php echo $st_h2border_color; ?>;
				/* Android4.1 - 4.3 */
				background: -webkit-linear-gradient(left,  <?php echo $st_h2border_undercolor; ?> 0%,<?php echo $st_h2border_color; ?> 100%);

				/* IE10+, FF16+, Chrome26+ */
				background: linear-gradient(to left,  <?php echo $st_h2border_undercolor; ?> 0%,<?php echo $st_h2border_color; ?> 100%);
			<?php elseif ( ( trim( $st_h2border_color ) !== '' ) && ( trim( $st_h2border_undercolor ) === '' ) ): //下部には色がある場合 ?>
				background-color: <?php echo $st_h2border_color; ?>;
			<?php endif; ?>
		}

		<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no) {
				background-image: url("<?php echo $st_h2_bgimg; ?>");
				background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
				<?php if ( $st_h2_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>

	<?php elseif ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'underlinedesign') ): //2色アンダーライン ?>
		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			position: relative;
			padding-left:0;
			padding-bottom: 10px;
			border-top:none;
			border-bottom-width:3px;
			<?php if($st_h2border_undercolor){ //下線基本ボーダー色 ?>
				border-bottom-color: <?php echo $st_h2border_undercolor; ?>;
			<?php } ?>
			<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if ( $st_h2_color ): ?>
				color: <?php echo $st_h2_color; ?>;
			<?php endif; ?>
			background-color:transparent;
		}
		.editor-styles-wrapper .h2modoki::after,
		.editor-styles-wrapper h2:not(.st-css-no)::after {
			position: absolute;
			bottom: -3px;
			left: 0;
			z-index: 2;
			content: '';
			width: 20%;
			height: 3px;
			<?php if($st_h2border_color){ //ボーダーカラー ?>
						background-color: <?php echo $st_h2border_color; ?>;
			<?php } ?>
		}

		<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no) {
				background-image: url("<?php echo $st_h2_bgimg; ?>");
				background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
				<?php if ( $st_h2_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>

	<?php elseif ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'centerlinedesign') ): ?>
		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			overflow: hidden;
			text-align: center;
			border-top:none;
			border-bottom:none;
			padding-left: 20px;
			padding-right: 20px;

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if ( $st_h2_color ): ?>
				color: <?php echo $st_h2_color; ?>;
			<?php endif; ?>
			background-color:transparent;
		}
		.editor-styles-wrapper .h2modoki span,
		.editor-styles-wrapper h2 span {
			position: relative;
			display: inline-block;
			margin: 0 10px;
			padding: 0 20px;
			text-align: left;
		}
		@media only screen and (max-width: 599px) {
			.editor-styles-wrapper .h2modoki span,
			.editor-styles-wrapper h2 span {
				padding: 0 10px;
			}
		}
		.editor-styles-wrapper .h2modoki span.st-dash-design::before,
		.editor-styles-wrapper .h2modoki span.st-dash-design::after,
		.editor-styles-wrapper h2:not(.st-css-no) span.st-dash-design::before,
		.editor-styles-wrapper h2:not(.st-css-no) span.st-dash-design::after {
			position: absolute;
			top: 50%;
			content: '';
			width: 1000%;
			height: 1px;
			background-color: <?php echo $st_h2border_color; ?>;
		}
		.editor-styles-wrapper .h2modoki span.st-dash-design::before,
		.editor-styles-wrapper h2:not(.st-css-no) span.st-dash-design::before {
			right: 100%;
		}
		.editor-styles-wrapper .h2modoki span.st-dash-design::after,
		.editor-styles-wrapper h2:not(.st-css-no) span.st-dash-design::after {
			left: 100%;
		}

		/* hタグ用 キャッチコピー */
		.editor-styles-wrapper .st-dash-design,
		.editor-styles-wrapper .st-dash-design .st-h-copy-toc,
		.editor-styles-wrapper .st-dash-design .st-h-copy {
			text-align: center;
		}

	<?php elseif ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'dotdesign') ): ?>

		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			position: relative;
			padding: 5px;
			border: 1px solid <?php echo $st_h2border_color; ?>;
					color: <?php echo $st_h2_color; ?>;
					<?php if ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) !== '' ) ): ?>
						/*Other Browser*/
						background: <?php echo $st_h2_bgcolor; ?>;
						/* Android4.1 - 4.3 */
						background: url("<?php echo $st_h2_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h2_gradient_w; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);

						/* IE10+, FF16+, Chrome26+ */
						background: url("<?php echo $st_h2_bgimg; ?>"), linear-gradient(to <?php echo $h2_gradient; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);
					<?php elseif ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
						background-image: url("<?php echo $st_h2_bgimg; ?>");
						background-color: <?php echo $st_h2_bgcolor; ?>;
					<?php else: ?>
						background-color: transparent;
						<?php if( $st_h2_bgimg ): //背景画像がある場合 ?>
							background: url("<?php echo $st_h2_bgimg; ?>");
						<?php else: ?>
							background: none;
						<?php endif; ?>
					<?php endif; ?>
		}

		<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no) {
				background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
				<?php if ( $st_h2_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>

		.editor-styles-wrapper .h2modoki span.st-dash-design,
		.editor-styles-wrapper h2:not(.st-css-no) span.st-dash-design {
			display: block;
			padding: 10px;
			<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>

			<?php if($st_h2border_undercolor){ //ドットカラー ?>
				border: 1px dashed <?php echo $st_h2border_undercolor; ?>;
			<?php }else{ ?>
				border: 1px dashed <?php echo $st_h2border_color; ?>;
			<?php } ?>
		}

				<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
				.editor-styles-wrapper .h2modoki,
				.editor-styles-wrapper h2:not(.st-css-no) {
					background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
					<?php if ( $st_h2_bgimg_repeat ): ?>
						background-repeat: no-repeat;
					<?php endif; ?>
				}
				<?php } ?>

	<?php elseif ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'leftlinedesign') ): //左ラインのみ ?>

		.editor-styles-wrapper .h2modoki:before,
		.editor-styles-wrapper h2:not(.st-css-no):before {
			position: absolute;
			content: '';
			width: 6px;
			height: 100%;
			<?php if ( $st_h2border_color ): ?>
				background-color: <?php echo $st_h2border_color; ?>;
			<?php endif; ?>
			left: 0;
			bottom: 0;
		}

		.editor-styles-wrapper .h2modoki:before,
		.editor-styles-wrapper h2:not(.st-css-no):before,
		.editor-styles-wrapper .h2modoki:after,
		.editor-styles-wrapper h2:not(.st-css-no):after {
			border: none;
		}

		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			position: relative;
			padding-left:20px;
			border: none;
			<?php if ( $st_h2_color ): ?>
				color: <?php echo $st_h2_color; ?>;
			<?php endif; ?>
			<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>


			<?php if ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) !== '' ) ): ?>
				/*Other Browser*/
				background: <?php echo $st_h2_bgcolor; ?>;
				/* Android4.1 - 4.3 */
				background: url("<?php echo $st_h2_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h2_gradient_w; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);

				/* IE10+, FF16+, Chrome36+ */
				background: url("<?php echo $st_h2_bgimg; ?>"), linear-gradient(to <?php echo $h2_gradient; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);
			<?php elseif ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
				background-image: url("<?php echo $st_h2_bgimg; ?>");
				background-color: <?php echo $st_h2_bgcolor; ?>;
			<?php else: ?>
				background-color: transparent;
				<?php if( $st_h2_bgimg ): //背景画像がある場合 ?>
					background: url("<?php echo $st_h2_bgimg; ?>");
				<?php else: ?>
					background: none;
				<?php endif; ?>
			<?php endif; ?>

			<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
				background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
				<?php if ( $st_h2_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			<?php } ?>
		}

		<?php elseif (
			( $st_is_ex ) // テーマ分岐
			&& ( trim( $st_h2_designsetting ) !== '' )
			&& ( $st_h2_designsetting === 'checkboxdesign' ) // チェックボックスデザイン
			): ?>

			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no){
				position: relative;
				display: block;
				line-height: 1.5;
				margin-bottom: 20px;
				padding-bottom: 0.5em;
				padding-left: calc(1.5em + 25px);
				<?php if ( $st_h2_bgcolor ): ?>
					background: <?php echo $st_h2_bgcolor; ?>;
				<?php else: ?>
					background-color: transparent;
				<?php endif; ?>
				<?php if ( $st_h2_color ): ?>
					color: <?php echo $st_h2_color; ?>;
				<?php endif; ?>
				<?php if ( $st_h2border_color ): //ボーダーがあるかどうか ?>
					border-bottom: 1px solid <?php echo $st_h2border_color; ?>;
				<?php else: ?>
					border-bottom: 1px solid #ccc;
				<?php endif; ?>
				border-top:none;
			}

			.editor-styles-wrapper .h2modoki:before,
			.editor-styles-wrapper h2:not(.st-css-no):before {
				position: absolute;
				top: calc(50% - .75em);
				left: 10px;
				content: "e907";
				font-family: stsvg;
				<?php if ( $st_h2border_undercolor ): //ボーダーがあるかどうか ?>
					color: <?php echo $st_h2border_undercolor; ?>;
				<?php else: ?>
					color: #ff0000;
				<?php endif; ?>
				z-index: 2;
				margin-right: 15px;
				/*text-shadow: -1px -1px 0 rgba(255, 255, 255, 1), 1px -1px 0 rgba(255, 255, 255, 1), -1px 1px 0 rgba(255, 255, 255, 1), 1px 1px 0 rgba(255, 255, 255, 1);*/
				font-size: 150%;
				line-height: 1.5;
			}

			.editor-styles-wrapper .h2modoki:after,
			.editor-styles-wrapper h2:not(.st-css-no):after {
				content: "e904";
				font-family: stsvg;
				position: absolute;
				z-index: 1;
				left: 10px;
				top: calc(50% - .75em);
				font-size: 150%;
				line-height: 1.5;
				<?php if ( $st_h2border_color ): //ボーダーがあるかどうか ?>
					color: <?php echo $st_h2border_color; ?>;
				<?php else: ?>
					color: #ccc;
				<?php endif; ?>
			}

	<?php elseif ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'underdotdesign') ): ?>

		.editor-styles-wrapper .h2modoki,
		.editor-styles-wrapper h2:not(.st-css-no) {
			border: none;
			border-bottom: 2px dashed <?php echo $st_h2border_color; ?>;
			<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
			<?php } else { ?>
				padding-left:0;
			<?php } ?>
			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if ( $st_h2_color ): ?>
				color: <?php echo $st_h2_color; ?>;
			<?php endif; ?>
			<?php if ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) !== '' ) ): ?>
					/*Other Browser*/
					background: <?php echo $st_h2_bgcolor; ?>;
					/* Android4.1 - 4.3 */
					background: url("<?php echo $st_h2_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h2_gradient_w; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);

					/* IE10+, FF16+, Chrome36+ */
					background: url("<?php echo $st_h2_bgimg; ?>"), linear-gradient(to <?php echo $h2_gradient; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);
				<?php elseif ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
					background-image: url("<?php echo $st_h2_bgimg; ?>");
					background-color: <?php echo $st_h2_bgcolor; ?>;
				<?php else: ?>
					background-color: transparent;
					<?php if( $st_h2_bgimg ): //背景画像がある場合 ?>
						background: url("<?php echo $st_h2_bgimg; ?>");
					<?php else: ?>
						background: none;
					<?php endif; ?>
				<?php endif; ?>
		}
				<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
					.editor-styles-wrapper .h2modoki,
					.editor-styles-wrapper h2:not(.st-css-no):not(.st-matome):not(.rankh2):not(#reply-title) {
						background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
						<?php if ( $st_h2_bgimg_repeat ): ?>
							background-repeat: no-repeat;
						<?php endif; ?>
					}
				<?php } ?>

	<?php else: ?>

		<?php if ( (trim( $st_h2_designsetting) !== '') && ($st_h2_designsetting === 'hukidasidesign') ): //吹き出しデザイン ?>
				.editor-styles-wrapper .h2modoki,
				.editor-styles-wrapper h2:not(.st-css-no) {
					<?php if ( $st_h2_bgcolor ): ?>
						background: <?php echo $st_h2_bgcolor; ?>;
					<?php endif; ?>
					<?php if ( $st_h2_color ): ?>
						color: <?php echo $st_h2_color; ?>;
					<?php endif; ?>
					position: relative;
					border: none;
					margin-bottom:30px;
			<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
			<?php } ?>
				}

				.editor-styles-wrapper .h2modoki:after,
				.editor-styles-wrapper h2:not(.st-css-no):after {
					border-top: 10px solid <?php echo $st_h2_bgcolor; ?>;
					content: '';
					position: absolute;
					border-right: 10px solid transparent;
					border-left: 10px solid transparent;
					bottom: -10px;
					left: 30px;
					border-radius: 2px;
				}
				.editor-styles-wrapper .h2modoki:before,
				.editor-styles-wrapper h2:not(.st-css-no):before {
					border-top: 10px solid <?php echo $st_h2_bgcolor; ?>;
					content: '';
					position: absolute;
					border-right: 10px solid transparent;
					border-left: 10px solid transparent;
					bottom: -10px;
					left: 30px;
				}

				<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
				.editor-styles-wrapper .h2modoki,
				.editor-styles-wrapper h2:not(.st-css-no) {
					background-image: url("<?php echo $st_h2_bgimg; ?>");
					background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
					<?php if ( $st_h2_bgimg_repeat ): ?>
						background-repeat: no-repeat;
					<?php endif; ?>
				}
				<?php } ?>

			<?php elseif (
				( $st_is_ex ) // テーマ分岐
				&& ( trim( $st_h2_designsetting) !== '' )
				&& ( $st_h2_designsetting === 'hukidasidesign_under' ) // 吹き出し下線デザイン
				): ?>

				.editor-styles-wrapper .h2modoki,
				.editor-styles-wrapper h2:not(.st-css-no) {

					position: relative;
					padding: 10px 5px;
					margin-bottom: 30px;
					border: none;

					<?php if ( $st_h2border_color ): //ボーダーがあるかどうか ?>
						border-bottom: 3px solid <?php echo $st_h2border_color; ?>;
					<?php else: ?>
						border-bottom: 3px solid #ccc;
					<?php endif; ?>

					<?php if ( $st_h2_bgcolor ): ?>
						background: <?php echo $st_h2_bgcolor; ?>;
					<?php else: ?>
						background: #fff;
					<?php endif; ?>

					<?php if ( $st_h2_color ): ?>
						color: <?php echo $st_h2_color; ?>;
					<?php endif; ?>

					<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
						padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
					<?php } ?>

					<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
						padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
						padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
					<?php } ?>
				}

				.editor-styles-wrapper .h2modoki::before,
				.editor-styles-wrapper h2:not(.st-css-no)::before,
				.editor-styles-wrapper .h2modoki::after,
				.editor-styles-wrapper h2:not(.st-css-no)::after {
					position: absolute;
					width: 0;
					height: 0;
					border: solid transparent;
					content: "";
					border-top-width: 13px;
					border-right-width: 13px;
					border-bottom-width: 13px;
					border-left-width: 13px;
				}

				.editor-styles-wrapper .h2modoki::before,
				.editor-styles-wrapper h2:not(.st-css-no)::before {
					left: 50px;
					bottom: -28px;
					<?php if ( $st_h2border_color ): //ボーダーがあるかどうか ?>
						border-top-color: <?php echo $st_h2border_color; ?>;
						border-left-color: <?php echo $st_h2border_color; ?>;
					<?php else: ?>
						border-top-color: #ccc;
						border-left-color: #ccc;
					<?php endif; ?>
				}

				.editor-styles-wrapper .h2modoki::after,
				.editor-styles-wrapper h2:not(.st-css-no)::after {
					left: 53px;
					bottom: -21px;
					<?php if ( $st_h2_bgcolor ): ?>
						border-top-color: <?php echo $st_h2_bgcolor; ?>;
						border-left-color: <?php echo $st_h2_bgcolor; ?>;
					<?php else: ?>
						border-top-color: #fff;
						border-left-color: #fff;
					<?php endif; ?>
				}

		<?php else: //吹き出しじゃないデザイン ?>

				.editor-styles-wrapper .h2modoki,
				.editor-styles-wrapper h2:not(.st-css-no) {
					<?php if ( $st_h2_color ): ?>
						color: <?php echo $st_h2_color; ?>;
					<?php endif; ?>
					<?php if ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) !== '' ) ): ?>
						/*Other Browser*/
						background: <?php echo $st_h2_bgcolor; ?>;
						/* Android4.1 - 4.3 */
						background: url("<?php echo $st_h2_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h2_gradient_w; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);

						/* IE10+, FF16+, Chrome26+ */
						background: url("<?php echo $st_h2_bgimg; ?>"), linear-gradient(to <?php echo $h2_gradient_w; ?>,  <?php echo $st_h2_bgcolor_t; ?> 0%,<?php echo $st_h2_bgcolor; ?> 100%);
					<?php elseif ( ( trim( $st_h2_bgcolor ) !== '' ) && ( trim( $st_h2_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
						background-image: url("<?php echo $st_h2_bgimg; ?>");
						background-color: <?php echo $st_h2_bgcolor; ?>;
					<?php else: ?>
						background-color: transparent;
						<?php if( $st_h2_bgimg ): //背景画像がある場合 ?>
							background: url("<?php echo $st_h2_bgimg; ?>");
						<?php else: ?>
							background: none;
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $st_h2border_color ): //ボーダーがあるかどうか ?>
						<?php if ( $st_h2_border_tb ): ?>
							border-top: 1px solid <?php echo $st_h2border_color; ?>;
							border-bottom: 1px solid <?php echo $st_h2border_color; ?>;
						<?php else: ?>
							border: 1px solid <?php echo $st_h2border_color; ?>;
						<?php endif; ?>
					<?php else: ?>
						border: none;
					<?php endif; ?>

					<?php if ( $st_h2border_color ): //ボーダーがあるかどうか ?>
						<?php if ( $st_h2_border_tb_sub ): ?>
							border-top-width: 2px;
							<?php if ( $st_h2border_undercolor ): ?>
								border-bottom-color: <?php echo $st_h2border_undercolor; ?>;
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>

					<?php if( $st_h2_bgimg_leftpadding ){ //左の余白 ?>
						padding-left:<?php echo $st_h2_bgimg_leftpadding; ?>px;
					<?php } ?>

					<?php if($st_h2_bgimg_tupadding){ //上下の余白 ?>
						padding-top:<?php echo $st_h2_bgimg_tupadding; ?>px;
						padding-bottom:<?php echo $st_h2_bgimg_tupadding; ?>px;
					<?php } ?>
				}

				<?php if( $st_h2_bgimg ){ //背景画像がある場合 ?>
					.editor-styles-wrapper .h2modoki,
					.editor-styles-wrapper h2:not(.st-css-no) {
						background-position: <?php echo $st_h2_bgimg_side; ?> <?php echo $st_h2_bgimg_top; ?>;
						<?php if ( $st_h2_bgimg_repeat ): ?>
							background-repeat: no-repeat;
						<?php endif; ?>
					}
				<?php } ?>

			<?php endif; ?>

	<?php endif; //ラインデザインかどうか ?>

	<?php endif; //カスタマイザーのCSSを無効化ここまで ?>

	/* h3 */
	<?php if($st_h3_no_css): //カスタマイザーのCSSを無効化
	else: ?>

	<?php if ( $st_h3_gradient ): //グラデーションを横向きにする
			$h3_gradient_w = 'left';
			$h3_gradient = 'left';
		else :
			$h3_gradient_w = 'top';
			$h3_gradient = 'bottom';
		endif;
	?>

	<?php if($st_h3_bg_radius){ //h3 ?>
		/* 角丸 */
		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			border-radius:5px;
		}
		<?php if ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'leftlinedesign') ): //左ラインのみ ?>
			.editor-styles-wrapper .h3modoki:before,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):before {
				border-radius:3px;
			}
		<?php endif; ?>
	<?php } ?>

	<?php if ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'linedesign') ): //ラインデザイン ?>
		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			position: relative;
			padding: 1em 1em 1em 1.4em;
			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>

			border: 1px solid <?php echo $st_h3border_color; ?>;
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
					<?php if ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) !== '' ) ): ?>
						/*Other Browser*/
						background: <?php echo $st_h3_bgcolor; ?>;
						/* Android4.1 - 4.3 */
						background: url("<?php echo $st_h3_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h3_gradient_w; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);

						/* IE10+, FF16+, Chrome36+ */
						background: url("<?php echo $st_h3_bgimg; ?>"), linear-gradient(to <?php echo $h3_gradient; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);
					<?php elseif ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
						background-image: url("<?php echo $st_h3_bgimg; ?>");
						background-color: <?php echo $st_h3_bgcolor; ?>;
					<?php else: ?>
						background-color: transparent;
						<?php if( $st_h3_bgimg ): //背景画像がある場合 ?>
							background: url("<?php echo $st_h3_bgimg; ?>");
						<?php else: ?>
							background: none;
						<?php endif; ?>
					<?php endif; ?>
		}

		<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
				background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
				<?php if ( $st_h3_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>
		.editor-styles-wrapper .h3modoki::after,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
					position: absolute;
					top: .5em;
					left: .5em;
					content: '';
					width: 5px;
					height: -webkit-calc(100% - 1em);
					height: calc(100% - 1em);
					<?php if($st_h3border_undercolor){ //ボーダーカラー ?>
						background-color: <?php echo $st_h3border_undercolor; ?>;
					<?php }else{ ?>
						background-color: <?php echo $st_h3border_color; ?>;
					<?php } ?>
		}

	<?php elseif ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'stripe_design') ): //ストライプ ?>
		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			<?php if ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) !== '' ) ): ?>
				background: -webkit-repeating-linear-gradient(45deg, <?php echo $st_h3_bgcolor; ?>, <?php echo $st_h3_bgcolor; ?> 5px, <?php echo $st_h3_bgcolor_t; ?> 5px, <?php echo $st_h3_bgcolor_t; ?> 10px);
				background: repeating-linear-gradient(45deg, <?php echo $st_h3_bgcolor; ?>, <?php echo $st_h3_bgcolor; ?> 5px, <?php echo $st_h3_bgcolor_t; ?> 5px, <?php echo $st_h3_bgcolor_t; ?> 10px);
			<?php elseif ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
				background-image: url("<?php echo $st_h3_bgimg; ?>");
				background-color: <?php echo $st_h3_bgcolor; ?>;
			<?php else: ?>

			<?php endif; ?>

			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
			<?php if($st_h3border_color){ //ボーダーカラー ?>
						border: 1px solid <?php echo $st_h3border_color; ?>;
			<?php } ?>
			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
		}

	<?php elseif ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'gradient_underlinedesign') ): //グラデーションアンダーライン ?>

		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			position: relative;
			padding-left:0;
			padding-bottom: 10px;
			border-top:none;
			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
			background-color:transparent;
		}

		.editor-styles-wrapper .h3modoki::after,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
			position: absolute;
			bottom: -3px;
			left: 0;
			z-index: 2;
			content: '';
			width: 100%;
			height: 3px;
			<?php if ( ( trim( $st_h3border_color ) !== '' ) && ( trim( $st_h3border_undercolor ) !== '' ) ): ?>
				/*Other Browser*/
				background: <?php echo $st_h3border_color; ?>;
				/* Android4.1 - 4.3 */
				background: -webkit-linear-gradient(left,  <?php echo $st_h3border_undercolor; ?> 0%,<?php echo $st_h3border_color; ?> 100%);

				/* IE10+, FF16+, Chrome26+ */
				background: linear-gradient(to left,  <?php echo $st_h3border_undercolor; ?> 0%,<?php echo $st_h3border_color; ?> 100%);
			<?php elseif ( ( trim( $st_h3border_color ) !== '' ) && ( trim( $st_h3border_undercolor ) === '' ) ): //下部には色がある場合 ?>
				background-color: <?php echo $st_h3border_color; ?>;
			<?php endif; ?>
		}

		<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
				background-image: url("<?php echo $st_h3_bgimg; ?>");
				background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
				<?php if ( $st_h3_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>

	<?php elseif ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'underlinedesign') ): ?>

		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			position: relative;
			padding-left:0;
			padding-bottom: 10px;
			border-top:none;
			border-bottom-width:3px;
			<?php if($st_h3border_undercolor){ //下線基本ボーダー色 ?>
				border-bottom-color: <?php echo $st_h3border_undercolor; ?>;
			<?php } ?>
			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
			background-color:transparent;
		}

		.editor-styles-wrapper .h3modoki::after,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
			position: absolute;
			bottom: -3px;
			left: 0;
			z-index: 3;
			content: '';
			width: 30%;
			height: 3px;
			<?php if($st_h3border_color){ //ボーダーカラー ?>
						background-color: <?php echo $st_h3border_color; ?>;
			<?php } ?>
		}

		<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
				background-image: url("<?php echo $st_h3_bgimg; ?>");
				background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
				<?php if ( $st_h3_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>

	<?php elseif ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'centerlinedesign') ): ?>

		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			overflow: hidden;
			text-align: center;
			border-top:none;
			border-bottom:none;
			padding-left: 20px;
			padding-right: 20px;

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
					background-color:transparent;
		}

		.editor-styles-wrapper .h3modoki span,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) span {
			position: relative;
			display: inline-block;
			margin: 0 10px;
			padding: 0 20px;
			text-align: left;
		}
		@media only screen and (max-width: 599px) {
			.h3modoki span,
			h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) span {
				padding: 0 10px;
			}
		}

		.editor-styles-wrapper .h3modoki span.st-dash-design::before,
		.editor-styles-wrapper .h3modoki span.st-dash-design::after,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) span.st-dash-design::before,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) span.st-dash-design::after {
			position: absolute;
			top: 50%;
			content: '';
			width: 1000%;
			height: 1px;
			background-color: <?php echo $st_h3border_color; ?>;
		}

		.editor-styles-wrapper .h3modoki span.st-dash-design::before,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) span.st-dash-design::before {
			right: 100%;
		}
		.editor-styles-wrapper .h3modoki span.st-dash-design::after,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) span.st-dash-design::after {
			left: 100%;
		}

		/* hタグ用 キャッチコピー */
		.editor-styles-wrapper .st-dash-design,
		.editor-styles-wrapper .st-dash-design .st-h-copy-toc,
		.editor-styles-wrapper .st-dash-design .st-h-copy {
			text-align: center;
		}

	<?php elseif ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'dotdesign') ): ?>

		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			position: relative;
			padding: 5px;
			border: 1px solid <?php echo $st_h3border_color; ?>;
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
			<?php if ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) !== '' ) ): ?>
				/*Other Browser*/
				background: <?php echo $st_h3_bgcolor; ?>;
				/* Android4.1 - 4.3 */
				background: url("<?php echo $st_h3_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h3_gradient_w; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);

				/* IE10+, FF16+, Chrome36+ */
				background: url("<?php echo $st_h3_bgimg; ?>"), linear-gradient(to <?php echo $h3_gradient; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);
			<?php elseif ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
				background-image: url("<?php echo $st_h3_bgimg; ?>");
				background-color: <?php echo $st_h3_bgcolor; ?>;
			<?php else: ?>
				background-color: transparent;
				<?php if( $st_h3_bgimg ): //背景画像がある場合 ?>
					background: url("<?php echo $st_h3_bgimg; ?>");
				<?php else: ?>
					background: none;
				<?php endif; ?>
			<?php endif; ?>
		}

		<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
				background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
				<?php if ( $st_h3_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			}
		<?php } ?>

		.editor-styles-wrapper .h3modoki span.st-dash-design,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome) span.st-dash-design {
			display: block;
			padding: 10px;
			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if($st_h3border_undercolor){ //ドットカラー ?>
				border: 1px dashed <?php echo $st_h3border_undercolor; ?>;
			<?php }else{ ?>
				border: 1px dashed <?php echo $st_h3border_color; ?>;
			<?php } ?>
		}

	<?php elseif ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'leftlinedesign') ): //左ラインのみ ?>

			.editor-styles-wrapper .h3modoki:before,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):before {
				position: absolute;
				content: '';
				width: 6px;
				height: 100%;
				<?php if ( $st_h3border_color ): ?>
					background-color: <?php echo $st_h3border_color; ?>;
				<?php endif; ?>
				left: 0;
				bottom: 0;
			}

			.editor-styles-wrapper .h3modoki:before,
			.editor-styles-wrapper h3:not(.st-css-no):before,
			.editor-styles-wrapper .h3modoki:after,
			.editor-styles-wrapper h3:not(.st-css-no):after {
				border: none;
			}

			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
				position: relative;
				padding-left:20px;
				border: none;
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>


			<?php if ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) !== '' ) ): ?>
				/*Other Browser*/
				background: <?php echo $st_h3_bgcolor; ?>;
				/* Android4.1 - 4.3 */
				background: url("<?php echo $st_h3_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h3_gradient_w; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);

				/* IE10+, FF16+, Chrome36+ */
				background: url("<?php echo $st_h3_bgimg; ?>"), linear-gradient(to <?php echo $h3_gradient; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);
			<?php elseif ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
				background-image: url("<?php echo $st_h3_bgimg; ?>");
				background-color: <?php echo $st_h3_bgcolor; ?>;
			<?php else: ?>
				background-color: transparent;
				<?php if( $st_h3_bgimg ): //背景画像がある場合 ?>
					background: url("<?php echo $st_h3_bgimg; ?>");
				<?php else: ?>
					background: none;
				<?php endif; ?>
			<?php endif; ?>
			<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
				background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
				<?php if ( $st_h3_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			<?php } ?>
		}

		<?php elseif (
			( $st_is_ex_af ) // テーマ分岐
			&& ( trim( $st_h3_designsetting ) !== '' )
			&& ( $st_h3_designsetting === 'checkboxdesign' ) // チェックボックスデザイン
		): ?>

			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title){
				position: relative;
				display: block;
				line-height: 1.5;
				margin-bottom: 20px;
				padding-bottom: 0.5em;
				padding-left: calc(1.5em + 25px);
				<?php if ( $st_h3_bgcolor ): ?>
					background: <?php echo $st_h3_bgcolor; ?>;
				<?php else: ?>
					background-color: transparent;
				<?php endif; ?>
				<?php if ( $st_h3_color ): ?>
					color: <?php echo $st_h3_color; ?>;
				<?php endif; ?>
				<?php if ( $st_h3border_color ): //ボーダーがあるかどうか ?>
					border-bottom: 1px solid <?php echo $st_h3border_color; ?>;
				<?php else: ?>
					border-bottom: 1px solid #ccc;
				<?php endif; ?>
				border-top:none;
			}

			.editor-styles-wrapper .h3modoki:before,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):before {
				position: absolute;
				top: calc(50% - .75em);
				left: 10px;
				content: "e907";
				font-family: stsvg;
				<?php if ( $st_h3border_undercolor ): //ボーダーがあるかどうか ?>
					color: <?php echo $st_h3border_undercolor; ?>;
				<?php else: ?>
					color: #ff0000;
				<?php endif; ?>
				z-index: 2;
				margin-right: 15px;
				/*text-shadow: -1px -1px 0 rgba(255, 255, 255, 1), 1px -1px 0 rgba(255, 255, 255, 1), -1px 1px 0 rgba(255, 255, 255, 1), 1px 1px 0 rgba(255, 255, 255, 1);*/
				font-size: 150%;
				line-height: 1.5;
			}

			.editor-styles-wrapper .h3modoki:after,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):after {
				content: "e904";
				font-family: stsvg;
				position: absolute;
				z-index: 1;
				left: 10px;
				top: calc(50% - .75em);
				font-size: 150%;
				line-height: 1.5;
				<?php if ( $st_h3border_color ): //ボーダーがあるかどうか ?>
					color: <?php echo $st_h3border_color; ?>;
				<?php else: ?>
					color: #ccc;
				<?php endif; ?>
			}

	<?php elseif ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'underdotdesign') ): ?>

		.editor-styles-wrapper .h3modoki,
		.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			border: none;
			border-bottom: 2px dashed <?php echo $st_h3border_color; ?>;
			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } else { ?>
				padding-left:0;
			<?php } ?>
			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
				<?php if ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) !== '' ) ): ?>
					/*Other Browser*/
					background: <?php echo $st_h3_bgcolor; ?>;
					/* Android4.1 - 4.3 */
					background: url("<?php echo $st_h3_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h3_gradient_w; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);

					/* IE10+, FF16+, Chrome36+ */
					background: url("<?php echo $st_h3_bgimg; ?>"), linear-gradient(to <?php echo $h3_gradient; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);
				<?php elseif ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
					background-image: url("<?php echo $st_h3_bgimg; ?>");
					background-color: <?php echo $st_h3_bgcolor; ?>;
				<?php else: ?>
					background-color: transparent;
					<?php if( $st_h3_bgimg ): //背景画像がある場合 ?>
						background: url("<?php echo $st_h3_bgimg; ?>");
					<?php else: ?>
						background: none;
					<?php endif; ?>
				<?php endif; ?>
		}
				<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
					.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
						background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
						<?php if ( $st_h3_bgimg_repeat ): ?>
							background-repeat: no-repeat;
						<?php endif; ?>
					}
				<?php } ?>

	<?php else: ?>

		<?php if ( (trim( $st_h3_designsetting) !== '') && ($st_h3_designsetting === 'hukidasidesign') ): //吹き出しデザイン ?>
				.editor-styles-wrapper .h3modoki,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
					background: <?php echo $st_h3_bgcolor; ?>;
					color: <?php echo $st_h3_color; ?>;
					position: relative;
					border: none;
					margin-bottom:30px;
			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
				}
				.editor-styles-wrapper .h3modoki:after,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):after {
					border-top: 10px solid <?php echo $st_h3_bgcolor; ?>;
					content: '';
					position: absolute;
					border-right: 10px solid transparent;
					border-left: 10px solid transparent;
					bottom: -10px;
					left: 30px;
					border-radius: 2px;
				}
				.editor-styles-wrapper .h3modoki:before,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):before {
					border-top: 10px solid <?php echo $st_h3_bgcolor; ?>;
					content: '';
					position: absolute;
					border-right: 10px solid transparent;
					border-left: 10px solid transparent;
					bottom: -10px;
					left: 30px;
				}

				<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
				.editor-styles-wrapper .h3modoki,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
					background-image: url("<?php echo $st_h3_bgimg; ?>");
					background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
					<?php if ( $st_h3_bgimg_repeat ): ?>
						background-repeat: no-repeat;
					<?php endif; ?>
				}
				<?php } ?>

			<?php elseif (
				( $st_is_ex ) // テーマ分岐
				&& ( trim( $st_h3_designsetting ) !== '' )
				&& ( $st_h3_designsetting === 'hukidasidesign_under' ) //吹き出し下線デザイン
			): ?>

				.editor-styles-wrapper .h3modoki,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {

					position: relative;
					padding: 10px;
					margin-bottom: 30px;
					border: none;

					<?php if ( $st_h3border_color ): //ボーダーがあるかどうか ?>
						border-bottom: 3px solid <?php echo $st_h3border_color; ?>;
					<?php else: ?>
						border-bottom: 3px solid #ccc;
					<?php endif; ?>

					<?php if ( $st_h3_bgcolor ): ?>
						background: <?php echo $st_h3_bgcolor; ?>;
					<?php else: ?>
						background: #fff;
						padding: 10px 0;
					<?php endif; ?>

					<?php if ( $st_h3_color ): ?>
						color: <?php echo $st_h3_color; ?>;
					<?php endif; ?>

					<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
						padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
					<?php } ?>

					<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
						padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
						padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
					<?php } ?>
				}

				.editor-styles-wrapper .h3modoki:before,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):before,
				.editor-styles-wrapper .h3modoki:after,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):after {
					position: absolute;
					width: 0;
					height: 0;
					border: solid transparent;
					content: "";
					border-top-width: 13px;
					border-right-width: 13px;
					border-bottom-width: 13px;
					border-left-width: 13px;
				}

				.editor-styles-wrapper .h3modoki:before,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):before {
					left: 50px;
					bottom: -28px;
					<?php if ( $st_h3border_color ): //ボーダーがあるかどうか ?>
						border-top-color: <?php echo $st_h3border_color; ?>;
						border-left-color: <?php echo $st_h3border_color; ?>;
					<?php else: ?>
						border-top-color: #ccc;
						border-left-color: #ccc;
					<?php endif; ?>
				}

				.editor-styles-wrapper .h3modoki:after,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):after {
					left: 53px;
					bottom: -21px;
					<?php if ( $st_h3_bgcolor ): ?>
						border-top-color: <?php echo $st_h3_bgcolor; ?>;
						border-left-color: <?php echo $st_h3_bgcolor; ?>;
					<?php else: ?>
						border-top-color: #fff;
						border-left-color: #fff;
					<?php endif; ?>
				}

		<?php else: //吹き出しじゃないデザイン ?>

			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			<?php if ( $st_h3_color ): ?>
				color: <?php echo $st_h3_color; ?>;
			<?php endif; ?>
					<?php if ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) !== '' ) ): ?>
						/*Other Browser*/
						background: <?php echo $st_h3_bgcolor; ?>;
						/* Android4.1 - 4.3 */
						background: url("<?php echo $st_h3_bgimg; ?>"), -webkit-linear-gradient(<?php echo $h3_gradient_w; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);

						/* IE10+, FF16+, Chrome36+ */
						background: url("<?php echo $st_h3_bgimg; ?>"), linear-gradient(to <?php echo $h3_gradient; ?>,  <?php echo $st_h3_bgcolor_t; ?> 0%,<?php echo $st_h3_bgcolor; ?> 100%);
					<?php elseif ( ( trim( $st_h3_bgcolor ) !== '' ) && ( trim( $st_h3_bgcolor_t ) === '' ) ): //下部には色がある場合 ?>
						background-image: url("<?php echo $st_h3_bgimg; ?>");
						background-color: <?php echo $st_h3_bgcolor; ?>;
					<?php else: ?>
						background-color: transparent;
						<?php if( $st_h3_bgimg ): //背景画像がある場合 ?>
							background: url("<?php echo $st_h3_bgimg; ?>");
						<?php else: ?>
							background: none;
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $st_h3border_color ): //ボーダーがあるかどうか ?>
						<?php if ( $st_h3_border_tb ): ?>
							border-top: 1px solid <?php echo $st_h3border_color; ?>;
							border-bottom: 1px solid <?php echo $st_h3border_color; ?>;
						<?php else: ?>
							border: 1px solid <?php echo $st_h3border_color; ?>;
						<?php endif; ?>
					<?php else: ?>
						border: none;
					<?php endif; ?>

					<?php if ( $st_h3border_color ): //ボーダーがあるかどうか ?>
						<?php if ( $st_h3_border_tb_sub ): ?>
							border-top-width: 2px;
							<?php if ( $st_h3border_undercolor ): ?>
								border-bottom-color: <?php echo $st_h3border_undercolor; ?>;
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>

			<?php if( $st_h3_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h3_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h3_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h3_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h3_bgimg_tupadding; ?>px;
			<?php } ?>
				}

				<?php if( $st_h3_bgimg ){ //背景画像がある場合 ?>
					.editor-styles-wrapper .h3modoki,
					.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
						background-position: <?php echo $st_h3_bgimg_side; ?> <?php echo $st_h3_bgimg_top; ?>;
						<?php if ( $st_h3_bgimg_repeat ): ?>
							background-repeat: no-repeat;
						<?php endif; ?>
					}
				<?php } ?>

			<?php endif; ?>

	<?php endif; ?>

	<?php endif; //カスタマイザーのCSSを無効化ここまで ?>

	/*h4*/
	<?php if($st_h4_no_css): //カスタマイザーのCSSを無効化
	else: ?>

	<?php if($st_h4_bg_radius){ //h4 ?>
		/* 角丸 */
		.editor-styles-wrapper .h4modoki,
		.editor-styles-wrapper h4:not(.st-css-no):not(.st-matome):not(.rankh4):not(#reply-title):not(.point){
			border-radius:5px;
		}
	<?php } ?>

	<?php if( $st_h4hukidasi_design ): //ふきだしに変更 ?>
		.editor-styles-wrapper .h4modoki,
		.editor-styles-wrapper h4:not(.st-css-no):not(.st-matome):not(.rankh4):not(#reply-title):not(.point){
			background: <?php echo $st_h4bgcolor; ?>;
			<?php if ( $st_h4_textcolor ): ?>
				color: <?php echo $st_h4_textcolor; ?>;
			<?php endif; ?>
			position: relative;
			border: none;
			margin-bottom:30px;
			<?php if( $st_h4_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h4_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h4_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h4_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h4_bgimg_tupadding; ?>px;
			<?php } ?>

			<?php if( $st_h4_bgimg ){ //背景画像がある場合 ?>
				background-image: url("<?php echo $st_h4_bgimg; ?>");
				background-position: <?php echo $st_h4_bgimg_side; ?> <?php echo $st_h4_bgimg_top; ?>;
				<?php if ( $st_h4_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			<?php } ?>
		}

		.editor-styles-wrapper .h4modoki:after,
		.editor-styles-wrapper h4:not(.st-css-no):not(.st-matome):not(.rankh4):not(#reply-title):not(.point):after {
			border-top: 10px solid <?php echo $st_h4bgcolor; ?>;
			content: '';
			position: absolute;
			border-right: 10px solid transparent;
			border-left: 10px solid transparent;
			bottom: -10px;
			left: 30px;
			border-radius: 2px;
		}

		.editor-styles-wrapper .h4modoki:before,
		.editor-styles-wrapper h4:not(.st-css-no):not(.st-matome):not(.rankh4):not(#reply-title):not(.point):before {
			border-top: 10px solid <?php echo $st_h4bgcolor; ?>;
			content: '';
			position: absolute;
			border-right: 10px solid transparent;
			border-left: 10px solid transparent;
			bottom: -10px;
			left: 30px;
		}
	<?php else: ?>
		.editor-styles-wrapper .h4modoki,
		.editor-styles-wrapper h4:not(.st-css-no):not(.st-matome):not(.rankh4):not(.point) {
			<?php if($st_h4_design){ ?>
				border-left: 5px solid <?php echo $st_h4bordercolor; ?>;
			<?php } ?>
			<?php if ( $st_h4_textcolor ): ?>
				color: <?php echo $st_h4_textcolor; ?>;
			<?php endif; ?>
			<?php if ( $st_h4bgcolor ): ?>
				background-color: <?php echo $st_h4bgcolor; ?>;
			<?php else: ?>
				background-color: transparent;
			<?php endif; ?>

			<?php if($st_h4_top_border){ //上のボーダー ?>
				border-top : solid 1px <?php echo $st_h4bordercolor; ?>;
			<?php } ?>

			<?php if($st_h4_bottom_border){ //下のボーダー ?>
				border-bottom : solid 1px <?php echo $st_h4bordercolor; ?>;
			<?php } ?>

			<?php if( $st_h4_bgimg_leftpadding ){ //左の余白 ?>
				padding-left:<?php echo $st_h4_bgimg_leftpadding; ?>px;
			<?php } ?>

			<?php if($st_h4_bgimg_tupadding){ //上下の余白 ?>
				padding-top:<?php echo $st_h4_bgimg_tupadding; ?>px;
				padding-bottom:<?php echo $st_h4_bgimg_tupadding; ?>px;
			<?php } ?>

			<?php if( $st_h4_bgimg ){ //背景画像がある場合 ?>
				background-image: url("<?php echo $st_h4_bgimg; ?>");
				background-position: <?php echo $st_h4_bgimg_side; ?> <?php echo $st_h4_bgimg_top; ?>;
				<?php if ( $st_h4_bgimg_repeat ): ?>
					background-repeat: no-repeat;
				<?php endif; ?>
			<?php } ?>
		}
	<?php endif; ?>

	<?php if ( $st_h4bgcolor && $st_h4_husen_shadow ): //背景色がある場合 ?>

		/*h4付箋*/
		.editor-styles-wrapper .h4modoki,
		.editor-styles-wrapper h4:not(.st-css-no):not(.st-matome):not(.rankh4):not(#reply-title):not(.point){
			position: relative;
			z-index:1;
		}
		.editor-styles-wrapper .st-h4husen-shadow
		{
			position: relative;
		}
		.editor-styles-wrapper .st-h4husen-shadow:after
		{
			z-index: 0;
			position: absolute;
			content: "";
			bottom:19px;
			right: 8px;
			left: auto;
			width: 50%;
			height:5px;
			max-width:100%;
			background: #777;
			-webkit-box-shadow: 0 15px 10px #777;
			-moz-box-shadow: 0 15px 10px #777;
			box-shadow: 0 15px 10px #777;
			-webkit-transform: rotate(2deg);
			-moz-transform: rotate(2deg);
			-o-transform: rotate(2deg);
			-ms-transform: rotate(2deg);
			transform: rotate(2deg);
		}

	<?php endif; ?>

	<?php endif; //カスタマイザーのCSSを無効化ここまで ?>

	/* h5 */

	<?php if($st_h5_no_css): //カスタマイザーのCSSを無効化
	else: ?>

		<?php if($st_h5_bg_radius){ //h5 ?>
			/* 角丸 */
			.editor-styles-wrapper .h5modoki,
			.editor-styles-wrapper h5:not(.st-css-no):not(.st-matome):not(.rankh5):not(#reply-title):not(.st-cardbox-t):not(.kanren-t):not(.popular-t):not(.post-card-title) {
				border-radius:5px;
			}
		<?php } ?>

		<?php if( $st_h5hukidasi_design ): //ふきだしに変更 ?>
			.editor-styles-wrapper .h5modoki,
			.editor-styles-wrapper h5:not(.st-css-no):not(.st-matome):not(.rankh5):not(#reply-title):not(.st-cardbox-t):not(.kanren-t):not(.popular-t):not(.post-card-title){
				background: <?php echo $st_h5bgcolor; ?>;
				<?php if ( $st_h5_textcolor ): ?>
					color: <?php echo $st_h5_textcolor; ?>;
				<?php endif; ?>
				position: relative;
				border: none;
				margin-bottom:30px;
				padding:10px 10px 10px 15px;
				<?php if( $st_h5_bgimg_leftpadding ){ //左の余白 ?>
					padding-left:<?php echo $st_h5_bgimg_leftpadding; ?>px;
				<?php } ?>

				<?php if($st_h5_bgimg_tupadding){ //上下の余白 ?>
					padding-top:<?php echo $st_h5_bgimg_tupadding; ?>px;
					padding-bottom:<?php echo $st_h5_bgimg_tupadding; ?>px;
				<?php } ?>

				<?php if( $st_h5_bgimg ){ //背景画像がある場合 ?>
					background-image: url("<?php echo $st_h5_bgimg; ?>");
					background-position: <?php echo $st_h5_bgimg_side; ?> <?php echo $st_h5_bgimg_top; ?>;
					<?php if ( $st_h5_bgimg_repeat ): ?>
						background-repeat: no-repeat;
					<?php endif; ?>
				<?php } ?>
			}

			.editor-styles-wrapper .h5modoki:after,
			.editor-styles-wrapper h5:not(.st-css-no):not(.st-matome):not(.rankh5):not(#reply-title):not(.st-cardbox-t):not(.kanren-t):not(.popular-t):not(.post-card-title):after {
				border-top: 10px solid <?php echo $st_h5bgcolor; ?>;
				content: '';
				position: absolute;
				border-right: 10px solid transparent;
				border-left: 10px solid transparent;
				bottom: -10px;
				left: 30px;
				border-radius: 2px;
			}

			.editor-styles-wrapper .h5modoki:before,
			.editor-styles-wrapper h5:not(.st-css-no):not(.st-matome):not(.rankh5):not(#reply-title):not(.st-cardbox-t):not(.kanren-t):not(.popular-t):not(.post-card-title):before {
				border-top: 10px solid <?php echo $st_h5bgcolor; ?>;
				content: '';
				position: absolute;
				border-right: 10px solid transparent;
				border-left: 10px solid transparent;
				bottom: -10px;
				left: 30px;
			}
		<?php else: ?>
			.editor-styles-wrapper .h5modoki,
			.editor-styles-wrapper h5:not(.st-css-no):not(.st-matome):not(.rankh5):not(.point):not(.st-cardbox-t):not(.popular-t):not(.kanren-t):not(.popular-t):not(.post-card-title) {
				<?php if($st_h5_design){ ?>
					border-left: 5px solid <?php echo $st_h5bordercolor; ?>;
				<?php } ?>
				<?php if ( $st_h5_textcolor ): ?>
					color: <?php echo $st_h5_textcolor; ?>;
				<?php endif; ?>
				<?php if ( $st_h5bgcolor ): ?>
					background-color: <?php echo $st_h5bgcolor; ?>;
				<?php else: ?>
					background-color: transparent;
				<?php endif; ?>

				<?php if($st_h5_top_border){ //上のボーダー ?>
					border-top : solid 1px <?php echo $st_h5bordercolor; ?>;
				<?php } ?>

				<?php if($st_h5_bottom_border){ //下のボーダー ?>
					border-bottom : solid 1px <?php echo $st_h5bordercolor; ?>;
				<?php } ?>

				<?php if( $st_h5_bgimg_leftpadding ){ //左の余白 ?>
					padding-left:<?php echo $st_h5_bgimg_leftpadding; ?>px;
				<?php } ?>

				<?php if($st_h5_bgimg_tupadding){ //上下の余白 ?>
					padding-top:<?php echo $st_h5_bgimg_tupadding; ?>px;
					padding-bottom:<?php echo $st_h5_bgimg_tupadding; ?>px;
				<?php } ?>

				<?php if( $st_h5_bgimg ){ //背景画像がある場合 ?>
					background-image: url("<?php echo $st_h5_bgimg; ?>");
					background-position: <?php echo $st_h5_bgimg_side; ?> <?php echo $st_h5_bgimg_top; ?>;
					<?php if ( $st_h5_bgimg_repeat ): ?>
						background-repeat: no-repeat;
					<?php endif; ?>
				<?php } ?>
			}
		<?php endif; ?>

		<?php if ( $st_h5bgcolor && $st_h5_husen_shadow ): //背景色がある場合 ?>

			/*h5付箋*/
			.editor-styles-wrapper .h5modoki,
			.editor-styles-wrapper h5:not(.st-css-no):not(.st-matome):not(.rankh5):not(.point):not(.st-cardbox-t):not(.popular-t):not(.kanren-t):not(.popular-t):not(.post-card-title) {
				position: relative;
				z-index:1;
			}
			.editor-styles-wrapper .st-h5husen-shadow
			{
				position: relative;
			}
			.editor-styles-wrapper .st-h5husen-shadow:after
			{
				z-index: 0;
				position: absolute;
				content: "";
				bottom:19px;
				right: 8px;
				left: auto;
				width: 50%;
				height:5px;
				max-width:100%;
				background: #777;
				-webkit-box-shadow: 0 15px 10px #777;
				-moz-box-shadow: 0 15px 10px #777;
				box-shadow: 0 15px 10px #777;
				-webkit-transform: rotate(2deg);
				-moz-transform: rotate(2deg);
				-o-transform: rotate(2deg);
				-ms-transform: rotate(2deg);
				transform: rotate(2deg);
			}

		<?php endif; ?>

	<?php endif; //カスタマイザーのCSSを無効化ここまで ?>

	<?php if($st_h4_matome_no_css): //カスタマイザーのCSSを無効化
	else: ?>

		<?php if($st_h4_matome_bg_radius){ //まとめタグ ?>
			/* 角丸 */
			.editor-styles-wrapper .st-matome:not(.st-css-no):not(.rankh4):not(#reply-title):not(.point){
				border-radius:5px;
			}
		<?php } ?>

		<?php if( $st_h4_matome_hukidasi_design ): //ふきだしに変更 ?>
			.editor-styles-wrapper .st-matome:not(.st-css-no):not(.rankh4):not(#reply-title):not(.point){
				background: <?php echo $st_h4_matome_bgcolor; ?>;
				<?php if ( $st_h4_matome_textcolor ): ?>
					color: <?php echo $st_h4_matome_textcolor; ?>;
				<?php endif; ?>
				position: relative;
				border: none;
				margin-bottom:30px;
				<?php if( $st_h4_matome_bgimg_leftpadding || $st_h4_matome_bgimg_leftpadding == 0 ){ //左の余白 ?>
					padding-left:<?php echo $st_h4_matome_bgimg_leftpadding; ?>px;
				<?php } ?>

				<?php if($st_h4_matome_bgimg_tupadding){ //上下の余白 ?>
					padding-top:<?php echo $st_h4_matome_bgimg_tupadding; ?>px;
					padding-bottom:<?php echo $st_h4_matome_bgimg_tupadding; ?>px;
				<?php } ?>

				<?php if( $st_h4_matome_bgimg ){ //背景画像がある場合 ?>
					background-image: url("<?php echo $st_h4_matome_bgimg; ?>");
					background-position: <?php echo $st_h4_matome_bgimg_side; ?> <?php echo $st_h4_matome_bgimg_top; ?>;
					<?php if ( $st_h4_matome_bgimg_repeat ): ?>
						background-repeat: no-repeat;
					<?php endif; ?>
				<?php } ?>
			}

			.editor-styles-wrapper .st-matome:not(.st-css-no):not(.rankh4):not(#reply-title):not(.point):after {
				border-top: 10px solid <?php echo $st_h4_matome_bgcolor; ?>;
				content: '';
				position: absolute;
				border-right: 10px solid transparent;
				border-left: 10px solid transparent;
				bottom: -10px;
				left: 30px;
				border-radius: 2px;
			}

			.editor-styles-wrapper .st-matome:not(.st-css-no):not(.rankh4):not(#reply-title):not(.point):before {
				border-top: 10px solid <?php echo $st_h4_matome_bgcolor; ?>;
				content: '';
				position: absolute;
				border-right: 10px solid transparent;
				border-left: 10px solid transparent;
				bottom: -10px;
				left: 30px;
			}
		<?php else: ?>

			.editor-styles-wrapper .st-matome:not(.st-css-no):not(.rankh4):not(.point) {
				<?php if($st_h4_matome_bordercolor): ?>
					border-left: 5px solid <?php echo $st_h4_matome_bordercolor; ?>;
			   <?php endif; ?>
				<?php if($st_h4_matome_textcolor): ?>
					color: <?php echo $st_h4_matome_textcolor; ?>;
				<?php endif; ?>
				<?php if ( $st_h4_matome_bgcolor ): ?>
					background-color: <?php echo $st_h4_matome_bgcolor; ?>;
				<?php else: ?>
					background-color: transparent;
				<?php endif; ?>

				<?php if($st_h4_matome_top_border){ //上のボーダー ?>
					border-top : solid 1px <?php echo $st_h4_matome_bordercolor; ?>;
				<?php } ?>

				<?php if($st_h4_matome_bottom_border){ //下のボーダー ?>
					border-bottom : solid 1px <?php echo $st_h4_matome_bordercolor; ?>;
				<?php } ?>

				<?php if( $st_h4_matome_bgimg_leftpadding || $st_h4_matome_bgimg_leftpadding == 0 ){ //左の余白 ?>
					padding-left:<?php echo $st_h4_matome_bgimg_leftpadding; ?>px;
				<?php } ?>

				<?php if($st_h4_matome_bgimg_tupadding){ //上下の余白 ?>
					padding-top:<?php echo $st_h4_matome_bgimg_tupadding; ?>px;
					padding-bottom:<?php echo $st_h4_matome_bgimg_tupadding; ?>px;
				<?php } ?>

				<?php if( $st_h4_matome_bgimg ){ //背景画像がある場合 ?>
					background-image: url("<?php echo $st_h4_matome_bgimg; ?>");
					background-position: <?php echo $st_h4_matome_bgimg_side; ?> <?php echo $st_h4_matome_bgimg_top; ?>;
					<?php if ( $st_h4_matome_bgimg_repeat ): ?>
						background-repeat: no-repeat;
					<?php endif; ?>
				<?php } ?>
			}
		<?php endif; ?>

	<?php endif; //カスタマイザーのCSSを無効化ここまで ?>

	/*強制センタリング・中央寄せ
	------------------------------------------------------------*/
	<?php if($st_entrytitle_no_css): //カスタマイザーのCSSを無効化 ?>
	<?php else: ?>
	<?php if ( $st_entrytitle_text_center ): //記事タイトル ?>
			.editor-styles-wrapper .entry-title:not(.st-css-no),
			.editor-styles-wrapper .entry-title:not(.st-css-no)
			{
				text-align:center;
				<?php if ( ( $st_entrytitle_designsetting !== 'dotdesign' ) && ( $st_entrytitle_designsetting !== 'linedesign' ) ): //左ラインと囲みドットデザイン以外  ?>
						padding-left:10px;
						padding-right:10px;
				<?php endif; ?>
			}
			<?php if ($st_entrytitle_designsetting === 'hukidasidesign'): //吹き出しデザイン ?>
				.editor-styles-wrapper .entry-title:not(.st-css-no):after,
				.editor-styles-wrapper .entry-title:not(.st-css-no):before,
				.editor-styles-wrapper .entry-title:not(.st-css-no):after,
				.editor-styles-wrapper .entry-title:not(.st-css-no):before {
					left: calc(50% - 10px);
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ( trim( $GLOBALS['stdata366'] ) === '' || ! st_wrap_class_check() ) &&  $st_entrytitle_design_wide ): // LP・1カラム時を全てワイド化する（β）が無効又は1カラム及びLPではない + デザイン幅一杯 ?>
			.editor-styles-wrapper .entry-title:not(.st-css-no),
			.editor-styles-wrapper .entry-title:not(.st-css-no),
			.editor-styles-wrapper .colum1 .entry-title:not(.st-css-no),
			.editor-styles-wrapper .colum1 .entry-title:not(.st-css-no)
			{
					margin-left: -15px;
					margin-right: -15px;
					<?php if ( ($st_entrytitle_designsetting !== 'dotdesign') && ($st_entrytitle_designsetting !== 'linedesign') ): //ドットデザイン及びセンターラインデザインではない場合 ?>
						padding-left:15px;
						padding-right:15px;
					<?php endif; ?>
			}
		<?php endif; ?>
	<?php endif; ?>
	<?php if($st_h2_no_css): //カスタマイザーのCSSを無効化 ?>
	<?php else: ?>
		<?php if ( $st_h2_text_center ): //h2 ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no)
			{
				text-align:center;
				<?php if ( ( $st_h2_designsetting !== 'dotdesign' ) && ( $st_h2_designsetting !== 'linedesign' ) ): //左ラインと囲みドットデザイン以外  ?>
						padding-left:10px;
						padding-right:10px;
				<?php endif; ?>
			}
			<?php if ($st_h2_designsetting === 'hukidasidesign'): //吹き出しデザイン ?>
				.editor-styles-wrapper .h2modoki:after,
				.editor-styles-wrapper .h2modoki:before,
				.editor-styles-wrapper h2:not(.st-css-no):after,
				.editor-styles-wrapper h2:not(.st-css-no):before {
					left: calc(50% - 10px);
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ( trim(  $GLOBALS['stdata366'] ) === '' || ! st_wrap_class_check() ) &&  $st_h2_design_wide ): ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no),
			.editor-styles-wrapper .colum1 .h2modoki,
			.editor-styles-wrapper .colum1 h2:not(.st-css-no)
			{
					margin-left: -15px;
					margin-right: -15px;
					<?php if ( ($st_h2_designsetting !== 'dotdesign') && ($st_h2_designsetting !== 'linedesign') ): //ドットデザイン及びセンターラインデザインではない場合 ?>
						padding-left:15px;
						padding-right:15px;
					<?php endif; ?>
			}
		<?php endif; ?>
	<?php endif; ?>
	<?php if($st_h3_no_css): //カスタマイザーのCSSを無効化 ?>
	<?php else: ?>
		<?php if ( $st_h3_text_center ): //h3 ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)
			{
				text-align:center;
				<?php if ( ( $st_h3_designsetting !== 'dotdesign' ) && ( $st_h3_designsetting !== 'linedesign' ) ): //左ラインと囲みドットデザイン以外  ?>
						padding-left:10px;
						padding-right:10px;
				<?php endif; ?>
			}
			<?php if ($st_h3_designsetting === 'hukidasidesign'): //吹き出しデザイン ?>
				.editor-styles-wrapper .h3modoki:after,
				.editor-styles-wrapper .h3modoki:before,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):after,
				.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title):before {
					left: calc(50% - 10px);
				}
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( ( trim(  $GLOBALS['stdata366'] ) === '' || ! st_wrap_class_check() ) &&  $st_h3_design_wide ): ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title),
			.editor-styles-wrapper .colum1 .h3modoki,
			.editor-styles-wrapper .colum1 h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)
			{
					margin-left: -15px;
					margin-right: -15px;
					<?php if ( ($st_h3_designsetting !== 'dotdesign') && ($st_h3_designsetting !== 'linedesign') ): //ドットデザイン及びセンターラインデザインではない場合 ?>
						padding-left:15px;
						padding-right:15px;
					<?php endif; ?>
			}
		<?php endif; ?>
	<?php endif; ?>

	/*ステップ
	------------------------------------------------------------*/
	.editor-styles-wrapper .st-step {
		<?php if ( $st_step_color ): ?>
			color: <?php echo $st_step_color; ?>;
		<?php endif; ?>
		<?php if ( $st_step_bgcolor ): ?>
			background: <?php echo $st_step_bgcolor; ?>;
		<?php endif; ?>
		<?php if ( $st_step_radius ): //角を丸くする ?>
			border-radius:5px;
		<?php endif; ?>
	}
	<?php if ( $st_step_bgcolor ): ?>
		.editor-styles-wrapper .st-step:before{
			border-top-color: <?php echo $st_step_bgcolor; ?>;
		}
	<?php endif; ?>

	.editor-styles-wrapper .st-step-title {
		<?php if ( $st_step_text_color ): ?>
			color:<?php echo $st_step_text_color; ?>;
		<?php endif; ?>
		<?php if ( $st_step_text_bgcolor ): ?>
			background:<?php echo $st_step_text_bgcolor; ?>;
			<?php if ( $st_step_radius ): //角を丸くする ?>
				border-radius:5px;
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( $st_step_text_border_color ): ?>
			border-bottom:solid 2px <?php echo $st_step_text_border_color; ?>;
		<?php endif; ?>
	}

	<?php if ( $st_step_text_bgcolor ): // テキストの背景色あり ?>
		.editor-styles-wrapper .st-step-box {
			top: -15px;
		}
	<?php else: ?>
		.st-step-box {
			bottom: 15px;
		}
	<?php endif; ?>

	/* ポイント
	------------------------------------------------------------*/
	<?php if ( ( $st_step_color ) || ( $st_step_bgcolor ) ): ?>
		.editor-styles-wrapper .editor-styles-wrapper .editor-styles-wrapper .st-point:before {
			<?php if ( $st_step_color ): ?>
				color: <?php echo $st_step_color; ?>;
			<?php endif; ?>
			<?php if ( $st_step_bgcolor ): ?>
				background: <?php echo $st_step_bgcolor; ?>;
			<?php endif; ?>
		}
	<?php endif; ?>

	/*スライドボックス
	------------------------------------------------------------*/
	<?php if ( $st_slidebox_color ): ?>
		.editor-styles-wrapper .st-slidebox-c {
			background: <?php echo $st_slidebox_color; ?>;
		}
	<?php endif; ?>

	/*--------------------------------
	調整 - editor-style-rich.php
	---------------------------------*/

	<?php // H2 ?>
	<?php if ($st_h2_no_css): ?>   // カスタマイザーのCSSを無効化
	<?php else: ?>
		<?php if ( $st_h2_designsetting === 'hukidasidesign' ):    // 吹き出しデザインに変更（※要背景色） ?>
		<?php elseif ( $st_h2_designsetting === 'linedesign' ):    // 囲み&左ラインデザインに変更（※要ボーダー色） ?>
			.editor-styles-wrapper h2:before {
				content: none;
			}
			.editor-styles-wrapper h2:after {
				border: none;
				bottom: auto;
				border-radius: 0;
			}
		<?php elseif ( $st_h2_designsetting === 'leftlinedesign' ):    // 左ラインデザインに変更（※要ボーダー色） ?>
			.editor-styles-wrapper .h2modoki::before,
			.editor-styles-wrapper .h2modoki::after,
			.editor-styles-wrapper .post h2:not(.st-css-no)::before,
			.editor-styles-wrapper h2:not(.st-css-no)::after {
				content: none;
				border: none;
			}
		<?php elseif ( $st_h2_designsetting === 'underlinedesign' ):    // 2色アンダーラインに変更（※要ボーダー色） ?>
		<?php elseif ( $st_h2_designsetting === 'gradient_underlinedesign' ):    // グラデーションアンダーラインに変更（※要ボーダー色） ?>
		<?php elseif ( $st_h2_designsetting === 'centerlinedesign' ):    // センターラインに変更（※要ボーダー色） ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no) {
				display: -webkit-box;
				display: -webkit-flex;
				display: -ms-flexbox;
				display: flex;
				-webkit-box-pack: justify;
				-webkit-justify-content: space-between;
				-ms-flex-pack: justify;
				justify-content: space-between;
				-webkit-box-align: center;
				-webkit-align-items: center;
				-ms-flex-align: center;
				align-items: center;
				border: 0;
				text-align: center;
			}

			.editor-styles-wrapper .h2modoki::before,
			.editor-styles-wrapper .h2modoki::after,
			.editor-styles-wrapper h2:not(.st-css-no)::before,
			.editor-styles-wrapper h2:not(.st-css-no)::after {
			border: 0;
				position: static;
				display: block;
				content: '';
				height: 1px;
				-webkit-box-flex: 1;
				-webkit-flex-grow: 1;
				-ms-flex-positive: 1;
				flex-grow: 1;
				border: 0;
				background-color: <?php echo $st_h2border_color; ?>;
			}

			.editor-styles-wrapper .h2modoki::before,
			.editor-styles-wrapper h2:not(.st-css-no)::before {
				margin-right: 20px;
			}

			.editor-styles-wrapper .h2modoki::after,
			.editor-styles-wrapper h2:not(.st-css-no)::after {
				margin-left: 20px;
			}
		<?php elseif ( $st_h2_designsetting === 'dotdesign' ):    // 囲みドットデザインに変更（※要ボーダー色） ?>
			.editor-styles-wrapper .h2modoki,
			.editor-styles-wrapper h2:not(.st-css-no) {
				padding: 15px ;
				<?php if ( $st_h2_text_center ): // 中央寄せ ?>
					text-align:center;
				<?php endif; ?>
			}

			.editor-styles-wrapper .h2modoki::before,
			.editor-styles-wrapper h2:not(.st-css-no)::before {
				content: normal;
			}

			.editor-styles-wrapper .h2modoki::after,
			.editor-styles-wrapper h2:not(.st-css-no)::after {
				position: absolute;
				content: '';
				top: 6px;
				right: 6px;
				bottom: 6px;
				left: 6px;
				<?php if ($st_h2border_undercolor):    // ドットカラー ?>
					border: 1px dashed <?php echo $st_h2border_undercolor; ?>;
				<?php else: ?>
					border: 1px dashed <?php echo$st_h2border_color; ?>;
				<?php endif; ?>
			}
		<?php elseif ( $st_h2_designsetting === 'stripe_design' ):    // ストライプデザインに変更（※要背景色） ?>
		<?php elseif ( $st_h2_designsetting === 'underdotdesign' ):    // 下線ドットデザインに変更（※要ボーダー色） ?>
		<?php else:    // なし、その他 ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php // H3 ?>
	<?php if ($st_h3_no_css): ?>   // カスタマイザーのCSSを無効化
	<?php else: ?>
		<?php if ( $st_h3_designsetting === 'hukidasidesign' ):    // 吹き出しデザインに変更（※要背景色） ?>
		<?php elseif ( $st_h3_designsetting === 'linedesign' ):    // 囲み&左ラインデザインに変更（※要ボーダー色） ?>
		<?php elseif ( $st_h3_designsetting === 'leftlinedesign' ):    // 左ラインデザインに変更（※要ボーダー色） ?>
			.editor-styles-wrapper .h3modoki::before,
			.editor-styles-wrapper .h3modoki::after,
			.editor-styles-wrapper .post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::before,
			.editor-styles-wrapper .post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
				content: none;
				border: none;
			}
		<?php elseif ( $st_h3_designsetting === 'underlinedesign' ):    // 2色アンダーラインに変更（※要ボーダー色） ?>
		<?php elseif ( $st_h3_designsetting === 'gradient_underlinedesign' ):    // グラデーションアンダーラインに変更（※要ボーダー色） ?>
		<?php elseif ( $st_h3_designsetting === 'centerlinedesign' ):    // センターラインに変更（※要ボーダー色） ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
				display: -webkit-box;
				display: -webkit-flex;
				display: -ms-flexbox;
				display: flex;
				-webkit-box-pack: justify;
				-webkit-justify-content: space-between;
				-ms-flex-pack: justify;
				justify-content: space-between;
				-webkit-box-align: center;
				-webkit-align-items: center;
				-ms-flex-align: center;
				align-items: center;
				padding-left: 0;
				padding-right: 0;
				text-align: center;
			}

			.editor-styles-wrapper .h3modoki::before,
			.editor-styles-wrapper .h3modoki::after,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::before,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
				position: static;
				display: block;
				content: '';
				height: 1px;
				-webkit-box-flex: 1;
				-webkit-flex-grow: 1;
				-ms-flex-positive: 1;
				flex-grow: 1;
				border: 0;
				background-color: <?php echo $st_h3border_color; ?>;
			}

			.editor-styles-wrapper .h3modoki::before,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::before {
				margin-right: 20px;
			}

			.editor-styles-wrapper .h3modoki::after,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
				margin-left: 20px;
			}
		<?php elseif ( $st_h3_designsetting === 'dotdesign' ):    // 囲みドットデザインに変更（※要ボーダー色） ?>
			.editor-styles-wrapper .h3modoki,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
				padding: 15px ;
				<?php if ( $st_h3_text_center ): // 中央寄せ ?>
					text-align:center;
				<?php endif; ?>
			}

			.editor-styles-wrapper .h3modoki::after,
			.editor-styles-wrapper h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
				position: absolute;
				content: '';
				top: 6px;
				right: 6px;
				bottom: 6px;
				left: 6px;
				<?php if ($st_h3border_undercolor):    // ドットカラー ?>
					border: 1px dashed <?php echo $st_h3border_undercolor; ?>;
				<?php else: ?>
					border: 1px dashed <?php echo $st_h3border_color; ?>;
				<?php endif; ?>
			}
		<?php elseif ( $st_h3_designsetting === 'stripe_design' ):    // ストライプデザインに変更（※要背景色） ?>
		<?php elseif ( $st_h3_designsetting === 'underdotdesign' ):    // 下線ドットデザインに変更（※要ボーダー色） ?>
		<?php else:    // なし、その他 ?>
		<?php endif; ?>
	<?php endif; ?>

<?php endif;    // カスタマイザーの反映 ?>
