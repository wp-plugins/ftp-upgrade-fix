=== FTP Upgrade Fix ===
Contributors: aldenta
Tags: update, upgrade, ftp, pureftp, pure-ftpd
Requires at least: 2.5
Tested up to: 3.1
Stable tag: 1.0
License: GPLv2 or later

Fixes problems that prevent installing or updating WordPress, themes, and plugins on some FTP server configurations (typically Pure-FTPd).

== Description ==

Some server configurations running Pure-FTPd have trouble updating WordPress via FTP. Common error messages when trying to update WordPress or update/install a plugin look like this:

* Could not copy file.: /wp-admin/css/theme-editor.dev.css
* Could not copy file.: /public_html/wp-admin/css/theme-editor.dev.css
* Could not copy file.: /.../.../wp-admin/css/theme-editor.dev.css 
* Could not create file.: /public_html/

Each of these cases seem to be related. There is a patch going into WordPress 3.2 that should take care of the issues and the plugin will be obsolete after updating to that version (http://core.trac.wordpress.org/ticket/10913). In the meantime, install and activate this plugin. Updates should work as expected.

== Installation ==

Upload the FTP Upgrade Fix plugin to your blog via FTP and Activate it.

== Changelog ==

= 1.0 =

* Initial release