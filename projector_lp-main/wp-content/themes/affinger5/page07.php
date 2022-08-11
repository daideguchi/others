<?php
/*
Template Name:白紙ノート
*/
$st_is_ex    = st_is_ver_ex();
$st_is_ex_af = st_is_ver_ex_af();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="i7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
		<meta charset="<?php bloginfo( 'charset' ); ?>" >
		<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
		<link href='https://fonts.googleapis.com/css?family=Montserrat:400' rel='stylesheet' type='text/css'>
		<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<script src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/js/html5shiv.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>
	<body id="hakusinote" <?php body_class(); ?> >
		<div id="wrapper" class="lp colum1">
			<header id="">
			</header>
			<div id="content" class="clearfix">
				<div id="contentInner">
					<main style="border-radius:0;">
						<div class="post" id="st-page">
							<article>
								<!--ループ開始 -->
								<?php if ( have_posts() ): ?>
									<?php while ( have_posts() ): the_post(); ?>
										<h1 class="entry-title st-css-no"><?php if ( $st_is_ex ): st_the_title(); else: the_title(); endif;    // タイトル ?></h1>
										<?php st_the_content( array( 'page', 'main' ) );    // 本文 ?>
										<?php get_template_part( 'itiran-date-singular' );    // 投稿日 ?>
									<?php endwhile; else: ?>
								<?php endif; ?>
								<!--ループ終了 -->
							</article>
						</div>
						<!--/post-->
					</main>
				</div>
				<!-- /#contentInner -->
			</div>
			<!--/#content -->
			<footer id="footer" style="margin:0;padding:0;">
			</footer>
		</div>
	<!-- /#wrapper -->
	<?php wp_footer(); ?>
	</body>
</html>
