<?php
header('Content-Type: text/css; charset=utf-8');
include_once(dirname( __FILE__ ) . '/../../../wp-load.php');

if ( !function_exists( 'sanitize_hex_color' ) ) {
	function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		if ( preg_match( '|\A#([A-Fa-f0-9]{3}){1,2}\z|', $color ) ) {
			return $color;
		}

		return null;
	}
}

if ( isset($GLOBALS['myaf30']) && $GLOBALS['myaf30'] === 'yes' ) { // ボタンで光る演出 ?>
	.rankstlink-a p:not(.no-reflection) a,
	.rankstlink-b p:not(.no-reflection) a,
	.rankstlink-l p:not(.no-reflection) a,
	.rankstlink-r p:not(.no-reflection) a,
	.rankstlink-l2 p:not(.no-reflection) a,
	.rankstlink-r2 p:not(.no-reflection) a {
		position:relative;
		overflow:hidden;
	}
	.rankstlink-a p:not(.no-reflection) a:after,
	.rankstlink-b p:not(.no-reflection) a:after,
	.rankstlink-l p:not(.no-reflection) a:after,
	.rankstlink-r p:not(.no-reflection) a:after,
	.rankstlink-l2 p:not(.no-reflection) a:after,
	.rankstlink-r2 p:not(.no-reflection) a:after{
		content:'';
    	height:100%;
    	width:30px;
    	position:absolute;
    	top:-180px;
    	left:0;
    	background-color: #fff;
    	opacity:0;
    	-webkit-transform: rotate(45deg);
    	-webkit-animation: reflection 3s ease-in-out infinite;
	}
<?php } ?>

<?php //ボタンAのグラデーションを横向きにする
if ( $GLOBALS["myaf28"] ):
		$btn_a_w = 'left';
		$btn_a = 'left';
	else :
		$btn_a_w = 'top';
		$btn_a = 'bottom';	
	endif;

//ボタンBのグラデーションを横向きにする
if ( $GLOBALS["myaf29"] ):
		$btn_b_w = 'left';
		$btn_b = 'left';
	else :
		$btn_b_w = 'top';
		$btn_b = 'bottom';	
	endif;
?>

@charset "UTF-8";
/*----------------------------------
ランク
-----------------------------------*/

<?php if($GLOBALS['stcssdata6']): ?>
.rankst-wrap {
	background-color: <?php echo sanitize_hex_color($GLOBALS['stcssdata6']); ?>;
	padding: 10px;
}
<?php endif; ?>

.rankst-wrap {
	margin-bottom: 10px;
}

.rankst {
	margin-bottom: 10px;
	overflow: hidden;
}

.rankst-box {
	margin-bottom:0px;
}

.rankst p {
	margin-bottom: 10px;
	overflow: hidden;
}

.rankst-cont blockquote {
	background-color: transparent;
	background-image: none;
	padding:0px;
	margin-top: 0px;
	border: none;
}

.rankst-cont {
	margin: 0px;
}

.rankst-l.post, /*ランキング*/
.rankst-l /*ランキングプラグイン*/ 
{
	text-align:center;
	padding:0 0 20px;
}

.rankstlink-l {
	width: 100%;
	text-align: center;
}

.rankstlink-r {
	float: right;
	width: 100%;
}

/*詳細ページへのリンクボタン*/
.rankstlink-l p a {
	display: block;
	width: 100%;
	box-sizing:border-box;
	text-align: center;
	padding: 10px;
	/*Other Browser*/
	background: <?php echo sanitize_hex_color($GLOBALS['stcssdata3']); ?>;
	/* Android4.1 - 4.3 */
	background: -webkit-linear-gradient(<?php echo $btn_a_w; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata3']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata9']); ?> 100%);   
	/* IE10+, FF16+, Chrome26+ */
	background: linear-gradient(to <?php echo $btn_a; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata3']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata9']); ?> 100%);
	color: <?php echo sanitize_hex_color($GLOBALS['stcssdata1']); ?>;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
}

