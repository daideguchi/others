<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( locate_template( 'st-shortcode-amp.php' ) !== '' ) {
	require_once locate_template( 'st-shortcode-amp.php' );
}

if ( ! function_exists( 'amp_if_amp_then' ) ) {
	function amp_if_amp_then( $callable ) {
		return function () use ( $callable ) {
			if ( ! amp_is_amp() ) {
				return null;
			}

			return call_user_func_array( $callable, func_get_args() );
		};
	}
}

if ( ! function_exists( 'amp_get_query_var' ) ) {
	function amp_get_query_var() {
		return apply_filters( 'amp_query_var', 'amp' );
	}
}

if ( ! function_exists( 'amp_get_meta_key' ) ) {
	function amp_get_meta_key() {
		return apply_filters( 'amp_meta_key', 'amp_is_enabled' );
	}
}

if ( ! function_exists( 'amp_is_queried' ) ) {

	function amp_is_queried() {
		return (bool) get_query_var( amp_get_query_var() );
	}
}

if ( ! function_exists( 'amp_is_supported' ) ) {
	function amp_is_supported( $post = null ) {
		$post                 = ( $post !== null ) ? $post : get_the_ID();
		$post                 = ( $post !== null ) ? $post : get_queried_object_id();
		$post                 = get_post( $post );

		if ( ! $post ) {
			return false;
		}

		$is_option_enabled    = ( get_option( 'st-data120', false ) === 'yes' );
		$is_post_meta_enabled = ( get_post_meta( $post->ID, amp_get_meta_key(), true ) === '1' );

		return $is_option_enabled || $is_post_meta_enabled;
	}
}

if ( ! function_exists( 'amp_is_amp' ) ) {

	function amp_is_amp() {
		return amp_is_queried() && amp_is_supported( get_queried_object_id() );
	}
}

if ( ! function_exists( 'amp_init' ) ) {
	function amp_init() {
		global $wp_rewrite;

		add_rewrite_endpoint( amp_get_query_var(), EP_PERMALINK );

		$permalink_structure = get_option( 'permalink_structure' );

		$rules_none = $wp_rewrite->generate_rewrite_rules(
			$permalink_structure,
			EP_NONE,
			false,
			false,
			false,
			false,
			false
		);

		$rules_permalink = $wp_rewrite->generate_rewrite_rules(
			$permalink_structure,
			EP_PERMALINK,
			false,
			false,
			false,
			false,
			false
		);

		$rules_permalink_endpoints = $wp_rewrite->generate_rewrite_rules(
			$permalink_structure,
			EP_PERMALINK,
			false,
			false,
			false,
			false,
			true
		);

		$rules_endpoints = array_diff( $rules_permalink_endpoints, $rules_permalink, $rules_none );
		$rewrite_rules   = array();

		foreach ( $rules_endpoints as $pattern => $url ) {
			$pattern_pattern = '(/' . preg_quote( amp_get_query_var(), '!' ) . ')';
			$url_pattern     = '([?&])(' . preg_quote( amp_get_query_var(), '!' ) . '=\\$)([0-9]+)';

			if ( ! preg_match( '!' . $url_pattern . '!', $url ) ) {
				continue;
			}

			$paged_pattern = preg_replace( '!' . $pattern_pattern . '!', '$1(/([0-9]+))?', $pattern );
			$paged_url     = preg_replace_callback(
				'!' . $url_pattern . '!',
				function ( $matches ) {
					return $matches[1] . 'page=$' . $matches[3] . '&' . $matches[2] . ( ( (int) $matches[3] ) + 2 );
				},
				$url
			);

			$rewrite_rules[ $paged_pattern ] = $paged_url;
		}

		foreach ( $rewrite_rules as $pattern => $url ) {
			$url = preg_replace( '!\\$([0-9]+)!', '$matches[$1]', $url );

			add_rewrite_rule( $pattern, $url, 'top' );
		}
	}
}
add_action( 'init', 'amp_init' );

if ( ! function_exists( 'amp_flush_rewrite_rules' ) ) {
	function amp_flush_rewrite_rules() {
		flush_rewrite_rules();
	}
}
add_action( 'after_switch_theme', 'amp_flush_rewrite_rules' );

if ( ! function_exists( 'amp_parse_request' ) ) {
	function amp_parse_request( $query_vars ) {
		if ( is_admin() ) {
			return $query_vars;
		}

		$key = amp_get_query_var();

		if ( isset( $query_vars[ $key ] ) ) {
			$query_vars [ $key ] = 1;
		}

		return $query_vars;
	}
}
add_filter( 'request', 'amp_parse_request' );

if ( ! function_exists( 'amp_after_setup_wp' ) ) {
	function amp_after_setup_wp() {
		if ( is_admin() ) {
			return;
		}

		if ( ! amp_is_amp() ) {
			return;
		}

		amp_initialize_filters();
		amp_initialize_shortcodes();
	}
}
add_action( 'wp', 'amp_after_setup_wp', PHP_INT_MAX );

if ( ! function_exists( 'amp_handle_404' ) ) {
	function amp_handle_404() {
		if ( is_admin() ) {
			return;
		}

		if ( ! amp_is_queried() || amp_is_supported( get_queried_object_id() ) ) {
			return;
		}

		$GLOBALS['wp_query']->set_404();

		status_header( 404 );
		nocache_headers();
	}
}
add_action( 'wp', 'amp_handle_404' );

if ( ! function_exists( 'amp_template_include' ) ) {
	function amp_template_include( $template ) {
		if ( ! amp_is_amp() ) {
			return $template;
		}

		return get_query_template( 'single', array( 'single-amp.php' ) );
	}
}
add_filter( 'template_include', 'amp_template_include' );

if ( ! function_exists( 'amp_display_meta_box' ) ) {
	function amp_display_meta_box( $post ) {
		$meta_key   = amp_get_meta_key();
		$is_enabled = get_post_meta( $post->ID, $meta_key, true );

		?>
		<label for="<?php esc_attr_e( $meta_key ); ?>" class="selectit">
			<input name="<?php esc_attr_e( $meta_key ); ?>" type="checkbox"
				   id="<?php esc_attr_e( $meta_key ); ?>"
				   value="1" <?php checked( $is_enabled, '1' ); ?> />
			AMPに対応する（β）
		</label>
		<?php wp_nonce_field( 'save-amp-meta', 'save_amp_meta_nonce' ); ?>
		<?php
	}
}

if ( ! function_exists( 'amp_add_meta_boxes' ) ) {
	function amp_add_meta_boxes() {
		add_meta_box( 'amp', 'AMP設定', 'amp_display_meta_box', null, 'side', 'default', null );
	}
}
add_action( 'add_meta_boxes_post', 'amp_add_meta_boxes' );

