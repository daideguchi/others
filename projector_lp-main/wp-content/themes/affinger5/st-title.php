<?php
// 直接アクセスを禁止
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( trim(($GLOBALS["stdata95"] ) === '')) {

	if ( !function_exists( 'st_document_title_separator' ) ) {
		function st_get_document_title_separator()
		{
			return '-';
		}
	}
	add_filter('document_title_separator', 'st_get_document_title_separator');
	
	if ( !function_exists( 'st_wp_title' ) ) {
		function st_wp_title($sep = '&raquo;', $display = true, $seplocation = '' ) {
			global $wp_locale, $page, $paged;
	
			$m	   = get_query_var( 'm' );
			$year	= get_query_var( 'year' );
			$monthnum = get_query_var( 'monthnum' );
			$day	 = get_query_var( 'day' );
			$search = function_exists( 'st_cs_get_search_query' )
				? st_cs_get_search_query( null, '', '', '', ' - ', '・' )
				: get_query_var( 's' );
			$title    = '';
			$t_sep    = '%WP_TITILE_SEP%';
	
			if ( is_single() || ( is_home() && !is_front_page() ) || ( is_page() && !is_front_page() ) ) {
				$title = single_post_title( '', false );
			}
	
			if ( is_post_type_archive() ) {
				$post_type = get_query_var( 'post_type' );
	
				if ( is_array( $post_type ) ) {
					$post_type = reset( $post_type );
				}
	
				$post_type_object = get_post_type_object( $post_type );
	
				if ( !$post_type_object->has_archive ) {
					$title = post_type_archive_title( '', false );
				}
			}
	
			if ( is_category() || is_tag() ) {
				$title = single_term_title( '', false );
			}
	
			if ( is_tax() ) {
				$term = get_queried_object();
	
				if ( $term ) {
					$tax   = get_taxonomy( $term->taxonomy );
					$title = single_term_title( $tax->labels->name . $t_sep, false );
				}
			}
	
			if ( is_author() && !is_post_type_archive() ) {
				$author = get_queried_object();
	
				if ( $author ) {
					$title = $author->display_name;
				}
			}
	
			if ( is_post_type_archive() && $post_type_object->has_archive ) {
				$title = post_type_archive_title( '', false );
			}

			if ( is_archive() && !empty( $m ) ) {
				$my_year  = substr( $m, 0, 4 );
				$my_month = $wp_locale->get_month( substr( $m, 4, 2 ) );
				$my_day   = intval( substr( $m, 6, 2 ) );
				$title    = $my_year . ( $my_month ? $t_sep . $my_month : '' ) . ( $my_day ? $t_sep . $my_day : '' );
			}
	
			if ( is_archive() && !empty( $year ) ) {
				$title = $year;
	
				if ( !empty( $monthnum ) ) {
					$title .= $t_sep . $wp_locale->get_month( $monthnum );
				}
				if ( !empty( $day ) ) {
					$title .= $t_sep . zeroise( $day, 2 );
				}
			}
	
			if ( is_search() ) {
				$title = sprintf( __( 'Search Results %1$s %2$s','default' ), $t_sep, strip_tags( $search ) );
			}
	
			if ( is_404() ) {
				$title = __( 'Page not found','default' );
			}
	
			$prefix = '';
	
			if ( !empty( $title ) ) {
				$prefix = " $sep ";
			}
	
			$title_array = apply_filters( 'wp_title_parts', explode( $t_sep, $title ) );
	
			if ( $seplocation === 'right' ) {
				$title_array = array_reverse( $title_array );
				$title	  = implode( " $sep ", $title_array ) . $prefix;
			} else {
				$title = $prefix . implode( " $sep ", $title_array );
			}
	
			if ( ! did_action( 'wp_head' ) && ! doing_action( 'wp_head' ) ) {
				$title = apply_filters( 'wp_title', $title, $sep, $seplocation );
			}
	
			if ( $display ) {
				echo $title;
			} else {
				return $title;
			}
		}
	}
	
	if ( !function_exists( 'st_get_document_title' ) ) {
		function st_get_document_title() {
			global $page, $paged;
	
			$title	= '';
			$blog_name = get_bloginfo( 'name', 'display' );
			$page_name = '';
	
			if ( $paged >= 2 || $page >= 2 ) {
				$page_name = ' ' . st_get_document_title_separator() . ' ' . sprintf( '%sページ', max( $paged, $page ) );
			}

			if ( is_front_page() ) {
				if ( trim( $GLOBALS["stdata33"] ) !== '' ) {
					$title = esc_html( $GLOBALS["stdata33"] );
				}elseif(is_front_page() && !is_home()){
					$title = single_post_title( '', false ); //記事タイトル
				}else{
					$title .= get_bloginfo( 'description', 'display' ) . ' ' . st_get_document_title_separator() . ' ' . get_bloginfo( 'name', 'display' );
				}
	
				return $title;
			}
	
	if ( trim( ($GLOBALS["stdata94"] ) !== '') &&  ( is_single() || ( is_home() && !is_front_page() ) || ( is_page() && !is_front_page() ) ) ) { //タイトルにサイト名を付加しない
			$title = single_post_title( '', false );
			$title .= $page_name;
	}else{
			switch ( true ) {
				case ( is_single() ):
					$title .= st_wp_title( st_get_document_title_separator(), false, 'right' );
					break;
	
				case ( is_page() ):
					$title .= st_wp_title( st_get_document_title_separator(), false, 'right' );
					break;

           			case ( is_home() && !is_front_page() ):
					$title .= st_wp_title( st_get_document_title_separator(), false, 'right' );
					break;

				case ( is_archive() ):
					$title .= st_wp_title( st_get_document_title_separator(), false, 'right' );
					break;
	
				case ( is_search() ):
					$title .= st_wp_title( st_get_document_title_separator(), false, 'right' );
					break;
	
				case ( is_404() ):
					$title .= '404 ' . st_get_document_title_separator();
					break;
	
				default:
					break;
			}
	
			$title .= $blog_name . $page_name;
	}
	
			if ( is_single() or is_page() or ( is_home() && !is_front_page() ) ) {
				global $wp_query;
				$postID = $wp_query->post->ID;
				$sttitlewords = get_post_meta( $postID, 'st_titlewords', true );
			} else {
				$sttitlewords = '';
			};
			if (isset( $sttitlewords ) && trim( $sttitlewords ) !== '') {
				$title = $sttitlewords;
			} 
	
			if(is_category()){
					$now_category = get_query_var('cat');
					$args = array(
						 'include' => array($now_category),
					);
					$tag_all = get_terms("category", $args);
					$cat_data = get_option('cat_'.$now_category);
			
				if(trim($cat_data['st_cattitle']) !== ''){
					$title = esc_html($cat_data['st_cattitle']);
					 }
			}
	
			return $title;
		}

		if ( !function_exists( 'wp_get_document_title' ) ) {
			add_filter( 'wp_title', 'st_get_document_title' );
		}
	}
	
	if ( !function_exists( 'st_legacy_render_title_tag' ) ) {
		function st_legacy_render_title_tag() {
			echo '<' . 'title>' . st_get_document_title() . '<' . '/title>' . "\n";
		}
	
		if ( !function_exists( '_wp_render_title_tag' ) ) {
			add_action( 'wp_head', 'st_legacy_render_title_tag', 1 );
		}
	}
	
	if ( !function_exists( 'st_get_document_title_array' ) ) {
		function st_get_document_title_array() {
			return array( st_get_document_title() );
		}
	
		if ( function_exists( 'wp_get_document_title' ) ) {
			add_filter( 'document_title_parts', 'st_get_document_title_array' );
		}
	}
	
	remove_filter( 'wp_title', 'wptexturize' );
	remove_filter( 'the_title', 'wptexturize'   );
	
	if ( !function_exists( 'st_render_title_tag_wrapper' ) ) {
		function st_render_title_tag_wrapper() {
			$GLOBALS['_st_should_run_wptexturize'] = false;
			wptexturize( 'force to reset static $run_wptexturize', true );
	
			_wp_render_title_tag();
	
			$GLOBALS['_st_should_run_wptexturize'] = true;
			wptexturize( 'force to reset static $run_wptexturize', true );
	
			unset($GLOBALS['_st_should_run_wptexturize']);
		}
	}
	
	if ( !function_exists( 'st_should_run_wptexturize' ) ) {
		function st_should_run_wptexturize( $run_texturize ) {
			if ( !isset( $GLOBALS['_st_should_run_wptexturize'] ) || $GLOBALS['_st_should_run_wptexturize'] ) {
				return $run_texturize;
			}
	
			return false;
		}
	}
	add_filter( 'run_wptexturize', 'st_should_run_wptexturize', PHP_INT_MAX );
	
	if ( function_exists( '_wp_render_title_tag' ) ) {
		// _wp_render_title_tag 差し替え
		remove_action( 'wp_head', '_wp_render_title_tag', 1 );
		add_action( 'wp_head', 'st_render_title_tag_wrapper', 1 );
	}


} 