<?php
function st_og_type_attribute() {
	if ( is_single() ) {
		echo 'article';
	} else {
		echo 'website';
	}
}

function st_og_title_attribute() {
	if ( is_single() || is_page() ) {
		the_title_attribute();
	} else {
		bloginfo( 'name' );
	}
}

function st_og_url_attribute() {
	if ( is_single() || is_page() ) {
		the_permalink();
	} else {
		echo esc_url( home_url() );
	}
}

function st_og_get_the_content() {
	if ( ! is_single() && ! is_page() ) {
		return '';
	}

	$post = get_queried_object();

	if ( post_password_required( $post ) ) {
		$content = __( 'There is no excerpt because this is a protected post.' );
	} else {
		$content = $post->post_content;
	}

	$content = force_balance_tags( $content );
	$content = _st_strip_shortcodes( $content, [ 'st-catgroup', 'st-postgroup', 'st-card', 'st_af', 'wpdm_package' ] );
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );

	return $content;
}

function st_og_description_attribute() {
	if ( ! is_single() && ! is_page() ) {

		bloginfo( 'description' );

		return;
	}

	$queried_object_id = get_queried_object_id();
	$excerpt           = trim( apply_filters( 'the_excerpt', get_the_excerpt( $queried_object_id ) ) );

	if ( $excerpt === '' ) {
		$excerpt = st_og_get_the_content();
	}

	$excerpt     = strip_tags( $excerpt );
	$excerpt     = str_replace( array( "\r", "\n" ), '', $excerpt );
	$whitespaces = '[\0\s\p{Zs}\p{Zl}\p{Zp}]';
	$excerpt     = (string) preg_replace( sprintf( '/\A%s++|%s++\z/u', $whitespaces, $whitespaces ), '', $excerpt );
	$excerpt     = esc_attr( $excerpt );

	echo mb_substr( $excerpt, 0, 100 );
}

function st_og_get_the_post_thumbnail_src() {
	$no_img = get_template_directory_uri() . '/images/no-img.png';

	if ( ! is_single() && ! is_page() ) {
		return $no_img;
	}

	$post = get_queried_object();

	if ( has_post_thumbnail( $post ) ) {
		$image_id = get_post_thumbnail_id( $post );
		$image    = wp_get_attachment_image_src( $image_id, 'full' );

		return $image[0];
	}

	if ( preg_match_all(
		     '!<img\s+[^>]*?src\s*=\s*(?:"([^"]+)"|\'([^\']+)\')[^>]*>!i',
		     st_og_get_the_content(),
		     $matches, PREG_SET_ORDER
	     ) !== false
	) {
		foreach ( $matches as $match ) {
			$tag = $match[0];
			$src = isset( $match[1] ) ? $match[1] : $match[2];

			if ( preg_match( '!\sdata-ogp-ignore(\s|/>|/|>)!', $tag ) ) {
				continue;
			}

			if ( preg_match( '!\swidth\s*=\s*("[0|1]"|\'[0|1]\')[^>]*height\s*=\s*("[0|1]"|\'[0|1]\')!i', $tag ) ) {
				continue;
			}

			if ( preg_match( '!\height\s*=\s*("[0|1]"|\'[0|1]\')[^>]*width\s*=\s*("[0|1]"|\'[0|1]\')!i', $tag ) ) {
				continue;
			}

			if ( preg_match( '!^(?:https?:)?\/\/!i', $src ) ) {
				$host         = parse_url( home_url(), PHP_URL_HOST );
				$host_pattern = preg_quote( $host, '!' );

				if ( ! preg_match( '!^(?:https?:)?\/\/' . $host_pattern . '[:/]!i', $src ) ) {
					continue;
				}
			}

			return $src;
		}
	}

	return $no_img;
}

function st_og_image_attribute() {
	$st_ogp_url = trim( get_option( 'st-data264', '' ) );
    if ( trim( $st_ogp_url ) !== '' ){
        $st_ogp_url = $st_ogp_url;
    } else {
        $st_ogp_url = get_template_directory_uri() . '/images/no-img.png';
    }
	if ( is_single() || is_page() ) { // 投稿記事か固定ページ
		echo esc_url( st_og_get_the_post_thumbnail_src() );
	} else { // ホーム・カテゴリーページなど
		echo $st_ogp_url;
	}
}

function st_og_get_fb_admin() {
	$admins = trim( get_option( 'st-data50', '' ) );
	$app_id = trim( get_option( 'st-data123', '' ) );

	return ( $app_id !== '' ) ? $app_id : $admins;
}

function st_og_fb_admin_meta() {
	$admins = trim( get_option( 'st-data50', '' ) );
	$app_id = trim( get_option( 'st-data123', '' ) );

	if ( $app_id !== '' ) {
		echo '<meta property="fb:app_id" content="' . esc_attr( $app_id ) . '">';
	} elseif ( $admins !== '' ) {
		echo '<meta property="fb:admins" content="' . esc_attr( $admins ) . '">';
	}
}

$has_fb_admin = (st_og_get_fb_admin() !== '');
?>
<?php if ( $has_fb_admin || trim( $GLOBALS["stdata25"] ) !== '' ) : ?>
	<!-- OGP -->
	<?php if ( $has_fb_admin ) : // fb:admins, fb:app_id ?>
		<meta property="og:locale" content="ja_JP">
		<?php st_og_fb_admin_meta(); ?>

		<?php if ( trim( $GLOBALS["stdata51"] ) !== '' ) : $facebook_page = $GLOBALS["stdata51"]; ?>
			<meta property="article:publisher" content="<?php echo esc_url( $facebook_page ); ?>">
		<?php endif; ?>

		<meta property="og:type" content="<?php st_og_type_attribute(); ?>">
		<meta property="og:title" content="<?php st_og_title_attribute(); ?>">
		<meta property="og:url" content="<?php st_og_url_attribute(); ?>">
		<meta property="og:description" content="<?php st_og_description_attribute(); ?>">
		<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
		<meta property="og:image" content="<?php st_og_image_attribute(); ?>">
	<?php endif; ?>

	<?php if ( trim( $GLOBALS["stdata25"] ) !== '' ) : $twitter_name = $GLOBALS["stdata25"]; // Twitter Cards ?>
		<?php if ( isset($GLOBALS['stdata333']) && $GLOBALS['stdata333'] === 'small' ) : ?>
			<meta name="twitter:card" content="summary">
		<?php else: ?>
			<meta name="twitter:card" content="summary_large_image">
		<?php endif; ?>
		<meta name="twitter:site" content="@<?php echo esc_attr( $twitter_name ); ?>">
		<meta name="twitter:title" content="<?php st_og_title_attribute(); ?>">
		<meta name="twitter:description" content="<?php st_og_description_attribute(); ?>">
		<meta name="twitter:image" content="<?php st_og_image_attribute(); ?>">
	<?php endif; ?>
	<!-- /OGP -->
<?php endif; ?>
