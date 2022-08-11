<?php get_header(); ?>

<div id="content" class="clearfix">
	<div id="contentInner">
		<main <?php st_text_copyck(); ?>>
			<article>
				<div id="author-page-<?php echo $author; ?>" class="post">
					<!--ぱんくず -->
						<div id="breadcrumb">
						<ol>
							<li><a href="<?php echo home_url(); ?>"><span><?php echo esc_html( $GLOBALS["stdata141"] ); ?></span></a> >  </li>
							<li><?php the_author_meta('display_name', get_query_var('author')); ?></li>
						</ol>
						</div>
					<!--/ ぱんくず -->
					<!--ループ開始-->
					
					<?php 
					$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
					$author = $curauth->ID;
					?>

					<h1 class="entry-title"><?php echo esc_html( get_queried_object()->display_name ); ?></h1>

					<?php if (isset($GLOBALS['stdata407']) && $GLOBALS['stdata407'] === 'yes'): // 投稿・固定ページで記事（著者）情報を出力する が有効 ?>
						<div class="center" style="padding-bottom:20px;">
							<?php if ( $author === 1 && get_option( 'st_author_profile_avatar' ) ): ?>
								<img src="<?php echo esc_url( get_option( 'st_author_profile_avatar' ) ); ?>">
							<?php else: ?>
								<?php echo get_avatar( $author, 150 ); ?>
							<?php endif; ?>
						</div>

						<p class="st-author-description"><?php the_author_meta( 'description', $author ); ?></p>
						<div class="st-author-box">
							<div class="post st-author-profile">
								<div class="sns">
									<ul class="profile-sns clearfix">
										<?php if(get_the_author_meta('twitter',1)): // Twitter ?>
											<li class="twitter"><a rel="nofollow" href="<?php esc_url( the_author_meta('twitter',$author) ); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<?php endif; ?>

										<?php if(get_the_author_meta('facebook',$author)): // Facebook ?>
											<li class="facebook"><a rel="nofollow" href="<?php esc_url( the_author_meta('facebook',$author) ); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<?php endif; ?>

										<?php if(get_the_author_meta('instagram',$author)): // instagram ?>
											<li class="instagram"><a rel="nofollow" href="<?php esc_url( the_author_meta('instagram',$author) ); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
										<?php endif; ?>

										<?php if(get_the_author_meta('youtube',$author)): // YouTube ?>
											<li class="author-youtube"><a rel="nofollow" href="<?php esc_url( the_author_meta('youtube',$author) ); ?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
										<?php endif; ?>

										<?php if(get_the_author_meta('amazon',$author)): // amazon ?>
											<li class="author-amazon"><a rel="nofollow" href="<?php the_author_meta('amazon',$author); ?>" target="_blank"><i class="fa fa-amazon" aria-hidden="true"></i></a></li>
										<?php endif; ?>

										<?php if(get_the_author_meta('feed_url',$author)): // RSS ?>
											<li class="author-feed"><a rel="nofollow" href="<?php the_author_meta('feed_url',$author); ?>" target="_blank"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
										<?php endif; ?>

										<?php if(get_the_author_meta('form_url',$author)): // フォーム ?>
											<li class="author-form"><a rel="nofollow" href="<?php the_author_meta('form_url',$author); ?>" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
										<?php endif; ?>

										<?php if(get_the_author_meta('user_url',$author)): // HOME ?>
											<li class="author-homepage"><a rel="nofollow" href="<?php the_author_meta('user_url',$author); ?>" target="_blank"><i class="fa fa-home" aria-hidden="true"></i></a></li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<!--/post-->
				<?php get_template_part( 'itiran' ); //投稿一覧読み込み ?>
				<?php get_template_part( 'st-pagenavi' ); //ページナビ読み込み ?>
			</article>
		</main>
	</div>
	<!-- /#contentInner -->
	<?php get_sidebar(); ?>
</div>
<!--/#content -->
<?php get_footer(); ?>
