<?php
class MP_Mail_revision
{
	const meta_key     	= '_MailPress_mail_revisions';

	public static function has( $id ) 
	{
		return MP_Mail_meta::has( $id,  self::meta_key );
	}

	public static function get( $id ) 
	{
		return MP_Mail_meta::get( $id, self::meta_key );
	}

	public static function get_all( $id, $o = 'DESC' ) 
	{
		global $wpdb;
		$revisions = array();
		$mails[] = ( int ) $id;

		$o = ( $o == 'DESC' ) ? $o : 'ASC';

		$rev_ids = self::get( $id );
		foreach( $rev_ids as $rev_id ) { $mails[] = ( int ) $rev_id; }
		$ms = $wpdb->get_results( sprintf( "SELECT * FROM $wpdb->mp_mails WHERE id IN ( %s ) ORDER BY created %s;", implode( ', ', $mails ), $o ) );
		foreach ( $ms as $m ) { $revisions[$m->id] = $m; }
                
		return $revisions;
	}

	public static function get_ui_diff( $id, $compare_from, $compare_to ) 
        {
		if ( !$mail = MP_Mail::get( $id ) )
			return false;

		if ( $compare_from ) {
			if ( ! $compare_from = MP_Mail::get( $compare_from ) )
				return false;
		} else {
			// If we're dealing with the first revision...
			$compare_from = false;
		}

		if ( ! $compare_to = MP_Mail::get( $compare_to ) )
			return false;

		// Add default title if title field is empty
		if ( $compare_from && empty( $compare_from->subject ) )
			$compare_from->subject = __( '(no subject)', 'MailPress' );
		if ( empty( $compare_to->subject ) )
			$compare_to->subject = __( '(no subject)', 'MailPress' );

		$return = array();

		foreach ( self::autosave_data() as $field => $name ) {

			$content_from = $compare_from ? apply_filters( "_mp_mail_revision_field_{$field}", $compare_from->$field, $field, $compare_from, 'from' ) : '';
	
			/** This filter is documented in wp-admin/includes/revision.php */
			$content_to = apply_filters( "_mp_mail_revision_field_{$field}", $compare_to->$field, $field, $compare_to, 'to' );
	
			$args = array( 
				'show_split_view' => true
			 );
	
			$args = apply_filters( 'revision_text_diff_options', $args, $field, $compare_from, $compare_to );
	
			$diff = wp_text_diff( $content_from, $content_to, $args );

			if ( ! $diff && 'subject' === $field ) {
				// It's a better user experience to still show the Subject, even if it didn't change.
				// No, you didn't see this.
				$diff = '<table class="diff"><colgroup><col class="content diffsplit left"><col class="content diffsplit middle"><col class="content diffsplit right"></colgroup><tbody><tr>';
				$diff .= '<td>' . esc_html( $compare_from->subject ) . '</td><td></td><td>' . esc_html( $compare_to->subject ) . '</td>';
				$diff .= '</tr></tbody>';
				$diff .= '</table>';
			}

			if ( $diff ) {
				$return[] = array( 
					'id' => $field,
					'name' => $name,
					'diff' => $diff,
				 );
			}
		}
		return apply_filters( 'mp_get_revision_ui_diff', $return, $compare_from, $compare_to );
	}

	public static function update( $id, $rev_id, $wp_user_id ) 
	{
		$rev_ids = self::get( $id );

		$revs = ( is_array( $rev_ids ) ) ? $rev_ids : array();
		$revs[$wp_user_id] = $rev_id;

		if ( !MP_Mail_meta::add(    $id,  self::meta_key, $revs, true ) )
			MP_Mail_meta::update( $id,  self::meta_key, $revs );
	}

	public static function delete( $id ) 
	{
		$rev_ids = self::get( $id );

		if ( !$rev_ids ) return;

		global $wpdb;
		foreach( $rev_ids as $rev_id )
		{	
			$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->mp_mails WHERE id = %d ; ", $rev_id ) );
		}
	}

	public static function restore( $mail, $revision ) 
	{
		global $wpdb;

		$fields = array_keys( self::autosave_data() );
		$types  = array( 'mail' => $revision->id, 'revision' => $mail->id );

		foreach ( $types as $type => $id )
		{
                    	$data = $format = $where = $where_format = array();

			foreach ( $fields as $field ) 
			{
                                $data[$field] = ${$type}->{$field}; 				$format[] = '%s';
			}

			$where['id'] 		= $id;						$where_format[] = '%d';
 
			$wpdb->update( $wpdb->mp_mails, $data, $where, $format, $where_format );
                }
	}

	public static function autosave_data()
	{
		$autosave_data['fromemail']= __( 'From', 'MailPress' ); 
		$autosave_data['fromname'] = __( 'Name (from)', 'MailPress' ); 
		$autosave_data['toemail'] 	= __( 'To', 'MailPress' ); 
		$autosave_data['toname'] 	= __( 'Name (to)', 'MailPress' ); 
		$autosave_data['theme']	= __( 'Theme', 'MailPress' );
		$autosave_data['subject'] 	= __( 'Subject', 'MailPress' ); 
		$autosave_data['html'] 	= __( 'Html' );
		$autosave_data['plaintext']= __( 'Plain Text', 'MailPress' );
		return $autosave_data;
	}

	public static function title( $revision, $link = true ) 
	{

		$author = get_the_author_meta( 'display_name', $revision->created_user_id );
		$datef = _x( 'F j, Y @ H:i:s', 'revision date format' );

		$gravatar = get_avatar( $revision->created_user_id, 24 );

		$date = date_i18n( $datef, strtotime( $revision->created ) );
		if ( $link ) $date = '<a href="' . esc_url( $link ) . '">' . $date . '</a>';

		$revision_date_author = sprintf( 
			__( '%1$s %2$s, %3$s ago (%4$s)' ),
			$gravatar,
			$author,
			human_time_diff( strtotime( $revision->created ), current_time( 'timestamp' ) ),
			$date
		 );

		/* translators: %s: revision date with author avatar */
		$autosavef = __( '%s [Autosave]' );
		/* translators: %s: revision date with author avatar */
		$currentf  = __( '%s [Current Revision]' );
                
		if ( '' == $revision->status ) 	$revision_date_author = sprintf( $autosavef, $revision_date_author );
		else						$revision_date_author = sprintf( $currentf, $revision_date_author );

		return $revision_date_author;
	}

	public static function listing( $id = 0, $type = 'all' ) 
	{
		$revisions = self::get_all( $id );
		$mail      = $revisions[$id];
		unset( $revisions[$id] );

		$rows = '';

		foreach ( $revisions as $revision ) 
		{
			$link = ( '' == $revision->status ) ? add_query_arg( array( 'id' => $mail->id, 'revision' => $revision->id ), MailPress_revision ) : add_query_arg( 'id', $mail->id, MailPress_write );

			$rows .= "\t" . '<li>' . self::title( $revision, $link ) . '</li>' . "\n";
		}
	
		echo '<div class="hide-if-js"><p>' . __( 'JavaScript must be enabled to use this feature.' ) . '</p></div>' . "\n";

		echo '<ul class="mail-revisions hide-if-no-js">' . "\n";
		echo $rows;
		echo '</ul>';
	}
}