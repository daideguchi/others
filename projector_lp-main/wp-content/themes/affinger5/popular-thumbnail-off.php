<?php
$heading        = get_option( 'st-data38', '' );
$post_id_string = trim( get_option( 'st-data37', '' ) );
?>

<div class="kanren pop-box">
	<?php if ( trim( stripslashes( $heading ) ) !== '' ): ?>
		<?php $popname = st_esc_html_i( stripslashes( $heading ) ); ?>
		<p class="p-entry-t"><span class="p-entry"><?php echo $popname; ?></span></p>
	<?php endif; ?>

	<?php
	if ( $post_id_string !== '' ) {
		$popid  = $post_id_string;
		$popids = explode( ',', $popid );
	} else {
		$popids = '';
	}

	$poprank_no = '1';
	?>

	<?php if ( is_array( $popids ) ): ?>
		<?php foreach ( $popids as $popid_no ): ?>
			<?php
			$posts_query = new WP_Query( array(
				'post_type'    => array( 'post', 'page', 'template' ),
				'post__in'     => array_map( 'intval', explode( ',', $popid_no ) ), //指定IDを含む投稿のみ
				'post__not_in' => get_option( 'sticky_posts' ),
			) );
			?>

			<?php while ( $posts_query->have_posts() ): $posts_query->the_post(); ?>

				<h5 class="popular-t"><span class="poprank-no2"><?php echo $poprank_no; ?></span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

				<?php get_template_part( 'st-excerpt-popular' ); //おすすめ記事抜粋 ?>

				<?php $poprank_no ++; ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php endforeach; ?>
	<?php endif; ?>

</div>
