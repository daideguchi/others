<?php if ( trim( $GLOBALS['stdata102'] ) !== '' ) : //ディスクリプションが無ければ ?>
	<!-- ロゴ又はブログ名 -->
	<?php if ( trim( $GLOBALS['stdata101'] ) === '' ) : //サイト名非表示でなければ ?>
		<?php if ( is_front_page() ) : ?>
			<h1 id="minih" class="sitename"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
						<amp-img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>"
							<?php amp_image_size( get_option( 'st_logo_image' ), array(PHP_INT_MAX, 80) ); ?> layout="fixed"></amp-img>
					<?php else: //ロゴ画像が無い時 ?>
						<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
					<?php endif; ?>
				</a></h1>
		<?php else : ?>
			<p id="minih" class="sitename"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
						<amp-img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>"
							<?php amp_image_size( get_option( 'st_logo_image' ), array(PHP_INT_MAX, 80) ); ?> layout="fixed"></amp-img>
					<?php else: //ロゴ画像が無い時 ?>
						<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
					<?php endif; ?>
				</a></p>
		<?php endif; ?>
	<?php endif; ?>

<?php else: ?>
	<!-- キャプション -->
	<?php if ( is_front_page() ) : ?>
		<h1 class="descr">
			<?php bloginfo( 'description' ); ?>
		</h1>
	<?php else : ?>
		<p class="descr">
			<?php bloginfo( 'description' ); ?>
		</p>
	<?php endif; ?>

	<!-- ロゴ又はブログ名 -->
	<?php if ( trim( $GLOBALS['stdata101'] ) === '' ) : //サイト名非表示でなければ ?>
		<p class="sitename"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
					<amp-img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>"
						<?php amp_image_size( get_option( 'st_logo_image' ), array(PHP_INT_MAX, 80) ); ?> layout="fixed"></amp-img>
				<?php else: //ロゴ画像が無い時 ?>
					<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
				<?php endif; ?>
			</a></p>
	<?php endif; ?>
	<!-- ロゴ又はブログ名ここまで -->
<?php endif; ?>