.rankstlink-l p {
	width: 90%;
	text-align: center;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-shadow: 0 3px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata7']); ?>;
	position:relative;
}

.rankstlink-l p:hover {
	box-shadow: 0 1px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata7']); ?>;
	top:1px;
}

/*投稿用詳細ページリンクボタン*/
.rankstlink-l2 p a {
	display: block;
	width: 100%;
	box-sizing:border-box;
	text-align: center;
	padding: 10px;
	/* Android4.1 - 4.3 */
	background: -webkit-linear-gradient(<?php echo $btn_a_w; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata3']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata9']); ?> 100%);   
	/* IE10+, FF16+, Chrome26+ */
	background: linear-gradient(to <?php echo $btn_a; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata3']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata9']); ?> 100%);
	color: <?php echo sanitize_hex_color($GLOBALS['stcssdata1']); ?>;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-sizing:border-box;
}

.rankstlink-l2 p {
	width: 90%;
	text-align: center;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-shadow: 0 3px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata7']); ?>;
	position:relative;
}

.rankstlink-l2 p:hover {
	box-shadow: 0 1px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata7']); ?>;
	top:1px;
}


/*詳細ページのみ*/

.rankstlink-b p a {
	display: block;
	width: 100%;
	box-sizing:border-box;
	text-align: center;
	padding: 10px;
	/* Android4.1 - 4.3 */
	background: -webkit-linear-gradient(<?php echo $btn_a_w; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata3']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata9']); ?> 100%);   
	/* IE10+, FF16+, Chrome26+ */
	background: linear-gradient(to <?php echo $btn_a; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata3']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata9']); ?> 100%);
	color: <?php echo sanitize_hex_color($GLOBALS['stcssdata1']); ?>;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
}

	width: 90%;
	text-align: center;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-shadow: 0 3px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata7']); ?>;
	position:relative;
}

.rankstlink-b p:hover {
	box-shadow: 0 1px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata7']); ?>;
	top:1px;
}

/*アフィリエイトのリンクボタン*/
.rankstlink-r p a {
	display: block;
	width: 100%;
	box-sizing:border-box;
	text-align: center;
	padding: 10px;
	/* Android4.1 - 4.3 */
	background: -webkit-linear-gradient(<?php echo $btn_b_w; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata2']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata10']); ?> 100%);   
	/* IE10+, FF16+, Chrome26+ */
	background: linear-gradient(to <?php echo $btn_b; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata2']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata10']); ?> 100%);
	color: <?php echo sanitize_hex_color($GLOBALS['stcssdata1']); ?>;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
}

.rankstlink-r p {
	width: 90%;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	box-shadow: 0 3px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata8']); ?>;
	position:relative;
}

.rankstlink-r p img{
	display:none;
}

.rankstlink-r p:hover {
	box-shadow: 0 1px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata8']); ?>;
	top:1px;
}

/*投稿用公式リンク*/
.rankstlink-r2 p a {
	display: block;
	width: 100%;
	box-sizing:border-box;
	text-align: center;
	padding: 10px;
	/* Android4.1 - 4.3 */
	background: -webkit-linear-gradient(<?php echo $btn_b_w; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata2']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata10']); ?> 100%);   
	/* IE10+, FF16+, Chrome26+ */
	background: linear-gradient(to <?php echo $btn_b; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata2']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata10']); ?> 100%);
	color: <?php echo sanitize_hex_color($GLOBALS['stcssdata1']); ?>;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
	box-sizing:border-box;
}

.rankstlink-r2 p {
	width: 90%;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	box-shadow: 0 3px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata8']); ?>;
	position:relative;
}

.rankstlink-r2 p img{
	display:none;
}

.rankstlink-r2 p br{
	display:none;
}

.rankstlink-r2 p:hover {
	box-shadow: 0 1px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata8']); ?>;
	top:1px;
}

