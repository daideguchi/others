=== xtras files ===

* category-xx (to manage subscriptions)
	- create a category 'For Mails' and remember its id (tag_ID=nn in admin url) => wp-admin/edit-tags.php?taxonomy=category ... &tag_ID=nn ...
	- rename file category-xx in category-nn (prefix 'category-' is mandatory for WordPress)
	- copy file category-nn in the current WordPress theme folder
	- in Settings > MailPress > General > On Blog section > Manage subscriptions from, choose Category template and enter nn in Category id

* pt_MailPress (to manage subscriptions)
	- copy this file in the current WordPress theme folder
	- create a new page => /wp-admin/post-new.php?post_type=page
	- in Page Attributes select 'MailPress'
	- save page and remember its id (... post=nn ... in admin url)
	- in Settings > MailPress > General > On Blog section > Manage subscriptions from, choose Page template and enter nn in Page id




* pt_MP_Archives (to manage mail archives)
	- copy this file in the current WordPress theme folder
	- create a new page => /wp-admin/post-new.php?post_type=page
	- in Page Attributes select 'MailPress Archives'

* mp_tracking_rewrite_url.htaccess (when using add-on Tracking_rewrite_url)
	sample file to show modifications to set in your .htaccess file 

