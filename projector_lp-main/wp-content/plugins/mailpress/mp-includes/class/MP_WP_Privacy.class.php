<?php
class MP_WP_Privacy
{
	function __construct()
	{
		new MP_WP_Privacy_exporters();
		new MP_WP_Privacy_erasers();
	}
}