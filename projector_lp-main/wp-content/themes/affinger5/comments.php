<hr class="hrcss" />

<div id="comments">
     <?php if ( have_comments() ): ?>

          <ol class="commets-list">
               <?php wp_list_comments( 'avatar_size=55' ); ?>
          </ol>
     <?php endif;

	if( trim( $GLOBALS['stdata381'] ) !== '' ):
		$comment_text = esc_html( $GLOBALS['stdata381'] );
	else:
		$comment_text = "comment";	
	endif;

	$args = array(
          'title_reply' => $comment_text,
          'label_submit' => __( '送信' , 'default' )
	);
	comment_form( $args );
	?>
</div>

<?php if( $wp_query -> max_num_comment_pages > 1 ): ?>
	<div class="st-pagelink">
	<?php
	$args = array(
		'prev_text' => '&laquo; Prev',
		'next_text' => 'Next &raquo;',
	);

	paginate_comments_links($args);
	?>
	</div>
<?php endif; ?>

<!-- END singer -->