if ( ! function_exists( 'amp_save_meta_box' ) ) {
	function amp_save_meta_box( $post_id ) {
		$nonce = isset( $_POST['save_amp_meta_nonce'] ) ? $_POST['save_amp_meta_nonce'] : null;

		if ( $nonce !== null && wp_verify_nonce( $nonce, wp_create_nonce( 'save-amp-meta' ) ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$meta_key   = amp_get_meta_key();
		$is_enabled = isset( $_POST[ $meta_key ] ) ? '1' : '0';

		update_post_meta( $post_id, $meta_key, $is_enabled );
	}
}
add_action( 'save_post_post', 'amp_save_meta_box' );

if ( ! function_exists( 'wp_get_canonical_url' ) ) {
	function wp_get_canonical_url( $post = null ) {
		$post = get_post( $post );

		if ( ! $post ) {
			return false;
		}

		if ( 'publish' !== $post->post_status ) {
			return false;
		}

		$canonical_url = get_permalink( $post );

		if ( $post->ID === get_queried_object_id() ) {
			$page = get_query_var( 'page', 0 );

			if ( $page >= 2 ) {
				if ( '' == get_option( 'permalink_structure' ) ) {
					$canonical_url = add_query_arg( 'page', $page, $canonical_url );
				} else {
					$canonical_url = trailingslashit( $canonical_url ) . user_trailingslashit( $page, 'single_paged' );
				}
			}

			$cpage = get_query_var( 'cpage', 0 );

			if ( $cpage ) {
				$canonical_url = get_comments_pagenum_link( $cpage );
			}
		}

		return apply_filters( 'get_canonical_url', $canonical_url, $post );
	}
}

if ( ! function_exists( 'amp_get_comments_pagenum_link' ) ) {
	function amp_get_comments_pagenum_link( $pagenum = 1, $max_page = 0 ) {
		global $wp_rewrite;

		$pagenum = (int) $pagenum;

		$result = get_permalink();

		if ( get_option( 'default_comments_page' ) === 'newest' ) {
			if ( $pagenum !== $max_page ) {
				if ( $wp_rewrite->using_permalinks() ) {
					$result = trailingslashit( $result ) . amp_get_query_var();
					$result = user_trailingslashit( trailingslashit( $result ) . $wp_rewrite->comments_pagination_base . '-' . $pagenum, 'commentpaged' );
				} else {
					$result = add_query_arg( 'cpage', $pagenum, $result );
					$result = add_query_arg( amp_get_query_var(), '1', $result );
				}
			}
		} elseif ( $pagenum > 1 ) {
			if ( $wp_rewrite->using_permalinks() ) {
				$result = trailingslashit( $result ) . amp_get_query_var();
				$result = user_trailingslashit( trailingslashit( $result ) . $wp_rewrite->comments_pagination_base . '-' . $pagenum, 'commentpaged' );
			} else {
				$result = add_query_arg( 'cpage', $pagenum, $result );
				$result = add_query_arg( amp_get_query_var(), '1', $result );
			}
		} else {
			if ( $wp_rewrite->using_permalinks() ) {
				$result = trailingslashit( $result ) . user_trailingslashit( amp_get_query_var(), 'single_amp' );
			} else {
				$result = add_query_arg( amp_get_query_var(), '1', $result );
			}
		}

		$result .= '#comments';

		return apply_filters( 'get_comments_pagenum_link', $result );
	}
}

if ( ! function_exists( 'amp_get_canonical_url' ) ) {
	function amp_get_canonical_url( $post = null ) {
		$post = get_post( $post );

		if ( ! $post ) {
			return false;
		}

		if ( 'publish' !== $post->post_status ) {
			return false;
		}

		$canonical_url = get_permalink( $post );

		if ( $post->ID === get_queried_object_id() ) {
			$page = get_query_var( 'page', 0 );

			if ( $page >= 2 ) {
				if ( get_option( 'permalink_structure' ) === '' ) {
					$canonical_url = add_query_arg( 'page', $page, $canonical_url );
					$canonical_url = add_query_arg( amp_get_query_var(), '1', $canonical_url );
				} else {
					$canonical_url = trailingslashit( $canonical_url ) . amp_get_query_var();
					$canonical_url = trailingslashit( $canonical_url ) . user_trailingslashit( $page, 'single_paged' );
				}
			} else {
				if ( get_option( 'permalink_structure' ) === '' ) {
					$canonical_url = add_query_arg( amp_get_query_var(), '1', $canonical_url );
				} else {
					$canonical_url = trailingslashit( $canonical_url ) . user_trailingslashit( amp_get_query_var(), 'single_amp' );
				}
			}

			$cpage = get_query_var( 'cpage', 0 );

			if ( $cpage ) {
				$canonical_url = amp_get_comments_pagenum_link( $cpage );
			}
		}

		remove_filter( 'get_canonical_url', 'st_get_canonical_url', 10 );

		$canonical_url = apply_filters( 'get_canonical_url', $canonical_url, $post );

		add_filter( 'get_canonical_url', 'st_get_canonical_url', 10, 2 );

		return $canonical_url;
	}
}

if ( ! function_exists( 'amp_output_amphtml_link' ) ) {
	function amp_output_amphtml_link() {
		if ( ! is_single() || ! amp_is_supported() ) {
			return;
		}

		$url_attr = esc_url( amp_get_canonical_url() );

		echo <<<HTML
<link rel="amphtml" href="{$url_attr}">
HTML;
		$should_prioritize_index = ( get_option( 'st-data237', false ) === 'yes' );

		if ($should_prioritize_index) {
			echo <<<HTML
	<link rel="alternate" media="only screen and (max-width: 599px)" href="{$url_attr}">

HTML;
		}
	}
}
add_action( 'wp_head', 'amp_output_amphtml_link' );

if ( ! function_exists( 'amp_get_kses_allowed_html' ) ) {
	function amp_get_kses_allowed_html() {
		$allowed_html = array(
			'article'    => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'section'    => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'nav'        => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'aside'      => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'h1'         => array(
				'align' => true,
			),
			'h2'         => array(
				'align' => true,
			),
			'h3'         => array(
				'align' => true,
			),
			'h4'         => array(
				'align' => true,
			),
			'h5'         => array(
				'align' => true,
			),
			'h6'         => array(
				'align' => true,
			),
			'header'     => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'footer'     => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'address'    => array(),

			'p'          => array(
				'align'    => true,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'hr'         => array(
				'align' => false,
			),
			'pre'        => array(
				'width' => false,
			),
			'blockquote' => array(
				'cite' => true,
			),
			'ol'         => array(
				'start'    => true,
				'type'     => true,
				'reversed' => false,
			),
			'ul'         => array(
				'type' => true,
			),
			'li'         => array(
				'align' => false,
				'value' => true,
			),
			'dl'         => array(),
			'dt'         => array(),
			'dd'         => array(),
			'figure'     => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'figcaption' => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'div'        => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'main'       => array(),

			'a'          => array(
				'href'   => true,
				'rel'    => true,
				'rev'    => true,
				'name'   => true,
				'target' => true,
				'data-vars-click-id' => true,
			),
			'em'         => array(),
			'strong'     => array(),
			'small'      => array(),
			's'          => array(),
			'cite'       => array(
				'dir'  => true,
				'lang' => true,
			),
			'q'          => array(
				'cite' => true,
			),
			'dfn'        => array(),
			'abbr'       => array(),
			'time'       => array(),
			'code'       => array(),
			'var'        => array(),
			'samp'       => array(),
			'kbd '       => array(),
			'sub'        => array(),
			'sup'        => array(),
			'i'          => array(),
			'b'          => array(),
			'u'          => array(),
			'mark'       => array(),
			'ruby'       => array(),
			'rt'         => array(),
			'rp'         => array(),
			'bdi'        => array(),
			'bdo'        => array(
				'dir' => true,
			),
			'span'       => array(
				'dir'      => true,
				'align'    => false,
				'lang'     => true,
				'xml:lang' => false,
			),
			'br'         => array(),
			'wbr'        => array(),

			'ins'        => array(
				'datetime' => true,
				'cite'     => true,
			),
			'del'        => array(
				'datetime' => true,
			),

			'source'     => array(),
			'table'      => array(
				'align'       => true,
				'bgcolor'     => true,
				'border'      => true,
				'cellpadding' => true,
				'cellspacing' => true,
				'dir'         => true,
				'rules'       => false,
				'summary'     => false,
				'width'       => true,
			),
			'caption'    => array(
				'align'    => false,
				'dir'      => true,
				'lang'     => true,
				'xml:lang' => false,
			),
			'colgroup'   => array(
				'align'   => false,
				'char'    => false,
				'charoff' => false,
				'span'    => true,
				'valign'  => false,
				'width'   => false,
			),
			'col'        => array(
				'align'   => false,
				'char'    => false,
				'charoff' => false,
				'span'    => true,
				'dir'     => true,
				'valign'  => false,
				'width'   => false,
			),
			'tbody'      => array(
				'align'   => false,
				'char'    => false,
				'charoff' => false,
				'valign'  => false,
			),
			'thead'      => array(
				'align'   => false,
				'char'    => false,
				'charoff' => false,
				'valign'  => false,
			),
			'tfoot'      => array(
				'align'   => false,
				'char'    => false,
				'charoff' => false,
				'valign'  => false,
			),
			'tr'         => array(
				'align'   => true,
				'bgcolor' => true,
				'char'    => false,
				'charoff' => false,
				'valign'  => true,
			),
			'td'         => array(
				'abbr'    => false,
				'align'   => true,
				'axis'    => false,
				'bgcolor' => true,
				'char'    => false,
				'charoff' => false,
				'colspan' => true,
				'dir'     => true,
				'headers' => true,
				'height'  => true,
				'nowrap'  => false,
				'rowspan' => true,
				'scope'   => false,
				'valign'  => true,
				'width'   => true,
			),
			'th'         => array(
				'abbr'    => true,
				'align'   => true,
				'axis'    => false,
				'bgcolor' => true,
				'char'    => false,
				'charoff' => false,
				'colspan' => true,
				'headers' => true,
				'height'  => true,
				'nowrap'  => false,
				'rowspan' => true,
				'scope'   => false,
				'valign'  => true,
				'width'   => true,
			),

			'button'     => array(
				'disabled' => true,
				'name'     => true,
				'type'     => true,
				'value'    => true,
			),

			'noscript'   => array(),

			'meta' => array(
				'name'     => true,
				'property' => true,
				'content'  => true,
			),

			'img'        => array(
				'alt'      => true,
				'align'    => false,
				'border'   => false,
				'height'   => true,
				'hspace'   => false,
				'longdesc' => false,
				'vspace'   => false,
				'src'      => true,
				'usemap'   => false,
				'width'    => true,

				'srcset' => true,
			),
			'video'      => array(
				'autoplay' => true,
				'controls' => true,
				'height'   => true,
				'loop'     => true,
				'muted'    => true,
				'poster'   => true,
				'preload'  => true,
				'src'      => true,
				'width'    => true,
			),
			'audio'      => array(
				'autoplay' => true,
				'controls' => true,
				'loop'     => true,
				'muted'    => true,
				'preload'  => false,
				'src'      => true,
			),
			'iframe'     => array(
				'src'               => true,
				'srcdoc'            => true,
				'frameborder'       => true,
				'allowfullscreen'   => true,
				'allowtransparency' => true,
				'referrerpolicy'    => true,
				'sandbox'           => true,
			),
		);

		$allowed_html = array_map(
			function ( $value ) {
				$global_attributes = array(
					'class' => true,
					'id'    => true,
					'style' => false,
					'title' => true,
					'role'  => true,
				);

				if ( $value === true ) {
					$value = array();
				}

				if ( is_array( $value ) ) {
					return array_merge( $value, $global_attributes );
				}

				return $value;
			},
			$allowed_html
		);

		return apply_filters( 'amp_kses_allowed_html', $allowed_html );
	}
}

if ( ! function_exists( 'amp_get_element_regexp_pattern' ) ) {
	function amp_get_element_regexp_pattern( $type = null ) {
		$type = ( $type !== null ) ? $type : '\S+';
		$type = preg_quote( $type, '@' );

		return <<<REGEXP
@                                                     # Element (group: 0)
    <(?<type>{$type})                                 # Element Type (group: 1)

    (                                                 # Attributes (group: 2)
        (?:
            \s+
            (?:\S+)                                   # Attribute name
            =
            ["']?                                     # Open quote
                (?:                                   # Attribute Value
                    (?:.
                        (?!["']?\s+(?:\S+)=|[>"']|/>)
                    )+.
                )
            ["']?                                     # Close quote
        )*
    )

    (                                                 # Rest characters (group: 3)
        [^/>]*/>                                      # Self-closing tag
        |
        [^>]*>(?!
            (?:[\s\S]*?)
            (?:</\k<type>>)
        )
        |
        [^>]*>
        ([\s\S]*?)                                    # Content. (group: 4)
        (</\k<type>>)                                 # Close tag. (group: 5)
    )
@xi
REGEXP;
	}
}

if ( ! function_exists( 'amp_replace_element' ) ) {
	function amp_replace_element( $replacer, $html, $type = null ) {
		$pattern = amp_get_element_regexp_pattern( $type );

		return preg_replace_callback( $pattern, $replacer, $html );
	}
}

if ( ! function_exists( 'amp_element_type_replacer' ) ) {
	function amp_element_type_replacer( $type, $replacement_type, $self_closing_to_close_tag, $matches ) {
		$element             = $matches[0];
		$is_self_closing_tag = ! isset( $matches[5] );

		$element = preg_replace( '!\A<' . preg_quote( $type, '!' ) . '!i', '<' . $replacement_type, $element );

		if ( ! $is_self_closing_tag ) {
			return preg_replace(
				'!</' . preg_quote( $type, '!' ) . '>\z!i',
				'</' . $replacement_type . '>',
				$element
			);
		}

		if ( $self_closing_to_close_tag ) {
			$element = preg_replace( '!\s*/>\z!i', '></' . $replacement_type . '>', $element );
		}

		return $element;
	}
}

if ( ! function_exists( 'amp_replace_element_type' ) ) {
	function amp_replace_element_type( $type, $replacement_type, $html, $self_closing_to_close_tag = false ) {
		return amp_replace_element(
			function ( $matches ) use ( $type, $replacement_type, $self_closing_to_close_tag ) {
				return amp_element_type_replacer( $type, $replacement_type, $self_closing_to_close_tag, $matches );
			},
			$html,
			$type
		);
	}
}

if ( ! function_exists( 'amp_replace_text' ) ) {
	function amp_replace_text( $replacer, $html ) {
		return preg_replace_callback(
			'@(<[^>]*(?:>|$))|(.+?(?=<[^>]*(?:>|$)))|(.+(?!<[^>]*(?:>|$)))@i',
			function ( $matches ) use ( $replacer ) {
				$node      = $matches[0];
				$maybe_tag = ( strpos( $node, '<' ) === 0 && strpos( $node, '>' ) === strlen( $node ) - 1 );

				if ( $maybe_tag ) {
					return $node;
				}

				return call_user_func( $replacer, $node );
			},
			$html
		);
	}
}

if ( ! function_exists( 'amp_strip_shortcodes' ) ) {
	function amp_strip_shortcodes( $html ) {
		static $cache = [];

		$removed_shortcodes = amp_removed_shortcodes();

		if ( false === strpos( $html, '[' ) ) {
			return $html;
		}

		if ( empty( $removed_shortcodes ) || ! is_array( $removed_shortcodes ) ) {
			return $html;
		}

		preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $html, $matches );

		$tagnames = array_intersect( array_keys( $removed_shortcodes ), $matches[1] );

		if ( empty( $tagnames ) ) {
			return $html;
		}

		$cacheKey = hash( 'sha256', serialize( array( $html, $tagnames ) ) );

		if ( isset( $cache[ $cacheKey ] ) ) {
			return $cache[ $cacheKey ];
		}

		$html = do_shortcodes_in_html_tags( $html, true, $tagnames );

		$pattern = get_shortcode_regex( $tagnames );
		$html    = preg_replace_callback( '/' . $pattern . '/', 'strip_shortcode_tag', $html );

		$html = unescape_invalid_shortcodes( $html );
		$html = strip_shortcodes( $html );

		$cache[ $cacheKey ] = $html;

		return $html;
	}
}

if ( ! function_exists( 'amp_kses' ) ) {
	function amp_kses( $html ) {
		return wp_kses( $html, amp_get_kses_allowed_html() );
	}
}

if ( ! function_exists( 'amp_ampify_img' ) ) {
	function amp_ampify_img( $html ) {
		return amp_replace_element(
			function ( $matches ) {
				$element = amp_element_type_replacer( 'img', 'amp-img', true, $matches );
				$element = amp_replace_element(
					function ( $matches_2 ) {
						return '<' . $matches_2[1] . $matches_2[2] . ' layout="responsive"' . $matches_2[3];
					},
					$element,
					'amp-img'
				);

				return $element;
			},
			$html,
			'img'
		);
	}
}

if ( ! function_exists( 'amp_get_youtube_url_regexp_pattern' ) ) {
	function amp_get_youtube_url_regexp_pattern() {
		return '(?:https?:)?//(?:(?:[^.]+.)?youtube\.com/embed|youtu\.be)/([-A-Za-z0-9_]+)';
	}
}

if ( ! function_exists( 'amp_ampify_embeded_youtube' ) ) {
	function amp_ampify_embeded_youtube( $html ) {
		return amp_replace_text(
			function ( $text ) {
				return preg_replace(
					'@' . amp_get_youtube_url_regexp_pattern() . '@i',
					'<amp-youtube width="560" height="315" data-videoid="\1" layout="responsive"></amp-youtube>',
					$text
				);
			},
			$html
		);
	}
}

if ( ! function_exists( 'amp_ampify_iframe_youtube' ) ) {
	function amp_ampify_iframe_youtube( $html ) {
		return amp_replace_element(
			function ( $matches ) {
				$element       = $matches[0];
				$attributes    = $matches[2];
				$url_pattern   = amp_get_youtube_url_regexp_pattern();
				$src_pattern   = '@\A(.*?)\s+src[^=]*=[^"\']*["\']' . $url_pattern . '["\'](.*?)\z@i';
				$maybe_youtube = preg_match( $src_pattern, $attributes, $attr_matches );

				if ( ! $maybe_youtube ) {
					return $element;
				}

				$element = amp_element_type_replacer( 'iframe', 'amp-youtube', false, $matches );
				$element = amp_replace_element(
					function ( $matches_2 ) use ( $src_pattern ) {
						$attributes = $matches_2[2];
						$attributes = preg_replace(
							$src_pattern,
							' width="560" height="315" data-videoid="\2" layout="responsive"',
							$attributes
						);

						return '<' . $matches_2[1] . $attributes . $matches_2[3];
					},
					$element,
					'amp-youtube'
				);

				return $element;
			},
			$html,
			'iframe'
		);
	}
}

if ( ! function_exists( 'amp_ampify_iframe' ) ) {
	function amp_ampify_iframe( $html ) {
		return amp_replace_element(
			function ( $matches ) {
				$element = amp_element_type_replacer( 'iframe', 'amp-iframe', false, $matches );
				$element = amp_replace_element(
					function ( $matches_2 ) {
						return '<' . $matches_2[1] . $matches_2[2] . ' layout="responsive"' . $matches_2[3];
					},
					$element,
					'amp-iframe'
				);

				return $element;
			},
			$html,
			'iframe'
		);
	}
}

if ( ! function_exists( 'amp_ampify_video' ) ) {
	function amp_ampify_video( $html ) {
		return amp_replace_element(
			function ( $matches ) {
				$element = amp_element_type_replacer( 'video', 'amp-video', false, $matches );
				$element = amp_replace_element(
					function ( $matches_2 ) {
						return '<' . $matches_2[1] . $matches_2[2] . ' layout="responsive"' . $matches_2[3];
					},
					$element,
					'amp-video'
				);

				return $element;
			},
			$html,
			'video'
		);
	}
}

if ( ! function_exists( 'amp_ampify_audio' ) ) {
	function amp_ampify_audio( $html ) {
		return amp_replace_element_type( 'audio', 'amp-audio', $html );
	}
}

if ( ! function_exists( 'amp_ampify_html' ) ) {
	function amp_ampify_html( $html ) {
		$ampifiers = apply_filters(
			'amp_ampifiers',
			array(
				'amp_kses',
				'do_shortcode',
				'amp_strip_shortcodes',
				'amp_ampify_img',
				'amp_ampify_embeded_youtube',
				'amp_ampify_iframe_youtube',
				'amp_ampify_iframe',
				'amp_ampify_video',
				'amp_ampify_audio',
			)
		);

		$ampified_html = $html;

		foreach ( $ampifiers as $ampifier ) {
			if ( is_callable( $ampifier ) ) {
				$ampified_html = call_user_func( $ampifier, $ampified_html );
			}
		}

		return $ampified_html;
	}
}

if ( ! function_exists( 'amp_ampify_renderer' ) ) {
	function amp_ampify_renderer( $callable ) {
		return function () use ( $callable ) {
			return amp_ampify_html( call_user_func_array( $callable, func_get_args() ) );
		};
	}
}

if ( ! function_exists( 'amp_ampify_displayer' ) ) {
	function amp_ampify_displayer( $callable ) {
		return function () use ( $callable ) {
			ob_start();

			call_user_func_array( $callable, func_get_args() );

			echo amp_ampify_html( ob_get_clean() );
		};
	}
}

if ( ! function_exists( 'amp_initialize_filters' ) ) {
	function amp_initialize_filters() {
		$disabled_filters = apply_filters(
			'amp_initialized_filters',
			array(
				'the_content',
			)
		);

		foreach ( $disabled_filters as $tag ) {
			remove_all_filters( $tag );
		}

		require ABSPATH . WPINC . '/default-filters.php';

		if ( is_multisite() ) {
			require ABSPATH . WPINC . '/ms-default-filters.php';
		}

		remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
		remove_filter( 'the_content', 'do_shortcode', 11 );

		$use_default_title = trim( get_option( 'st-data95', '' ) );

		if ( $use_default_title === '' ) {
			remove_filter( 'wp_title', 'wptexturize' );
			remove_filter( 'the_title', 'wptexturize' );
		}

		add_filter(
			'the_content',
			function ( $content ) {
				return apply_filters( 'amp_the_content', $content );
			},
			PHP_INT_MAX
		);

		add_filter( 'wp_kses_allowed_html', 'amp_get_kses_allowed_html' );

		add_action( 'dynamic_sidebar_before', function () {
			ob_start();
		}, ~PHP_INT_MAX );

		add_action( 'dynamic_sidebar_after', function () {
			$content = ob_get_clean();

			echo amp_ampify_html( $content );
		}, PHP_INT_MAX );

		if ( $use_default_title === '' ) {
			add_action( 'amp_wp_head', 'st_render_title_tag_wrapper', 1 );
		} else {
			add_action( 'amp_wp_head', '_wp_render_title_tag', 1 );
		}

		add_action( 'amp_wp_head', 'amp_output_canonical' );
		add_filter( 'amp_the_content', 'amp_ampify_html', PHP_INT_MAX );
	}
}

if ( ! function_exists( 'amp_remove_target_blank' ) ) {
	function amp_remove_target_blank( $the_content ) {
		$cache_key = 'st_amp_remove_target_blank_' . hash( 'sha256', serialize( func_get_args() ) );
		$cache     = wp_cache_get( $cache_key );

		if ( $cache !== false ) {
			return $cache;
		}

		if ( isset( $GLOBALS['stdata467'] ) && $GLOBALS['stdata467'] === 'yes' ) {
			$the_content = _st_remove_target_attr( $the_content );
		} else {
			// AMP allows only `_blank`.
			$the_content = _st_remove_target_attr( $the_content, array( '_blank' ), 'none' );
		}

		wp_cache_set( $cache_key, $the_content );

		return $the_content;
	}
}

add_filter( 'amp_the_content', 'amp_remove_target_blank', PHP_INT_MAX );

if ( isset( $GLOBALS['stdata8'] ) && $GLOBALS['stdata8'] === 'yes' ) {
	add_filter( 'amp_the_content', 'st_noopener_noreferrer_remove', PHP_INT_MAX );
}

if ( ! function_exists( 'amp_wp_head' ) ) {
	function amp_wp_head() {
		do_action( 'amp_wp_head' );
	}
}

if ( ! function_exists( 'amp_wp_footer' ) ) {
	function amp_wp_footer() {
		do_action( 'amp_wp_footer' );
	}
}

if ( ! function_exists( 'amp_custom_style' ) ) {
	function amp_custom_style() {
		include locate_template('st-amp-css.php', false, false);

		$child_style = get_stylesheet_directory() . '/style-amp.css';

		if ( is_readable( $child_style ) ) {
			include $child_style;
		}
	}
}

if ( ! function_exists( 'amp_get_template_part' ) ) {
	function amp_get_template_part( $slug, $name = null ) {
		if ( ! amp_is_amp() ) {
			get_template_part( $slug, $name );

			return;
		}

		if ( $name === 'amp' && locate_template( array( $slug . '-amp.php' ), false, false ) !== '' ) {
			get_template_part( $slug, $name );

			return;
		}

		do_action( 'get_template_part_' . $slug, $slug, $name );
		do_action( 'amp_get_template_part_' . $slug, $slug, $name );

		$templates = array();
		$name      = (string) $name;

		if ( $name !== '' ) {
			$templates[] = $slug . '-' . $name . '.php';
		}

		$templates[] = $slug . '.php';

		$ampified_locate_template = amp_ampify_displayer( 'locate_template' );

		call_user_func( $ampified_locate_template, $templates, true, false );
	}
}

if ( ! function_exists( 'amp_get_image_size' ) ) {
	function amp_get_image_size( $attachment, $size ) {
		if ( is_int( $attachment ) ) {
			$attachment_id = (int) $attachment;
		} else {
			$wpdb = $GLOBALS['wpdb'];

			$cols = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment ) );

			if ( count( $cols ) === 0 ) {
				return null;
			}

			$attachment_id = $cols[0];
		}

		$image = wp_get_attachment_image_src( $attachment_id, $size );

		if ( $image === false ) {
			return null;
		}

		return array(
			absint( $image[1] ),
			absint( $image[2] ),
		);
	}
}

if ( ! function_exists( 'amp_image_size' ) ) {
	function amp_image_size( $attachment, $size ) {
		$size = amp_get_image_size( $attachment, $size );

		if ( $size === null ) {
			return;
		}

		list( $width, $height ) = $size;

		echo ' width="' . $width . '" height="' . $height . '"';
	}
}

if ( ! function_exists( 'amp_output_canonical' ) ) {
	function amp_output_canonical() {
		remove_filter( 'post_link', 'amp_post_link', PHP_INT_MAX );

		$url_attr = esc_url( wp_get_canonical_url() );

		add_filter( 'post_link', 'amp_post_link', PHP_INT_MAX, 3 );

		echo <<<HTML
<link rel="canonical" href="{$url_attr}">
HTML;
	}
}

if ( ! function_exists( 'amp_post_link' ) ) {
	function amp_post_link( $permalink, $post, $leavename ) {
		if ( ! amp_is_amp() || ! amp_is_supported( $post ) ) {
			return $permalink;
		}

		if ( get_option( 'permalink_structure' ) !== '' ) {
			$permalink = trailingslashit( $permalink ) . user_trailingslashit( amp_get_query_var(), 'single_amp' );
		} else {
			$permalink = add_query_arg( amp_get_query_var(), 1, $permalink );
		}

		return $permalink;
	}
}
add_filter( 'post_link', 'amp_post_link', PHP_INT_MAX, 3 );

if ( ! function_exists( 'amp_get_allowed_shortcode_tags' ) ) {
	function amp_get_allowed_shortcode_tags() {
		return apply_filters(
			'st_amp_get_allowed_shortcode_tags',
			array(
				'audio',
				'video',
				'pc',
				'nopc',
				'postonly',
				'catonly',
				'下矢印',
				'star5',
				'star45',
				'star4',
				'star35',
				'star3',
				'star2',
				'star1',
				'tp',
				'st-card',
				'cft',
				'st-maru',
				'st-x',
				'login-only',
				'st-catgroup', 
				'st-postgroup',
				'st-osusume',
				'st-count-reset',
			)
		);
	}
}

if ( ! function_exists( 'amp_removed_shortcodes' ) ) {
	function amp_removed_shortcodes( $tag = null ) {
		static $tags = array();

		if ( $tag !== null ) {
			$tags[ $tag ] = true;
		}

		return $tags;
	}
}

if ( ! function_exists( 'amp_initialize_shortcodes' ) ) {
	function amp_initialize_shortcodes() {
		$shortcode_tags = $GLOBALS['shortcode_tags'];
		$allowed_tags   = amp_get_allowed_shortcode_tags();

		foreach ( $shortcode_tags as $tag => $callable ) {
			$ampified_function = apply_filters(
				'st_amp_ampified_shortcode_functions',
				'amp_shortcode_' . preg_replace( '/[^a-z0-9_]/', '_', strtolower( $tag ) ),
				$tag,
				$callable
			);

			if ( is_callable( $ampified_function ) ) {
				remove_shortcode( $tag );
				add_shortcode( $tag, $ampified_function );

				continue;
			}

			if ( ! in_array( $tag, $allowed_tags, true ) ) {
				remove_shortcode( $tag );
				amp_removed_shortcodes( $tag );
			}
		}
	}
}

if ( ! function_exists( 'amp_shortcode_caption' ) ) {
	function amp_shortcode_caption( $atts, $content = '' ) {
		$result = img_caption_shortcode( $atts, $content );

		return amp_ampify_html( $result );
	}
}

if ( ! function_exists( 'amp_shortcode_youtube' ) ) {
	function amp_shortcode_youtube( $atts, $content = '' ) {
		$atts = shortcode_atts( array( 'id' => '', ), $atts );

		$id_attr = esc_attr( $atts['id'] );

		$result = <<<HTML
<amp-youtube width="560" height="315" data-videoid="{$id_attr}" layout="responsive"></amp-youtube>
HTML;

		return $result;
	}
}

if ( ! function_exists( 'amp_shortcode_st_amp_ad' ) ) {
	function amp_shortcode_st_amp_ad( $atts, $content = '' ) {
		if ( ! amp_is_amp() ) {
			return '';
		}

		ob_start();
		get_template_part( 'st-ad', 'amp' );

		return ob_get_clean();
	}
}
add_shortcode( 'st-amp-ad', 'amp_shortcode_st_amp_ad' );

if ( ! function_exists( 'amp_shortcode_adsense' ) ) {
	function amp_shortcode_adsense( $atts, $content = '' ) {
		return amp_shortcode_st_amp_ad( $atts, $content );
	}
}

if ( ! function_exists( 'amp_shortcode_st_card' ) ) {

	function amp_shortcode_st_card( $arg, $content = '' ) {
		$globals = array();
		$globals = _st_store_global_query( $globals );

		$atts = shortcode_atts(
			array(
				'id'       => '0',
				'label'    => '',
				'name'     => '',
				'bgcolor'  => '#ff0000',
				'color'    => '#ffffff',
				'readmore' => 'off',
				'fontawesome'  => '',
			),
			$arg
		);

		$atts = array_map( 'trim', $atts );

		$post_id    = (int) $atts['id'];
		$post_query = new WP_Query( array(
			'p'              => $post_id,
			'post_type'      => 'any',
			'posts_per_page' => 1,
		) );

		if ( ! $post_query->have_posts() ) {
			_st_restore_global_query( $globals );

			return '';
		}

		$card_label = $atts['label'];
		$card_name  = $atts['name'];
		$readmore   = ( $atts['readmore'] === 'on' );
		$fontawesome_html = ( $atts['fontawesome'] !== '' ) ? '<i class="fa ' . esc_attr( $atts['fontawesome'] ) . '" aria-hidden="true"></i> ' : '';

		$wpp_view_limit = trim( get_option( 'st-data223', '' ) );
		$wpp_view_limit = ( $wpp_view_limit !== '' ) ? (int) $wpp_view_limit : 9999;

		$wpp_view_limit_label = trim( get_option( 'st-data224', '' ) );
		$wpp_view_limit_label = ( $wpp_view_limit_label !== '' ) ? $wpp_view_limit_label : '殿堂';

		$show_wpp_view_count = (bool) trim( get_option( 'st-data229', '' ) );
		$default_thumbnail   = trim( get_option( 'st-data97', '' ) );
		$hide_excerpt_on_pc  = (bool) trim( get_option( 'st-data221', '' ) );

		$html = '';

		while ( $post_query->have_posts() ) {
			$post_query->the_post();

			ob_start();

			?>
			<div class="kanren st-cardbox">
				<?php if ( $card_label !== '' || $fontawesome_html !== '' ): //ラベルを挿入 ?>
					<div class="st-cardbox-label"><span class="st-cardbox-label-text"><?php echo $fontawesome_html; ?><?php echo esc_html( $card_label ); ?></span></div>
				<?php elseif ( $show_wpp_view_count && function_exists( 'wpp_get_views' ) ): ?>
					<?php $wpp_view_count = max( 0, (int) wpp_get_views( get_the_ID(), null, false ) ); // 計測数 ?>
					<?php if ( $wpp_view_count > $wpp_view_limit ): ?>
						<div class="st-cardbox-label st-wppview-limit-over"><span class="st-cardbox-label-text"><?php echo esc_html( $wpp_view_limit_label ); ?></span></div>
					<?php else: ?>
						<div class="st-cardbox-label"><span class="st-cardbox-label-text"><?php echo esc_html( number_format_i18n( $wpp_view_count ) );?><span class="wpp-text">view</span></span></div>
					<?php endif; ?>
				<?php endif; ?>
				<dl class="clearfix">
					<dt class="st-card-img"><a href="<?php the_permalink() ?>">
							<?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
								<?php the_post_thumbnail( array( 100, 100 ) ); ?>
							<?php else: // サムネイルを持っていないときの処理 ?>
								<?php if ( $default_thumbnail !== '' ): ?>
									<img src="<?php echo esc_url( $default_thumbnail ); ?>" alt="no image" title="no image" width="100" height="100" />
								<?php else: ?>
									<img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
								<?php endif; ?>
							<?php endif; ?>
						</a></dt>
					<dd>
						<?php if (  $card_name !== '' ): //タイトルを変更 ?>
							<h5 class="st-cardbox-t"><a href="<?php the_permalink(); ?>"><?php echo esc_html( $card_name ); ?></a></h5>
						<?php else: ?>
							<h5 class="st-cardbox-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<?php endif; ?>

						<?php if ( ! $hide_excerpt_on_pc && ! st_is_mobile() ): ?>
							<div class="smanone">
								<?php the_excerpt(); //抜粋文 ?>
							</div>
						<?php endif; ?>

						<?php if ( $readmore ): ?>
							<p class="cardbox-more"><a href="<?php the_permalink(); ?>">続きを見る</a></p>
						<?php endif; ?>
					</dd>
				</dl>
			</div>
			<?php

			$html = ob_get_clean();
		}

		wp_reset_postdata();

		_st_restore_global_query( $globals );

		return $html;
	}
}

if ( !function_exists( 'amp_shortcode_st_label' ) ) {
	function amp_shortcode_st_label( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'label'    => 'おすすめ',
			'bgcolor' => '#fafafa',
			'color'   => '#000000',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$text_html = ( $label !== '' ) ? $label : '注目'; //ラベルテキスト

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="kanren st-labelbox"><div class="st-labelbox-label"><span class="st-labelbox-label-text">' . esc_html( $text_html ) . '</span></div>' . $content . '</div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_minihukidashi' ) ) {
	function amp_shortcode_st_minihukidashi( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-minihukidashi"><span></span>' . $fontawesome_html . $content . '</p>';
	}
}

if ( !function_exists( 'amp_shortcode_st_marumozi' ) ) {
	function amp_shortcode_st_marumozi( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
		), $atts );
	
		extract( array_map( 'trim', $atts ), EXTR_SKIP );
	
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
	
		return '<span class="st-marumozi">' . $fontawesome_html . $content . '</span>';
	}
}


if ( !function_exists( 'amp_shortcode_st_marumozi_big' ) ) {
	function amp_shortcode_st_marumozi_big( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
		), $atts );
	
		extract( array_map( 'trim', $atts ), EXTR_SKIP );
	
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
	
		return '<span class="st-marumozi-big">' . $fontawesome_html . $content . '</span>';
	}
}

if ( !function_exists( 'amp_shortcode_st_cmemo' ) ) {
	function amp_shortcode_st_cmemo( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'fontawesome' => 'fa-file-text-o',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );
		
		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . '" aria-hidden="true"></i>' : ''; //Webアイコン
		
		return '<div class="clip-memobox"><div class="clip-fonticon">' . $fontawesome_html . '</div><div class="clip-memotext"><p>'.$content.'</p></div></div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_itembox' ) ) {

	function amp_shortcode_st_itembox( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'link' => '#',
			'target' => '_blank',
			'rel' => 'nofollow',
			'img' => '',
			'title' => '',
			'price' => '',
            'star' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );
        
        $noimg = get_template_directory_uri().'/images/no-img.png';
				
		if ( $star !== '' ){
			if ( $star === '5' ){
            	$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
			}elseif ( $star === '4' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '3' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '2' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '1' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}else{
			$star_mark = '';			
		}
        
		$link_url = ( $link !== '' ) ? esc_html($link) : '#'; //リンク先
		$target_attr     = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$rel_attr        = ( $rel !== '' ) ? 'rel="nofollow' : ''; //nofollow
		$img_url    = ( $img !== '' ) ? esc_url( $img ) : $noimg; //画像URL
		$title_html       = ( $title !== '' ) ? '<h5 class="st-cardbox-t">' . esc_html($title) . '</h5>' : ''; //タイトル
		$price_html        = ( $price !== '' ) ? '<p class="itembox-price">価格' . esc_html($price) . '円</p>' : ''; //料金
		$star_html        = ( $star_mark !== '' ) ? '<span class="itembox-star st-star">'.$star_mark.'</span><br/>' : ''; //スター

		$imagesize = getimagesize($img_url);
		if($imagesize){
    		$width = $imagesize[0];  // width
    		$height = $imagesize[1];  //height
		}

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		
		return '<a href="'.$link_url.'" class="itembox-link"><div class="kanren st-cardbox st-itmebox"><dl class="clearfix"><dt><img src="' . $img_url . '" width="'.$width.'" height="'.$height.'" /></dt><dd>' . $title_html . '<div class="itembox-guide"><p>'.$star_html.$content.'</p>'.$price_html.'</div></dd></dl></div></a>';
	}

}

