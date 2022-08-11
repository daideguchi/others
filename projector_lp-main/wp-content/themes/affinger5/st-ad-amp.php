<?php //AMP用の広告読み込み
global $wp_query;

$postID = $wp_query->post->ID;
$hide_koukoku = get_post_meta( $postID, 'koukoku_set', true ); // 広告を表示しない (隠す)

$ad_client = get_option( 'st-data121', '' );
$ad_slot = get_option( 'st-data122', '' );
$is_ad_empty = ( $ad_client === '' || $ad_slot === '' ); // ad_client が空か ad_slot が空
?>

<?php if ( ( isset( $hide_koukoku ) && $hide_koukoku === 'yes' ) || $is_ad_empty ) : //広告非表示/未設定の場合 ?>

<?php else : ?>

	<amp-ad
		type="adsense"
		data-ad-client="ca-pub-<?php echo esc_js( $ad_client ); ?>"
		data-ad-slot="<?php echo esc_js( $ad_slot ); ?>"
		width="300"
		height="250">
	</amp-ad>

<?php endif; ?>