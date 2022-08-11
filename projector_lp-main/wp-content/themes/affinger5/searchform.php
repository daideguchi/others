<div id="search">
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="hidden" for="s">
			<?php __( '', 'default' ); ?>
		</label>
		<input type="text" placeholder="検索するテキストを入力" value="<?php the_search_query(); ?>" name="s" id="s" />
		<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/search.png" alt="検索" id="searchsubmit" />
	</form>
</div>
<!-- /stinger --> 