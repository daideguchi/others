<?php
class MP_Mailinglists_Walker_Array extends Walker 
{
	var $tree_type = MailPress_mailinglist::taxonomy;
	var $db_fields = array ( 'parent' => 'parent', 'id' => 'term_id' ); //TODO: decouple this
	
	public function start_el( &$output, $mailinglist, $depth = 0, $args = array(), $current_object_id = 0 ) 
	{
	if ( !empty( $output ) ) $t = unserialize( $output );

		$pad = str_repeat( '&#160;', $depth * 3 );
		$x = 'MailPress_mailinglist~' . $mailinglist->term_id;
		$t[$x] = $pad . $mailinglist->name;

		$output = serialize( $t );
	}
}