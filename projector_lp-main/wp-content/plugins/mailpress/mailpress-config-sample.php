<?php
/**
 * Optional config file to 
	** rename mp-content folder :
		*** rename mp-content folder to the new folder name ( e.g. : mailpress-content )
		*** create mailpress-config.php file from this file inside mailpress folder, rename "mp-content" ( e.g. : replace 'mp-content' by 'mailpress-content' ).
		*** check under Wp Admin : Mails > Themes, that themes are located with the right path.
	** place mp-content folder outside mailpress folder
		*** copy mp-content folder in the mailpress parent directory with a new folder name ( e.g. : mailpress-content )
		*** create mailpress-config.php file from this file inside mailpress parent directory, rename "mp-content" ( e.g. : replace 'mp-content' by 'mailpress-content' ).
		*** check under Wp Admin : Mails > Themes, that themes are located with the right path.

 	** define use of wp_enqueue_script for mailpress subscription form >> requires : wp_print_scripts(); in your wordpress theme footer !! .

 	** define log for debug purpose only, uncomment appropriate line.
*/

// 0.

//define ( 'MP_Ip_ipinfodb_ApiKey', 	'<- get your api key here : http://www.ipinfodb.com/register.php ->' );

// 1.

/** Folder name of MailPress 'mp-content'. */
//define ( 'MP_CONTENT_FOLDER', 	'mp-content' );

// 2.

/** Since MailPress 6.0, MP_wp_enqueue_script is set to true if not defined */
/** if your WordPress theme has a wp_footer in it's footer.php, you donot need to uncomment the following line */
//define ( 'MP_wp_enqueue_script', false );

// 3.

/** MailPress dev log ( uncomment if necessary ) */
//define ( 'MP_DEBUG_LOG', true );





/* That's all, stop editing! Check right path under Mails > Themes and Happy mailing. */

if ( defined( 'MP_CONTENT_FOLDER' ) )
{
	/** Absolute path to the MailPress 'mp-content' folder. */
	define ( 'MP_CONTENT_DIR', 	__DIR__ . '/' . MP_CONTENT_FOLDER . '/' );

	/** Relative path to the MailPress 'mp-content' folder. */
	if ( MP_FOLDER != basename( __DIR__ ) )
		define ( 'MP_PATH_CONTENT', 	dirname( MP_PATH ) . '/' 	. MP_CONTENT_FOLDER . '/' );
}