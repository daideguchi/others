<?php

$results = MP_Mail_links::process();

$view_ = filter_input( INPUT_GET, 'view' );

if ( isset( $view_ ) )
{
	$mp_title = $results ['title'];
	include( 'header.php' );
?>
	</head>
	<body>
		<div>
			<div>
				<b><?php echo $results ['title']; ?></b>
			</div>
			<?php echo $results ['content']; ?>
		</div>
	</body>
</html>
<?php
	return true;
}

get_header();
?>
	<div id="content" class="widecolumn">
		<div>
			<h2><?php echo $results ['title']; ?></h2>
			<div>
				<?php echo $results ['content']; ?>
			</div>
		</div>
	</div>
<?php
get_footer();
?>