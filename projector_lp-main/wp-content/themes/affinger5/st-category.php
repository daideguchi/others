<?php
if ( ! function_exists( '_st_get_category_meta' ) ) {

	function _st_get_category_meta( $category ) {
		$category = get_category( $category );
		$defaults = array(
			'thumbnail_id'          => '',
			'thumbnail_under'       => '',
			'thumbnail_wide'        => '',
			'st_cattitle'           => '',
			'st_catmetakeyword'     => '',
			'st_catmetadescription' => '',
			'listdelete'            => '',
			'bgcolor'               => '',
			'snscat'                => '',
			'catindex'              => '',
		);

		if ( ! $category || is_wp_error( $category ) ) {
			return $defaults;
		}

		$meta = get_option( 'cat_' . $category->term_id, array() );
		$meta = array_merge( $defaults, $meta );

		return $meta;
	}
}

if ( ! function_exists( 'st_get_term_meta' ) ) {

	function st_get_term_meta( $term_id, $key = '' ) {
		$term   = get_term( $term_id );
		$is_all = ( $key === '' );

		if ( ! $term || is_wp_error( $term ) ) {
			return $is_all ? array() : '';
		}

		switch ( $term->taxonomy ) {
			case 'category':
			default:
				$meta  = _st_get_category_meta( $term );
				$value = $meta;

				if ( ! $is_all ) {
					$value = isset( $meta[ $key ] ) ? $meta[ $key ] : '';
				}
		}


		return $value;
	}
}

add_action ( 'edit_category_form_fields', 'extra_category_fields');
function extra_category_fields( $tag ) {
	$cat_meta       = st_get_term_meta( $tag->term_id );
	$editor_content = get_term_field( 'description', $tag );

	$editor_settings = array(
		'textarea_name' => 'description',
	);
    ?>

<tr class="form-field">
    <th><label for="st_description">説明</label></th>
    <td>
        <?php wp_editor( $editor_content, 'st-tag-description', $editor_settings ); ?>
        <p class="description"><?php _e( 'The description is not prominent by default; however, some themes may show it.' ); ?></p>
    </td>
</tr>

<tr class="form-field">
    <th>アイキャッチ画像を登録</th>
    <td>
        <?php st_media_preview( 'Cat_meta[thumbnail_id]', $cat_meta['thumbnail_id'] ); ?>
        <?php st_media_editor_button( 'Cat_meta[thumbnail_id]', 'アップロード', array( 'type' => 'id' ) ); ?>
        <?php st_media_reset_button( 'Cat_meta[thumbnail_id]', '削除' ); ?><br/>
        <input type="hidden" name="Cat_meta[thumbnail_id]" value="<?php echo esc_attr( $cat_meta['thumbnail_id'] ); ?>"/>
        <label style="display: inline-block; margin-top: .5em;">
            <input type="hidden" name="Cat_meta[thumbnail_under]" value="" />
            <input type="checkbox" name="Cat_meta[thumbnail_under]" value="yes"<?php checked( $cat_meta['thumbnail_under'] === 'yes' ); ?> /> タイトル下に表示
        </label><br/>
        <label style="display: inline-block; margin: .5em 0 0 1.5em;">
            <input type="hidden" name="Cat_meta[thumbnail_wide]" value="" />
            <input type="checkbox" name="Cat_meta[thumbnail_wide]" value="yes"<?php checked( $cat_meta['thumbnail_under'] === 'yes' && $cat_meta['thumbnail_wide'] === 'yes' ); ?><?php disabled( $cat_meta['thumbnail_under'] !== 'yes' ); ?> /> ワイド化する
        </label>
    </td>
</tr>

<tr class="form-field">
    <th><label for="st_cattitle">カテゴリータイトルの書き替え</label></th>
    <td><input type="text" name="Cat_meta[st_cattitle]" id="st_cattitle" size="25" value="<?php echo esc_attr($cat_meta['st_cattitle']) ?>" /><p class="description">※テーマ管理画面にて「WPデフォルトのタイトル出力を使用する」にチェックが入っているとtitleタグには反映されません</p></td>
</tr>

<tr class="form-field">
    <th><label for="st_catmetakeyword">カテゴリーのメタキーワード</label></th>
    <td><input type="text" name="Cat_meta[st_catmetakeyword]" id="st_catmetakeyword" size="25" value="<?php echo esc_attr($cat_meta['st_catmetakeyword']) ?>" /><p class="description">※複数指定する場合は半角カンマで区切ってください</p></td>
</tr>

<tr class="form-field">
    <th><label for="st_catmetadescription">カテゴリーのメタディスクリプション</label></th>
    <td><textarea id="st_catmetadescription" rows="4" name="Cat_meta[st_catmetadescription]"><?php echo esc_attr( $cat_meta['st_catmetadescription'] ); ?></textarea></td>
</tr>

<tr class="form-field">
	<th><label for="bgcolor">背景色</label></th>
	<td><input type="text" name="Cat_meta[bgcolor]" id="bgcolor" value="<?php echo esc_attr( $cat_meta['bgcolor'] ); ?>" pattern="^#[0-9A-Za-z]+$" size="7" maxlength="7" style="ime-mode: disabled;" data-wp-color-picker></td>
</tr>

<tr class="form-field">
    <th><label for="listdelete">投稿の一覧表示</label></th>
    <td><input type="radio" name="Cat_meta[listdelete]" id="listdelete" value=""<?php checked( $cat_meta['listdelete'] === ''); ?> /> する<br/>
<input type="radio" name="Cat_meta[listdelete]" id="listdelete" value="no"<?php checked( $cat_meta['listdelete'] === 'no' ); ?> /> しない
</td>
</tr>
<tr class="form-field">
    <th><label for="snscat">SNSボタンの表示</label></th>
    <td><input type="radio" name="Cat_meta[snscat]" id="snscat" value="yes"<?php checked( $cat_meta['snscat'] === 'yes'); ?> /> する<br/>
<input type="radio" name="Cat_meta[snscat]" id="snscat" value=""<?php checked( $cat_meta['snscat'] === '' ); ?> /> しない
</td>
</tr>
<?php
}