if ( !function_exists( 'amp_shortcode_st_button' ) ) {
	function amp_shortcode_st_button( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
			'title'       => 'ボタン',
			'type'        => 'A',
			'rel'         => '',
			'url'         => '#',
			'target'      => '_blank',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン';
		$type         = ( $type !== '' ) ? $type : 'A';
		$url          = ( $url !== '' ) ? $url : '#';
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : '';
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : '';

		if ( trim( $fontawesome ) !== '' ) {
			$fontawesome_html = '<i class="fa  ' . esc_attr( $fontawesome ) . '" aria-hidden="true"></i>';
		} else {
			$fontawesome_html = '';
		} //Webアイコン

		if ( $type === 'A' ) { //タイプ
			return '<div class="rankstlink-r2"><p><a href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . '</a></p></div>';
		} else {
			return '<div class="rankstlink-l2"><p><a href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . '</a></p></div>';
		}
	}
}

if ( !function_exists( 'amp_shortcode_st_mybutton' ) ) {
	function amp_shortcode_st_mybutton( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
			'title'       => 'ボタン',
			'rel'         => '',
			'url'         => '#',
			'target'      => '',
			'fontawesome'  => 'fa-check-circle',
			'fontawesome_after'  => '',
			'class'       => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン'; //テキスト
		$url          = ( $url !== '' ) ? $url : '#'; //URL
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : ''; //nofollow
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$fontawesome_after_html = ( $fontawesome_after !== '' ) ? '<i class="fa fa-after ' . esc_attr( $fontawesome_after ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン（後）
		$class_attr  = ( $class !== '' ) ? $class : ''; //class

		return '<p class="'. $class_attr . ' st-mybtn"><a href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . $fontawesome_after_html .'</a></p>';

	}
}

if ( !function_exists( 'amp_shortcode_st_mybutton_mini' ) ) {
	function amp_shortcode_st_mybutton_mini( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => '',
			'title'       => 'ボタン',
			'rel'         => '',
			'url'         => '#',
			'target'      => '',
			'fontawesome'  => 'fa-check-circle',
			'fontawesome_after'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン'; //テキスト
		$url          = ( $url !== '' ) ? $url : '#'; //URL
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : ''; //nofollow
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$fontawesome_after_html = ( $fontawesome_after !== '' ) ? '<i class="fa fa-after ' . esc_attr( $fontawesome_after ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン（後）

		return '<p class="st-mybtn"><a href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . $fontawesome_after_html .'</a></p>';

	}
}

if ( !function_exists( 'amp_shortcode_st_mybox' ) ) {
	function amp_shortcode_st_mybox( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'fontawesome' => 'fa-check-circle',
			'title'       => 'ポイント',
			'title_bordercolor' => '',
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontawesome_css = $fontawesome !== '' ? '<i class="fa  ' . esc_attr($fontawesome) . '" aria-hidden="true"></i>' : ''; //Webアイコン
		$myclass_class  = ( $myclass !== '' ) ? $myclass : '';

		$titlebox    = '';
		$title_class = '';

		if ( $title !== '' ) {
			$title_class = ' has-title';
			$titlebox = '<p class="st-mybox-title">' . $fontawesome_css . $title . '</p>';
		}

		if ( $title_bordercolor ){
			$myclass_class .=  ' st-title-border';
		}else{
			$title_bordercolor_css  = '';
		}

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		
		return '<div class="st-mybox ' . esc_attr ( $title_class . $myclass_class ) . '">' . $titlebox . '<div class="st-in-mybox">' . $content . '</div></div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_midasibox' ) ) {
	function amp_shortcode_st_midasibox( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => 'fa-file-text-o',
			'title'       => '見出し（全角15文字）',
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontawesome_css = $fontawesome !== '' ? '<i class="fa  ' . esc_attr( $fontawesome ) . '" aria-hidden="true"></i>' : '';
		$title_class     = '';
		$title_class = $title !== '' ? 'has-title ' : '';
		$myclass_class  = ( $myclass !== '' ) ? $myclass : '';
		
		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="freebox ' . $title_class . $myclass_class . '">' .
		       '<p class="p-free"><span class="p-entry-f">' . $fontawesome_css . $title . '</span></p>' .
		       '<div class="free-inbox">' . $content . '</div>' .
		       '</div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_midasibox_intitle' ) ) {
	function amp_shortcode_st_midasibox_intitle( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome' => 'fa-file-text-o',
			'title'       => '見出し（全角15文字）',
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$fontawesome_css = $fontawesome !== '' ? '<i class="fa  ' . esc_attr( $fontawesome ) . '" aria-hidden="true"></i>' : ''; //Webアイコン
		$title_class     = '';
		$title_class = $title !== '' ?  'has-title ' : '';
		$myclass_class  = ( $myclass !== '' ) ? $myclass : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		
		return '<div class="freebox freebox-intitle ' . $title_class . $myclass_class . '">' .
		       '<p class="p-free"><span class="p-entry-f">' . $fontawesome_css . $title . '</span></p>' .
		       '<div class="free-inbox">' . $content . '</div>' .
		       '</div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_flexbox' ) ) {
	function amp_shortcode_st_flexbox( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'url'             => '',
        	'title' => '',
			'fontawesome' => '',
			'target' => '',
			'rel' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$target_attr     = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$rel_attr        = ( $rel !== '' ) ? 'rel="nofollow"' : ''; //nofollow
        
		if ( trim( $fontawesome ) !== '' ) { //Webアイコン
			$fontawesome_html = '<i class="fa  ' . esc_attr( $fontawesome ) . '" aria-hidden="true"></i>';
		} else {
			$fontawesome_html = '';
		}
		
		if ( trim( $url ) !== '' ) { //link
			$url_front_html = '<a href="' . esc_url($url) . '" class="st-flexbox-link" ' . $rel_attr . $target_attr . '>';
			$url_back_html  = '</a>';
		} else {
			$url_front_html = '';
			$url_back_html  = '';
		}	
		
        $title_html        = ( $title !== '' ) ? '<p class="st-header-flextitle">' . $fontawesome_html . $title . '</p>' : ''; //テキスト

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );    
        
		return $url_front_html . '<div class="st-header-flexwrap"><div class="st-header-flexbox">' . $title_html . $content . '</div></div>'. $url_back_html;
	}
}

if ( !function_exists( 'amp_shortcode_st_under_t' ) ) {
	function amp_shortcode_st_under_t(  ) {
		return '<div class="st-triangle-down"></div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_step' ) ) {
	function amp_shortcode_st_step( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'step_no'            => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$step_no_html = ( $step_no !== '' ) ? $step_no : '1'; //ステップ数

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-step-title">step.'. $step_no_html .' ' . $content . '</p>';
	}
}

if ( !function_exists( 'amp_shortcode_st_point' ) ) {
	function amp_shortcode_st_point( $atts, $content = null ) {
		return '<p class="st-point"><span class="st-point-text">' . $content . '</span></p>';
	}
}


if ( !function_exists( 'amp_shortcode_st_rank' ) ) {

	function amp_shortcode_st_rank( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'rankno'    => '',
			'star' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$rankno_int   = ( $rankno !== '' ) ? (int) $rankno : ''; //id
		
		if ( $star !== '' ){
			if ( $star === '5' ){
            	$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
			}elseif ( $star === '4' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '3' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '2' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '1' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}else{
			$star_mark = '';			
		}

		$star_html = ( $star_mark !== '' ) ? '<br/><span class="st-star">'.$star_mark.'</span>' : ''; //スター

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="rankid' . $rankno_int . '"><h4 class="rankh4 rankh4-sc">' . $content . $star_html . '</h4></div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_mcbutton' ) ) {
	/**
	 * MCボタンショートコード
	 */
	function amp_shortcode_st_mcbutton( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'fontawesome'        => '',
			'title'              => 'ボタン',
			'rel'                => '',
			'url'                => '#',
			'target'             => '',
			'fontawesome'        => 'fa-check-circle',
			'fontawesome_after'  => '',
			'width'              => '',
			'ref'                =>  '',

			'mcbox_title'           =>  '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$title        = ( $title !== '' ) ? $title : 'ボタン'; //テキスト
		$url          = ( $url !== '' ) ? $url : '#'; //URL
		$nofollow_set = ( $rel !== '' ) ? ' rel="nofollow"' : ''; //nofollow
		$target_set   = ( $target !== '' ) ? ' target="_blank"' : ''; //ターゲット
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン
		$fontawesome_after_html = ( $fontawesome_after !== '' ) ? '<i class="fa fa-after ' . esc_attr( $fontawesome_after ) . ' st-css-no" aria-hidden="true"></i>' : ''; //Webアイコン（後）
		$width_class  = ( $width === '' ) ? ' st-btn-default' : ''; //幅のクラス
		$rel_class  = ( $ref !== '' ) ? ' st-reflection' : ''; //光る演出
		$mcbox_title        = ( $mcbox_title !== '' ) ? $mcbox_title : '';
		$mcbox_title_html       = ( $mcbox_title !== '' ) ? '<p class="st-mcbox-title center huto">' . $mcbox_title . '</p>' : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="st-mcbtn-box">' . $mcbox_title_html . '<p class="st-mybtn' . $rel_class .  $width_class .'"><a href="' . esc_url( $url ) . '"' . $nofollow_set . $target_set . '>' . $fontawesome_html . esc_html( $title ) . $fontawesome_after_html .'</a></p><p class="st-mcbox-text center komozi">' . $content . '</p></div>';

	}
}

if ( !function_exists( 'amp_shortcode_st_input_tab' ) ) {
	/**
	 * input-tabショートコード
	 * [st-input-tab text="タブ" bgcolor="#fff" color="#1a1a1a" fontweight="" width="30" value="0" checked=""]
	 */
	function amp_shortcode_st_input_tab( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'text' => 'タブ',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$text_attr        = ( $text !== '' ) ? $text : '';

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '';
	}
}

if ( !function_exists( 'amp_shortcode_st_tab_content' ) ) {
	/**
	 * タブコンテンツショートコード
	 * [st-tab-content]
	 */
	function amp_shortcode_st_tab_content( $atts, $content = null ) {
		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );
		return '<div id="st-tab-content">' . $content . '</div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_tab_main' ) ) {
	/**
	 * タブ内コンテンツショートコード
	 * [st-tab-main bgcolor="" bordercolor="" value=""]
	 */
	function amp_shortcode_st_tab_main( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'value'            => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$value_attr = ( $value !== '' ) ? intval($value) : ''; //コンテンツナンバー

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div id="st-tab-main'. $value_attr .'" class="st-tab-main">' . $content . '</div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_user_comment_box' ) ) {
	function amp_shortcode_st_user_comment_box( $atts, $content = null ) {
		$atts = shortcode_atts( array(
        	'title'           => '',
            'user_text'           => '',
            'star' => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

        $title_html   = ( $title !== '' ) ? $title : ''; //タイトル
        $user_text_html   = ( $user_text !== '' ) ? $user_text : ''; //ユーザー属性

		if ( $star !== '' ){
			if ( $star === '5' ){
            	$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
			}elseif ( $star === '4' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '3' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '2' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}elseif ( $star === '1' ) {
				$star_mark = '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}else{
			$star_mark = '';			
		}

		$star_html = ( $star_mark !== '' ) ? '<span class="st-star">'.$star_mark.'</span>' : ''; //スター

		// 余分な <p> を削除
		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );    
        
		return '<div class="st-user-comment-box">
<div class="st-user-comment-img">' . $content . '</div><div class="st-user-comment-text"><h6>' . esc_html($title_html) . '</h6><p class="komozi st-user-comment-attribute">' . esc_html($user_text_html) .  $star_html .'</p>
</div>
</div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_slidebox' ) ) {
	function amp_shortcode_st_slidebox( $atts, $content = null ) {

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="st-slidebox-c"><div class="st-slidebox">' . $content . '</div></div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_designfont' ) ) {
	function amp_shortcode_st_designfont( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'webfont'  => '',
			'fontawesome'  => '',
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$webfont_class  = ( $webfont !== '' ) ? 'st-web-font ' : ''; //webfontを適応するクラス
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' aria-hidden="true"></i>' : ''; //Webアイコン
		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<p class="st-designfont '. esc_attr( $webfont_class . $myclass_class ) .'">' . $fontawesome_html  . $content . '</p>';
	}
}

if ( !function_exists( 'amp_shortcode_st_comment_out' ) ) {
	function amp_shortcode_st_comment_out( $atts, $content = null ) {
		return null;
	}
}

if ( !function_exists( 'amp_shortcode_st_div' ) ) {
	function amp_shortcode_st_div( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'class'       => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$class_attr  = ( $class !== '' ) ? $class : ''; //class

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="'. $class_attr .'">' . $content . '</div>';
	}
}

if ( ! function_exists( 'amp_st_meta_thumbnail' ) ) {
	function amp_st_meta_thumbnail() {
		$st_ogp_url = trim( get_option( 'st-data264', '' ) ); // デフォルトのアイキャッチ画像設定
		if ( ( is_page() || is_single() ) && has_post_thumbnail() ) {
	  		echo '<meta name="thumbnail" content="'. wp_get_attachment_url( get_post_thumbnail_id() ) .'">'. "\n";	
		}elseif( $st_ogp_url ) {
	  		echo '<meta name="thumbnail" content="'. esc_attr( $st_ogp_url) .'">'. "\n";	
		}else {
		}
	}
}
add_action( 'amp_wp_head', 'amp_st_meta_thumbnail' );

if ( !function_exists( 'amp_shortcode_st_google_icon' ) ) {
	function amp_shortcode_st_google_icon( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'googleicon'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$googleicon_html = ( $googleicon !== '' ) ? '<i class="material-icons">'. esc_attr( $googleicon ) .'</i>' : ''; //Googleアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return $googleicon_html;
	}
}

if ( !function_exists( 'amp_shortcode_st_wide_background' ) ) {
	function amp_shortcode_st_wide_background( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'myclass'  => '',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス

		$content = (string) $content;
		$content = preg_replace( '!<p>(?:\s|&nbsp;)*</p>!', '', $content );
		$content = preg_replace( '!^</p>|<p>$!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<div class="'. esc_attr ( $myclass_class ) .'">' . $content . '</div>';
	}
}

if ( !function_exists( 'amp_shortcode_st_pre' ) ) {
	function amp_shortcode_st_pre( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'myclass'       => '',
			'text'    => '',
			'fontawesome' => 'fa-code',
		), $atts );

		extract( array_map( 'trim', $atts ), EXTR_SKIP );

		$myclass_class  = ( $myclass !== '' ) ? $myclass : ''; // オリジナルクラス
		$text_html   = ( $text !== '' ) ? $text : ''; //テキスト
		$fontawesome_html = ( $fontawesome !== '' ) ? '<i class="fa ' . esc_attr( $fontawesome ) . ' st-css-no" aria-hidden="true"></i> ' : '<i class="fa fa-code" aria-hidden="true"></i> '; //Webアイコン

		$content = (string) $content;
		$content = preg_replace( '!<p>!', '', $content );
		$content = preg_replace( '!</p>!', '', $content );
		$content = do_shortcode( shortcode_unautop( $content ) );

		return '<pre class="st-pre '. esc_attr( $myclass_class ) .'"><span class="st-pre-text">' . $fontawesome_html . $text_html . '</span>' . $content . '</pre>';

	}
}
