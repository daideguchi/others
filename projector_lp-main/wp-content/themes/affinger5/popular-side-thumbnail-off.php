<div class="kanren pop-box">
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

	<h5 class="poprank-noh5"><span class="poprank-no2"><?php echo "$poprank_no";?></span><a href="<?php the_permalink(); ?>"><?php the_title(); ?>
						</a></h5>

			<?php get_template_part( 'st-excerpt-popular' ); //おすすめ記事抜粋 ?>

	<?php $poprank_no++;
		endwhile; ?>
		<?php wp_reset_postdata(); ?>
<?php }
}?>
</div>
