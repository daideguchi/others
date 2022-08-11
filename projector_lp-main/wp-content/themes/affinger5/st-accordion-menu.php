<?php
if( wp_is_mobile() || trim($GLOBALS['stdata16']) === ''){ //PCで切り替え表示にチェックがある場合は表示しない
	if ( trim( $GLOBALS["stdata80"] ) === '' ) { //スライドメニューを非表示
		//追加メニューテキスト 
		if ( trim( $GLOBALS["stdata82"] ) !== '' ) {
			$menutext = '<span class="op-text">' . esc_html( $GLOBALS["stdata82"] ) . '</span>';
		} else {
			$menutext = '';
		}
		if ( trim( $GLOBALS["stdata84"] ) !== '' ) {
			$menutext2 = '<span class="op-text">' . esc_html( $GLOBALS["stdata84"] ) . '</span>';
		} else {
			$menutext2 = '';
		}
		//リンク先
		if ( trim( $GLOBALS["stdata85"] ) !== '' ) {
			$menuurl = esc_url( $GLOBALS["stdata85"] );
		} else {
			$menuurl = '#';
		}
		if ( trim( $GLOBALS["stdata86"] ) !== '' ) {
			$menuurl2 = esc_url( $GLOBALS["stdata86"] );
		} else {
			$menuurl2 = '#';
		}
		//Webフォント
		if ( trim( $GLOBALS["stdata81"] ) !== '' ) {
			$web_icon = esc_attr( $GLOBALS["stdata81"] );
			$menuicon = '<i class="fa ' . $web_icon . '" aria-hidden="true"></i>';
		} else {
			$menuicon = '';
		}
		if ( trim( $GLOBALS["stdata83"] ) !== '' ) {
			$web_icon2 = esc_attr( $GLOBALS["stdata83"] );
			$menuicon2 = '<i class="fa ' . $web_icon2 . '" aria-hidden="true"></i>';
		} else {
			$menuicon2 = '';
		}

		$has_text = ( isset( $GLOBALS['stdata374'] ) && $GLOBALS['stdata374'] === 'yes' ) // スライドメニューに文字追加
	?>
		<nav id="s-navi" class="pcnone">
			<dl class="acordion">
				<dt class="trigger">
					<p class="acordion_button"><span class="op<?php if ( $has_text ): ?> has-text<?php endif; ?>"><i class="fa <?php st_svg_close_class(); ?>"></i></span></p>
					<?php if ( st_is_mobile() && st_mobilelogo_on() ): //スマホ・タブレット表示時にモバイル用ロゴ及びタイトルの使用 ?>	

						<?php if ( is_front_page() && trim( $GLOBALS['stdata429'] ) !== '' ) : //トップページのみサイト名（ロゴ）及びキャッチフレーズを非表示 ?>
						<?php elseif ( is_front_page() ) : ?>
							<h1 id="st-mobile-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'description' ); ?>"><?php if ( get_option( 'st_mobile_logo' ) ): //ロゴ画像がある時 ?><img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_mobile_logo' ) ); ?>" ><?php else: //ロゴ画像が無い時 ?><?php echo esc_attr( wp_trim_words( get_bloginfo( 'name' ), 120, '...' ) ); ?><?php endif; ?></a></h1>
						<?php else: ?>
							<p id="st-mobile-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'description' ); ?>"><?php if ( get_option( 'st_mobile_logo' ) ): //ロゴ画像がある時 ?><img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_mobile_logo' ) ); ?>" ><?php else: //ロゴ画像が無い時 ?><?php echo esc_attr( wp_trim_words( get_bloginfo( 'name' ), 120, '...' ) ); ?><?php endif; ?></a></p>
						<?php endif; ?>

					<?php else: //モバイル用ロゴ画像が無い時 ?>

								<!-- 追加メニュー -->
								<?php if ( ( trim( $GLOBALS["stdata81"] ) !== '' ) || ( trim( $GLOBALS["stdata82"] ) !== '' ) ) { ?>
									<p class="acordion_extra_1"><a href="<?php echo $menuurl ?>"><span class="op-st"><?php echo $menuicon; ?><?php echo $menutext ?></span></a></p>
								<?php } else { } ?>

								<!-- 追加メニュー2 -->
								<?php if ( ( trim( $GLOBALS["stdata83"] ) !== '' ) || ( trim( $GLOBALS["stdata84"] ) !== '' )  ) { ?>
									<p class="acordion_extra_2"><a href="<?php echo $menuurl2 ?>"><span class="op-st2"><?php echo $menuicon2; ?><?php echo $menutext2 ?></span></a></p>
								<?php } else { } ?>

					<?php endif; ?>
				</dt>

				<dd class="acordion_tree">
					<div class="acordion_tree_content">

						<?php if ( is_active_sidebar( 25 ) ) { ?>
							<div class="st-ac-box">
								<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 25 ) ) : else : //サイドウイジェット読み込み ?>
								<?php endif; ?>
							</div>
						<?php } ?>


							<?php
							if ( has_nav_menu( 'smartphone-menu' ) ) :
								$defaults = array(
									'theme_location' => 'smartphone-menu',
									'link_before'    => '<span class="menu-item-label">',
									'link_after'     => '</span>',
								);
							else :
								$defaults = array(
									'theme_location' => 'primary-menu',
									'link_before'    => '<span class="menu-item-label">',
									'link_after'     => '</span>',
								);
							endif;?>
							<?php wp_nav_menu( $defaults ); ?>
							<div class="clear"></div>

						<?php if ( is_active_sidebar( 27 ) ) { ?>
							<div class="st-ac-box st-ac-box-bottom">
								<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 27 ) ) : else : //サイドウイジェット読み込み ?>
								<?php endif; ?>
							</div>
						<?php } ?>

					</div>
				</dd>
			</dl>
		</nav>
	<?php
	}
}
