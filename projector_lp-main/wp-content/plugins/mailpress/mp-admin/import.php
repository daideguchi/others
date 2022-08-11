<?php
class MP_AdminPage extends MP_WP_Admin_page_list_
{
	const screen 		= MailPress_page_import;
	const capability 	= 'MailPress_import';
	const help_url		= 'http://blog.mailpress.org/tutorials/add-ons/import/';
	const file        	= __FILE__;

	const per_page 		= false;

////  Title  ////

	public static function title() 
	{
		new MP_Import_importers();
	}

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$content = '';
		$content .= '<p><strong>' . __( 'Import :', 'MailPress' ) . '</strong></p>';
		$content .= '<p>' . __( 'This screen lists a serie of importers/exporters to import/export data into/out of MailPress. ', 'MailPress' ) . '</p>';

		$current_screen->add_help_tab( array( 	'id'        => 'overview',
										'title'        => __( 'Overview' ),
										'content'    => $content )
		);
	}

//// List ////

	public static function get_list( $args = array() ) 
	{
		$importers = MP_Import_importers::get_all();

		return ( empty( $importers ) ) ? false : $importers;
	}

////  Row  ////

	public static function get_row( $id, $data ) 
	{

// url's
		$url_parms = array();
		$url_parms['mp_import'] 	= $id;
		$import_url = esc_url( self::url( MailPress_import, $url_parms ) );
// actions
		$actions = array();
		$actions['import'] = '<a href="' . $import_url . '" title="' . esc_attr( wptexturize( strip_tags( $data[1] ) ) ) . '">' . ( ( strpos( $id, 'export' ) !== false ) ?  __( 'Export', 'MailPress' ) : __( 'Import', 'MailPress' ) ) . '</a>';

		$out = '';
		$out .= '<tr class="importer-item">';
		$out .= '<td class="importer-system">';
		$out .= '<span class="importer-title">' . ucfirst( $data[0] ) . '</span>';
		$out .= '<span class="importer-action">' . $actions['import'] . '</span>';
		$out .= '</td>';
		$out .= '<td class="desc">' . $data[1] . '</td>';
		$out .= '</tr>';

		return $out;
	}
}