<?php
/**
 * ビジュアルエディタのデザインを実際に近づける専用スタイル
 */

header( 'Content-Type: text/css; charset=utf-8' );

require_once __DIR__ . '/../../../wp-load.php';
require_once __DIR__ . '/st-themecss-variables.php'; // カスタマイザー用 CSS 設定読み込み
?>@charset "UTF-8";

<?php // .post ?>
/*
body.mceContentBody {
	position: relative;
	z-index: 0;
}
*/

<?php // H2 ?>
<?php if ($st_h2_no_css): ?>   // カスタマイザーのCSSを無効化
<?php else: ?>
	<?php if ( $st_h2_designsetting === 'hukidasidesign' ):    // 吹き出しデザインに変更（※要背景色） ?>
	<?php elseif ( $st_h2_designsetting === 'linedesign' ):    // 囲み&左ラインデザインに変更（※要ボーダー色） ?>
		h2:before {
    		content: none!important;
		}
		h2:after {
			border: none!important;
 	  		bottom: auto!important;
			border-radius: 0!important;
		}
	<?php elseif ( $st_h2_designsetting === 'leftlinedesign' ):    // 左ラインデザインに変更（※要ボーダー色） ?>
		.h2modoki::before,
		.h2modoki::after,
		.post h2:not(.st-css-no)::before,
		h2:not(.st-css-no)::after {
			content: none!important;
			border: none!important;
		}
	<?php elseif ( $st_h2_designsetting === 'underlinedesign' ):    // 2色アンダーラインに変更（※要ボーダー色） ?>
	<?php elseif ( $st_h2_designsetting === 'gradient_underlinedesign' ):    // グラデーションアンダーラインに変更（※要ボーダー色） ?>
	<?php elseif ( $st_h2_designsetting === 'centerlinedesign' ):    // センターラインに変更（※要ボーダー色） ?>
		.h2modoki,
		.post h2:not(.st-css-no) {
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

		.h2modoki::before,
		.h2modoki::after,
		.post h2:not(.st-css-no)::before,
		h2:not(.st-css-no)::after {
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

		.h2modoki::before,
		.post h2:not(.st-css-no)::before {
			margin-right: 20px;
		}

		.h2modoki::after,
		.post h2:not(.st-css-no)::after {
			margin-left: 20px;
		}
	<?php elseif ( $st_h2_designsetting === 'dotdesign' ):    // 囲みドットデザインに変更（※要ボーダー色） ?>
		.h2modoki,
		.post h2:not(.st-css-no) {
			padding: 15px !important;
			<?php if ( $st_h2_text_center ): // 中央寄せ ?>
				text-align:center;
			<?php endif; ?>
		}

		.h2modoki::before,
		.post h2:not(.st-css-no)::before {
			content: normal;
		}

		.h2modoki::after,
		.post h2:not(.st-css-no)::after {
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
		.h3modoki::before,
		.h3modoki::after,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::before,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
			content: none!important;
			border: none!important;
		}
	<?php elseif ( $st_h3_designsetting === 'underlinedesign' ):    // 2色アンダーラインに変更（※要ボーダー色） ?>
	<?php elseif ( $st_h3_designsetting === 'gradient_underlinedesign' ):    // グラデーションアンダーラインに変更（※要ボーダー色） ?>
	<?php elseif ( $st_h3_designsetting === 'centerlinedesign' ):    // センターラインに変更（※要ボーダー色） ?>
		.h3modoki,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
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

		.h3modoki::before,
		.h3modoki::after,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::before,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
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

		.h3modoki::before,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::before {
			margin-right: 20px;
		}

		.h3modoki::after,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
			margin-left: 20px;
		}
	<?php elseif ( $st_h3_designsetting === 'dotdesign' ):    // 囲みドットデザインに変更（※要ボーダー色） ?>
		.h3modoki,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title) {
			padding: 15px !important;
			<?php if ( $st_h3_text_center ): // 中央寄せ ?>
				text-align:center;
			<?php endif; ?>
		}

		.h3modoki::after,
		.post h3:not(.st-css-no):not(.st-matome):not(.rankh3):not(#reply-title)::after {
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