if ( ! function_exists( 'st_admin_enqueue_category_scripts' ) ) {
	function st_admin_enqueue_category_scripts( $hook_suffix ) {
		$taxonomy = (string) filter_input( INPUT_GET, 'taxonomy' );

		if ( $hook_suffix === 'term.php' && $taxonomy === 'category' ) {
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script(
				'st-color-picker',
				get_template_directory_uri() . '/js/st-color-picker.js',
				array( 'wp-color-picker' ),
				false,
				false
			);
		}
	}
}
add_action( 'admin_enqueue_scripts', 'st_admin_enqueue_category_scripts' );

if ( ! function_exists( '_st_generate_category_css' ) ) {

	function _st_generate_category_css() {
		$args = array(
			'hide_empty' => false,
			'fields'     => 'ids',
		);

		$css = '';

		foreach ( get_categories( $args ) as $category_id ) {
			$cat_meta = get_option( "cat_{$category_id}" );

			if ( isset( $cat_meta['bgcolor'] ) && trim( $cat_meta['bgcolor'] ) !== '' ) {
				$css .= <<<CSS
.catname.st-catid{$category_id} {
	background-color: {$cat_meta['bgcolor']};
}
CSS;
			}
		}

		return $css;
	}
}

add_action ( 'edited_term', 'save_extra_category_fileds');
function save_extra_category_fileds( $term_id ) {
	if ( isset( $_POST['Cat_meta'] ) ) {
		$t_id     = $term_id;
		$cat_meta = get_option( "cat_$t_id" );
		$cat_keys = array_keys( $_POST['Cat_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( ! isset( $_POST['Cat_meta'][ $key ] ) ) {
				continue;
			}

			switch ( true ) {
				case ( $key === 'bgcolor' ):
					$cat_meta[ $key ] = sanitize_hex_color( $_POST['Cat_meta'][ $key ] );

					break;

				case ( $key === 'thumbnail_wide' ):
					$cat_meta[ $key ] = (bool) $_POST['Cat_meta']['thumbnail_under'] ? $_POST['Cat_meta'][ $key ] : '';

					break;

				default:
					$cat_meta[ $key ] = $_POST['Cat_meta'][ $key ];

					break;
			}
		}
		update_option( "cat_$t_id", $cat_meta );
	}
}

