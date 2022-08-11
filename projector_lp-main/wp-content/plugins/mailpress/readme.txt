=== MailPress ===
Contributors: arena
Donate link: https://www.paypal.me/arenaut
Tags: mail, mails, comments, comment, subscribe, newsletters, newsletter, Wordpress, Plugin, swiftmailer, post, posts, smtp, sendmail, notification, notifications, mailing, mailings
Requires at least: 5.4
Tested up to: 5.4
Stable tag: 7.2.1
Requires PHP: 7.0
License: WTFPL license

The WordPress mailing platform 

== Description ==

1. Style your html and plain text mails with dedicated themes and templates.
2. Newsletters/Post notifications on a per post, daily (even intraday...), weekly, monthly basis.
3. Subscriptions to Comments, Newsletters/Post notifications and even to Mailing lists.
4. Support international emails
5. Support Dkim or S/Mime
6. and much more, for free !

== Installation ==

1. Before any installation, make sure you have a smtp server available (supports smtp (default) or sendmail).
2. Have all informations to access to this server at hand.
3. The installation process is like any other plugin.
4. Once activated, go to "Settings > MailPress", fill and save the settings for each tab (General, (Connection to your mail server), Test, ...
5. Once everything is set, use the Test tab in "Settings > MailPress" to validate your settings (your first mail with MailPress)
6. You can also install the MailPress widget on your front page : "Appearance > Widgets".
7. Just browse the different MailPress admin screens, read the help in the help tab for each screen.
8. Now that you are familiar with this plugin, you can visit "Plugins > MailPress Add-ons" to add options to your plugin (may be you already did it to activate sendmail).
9. I wisely recommand to activate add-ons one by one, and see what are the changes in the MailPress settings admin panel, in the help, etc ...

== Upgrade Notice == 

WordPress automatic upgrade is a delete and replace process !

1. Deactivate all MailPress Add-ons
2. Save or Back-up any customized file (if any)
3. Deactivate the plugin
4. Upgrade
5. Restore any customized files (if any)
6. Activate plugin and add-ons

== Technical Details ==

1. MailPress sends one mail for each recipient, so before sending thousands of mails in one pass, make sure your webserver and mailserver can afford it !
(see also Batch_send add-on)
2. Requires php7
3. php function proc_open must be available
4. php extensions simplexml and intl must be available

== Frequently Asked Questions == 

see the mailpress google group http://groups.google.com/group/mailpress

== Screenshots ==

n/a

== Privacy ==

This plugin is using the following external softwares :
1. Swiftmailer "Free Feature-rich PHP Mailer" (https://swiftmailer.symfony.com/)
** doctrine/lexer "Base library for a lexer" (https://github.com/doctrine/lexer)
** egulias/EmailValidator "PHP Email validator" (https://github.com/egulias/EmailValidator)
2. [Import Addon] Excel parsing library (http://code.google.com/p/php-excel-reader/) modified for php7 compatibility
3. [Import Addon] CSV parsing library   (https://github.com/parsecsv/parsecsv-for-php)  modified for php7 compatibility

This plugin is using - depending on your settings - the following external services & softwares
1. [Maps] Bing maps (https://www.microsoft.com/en-us/maps) (javascript and REST api)
2. [Maps] Google maps (https://cloud.google.com/maps-platform/?hl=en) (javascript and REST api) 
3. [Maps] Here maps (https://www.here.com/) (javascript and REST api) 
4. [Maps] Mapbox GL JS (https://docs.mapbox.com/mapbox-gl-js/api/) (javascript and REST api) 
5. [Maps] OpenStreetMaps and Leaflet (https://www.openstreetmap.org & https://leafletjs.com/) (javascript and REST api) 

This plugin is using - randomly - the following external services (ip adress transmitted)
1. [Ip Geocoding] https://extreme-ip-lookup.com/ (REST Api)
2. [Ip Geocoding] http://www.geoplugin.net/ (REST Api) 
3. [Ip Geocoding] https://ipapi.co (REST Api) 
4. [Ip Geocoding] http://ip-api.com/ (REST Api) 
5. [Ip Geocoding] http://ipinfo.io/ (REST Api) 
6. [Ip Geocoding] https://ipstack.com/ (REST Api) 

This plugin is storing data
1. [core] Subscribers
2. [core] Mails and recipients informations
3. [Comment addon] Subscriptions
4. [Mailinglist addon] Subscriptions
5. [Newsletter addon] Subscriptions
6. [Tracking addon] any activity on sent mails when clicking on mail links

This plugin authorize data export in csv format [Import addon]

This plugin is compliant with WordPress Export/Erase Personnal Data process (Privacy)

== Changelog ==

= 7.2.1 = 2020/06/02

* fixing bugs on weekly and monthly newsletter schedulers & processors
* preparing php7.3 

= 7.2 = 2020/05/25

* complete review of mail pluggable functions (wp_mail included + bug fixed)
* adding a List-Unsubscribe add-on trying to comply with rfc2369, rfc8058 & friends
* Newsletter schedulers & processors reviewed, use of wp_date()
* settings reviewed to comply with wp settings look and feel
* logging reviewed
* Swiftmailer 6.3.0 (with specific smtputf8 encoding support)
* Bugs fixed
** bug in csv and excel importers (when mailinglist not active)
** fixing bug in form field type
** fixing minor bug in bounce management
** several cosmetic changes (mainly code comments and css)

= 7.1 = 2019/05/13

* Compliant with WordPress Export/Erase Personnal Data process (Privacy)
* Bing & Here map api's integrated
* new Geo Ip providers : extreme-ip-lookup, ipstack
* new addon "Privacy" to post privacy data requests via mail
* Dashicon-ification of admin & map icons
* better bot detection on Tracking
* better spam detection on subscription form
* Bugs fixed
* metaboxes Draft/Test (admin write post) & Posts (admin write mail)
* autosave (admin write mail)
* tracking : capturing more urls
* dashboard comment widget : fixing data type for a variable
* message displayed correctly when submitting forms from Form addon
* geoplugin, ip-api, ipapi reviewed (Geo Ip)
* cleanup in stats table when (re)activating the plugin
* Mapbox v0.53.1

= 7.0.2 = 2019/02/06

* Fixing specific issue for some webhosts on creating some mysql meta tables
* Fixing bug on addon Tracking_rewrite_url
* maps

= 7.0.1 = 2019/01/27

* Fixing minor bugs
* MailPress back in the WordPress repository !!!

= 7.0 = 2019/01/23

* Swiftmailer 6.1.3 
** php 7 required
** PHP Mail deprecated (for security reasons), use SMTP or Sendmail
** Dkim & S/Mime support
** SMTPUTF8 support for international emails (your SMTP server MUST support SMTPUTF8)
