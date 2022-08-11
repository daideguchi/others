<?php
class MP_WP_Admin_Menu
{
	function __construct()
	{
		$menus = array();

		foreach ( MailPress::capabilities() as $capability => $datas )
		{
			if ( isset( $datas['menu'] ) && $datas['menu'] && current_user_can( $capability ) )
			{
				$datas['capability'] 	= $capability;
				$menus[]			= $datas;
			}
		}
		if ( empty( $menus ) ) return;

		uasort( $menus, array( 'self', 'sort_menus' ) );

		$first = true;
		foreach ( $menus as $menu )
		{
			if ( !$menu['parent'] )
			{
				if ( $first )
				{
					$toplevel = $menu['page'];
					add_menu_page( '', __( 'Mails', 'MailPress' ), $menu['capability'], $menu['page'], $menu['func'], 'dashicons-admin-mailpress' );
				}
				$first = false;
			}

			$parent = ( $menu['parent'] ) ? $menu['parent'] : $toplevel;
			add_submenu_page( $parent, $menu['page_title'], $menu['menu_title'], $menu['capability'], $menu['page'], $menu['func'] );

			if ( $menu['page'] == MailPress_page_mails )
			{
				add_submenu_page( $toplevel, __( 'Add New Mail', 'MailPress' ), '&#160;' . __( 'Add New' ), 'MailPress_edit_mails', MailPress_page_write, array( 'MP_AdminPage', 'body' ) );
			}
		}
	}

	public static function sort_menus( $a, $b ) 
	{
		return strcmp( $a['menu'], $b['menu'] );
	}
}