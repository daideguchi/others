<?php //ページ改
if ( ! function_exists( '_st_link_pages_next' ) ) {
	function _st_link_pages_next( $output, $args ) {
		global $page, $numpages, $multipage;

		if ( ! $multipage ) {
			return $output;
		}

		$html = '';
		$prev = $page - 1;

		if ( $prev > 0 ) {
			$link = '';

			if ( trim( $args['previouspagelink'] ) !== '' ) {
				$link = _wp_link_page( $prev ) . $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';
			}

			$html .= apply_filters( 'wp_link_pages_link', $link, $prev );
		}

		$next = $page + 1;

		if ( $next <= $numpages ) {
			if ( $prev && trim( $args['previouspagelink'] ) !== '' ) {
				$html .= $args['separator'];
			}

			$link = '';

			if ( trim( $args['nextpagelink'] ) !== '' ) {
				$link = _wp_link_page( $next ) . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>';
			}

			$html .= apply_filters( 'wp_link_pages_link', $link, $next );
		}

		if ( trim( $html ) !== '' ) {
			$html = $args['before'] . $html . $args['after'];
		}

		return $html;
	}
}

if ( ! function_exists( '_st_link_pages_number_first_last' ) ) {
	function _st_link_pages_number_first_last( $output, $args ) {
		global $page, $numpages, $multipage, $more;

		if ( ! $multipage ) {
			return $output;
		}

		$html = '';
		$html .= $args['before'];

		if ( $page > 1 ) {
			$link = sprintf(
				$args['firstpagelinkitem'],
				esc_url( _st_link_page_url( 1 ) ),
				$args['link_before'] . $args['firstpagelink'] . $args['link_after']
			);
		} else {
			$link = sprintf(
				$args['firstpageitem'],
				$args['link_before'] . $args['firstpagelink'] . $args['link_after']
			);
		}

		$html .= $link;

		for ( $i = 1; $i <= $numpages; $i ++ ) {
			$link = $args['link_before'] . str_replace( '%', $i, $args['pagelink'] ) . $args['link_after'];

			if ( $i !== (int) $page || ( ! $more && (int) $page === 1 ) ) {
				$link = sprintf( $args['pagelinkitem'], esc_url( _st_link_page_url( $i ) ), $link );
			} else {
				$link = sprintf( $args['pageitem'], $link );
			}

			$link = apply_filters( 'wp_link_pages_link', $link, $i );

			$html .= ( $i === 1 ) ? ' ' : $args['separator'];
			$html .= $link;
		}

		if ( $page < $numpages ) {
			$link = sprintf(
				$args['lastpagelinkitem'],
				esc_url( _st_link_page_url( $numpages ) ),
				$args['link_before'] . $args['lastpagelink'] . $args['link_after']
			);
		} else {
			$link = sprintf( $args['lastpageitem'],
				$args['link_before'] . $args['lastpagelink'] . $args['link_after'] );
		}

		$html .= $link;
		$html .= $args['after'];

		return $html;
	}
}

if ( ! function_exists( 'st_link_pages' ) ) {
	function st_link_pages( $output, $args ) {
		global $multipage;

		if ( ! $multipage ) {
			return $output;
		}

		$defaults = array(
			'before'            => '<p>' . __( 'Pages:' ),
			'after'             => '</p>',
			'link_before'       => '',
			'link_after'        => '',
			'next_or_number'    => 'number',
			'separator'         => ' ',
			'nextpagelink'      => __( 'Next page' ),
			'previouspagelink'  => __( 'Previous page' ),
			'pagelink'          => '%',
			'echo'              => 1,
			'firstpagelink'     => __( 'First page' ),
			'lastpagelink'      => __( 'Last page' ),
			'firstpageitem'     => '%s',
			'pageitem'          => '%s',
			'lastpageitem'      => '%s',
			'firstpagelinkitem' => '<a href="%s">%s</a>',
			'pagelinkitem'      => '<a href="%s">%s</a>',
			'lastpagelinkitem'  => '<a href="%s">%s</a>',
		);

		$params = wp_parse_args( $args, $defaults );
		$r      = apply_filters( 'wp_link_pages_args', $params );

		if ( $r['next_or_number'] === 'next' ) {
			return _st_link_pages_next( $output, $r );
		}

		if ( $r['next_or_number'] === 'number_first_last' ) {
			return _st_link_pages_number_first_last( $output, $r );
		}

		return $output;
	}
}

add_filter( 'wp_link_pages', 'st_link_pages', 10, 2 );

$next = array(
	'before'           => '<p class="tuzukicenter"><span class="tuzuki">',
	'after'            => '</span></p>',
	'link_before'      => '',
	'link_after'       => '',
	'next_or_number'   => 'next',
	'nextpagelink'     => __( '次のページへ&ensp;&gt;', 'default' ),
	'previouspagelink' => '',
);

wp_link_pages( $next );

$number = array(
	'before'            => '<div class="st-pagelink st-pagelink-pages">',
	'after'             => '</div>',
	'next_or_number'    => 'number_first_last',
	'firstpagelink'     => '&lt;',
	'lastpagelink'      => '&gt;',
	'firstpageitem'     => '<span class="page-numbers first disabled">%s</span>',
	'pageitem'          => '<span class="page-numbers current">%s</span>',
	'lastpageitem'      => '<span class="page-numbers last disabled">%s</span>',
	'firstpagelinkitem' => '<a class="page-numbers first" href="%s">%s</a>',
	'pagelinkitem'      => '<a class="page-numbers" href="%s">%s</a>',
	'lastpagelinkitem'  => '<a class="page-numbers last" href="%s">%s</a>',
);

wp_link_pages( $number );
