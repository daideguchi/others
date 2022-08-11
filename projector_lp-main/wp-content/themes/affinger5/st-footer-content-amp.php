<!-- フッターのメインコンテンツ -->
<h3 class="footerlogo">
	<!-- ロゴ又はブログ名 -->
	<?php if ( ! is_home() || ! is_front_page() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php endif; ?>

		<?php if ( get_option( 'st_footer_logo' ) ) : //フッター用ロゴ画像がある時 ?>
			<amp-img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_footer_logo' ) ); ?>"
				<?php amp_image_size( get_option( 'st_footer_logo' ), array(PHP_INT_MAX, 80) ); ?> layout="fixed"></amp-img>
		<?php else: //フッター用ロゴ画像が無い時 ?>

			<?php if ( get_option( 'st_logo_image' ) && ( st_headerfooter_logo() ) ) : //ヘッダーロゴ画像があり併用する時 ?>
				<amp-img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>"
					<?php amp_image_size( get_option( 'st_logo_image' ), array(PHP_INT_MAX, 80) ); ?> layout="fixed"></amp-img>
			<?php else : //ロゴ画像が無い時 ?>
				<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! is_home() || ! is_front_page() ) : ?>
	</a>
<?php endif; ?>
</h3>

<p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'description' ); ?></a>
</p>
<?php if ( false ): // [未対応] 通常ページ用 ?>
<?php get_template_part( 'st-header-widget', 'amp' ); //電話番号とヘッダー用ウィジェット ?>
<?php endif; ?>
