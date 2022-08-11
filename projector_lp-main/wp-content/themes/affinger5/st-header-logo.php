<?php
if  ( st_is_mobile() && st_mobilelogo_on() ): //スマホ・タブレット表示時にモバイル用ロゴ及びタイトルの使用
elseif ( is_front_page() && trim( $GLOBALS['stdata429'] ) !== '' ): //トップページのみサイト名（ロゴ）及びキャッチフレーズを非表示
else:

	if(trim($GLOBALS['stdata102']) !== '' ): //キャッチフレーズが非表示の場合 ?>
		<!-- ロゴ又はブログ名 -->
        <?php if(trim($GLOBALS['stdata101']) === ''): //サイト名非表示でなければ ?>
			<?php if ( is_front_page() ) { ?>
 				<h1 class="sitename sitename-only"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
                        <img class="sitename-only-img" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
                    <?php else: //ロゴ画像が無い時 ?>
                        <?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
                    <?php endif; ?>
                </a></h1>
			<?php } else { //下層ページ ?>
				<p class="sitename sitename-only"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
                        <img class="sitename-only-img" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
                    <?php else: //ロゴ画像が無い時 ?>
                        <?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
                    <?php endif; ?>
                </a></p>
            <?php } ?>
        <?php endif; ?>
    
    <?php else: //キャッチフレーズあり ?>

        <?php if(trim($GLOBALS['stdata127']) !== ''): //サイト名とキャッチフレーズを反対に ?>
    
			<?php if(trim($GLOBALS['stdata209']) === ''): //h1タグをキャッチフレーズに（デフォルト） ?>

				<!-- ロゴ又はブログ名 -->
				<?php if(trim($GLOBALS['stdata101']) === ''): //サイト名非表示でなければ ?>
                
					<p class="sitename sitenametop"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
  						<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
							<img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
   						<?php else: //ロゴ画像が無い時 ?>
                      		  <?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
                   		<?php endif; ?>
               		 </a></p>
                     
   				<?php endif; ?>
          		<!-- ロゴ又はブログ名ここまで -->
                
           		<!-- キャプション -->
           		<?php if ( is_front_page() ) { ?>
					<h1 class="descr">
						<?php bloginfo( 'description' ); ?>
					</h1>
           		 <?php } else { ?>
					<p class="descr">
						<?php bloginfo( 'description' ); ?>
					</p>
				<?php } ?>

			<?php else: //h1タグをキャッチフレーズに ?>

				<!-- ロゴ又はブログ名 -->
				<?php if(trim($GLOBALS['stdata101']) === ''): //サイト名非表示でなければ ?>

					<?php if ( is_front_page() ) { ?>
						<h1 class="sitename sitenametop"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
 								<img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
							<?php else: //ロゴ画像が無い時 ?>
								<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
  							<?php endif; ?>
               			 </a></h1>
           			<?php } else { ?>
						<p class="sitename sitenametop"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
								<img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
                   			<?php else: //ロゴ画像が無い時 ?>
                    			<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
                   			<?php endif; ?>
						</a></p>
					<?php } ?>

				<?php endif; ?>
           		<!-- ロゴ又はブログ名ここまで -->
            
           		<!-- キャプション -->
				<p class="descr">
					<?php bloginfo( 'description' ); ?>
				</p>
			<?php endif; //h1タグをキャッチフレーズに ?>

		<?php else: //サイト名とキャッチフレーズを反対に ?>
    
			<?php if(trim($GLOBALS['stdata209']) === ''): //h1タグをキャッチフレーズに ?>

				<!-- キャプション -->
				<?php if(trim($GLOBALS['stdata101']) === ''): //サイト名非表示でなければ ?>
                
					<?php if ( is_front_page() ) { ?>
						<h1 class="descr sitenametop">
             		       	<?php bloginfo( 'description' ); ?>
             		   	</h1>
					<?php } else { ?>
              		 	 <p class="descr sitenametop">
               		     	<?php bloginfo( 'description' ); ?>
               			 </p>
					<?php } ?>
                    
				<?php else: ?>
                
          			<?php if ( is_front_page() ) { ?>
              		 	 <h1 class="descr">
             		       	<?php bloginfo( 'description' ); ?>
             		   	</h1>
         		  	 <?php } else { ?>
              		 	 <p class="descr">
               		     	<?php bloginfo( 'description' ); ?>
               			 </p>
           			 <?php } ?>
                     
            	<?php endif; ?>
                
				<!-- ロゴ又はブログ名 -->
				<?php if(trim($GLOBALS['stdata101']) === ''): //サイト名非表示でなければ ?>
              		  <p class="sitename"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                  		  <?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
                      		  <img class="sitename-bottom" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
                   		 <?php else: //ロゴ画像が無い時 ?>
                    		    <?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
                   		 <?php endif; ?>
              		  </a></p>
            	<?php endif; ?>
				<!-- ロゴ又はブログ名ここまで -->

			<?php else: //h1タグをサイト名に ?>

 				<!-- キャプション -->
             	<p class="descr sitenametop">
					<?php bloginfo( 'description' ); ?>
  				</p>

 				<!-- ロゴ又はブログ名 -->
				<?php if(trim($GLOBALS['stdata101']) === ''): //サイト名非表示でなければ ?>

           		 	<?php if ( is_front_page() ) { ?>
						<h1 class="sitename"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
								<img class="sitename-bottom" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
							<?php else: //ロゴ画像が無い時 ?>
								<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
							<?php endif; ?>
						</a></h1>
           			<?php } else { ?>
						<p class="sitename"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if ( get_option( 'st_logo_image' ) ): //ロゴ画像がある時 ?>
								<img class="sitename-bottom" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_option( 'st_logo_image' ) ); ?>" >
							<?php else: //ロゴ画像が無い時 ?>
								<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
							<?php endif; ?>
						</a></p>
           			<?php } ?>

				<?php endif; //サイト名非表示でなければ ?>
				<!-- ロゴ又はブログ名ここまで -->

			<?php endif; //h1タグをサイト名に ?>
    
		<?php endif; //サイト名とキャッチフレーズを反対に ?>

    <?php endif; //キャッチフレーズあり

endif;