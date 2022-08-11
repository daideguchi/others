/**
 * Fixed Bottom Menu Admin
 *
 * @package    Fixed Bottom Menu Admin
 * @subpackage jquery.fixedbottommenu.admin.js
/*  Copyright (c) 2019- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

jQuery(
	function($){

		/* Range */
		$( '#font_size_range' ).html( $( '#font_size_bar' ).val() );
		$( '#font_size_bar' ).on(
			'input change',
			function() {
				$( '#font_size_range' ).html( $( this ).val() );
			}
		);
		$( '#height_bar_range' ).html( $( '#height_bar' ).val() );
		$( '#height_bar' ).on(
			'input change',
			function() {
				$( '#height_bar_range' ).html( $( this ).val() );
			}
		);
		$( '#line_hieght_range' ).html( $( '#line_hieght_bar' ).val() );
		$( '#line_hieght_bar' ).on(
			'input change',
			function() {
				$( '#line_hieght_range' ).html( $( this ).val() );
			}
		);
		$( '#padding_top_range' ).html( $( '#padding_top_bar' ).val() );
		$( '#padding_top_bar' ).on(
			'input change',
			function() {
				$( '#padding_top_range' ).html( $( this ).val() );
			}
		);
		$( '#zindex_range' ).html( $( '#zindex_bar' ).val() );
		$( '#zindex_bar' ).on(
			'input change',
			function() {
				$( '#zindex_range' ).html( $( this ).val() );
			}
		);

		/* Control of the Enter key */
		$( 'input[type!="submit"][type!="button"]' ).keypress(
			function(e){
				if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
					return false;
				} else {
					return true;
				}
			}
		);

	}
);