/*ボタンのアイコン*/
.rankstlink-r2 .fa,
.rankstlink-l2 .fa {
	margin-right: 5px;
}

/*アフィリエイトリンクのみ*/

.rankstlink-a p a {
	display: block;
	width: 100%;
	box-sizing:border-box;
	text-align: center;
	padding: 10px;
	/* Android4.1 - 4.3 */
	background: -webkit-linear-gradient(<?php echo $btn_b_w; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata2']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata10']); ?> 100%);   
	/* IE10+, FF16+, Chrome26+ */
	background: linear-gradient(to <?php echo $btn_b; ?>,  <?php echo sanitize_hex_color($GLOBALS['stcssdata2']); ?> 0%,<?php echo sanitize_hex_color($GLOBALS['stcssdata10']); ?> 100%);
	color: <?php echo sanitize_hex_color($GLOBALS['stcssdata1']); ?>;
	text-decoration: none;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	font-weight:bold;
}

.rankstlink-a p {
	width: 90%;
	margin-right: auto;
	margin-left: auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	box-shadow: 0 3px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata8']); ?>;
	position:relative;
}

.rankstlink-a p img{
	display:none;
}

.rankstlink-a p:hover {
	box-shadow: 0 1px 0 <?php echo sanitize_hex_color($GLOBALS['stcssdata8']); ?>;
	top:1px;
}


.rankst-box .clearfix.rankst .rankst-l a img, .rankst-box .clearfix.rankst .rankst-l iframe {
	padding:0;
	max-width:100%;
	box-sizing: border-box;
	margin:0 auto;
}

.rankh4:not(.st-css-no), 
.post .rankh4:not(.st-css-no),
#side .rankh4:not(.st-css-no) {
	padding: 15px 20px 15px 60px;
	background-repeat: no-repeat;
	background-position: left center;
	font-size: 20px;
	line-height: 1.3;
	color:#000;
	background-color : transparent ;
	<?php if ( trim( $GLOBALS["myaf18"] ) !== '' ) { ?>
		background-image: url(<?php echo $GLOBALS["myaf18"];?>);
	<?php }else{ ?>
		background-image: url(images/oukan.png);
	<?php } ?>
}


.rankh4:not(.st-css-no):not(.rankh4-sc), 
.post .rankh4:not(.st-css-no):not(.rankh4-sc),
#side .rankh4:not(.st-css-no):not(.rankh4-sc) {

	<?php if ( trim( $GLOBALS["stcssdata13"] ) !== '' || trim( $GLOBALS["stcssdata12"] ) !== '' ) { // 背景色又は下線がある ?>
		margin-bottom: 15px;
	<?php }else{ ?>
		margin-bottom: 10px;
	<?php } ?>
	<?php if ( trim( $GLOBALS["stcssdata11"] ) !== '' ) { ?>
		color: <?php echo sanitize_hex_color($GLOBALS['stcssdata11']); ?>;
	<?php }else{ ?>
		color:#000;
	<?php } ?>
	<?php if ( trim( $GLOBALS["stcssdata12"] ) !== '' ) { ?>
		background-color : <?php echo sanitize_hex_color($GLOBALS['stcssdata12']); ?>;
	<?php }else{ ?>
		background-color : transparent ;
	<?php } ?>
	<?php if ( trim( $GLOBALS["stcssdata13"] ) !== '' ) { ?>
		border-bottom : solid 1px <?php echo sanitize_hex_color($GLOBALS['stcssdata13']); ?>;
	<?php } ?>
	<?php if ( trim( $GLOBALS["myaf31"] ) !== '' ) { ?>
		border-radius: 5px;
	<?php } ?>
	<?php if ( trim( $GLOBALS["myaf18"] ) !== '' ) { ?>
		background-image: url(<?php echo $GLOBALS["myaf18"];?>);
	<?php }else{ ?>
		background-image: url(images/oukan.png);
	<?php } ?>
}

