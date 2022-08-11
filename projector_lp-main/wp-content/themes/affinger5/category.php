<?php get_header(); ?>

<?php
$the_cat_id        = get_queried_object_id();
$is_thumbnal_under = (bool) st_get_term_meta( $the_cat_id, 'thumbnail_under' );
$has_thumbnail     = st_has_term_thumbnail();
?>
<div id="content" class="clearfix">
    <div id="contentInner">
        <main>
            <article>
				<?php if ( ! $is_thumbnal_under && $has_thumbnail ): // サムネイル ?>
					<?php get_template_part( 'st-category-eyecatch' ); ?>
				<?php endif; ?>

					<!--ぱんくず -->
					<div id="breadcrumb">
					<ol itemscope itemtype="http://schema.org/BreadcrumbList">
						<li itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><a href="<?php echo home_url(); ?>" itemprop="item"><span itemprop="name"><?php echo esc_html( $GLOBALS["stdata141"] ); ?></span></a> > <meta itemprop="position" content="1" /></li>

					<?php
					$catid = $the_cat_id;
					if( !$catid ){
					$cat_now = get_the_category();
					$cat_now = $cat_now[0];
					$catid  = $cat_now->cat_ID;
					}
					?>
					<?php $allcats = array( $catid ); ?>
					<?php
					while ( !$catid == 0 ) {
						$mycat = get_category( $catid );
						$catid = $mycat->parent;
						array_push( $allcats, $catid );
					}
					array_pop( $allcats );
					$allcats = array_reverse( $allcats );
					?>

					<?php 
					$i = 2;
					foreach ( $allcats as $catid ): ?>
							<li itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><a href="<?php echo esc_url( get_category_link( $catid ) ); ?>" itemprop="item">
								<span itemprop="name"><?php echo esc_html( get_cat_name( $catid ) ); ?></span> </a> &gt; 
								<meta itemprop="position" content="<?php echo $i; ?>" />
							</li>
					<?php  $i++; ?>
					<?php endforeach; ?>
					</ol>
					</div>
					<!--/ ぱんくず -->
        <?php
		$now_category = get_query_var('cat');
		$args = array(
                'include' => array($now_category),
		);
		$tag_all = get_terms("category", $args);
		$cat_data = get_option('cat_'.$now_category);
   
		if(trim($cat_data['listdelete']) === ''){
                     //一覧を表示する場合　?>
                        <div class="post">
                        <?php if(trim($cat_data['st_cattitle']) !== ''){ ?>
                            <h1 class="entry-title"><?php echo esc_html($cat_data['st_cattitle']) ?></h1>
                        <?php }else{ ?>
                            <h1 class="entry-title"><?php single_cat_title(); ?></h1>
                        <?php } ?>

			<?php if ( is_active_sidebar( 21 ) ) { ?>
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 21 ) ) : else : //カテゴリページ上一括ウィジェット ?>
				<?php endif; ?>
			<?php } ?>

			<?php if(!is_paged()){ ?>
				<div id="nocopy" <?php st_text_copyck(); ?>>
					<?php if ( $is_thumbnal_under && $has_thumbnail ): // サムネイル ?>
						<?php get_template_part( 'st-category-eyecatch' ); ?>
					<?php endif; ?>

					<div class="entry-content">
						<?php echo apply_filters('the_content',category_description()); //コンテンツを表示 ?>
					</div>
				</div>
				<?php get_template_part( 'popular-thumbnail' ); //任意のエントリ ?>
			<?php } ?>

                        </div><!-- /post -->

			<?php if( category_description() && (!is_paged()) ){ //コンテンツがある場合 ?>
				<?php if ( isset($GLOBALS['stplus']) && $GLOBALS['stplus'] === 'yes' ) {
					get_template_part( 'st-rank' ); //ランキング 
				} ?>
				<?php if( trim($cat_data['snscat'] ) !== '' ):
					get_template_part( 'sns-cat' ); //ソーシャルボタン読み込み
				endif; ?>
				<div class="cat-itiran" style="padding-top:20px;">
			<?php } ?>

                        		<?php get_template_part( 'itiran' ); //投稿一覧読み込み ?>
                       			<?php get_template_part( 'st-pagenavi' ); //ページナビ読み込み ?>

			<?php if( category_description() && (!is_paged()) ){ //コンテンツがある場合 ?>
				</div>
			<?php }else{
				get_template_part( 'st-rank' ); //ランキング 
			} ?>

		<?php }else{ //一覧を表示しない ?>

                        <div class="post">
                        <?php if(trim($cat_data['st_cattitle']) !== ''){ ?>
                            <h1 class="entry-title"><?php echo esc_html($cat_data['st_cattitle']) ?></h1>
                        <?php }else{ ?>
                            <h1 class="entry-title">「<?php single_cat_title(); ?>」 一覧</h1>
                        <?php } ?>

			<?php if ( is_active_sidebar( 21 ) ) { ?>
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 21 ) ) : else : //カテゴリページ上一括ウィジェット ?>
				<?php endif; ?>
			<?php } ?>
                      
			<div id="nocopy" <?php st_text_copyck(); ?>>
				<?php if ( $is_thumbnal_under && $has_thumbnail ): // サムネイル ?>
					<?php get_template_part( 'st-category-eyecatch' ); ?>
				<?php endif; ?>

				<div class="entry-content">
					<?php echo apply_filters('the_content',category_description()); //コンテンツを表示 ?>
				</div>
			</div>
			<?php get_template_part( 'popular-thumbnail' ); //任意のエントリ ?>

			<?php if(trim($cat_data['snscat']) !== '' && (category_description())){ //コンテンツがある場合 ?>
				<?php if ( isset($GLOBALS['stplus']) && $GLOBALS['stplus'] === 'yes' ) {
					get_template_part( 'st-rank' ); //ランキング 
				} ?>
				<?php get_template_part( 'sns-cat' ); //ソーシャルボタン読み込み ?>
			<?php } ?>

                        </div><!-- /post -->
		<?php } ?>

		<?php if((trim($cat_data['snscat']) !== '') && (!category_description())){ //コンテンツがない場合 ?>
			<?php if ( isset($GLOBALS['stplus']) && $GLOBALS['stplus'] === 'yes' ) {
				get_template_part( 'st-rank' ); //ランキング 
			} ?>
			<?php get_template_part( 'sns-cat' ); //ソーシャルボタン読み込み ?>
		<?php } ?>


			<?php if ( is_active_sidebar( 22 ) ) { ?>
				<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 22 ) ) : else : //カテゴリページ下一括ウィジェット ?>
				<?php endif; ?>
			<?php } ?>

            </article>
        </main>
    </div>
    <!-- /#contentInner -->
    <?php get_sidebar(); ?>
</div>
<!--/#content -->
<?php get_footer(); ?>
