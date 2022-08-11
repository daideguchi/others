<?php

if ( !( function_exists( 'current_user_can' ) && current_user_can( MP_AdminPage::capability ) ) ) die( 'Access denied' );

$id		= absint( MP_AdminPage::$get_['id'] );
$mail 	= MP_Mail::get( $id );

//
// MANAGING H1
//

$edit_url		= esc_url( add_query_arg( 'id', $id, MailPress_edit ) );
$mail_title	= '<a href="' . $edit_url . '">' . $mail->subject . '</a>';
$return_to_edit	= '<a href="' . $edit_url . '">' . __( '&larr; Return to editor' ) . '</a>';

$h1 = sprintf( __( 'Compare Revisions of &#8220;%1$s&#8221;' ), $mail_title );

?>
<div class="wrap">
	<h1 class="long-header">
		<?php echo $h1; ?>
	</h1>
	<?php echo $return_to_edit; ?>
</div>
<script id="tmpl-revisions-frame" type="text/html">
	<div class="revisions-control-frame"></div>
	<div class="revisions-diff-frame"></div>
</script>

<script id="tmpl-revisions-buttons" type="text/html">
	<div class="revisions-previous">
		<input type="button" class="button" value="<?php echo esc_attr( _x( 'Previous', 'Button label for a previous revision' ) ); ?>" />
	</div>

	<div class="revisions-next">
		<input type="button" class="button" value="<?php echo esc_attr( _x( 'Next', 'Button label for a next revision' ) ); ?>" />
	</div>
</script>

<script id="tmpl-revisions-checkbox" type="text/html">
	<div class="revision-toggle-compare-mode">
		<label>
			<input type="checkbox" class="compare-two-revisions"
			<#
			if ( 'undefined' !== typeof data && data.model.attributes.compareTwoMode ) {
				#> checked="checked"<#
			}
			#>
			/>
			<?php esc_html( _e( 'Compare any two revisions' ) ); ?>
		</label>
	</div>
</script>

<script id="tmpl-revisions-meta" type="text/html">
	<# if ( ! _.isUndefined( data.attributes ) ) { #>
		<div class="diff-title">
		<# if ( 'from' === data.type ) { #>
			<strong><?php _ex( 'From:', 'Followed by post revision info' ); ?></strong>
		<# } else if ( 'to' === data.type ) { #>
			<strong><?php _ex( 'To:', 'Followed by post revision info' ); ?></strong>
		<# } #>
		<div class="author-card<# if ( data.attributes.autosave ) { #> autosave<# } #>">
			{{{ data.attributes.author.avatar }}}
			<div class="author-info">
			<# if ( data.attributes.autosave ) { #>
				<span class="byline"><?php printf( __( 'Autosave by %s' ),
					'<span class="author-name">{{ data.attributes.author.name }}</span>' ); ?></span>
			<# } else if ( data.attributes.current ) { #>
				<span class="byline"><?php printf( __( 'Current Revision by %s' ),
					'<span class="author-name">{{ data.attributes.author.name }}</span>' ); ?></span>
				<# } else { #>
					<span class="byline"><?php printf( __( 'Revision by %s' ),
						'<span class="author-name">{{ data.attributes.author.name }}</span>' ); ?></span>
				<# } #>
					<span class="time-ago">{{ data.attributes.timeAgo }}</span>
					<span class="date">( {{ data.attributes.dateShort }} )</span>
				</div>
			<# if ( 'to' === data.type && data.attributes.restoreUrl ) { #>
				<input  <?php if ( MP_Mail_lock::check( $mail->id ) ) { ?>
					disabled="disabled"
				<?php } else { ?>
					<# if ( data.attributes.current ) { #>
						disabled="disabled"
					<# } #>
				<?php } ?>
				<# if ( data.attributes.autosave ) { #>
					type="button" class="restore-revision button button-primary" value="<?php echo esc_attr( __( 'Restore This Autosave' ) ); ?>" />
				<# } else { #>
					type="button" class="restore-revision button button-primary" value="<?php echo esc_attr( __( 'Restore This Revision' ) ); ?>" />
				<# } #>
			<# } #>
		</div>
	<# if ( 'tooltip' === data.type ) { #>
		<div class="revisions-tooltip-arrow"><span></span></div>
	<# } #>
<# } #>
</script>

<script id="tmpl-revisions-diff" type="text/html">
	<div class="loading-indicator"><span class="spinner"></span></div>
	<div class="diff-error"><?php _e( 'Sorry, something went wrong. The requested comparison could not be loaded.' ); ?></div>
	<div class="diff">
	<# _.each( data.fields, function( field ) { #>
		<h3>{{ field.name }}</h3>
		{{{ field.diff }}}
	<# } ); #>
	</div>
</script>