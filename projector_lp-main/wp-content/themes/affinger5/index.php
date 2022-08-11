<?php get_header(); ?>

<div id="content" class="clearfix">
	<div id="contentInner">

		<main>
			<article>
				<div id="post-<?php the_ID(); ?>" <?php post_class('st-post'); ?>>

			<?php get_template_part( 'st-eyecatch' ); //アイキャッチ画像を挿入 ?>

					<?php if ( is_active_sidebar( 16 ) ) { ?>
						<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 16 ) ) : else : //投稿ページ上一括ウィジェット ?>
						<?php endif; ?>
					<?php } ?>	

					<!--ぱんくず -->
					<div id="breadcrumb">
					<ol itemscope itemtype="http://schema.org/BreadcrumbList">
							 <li itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><a href="<?php echo home_url(); ?>" itemprop="item"><span itemprop="name"><?php echo esc_html( $GLOBALS["stdata141"] ); ?></span></a> > <meta itemprop="position" content="1" /></li>
						<?php 
							$postcat = get_the_category();
							$catid = $postcat[0]->cat_ID;
							$allcats = array( $catid );
						
						while ( !$catid == 0 ) {
							$mycat = get_category( $catid );
							$catid = $mycat->parent;
							array_push( $allcats, $catid );
						}
						array_pop( $allcats );
						$allcats = array_reverse( $allcats );
						$i = 2;
						foreach ( $allcats as $catid ): ?>
							<li itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><a href="<?php echo get_category_link( $catid ); ?>" itemprop="item">
							<span itemprop="name"><?php echo esc_html( get_cat_name( $catid ) ); ?></span> </a> &gt;<meta itemprop="position" content="<?php echo $i; ?>" /></li> 
						<?php  
						$i++; 
						endforeach; ?>
					</ol>
					</div>
					<!--/ ぱんくず -->

					<!--ループ開始 -->
					<?php if (have_posts()) : while (have_posts()) :
					the_post(); ?>
					
					<?php //カテゴリ表示
					if ( isset($GLOBALS['stdata60']) && $GLOBALS['stdata60'] === 'yes' ) {

					} else {

						$categories = get_the_category();
						$separator = ' ';
						$output = ''; ?>
					<p class="st-catgroup">
					<?php
							if ( $categories ) {
								foreach( $categories as $category ) {
									$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' 
									. esc_attr( sprintf( "View all posts in %s", $category->name ) ) 
									. '" rel="category tag"><span class="catname st-catid' . $category->cat_ID . '">' . $category->cat_name . '</span></a>' . $separator;
									}
								echo trim( $output, $separator );
							} ?>
					</p>
					<?php
					} //カテゴリ表示ここまで
					?>				

					<h1 class="entry-title"><?php the_title(); //タイトル ?></h1>

					<div class="blogbox <?php st_hidden_class(); ?>">
						<p><span class="kdate">
							<?php if ( get_the_date() != get_the_modified_date() ) : //更新がある場合 ?>
								投稿日：<?php echo esc_html( get_the_date() ); ?>
								更新日：<time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( DATE_ISO8601 ) ); ?>"><?php echo esc_html( get_the_modified_date() ); ?></time>
							<?php else: //更新がない場合 ?>
								投稿日：<time class="updated" datetime="<?php echo esc_attr( get_the_date( DATE_ISO8601 ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<?php endif; ?>
						</span></p>
					</div>

					<div class="mainbox">
						<div id="nocopy" <?php st_text_copyck(); ?>><!-- コピー禁止エリアここから -->
							<div class="entry-content">
								<?php the_content(); //本文 ?>
							</div>
						</div><!-- コピー禁止エリアここまで -->
						<?php get_template_part( 'st-ad-on' ); //広告 ?>
						<?php get_template_part( 'st-kai-page' ); //改ページ ?>

						<?php if ( is_active_sidebar( 5 ) ) { ?>
							<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 5 ) ) : else : //投稿ページ下一括ウィジェット ?>
							<?php endif; ?>
						<?php } ?>

					</div><!-- .mainboxここまで -->

						<?php if ( isset($GLOBALS['stplus']) && $GLOBALS['stplus'] === 'yes' ) {
							get_template_part( 'st-rank' ); //ランキング 
						} ?>
	
						<?php get_template_part( 'sns' ); //ソーシャルボタン読み込み ?>
						<?php get_template_part( 'popular-thumbnail' ); //任意のエントリ ?>

						<p class="tagst">
							<i class="fa fa-folder-open-o" aria-hidden="true"></i>-<?php the_category( ', ' ) ?><br/>
							<?php the_tags( '<i class="fa fa-tags"></i>-', ', ' ); ?>
						</p>

					<aside>

						<?php st_author(); //著者リンク ?>

						<?php endwhile; else: ?>
							<p>記事がありません</p>
						<?php endif; ?>
						<!--ループ終了-->
						<?php
						//コメント
						if ( ( $GLOBALS["stdata6"] ) === '' ) { ?>
							<?php if ( comments_open() || get_comments_number() ) {
								comments_template();
							} ?>
						<?php } ?>
						<!--関連記事-->
						<?php get_template_part( 'kanren' ); ?>

						<!--ページナビ-->
						<div class="p-navi clearfix">
							<dl>
								<?php
								$prev_post = get_previous_post();
								if ( !empty( $prev_post ) ): ?>
									<dt>PREV</dt>
									<dd>
										<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo $prev_post->post_title; ?></a>
									</dd>
								<?php endif; ?>
								<?php
								$next_post = get_next_post();
								if ( !empty( $next_post ) ): ?>
									<dt>NEXT</dt>
									<dd>
										<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo $next_post->post_title; ?></a>
									</dd>
								<?php endif; ?>
							</dl>
						</div>
					</aside>

				</div>
				<!--/post-->
			</article>
		</main>
	</div>
	<!-- /#contentInner -->
	<?php get_sidebar(); ?>
</div>
<!--/#content -->
<?php get_footer(); ?>
