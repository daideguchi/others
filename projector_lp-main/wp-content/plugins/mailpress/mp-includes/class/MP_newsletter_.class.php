<?php
abstract class MP_newsletter_
{
	function __construct( $desc )
	{
		$this->desc = $desc;

		$this->time = time();

		$this->date   = wp_date( 'Y-m-d H:i:s', $this->time );
		$this->year   = (int) substr( $this->date, 0, 4 );
		$this->month  = (int) substr( $this->date, 5, 2 );
		$this->day    = (int) substr( $this->date, 8, 2 );
		$this->hour   = (int) substr( $this->date, 11, 2 );
		$this->minute = (int) substr( $this->date, 14, 2 );
		$this->second = (int) substr( $this->date, 17, 2 );

		$this->wday  = ( int ) wp_date( 'w', $this->time );

		add_filter( "MailPress_newsletter_{$this->args}s_register",	array( $this, 'register' ), 8, 1 );
	}

	function register( $x ) { $x[$this->id] = $this->desc; return $x; }

	function get_day( $y, $m ) 
	{
		$d = ( int ) $this->newsletter[$this->args]['args']['day'] ?? 1;

		$max_day = $this->get_last_day( $y, $m );

		return ( !is_numeric( $d ) ) ? 1 : ( ( $d <= 0 || $d > $max_day ) ? $max_day : $d );
	}

	function get_last_day( $y, $m ) 
	{
		$maxd = array( 31,( !( $y%4 )&&( $y%100||!( $y%400 ) ) )?29:28,31,30,31,30,31,31,30,31,30,31 ); 
		return $maxd[$m - 1];
	}

	function get_wday() 
	{
		$w = ( isset( $this->newsletter[$this->args]['args']['wday'] ) && is_numeric( $this->newsletter[$this->args]['args']['wday'] ) ) ? $this->newsletter[$this->args]['args']['wday'] : get_option( 'start_of_week' );
		if ( $w === false ) 	$w = 1;
		if ( $w == 7 ) 		$w = 0;
		return ( !is_numeric( $w ) || $w < 0 || $w > 6 ) ? 1 : $w;
	}

	function get_hour() 
	{
		$h = ( int ) $this->newsletter[$this->args]['args']['hour'] ?? 0;
		return ( !is_numeric( $h ) || $h < 0 || $h > 23 ) ? 0 : $h;
	}

	function get_minute() 
	{
		$i = ( int ) $this->newsletter[$this->args]['args']['minute'] ?? 0;
		return ( !is_numeric( $i ) || $i < 0 || $i > 59 ) ? 0 : $i;
	}

	function mktime( $h, $i, $s, $m, $d, $y )
	{
		return gmmktime( $h, $i, $s, $m, $d, $y ) - get_option( 'gmt_offset' ) * 3600;
	}


	function format_timestamp( $y, $m, $d, $h, $i, $s = false ) 
	{
		if ( !$s ) $s = 0;
		return $this->format_date( $y, $m, $d ) . ' ' . $this->format_hour( $h, $i, $s );
	}

	function format_date( $y, $m, $d ) 
	{
		return zeroise( $y, 4 ) . '-' . zeroise( $m, 2 ) . '-' . zeroise( $d, 2 );
	}

	function format_hour( $h, $i, $s = false ) 
	{
		$hh = zeroise( $h, 2 ) . ':' . zeroise( $i, 2 );
		if ( $s !== false ) $hh .= ':' . zeroise( $s, 2 );
		return $hh;
	}

	function get_slots( $s = NULL ) 
	{
		$s = $s ?? $this->newsletter['slots'] ?? 1;
		return (int) ( !( 24%$s ) ) ? $s : 1;
	}

	function get_slot_context( $s = NULL )
	{
		$h = $this->get_hour();
		$i = $this->get_minute();

		$s = $this->get_slots( $s );

		/* "map" the slots */

		$this->slot_in_hour = 24 / $s;
		$this->slot_in_sec  = DAY_IN_SECONDS / $s;

		$this->slots = array();
		for( $z = 0; $z <= $s; $z++ )
		{
			$x = $h + ( $z * $this->slot_in_hour );
			if ( $x >= 24 ) $x -= 24;
			$this->slots[$z] = $this->slots[$z - $s] = $this->format_hour( $x, $i, 0 );
		}
		ksort( $this->slots );

		/* in which slot are we ? */

		$diff = ( ( $this->hour - $h ) * HOUR_IN_SECONDS ) + ( ( $this->minute - $i ) * MINUTE_IN_SECONDS ) + $this->second;

		$this->slot_overnight = ( $diff < 0 );

		if ( $this->slot_overnight ) $diff += DAY_IN_SECONDS;

		$this->slot = 0;
		while ( $diff >= $this->slot_in_sec )
		{
			$this->slot++;
			$diff -= $this->slot_in_sec;
		}

		$this->slot_overnight = ( $this->slot_overnight && ( $this->slots[$this->slot] != '00:00:00' ) );
	}
}