<?php if ( trim( $GLOBALS["myaf27"] ) !== '' ) { ?>
	.rankh4:not(.st-css-no), 
	.post .rankh4:not(.st-css-no),
	#side .rankh4:not(.st-css-no) {
		padding-left: 0!important;
		background-image: none!important;
	}
<?php } ?>

/* 中見出し */
.rankh3:not(.st-css-no) {
	position: relative;
	background: <?php echo sanitize_hex_color($GLOBALS['stcssdata4']); ?>;
	color: <?php echo sanitize_hex_color($GLOBALS['stcssdata5']); ?>!important;
	font-size: 18px;
	line-height: 27px;
	margin-bottom: 20px;
	padding-top: 10px;
	padding-right: 20px;
	padding-bottom: 10px;
	padding-left: 20px;
	border-bottom:none!important;
	text-align:center;
}


.rankh3:not(.st-css-no):before {
	content: "";
	position: absolute;
	top: 100%;
	left: 50%;
 	margin-left: -10px;
	border: 10px solid transparent;
	border-top: 10px solid <?php echo sanitize_hex_color($GLOBALS['stcssdata4']); ?>;
}

/* フッター */
#footer .st_rankside {
    margin-bottom: 10px;
}

#footer .st_side_rankwidgets {
    margin-bottom: 20px;
}

#footer .rankh3:not(.st-css-no) {
background-color: transparent;
    margin-bottom: 0;
    padding:0 0 10px 0;
    text-align: left;
}

#footer .rankh3:not(.st-css-no):before {
    content: none;
}

#footer .rankwidgets-item {
f    ont-size: 110%;
line-height: 1.3;
padding-top:5px;
}
#footer .rankwidgets-item .st-star {
    font-size: 80%;
}

#footer .st_rankside_all {
margin-left:10px;
padding-left: 45px;
}

/* スライドメニュー内 */
#s-navi dl.acordion .rankh3.rankwidgets-title {
	font-size:90%;
	line-height:1.5;
	margin-bottom:20px;
	padding:10px;
}

#s-navi dl.acordion .rankwidgets-item {
	font-size:90%;
	line-height:1.5;
}

.post .rankst-cont h4:not(.st-css-no),
.rankst-cont h4:not(.st-css-no) {
background-color:#FCFC88;
padding:10px;
margin-bottom:10px;
}

/*コンテンツ内の見出し*/
.post .rankst-cont h2:not(.st-css-no),
.post .rankst-cont h3:not(.st-css-no),
.post .rankst-cont h4:not(.st-css-no),
.post .rankst-cont h5:not(.st-css-no) {
	margin-top: 0;
}

/*ランキングナンバー*/

.rankh4.rankno-1:not(.st-css-no), 
.post .rankh4.rankno-1:not(.st-css-no), 
#side .rankh4.rankno-1:not(.st-css-no),
.rankid1 .rankh4:not(.st-css-no), 
.post .rankid1 .rankh4:not(.st-css-no), 
#side .rankid1 .rankh4:not(.st-css-no) {
	<?php if ( trim( $GLOBALS["myaf19"] ) !== '' ) { ?>
		background-image: url(<?php echo $GLOBALS["myaf19"];?>);
	<?php }else{ ?>
		<?php if ( trim( $GLOBALS["myaf18"] ) !== '' ) { ?>
			background-image: url(<?php echo $GLOBALS["myaf18"];?>);
		<?php }else{ ?>
			background-image: url(images/oukan1.png);
		<?php } ?>
	<?php } ?>
}

