<!DOCTYPE html>
<?php include( 'header.php' ); ?>
<style type="text/css">* html { overflow-x: hidden; }</style>
<?php
register_admin_color_schemes();

wp_enqueue_style( 'colors' );
wp_enqueue_style( 'ie' );
wp_enqueue_script( 'utils' );

wp_register_style( 'mp_common',	'/' . MP_PATH . 'mp-admin/css/common.css' );
wp_enqueue_style( 'mp_common' );
wp_register_style( 'mp_exts', '/' . MP_PATH . 'mp-admin/css/_exts.css' );
wp_enqueue_style( 'mp_exts' );

do_action( 'admin_print_styles' );
?>
<script type="text/javascript">
//<![CDATA[
addLoadEvent = function( func ) {if ( typeof jQuery != "undefined" ) jQuery( document ).ready( func ); else if ( typeof wpOnload!='function' ){wpOnload=func;} else {var oldonload=wpOnload; wpOnload=function(){oldonload();func();}}};
//]]>
<?php
wp_enqueue_script( 'jquery-ui-tabs' );
do_action( 'admin_print_scripts' );
?>
<link rel="stylesheet" href="<?php echo site_url() . '/' . MP_PATH; ?>mp-admin/css/mail.css" type="text/css" title="MailPress" media="all" />
</script>
<style type="text/css">
div.mp_ext:first-of-type + div, div.mp_ext_uploading:first-of-type + div {
	display: inline;
}
</style>
	</head>
	<body id="media-upload">
		<div id="wpwrap">
			<div id="wpcontent" style="margin:0;">
				<div id="wpbody" style="background-color:#fff;margin-left:15px;">
					<div class="wrap">
<?php if ( isset( $view ) ) : ?>
						<form>
							<div id="post-body">
								<table class="form-table">
									<tr>
										<th>
											<?php _e( 'From', 'MailPress' ); ?>
										</th>
										<td>
											<?php echo $from; ?>
										</td>
									</tr>
									<tr>
										<th>
											<?php _e( 'To', 'MailPress' ); ?>
										</th>
										<td>
											<?php echo $to; ?>
										</td>
									</tr>
									<tr>
										<th>
											<?php _e( 'Subject', 'MailPress' ); ?>
										</th>
										<td>
											<b><?php echo $subject;?></b> 
										</td>
									</tr>
								</table>
							</div>
						</form>
<?php endif; ?>
						<div id="example">
							<ul class="tablenav ui-tabs-nav">
<?php if ( isset( $plaintext ) ) : ?>
								<li id="li_plaintext"><a href="#fragment-2"><span><?php _e( 'Plaintext View', 'MailPress' ); ?></span></a></li>
<?php endif; ?>
<?php if ( isset( $html ) ) : ?>
								<li id="li_html" class="ui-tabs-selected"><a href="#fragment-1"><span><?php _e( 'Html View', 'MailPress' ); ?></span></a></li>
<?php endif; ?>
							</ul>

<?php if ( isset( $plaintext ) ) : ?>
							<div id="fragment-2">
								<div style="margin:0;background:#fff;border:1px solid #c0c0c0;padding:5px;">
									<?php echo $plaintext; ?>
								</div>
							</div>
<?php endif; ?>
<?php if ( isset( $html ) ) : ?>
							<div id="fragment-1">
								<div style="margin:0;background:#fff;border:1px solid #c0c0c0;padding:5px;">
									<?php echo $html; ?>
								</div>
							</div>
<?php endif; ?>
						</div>
<?php if ( isset( $attachments ) && ( !empty( $attachments ) ) ) : ?>
						<div id="attachments">
							<table>
								<tr>
									<td style="vertical-align:top;">
										<?php _e( 'Attachments', 'MailPress' ); ?>
									</td>
									<td>
										<table>
											<?php echo $attachments; ?>
										</table>
									</td>
								</tr>
							</table>
						</div>
<?php endif; ?>
					</div>
				</div>
			</div>
			<br />
		</div>
<?php do_action( 'admin_print_footer_scripts' ); ?>
<script type="text/javascript">
	jQuery( document ).ready( function(){ jQuery( '#example' ).tabs( {active:1} ); } );
</script>
	</body>
</html>