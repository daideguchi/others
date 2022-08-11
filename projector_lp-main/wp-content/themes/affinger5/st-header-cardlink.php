<?php
$cards = array(
	array(
		'img_url'    => trim( $GLOBALS["stdata337"] ),                 // ヘッダーカード1（テキスト）
		'text'       => trim( stripslashes( $GLOBALS["stdata338"] ) ), // ヘッダーカード1（テキスト）
		'link_url'   => trim( $GLOBALS["stdata339"] ),                 // ヘッダーカード1（リンクURL）
		'hide_on_pc' => trim( $GLOBALS["stdata350"] ),                 // ヘッダーカード1（PC非表示）
		'hide_on_sp' => trim( $GLOBALS["stdata351"] ),                 // ヘッダーカード1（SC非表示）
	),
	array(
		'img_url'    => trim( $GLOBALS["stdata340"] ),                 // ヘッダーカード2（テキスト）
		'text'       => trim( stripslashes( $GLOBALS["stdata341"] ) ), // ヘッダーカード2（テキスト）
		'link_url'   => trim( $GLOBALS["stdata342"] ),                 // ヘッダーカード2（リンクURL）
		'hide_on_pc' => trim( $GLOBALS["stdata352"] ),                 // ヘッダーカード2（PC非表示）
		'hide_on_sp' => trim( $GLOBALS["stdata353"] ),                 // ヘッダーカード2（SC非表示）
	),
	array(
		'img_url'    => trim( $GLOBALS["stdata343"] ),                 // ヘッダーカード3（テキスト）
		'text'       => trim( stripslashes( $GLOBALS["stdata344"] ) ), // ヘッダーカード3（テキスト）
		'link_url'   => trim( $GLOBALS["stdata345"] ),                 // ヘッダーカード3（リンクURL）
		'hide_on_pc' => trim( $GLOBALS["stdata354"] ),                 // ヘッダーカード3（PC非表示）
		'hide_on_sp' => trim( $GLOBALS["stdata355"] ),                 // ヘッダーカード3（SC非表示）
	),
	array(
		'img_url'    => trim( $GLOBALS["stdata346"] ),                 // ヘッダーカード4（テキスト）
		'text'       => trim( stripslashes( $GLOBALS["stdata347"] ) ), // ヘッダーカード4（テキスト）
		'link_url'   => trim( $GLOBALS["stdata348"] ),                 // ヘッダーカード4（リンクURL）
		'hide_on_pc' => trim( $GLOBALS["stdata356"] ),                 // ヘッダーカード4（PC非表示）
		'hide_on_sp' => trim( $GLOBALS["stdata357"] ),                 // ヘッダーカード4（SC非表示）
	),
);

$blur = ( $GLOBALS['stdata349'] === 'yes' );
$dark = ( $GLOBALS['stdata349'] === 'dark' );

$is_mobile = wp_is_mobile();

$include_pc_cards = function ( $card ) {
	return ( $card['img_url'] !== '' && $card['hide_on_pc'] === '' );
};

$include_mobile_cards = function ( $card ) {
	return ( $card['img_url'] !== '' && $card['hide_on_sp'] === '' );
};

$cards      = array_filter( $cards, $is_mobile ? $include_mobile_cards : $include_pc_cards );
$card_count = count( $cards );
?>

<?php if ( ( $card_count >= 1 ) && ( is_front_page() || trim( $GLOBALS["stdata358"] ) !== '' ) ): ?>
	<?php
	$column_count = $is_mobile
		? min( max( $card_count, 1 ), 2 )
		: min( max( $card_count, 1 ), 4 );

	$column_class = 'st-cardlink-column-' . $column_count;
	?>
	<div id="st-header-cardlink-wrapper">
		<ul id="st-header-cardlink" class="st-cardlink-column-d <?php echo esc_attr( $column_class ); ?>">
			<?php foreach ( $cards as $card ): ?>
				<?php $card_class = ( $card['link_url'] !== '' ) ? ' has-link' : ''; ?>

				<?php if ( $card['text'] !== '' ): ?>
					<?php $card_class .= $blur ? ' is-blurable' : ''; ?>
					<?php $card_class .= $dark ? ' is-darkable' : ''; ?>

					<li class="st-cardlink-card has-bg<?php echo esc_attr( $card_class ); ?>"
						style="background-image: url(<?php echo esc_url( $card['img_url'] ); ?>);">
						<?php if ( $card['link_url'] !== '' ): ?>
							<a class="st-cardlink-card-link" href="<?php echo esc_url( $card['link_url'] ); ?>">
								<div class="st-cardlink-card-text"><?php echo $card['text']; ?></div>
							</a>
						<?php else: ?>
							<div class="st-cardlink-card-text"><?php echo $card['text']; ?></div>
						<?php endif; ?>
					</li>
				<?php else: ?>
					<li class="st-cardlink-card<?php echo esc_attr( $card_class ); ?>">
						<?php if ( $card['link_url'] !== '' ): ?>
							<a class="st-cardlink-card-link" href="<?php echo esc_url( $card['link_url'] ); ?>">
								<img src="<?php echo esc_url( $card['img_url'] ); ?>" alt="">
							</a>
						<?php else: ?>
							<img src="<?php echo esc_url( $card['img_url'] ); ?>" alt="">
						<?php endif; ?>
					</li>
				<?php endif; ?>

			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