function st_catmeta_source() {
	if ( !is_category() ) {
		return;
	}

	$current_cat_id = get_query_var( 'cat' );
	$cat_data         = get_option( 'cat_' . $current_cat_id, array() );
	$cat_keyword      = isset( $cat_data['st_catmetakeyword'] ) ? trim( $cat_data['st_catmetakeyword'] ) : '';
	$cat_description  = isset( $cat_data['st_catmetadescription'] ) ? trim( $cat_data['st_catmetadescription'] ) : '';

	if ( $cat_keyword !== '' ) {
		echo '<meta name="keywords" content="' . esc_attr( $cat_keyword ) . '">' . "\n";
	}

	if ( $cat_description !== '' ) {
		echo '<meta name="description" content="' . esc_attr( $cat_description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'st_catmeta_source' );

if ( ! function_exists( 'st_admin_category_add_form_fields' ) ) {
	function st_admin_category_add_form_fields( $taxonomy ) {
		$editor_content = get_term_field( 'description', $taxonomy );

		$editor_settings = array(
			'textarea_name' => 'description',
		);

		?>

		<div class="form-field st-term-description-wrap">
			<label for="tag-description"><?php _e( 'Description' ); ?></label>
			<?php wp_editor( $editor_content, 'st-tag-description', $editor_settings ); ?>
			<p><?php _e( 'The description is not prominent by default; however, some themes may show it.' ); ?></p>
		</div>

		<?php
	}
}
add_action( 'category_add_form_fields', 'st_admin_category_add_form_fields' );

if ( ! function_exists( 'st_admin_print_category_styles' ) ) {
	function st_admin_print_category_styles() {
		$taxonomy = (string) filter_input( INPUT_GET, 'taxonomy' );

		if ( $taxonomy !== 'category' ) {
			return;
		}

		echo <<<HTML
<style>
.form-wrap .form-field.term-description-wrap,
.form-table .form-field.term-description-wrap
{
	display: none;
}

.wp-editor-area {
	border: 0 !important;
}
</style>
HTML;
	}
}
add_action( 'admin_print_styles-edit-tags.php', 'st_admin_print_category_styles' );
add_action( 'admin_print_styles-term.php', 'st_admin_print_category_styles' );

if (!function_exists('st_admin_print_category_scripts')) {
	function st_admin_print_category_scripts() {
		$taxonomy = (string) filter_input( INPUT_GET, 'taxonomy' );

		if ( $taxonomy !== 'category' ) {
			return;
		}

		echo <<<HTML
<script>
;(function (window, document, $, undefined) {
	'use strict';

	$(function () {
		$('.form-wrap .form-field.term-description-wrap, .form-table .form-field.term-description-wrap').remove();

		$('#submit').on('click', function (event) {
			if (typeof tinyMCE === 'undefined') {
				return;
			}

			var editor = tinyMCE.get('st-tag-description');

			if (!editor) {
				return;
			}

			$('#st-tag-description').text(editor.getContent({format: 'raw'}));

			tinyMCE.triggerSave();
		});

		$(document).ajaxComplete(function (event, xhr, settings) {
			if (!settings.data.match(/(^|&)action=add-tag($|&)/)) {
				return;
			}

			var editor = tinyMCE.get('st-tag-description');

			if (!editor) {
				return;
			}

			editor.setContent('');
		});
	});
}(window, window.document, jQuery));
</script>
HTML;
	}
}
add_action( 'admin_print_footer_scripts-edit-tags.php', 'st_admin_print_category_scripts' );
add_action( 'admin_print_footer_scripts-term.php', 'st_admin_print_category_scripts' );

if ( ! function_exists( 'st_get_term_thumbnail' ) ) {

	function st_get_the_term_thumbnail( $term_id = null, $size = 'post-thumbnail', array $attr = array() ) {
		if ( $term_id === null ) {
			$term_id = ( is_category() || is_tag() || is_tax() ) ? get_queried_object_id() : null;
		}

		$attachment_id = (int) st_get_term_meta( $term_id, 'thumbnail_id' );

		return wp_get_attachment_image( $attachment_id, $size, false, $attr );
	}
}

if ( ! function_exists( 'st_the_term_thumbnail' ) ) {

	function st_the_term_thumbnail( $size = 'post-thumbnail', array $attr = array() ) {
		echo st_get_the_term_thumbnail( null, $size, $attr );
	}
}

if ( ! function_exists( 'st_has_term_thumbnail' ) ) {

	function st_has_term_thumbnail( $term_id = null ) {
		return ( st_get_the_term_thumbnail( $term_id ) !== '' );
	}
}