.rankh4.rankno-2:not(.st-css-no), 
.post .rankh4.rankno-2:not(.st-css-no), 
#side .rankh4.rankno-2:not(.st-css-no),
.rankid2 .rankh4:not(.st-css-no), 
.post .rankid2 .rankh4:not(.st-css-no), 
#side .rankid2 .rankh4:not(.st-css-no) {
	<?php if ( trim( $GLOBALS["myaf20"] ) !== '' ) { ?>
		background-image: url(<?php echo $GLOBALS["myaf20"];?>);
	<?php }else{ ?>
		<?php if ( trim( $GLOBALS["myaf18"] ) !== '' ) { ?>
			background-image: url(<?php echo $GLOBALS["myaf18"];?>);
		<?php }else{ ?>
			background-image: url(images/oukan2.png);
		<?php } ?>
	<?php } ?>
}

.rankh4.rankno-3:not(.st-css-no), 
.post .rankh4.rankno-3:not(.st-css-no), 
#side .rankh4.rankno-3:not(.st-css-no),
.rankid3 .rankh4:not(.st-css-no), 
.post .rankid3 .rankh4:not(.st-css-no), 
#side .rankid3 .rankh4:not(.st-css-no) {
	<?php if ( trim( $GLOBALS["myaf21"] ) !== '' ) { ?>
		background-image: url(<?php echo $GLOBALS["myaf21"];?>);
	<?php }else{ ?>
		<?php if ( trim( $GLOBALS["myaf18"] ) !== '' ) { ?>
			background-image: url(<?php echo $GLOBALS["myaf18"];?>);
		<?php }else{ ?>
			background-image: url(images/oukan3.png);
		<?php } ?>
	<?php } ?>
}

.rankh4.rankno-4:not(.st-css-no), 
.post .rankh4.rankno-4:not(.st-css-no), 
#side .rankh4.rankno-4:not(.st-css-no),
.rankid-normal .rankh4:not(.st-css-no), 
.post .rankid-normal .rankh4:not(.st-css-no), 
#side .rankid-normal .rankh4:not(.st-css-no) {
	background-image: url(images/oukan4.png);
}

/*サイドバー*/

#side .rankst-l,#side .rankst-r{
	float:none;
	width:100%;
}

#side .rankst-box .clearfix.rankst .rankst-l a img{
	float:none;
	width:100%;
}

#side .rankst-r,#side .rankst-l,#side .rankst-cont{
	margin:0;
}

#side .rankst-ls img {
	max-width: 100% !important;
	margin:0 auto;
}

#side .rankst-ls {
	text-align:center;
}

/*----------------------------------
サイドバーウィジェットランキング
-----------------------------------*/

.rankh3.rankwidgets-title:not(.st-css-no) {
    font-weight: bold;
	margin-bottom: 25px;
}

#side .rankh3.rankwidgets-title:not(.st-css-no) {
	font-size: 18px;
	line-height: 30px;
	padding-top: 10px;
    padding-bottom: 10px;
}

.rankwidgets-poprank {
	position: relative;
	width:100px;
	float:left;
}

.st_rankside {
	overflow: hidden;
	margin-bottom:15px;
}

.st_rankside_r{
	float: right;
	width: 100%;
	margin-right:-110px; 
	padding-right: 110px;
	box-sizing: border-box;
}

.rankwidgets-no {
    /* font-family: 'Montserrat', sans-serif; */
    position: absolute;
    top: 0;
    left: 0;
    padding: 2px 8px;
    background: #78909C;
    font-size: 13px;
    font-weight: bold;
    color: #fff;
}

.rankwidgets-item {
	margin-bottom: 0;
}

.rankwidgets-item a {
	font-weight: bold;
	color: #1a1a1a;
}

/*ランキング*/
.rankwidgets-side-rank1 {
    background: #c4bf2c;
}
.rankwidgets-side-rank2 {
    background: #9E9E9E;
}
.rankwidgets-side-rank3 {
    background: #795548;
}

/*説明*/
.rankwidgets-cont p,
.rankwidgets-cont a{
	margin-bottom: 0;
	line-height: 1.3;
	font-size: 80%;
}

/*バナー画像が無い場合*/
.st_rankside_all {
	padding-left: 50px;
	background-repeat: no-repeat;
    background-position: left center;
	background-image: url(images/oukan_side4.png);
}

