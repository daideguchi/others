<div class="kanren pop-box <?php st_marugazou_class(); //サムネイルを丸くする ?>">
<?php
    if ( trim( stripslashes( $GLOBALS["stdata38"] ) ) !== '' ) {
        $popname = st_esc_html_i( stripslashes( $GLOBALS["stdata38"] ) );
    ?>
<p class="p-entry-t"><span class="p-entry"><?php echo "$popname"; ?></span></p>
    <?php } ?>
<?php
    if ( trim( $GLOBALS["stdata37"] ) !== '' ) {
        $popid = $GLOBALS["stdata37"];
        $popids =explode(',',$popid);
    }else{
    $popids = '';
    }
    $poprank_no = '1';
    if (is_array($popids)) {
        foreach ($popids as $popid_no) {
            $posts_query = new WP_Query(array(
            'post_type' => array('post','page','template'),
            'post__in' => array_map('intval', explode(',', $popid_no)), //指定IDを含む投稿のみ
			'post__not_in' => get_option('sticky_posts'),
        ));
        while ($posts_query->have_posts()) : $posts_query->the_post();
    ?>

            <dl class="clearfix">
                <dt class="poprank"><a href="<?php the_permalink() ?>">
                        <?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
                           <?php get_template_part( 'st-thumbnail' ); //アイキャッチ画像 ?>
                        <?php else: // サムネイルを持っていないときの処理 ?>
				<?php if( trim($GLOBALS['stdata97']) !== '' ){ ?>
					<img src="<?php echo esc_url( ($GLOBALS['stdata97']) ); ?>" alt="no image" title="no image" width="100" height="100" />
				<?php }else{ ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
				<?php } ?>
                        <?php endif; ?>
                    </a><span class="poprank-no"><?php echo "$poprank_no";?></span></dt>
                <dd>
                    <h5><a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a></h5>

			<?php get_template_part( 'st-excerpt-popular' ); //おすすめ記事抜粋 ?>

                </dd>
            </dl>

    <?php $poprank_no++;
        endwhile; ?>
		<?php wp_reset_postdata(); ?>
<?php }
}?>
</div>
