<?php // 記事一覧の投稿日
$st_is_ex    = st_is_ver_ex();
$show_published_date = ( get_option( 'st-data140', '' ) === 'yes' ); // 更新日がある場合も投稿日を表示する
if ( trim ( $GLOBALS['stdata324'] ) === '' ): // 日付表示 ?>
	<div class="blog_info">
		<p>
			<?php if( $st_is_ex ): //更新日の表示確認
				$postID = get_the_ID();
				$updatewidgetset = get_post_meta( $postID, 'updatewidget_set', true );
			else:
				$updatewidgetset = '';
			endif;

			if ( trim ( $updatewidgetset ) === '' && ( get_the_date() != get_the_modified_date() ) ) : //更新がある場合 ?>
				<i class="fa fa-refresh"></i><?php the_modified_date( 'Y/n/j' ); ?>
			<?php else: ?>
				<i class="fa fa-clock-o"></i><?php the_time( 'Y/n/j' ); ?>
			<?php endif; ?>
			<?php if ( trim( $GLOBALS['stdata466']) === '' ) : // タグを表示しない ?>
				&nbsp;<span class="pcone">
						<?php the_tags( '<i class="fa fa-tags"></i>&nbsp;', ', ' ); ?>
				</span></p>
			<?php endif; ?>
	</div>
<?php endif;