.st_rankside1 .st_rankside_all {
	background-image: url(images/oukan_side1.png);
}
.st_rankside2 .st_rankside_all {
	background-image: url(images/oukan_side2.png);
}
.st_rankside3 .st_rankside_all {
	background-image: url(images/oukan_side3.png);
}

/*media Queries スマートフォンとタブレットサイズ（959px以下）で適応したいCSS - スマホ・タブレット
---------------------------------------------------------------------------------------------------*/
@media only screen and (max-width: 959px) {


}

/*media Queries タブレットサイズ（600px～959px）のみで適応したいCSS -タブレットのみ
---------------------------------------------------------------------------------------------------*/
@media only screen and (min-width: 600px) and (max-width: 959px) {

	/*ランキング大見出し*/
	.rankh3:not(.st-css-no) {
		font-size: 110%;
    	line-height: 1.5;
		padding:15px;
	}

	#side .rankst-box .clearfix.rankst .rankst-l a img {
		float: left;
		padding:0;
		margin:0!important;
	}

	#side .rankst-cont {
		margin: 0 0 0 165px;
	}

	#side .rankst-r {
		position:relative;
		z-index:1;
		float: right;
		width: 100%;
		margin: 0 0 0 -150px;
	}

	#side .rankst-l {
		position:relative;
		z-index:2;
		float: left;
		width: 150px;
	}

	#side .rankstlink-l {
		float: left;
		width: 50%;
	}

	#side .rankstlink-r {
		float: right;
		width: 50%;
	}

/*-- ここまで --*/
}

/*media Queries タブレット（600px）以上で適応したいCSS -タブレット・PC
---------------------------------------------------------------------------------------------------*/
@media only screen and (min-width: 600px) {

	.rankst-box .clearfix.rankst .rankst-l a img {
		float: left;
		padding:0;
		margin:0!important;
	}

	.rankst-cont {
		margin: 0 0 0 165px;
	}

	.rankst-r {
		position:relative;
		z-index:1;
		float: right;
		width: 100%;
		margin: 0 0 0 -150px;
	}

	.rankst-l {
		position:relative;
		z-index:2;
		float: left;
		width: 150px;
	}

	<?php if($GLOBALS['stcssdata6']): ?>
		.rankst-wrap {
			padding: 20px;
		}
	<?php endif; ?>

	/*-- ここまで --*/
}

/*media Queries PCサイズ（960px）以上で適応したいCSS - PCのみ
---------------------------------------------------------------------------------------------------*/
@media print, screen and (min-width: 960px) {

	#side .rankh3.rankwidgets-title:not(.st-css-no) {
		font-size: 14px;
		line-height: 25px;
		padding-top: 5px;
    	padding-bottom: 5px;
	}

	.rankstlink-l {
		float: left;
		width: 50%;
	}

	.rankstlink-r {
		float: right;
		width: 50%;
	}

	#side .rankstlink-l,
	#side .rankstlink-r {
    	float: none;
    	width: 100%;
	}

	/*----------------------------------
	ランク-1カラム
	-----------------------------------*/
	.colum1 .rankst-r {
		float: right;
		width: 100%;
		margin: 0 0 0 -320px;
	}

	.colum1 .rankst-l {
		float: left;
		width: 300px;
	}

	.colum1 .rankst-cont {
		margin: 0 0 0 320px;
	}

	/*投稿用ボタンリンク*/
	.rankstlink-r2 p,
	.rankstlink-l2 p {
		width: 50%;
	}
	#side .rankstlink-r2 p,
	#side .rankstlink-l2 p {
		width: 100%;
	}

	/*-- ここまで --*/
}

/*media Queries スマートフォンのみ（600px）以下
---------------------------------------------------------------------------------------------------*/
@media only screen and (max-width: 599px) {
	.rankst-box .clearfix.rankst .rankst-l a img {
		float: none;
		width: 100%;
	}

/*-- ここまで --*/
}
