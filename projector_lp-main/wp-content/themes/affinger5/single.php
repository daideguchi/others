<?php
if ((trim($GLOBALS['stdata74']) !== '') && ( in_category($GLOBALS['stdata74']) )) {
	include(TEMPLATEPATH . '/single-type2.php');
} else {
	include(TEMPLATEPATH . '/single-type1.php');
}
