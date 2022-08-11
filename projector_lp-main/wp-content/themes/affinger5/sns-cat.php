<?php
if ( trim( $GLOBALS["stdata25"] ) !== '' ) { //Twitterアカウント
	$twitter_name = '&via=' . esc_attr( $GLOBALS["stdata25"] );
} else {
	$twitter_name = '';
}

if ( trim( $GLOBALS["stdata118"] ) !== '' ) { //Twitterハッシュタグ
	$twitter_tag = '&hashtags=' . esc_attr( $GLOBALS["stdata118"] );
} else {
	$twitter_tag = '';
}

$the_term   = get_queried_object(); //現在のターム ID を取得
$url        = get_term_link( $the_term, $the_term->taxonomy );
$url_encode = rawurlencode( $url );
$term_meta  = st_get_term_meta( $the_term );

if ( st_is_ver_ex() ) : // EX
	if ( trim( $term_meta['title'] ) !== '' ) {
		$title        = $term_meta['title'];
		$title_encode = rawurlencode( $title );
	} else {
		$title        = single_term_title( '', false );
		$title_encode = rawurlencode( $title );
	}
else: // EX以外
	if ( trim( $term_meta['st_cattitle'] ) !== '' ) {
		$title        = $term_meta['st_cattitle'];
		$title_encode = rawurlencode( $title );
	} else {
		$title        = single_term_title( '', false );
		$title_encode = rawurlencode( $title );
	}
endif;

if ( function_exists( 'scc_get_share_twitter' ) ) {
	$plug = 'smanone';
} else {
	$plug = '';
}
?>

	<?php if ( isset( $GLOBALS['stdata468'] ) && $GLOBALS['stdata468'] === 'yes' ): // この記事タイトルとURLをコピー ?>
		<div class="st-copyurl-btn">
			<a href="#" rel="nofollow" data-st-copy-text="<?php echo esc_attr( $title . ' / ' . $url ); ?>"><i class="fa fa-clipboard"></i>この記事タイトルとURLをコピー</a>
		</div>
	<?php endif; ?>

	<div class="sns">
	<ul class="clearfix">
		<?php if ( trim( $GLOBALS['stdata410'] ) === '' ): ?>
			<!--ツイートボタン-->
			<li class="twitter"> 
			<a rel="nofollow" onclick="window.open('//twitter.com/intent/tweet?url=<?php echo $url_encode ?><?php echo $twitter_tag ?>&text=<?php echo $title_encode ?><?php echo $twitter_name ?>&tw_p=tweetbutton', '', 'width=500,height=450'); return false;"><i class="fa fa-twitter"></i><span class="snstext <?php echo $plug; ?>" >Twitter</span><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()=='0')?'<span class="snstext pcnone" >Twitter</span>':'<span class="snscount">'.scc_get_share_twitter().'</span>'; ?></a>
			</li>
		<?php endif; ?>

		<?php if ( trim( $GLOBALS['stdata411'] ) === '' ): ?>
			<!--シェアボタン-->      
			<li class="facebook">
			<a href="//www.facebook.com/sharer.php?src=bm&u=<?php echo $url_encode;?>&t=<?php echo $title_encode;?>" target="_blank" rel="nofollow noopener"><i class="fa fa-facebook"></i><span class="snstext <?php echo $plug; ?>" >Share</span>
			<?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'<span class="snstext pcnone" >Share</span>':'<span class="snscount">'.scc_get_share_facebook().'</span>'; ?></a>
			</li>
		<?php endif; ?>

		<?php if ( trim( $GLOBALS['stdata412'] ) === '' ): ?>
			<!--ポケットボタン-->      
			<li class="pocket">
			<a rel="nofollow" onclick="window.open('//getpocket.com/edit?url=<?php echo $url_encode;?>&title=<?php echo $title_encode;?>', '', 'width=500,height=350'); return false;"><i class="fa fa-get-pocket"></i><span class="snstext <?php echo $plug; ?>" >Pocket</span><?php if(function_exists('scc_get_share_pocket')) echo (scc_get_share_pocket()==0)?'<span class="snstext pcnone" >Pocket</span>':'<span class="snscount">'.scc_get_share_pocket().'</span>'; ?></a></li>
		<?php endif; ?>

		<?php if ( trim( $GLOBALS['stdata413'] ) === '' ): ?>
			<!--はてブボタン-->  
			<li class="hatebu">       
				<a href="//b.hatena.ne.jp/entry/<?php echo $url_encode;?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" title="<?php echo esc_attr( $title ); ?>" rel="nofollow"><i class="fa st-svg-hateb"></i><span class="snstext <?php echo $plug; ?>" >Hatena</span>
				<?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'<span class="snstext pcnone" >Hatena</span>':'<span class="snscount"><span class="hatebno">'.scc_get_share_hatebu().'</span></span>';
	 ?></a><script type="text/javascript" src="//b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>

			</li>
		<?php endif; ?>

		<?php if ( trim( $GLOBALS['stdata414'] ) === '' ): ?>
			<!--LINEボタン-->   
			<li class="line">
			<a href="//line.me/R/msg/text/?<?php echo $title_encode . '%0A' . $url_encode;?>" target="_blank" rel="nofollow noopener"><i class="fa fa-comment" aria-hidden="true"></i><span class="snstext" >LINE</span></a>
			</li>
		<?php endif; ?>

		<?php if ( trim( $GLOBALS['stdata415'] ) === '' ): ?>
			<!--URLコピーボタン-->
			<li class="share-copy">
				<a href="#" rel="nofollow" data-st-copy-text="<?php echo esc_attr( $title . ' / ' . $url ); ?>"><i class="fa fa-clipboard"></i><span class="snstext" >コピーする</span></a>
			</li>
		<?php endif; ?>
	</ul>

	</div> 
